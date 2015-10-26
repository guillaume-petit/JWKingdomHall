<?php
/**
 * Created by PhpStorm.
 * User: gpetit
 * Date: 6/22/15
 * Time: 8:42 PM
 */

namespace KingdomHall\MainBundle\Form\Type\Territory;


use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ForwardTerritoryType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('publisher', 'entity', array(
            'class' => 'KingdomHall\DataBundle\Entity\Publisher',
            'label' => 'jwkh.entity.publisher.entity',
            'expanded' => false,
            'multiple' => false,
            'property' => 'fullName',
            'query_builder' =>
                function(EntityRepository $er) {
                    return $er->createQueryBuilder('p')->where('p.deleted = false')->orderBy('p.lastName');
                },
        ));
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
        return 'kingdomhall_form_forward_territory';
    }
}