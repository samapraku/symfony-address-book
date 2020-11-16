<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class, [
            'attr' => [
                'class' => 'form-control form-control-sm',
            ]
            ])
            ->add('lastName', TextType::class, [
                'attr' => [
                    'class' => 'form-control form-control-sm',
                ]
                ])
            ->add('streetName', TextType::class, [
                'attr' => [
                    'class' => 'form-control form-control-sm',
                ]
                ])
            ->add('streetNumber', TextType::class, [
                'attr' => [
                    'class' => 'form-control form-control-sm col-sm-2',
                ]
                ])
            ->add('zip', TextType::class, [
                'attr' => [
                    'class' => 'form-control form-control-sm col-sm-4',
                ]
                ])
            ->add('city', TextType::class, [
                'attr' => [
                    'class' => 'form-control form-control-sm',
                ]
                ])
            ->add('country', CountryType::class, [
                'preferred_choices' => ['DE'],
                'label' => 'Country',
                'attr' => [
                    'class' => 'form-control form-control-sm',
                ],
                'label_attr' => [
                    'class' => 'col-sm-2 col-form-label'
                ],
            ])
            ->add('phoneNumber', TelType::class, [
                'attr' => [
                    'class' => 'form-control form-control-sm',
                ]
                ])
            ->add('birthDay', BirthdayType::class, [
                'attr' => [
                    'class' => 'form-control form-control-sm',
                ],
                'required' => true,
                'label' => 'Date of Birth',
                'widget' => 'single_text',                 
                'empty_data' => ''
            ])
            ->add('emailAddress', EmailType::class, [
                'attr' => [
                    'class' => 'form-control form-control-sm',
                ]
                ])
            ->add('picture', FileType::class, [
                'required' => false
            ]
            );

            $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
                $contact = $event->getData();
                $form = $event->getForm();
                if (!$contact || null === $contact->getId()) {
                    $submitText = "Add new address";
                }
                else $submitText = "Update";
                $form->add('submit', SubmitType::class, [
                    'label' => $submitText
                ]);
            });
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}