<?php

namespace Crm\SandboxBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Crm\SandboxBundle\Form\ComplaintLogType;

class ComplaintWithLeadType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('mobile')
            ->add('brief')
            ->add('description')
            ->add('status', 'choice', array(
                'choices' => array(
                    'Feedback' => 'Feedback',
                    'Complain' => 'Complain',
                    'Meeting' => 'Meeting',
                    'Follow Up' => 'Follow Up'
                    )
            ))
            ->add('department', 'choice', array(
                'choices' => array(
                    'Legal' => 'Legal',
                    'Operation' => 'Operation',
                    'Finance' => 'Finance',
                    'Credit' => 'Credit',
                    'HR' => 'HR',
                    'Sales' => 'Sales',
                    'Marketing' => 'Marketing',
                    )
            ))
            ->add('complaintlog',new ComplaintLogType(),['mapped'=>false]) 
            
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Crm\SandboxBundle\Entity\Complaint'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'crm_sandboxbundle_complaint';
    }
}
