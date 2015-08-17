<?php
/**
 * Created by PhpStorm.
 * User: gpetit
 * Date: 8/11/15
 * Time: 10:55 AM
 */

namespace KingdomHall\UserBundle\Form\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserProfileLightType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('username', 'text', array ('label' => 'jwkh.entity.user.username'));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array (
                'data_class' => 'KingdomHall\UserBundle\Entity\User',
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
        return 'user_profile_light';
    }
}