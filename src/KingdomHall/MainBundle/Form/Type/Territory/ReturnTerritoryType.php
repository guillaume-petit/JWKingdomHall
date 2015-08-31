<?php
/**
 * Created by PhpStorm.
 * User: gpetit
 * Date: 6/22/15
 * Time: 8:42 PM
 */

namespace KingdomHall\MainBundle\Form\Type\Territory;


use KingdomHall\MainBundle\Form\Validator\Constraints\TerritoryReturnDate;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class ReturnTerritoryType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'worked',
            'choice',
            array (
                'expanded' => true,
                'multiple' => false,
                'mapped' => false,
                'choices' => array (
                    'yes' => 'jwkh.common.yes',
                    'no' => 'jwkh.common.no'
                ),
                'data' => 'yes',
                'label' => 'jwkh.territories.return.worked',
            )
        );

        $builder->addEventListener(FormEvents::PRE_SET_DATA, array($this, 'addReturnDate'));
        $builder->addEventListener(FormEvents::PRE_SUBMIT, array($this, 'addReturnDate'));
    }

    public function addReturnDate(FormEvent $event)
    {
        $form = $event->getForm();
        $data = $event->getData();
        $constraints = array();
        if ($data && array_key_exists('worked', $data)) {
            if ($data['worked'] == 'yes') {
                $constraints = array (
                    new NotBlank(),
                );
            }
        }
        $form->add(
            'returnDate',
            'date',
            array (
                'widget' => 'single_text',
                'format' => 'dd-MM-yyyy',
                'attr' => array (
                    'data-provide' => 'datepicker',
                    'data-date-format' => 'dd-mm-yyyy',
                    'class' => 'input-inline datepicker',
                ),
                'constraints' => $constraints,
                'data' => null,
            )
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'KingdomHall\DataBundle\Entity\Territory',
                'constraints' => array (new TerritoryReturnDate()),
            )
        );
    }

    public function getName()
    {
        return 'kingdomhall_form_return_territory';
    }
}