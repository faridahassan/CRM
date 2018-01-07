<?php

namespace Crm\BrookerInventoryBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;

use Crm\BrookerInventoryBundle\Form\ImageType;
use Crm\BrookerInventoryBundle\Entity\Location;


class PropertyType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $myEntity = $builder->getForm()->getData();
        $builder
            ->add('contactName')
            ->add('rentPrice')
            ->add('rentFinalPrice')
            ->add('contactNumber')
            ->add('contactEmail')
            ->add('previousContactName')
            ->add('previousContactNumber')
            ->add('previousContactEmail')
            ->add('propertyTypeDynamic', 'entity', array(
                'class' => 'CrmBrookerInventoryBundle:PropertyType',
                'required' => false,
                'placeholder' => 'Select Property Type'
            ))
            ->add('commercial', null, ['label' => false])
            ->add('contactAddress')
            ->add('location', 'entity', array(
                    'class' => 'CrmBrookerInventoryBundle:Location',
                    'placeholder' => '',
                    'required' => false
                ))
            ->add('developer', 'entity', array(
                    'class' => 'CrmBrookerInventoryBundle:Developer',
                    'placeholder' => '',
                    'required' => false
                ))
            ->add('project', 'entity', array(
                    'class' => 'CrmBrookerInventoryBundle:Project',
                    'placeholder' => '',
                    'required' => false
                ))
            ->add('name')
            ->add('folder')
            ->add('broker')
            ->add('phase')
            ->add('delivered',null, ['label' => false])
            ->add('folder', 'hidden')
            ->add('sellingType', 'choice', array(
                    'choices' => array(
                        'Sale' => 'Sale',
                        'Rent' => 'Rent',
                        'Both' => 'Both'
                        )
                ))
            ->add('exclusivity', 'choice', array(
                    'choices' => array(
                        'Exclusive' => 'Exclusive',
                        'Open' => 'Open',
                        )
                ))
            ->add('isActive' ,null, ['label' => false])
            ->add('legal', 'choice', array(
                    'choices' => array(
                        'Agreement - PVT' => 'Agreement - PVT',
                        'Property Contract + Appendices + Floor Plans' => 'Property Contract + Appendices + Floor Plans',
                        )
                ))
            ->add('eagerness', 'choice', array(
            'choices' => array(
                'Very High' => 'Very High',
                'High' => 'High',
                'Medium' => 'Medium',
                'Low' => 'Low',
                )
            ))
            
                        ->add('soldDate', 'date', array(
                'widget' => 'single_text',
                'format' => 'MM-dd-yyyy',
                'required' => false
                ))
            ->add('soldPrice')
            ->add('prime', null, ['label' => false])
            ->add('landArea')
            ->add('address')
            ->add('instalments')
            ->add('propertyType')
            ->add('type', 'choice', array(
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
                        )
                ))
            ->add('unitNumber')
            ->add('buildingNumber')
            ->add('buildupArea')
            ->add('floors')
            ->add('links')
            ->add('finishing', 'choice', array(
            'required' => false,
                'placeholder' => 'Select Finishing',
            'choices' => array(
                'Luxury Finished' => 'Luxury Finished',
                'Basic Finished' => 'Basic Finished',
                'Semi Finished' => 'Semi Finished',
                )
            ))
            ->add('furnishing', 'choice', array(
            'required' => false,
                'placeholder' => 'Select Furnishing',
            'choices' => array(
                    'Fully Furnished' => 'Fully Furnished',
                    'Semi Furnished' => 'Semi Furnished',
                    'Unfurnished' => 'Unfurnished',
                )
            ))
            ->add('view', 'choice', array(
            'required' => false,
            'placeholder' => 'Select View',
            'choices' => array(
                    'Open View' => 'Open View',
                    'Landscape View' => 'Landscape View',
                    'Sea View' => 'Sea View',
                    'Nile View' => 'Nile View',
                    'Golf View' => 'Golf View',
                )
            ))
            ->add('gardenArea')
            ->add('bedrooms')
            ->add('bathrooms')
            ->add('notes')
            ->add('askingPrice', 'number', ['required' => true])
            ->add('totalPrice', 'number', ['required' => false])
            ->add('maintenance')
            ->add('paymentPlan', 'choice', ['choices' => [
                    'Cash' => 'Cash', 
                    'Installments' => 'Installments'
                ]])
            ->add('exclusivity', 'choice', ['choices' => [
                    'Exclusive' => 'Exclusive', 
                    'Open' => 'Open'
                ]])
            ->add('transfer')
            ->add('featured', null, ['label' => false])
            ->add('superFeatured', null, ['label' => false])
            ->add('deliveryDate', 'date', array(
                'widget' => 'single_text',
                'format' => 'MM-dd-yyyy',
                'required' => false
                ))

            ->add('features', 'entity', array(
                    'class' => 'Crm\SandboxBundle\Entity\Features',
                    'property' => 'name',
                    'multiple' => true,
                    'required' => false
                ))
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
                    'minWidth' => 1230,
                    'minHeight' => 817,
                    'aspectRatio' => true,           
                    'cropRoute' => 'comur_api_crop',  
                    'forceResize' => false,            
                    'thumbs' => array(                
                        array(
                            'maxWidth' => 1230,
                            'maxHeight' => 817,
                            'useAsFieldImage' => true  
                        )
                    )
                )
            ))
            ->add('slider', 'comur_image', array(
                'required' => false,
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
                    'minWidth' => 2460,
                    'minHeight' => 1634,
                    'aspectRatio' => true,           
                    'cropRoute' => 'comur_api_crop',  
                    'forceResize' => false,            
                    'thumbs' => array(                
                        array(
                            'maxWidth' => 2460,
                            'maxHeight' => 1634,
                            'useAsFieldImage' => true  
                        )
                    )
                )
            ))
            ->add('thumbnail', 'comur_image', array(
                'required' => false,
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
                    'minWidth' => 1230,
                    'minHeight' => 690,
                    'aspectRatio' => true,           
                    'cropRoute' => 'comur_api_crop',  
                    'forceResize' => false,            
                    'thumbs' => array(                
                        array(
                            'maxWidth' => 1230,
                            'maxHeight' => 690,
                            'useAsFieldImage' => true  
                        )
                    )
                )
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Crm\BrookerInventoryBundle\Entity\Property'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'crm_brookerinventorybundle_property';
    }
}
