<?php
namespace Uploadcare\Form\View\Helper;

use Uploadcare\Form\UploadcareInput;
use Zend\Form\View\Helper\FormElement as BaseFormElement;
use Zend\Form\ElementInterface;

class FormElement extends BaseFormElement
{
	public function render(ElementInterface $element)
	{
		$renderer = $this->getView();
		if (!method_exists($renderer, 'plugin')) {
			return '';
		}
		
		if ($element instanceof UploadcareInput) {
			$helper = $renderer->plugin('formuploadcareinputhelper');
			return $helper($element);
		}

		return parent::render($element);
	}
}