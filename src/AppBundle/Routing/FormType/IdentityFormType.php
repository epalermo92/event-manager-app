<?php


namespace AppBundle\Routing\FormType;

use Symfony\Component\Form\AbstractType;
//use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class IdentityFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', TextType::class, [
            'label' => 'Nome',
            'required' => true,
        ]);

        $builder->add('surname', TextType::class, [
            'label' => 'Cognome',
            'required' => true,
        ]);

        $builder->add('codiceFiscale', TextType::class, [
            'label' => 'codiceFiscale',
            'required' => true,
        ]);

//        $builder->add('type', ChoiceType::class, [
//            'label' => 'Persona',
//            'choices' => [
//                'Natural' => 'natural',
//                'Legal' => 'legal',
//            ],
//            'placeholder' => 'Add type',
//            'required' => true,
//        ]);
    }
}
