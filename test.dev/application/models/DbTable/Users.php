<?php

class Application_Model_DbTable_Users extends Zend_Db_Table_Abstract
{

    protected $_name = 'users';
    
    public function save(array $data)
    {
        
        $insert = array(
            'fname' => $data['fname'],
            'lname' => $data['lname'],
            'email' => $data['email'],
            'pass' => md5($data['password']),
            'phonenumber' => $data['telnum'],
            'adress1' => $data['adr1'],
            'adress2' => $data['adr2'],
            'country' => 'Poland'
        );
        $this->insert($insert);
    }
    
    public function onlyOne($email)
    {
        $select = $this->fetchRow($this->select()->from('users',array('count(fname) as ile'))->where('email = ?',$email));
        
        if($select['ile']>0)
        {return false;}
        return true;
    }
    
    public function getUserData($email)
    {
        $whatGet = array("fname","lname","phonenumber","adress1","adress2","country");
        return $select = $this->fetchRow($this->select()->from('users',$whatGet)->where('email = ?',$email));
    }
 
}

