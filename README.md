# Uploadcare Zend Framework 2 Module

This is a module for [Zend Framework 2][5] to work with [Uploadcare][1]

It's based on a [uploadcare-php][4] library.

## Requirements

- Zend 2.0+
- PHP 5.3+

## Install

### GitHub

Clone module from git to your vendor directory:

    git clone git://github.com/uploadcare/uploadcare-zend2.git vendor/Uploadcare --recursive
    
### Composer

Update your composer.json:

    "require": {
      "uploadcare/uploadcare-zend2": "dev-master"
    }   

Install package:

    composer update
    
Fetch submodules from github:
    
    cd vendor/uploadcare/uploadcare-zend2/ && git submodule init && git submodule update   
    
Edit your config/application.config.php and add new module. It should look like this:
    
    return array(
        'modules' => array(
            'Application',
            'Uploadcare',
        ),
        'module_listener_options' => array(
            'config_glob_paths'    => array(
                'config/autoload/{,*.}{global,local}.php',
            ),
            'module_paths' => array(
                './module',
                './vendor',
            ),
        ),  
);
    
Inside your config/autoload/global.php add:

    return array(
        'uploadcare' => array(
          'public_key' => 'demopublickey',
          'secret_key' => 'demoprivatekey',
        ),
    );

## Usage

You can access uploadcare api service inside a controller like this:

    $uploadcare = $this->getServiceLocator()->get('uploadcare');
    
It will return a UploadcareZend object. This class extends Uploadcare\Api class.

Create a from to show Uploadcare widget. Use UploadcareInput class as a field.

Inside your controller:

    namespace Application\Controller;
    
    use Zend\Mvc\Controller\AbstractActionController;
    use Uploadcare\Form\UploadcareInput;
    use Zend\Form\Form;

    class IndexController extends AbstractActionController
    {
        public function indexAction()
        {
            $uploadcare = $this->getServiceLocator()->get('uploadcare');
            
            //file_id is name of input for widget. 
            //You will recieve File ID at CDN from this field.
            $uploadcare_widget = new UploadcareInput('file_id');
            
            $form = new Form();
            $form->add($uploadcare_widget);
            $form->add(array('name' => 'submit',
              'attributes' => array(
                'type'  => 'submit',
                'value' => 'Upload!'
            )));
            
            return array(
              'form' => $form,
              'uploadcare' => $uploadcare,
            );
        }
    }
    
Now we can display a form with a widget inside view:

    <?php
    $this->form->prepare();
    
    echo $this->uploadcare->widget->getScriptTag();
    echo $this->form()->openTag($form);
    echo $this->formCollection($form);
    echo $this->form()->closeTag();
    
    
"echo $this->uploadcare->widget->getScriptTag();" will display all &lt;script&gt; sections you need.

Now you are able to upload files using Uploadcare widget.

Let's handle file_id and display the file. Update your controller to look like this:

    class IndexController extends AbstractActionController
    {
        public function indexAction()
        {
            $uploadcare = $this->getServiceLocator()->get('uploadcare');
  
            $uploadcare_widget = new UploadcareInput('file_id');
            
            $form = new Form();
            $form->add($uploadcare_widget);
            $form->add(array('name' => 'submit',
              'attributes' => array(
                'type'  => 'submit',
                'value' => 'Upload!'
            )));
        
            $file = null;
            $request = $this->getRequest();
            if ($request->isPost()) {
              $form->setData($request->getPost()->toArray());
              if ($form->isValid()) {
                $data = $form->getData();
                $file_id = $data['file_id'];
                $file = $uploadcare->getFile($file_id); //get file from API
                $file->store(); //store file
              }
            }
            
            return array(
              'form' => $form,
              'uploadcare' => $uploadcare,
              'file' => $file,
            );
        }
    }

Now we have an object of Uploadcare\File. Let's display it inside view:

    echo $this->file->scaleCrop(300, 300, true)->getImgTag();
 
[1]: http://uploadcare.com/
[2]: https://uploadcare.com/documentation/reference/basic/cdn.html
[3]: https://github.com/uploadcare/uploadcare-wordpress/downloads
[4]: https://github.com/uploadcare/uploadcare-php
[5]: http://framework.zend.com/