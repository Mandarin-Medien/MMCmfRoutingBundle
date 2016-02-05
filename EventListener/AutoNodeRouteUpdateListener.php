<?php

namespace MandarinMedien\MMCmfRoutingBundle\EventListener;


use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PostFlushEventArgs;
use MandarinMedien\MMCmfNodeBundle\Entity\Node;
use MandarinMedien\MMCmfRoutingBundle\Entity\NodeRouteManager;
use Doctrine\ORM\Event\OnFlushEventArgs;
use MandarinMedien\MMCmfRoutingBundle\Routing\NodeRouteLoader;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\DependencyInjection\Container;


/**
 * Class NodeRouteUpdater
 *
 * handles the creation and updates of Node related NodeRoute Entites
 *
 * @package MandarinMedien\MMCmfRoutingBundle\EventListener
 */
class AutoNodeRouteUpdateListener
{

    private $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * prePersist Event
     * whenever a new Node is created, also create automatically a new NodeRoute
     *
     * @param LifecycleEventArgs $args
     */
    public function prePersist(LifecycleEventArgs $args)
    {

        // update child routes
        $entity = $args->getEntity();

        if (    $entity instanceof Node
            &&  $entity->isRouteGeneration()
        ) {
            $routeManager = new NodeRouteManager();
            $entity->addRoute($routeManager->generateAutoNodeRoute($entity));
        }

        return;
    }


    /**
     * onFlush Event for persisting all NodeRoutes that needs an update
     *
     * @param OnFlushEventArgs $args
     */
    public function onFlush(OnFlushEventArgs $args)
    {

        $unit = $args->getEntityManager()->getUnitOfWork();
        $routeManager = new NodeRouteManager();

        foreach($unit->getScheduledEntityUpdates() as $entity) {

            if(     $entity instanceof Node
                &&  $entity->isRouteGeneration()
            ) {

                // check if Node::name has changed
                $changed = $unit->getEntityChangeSet($entity);

                if(array_key_exists('name', $changed)) {

                    // update all child AutoNodeRoutes
                    $routeManager->getAutoNodeRoutesRecursive($entity);
                    $unit->computeChangeSets();
                }
            }
        }
    }


    public function postFlush(PostFlushEventArgs $args)
    {



        $router = $this->container->get('router');
        $cache_dir = $this->container->getParameter('kernel.cache_dir');

        $this->container->get('cache_clearer')->clear($cache_dir);
        //$router->warmUp($cache_dir);
    }
}