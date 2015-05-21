<?php

class Application_Form_Addmessage extends Zend_Form
{

    public function init()
    {
        $this->setAction('add');
        $this->setMethod('post');
        $text = new Zend_Form_Element_Textarea('usermessage');
        $text->setLabel("Treść Wiadomości:")
            ->isRequired(true);
        $text->setAttribs(array("rows"=>"5"));
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Wyślij');
        $this->addElements(array($text,$submit));

    }


}

