<?php

namespace Crm\SandboxBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Crm\SandboxBundle\Form\TaskType;

class CallType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('orientation', 'choice', array(
                'choices' => array(
                        'inbound' => 'inbound',
                        'outbound' => 'outbound'
                    )
                ))
            ->add('objective', 'choice', array(
                    'choices' => array(
                        'Feedback' => 'Feedback',
                        'Complain' => 'Complain',
                        'Meeting' => 'Meeting',
                        'Follow Up' => 'Follow Up'
                        )
                ))
            ->add('outcome')
            ->add('interestedIn')
            ->add('properties', 'entity', array(
                    'class' => 'Crm\BrookerInventoryBundle\Entity\Property',
                    'multiple' => true,
                    'required' => false,
                ))
            ->add('isCall')
            ->add('lead')
            ->add('task', new TaskType()) 
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Crm\SandboxBundle\Entity\Call',
            'allow_extra_fields' => true
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'crm_sandboxbundle_call';
    }
}
