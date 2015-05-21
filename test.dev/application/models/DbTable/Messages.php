<?php

class Application_Model_DbTable_Messages extends Zend_Db_Table_Abstract
{

    protected $_name = 'messages';

    public function save($userId,$groupId,$message,$answerTo)
    {
        $insert = array(
            'fromUser' => $userId,
            'groupIn' => $groupId,
            'messText' => $message,
            'answerTo' => $answerTo
        );
        $this->insert($insert);
    }

    public function show($answerTo, $groupId)
    {
        if($answerTo == null) {
            $select = $this->fetchAll(
                $this->select()
                    ->from(array('m' => $this->_name), array('m.id as id', 'm.messText as text', 'u.lname as lname', 'u.fname as fmane'))
                    ->joinLeft(array("u" => "users"), 'm.fromUser = u.id')
                    ->where("m.groupIN = ?","$groupId")->where('answerTo is null')
                    ->setIntegrityCheck(false)
            );
        }
        else {
            $select = $this->fetchAll(
                $this->select()
                    ->from(array('m' => $this->_name), array('m.messText as text', 'u.lname as lname', 'u.fname as fmane'))
                    ->joinLeft(array("u" => "users"), 'm.fromUser = u.id')
                    ->where("m.groupIN = ?", $groupId)->where('answerTo = ?', $answerTo)
                    ->setIntegrityCheck(false)
            );
        }
        return $select;
    }
}

