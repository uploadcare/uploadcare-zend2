<?php
namespace Uploadcare;

use Zend\ModuleManager\ModuleManager;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;

class Module implements
AutoloaderProviderInterface,
ConfigProviderInterface,
ServiceProviderInterface
{
	public function getAutoloaderConfig()
	{
		return array(
				'Zend\Loader\ClassMapAutoloader' => array(
						__DIR__ . '/autoload_classmap.php',
				),
		);
	}
	
	public function getConfig($env = null)
	{
		return include __DIR__ . '/config/module.config.php';
	}	
	
	public function getServiceConfig()
	{
		return array(	
				'factories' => array(
						'uploadcare' => function($sm) {
								$config = $sm->get('Config');
								$service = new UploadcareZend($config['uploadcare']['public_key'], $config['uploadcare']['secret_key']);
								return $service;
						}
				)
		);
	}
	
	public function getViewHelperConfig()
	{
		return array(
				'invokables' => array(
						'formelement' => 'Uploadcare\Form\View\Helper\FormElement',
						'formuploadcareinputhelper' => 'Uploadcare\Form\View\Helper\Uploadcare',
				),				
		);		
	}
}