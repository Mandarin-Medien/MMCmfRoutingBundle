<?php

namespace MandarinMedien\MMCmfRoutingBundle\Controller;

use MandarinMedien\MMCmfRoutingBundle\Entity\AutoNodeRoute;
use MandarinMedien\MMCmfRoutingBundle\Entity\RedirectNodeRoute;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use MandarinMedien\MMCmfNodeBundle\Entity\Node;
use MandarinMedien\MMCmfRoutingBundle\Entity\NodeRoute;
use Symfony\Component\BrowserKit\Response;

class NodeRouteController extends Controller
{

    /**
     * @var string default Template
     */
    protected $defaultView = "MMCmfRoutingBundle:Default:index.html.twig";

    public function nodeRouteAction(NodeRoute $nodeRoute)
    {


        if ($nodeRoute instanceof RedirectNodeRoute) {
            return $this->redirectAction($nodeRoute);
        } else {

            return $this->render(
                $this->getDefaultView(),
                array(
                    'node' => $nodeRoute->getNode(),
                    'route' => $nodeRoute
                )
            );
        }
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
    public function redirectAction(RedirectNodeRoute $nodeRoute)
    {

        $status = $nodeRoute->getStatusCode();

        foreach($nodeRoute->getNode()->getRoutes() as $route) {
            if($route instanceof AutoNodeRoute) {
                return $this->redirectToRoute("mm_cmf_node_route", array(
                    'route' => trim($route->getRoute(), '/')
                ), $status);
            }
        }
    }

    /**
     * @return mixed
     */
    public function getDefaultView()
    {
        return $this->defaultView;
    }

    /**
     * @param string $defaultView
     * @return NodeRouteController
     */
    public function setDefaultView($defaultView)
    {
        $this->defaultView = $defaultView;
        return $this;
    }
}
