<?php

namespace App\Form;

use App\Entity\Figure;
use App\Entity\FiguresGroup;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class FigureType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => false,
                'attr' => array(
                    'placeholder' => 'Enter figure name'
                )
            ])
            ->add('description', TextareaType::class, [
                'label' => false,
                'attr' => array(
                    'placeholder' => 'Enter the description',
                    'style' => 'height: 300px; resize: vertical'
                )
            ])
            ->add('figuresGroup', EntityType::class, [
                'label' => false,
                'placeholder' => 'Choose a figure group',
                'class' => FiguresGroup::class,
                'choice_label' => 'name'
            ])
            ->add('file', FileType::class, [
                'label' => false,
                'mapped' => false,
                'required' => true,
                'constraints' => [
                   new File([
                       'maxSize' => '2M',
                       'mimeTypes' => [
                           'image/jpeg',
                           'image/png'
                       ],
                       'mimeTypesMessage' => 'Please upload a JPG or PNG image file'
                   ])
                ]

            ])
            ->add('Submit', SubmitType::class, [
                'attr' => array(
                    'class' => 'btn-primary pull-left'
                ),
                'label' => 'Save'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Figure::class,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'post';
    }
}
