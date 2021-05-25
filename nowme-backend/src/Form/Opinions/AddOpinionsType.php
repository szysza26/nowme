<?php

namespace NowMe\Form\Opinions;

use NowMe\Entity\Opinions;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddOpinionsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('stars')
            ->add('content')
            ->add('user')
            ->add('specjalist')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Opinions::class,
        ]);
    }
}
