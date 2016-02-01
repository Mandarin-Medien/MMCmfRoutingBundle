<?php

namespace MandarinMedien\MMCmfRoutingBundle\Routing;

use Doctrine\ORM\EntityManager;
use MandarinMedien\MMCmfNodeBundle\Entity\Node;
use Symfony\Component\Config\Loader\Loader;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

class NodeRouteLoader extends Loader
{

    private $loaded = false;
    private $manager;
    private $repositoryClass = 'MandarinMedien\MMCmfRoutingBundle\Entity\NodeRoute';

    public function __construct(EntityManager $manager)
    {
        $this->manager = $manager;
    }

    public function load($resource, $type = null)
    {
        if (true === $this->loaded) {
            throw new \RuntimeException('Do not add the "extra" loader twice');
        }

        $routes = new RouteCollection();

        // load all entites from NodeRoute-Repository
        // and add to RouteCollection
        $node_routes = $this->manager->getRepository($this->repositoryClass)->findAll();

        foreach($node_routes as $node_route) {

            $path = $node_route->getRoute();
            $defaults = array(
                '_controller' => 'MMCmfRoutingBundle:NodeRoute:node'
            );

            /**
             * @var Node $node
             */
            if(!is_null($node = $node_route->getNode())) {

                $route = new Route($path, $defaults, array(), array(
                    'route' => $node_route
                ));

                $routeName = 'cmf_node_' . $node->getId();
                $routes->add($routeName, $route);
            }
        }

        $this->loaded = true;

        return $routes;
    }

    public function supports($resource, $type = null)
    {
        return 'mm_cmf_routing' === $type;
    }

}