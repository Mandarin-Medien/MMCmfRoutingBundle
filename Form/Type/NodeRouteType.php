<?php

namespace MandarinMedien\MMCmfRoutingBundle\Form\Type;

use Doctrine\ORM\EntityManager;
use MandarinMedien\MMCmfRoutingBundle\Entity\NodeRoute;
use MandarinMedien\MMCmfRoutingBundle\Form\DataTransformer\StringToNodeRouteTransformer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class NodeRouteType extends AbstractType
{

    private $manager;

    /**
     * @param EntityManager $manager
     */
    public function __construct(EntityManager $manager)
    {
        $this->manager = $manager;
    }


    /**
     * @param OptionsResolver $resolver
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefault('allow_add', true)
            ->setDefault('allow_delete', true)
            ->setDefault('data_class', NodeRoute::class);

    }


    /**
     * @return string
     */
    public function getParent()
    {
        return CollectionType::class;
    }


    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return "node_route_type";
    }

}