<?php
namespace Uploadcare\Form\View\Helper;
use Zend\Form\View\Helper\FormInput;

class Uploadcare extends FormInput
{
	public function __construct()
	{
		$this->validTagAttributes = $this->validTagAttributes+array('role' => true);
	}
}