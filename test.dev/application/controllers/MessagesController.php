<?php

class MessagesController extends Zend_Controller_Action
{
    private static $_userData;

    private function getForm($destination)
    {
        $form = new Zend_Form();
        $form->setAction($destination);
        $form->setMethod('post');
        $tekst = new Zend_Form_Element_Textarea('usermessage');
        $tekst->setValue($destination)->setLabel("Treść Wiadomości")
            ->isRequired(true);
        $tekst->setAttribs(array("rows"=>"5","value"));
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Wyślij');
        $form->addElements(array($tekst,$submit));
        return $form;
    }

    public function init()
    {

        $this->_userData = new Zend_Session_Namespace('userData');
        $auth = Zend_Auth::getInstance();
        $logged = $auth->hasIdentity();
        if(!$logged)
        {
            $this->redirect("users/login");
        }
    }

    public function indexAction()
    {

        $grupa = $this->getRequest()->getParam("grupa");
        $this->inGroup($grupa,$this->_userData->id);
    }
    /**
     * TODO
     * Do poprawy
    **/
    public function addAction()
    {
        $grupa = $this->getRequest()->getParam("grupa");
        $this->inGroup($grupa,$this->_userData->id);
        $form = new Application_Form_Addmessage("messages/add/grupa/"+$grupa);
        $request = $this->getRequest();
        $form->setAction("messages/add/grupa/"+$grupa);
        if($request->isPost()&&$form->isValid($request->getPost())){}
        echo $this->view->form = $form;
        $this->render('form');
    }

    public function deleteAction()
    {
        // action body
    }

    public function listAction()
    {
        $grupa = $this->getRequest()->getParam("grupa");
        $this->inGroup($grupa,$this->_userData->id);

        echo $this->view->form = $this->getForm("messages/add/grupa/"+$grupa);
    }

    public function editAction()
    {
        // action body
    }

    private function inGroup($groupName,$userId)
    {
        if($groupName == NULL) $this->redirect('groups/list');
        $group = new Application_Model_DbTable_Groups();
        $result = $group->inGroup($groupName,$userId);
        if(!$result)
        {
            $this->redirect("groups/list/error/non");
        }

    }

}