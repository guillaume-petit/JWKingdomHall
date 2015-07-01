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

class TerritoryType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('type', 'choice', array(
            'expanded' => false,
            'multiple' => false,
            'choices' => array (
                'standard' => 'jwkh.entity.territory.standard',
                'campaign' => 'jwkh.entity.territory.campaign',
            ),
            'label' => 'jwkh.entity.territory.type',
        ));
        $builder->add('number', 'integer', array('label' => 'jwkh.entity.territory.number',));
        $builder->add('name', 'text', array('label' => 'jwkh.entity.territory.name',));
        $builder->add('area', 'text', array('label' => 'jwkh.entity.territory.area',));
        $builder->add('mapFile', 'file', array('label' => 'jwkh.entity.territory.map',));
        $builder->add('phone', 'checkbox', array('label' => 'jwkh.entity.territory.phone',));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'KingdomHall\DataBundle\Entity\Territory',
            )
        );
    }

    public function getName()
    {
        return 'kingdomhall_form_territory';
    }
}