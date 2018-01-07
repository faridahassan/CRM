<?php

namespace Crm\SandboxBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Crm\SandboxBundle\Form\ContactType;
use Doctrine\ORM\EntityRepository;

class LeadType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('info')
            ->add('status', 'choice', array(
                'choices' => array(
                    'New Lead' => 'New Lead',
                    'Ongoing' => 'Ongoing',
                    )
                ))
            ->add('description')
            ->add('budget','text',['required' => false,])
            ->add('assignedSalesRep', 'entity', array(
                'required' => false,
                'class' => 'CrmSandboxBundle:User',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->where("u.roles LIKE '%ROLE_SALES_REPRESENTATIVE%' ")
                        ->orWhere("u.roles LIKE '%ROLE_SALES_MANAGER%' ")
                        ->orWhere("u.roles LIKE '%ROLE_ADMIN%' ")
                        ;
                },
            ))
            ->add('subChannel', 'entity', array(
                'class' => 'CrmSandboxBundle:SubChannel',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('sc')
                        ->where('sc.endDate > :today')
                        ->andwhere('sc.hide = false')
                        ->setParameter('today', new \DateTime())

                        ;
                },
            ))
            ->add('evaluation', 'choice', array(
                    'choices' => array(
                            'Unassigned' => 'Unassigned',
                            'Waiting for details' => 'Waiting for details',
                            'On hold' => 'On hold'
                        )
                ))
            ->add('contact', new ContactType())
            ->add('features', 'entity', array(
                'required' => false,
                    'class' => 'Crm\SandboxBundle\Entity\Features',
                    'multiple' => true,
                ))
            ->add('locations', 'entity', array(
                'required' => false,
                    'class' => 'Crm\BrookerInventoryBundle\Entity\Location',
                    'multiple' => true,
                ))
            ->add('typeFeatures', 'choice', array(
                'required' => false,
                'choices' => array(
                      'Chalet' => 'Chalet',
                        'Villa' => 'Villa',
                        'Standalone' => 'Standalone',
                        'Townhouse' => 'Townhouse Up',
                        'Twinhouse' => 'Twinhouse',
                        'Apartment' => 'Apartment',
                        'Penthouse' => 'Penthouse',
                        'Duplex' => 'Duplex',
                        'Maisonette' => 'Maisonette',
                        'Studio' => 'Studio'
                    ),
                'multiple' => true,
                ))
            ;
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Crm\SandboxBundle\Entity\Lead'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'crm_sandboxbundle_lead';
    }
}
