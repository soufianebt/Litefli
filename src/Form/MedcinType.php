<?php

namespace App\Form;

use App\Entity\Medcin;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MedcinType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomComplet')
            ->add('username')
            ->add('email')
            ->add('mdp')
            ->add('typeCompte', null, array(
     'required'   => false,
     'empty_data' => 'medcin',
     
))
            ->add('codePostal')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Medcin::class,
        ]);
    }
}
