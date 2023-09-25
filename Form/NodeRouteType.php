<?php

namespace MandarinMedien\MMCmfRoutingBundle\Form;


use MandarinMedien\MMCmfRoutingBundle\Entity\NodeRoute;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NodeRouteType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
       $builder->add('route');
    }


    /**
     * @param OptionsResolver $resolver
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefault('data_class', NodeRoute::class)
            ->setDefault('cascade_validation', true);
    }


    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'mm_cmf_routing_noderoute_type';
    }
}