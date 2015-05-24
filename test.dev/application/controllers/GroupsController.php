<?php

class GroupsController extends Zend_Controller_Action
{

    private static $_userData = null;

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
        echo $this->_userData->id;
    }


    public function addAction()
    {
        $form = new Application_Form_Addgroup();
        $request = $this->getRequest();
        if($request->isPost() && $form->isValid($request->getPost()))
        {
            $groupDb = new Application_Model_DbTable_Groups();
            $groupDb->addGroups($this->_userData->id,$form->getValue('groupName'));
        }
        $this->view->form = $form;
    }

    public function editAction()
    {
        // action body
    }

    public function listAction()
    {
        $groups = new Application_Model_DbTable_Groups();
        $grList = $groups->listOfGroups($this->_userData->id);
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $this->getResponse()
            ->setHeader('Content-Type', 'application/json');
        header('Content-type: application/json');
        echo Zend_Json::encode($grList);
    }

    public function deleteAction()
    {
        // action body
    }

    public function adduserAction()
    {
        $form = new Application_Form_Addusertogroup();
        $request = $this->getRequest();
        $grData = new Zend_Session_Namespace('grupa');
        $grName = $grData->name;

        if($grName == null) $this->redirect('/messages/index');
        if($request->isPost() && $form->isValid($request->getPost()))
        {
            $grDb = new Application_Model_DbTable_Groups();
            $usDb = new Application_Model_DbTable_Users();
            $inDb = new Application_Model_DbTable_InGroup();
            $isIn = $inDb->isIn($usDb->getId($form->getValue('email')),$grDb->getId($grName));
            if($isIn)
            {
                echo $this->view->errorMessage = 'Użytkowanik jest już w grupie';
            }else{
                $inDb->save($usDb->getId($form->getValue('email')),$grDb->getId($grName));
                echo $this->view->errorMessage = 'Użytkowanik dodany do grupy<br />';
            }

        }
        echo $this->view->form = $form;
    }


}











