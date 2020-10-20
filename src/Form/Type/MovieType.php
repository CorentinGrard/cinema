<?php

namespace App\Form\Type;

use App\Entity\Category;
use App\Entity\Person;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class MovieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, ['required' => true,])
            ->add('category', EntityType::class, [
                'required' => true,
                'class' => Category::class,
                'choice_label' => 'name',
            ])
            ->add('realisator', EntityType::class, [
                'required' => true,
                'class' => Person::class,
                'placeholder' => 'Choose a realisator',
                'choice_label' => function ($person) {
                    return $person->getFirstName() . " " . $person->getLastName();
                },
            ])
            ->add('casting', EntityType::class, [
                'required' => true,
                'class' => Person::class,
                'placeholder' => 'Choose a casting',
                'choice_label' => function ($person) {
                    return $person->getFirstName() . " " . $person->getLastName();
                },
                'multiple' => true,
            ])
            ->add('releaseDate', DateType::class, ['required' => true, 'years' => range(date('Y') - 100, date('Y')),])
            ->add('description', TextType::class, ['required' => true, 'constraints' => [new Length(['min' => 5]), new Length(['max' => 100])]])
            ->add('save', SubmitType::class);
    }
}
