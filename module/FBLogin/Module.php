<?php
namespace FBLogin;

use FBLogin\Authentication\Adapter\FacebookAdapter;
use Zend\ModuleManager\Feature\ServiceProviderInterface;
use Zend\ServiceManager\ServiceManager;

class Module implements ServiceProviderInterface
{
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    /**
     * Expected to return \Zend\ServiceManager\Config object or array to
     * seed such an object.
     *
     * @return array|\Zend\ServiceManager\Config
     */
    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'FBLogin\Authentication\Adapter\FacebookAdapter' => function (ServiceManager $sm) {
                        $dbAdapter   = $sm->get('Zend\Db\Adapter\Adapter');
                        $authAdapter = new FacebookAdapter($dbAdapter, 'user', 'scId', 'email');
                        return $authAdapter;
                    },
            ),
        );
    }
}
