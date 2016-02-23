<?php

namespace MandarinMedien\MMCmfRoutingBundle\Form\Type;

use Doctrine\ORM\EntityManager;
use MandarinMedien\MMCmfRoutingBundle\Form\DataTransformer\StringToNodeRouteTransformer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class NodeRouteType extends AbstractType
{

    private $manager;

    public function __construct(EntityManager $manager)
    {
        $this->manager = $manager;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefault('allow_add', true)
            ->setDefault('allow_delete', true)
            ->setDefault('data_class', 'MandarinMedien\MMCmfRoutingBundle\Entity\NodeRoute');

    }

    public function getParent()
    {
        return CollectionType::class;
    }


    public function getName()
    {
        return "node_route_type";
    }

}