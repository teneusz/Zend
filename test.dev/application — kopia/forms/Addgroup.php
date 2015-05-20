<?php

class Application_Form_Addgroup extends Zend_Form
{

    public function init()
    {
        $this->setMethod("post");
        $groupName = new Zend_Form_Element_Text('groupName');
        $groupName->setLabel('Nazwa Grupy')
            ->isRequired(true);
        $groupName->addValidator(new Zend_Validate_Db_NoRecordExists(
            array(
                "table" => 'groups',
                'field' => 'nameGroup'
            )
        ));
        $groupName->getValidator('Db_NoRecordExists')->setMessage("Ta nazwa jest już zajęta");
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Dodaj grupę');
        $this->addElements(array($groupName,$submit));

    }


}

