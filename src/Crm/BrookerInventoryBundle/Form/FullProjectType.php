<?php

namespace Crm\BrookerInventoryBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FullProjectType extends AbstractType
{

    private $dir;
    public function __construct($dir) {
        $this->dir = $dir;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $myEntity = $builder->getForm()->getData();
        $builder
            ->add('name')
            ->add('location')
            ->add('folder', 'hidden')
            ->add('slogan')
            ->add('landArea')
            ->add('numberOfUnits')
            ->add('unitTypes')
            ->add('averagePrice')
            ->add('projectBuiltDensity')
            ->add('maxHeight')
            ->add('description')
            ->add('currentPhase')
            ->add('amenities')
            ->add('finishing')
            ->add('address')
            ->add('gpsCoordinates')
            ->add('landMarks')
            ->add('numberOfPhases')
            ->add('nextDeliveryBy', 'date', array(
                'widget' => 'single_text',
                'format' => 'MM-dd-yyyy',
                'required' => false
                ))
            ->add('paymentPlans')
            ->add('gallery', 'comur_gallery', array(
                'uploadConfig' => array(
                    'uploadRoute' => 'comur_api_upload',
                    'uploadUrl' => $myEntity->getUploadRootDir(), 
                    'webDir' => "crm/alissta/web/".$myEntity->getUploadDir(), 
                    'fileExt' => '*.jpg;*.gif;*.png;*.jpeg',    
                    'libraryDir' => null,                     
                    'libraryRoute' => 'comur_api_image_library',
                    'showLibrary' => true,                     
                    //'saveOriginal' => 'originalImage'        
                ),
                'cropConfig' => array(
                    'minWidth' => 609,
                    'minHeight' => 336,
                    'aspectRatio' => true,           
                    'cropRoute' => 'comur_api_crop',  
                    'forceResize' => false,            
                    'thumbs' => array(                
                        array(
                            'maxWidth' => 570,
                            'maxHeight' => 380,
                            'useAsFieldImage' => true  
                        )
                    )
                )
            ))
            ->add('masterPlan')
            ->add('primeAvailable', null, ['label' => false])
            ->add('properties')
            ->add('developer')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Crm\BrookerInventoryBundle\Entity\Project'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'crm_brookerinventorybundle_project';
    }
}
