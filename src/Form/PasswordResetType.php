<?php


namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class PasswordResetType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('password',RepeatedType::class, array(
                'type' => PasswordType::class,
                'invalid_message' => 'The password are not the same !',
                'first_options' => array(
                    'label' => false,
                    'attr' => array(
                        'placeholder' => 'Choose a Password'
                    )
                ),
                'second_options' => array(
                    'label' => false,
                    'attr' => array(
                        'placeholder' => 'Repeat your Password'
                    )
                )
            ))
            ->add('submit', SubmitType::class, array(
                'attr' => array(
                    'class' => 'btn-primary pull-left'
                ),
                'label' => 'Send'
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'App\Entity\User'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'user';
    }
}
