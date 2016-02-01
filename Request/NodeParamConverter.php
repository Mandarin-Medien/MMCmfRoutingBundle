<?php

namespace MandarinMedien\MMCmfRoutingBundle\Request;

use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class NodeParamConverter implements ParamConverterInterface
{

    private $manager;
    private $repositoryClass = 'MandarinMedien\MMCmfRoutingBundle\Entity\NodeRoute';

    public function __construct(EntityManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * {@inheritdoc}
     */
    function apply(Request $request, ParamConverter $configuration)
    {
        $route = $this->manager->getRepository($this->repositoryClass)->findOneBy(array(
            'route' => $request->getPathInfo()
        ));

        if(! $route) {
            throw new NotFoundHttpException();
        }

        $request->attributes->add(
            array($configuration->getName() => $route->getNode())
        );

        return true;
    }


    /**
     * {@inheritdoc}
     */
    function supports(ParamConverter $configuration)
    {
        return in_array(
            'MandarinMedien\MMCmfNodeBundle\Entity\NodeInterface',
            class_implements($configuration->getClass())
        );
    }

}