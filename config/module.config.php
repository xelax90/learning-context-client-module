<?php
namespace LearningContextClientModule;

use Zend\ServiceManager\ServiceManager;
use LearningContextClient\Config as LCConfig;
use LearningContextClient\Client as LCClient;
use LearningContextClient\Storage\StorageInterface as LCStorage;
use LearningContextClient\Storage\ZendSessionStorage;
use BjyAuthorize\Guard;


return array(
	'learning_context' => array(
		'app_id' => '',
		'app_secret' => '',
		'callback_url' => '',
	),
	
	'controllers' => array(
		'invokables' => array(
			Controller\LearningContextController::class => Controller\LearningContextController::class,
		),
	),
	
	'router' => array(
		'routes' => array(
			'learning-context' => array(
				'type' => 'Literal',
				'options' => array(
					'route' => '/learning-context',
					'defaults' => array(
						'controller' => Controller\LearningContextController::class,
						'action'     => 'index',
					),
				),
				'may_terminate' => false,
				'child_routes' => array(
					'authenticate' => array(
						'type' => 'Literal',
						'options' => array(
							'route' => '/authenticate',
							'defaults' => array(
								'action'     => 'authorize',
							),
						),
					),
					'callback' => array(
						'type' => 'Literal',
						'options' => array(
							'route' => '/callback',
							'defaults' => array(
								'action'     => 'callback',
							),
						),
					),
				)
			)
		),
	),
	
	'bjyauthorize' => array(
        'guards' => array(
            Guard\Route::class => array(
				'learning-context/callback'     => ['route' => 'learning-context/callback',  'roles' => ['guest', 'user'] ],
				'learning-context/authenticate' => ['route' => 'learning-context/authenticate',  'roles' => ['guest', 'user'] ],
			),
		),
	),
	
	'service_manager' => array(
		'invokables' => array(
		),
		'factories' => array(
			Options\LearningContextOptions::class => function (ServiceManager $sm) {
				$config = $sm->get('Config');
				return new Options\LearningContextOptions(isset($config['learning_context']) ? $config['learning_context'] : array());
			},
			LCConfig::class => Service\Config::class,
			LCClient::class => Service\LearningContext::class,
			LCStorage::class => Service\SessionStorage::class,
			ZendSessionStorage::class => Service\SessionStorage::class,
		),
	),
);