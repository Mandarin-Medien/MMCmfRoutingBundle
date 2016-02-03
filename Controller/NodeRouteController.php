<?php

namespace MandarinMedien\MMCmfRoutingBundle\Controller;

use MandarinMedien\MMCmfRoutingBundle\Entity\AutoNodeRoute;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use MandarinMedien\MMCmfNodeBundle\Entity\Node;

class NodeRouteController extends Controller
{
    public function nodeAction(Node $node)
    {
        return $this->render('MMCmfRoutingBundle:Default:index.html.twig', array('node' => $node));
    }


    /**
     *
     * default redirect action
     * triggered when a RedirectNodeRoute is called
     *
     * @TODO: Extend RedirectNodeRoute, so an target Route is selectable
     *
     * @param Node $node
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirectAction(Node $node)
    {
        foreach($node->getRoutes() as $route) {
            if($route instanceof AutoNodeRoute) {

                // get the route name
                $router = $this->get('router');
                $route  = $router->match($route->getRoute());

                return $this->redirectToRoute($route['_route'], array(), 301);
            }
        }
    }
}
