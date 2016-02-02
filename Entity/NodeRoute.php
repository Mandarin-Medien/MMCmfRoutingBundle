<?php

namespace MandarinMedien\MMCmfRoutingBundle\Entity;
use MandarinMedien\MMCmfNodeBundle\Entity\Node;

/**
 * NodeRoute
 */
class NodeRoute
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var Node
     */
    private $node;

    /**
     * @var string
     */
    private $route;


    /**
     * @var bool
     */
    private $generic;


    public function __construct()
    {
        $this->setGeneric(true);
    }


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set node
     *
     * @param Node $node
     *
     * @return NodeRoute
     */
    public function setNode(Node $node)
    {
        $this->node = $node;

        return $this;
    }

    /**
     * Get node
     *
     * @return Node
     */
    public function getNode()
    {
        return $this->node;
    }

    /**
     * Set route
     *
     * @param string $route
     *
     * @return NodeRoute
     */
    public function setRoute($route)
    {
        $this->route = $route;

        return $this;
    }

    /**
     * Get route
     *
     * @return string
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * @return boolean
     */
    public function isGeneric()
    {
        return $this->generic;
    }

    /**
     * @param boolean $generic
     * @return NodeRoute
     */
    public function setGeneric($generic)
    {
        $this->generic = $generic;
        return $this;
    }


    public function __toString()
    {
        return $this->getRoute();
    }
}

