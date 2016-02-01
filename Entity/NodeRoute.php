<?php

namespace MandarinMedien\MMCmfRoutingBundle\Entity;

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
     * @var integer
     */
    private $node;

    /**
     * @var string
     */
    private $route;


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
     * @param integer $node
     *
     * @return NodeRoute
     */
    public function setNode($node)
    {
        $this->node = $node;

        return $this;
    }

    /**
     * Get node
     *
     * @return integer
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
}

