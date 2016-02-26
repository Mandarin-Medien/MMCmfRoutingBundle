<?php

namespace MandarinMedien\MMCmfRoutingBundle\Entity;
use MandarinMedien\MMCmfNodeBundle\Entity\Node;
use Symfony\Component\Validator\Constraints as Assert;
use MandarinMedien\MMCmfRoutingBundle\Validator\Constraints as RoutingAssert;

/**
 * NodeRoute
 * @RoutingAssert\NodeRouteUnique
 */
class NodeRoute implements NodeRouteInterface
{
    /**
     * @var integer
     */
    protected $id;

    /**
     * @var Node
     */
    protected $node;

    /**
     * @Assert\NotBlank
     */
    protected $route;


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
    public function setNode(Node $node = null)
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


    public function __toString()
    {
        return $this->getRoute();
    }
}

