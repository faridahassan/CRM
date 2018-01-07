<?php

namespace Crm\SandboxBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityManager;

class DealType extends AbstractType
{
    private $em;

    public function __construct(EntityManager $entityManager) {
        $this->em = $entityManager;
    }
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // not sold and not deposited
        $availableProperties = $this->em->getRepository('CrmBrookerInventoryBundle:Property')->getAvailableForDeal();

        $builder
            ->add('price', 'text',['required' => false])
            ->add('commission')
            ->add('closed')
            ->add('deposit', 'text',['required' => false])
            ->add('lead')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Crm\SandboxBundle\Entity\Deal'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'crm_sandboxbundle_deal';
    }
}
