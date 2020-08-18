<?php

namespace App\Form;

use App\Entity\Intervenant;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class IntervenantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('datePassage', DateTimeType::class, [
                'widget' => 'single_text'
            ])
            ->add('heureFin', DateTimeType::class, [
                'widget' => 'single_text'
            ])
            ->add('sujet', TextType::class)
            ->add('contenu', TextareaType::class)
            ->add('nickname', TextType::class)
            ->add('biographie', TextareaType::class)
        
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Intervenant::class,
        ]);
    }
}
