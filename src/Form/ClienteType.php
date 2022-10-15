<?php

namespace App\Form;

use App\Entity\Cliente;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClienteType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' =>Cliente::class]);
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nombre', TextType::class)
            ->add('apellidos', TextType::class)
            ->add('telefono', TextType::class);

    }

    // Por defecto le pone un nombre al formulario

    public function getBlockPrefix()
    {
        return '';
    }
    public function getName(){
        return '';
    }
}