<?php

namespace MandarinMedien\MMCmfRoutingBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;


interface RoutableNodeInterface
{

    public function addRoute(NodeRouteInterface $nodeRoute);

    public function getRoutes();

    public function removeRoute(NodeRouteInterface $nodeRoute);

    public function setRoutes(ArrayCollection $nodeRoutes);

    public function hasAutoNodeRouteGeneration();

    public function setAutoNodeRouteGeneration($autoNodeRouteGeneration);


}