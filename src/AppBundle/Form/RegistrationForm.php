<?php

namespace AppBundle\Form;

use AppBundle\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class RegistrationForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, array(
                "label" => "Логин:",
                "attr" => array(
                    'class' => 'form-control'
                )
            ))
            ->add('plainPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'invalid_message' => 'Пароли не совпадают.',
                'error_bubbling' => true,
                'first_options'  => array(
                    'label' => 'Пароль:',
                    "attr" => array(
                        'class' => 'form-control'
                    )),
                'second_options' => array(
                    'label' => 'Повторите пароль:',
                    "attr" => array(
                        'class' => 'form-control'
                    ))
            ))
            ->add('submit',SubmitType::class, array(
                "label" => "ОК"
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => User::class,
        ));
    }
}