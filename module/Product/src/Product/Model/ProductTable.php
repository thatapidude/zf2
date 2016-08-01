<?php
namespace Product\Model;

use Zend\Db\TableGateway\TableGateway;

class ProductTable
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

    public function getAllStoreProducts($store_id)
    {
    	$store_id = (int) $store_id;

    	$resultSet = $this->tableGateway->select(
        	array('store_id' => $store_id)
        );
        
        return $resultSet;
    }

    public function getProduct($id)
    {
        $id  = (int) $id;
        $rowset = $this->tableGateway->select(
        	array('id' => $id)
        );
        
        return $rowset->current();
    }

    public function saveProduct(Product $product)
	{
	    $data = array(
	    	'store_id' => $product->store_id,
	    	'category_id' => $product->category_id,
	        'name' => $product->name,
	        'description'  => $product->description,
	        'price' => $product->price,
			'timestamp' => time()
	    );
	 
	    $id = (int) $product->id;
	    if (empty($id)) {
	        $this->tableGateway->insert($data);
	        $id = $this->tableGateway->getLastInsertValue();
	    } else {
	        if ($this->getProduct($id)) {
	            $this->tableGateway->update(
	            	$data, 
	            	array(
	            		'id' => $id
	            	)
	            );
	        } else {
	            throw new \Exception('Form id does not exist');
	        }
	    }
	 
	    return $id;
	}

	public function deleteProduct($id)
    {
        $this->tableGateway->delete(array('id' => (int) $id));
    }
}