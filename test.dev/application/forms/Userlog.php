<?php

class Application_Form_Userlog extends Zend_Form
{

    public function init()
    {
        $this->setMethod('post');
        $email = new Zend_Form_Element_Text('email');
        $email->setLabel('Email')
              ->setRequired(true)
              ->addValidator('EmailAddress');
        $password = new Zend_Form_Element_Password('password');
        $password->setLabel('Password')
                ->setRequired(true);
        $button = new Zend_Form_Element_Submit('submit');
        $button->setLabel('login');
        $this->addElements(array($email,$password,$button));
        
    }


}

