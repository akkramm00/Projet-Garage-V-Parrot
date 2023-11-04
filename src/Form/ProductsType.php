<?php

namespace App\Form;

use App\Entity\Products;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints as Assert;

class ProductsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Marque', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlength' => '2',
                    'maxlength' => '50'
                ],
                'label' => 'Marque',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'constraints' => [
                    new Assert\Length(['min' => 2, 'max' => 50]),
                    new Assert\NotBlank()
                ]
            ])
            ->add('Model', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlength' => '2',
                    'maxlength' => '50'
                ],
                'label' => 'Model',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'constraints' => [
                    new Assert\Length(['min' => 2, 'max' => 50]),
                    new Assert\NotBlank()
                ]
            ])
            ->add('Prix', MoneyType::class, [
                'attr' => [
                    'class' => 'form-control',
                ],
                'label' => 'Prix',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'constraints' => [
                    new Assert\Positive(),
                    new Assert\NotBlank()
                ]
            ])
            ->add('Boite', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlength' => '2',
                    'maxlength' => '50'
                ],
                'label' => 'Boite',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'constraints' => [
                    new Assert\Length(['min' => 2, 'max' => 50]),
                    new Assert\NotBlank()
                ]
            ])
            ->add('Energie', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlength' => '2',
                    'maxlength' => '50'
                ],
                'label' => 'Energie',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'constraints' => [
                    new Assert\Length(['min' => 2, 'max' => 50]),
                    new Assert\NotBlank()
                ]
            ])
            ->add('Puissance', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlength' => '2',
                    'maxlength' => '50'
                ],
                'label' => 'Puissance',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'constraints' => [
                    new Assert\Length(['min' => 2, 'max' => 50]),
                    new Assert\NotBlank()
                ]
            ])
            ->add('description', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlength' => '2',
                    'maxlength' => '255'
                ],
                'label' => 'Description',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'constraints' => [
                    new Assert\Length(['min' => 2, 'max' => 255]),
                    new Assert\NotBlank()
                ]
            ])
            ->add('imageFile', FileType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Image du produit',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ]
            ])
            ->add('isPublic', CheckboxType::class, [
                'attr' => [
                    'class' => 'form-check-input',
                ],
                'label' => 'Public',
                'label_attr' => [
                    'class' => 'form-check-label'
                ],
                'constraints' => [
                    new Assert\NotNull()
                ],
                'required' => true
            ])
            ->add('submit', submitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary mt-4'
                ],
                'label' => 'Créer un nouveau produit'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Products::class,
        ]);
    }
}
