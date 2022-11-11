<?php

namespace App\Form;

use App\Entity\Joueur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class JoueurType extends AbstractType
{
    //private $image = null;
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', TextType::class,[
                'label'=>"Nom d'utilisateur ",
            ])
            //->add('roles')
            ->add('password', PasswordType::class,[
                'label'=>'Mot de passe ',
            ])
            ->add('email', EmailType::class,[
                'required'=>false,
            ])
            ->add('img_Profil', FileType::class,[
                'required'=>false,
                'mapped'=>false,
                'label'=>'Image de profil ',
            ])
            ->add('img_Banniere', FileType::class,[
                'required'=>false,
                'mapped'=>false,
                'label'=>'Image de banniere ',
            ])
            //->add('classement')
           /*->add('submit', SubmitType::class,[
                'attr'=>[
                    'class'=>'btn btn-primary mt-4'
                ],
                'label'=>'Envoyer mon formulaire'
            ])*/
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Joueur::class,
        ]);
    }
}
