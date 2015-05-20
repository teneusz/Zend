<?php

class Application_Model_DbTable_Groups extends Zend_Db_Table_Abstract
{

    protected $_name = 'groups';

    public function addGroups($owner, $nameGroup)
    {
        $insert = array(
            'owner' => $owner,
            'namegroup' => $nameGroup
        );
        $this->insert($insert);
        $groupId = $this->fetchRow($this->select()->from($this->_name, array('id'))->where('namegroup = ?', $nameGroup));
        $inGroup = new Application_Model_DbTable_InGroup();
        $inGroup->save($owner, $groupId['id']);
    }

    public function listOfGroups($userId)
    {
        $select = $this->fetchAll(
            $this->select()
                ->from(array('g'=>$this->_name),array('namegroup'))
                ->joinLeft(array("in"=>"inGroup"),'g.id = in.g_id')
                ->where("in.u_id = ?",$userId)
                ->setIntegrityCheck(false)
        );
        return $select;
    }

    public function inGroup($groupName,$userId)
    {
        $select = $this->fetchRow(
            $this->select()
                ->from(array('g'=>$this->_name),array('count(namegroup) as ile'))
                ->joinLeft(array('in'=>'inGroup'),'g.id = in.g_id')
                ->where("g.namegroup = ?",$groupName)->where("in.u_id = ?",$userId)
                ->setIntegrityCheck(false)
        );
        if($select['ile'] > 0)
        {return true;}
        else return false;
    }
}