<?php

namespace App\Form;

use App\Entity\PhotoAlbum;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class AlbumType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('album', FileType::class, [
                'attr' => [
                  'placeholder' => 'Choose File',
                  'label' => 'Photo',
                ]
              ])
            // ->add('trails')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PhotoAlbum::class,
        ]);
    }
}
