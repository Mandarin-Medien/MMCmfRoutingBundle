<?php

namespace MandarinMedien\MMCmfRoutingBundle\Form;


use MandarinMedien\MMCmfRoutingBundle\Entity\NodeRoute;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NodeRouteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
       $builder->add('route');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefault('data_class', NodeRoute::class)
            ->setDefault('cascade_validation', true);
    }

    public function getBlockPrefix()
    {
        return 'mm_cmf_routing_noderoute_type';
    }
}