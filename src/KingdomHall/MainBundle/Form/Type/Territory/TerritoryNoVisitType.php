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

class TerritoryNoVisitType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'text', array('label' => 'jwkh.entity.territory_no_visit.name',));
        $builder->add('address', 'text', array('label' => 'jwkh.entity.territory_no_visit.address',));
        $builder->add('publisher', 'entity', array(
            'class' => 'KingdomHall\DataBundle\Entity\Publisher',
            'label' => 'jwkh.entity.publisher.entity',
            'choice_label' => 'fullName',
            'placeholder' => 'jwkh.entity.publisher.placeholder',
        ));
        $builder->add(
            'date',
            'datetime',
            array (
                'widget' => 'single_text',
                'format' => 'dd-MM-yyyy',
                'attr' => array (
                    'class' => 'form-control input-inline datepicker',
                    'data-provide' => 'datepicker',
                    'data-date-format' => 'dd-mm-yyyy',
                ),
                'data' => new \DateTime(),
            )
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'KingdomHall\DataBundle\Entity\TerritoryNoVisit',
            )
        );
    }

    public function getName()
    {
        return 'kingdomhall_form_territory_no_visit';
    }
}