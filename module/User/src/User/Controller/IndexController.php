<?php

namespace User\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{

    public function indexAction()
    {

        /** @var \Application\Mapper\Category $category */
        $category = $this->getServiceLocator()->get('Application\Mapper\Category');


        return new ViewModel(
            array(
                'categories' => $category->findAll()
            )
        );
    }


}

