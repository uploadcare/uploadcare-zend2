<?php
namespace Uploadcare\Form;

use Zend\Form\Element\Hidden;
use Zend\Form\View\Helper\FormInput;

class UploadcareInput extends Hidden
{
	public function getViewHelperConfig(){
		return new UploadcareInputHepler();
	}
	
	/**
	 * Seed attributes
	 *
	 * @var array
	 */
	protected $attributes = array(
			'type' => 'hidden',
			'role' => 'uploadcare-uploader',
	);
}