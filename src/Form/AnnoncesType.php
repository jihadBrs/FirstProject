<?php

namespace App\Form;

use App\Entity\Annonces;
use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Categories;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Doctrine\ORM\EntityRepository; 
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnnoncesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('title', TextType::class, [
            'label' => 'Title of TestType'
        ])
        ->add('content', TextareaType::class)
        ->add('courseFile', FileType::class, [ // Changer 'file' à 'courseFile'
            'label' => 'File',
            'required' => false,
        ])
        ->add('categorie', EntityType::class, [
            'class' => Categories::class,
            'query_builder' => function (EntityRepository $er) { // Use EntityRepository
                return $er->createQueryBuilder('c');
            },
            'choice_label' => 'name',
            'label' => 'Categories',
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Annonces::class,
        ]);
    }
}