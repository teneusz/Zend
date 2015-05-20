<?php

class Application_Model_DbTable_Groups extends Zend_Db_Table_Abstract
{

    protected $_name = 'groups';
    
    public function addGroups($owner,$name)
    {
        $insert  = array(
            'owner' => $owner,
            'namegroup' => $name
        );
        $this->insert($insert);

        $groupId = $this->fetchRow($this->select()->from($this->$_name,array('id'))->where(array('namegroup = ?'=>$name)));

        $inGroup = new Application_Model_DbTable_InGroup();
        $inGroup->save($owner,$groupId['id']);
    }

}

