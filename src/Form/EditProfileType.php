<?php

namespace App\Form;

use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, ['attr' => ['class' =>'form-control']])            
            ->add('name', TextType::class, ['attr' => ['class' =>'form-control']])
            ->add('firstname', TextType::class, ['attr' => ['class' =>'form-control']])          
            ->add('Valider', SubmitType::class, ['attr' => ['class' =>'btn shadow-3 rounded-1 small blue dark-3 bd-1 bd-solid bd-black  uppercase mt-3 mr-4']]) 
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
        ]);
    }
}
