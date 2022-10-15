<?php

namespace App\Form;

use App\Entity\Categoria;
use App\Entity\Municipios;
use App\Entity\Restaurante;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RestauranteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombre', TextType::class)
            ->add('logo_url', TextType::class)
            ->add('imagen_url', TextType::class)
            ->add('descripcion', TextType::class)
            ->add('destacado', IntegerType::class)
            ->add('categorias', EntityType::class,
                ['class'=> Categoria::class])
            ->add('municipio', EntityType::class,
                ['class'=> Municipios::class])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Restaurante::class,
        ]);
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
