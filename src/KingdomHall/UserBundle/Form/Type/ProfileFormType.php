<?php

namespace KingdomHall\UserBundle\Form\Type;


use Doctrine\ORM\EntityRepository;
use KingdomHall\UserBundle\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;

class ProfileFormType extends AbstractType
{
    /** @var AuthorizationChecker $auth */
    protected $auth;

    public function __construct(AuthorizationChecker $auth)
    {
        $this->auth = $auth;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('plainPassword', 'repeated', array(
            'type' => 'password',
            'options' => array('translation_domain' => 'FOSUserBundle'),
            'first_options' => array('label' => 'form.new_password'),
            'second_options' => array('label' => 'form.new_password_confirmation'),
            'invalid_message' => 'fos_user.password.mismatch',
        ));
        $builder->remove('current_password');

        if ($this->auth->isGranted('ROLE_ADMIN')) {
            $builder->add('publisher', 'entity', array(
                'class' => 'KingdomHall\DataBundle\Entity\Publisher',
                'label' => 'jwkh.entity.publisher.entity',
                'expanded' => false,
                'multiple' => false,
                'property' => 'fullName',
                'query_builder' =>
                    function (EntityRepository $er) {
                        return $er->createQueryBuilder('p')->where('p.deleted = false');
                    },
            ));


            $builder->add('roles', 'collection', array(
                'label' => 'Role',
                'type' => 'choice',
                'options' => array(
                    'choices' => User::$ROLES,
                )
            ));
        }
    }

    public function getParent()
    {
        return 'fos_user_profile';
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'kingdomhall_user_profile';
    }
}