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
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;




class UploadType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', TextType::class, [
                'attr' => [
                  'placeholder' => 'Mont Blanc',
                ]
              ])   
              ->add('image', FileType::class, [
                'label' => "Image",
                'block_name'   => 'file',

            ])         
            ->add('niveau', TextType::class, [
                'attr' => [
                  'placeholder' => '4',
                ]
              ])   
            ->add('denivele', TextType::class, [
                'label' => 'Dénivelée',
                'attr' => [
                  'placeholder' => '100',
                ]
              ])   
            ->add('altitude_de_depart', TextType::class, [
                'label' => 'Altitude de départ',
                'attr' => [
                  'placeholder' => '1200',
                ]
              ])   
            ->add('altitudedarrivee', TextType::class, [
                'label' => 'Altitude d\'arrivée',
                'attr' => [
                  'placeholder' => '2300',
                ]
              ])   
            ->add('tempsalamontee', TextType::class, [
                'label' => 'Temps à la montée',
                'attr' => [
                  'placeholder' => '120',
                ]
              ])   
            ->add('tempsaladescente', TextType::class, [
                'label' => 'Temps à la descente',
                'attr' => [
                  'placeholder' => '100',
                ]
              ])   
            ->add('tempstotal', TextType::class, [
                'label' => 'Temps total',
                'attr' => [
                  'placeholder' => '220',
                ]
              ])   
            ->add('description')
         
            ->add ('album' , CollectionType::class, [
                'entry_type' => AlbumType::class ,
                'allow_add' => true,
                ])
            ->add('gpx', FileType::class)
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
