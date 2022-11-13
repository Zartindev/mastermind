<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', TextType::class,[
                'attr'=>[
                    'class'=>'form-control',
                    'minlenght'=>'2',
                    'maxlenght'=>'50'
                ],
                'label'=>'pseudo',
                'label_attr'=>[
                    'class'=>'form-color'
                ]
            ])
            ->add('email', EmailType::class,[
                'attr'=>[
                    'class'=>'form-control',
                    'minlenght'=>'2',
                    'maxlenght'=>'180'
                ],
                'label'=>'email',
                'label_attr'=>[
                    'class'=>'form-color'
                ]#,
                #'contraints'=>[
                 #   new Assert\NotBlank(),
                  #  new Assert\Email(),
                   # new Assert\Length(['min'=>2,'max'=>180])]
            ])
            ->add('message',TextareaType::class,[
                'attr'=>[
                    'class'=>'form-control',
                    'minlenght'=>'2',
                    'maxlenght'=>'255'
                ],
                'label'=>'Votre message',
                'label_attr'=>[
                    'class'=>'form-color'
                ]
                #,'contraints'=>[new Assert\NotBlank(),]
            ])
            ->add('image',FileType::class,[
                'label'=>'Image ',
                'label_attr'=>[
                    'class'=>'form-color'
            ]])
            ->add('submit',SubmitType::class,[
                'attr'=>[
                    'class'=>'btn'
                ],
                'label'=>'Envoyer le formulaire'
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
