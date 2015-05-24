<?php

class Application_Form_Addusertogroup extends Zend_Form
{

    public function init()
    {
        $email = new Zend_Form_Element_Text('email');
        $email->addValidator('EmailAddress');
        $email->addValidator(new Zend_Validate_Db_RecordExists(
            array(
                "table" => 'users',
                'field' => 'email'
            )
        ));
        $email->getValidator('Db_RecordExists')->setMessage("Użytkownik nie istnieje!");
        $email->setLabel('E-mail użytkownika')->setRequired(true);
        $button = new Zend_Form_Element_Submit('submit');
        $button->setLabel('Dodaj');
        $this->addElements(array($email,$button));
    }


}

