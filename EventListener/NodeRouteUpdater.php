<?php

namespace MandarinMedien\MMCmfRoutingBundle\EventListener;


use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use MandarinMedien\MMCmfRoutingBundle\Entity\NodeRoute;
use MandarinMedien\MMCmfNodeBundle\Entity\Node;
use MandarinMedien\MMCmfRoutingBundle\Entity\NodeRouteManager;
use Doctrine\ORM\Event\PostFlushEventArgs;


/**
 * Class NodeRouteUpdater
 *
 * handles the creation and updates of Node related NodeRoute Entites
 *
 * @package MandarinMedien\MMCmfRoutingBundle\EventListener
 */
class NodeRouteUpdater
{

    protected $updateRoutes;



    public function __construct()
    {
        $this->updateRoutes = array();
    }
    

    /**
     * preUpdate Event
     * whenever a Node::name has changed update all related routes
     *
     * @param PreUpdateEventArgs $args
     */
    public function preUpdate(PreUpdateEventArgs $args)
    {
        // update child routes
        $entity = $args->getEntity();
        $routes = array();

        if (!$entity instanceof Node) {
            return;
        }

        if($args->hasChangedField('name')) {
            $routeManager = new NodeRouteManager($args->getEntityManager());

            // since you can't persist entites in preUpdate process,
            // get the routes to update and store it in property
            // so it can be persisted and flushed on postFlush Event
            $this->updateRoutes = array_merge(
                $routeManager->updateNodeRoutesRecursive($entity),
                $this->updateRoutes
            );
        }
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

        if (!$entity instanceof Node) {
            return;
        }

        $routeManager = new NodeRouteManager($args->getEntityManager());
        $entity->addRoute($routeManager->autoGenerateNodeRoute($entity));
    }


    /**
     * postFlush Event for persisting all NodeRoutes that needs an update
     *
     * @param PostFlushEventArgs $args
     */
    public function postFlush(PostFlushEventArgs $args)
    {

        $em = $args->getEntityManager();

        if(count($this->updateRoutes) > 0)
        {
            /**
             * @var NodeRoute $nodeRoute
             */
            foreach($this->updateRoutes as $nodeRoute)
            {
                $em->persist($nodeRoute);
            }

            // unset the update routes avoiding endless loop
            $this->updateRoutes = array();
            $em->flush();
        }
    }
}