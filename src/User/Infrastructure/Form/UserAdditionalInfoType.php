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
        $builder->add('firstName', TextType::class)
            ->add('lastName', TextType::class)
            ->add('phoneNumber', IntegerType::class)
            ->add('addresses', CollectionType::class, [
                'entry_type' => AddressType::class,
            ])
            ->add('submit', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UserAdditionalInfo::class
        ]);
    }
}