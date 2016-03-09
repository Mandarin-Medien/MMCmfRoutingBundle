<?php

namespace MandarinMedien\MMCmfRoutingBundle\Entity;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query\ResultSetMapping;
use MandarinMedien\MMCmfNodeBundle\Entity\Node;
use utilphp\util;

/**
 * Class NodeRouteManager
 *
 * Handles the generating, persisting and updating of NodeRoutes
 *
 * @package MandarinMedien\MMCmfRoutingBundle\Entity
 */
class NodeRouteManager
{

    /**
     * @var EntityManager
     */
    protected $manager;


    /**
     * NodeRouteManager constructor.
     * @param EntityManager $manager
     */
    public function __construct(EntityManager $manager)
    {
        $this->manager = $manager;
    }


    /**
     * generates a AutoNodeRoute for a given Node
     *
     * @param Node $node
     * @return AutoNodeRoute
     */
    public function generateAutoNodeRoute(Node $node)
    {

        $repository = $this->manager->getRepository(AutoNodeRoute::class);

        $route = (new AutoNodeRoute())
            ->setRoute('/' . $this->slugify($node))
            ->setNode($node);

        /**
         * @var Node $parent
         */
        while (!is_null($parent = $node->getParent())) {
            $route->setRoute($this->getAutoNodeRoute($parent) . $route->getRoute());
            $node = $parent;
        }

        // add incrementor if route exists
        $route->setRoute(
            $route->getRoute().($this->getIncrement($route->getRoute()) ?: '')
        );


        return $route;
    }


    /**
     * get updated AutoNodeRoutes recursive
     *
     * @param Node $node
     * @param null|string $base
     * @return NodeRoute[]
     */
    public function getAutoNodeRoutesRecursive(Node &$node, $base = null)
    {
        $routeObjects = array();

        $route = null;
        $routes = $node->getRoutes();

        // update the AutoNodeRoutes of current Node
        if(count($routes)>0) {

            foreach($routes as $route) {

                if($route instanceof AutoNodeRoute) {

                    $route->setRoute(
                        $base   ? $base . '/' . util::slugify($node->getName())
                                : $this->generateAutoNodeRoute($node)->getRoute()
                    );

                    array_push($routeObjects, $route);

                    // recursive loop
                    foreach($node->getNodes() as $node) {
                        $routeObjects = array_merge(
                            $this->getAutoNodeRoutesRecursive($node, $route->getRoute()),
                            $routeObjects
                        );
                    }
                }
            }
        }


        return $routeObjects;
    }


    /**
     * generate an url-friendly string from Node::name
     * @param Node $node
     * @return string
     */
    public function slugify(Node $node)
    {
        return util::slugify($node->getName());
    }


    /**
     * return the AutoNodeRoute::route of the given Node entity
     * @param Node $node
     * @return string
     */
    protected function getAutoNodeRoute(Node $node)
    {
        foreach($node->getRoutes() as $route) {
            if($route instanceof AutoNodeRoute) {
                return $route->getRoute();
            }
        }
    }


    /**
     * check if the generated route already exists and return the count
     * @param string $route route string to check
     * @return int increment value
     */
    protected function getIncrement($route)
    {

        $mapper = new ResultSetMapping();
        $mapper->addScalarResult('count', 'count');

        $builder = $this->manager->createNativeQuery(
            'SELECT count(*) as count FROM node_route WHERE route REGEXP ?',
            $mapper
        )
        ->setParameter('1', $route."[0-9]*$");

        return (int) $builder->getSingleScalarResult();
    }

}