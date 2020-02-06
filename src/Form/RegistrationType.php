<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;

class RegistrationType extends AbstractType
{
    private $userPassWordInterface;
    
    public function __construct(UserPasswordEncoderInterface $userPassWordInterface){
        $this->userPassWordInterface = $userPassWordInterface;
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addEventListener(FormEvents::SUBMIT, function(FormEvent $event){
            
            $user = $event->getData();
            $form = $event->getForm();

            if (!$user) {
                return;
            }
            $passWord = $this->userPassWordInterface->encodePassword($user, $user->getPlainPassword());
            $user->setPassWord($passWord);
        });
    }
    
    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';
    }
    
    public function getBlockPrefix()
    {
        return 'app_user_registration';
    }
}
