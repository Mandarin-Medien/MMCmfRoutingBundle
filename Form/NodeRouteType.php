<?php

namespace MandarinMedien\MMCmfRoutingBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class NodeRouteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
       $builder
           ->add('route')
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver
            ->setDefault('data_class', 'MandarinMedien\MMCmfRoutingBundle\Entity\NodeRoute')
            ->setDefault('cascade_validation', true);
    }

    public function getName()
    {
        return 'mm_cmf_routing_noderoute_type';
    }
}