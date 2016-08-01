<?php
namespace Product\Form;

use Zend\Form\Form;

class ProductForm extends Form
{
	public function __construct($name = null)
	{
	    parent::__construct('product');

		$this->add(array(
			'name' => 'id',
		));

		$this->add(array(
			'name' => 'store_id',
		));

		$this->add(array(
			'name' => 'category_id',
		));

		$this->add(array(
			'name' => 'name',
		));

		$this->add(array(
			'name' => 'description',
		));

		$this->add(array(
			'name' => 'price',
		));
	}
}