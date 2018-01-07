<?php

namespace Crm\SandboxBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TaskType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('comment',null,['required' => false])
            ->add('type', 'choice', [
                    'required' => false,
                    'choices' => [
                        'meeting'=>'Appointment',
                        'call'=>'Follow Up'
                    ],
                    'empty_value' => 'Reminder type must be set.'
                ])
            ->add('date', 'date', array(
                'required' => true,
                'widget' => 'single_text',
                'format' => 'yyyy-M-d',))
               // ->add('date','text')
            // ->add('user')
            // ->add('call')
            // ->add('lead')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Crm\SandboxBundle\Entity\Task'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'crm_sandboxbundle_task';
    }
}
