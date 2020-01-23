<?php

namespace App\Form;
use App\Entity\Trails;
use App\Form\AlbumType;
use App\Entity\PhotoAlbum;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;




class UploadType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', TextType::class, [
              'required' => false,
                'attr' => [
                  'placeholder' => 'Mont Blanc',
                ]
              ])   
              ->add('image', FileType::class, array(
                'data_class' => null,
                'required' => false,
                'attr' => [
                  'label' => "Image",
                  'block_name'   => 'file',
              ]
              ))         
            ->add('niveau', ChoiceType::class, [
              'required' => false,
              'choices' => [
                '1' => 1,
                '2' => 2,
                '3' => 3,
                '4' => 4,
              ]
                // 'attr' => [
                //   'placeholder' => '4',
                // ]
              ])   
            ->add('denivele', TextType::class, [
              'required' => false,
                'label' => 'Dénivelée',
                'attr' => [
                  'placeholder' => 'Ex : 100 (unité mètre)',
                ]
              ])   
            ->add('altitude_de_depart', TextType::class, [
              'required' => false,
                'label' => 'Altitude de départ',
                'attr' => [
                  'placeholder' => 'Ex : 1200 (unité mètre)',
                ]
              ])   
            ->add('altitudedarrivee', TextType::class, [
              'required' => false,
                'label' => 'Altitude d\'arrivée',
                'attr' => [
                  'placeholder' => 'Ex : 2300 (unité mètre)',
                ]
              ])   
            ->add('tempsalamontee', TextType::class, [
              'required' => false,
                'label' => 'Temps à la montée',
                'attr' => [
                  'placeholder' => 'Ex : 120 (unité minute)',
                ]
              ])   
            ->add('tempsaladescente', TextType::class, [
              'required' => false,
                'label' => 'Temps à la descente',
                'attr' => [
                  'placeholder' => 'Ex : 100 (unité minute)',
                ]
              ])   
            ->add('tempstotal', TextType::class, [
              'required' => false,
                'label' => 'Temps total',
                'attr' => [
                  'placeholder' => 'EX : 220 (unité minute)',
                ]
              ])   
            ->add('description')
            ->add('gpx', FileType::class, array(
              'data_class' => null,
              'required' => false,
              'attr' => [
                // 'label' => "Image",
                'block_name'   => 'file',
            ]
            ))   
            ->add ('album' , CollectionType::class, [
              'label' => false,
                'entry_type' => AlbumType::class ,
                'allow_add' => true,
                ])
   
            ->add('envoyer', SubmitType::class)
        ;
    }

 

    public function configureOptions(OptionsResolver $resolver)
    {
        
        $resolver->setDefaults([
            'data_class' => Trails::class,
        ]);
    }
}
