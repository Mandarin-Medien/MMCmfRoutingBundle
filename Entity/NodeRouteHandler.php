<?php

namespace MandarinMedien\MMCmfRoutingBundle\Entity;

use Doctrine\ORM\EntityManager;
use MandarinMedien\MMCmfNodeBundle\Entity\Node;
use utilphp\util;

class NodeRouteHandler
{

    /**
     * @var EntityManager
     */
    private $manager;


    public function __construct(EntityManager $manager)
    {
        $this->manager = $manager;
    }


    /**
     * generates a NodeRoute for a given Node
     * @param Node $node
     * @return NodeRoute
     */
    public function autoGenerateNodeRoute(Node $node)
    {
        $route = (new NodeRoute())
            ->setRoute('/' . $this->slugify($node))
            ->setNode($node);

        /**
         * @var Node $parent
         */
        while (!is_null($parent = $node->getParent())) {
            $route->setRoute('/' . $this->slugify($parent) . $route->getRoute());
            $node = $parent;
        }

        return $route;
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

}