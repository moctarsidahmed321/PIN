<?php

namespace App\Form;

use App\Entity\Page;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nouvelles', TextareaType::class)
            // J'ai fait une liste déroulante pour choisir s'il sagit d'une nouvelle ou d'une présentation
            ->add('type', ChoiceType::class, [
                'choices' => [
                    'Nouvelle' => Page::NOUVELLE,
                    'Présentation' => Page::PRESENTATION
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Page::class,
        ]);
    }
}
