<?php

namespace App\Form;

use App\Entity\People;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PeopleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name',TextType::class, array(
                'label'  => 'Nome',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control',
                ),
                'label_attr' => array(
                    'class' => 'col-form-label',
                ),
            ))
            ->add('lastName',TextType::class, array(
                'label'  => 'Sobrenome',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control',
                ),
                'label_attr' => array(
                    'class' => 'col-form-label',
                ),
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => People::class,
        ]);
    }
}