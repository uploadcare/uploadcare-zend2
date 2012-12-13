<?php
namespace Uploadcare;

include __DIR__.'/../uploadcare-php/uploadcare/lib/5.3-5.4/Uploadcare.php';

use Uploadcare\Api;
use Zend\ServiceManager\ServiceManager;
use Zend\ServiceManager\ServiceManagerAwareInterface;

class UploadcareZend extends Api implements ServiceManagerAwareInterface
{
    protected $serviceManager;
    
    public function setServiceManager(ServiceManager $serviceManager)
    {
        $this->serviceManager = $serviceManager;
 
        return $this;
    }
 
    public function getServiceManager()
    {
        return $this->serviceManager;
    }
}