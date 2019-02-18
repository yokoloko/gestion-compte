<?php

namespace AppBundle\Form;

use AppBundle\Entity\CodeBoxAccessForShifter;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CodeBoxAccessForShifterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('afterDelay', IntegerType::class, ['label' => 'Délai avant'])
            ->add('beforeDelay', IntegerType::class, ['label' => 'Délai après'])
            ->add('canGenerate', CheckboxType::class,  ['label' => 'Code générable', 'required' => false, 'attr' => ['class' => '']])
            ->add('slug', TextType::class, ['label' => 'Slug']);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => CodeBoxAccessForShifter::class
        ));
    }
}