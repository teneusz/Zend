<?php

class Application_Model_DbTable_InGroup extends Zend_Db_Table_Abstract
{

    protected $_name = 'ingroup';

    public function save($userId,$groupId)
    {
        $insert = array(
            'u_id' => $userId,
            'g_id' => $groupId
        );
        $this->insert($insert);
    }


}

