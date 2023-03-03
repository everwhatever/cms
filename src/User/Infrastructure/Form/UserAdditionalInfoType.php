<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Form;


use App\User\Domain\Model\Address;
use App\User\Domain\Model\UserAdditionalInfo;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserAdditionalInfoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('firstName', TextType::class, [
            'label' => "Imię"
        ])
            ->add('lastName', TextType::class, [
                'label' => 'Nazwisko'
            ])
            ->add('phoneNumber', IntegerType::class, [
                'label' => 'Numer tel'
            ])
            ->add('addresses', CollectionType::class, [
                'entry_type' => AddressType::class,
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Zaktualizuj'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UserAdditionalInfo::class
        ]);
    }
}