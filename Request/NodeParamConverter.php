<?php

namespace MandarinMedien\MMCmfRoutingBundle\Request;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class NodeParamConverter implements ParamConverterInterface
{

    private $manager;
    private $repositoryClass = 'MandarinMedien\MMCmfRoutingBundle\Entity\NodeRoute';

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @param Request $request
     * @param ParamConverter $configuration
     * @return bool
     */
    function apply(Request $request, ParamConverter $configuration)
    {

        $route = $this->manager->getRepository($this->repositoryClass)->findOneBy(array(
            'route' => $request->getPathInfo()
        ));

        if($route) {
            $request->attributes->add(
                array($configuration->getName() => $route->getNode())
            );
            return true;
        }

        return false;
    }


    /**
     * @param ParamConverter $configuration
     * @return bool
     */
    function supports(ParamConverter $configuration)
    {

        if($configuration->getClass()) {
            return in_array(
                'MandarinMedien\MMCmfNodeBundle\Entity\NodeInterface',
                class_implements($configuration->getClass())
            );
        }

        return false;
    }

}