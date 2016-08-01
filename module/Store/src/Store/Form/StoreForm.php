<?php
namespace Store\Form;

use Zend\Form\Form;

class StoreForm extends Form
{
	public function __construct($name = null)
	{
	    parent::__construct('store');

    	$this->add(array(
			'name' => 'id',
		 	'type' => 'Text',
		));

		$this->add(array(
			'name' => 'name',
			'type' => 'Text',
		));

		$this->add(array(
			'name' => 'description',
			'type' => 'Text',
		));
	}
}