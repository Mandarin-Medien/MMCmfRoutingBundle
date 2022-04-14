<?php

namespace MandarinMedien\MMCmfRoutingBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use MandarinMedien\MMCmfNodeBundle\Entity\NodeInterface;


interface RoutableNodeInterface extends NodeInterface
{

    public function addRoute(NodeRouteInterface $nodeRoute);

    /**
     * @return ArrayCollection|array|NodeRoute[]
     */
    public function getRoutes();

    public function removeRoute(NodeRouteInterface $nodeRoute);

    public function setRoutes(ArrayCollection $nodeRoutes);

    public function hasAutoNodeRouteGeneration();

    public function setAutoNodeRouteGeneration($autoNodeRouteGeneration);


}