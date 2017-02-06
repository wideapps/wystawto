<?php

namespace AdminBundle\Form\Type;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OfferType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title', TextType::class, array(
            'label' => 'Tytuł',
            'attr' => array(
                'placeholder' => 'Wpisz nazwę przedmiotu który chcesz sprzedać'
            )
        ))->add('description', TextareaType::class, array(
            'label' => 'Opis',
            'attr' => array(
                'placeholder' => 'Postaraj się jak najdokładniej opisać sprzedawany przedmiot'
            )
        ))->add('category', EntityType::class, array(
            'label' => 'Kategoria',
            'class' => 'AppBundle\Entity\Category',
            'choice_label' => 'title'
        ))->add('phone', TextType::class, array(
            'label' => 'Telefon',
            'required' => false
        ))->add('city', TextType::class, array(
            'label' => 'Miasto',
            'attr' => array('autocomplete' => 'off')
        ))->add('price', MoneyType::class, array(
            'label' => 'Cena',
            'currency' => 'PLN'
        ))->add('toNegotiate', CheckboxType::class, array(
            'label' => 'Do negocjacji',
            'required' => false
        ))->add('warranty', CheckboxType::class, array(
            'label' => 'Gwarancja',
            'required' => false
        ))->add('purchaseDate', DateType::class, array(
            'label' => 'Data zakupu',
            'required' => false
        ))->add('warrantyDate', DateType::class, array(
            'label' => 'Data końca gwarancji',
            'required' => false
        ))->add('stan', ChoiceType::class, array(
            'label' => 'Stan',
            'choices' => array(
                'Nowe' => 'Nowe',
                'Używane' => 'Używane'
            )
        ))->add('status', ChoiceType::class, array(
            'label' => 'Status',
            'choices' => array(
                'Do akceptacji' => 1,
                'Zaakceptowane' => 2
            )
        ))->add('submit', SubmitType::class, array(
            'label' => 'Zapisz',
            'attr' => array('class' => 'btn btn-success')
        ));

        if(!$options['user'])
        {
            $builder->add('email', TextType::class, array(
                'label' => 'E-mail'
            ))->add('fullname', TextType::class, array(
                'label' => 'Imię i nazwisko'
            ));
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'user' => null,
        ));
    }
}