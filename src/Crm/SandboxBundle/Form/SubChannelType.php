<?php

namespace Crm\SandboxBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;
class SubChannelType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('name')
        ->add('channel', 'entity', array(
            'class' => 'Crm\SandboxBundle\Entity\Channel',
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('sc')
                ->where('sc.hide = false')
                ;
            },
            ))
        ->add('cost','text')
        ->add('startDate', 'date', array(
            'widget' => 'single_text',
            'format' => 'MM-dd-yyyy'))
        ->add('endDate', 'date', array(
            'widget' => 'single_text',
            'format' => 'MM-dd-yyyy',))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Crm\SandboxBundle\Entity\SubChannel',
            'attr'=>array('novalidate'=>'novalidate')
            ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'crm_sandboxbundle_subchannel';
    }
}
