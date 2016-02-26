<?php

namespace MandarinMedien\MMCmfRoutingBundle\Entity;

use MandarinMedien\MMCmfNodeBundle\Entity\Node;


/**
 * Interface NodeRouteInterface
 * @package MandarinMedien\MMCmfRoutingBundle\Entity
 */
interface NodeRouteInterface
{

    /**
     * @param Node|null $node
     * @return mixed
     */
    public function setNode(Node $node = null);

    /**
     * @return Node|null
     */
    public function getNode();


    /**
     * @param string$route
     * @return mixed
     */
    public function setRoute($route);

    /**
     * @return string
     */
    public function getRoute();

}

