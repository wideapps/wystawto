<?php

namespace AppBundle\Form\Type;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

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
        ))->add('fullname', TextType::class, array(
            'label' => 'Imię i nazwisko'
        ))->add('phone', TextType::class, array(
            'label' => 'Telefon',
            'required' => false
        ))->add('email', TextType::class, array(
            'label' => 'E-mail'
        ))->add('city', TextType::class, array(
            'label' => 'Miasto',
            'attr' => array('autocomplete' => 'off')
        ))->add('price', MoneyType::class, array(
            'label' => 'Cena',
            'currency' => 'PLN'
        ))->add('toNegotiate', CheckboxType::class, array(
            'label' => 'Do negocjacji',
            'required' => false
        ))->add('submit', SubmitType::class, array(
            'label' => 'Dodaj',
            'attr' => array('class' => 'btn btn-success')
        ));
    }
}