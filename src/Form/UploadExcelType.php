<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class UploadExcelType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('worksheet', null, [
            'label' => "WorkSheet",
            'label_attr'=> ['class' => 'font-weight-light  mt-2'],
            'attr'=> ['class' => 'form-control form-control-sm'],
            'required'   => true
            ])
        ->add('data', FileType::class, [
            'label' => 'Ajouter un fichier excel',
            'label_attr'=> ['class' => 'font-weight-light'],
            // unmapped means that this field is not associated to any entity property
            'mapped' => false,

            // make it optional so you don't have to re-upload the PDF file
            // every time you edit the Product details
            'required' => true,

            // unmapped fields can't define their validation using annotations
            // in the associated entity, so you can use the PHP constraint classes
            'constraints' => [
                new File([
                    'maxSize' => '2048k',
                    'mimeTypes' => [
                        'application/vnd.ms-excel',
                        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
                    ],
                    'mimeTypesMessage' => 'Please upload a valid Excel document (xls, xlsx)',
                ])
            ]
        ]
        )->add('Importer', SubmitType::class,[
            'attr'=> ['class' => 'btn btn-primary maincolor btn-sm btn-flat'],
        ]);
        
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
