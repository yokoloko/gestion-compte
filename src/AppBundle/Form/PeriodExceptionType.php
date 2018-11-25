<?php

namespace AppBundle\Form;

use AppBundle\Entity\Job;
use AppBundle\Entity\PeriodException;
use AppBundle\Entity\PeriodExceptionReason;
use AppBundle\Entity\PeriodPosition;
use AppBundle\Entity\PeriodRoom;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Validator\Constraints\NotBlank;

class PeriodExceptionType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type', ChoiceType::class, array(
                'label' => 'Type',
                'choices' => array(
                    'Exclusion' => PeriodException::TYPE_EXCLUSION,
                    'Créneau supplémentaire' => PeriodException::TYPE_ADD
                ),
                'attr' => array(
                    'onchange' => 'typeUpdated(this)',
                )
            ))
            ->add('recurrence', ChoiceType::class, array(
                'label' => 'Répétition',
                'choices' => array(
                    'Une seule fois' => PeriodException::RECURRENCE_NONE,
                    'Annuel' => PeriodException::RECURRENCE_YEARLY,
                    'Mensuel' => PeriodException::RECURRENCE_MONTHLY,
                    'Hebdomadaire' => PeriodException::RECURRENCE_WEEKLY,
                    'Quotidien' => PeriodException::RECURRENCE_DAILY,
                )
            ))
            ->add('job', EntityType::class, array(
                'label' => 'Type de créneau',
                'class' => Job::class,
                'label_attr' => array(
                    'class' => 'add-only'
                ),
                'attr' => array(
                    'class' => 'add-only'
                ),
                'required' => false,
            ))
            ->add('startDate', DateTimeType::class, array(
                'label' => 'Début',
                'input'  => 'datetime',
                'date_widget' => 'single_text',
                'time_widget' => 'single_text',
            ))
            ->add('endDate', DateTimeType::class, array(
                'label' => 'Fin',
                'input'  => 'datetime',
                'date_widget' => 'single_text',
                'time_widget' => 'single_text',
            ))
            ->add('reason', EntityType::class, array(
                'label' => 'Raison',
                'class' => PeriodExceptionReason::class
            ));

        $builder->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) {
            /** @var PeriodException $exception */
            $exception = $event->getForm()->getData();
            if ($exception) {
                if (!$exception->getEndDate()) {
                    $exception->setEndDate($exception->getStartDate());
                }
            }
        });
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\PeriodException'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_period_exception';
    }
}
