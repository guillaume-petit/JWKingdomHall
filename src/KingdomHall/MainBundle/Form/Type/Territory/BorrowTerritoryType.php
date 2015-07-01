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
use Symfony\Component\Validator\Constraints\NotBlank;

class BorrowTerritoryType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('publisher', 'entity', array(
            'class' => 'KingdomHall\DataBundle\Entity\Publisher',
            'label' => 'jwkh.entity.publisher.entity',
            'expanded' => false,
            'multiple' => false,
            'choice_label' => 'fullName',
        ));
        $builder->add(
            'borrowDate',
            'date',
            array (
                'widget' => 'single_text',
                'format' => 'dd-MM-yyyy',
                'label' => 'jwkh.entity.territory.borrow_date',
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
                'data_class' => 'KingdomHall\DataBundle\Entity\Territory',
            )
        );
    }

    public function getName()
    {
        return 'kingdomhall_form_borrow_territory';
    }
}