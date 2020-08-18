<?php

namespace App\Form;

use App\Entity\Intervenant;
use App\Entity\Programme;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProgrammeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dateHeureDebut', DateTimeType::class,[
                'widget' => 'single_text',
            ])
            ->add('dateHeureFin', DateTimeType::class,[
                'widget' => 'single_text',
            ])
            ->add('intervenants', EntityType::class, [
                'class' => Intervenant::class,
                'multiple' => true,
            ])
            ->add('nomProgramme', TextType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Programme::class,
        ]);
    }
}
