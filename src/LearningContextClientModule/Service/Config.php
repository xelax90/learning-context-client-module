<?php

/*
 * Copyright (C) 2016 schurix
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 */

namespace LearningContextClientModule\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use LearningContextClientModule\Options\LearningContextOptions;
use LearningContextClient\Config as LCConfig;

/**
 * Factory for Learning Context Client Configuration
 *
 * @author schurix
 */
class Config implements FactoryInterface{
	public function createService(ServiceLocatorInterface $serviceLocator) {
		/* @var $options LearningContextOptions */
		$options = $serviceLocator->get(LearningContextOptions::class);
		/* @var $router \Zend\Mvc\Router\Http\TreeRouteStack */
		$router = $serviceLocator->get('HttpRouter');
		$storage = $serviceLocator->get($options->getStorageService());
		$callbackUrl = $router->assemble(array(), array('name' => 'learning-context/callback', 'force_canonical' => true));
		$config = new LCConfig($options->getAppId(), $options->getAppSecret(), $callbackUrl, $storage, $options->getApiUrl(), $options->getApiVersion(), $options->getOAuthServer());
		return $config;
	}
}
