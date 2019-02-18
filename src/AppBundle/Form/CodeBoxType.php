<?php

namespace AppBundle\Form;

use AppBundle\Entity\CodeBox;
use AppBundle\Entity\CodeBoxAccessForShifter;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CodeBoxType extends AbstractType
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, ['label' => 'Nom'])
            ->add('description', TextareaType::class, ['label' => 'Description'])
            ->add('enableAccessForShifter', CheckboxType::class, ['label' => 'Utilisé pour les créneaux', 'mapped' => false, 'required' => false]);

        $builder->add('accessForShifter', CodeBoxAccessForShifterType::class, ['label' => false]);

        $builder->addEventListener(FormEvents::POST_SET_DATA, function (FormEvent $event) {
            $form = $event->getForm();
            /** @var CodeBox $codeBoxData */
            $codeBoxData = $event->getData();

            $form->get('enableAccessForShifter')->setData($codeBoxData ? $codeBoxData->getAccessForShifter() !== null : false);
        });

        $builder->addEventListener(FormEvents::SUBMIT, function (FormEvent $event) {
            $form = $event->getForm();
            /** @var CodeBox $codeBoxData */
            $codeBoxData = $event->getData();

            $enable = $form->get('enableAccessForShifter')->getData();
            $accessForShifter = $codeBoxData->getAccessForShifter();

            if ($enable) {
                $accessForShifter->setCodeBox($codeBoxData);
                $this->em->persist($accessForShifter);
            } else if ($accessForShifter) {
                $accessForShifter->setCodeBox(null);
                $this->em->remove($accessForShifter);
            }

        });
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => CodeBox::class
        ));
    }
}