<?php
namespace Store\Model;

use Zend\Db\TableGateway\TableGateway;

class StoreTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {
        $resultSet = $this->tableGateway->select();

        return $resultSet;
    }

    public function getStore($id)
    {
        $id  = (int) $id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        
        return $rowset->current();
    }

    public function saveStore(Store $store)
	{
	    $data = array(
	        'name' => $store->name,
	        'description'  => $store->description,
			'timestamp' => time()	        
	    );
	 
	    $id = (int) $store->id;
	    if ($id == 0) {
	        $this->tableGateway->insert($data);
	        $id = $this->tableGateway->getLastInsertValue();
	    } else {
	        if ($this->getStore($id)) {
	            $this->tableGateway->update($data, array('id' => $id));
	        } else {
	            throw new \Exception('Form id does not exist');
	        }
	    }
	 
	    return $id;
	}

	public function deleteStore($id)
    {
        $this->tableGateway->delete(array('id' => (int) $id));
    }
}