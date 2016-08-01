<?php

namespace Product\Model;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Product
{
 	public $id;

 	public $store_id;

 	public $category_id;

 	public $name;

 	public $description;

 	public $price;

 	protected $inputFilter;

 	public function exchangeArray($data)
 	{
    	$this->id = (!empty($data['id'])) ? $data['id'] : null;
    	$this->store_id = (!empty($data['store_id'])) ? $data['store_id'] : null;
    	$this->category_id = (!empty($data['category_id'])) ? $data['category_id'] : null;
     	$this->name = (!empty($data['name'])) ? $data['name'] : null;
     	$this->description = (!empty($data['description'])) ? $data['description'] : null;
     	$this->price = (!empty($data['price'])) ? $data['price'] : null;
 	}
 	
    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }

    public function getInputFilter()
    {
		if (!$this->inputFilter) {
			$inputFilter = new InputFilter();

			$inputFilter->add(array(
		 		'name'     => 'id',
		 		'required' => false,
		 		'filters'  => array(
		     		array('name' => 'Int'),
		 		),
			));

			$inputFilter->add(array(
		 		'name'     => 'store_id',
		 		'required' => true,
		 		'filters'  => array(
		     		array('name' => 'Int'),
		 		),
			));

			$inputFilter->add(array(
		 		'name'     => 'category_id',
		 		'required' => true,
		 		'filters'  => array(
		     		array('name' => 'Int'),
		 		),
			));

			$inputFilter->add(array(
		 		'name'     => 'name',
		 		'required' => true,
		 		'filters'  => array(
		     		array('name' => 'StripTags'),
		     		array('name' => 'StringTrim'),
		 		),
		 		'validators' => array(
			     	array(
			         	'name'    => 'StringLength',
			         	'options' => array(
			            	'encoding' => 'UTF-8',
			            	'min'      => 1,
			            	'max'      => 100,
			        	),
			    	),
				),
			));

			$inputFilter->add(array(
				'name'     => 'description',
				'required' => true,
				'filters'  => array(
				    array('name' => 'StripTags'),
				    array('name' => 'StringTrim'),
				),
				'validators' => array(
				    array(
				        'name'    => 'StringLength',
				        'options' => array(
				            'encoding' => 'UTF-8',
				            'min'      => 1,
				            'max'      => 200,
				        ),
				    ),
				),
			));

			$inputFilter->add(array(
		 		'name'     => 'price',
		 		'required' => true
			));

			$this->inputFilter = $inputFilter;
		}

		return $this->inputFilter;
	}

	// Add the following method:
     public function getArrayCopy()
     {
         return get_object_vars($this);
     }
}