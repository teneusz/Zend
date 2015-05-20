<?php

class GroupsController extends Zend_Controller_Action
{
    private static $_userData;
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

    /**
     * TODO
     * Show form addgroup.php
     * Instance of class Application_Model_DbTable_Groups
     * Instance of class Application_Model_DbTable_InGroup
     */
    public function addAction()
    {
        $form = new Application_Form_Addgroup();
        $request = $this->getRequest();
        if($request->isPost() && $form->isValid($request->getPost()))
        {
            $groupDb = new Application_Model_DbTable_Groups();
            $groupDb->addGroups($this->_userData->id,$form->getValue('groupName'));//Error
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
        foreach($grList as $row)
        {
            echo $row['namegroup']."<br />";
        }
    }

    public function deleteAction()
    {
        // action body
    }


}









