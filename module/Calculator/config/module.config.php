<?php
namespace Calculator;

return array(

    'controllers' => array(
        'invokables' => array(
            'Calculator\Controller\Index' => 'Calculator\Controller\IndexController',
        ),
    ),

    // The following section is new and should be added to your file
    'router' => array(
        'routes' => array(
            'calculator' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/calculator[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Calculator\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),

    'view_manager' => array(
        'template_path_stack' => array(
            'calculator' => __DIR__ . '/../view',
        ),
    ),



);