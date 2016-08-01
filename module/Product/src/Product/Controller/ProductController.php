<?php
namespace Product\Controller;
 
use Zend\Mvc\Controller\AbstractRestfulController;
use Product\Model\Product;
use Product\Form\ProductForm;
use Product\Model\ProductTable;
use Zend\View\Model\JsonModel;
 
class ProductController extends AbstractRestfulController
{
    protected $response;

    protected $productTable;
    /**
     * Retrieve all product's
     * 
     * @http_post GET
     */
    public function getList()
    {
        $product = $this->getProductTable()->fetchAll();
        if (empty($product)) {
            $this->response = array(
                'status' => false,
                'message' => '',
                'data' => null
            );
        } else {
            $data = array();
            foreach ($product as $index => $product_data) {
                $data['ids'][] = $product_data->{'id'};
                $data['info'][$product_data->{'id'}] = $product_data;
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
     * Retrieve product data by product id
     * 
     * @http_post GET
     * 
     * @param int $arg_id
     * 
     * @return array
     */
    public function get($arg_id)
    {
        $product = $this->getProductTable()->getProduct($arg_id);        
        if (empty($product)) {
            $this->response = array(
                'status' => false,
                'message' => '',
                'data' => null
            );
        } else {           
            $this->response = array(
                'status' => true,
                'message' => '',
                'data' => $product
            );
        }
        return new JsonModel(
            $this->response
        );
    }
    /**
     * Create new product
     * 
     * @http_method POST
     * 
     * @param array $arg_data
     * 
     * @return array
     */
    public function create($arg_data)
    {
        $objProductForm = new ProductForm();        
        $objProduct = new Product();        
        $objProductForm->setInputFilter($objProduct->getInputFilter());
        $objProductForm->setData($arg_data);
        if ($objProductForm->isValid()) {            
            $objProduct->exchangeArray(
                $objProductForm->getData()
            );
            $id = $this->getProductTable()->saveProduct($objProduct);
        }        
     
        return $this->get($id);
    }
    /**
     * Update product data
     * 
     * @http_method PUT
     * 
     * @param int $arg_id product id
     * 
     * @param array $arg_data updated product data
     * 
     * @return array
     */
    public function update($arg_id, $arg_data)
    {
        $arg_data['id'] = $arg_id;
        $product_data = $this->getProductTable()->getProduct($arg_id);

        $objProductForm  = new ProductForm();
        $objProductForm->bind($product_data);
        $objProductForm->setInputFilter(
            $product_data->getInputFilter()
        );
        $objProductForm->setData($arg_data);

        if ($objProductForm->isValid()) {
            $arg_id = $this->getProductTable()->saveProduct(
                $objProductForm->getData()
            );
        }
     
        return $this->get($arg_id);
    }
    /**
     * Delete product
     * 
     * @http_method DELETE
     * 
     * @param int $arg_id
     * 
     * @return array
     */
    public function delete($arg_id)
    {
        $this->getProductTable()->deleteProduct($arg_id);
 
        return new JsonModel(
            array(
                'status' => true,
                'message' => '',
                'data' => null,
            )
        );
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