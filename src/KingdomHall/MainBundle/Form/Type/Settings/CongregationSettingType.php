<?php

namespace KingdomHall\MainBundle\Form\Type\Settings;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CongregationSettingType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addEventListener(FormEvents::POST_SET_DATA, array($this, 'addSetting'));
    }

    public function addSetting(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();

        $form->add('value', 'text', array ('label' => 'jwkh.entity.setting.'.$data->getCode()));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'KingdomHall\DataBundle\Entity\CongregationSetting',
            )
        );
    }

    public function getName()
    {
        return 'kingdomhall_form_congregation_setting';
    }
}