<?php

namespace JobBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('userName',TextType::class)
            ->add('email',TextType::class)
            ->add('password', TextType::class,
                ['csrf_protection' => true]);

//           ->add(RepeatedType::class, [
//            'type' => PasswordType::class,
//            'invalid_message' => 'The password fields must match.',
//            'options' => ['attr' => ['class' => 'password-field']],
//            'required' => true,
//            'first_options'  => ['label' => 'Password'],
//            'second_options' => ['label' => 'Repeat Password'],
//        ]);
//            ->add('dateAdded', DateTimeType::class, [
//                'placeholder' => [
//                    'year' => 'Year', 'month' => 'Month', 'day' => 'Day',
//                    'hour' => 'Hour', 'minute' => 'Minute', 'second' => 'Second',
//                ]
    //        ]
    //);
    }
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'JobBundle\Entity\User'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'jobbundle_user';
    }


}
