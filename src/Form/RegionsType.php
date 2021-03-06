<?php

namespace App\Form;

use App\Entity\Regions;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegionsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('departements', CollectionType::class, [
                'entry_type' => DepartementsType::class,
                'label' => 'Départements',
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false
            ])
            ->add('valider', SubmitType::class, ['attr' => ['class' =>'btn shadow-3 rounded-1 small blue bd-1 bd-solid bd-black  uppercase mt-3 mr-4']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Regions::class,
        ]);
    }
}
