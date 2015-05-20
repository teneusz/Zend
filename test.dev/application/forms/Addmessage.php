<?php

class Application_Form_Addmessage extends Zend_Form
{
    private $destination;

    public function init()
    {

        $this->setMethod('post');
        $tekst = new Zend_Form_Element_Textarea('usermessage');
        $tekst->setLabel("Treść Wiadomości")
            ->isRequired(true);
        $tekst->setAttribs(array("rows"=>"5"));
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Wyślij');
        $this->addElements(array($tekst,$submit));

    }


}

