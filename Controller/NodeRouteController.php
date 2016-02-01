<?php

namespace MandarinMedien\MMCmfRoutingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use MandarinMedien\MMCmfNodeBundle\Entity\Node;

class NodeRouteController extends Controller
{
    public function nodeAction(Node $node)
    {
        return $this->render('MMCmfRoutingBundle:Default:index.html.twig', array('node' => $node));
    }
}
