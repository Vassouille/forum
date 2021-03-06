<?php

namespace AppBundle\Form;

use Gregwar\CaptchaBundle\Type\CaptchaType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('forename', null, array('label' => 'form.forename', 'required' => false))
            ->add('name', null, array('label' => 'form.name', 'required' => false))
            ->add('age', null, array('label' => 'form.age', 'required' => false))
            ->add('city', null, array('label' => 'form.city', 'attr' => ['class' => 'typeahead'], 'required' => false))
            ->add('captcha', CaptchaType::class)
        ;
    }

    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';
    }

    public function getBlockPrefix()
    {
        return 'app_user_registration';
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'translation_domain' => 'FOSUserBundle'
        ));
    }
}