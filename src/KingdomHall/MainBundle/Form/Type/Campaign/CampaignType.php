<?php
/**
 * Created by PhpStorm.
 * User: gpetit
 * Date: 6/22/15
 * Time: 8:42 PM
 */

namespace KingdomHall\MainBundle\Form\Type\Campaign;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class CampaignType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'text', array(
            'label' => 'jwkh.entity.campaign.name',
        ));

        $builder->add(
            'startDate',
            'date',
            array (
                'widget' => 'single_text',
                'format' => 'dd-MM-yyyy',
                'label' => 'jwkh.entity.campaign.start_date',
                'attr' => array (
                    'class' => 'form-control input-inline datepicker',
                    'data-provide' => 'datepicker',
                    'data-date-format' => 'dd-mm-yyyy',
                ),
                'constraints' => array (
                    new NotBlank(),
                ),
            )
        );

        $builder->add(
            'endDate',
            'date',
            array (
                'widget' => 'single_text',
                'format' => 'dd-MM-yyyy',
                'label' => 'jwkh.entity.campaign.end_date',
                'attr' => array (
                    'class' => 'form-control input-inline datepicker',
                    'data-provide' => 'datepicker',
                    'data-date-format' => 'dd-mm-yyyy',
                ),
                'constraints' => array (
                    new NotBlank(),
                ),
            )
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'KingdomHall\DataBundle\Entity\Campaign',
            )
        );
    }

    public function getName()
    {
        return 'kingdomhall_form_campaign';
    }
}