<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Store\Controller\Store' => 'Store\Controller\StoreController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'store' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/store[/:id]',
                    'constraints' => array(
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Store\Controller\Store',
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'strategies' => array(
            'ViewJsonStrategy',
        ),
    ),
);