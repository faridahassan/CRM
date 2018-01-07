<?php

namespace Crm\BrookerInventoryBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TeamType extends AbstractType
{
    private $team_id;

    public function __construct($team_id = null) {
        $this->team_id = $team_id;
    }
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('leader', 'entity', [
                // 'required' => true,
                // 'placeholder' => 'Choose a leader',
                 'class' => 'Crm\SandboxBundle\Entity\User',
                 'query_builder' => function (\Crm\SandboxBundle\DAO\UserRepository $repository)
                    {
                     return $repository->createQueryBuilder('u') 
                            ->where('u.roles LIKE :roles')
                            // ->andWhere('u.ledTeam IS NULL')
                            ->setParameter('roles', '%ROLE_SALES_MANAGER%');
                    }
                ])
            ->add('users', 'entity', [
                    'class' => 'Crm\SandboxBundle\Entity\User',
                    'property' => 'name',
                    'multiple' => true,
                    'expanded' => false,
                    'query_builder' => function (\Crm\SandboxBundle\DAO\UserRepository $repository)
                    {
                        // Create function
                     if (is_null($this->team_id))
                        return $repository->createQueryBuilder('u') 
                            ->where('u.roles LIKE :roles')
                            ->andWhere('u.team is NULL')
                            ->setParameter('roles', '%ROLE_SALES_REPRESENTATIVE%');
                        // Edit function
                    else
                        return $repository->createQueryBuilder('u') 
                            ->where('u.roles LIKE :roles')
                            ->andWhere('u.team is NULL OR u.team = :team_id')
                            ->setParameter('roles', '%ROLE_SALES_REPRESENTATIVE%')
                            ->setParameter('team_id', $this->team_id)
                            ;
                    }
                ])
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Crm\BrookerInventoryBundle\Entity\Team'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'crm_brookerinventorybundle_team';
    }
}
