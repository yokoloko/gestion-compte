<?php

namespace AppBundle\Form;

use AppBundle\Entity\CodeBox;
use AppBundle\Entity\CodeBoxAccessByCode;
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

class CodeBoxAccessByCodeType extends AbstractType
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
            ->add('code', TextType::class, ['label' => 'Code']);

        $builder->addEventListener(FormEvents::POST_SET_DATA, function (FormEvent $event) {
            $form = $event->getForm();
            /** @var CodeBoxAccessByCode $codeBoxAccessByCodeData */
            $codeBoxAccessByCodeData = $event->getData();

            if ($codeBoxAccessByCodeData && !$codeBoxAccessByCodeData->getCode()) {
                $codeValue = rand(0, 9999);
                $codeValueString = str_pad(intval($codeValue), 4, '0', STR_PAD_LEFT);
                $form->get('code')->setData($codeValueString);
            }
        });
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => CodeBoxAccessByCode::class
        ));
    }
}