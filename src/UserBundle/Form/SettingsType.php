<?php
namespace UserBundle\Form;

use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use UserBundle\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class SettingsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fullname', TextType::class, array(
                'label' => 'Imię i nazwisko'
            ))
            ->add('city', TextType::class, array(
                'label' => 'Miasto'
            ))
            ->add('email', EmailType::class)
            ->add('phone', TextType::class, array(
                'label' => 'Telefon',
                'required' => false
            ))
            ->add('birthdate', BirthdayType::class, array(
                'label' => 'Data urodzenia'
            ))
            ->add('submit', SubmitType::class, array(
                'label' => 'Zapisz',
                'attr' => array(
                    'class' => 'btn-success'
                )
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => User::class,
        ));
    }
}