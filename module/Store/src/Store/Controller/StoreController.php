<?php
namespace Store\Controller;
 
use Zend\Mvc\Controller\AbstractRestfulController;
use Store\Model\Store;
use Store\Form\StoreForm;
use Store\Model\StoreTable;
use Product\Model\ProductTable;
use Zend\View\Model\JsonModel;
 
class StoreController extends AbstractRestfulController
{
    protected $response;

    protected $storeTable;

    protected $productTable;
    /**
     * Retrieve all store's
     * 
     * @http_post GET
     */
    public function getList()
    {
        $store = $this->getStoreTable()->fetchAll();
        if (empty($store)) {
            $this->response = array(
                'status' => false,
                'message' => '',
                'data' => null
            );
        } else {
            $data = (object) array();
            foreach ($store as $index => $store_data) {
                $data->ids[] = $store_data->id;
                $data->info[$store_data->id] = $store_data;
                $store_products = $this->getProductTable()->getAllStoreProducts($store_data->id);
                foreach ($store_products as $key => $product) {
                    $data->info[$product->store_id]->products[] = $product;
                }
            }            

            $this->response = array(
                'status' => true,
                'message' => '',
                'data' => $data
            );
        }

        return new JsonModel($this->response);
    }
    /**
     * Retrieve store data by store id
     * 
     * @http_post GET
     * 
     * @param int $arg_id
     * 
     * @return array
     */
    public function get($arg_id)
    {
        $store = $this->getStoreTable()->getStore($arg_id);        
        if (empty($store)) {
            $this->response = array(
                'status' => false,
                'message' => '',
                'data' => null
            );
        } else {           
            $this->response = array(
                'status' => true,
                'message' => '',
                'data' => $store
            );
        }
        return new JsonModel(
            $this->response
        );
    }
    /**
     * Create new store
     * 
     * @http_method POST
     * 
     * @param array $arg_data
     * 
     * @return array
     */
    public function create($arg_data)
    {        
        $objStoreForm = new StoreForm();
        $objStore = new Store();
        $objStoreForm->setInputFilter($objStore->getInputFilter());
        $objStoreForm->setData($arg_data);
        if ($objStoreForm->isValid()) {            
            $objStore->exchangeArray($objStoreForm->getData());
            $id = $this->getStoreTable()->saveStore($objStore);
        }        
     
        return $this->get($id);
    }
    /**
     * Update store data
     * 
     * @http_method PUT
     * 
     * @param int $arg_id store id
     * 
     * @param array $arg_data updated store data
     * 
     * @return array
     */
    public function update($arg_id, $arg_data)
    {
        $arg_data['id'] = $arg_id;
        $store_data = $this->getStoreTable()->getStore($arg_id);

        $objStoreForm  = new StoreForm();
        $objStoreForm->bind($store_data);
        $objStoreForm->setInputFilter(
            $store_data->getInputFilter()
        );
        $objStoreForm->setData($arg_data);

        if ($objStoreForm->isValid()) {
            $arg_id = $this->getStoreTable()->saveStore(
                $objStoreForm->getData()
            );
        }
     
        return $this->get($arg_id);
    }
    /**
     * Delete store
     * 
     * @http_method DELETE
     * 
     * @param int $arg_id
     * 
     * @return array
     */
    public function delete($arg_id)
    {
        $this->getStoreTable()->deleteStore($arg_id);
 
        return new JsonModel(
            array(
                'status' => true,
                'message' => '',
                'data' => null,
            )
        );
    }

    public function getStoreTable()
    {
        if (!$this->storeTable) {
            $sm = $this->getServiceLocator();
            $this->storeTable = $sm->get('Store\Model\StoreTable');
        }
        return $this->storeTable;
    }

    public function getProductTable()
    {
        if (!$this->productTable) {
            $sm = $this->getServiceLocator();
            $this->productTable = $sm->get('Product\Model\ProductTable');
        }
        return $this->productTable;
    }
}