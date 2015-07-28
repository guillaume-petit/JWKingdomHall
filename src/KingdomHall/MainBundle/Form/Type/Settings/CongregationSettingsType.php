<?php
/**
 * Created by PhpStorm.
 * User: gpetit
 * Date: 7/28/15
 * Time: 2:35 PM
 */

namespace KingdomHall\MainBundle\Form\Type\Settings;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CongregationSettingsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('settings', 'collection', array (
            'type' => 'kingdomhall_form_congregation_setting',
        ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array (
                'data_class' => 'KingdomHall\DataBundle\Entity\Congregation',
            )
        );
    }


    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'kingdomhall_form_congregation_settings';
    }
}