<?php

namespace MandarinMedien\MMCmfRoutingBundle\Request;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;

class NodeRouteParamConverter implements ParamConverterInterface
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

        if(!is_null(
            $route = $this->manager
                ->getRepository($this->repositoryClass)
                ->findOneBy(
                    array(
                        'route' => '/'.$request->attributes->get('route')
                    )
                )
        )) {

            $request->attributes->add(
                array($configuration->getName() => $route)
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
        return $configuration->getClass() == 'MandarinMedien\MMCmfRoutingBundle\Entity\NodeRoute';
    }
}