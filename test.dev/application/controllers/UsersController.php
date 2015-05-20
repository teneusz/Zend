<?php

class UsersController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
       $auth = Zend_Auth::getInstance();
       $logged = $auth->hasIdentity();
       if($logged)
       {
        $userProfile = new Zend_Session_Namespace('userData');
        echo "Hello ".$userProfile->fname." ".$userProfile->lname."!";
       }
       
    }

    public function addAction()
    {
       $request = $this->getRequest();
       $form = new Application_Form_Adduser();
       $user = new Application_Model_DbTable_Users();
       
       if ($this->getRequest()->isPost() && $form->isValid($request->getPost()))
       {            
                if($user->onlyOne($form->getValue('email')))
                {
                    $user->save($form->getValues());
                    $this->view->errorMessage = "Rejestracja przebiegła pomyślnie";
                }else
                {
                    echo $this->view->errorMessage = "Email sie powtórzył";
                    echo $this->view->form = $form;
                }        
       }else echo $this->view->form = $form;
    }

    public function editAction()
    {
        // action body
    }

    public function deleteAction()
    {
        // action body
    }

    public function listAction()
    {
        // action body
    }

    public function loginAction()
    {
        $auth = Zend_Auth::getInstance();
        if($auth->hasIdentity())
        {
           $this->redirect("users/index");
        }
        $form = new Application_Form_Userlog();
        $request = $this->getRequest();
        if ($this->getRequest()->isPost() && $form->isValid($request->getPost()))
        {
            $email = $form->getValue('email');
            $authAdapter = new Zend_Auth_Adapter_DbTable(null,'users','email','pass');
            $authAdapter ->setIdentity($email)
                         ->setCredential(md5($form->getValue('password')));
            $result = $auth->authenticate($authAdapter);
            if($result->isValid())
            {
                $db = new Application_Model_DbTable_Users();
                $userProfile = new Zend_Session_Namespace('userData');
                $userData = $db->getUserData($email);
                $userProfile->email = $email;
                $userProfile->fname = $userData['fname'];
                $userProfile->lname = $userData['lname'];
                $userProfile->phonenumber = $userData['phonenumber'];
                $userProfile->adress1 = $userData['adress1'];
                $userProfile->adress2 = $userData['adress2'];
                $userProfile->country = $userData['country'];
                $userProfile->Lock();
                
                $this->redirect("users/index");
            }
           echo $this->view->errorMessage = "Błędny e-mail lub hasło!<br/><br/>"; 
            
        }echo $this->view->form = $form;
    }

    public function logoutAction()
    {
        $auth = Zend_Auth::getInstance();
        $auth->clearIdentity();
        $this->redirect("index/index");
    }


}













