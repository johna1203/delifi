<?php
namespace User;

use User\Mapper\User as UserMapper;
use Zend\Authentication\Adapter\DbTable as AuthAdapter;
use Zend\ModuleManager\Feature\ServiceProviderInterface;
use Zend\ServiceManager\ServiceManager;
use Zend\Authentication\Storage\Session as SessionStorage;

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
            'invokables' => array(
                'User\Model\User' => 'User\Model\User',
            ),
            'factories'  => array(
                'User\Mapper\User'                          => function (ServiceManager $sm) {
                        $mapper = new UserMapper($sm->get('Zend\Db\Adapter\Adapter'));
                        $mapper->setServiceManager($sm);

                        return $mapper;
                    },
                'Zend\Authentication\Adapter\DbTable'       => function (ServiceManager $sm) {
                        $dbAdapter   = $sm->get('Zend\Db\Adapter\Adapter');
                        $authAdapter = new AuthAdapter($dbAdapter, 'users', 'username', 'password', null);
                        $select      = $authAdapter->getDbSelect();
                        $select->where("status = 0");

                        return $authAdapter;
                    },
                'Zend\Authentication\AuthenticationService' => function (ServiceManager $sm) {
                        /** @var \Zend\Authentication\AuthenticationService $authService */
                        $authService = new \Zend\Authentication\AuthenticationService(new SessionStorage('delifi'));
                        return $authService;
                    },
            )
        );
    }
}
