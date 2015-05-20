<?php

class Application_Form_Adduser extends Zend_Form
{

    public function init()
    {
        $this->setMethod('post');
        $this->addElement('text','fname',array('label'=>'Imie',
                                               'required'=>true,
                                                'filters'=>array('StringTrim')
                                                //'placeholder'=>'Imię',
                                                ));
        $this->addElement('text','lname',array('label'=>'Nazwisko',
                                                'required'=>true,
                                                 'filters'=>array('StringTrim')
                                                ));
        $this->addElement('text','email',array('label'=>'Adres e-mail:',
                                                'required'=>true,
                                                'filters'=>array('StringTrim'),
                                                 'validators' => array('EmailAddress')
                                                ));
        $this->addElement('text','telnum',array('label'=>'Numer Telefonu','filters'=>array('StringTrim'),));
        $this->addElement('password','password',array('label'=>'Haslo','required'=>true,'filters'=>array('StringTrim')));
        $this->addElement('text','adr1',array('label'=>'adres','filters'=>array('StringTrim')));
        $this->addElement('text','adr2',array('label'=>'adres','filters'=>array('StringTrim')));
        $this->addElement('select','country',array('label'=>'Kraj',"multiOptions"=>array("Poland"=>"Poland","Anywhere"=>"Anywhere")));  
        $this->addElement('captcha', 'captcha', array(
            'label'      => 'Prosze wprodzic 5 liter pokazanych ponizej:',
            'required'   => true,
            'captcha'    => array(
                'captcha' => 'Figlet',
                'wordLen' => 5,
                'timeout' => 300
            )
        ));
        $this->addElement('submit','submit',array('label'=>'Rejestruj'));
    }


}

