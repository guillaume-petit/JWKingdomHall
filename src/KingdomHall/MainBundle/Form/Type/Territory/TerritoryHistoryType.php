<?php
/**
 * Created by PhpStorm.
 * User: gpetit
 * Date: 6/22/15
 * Time: 8:42 PM
 */

namespace KingdomHall\MainBundle\Form\Type\Territory;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TerritoryHistoryType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('publisher', 'entity', array(
            'class' => 'KingdomHall\DataBundle\Entity\Publisher',
            'label' => 'jwkh.entity.publisher.entity',
            'choice_label' => 'fullName',
        ));
        $builder->add(
            'borrowDate',
            'datetime',
            array (
                'widget' => 'single_text',
                'format' => 'dd-MM-yyyy',
                'attr' => array (
                    'class' => 'form-control input-inline datepicker',
                    'data-provide' => 'datepicker',
                    'data-date-format' => 'dd-mm-yyyy',
                ),
            )
        );
        $builder->add(
            'returnDate',
            'datetime',
            array (
                'widget' => 'single_text',
                'format' => 'dd-MM-yyyy',
                'attr' => array (
                    'class' => 'form-control input-inline datepicker',
                    'data-provide' => 'datepicker',
                    'data-date-format' => 'dd-mm-yyyy',
                ),
            )
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'KingdomHall\DataBundle\Entity\TerritoryHistory',
            )
        );
    }

    public function getName()
    {
        return 'kingdomhall_form_territory_history';
    }
}