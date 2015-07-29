<?php
/**
 * Created by PhpStorm.
 * User: gpetit
 * Date: 7/29/15
 * Time: 9:41 AM
 */

namespace KingdomHall\MainBundle\Form\Type\Publisher;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PublisherType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('lastName', 'text', array ('label' => 'jwkh.entity.publisher.last_name'));
        $builder->add('firstName', 'text', array ('label' => 'jwkh.entity.publisher.first_name'));
        $builder->add('email', 'email', array ('label' => 'jwkh.entity.publisher.email'));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array (
                'data_class' => 'KingdomHall\DataBundle\Entity\Publisher',
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
        return "kingdomhall_form_publisher";
    }
}