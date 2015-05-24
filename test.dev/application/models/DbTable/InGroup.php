<?php

class Application_Model_DbTable_InGroup extends Zend_Db_Table_Abstract
{

    protected $_name = 'inGroup';

    public function save($userId,$groupId)
    {
        $insert = array(
            'u_id' => $userId,
            'g_id' => $groupId
        );
        $this->insert($insert);
    }

    public function isIn($u_id,$g_id)
    {
        $select = $this->fetchRow(
            $this->select()
                ->from($this->_name,array('count(id) as ile'))
                ->where('u_id = ?',$u_id)->where('g_id = ?',$g_id)
        );
        if($select['ile'] > 0) return true;
        return false;
    }

}

