<?php

namespace MandarinMedien\MMCmfRoutingBundle\Form\DataTransformer;

use Doctrine\Common\Persistence\ObjectManager;
use MandarinMedien\MMCmfRoutingBundle\Entity\NodeRoute;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class StringToNodeRouteTransformer implements DataTransformerInterface
{
    /**
     * @var ObjectManager
     */
    protected $objectManager;


    public function __construct(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    public function transform($nodeRoute)
    {
        if (null === $nodeRoute) {
            return;
        }

        return $nodeRoute->getRoute();
    }

    public function reverseTransform($value)
    {
        var_dump($value);

        if (!$value) {
            return null;
        }

        $nodeRoute = $this->objectManager
            ->getRepository(NodeRoute::class)
            ->findOneBy(array(
                'route' => $value
            ));


        if (null === $nodeRoute) {
            throw new TransformationFailedException();
        }

        return $nodeRoute;
    }
}