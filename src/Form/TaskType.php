<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class TaskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title', TextType::class, [
           'label' => 'Titulo'
        ])->add('content', TextareaType::class, [
            'label' => 'Descripción'
        ])->add('priority', ChoiceType::class, [
            'label' => 'Prioridad',
            'choices' => [
                'Alta' => 'Hight',
                'Media' => 'Medium',
                'Baja' => 'Low'
            ]
        ])->add('hours', NumberType::class, [
            'label' => 'Horas'
        ])->add('submit', SubmitType::class, [
            'label' => 'Guardar'
        ]);

    }
}