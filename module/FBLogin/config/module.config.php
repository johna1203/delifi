<?php
return array(
    'router'       => array(
        'routes' => array(
            'FBLogin' => array(
                'type'          => 'Literal',
                'options'       => array(
                    'route'    => '/fb',
                    'defaults' => array(
                        '__NAMESPACE__' => 'FBLogin\Controller',
                        'controller'    => 'Index',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes'  => array(
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'       => '/[:controller[/:action]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults'    => array(),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'controllers'  => array(
        'invokables' => array(
            'FBLogin\Controller\Index' => 'FBLogin\Controller\IndexController'
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
);