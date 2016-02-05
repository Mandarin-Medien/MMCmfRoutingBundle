<?php

namespace MandarinMedien\MMCmfRoutingBundle\Entity;

use MandarinMedien\MMCmfRoutingBundle\Validator\Constraints as RoutingAssert;

/**
 * RedirectNodeRoute
 *
 * @TODO: Extend RedirectNodeRoute, so an target Route is selectable
 */
class RedirectNodeRoute extends NodeRoute
{

    /**
     * @var int
     * @RoutingAssert\RedirectStatusCode
     */
    private $statusCode = 301;

    /**
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @param int $statusCode
     * @return RedirectNodeRoute
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
        return $this;
    }
}

