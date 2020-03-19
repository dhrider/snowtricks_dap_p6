<?php

namespace App\Form;

use App\Entity\Figure;
use App\Entity\FiguresGroup;
use App\Entity\Image;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class FigureType extends AbstractType
{
    private $requestStack;
    private $imageDirectory;

    public function __construct(RequestStack $requestStack, string $imageDirectory)
    {
        $this->requestStack = $requestStack;
        $this->imageDirectory = $imageDirectory;
    }

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
            ->add('videoLinks', CollectionType::class, [
                'label' => false,
                'allow_add' => true,
                'prototype' => true,
                'by_reference' => false,
                'entry_type' => TextType::class,
                'entry_options' => [
                    'label' => false,
                    'mapped' => false,
                    'required' => false
                ]
            ])
            ->add('images', CollectionType::class, [
                'label' => false,
                'allow_add' => true,
                'prototype' => true,
                'by_reference' => false,
                'entry_type' => FileType::class,
                'entry_options' => [
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
                ]
            ])
            ->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $formEvent) {
                //dd($links = $this->requestStack->getCurrentRequest()->request->all()['post']['videoLinks']);
                $files = $this->requestStack->getCurrentRequest()->files->all()['post']['images'];
                $links = $this->requestStack->getCurrentRequest()->request->all()['post']['videoLinks'];

                foreach($files as $file) {
                    $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                    $safeFilename = transliterator_transliterate(
                        'Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()',
                        $originalFilename
                    );
                    $newFilename = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();

                    $file->move($this->imageDirectory,$newFilename);

                    $image = new Image();
                    $image->setName($newFilename);
                    $image->setType($file->getClientMimeType());

                    $formEvent->getData()->addImage($image);
                }

                foreach ($links as $link) {
                    $formEvent->getData()->setVideoLinks($link);
                }
            })
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
