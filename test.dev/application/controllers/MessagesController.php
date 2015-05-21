<?php

class MessagesController extends Zend_Controller_Action
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
        $groupSession = new Zend_Session_Namespace('grupa');
        $group = $this->getRequest()->getParam("grupa");
        $grupaDb = new Application_Model_DbTable_Groups();
        if($group == NULL)
        {
            $group = $groupSession->name;
            $this->inGroup($groupSession->name,$this->_userData->id);
        }else
        {
            $this->inGroup($group,$this->_userData->id);
            if($groupSession->isLocked())
                $groupSession->unlock();
            $groupSession->name = $group;
            $groupSession->id = $grupaDb->getId($group);
            $groupSession->lock();
        }
    }


    public function addAction()
    {
        $grupaSession = new Zend_Session_Namespace('grupa');
        $this->inGroup($grupaSession->name,$this->_userData->id);
        $answer = $this->getRequest()->getParam('answer');
        $form = new Application_Form_Addmessage();
        $request = $this->getRequest();
        if($request->isPost()&&$form->isValid($request->getPost())){
            $messDb = new Application_Model_DbTable_Messages();
            $messDb->save($this->_userData->id,$grupaSession->id,$form->getValue('usermessage'),$answer);
            $this->redirect('messages/list');
        }
        echo $this->view->form = $form;

    }

    public function deleteAction()
    {
        // action body
    }

    public function listAction()
    {
        $groupSession = new Zend_Session_Namespace('grupa');
        $group = $this->getRequest()->getParam("grupa");
        $grupaDb = new Application_Model_DbTable_Groups();
        if($group == NULL)
        {
            $group = $groupSession->name;
            $this->inGroup($groupSession->name,$this->_userData->id);
        }else
        {
            $this->inGroup($group,$this->_userData->id);
            if($groupSession->isLocked())
                $groupSession->unlock();
            $groupSession->name = $group;
            $groupSession->id = $grupaDb->getId($group);
            $groupSession->lock();
        }

        $messageDb = new Application_Model_DbTable_Messages();
        $messages = $messageDb->show(null,$groupSession->id);
        $dane = array();
        foreach ($messages as $row) {
            $answers = $messageDb->show($row['id'],$groupSession->id);
            array_push($dane, array("lname"=>$row['lname'],'fname'=>$row['fname'],"text"=>$row['text'],'createdate'=>$row['createDate'],"odpowiedzi"=>$answers));
        }
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        echo Zend_Json::encode($dane);
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