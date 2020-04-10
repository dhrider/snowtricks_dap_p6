<?php

namespace App\Form;


use App\Form\EventListener\ImageEventListener;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class ImageType extends AbstractType
{
    private $imageEventListener;

    public function __construct(ImageEventListener $imageEventListener)
    {
        $this->imageEventListener = $imageEventListener;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('image', FileType::class, [
            'mapped' => false
        ]);
        $builder->add('submit', SubmitType::class);
        $builder->add($this->imageEventListener);
    }
}
