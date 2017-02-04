<?php
namespace UserBundle\Form;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use UserBundle\Entity\UserInvoiceData;

class InvoiceDataType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fullname', TextType::class, array(
                'label' => 'Nazwa firmy'
            ))->add('address', TextType::class, array(
                'label' => 'Adres'
            ))->add('postcode', TextType::class, array(
                'label' => 'Kod pocztowy'
            ))->add('city', TextType::class, array(
                'label' => 'Miasto'
            ))->add('nip', TextType::class, array(
                'label' => 'NIP',
                'required' => false
            ))->add('submit', SubmitType::class, array(
                'label' => 'Zapisz',
                'attr' => array(
                    'class' => 'btn-success'
                )
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => UserInvoiceData::class,
        ));
    }
}