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
}