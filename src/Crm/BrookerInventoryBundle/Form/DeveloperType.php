<?php

namespace Crm\BrookerInventoryBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DeveloperType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            // ->add('locations', 'entity', array(
            //         'class' => 'Crm\BrookerInventoryBundle\Entity\Location',
            //         'property' => 'name',
            //         'multiple' => true,
            //         'expanded' => true
            //     ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Crm\BrookerInventoryBundle\Entity\Developer'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'crm_brookerinventorybundle_developer';
    }
}
