<?php

namespace App\Form;

use App\Entity\Annonces;
use App\Entity\Categories;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class AnnoncesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, ['attr' => ['class' =>'form-control']])            
            ->add('content', TextareaType::class, ['attr' => ['class' =>'form-control']])
            ->add('categories', EntityType::class, [
                'class' => Categories::class,
                'attr' => ['class' =>'form-control']
            ])
            ->add('images', FileType::class, [
                'label' => 'ajouter des photos',
                'multiple' => true,
                'mapped' => false,
                'required' => false,
                'attr' => ['class' =>'form-control']
            ])
            ->add('Valider', SubmitType::class, ['attr' => ['class' =>'btn shadow-3 rounded-1 small blue dark-3 bd-1 bd-solid bd-black  uppercase mt-3 mr-4']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Annonces::class,
        ]);
    }
}
