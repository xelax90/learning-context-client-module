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

namespace LearningContextClientModule\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use LearningContextClient\Client;
use Zend\View\Model\JsonModel;
use Zend\Http\Response;
use LearningContextClientModule\Options\LearningContextOptions;

/**
 * Description of LearningContextController
 *
 * @author schurix
 */
class LearningContextController extends AbstractActionController{
	
	/** @var Client */
	protected $client;
	
	/** @var string|Response|null redirect after authentication. Can be either response, URL, route name or null. If null is passed, no redirect will happen. */
	protected $redirect = null;
	
	/** @var LearningContextOptions */
	protected $options;
	
	/**
	 * @return Client
	 */
	public function getClient(){
		if(null === $this->client){
			$this->client = $this->getServiceLocator()->get(Client::class);
		}
		return $this->client;
	}
	
	public function getOptions(){
		if(null === $this->options){
			$this->options = $this->getServiceLocator()->get(LearningContextOptions::class);
		}
		return $this->options;
	}
	
	public function setRedirect($redirect){
		$this->redirect = $redirect;
		return $this;
	}
	
	public function getRedirect() {
		return $this->redirect;
	}
	
	protected function _redirect(){
		$redirect = $this->redirect;
		if(empty($redirect)){
			$redirect = $this->getOptions()->getRedirectAfterAuthentication();
		}
		if($redirect instanceof Response){
			return $redirect;
		}
		if(!empty($redirect) && is_string($redirect)){
			if(strpos($redirect, 'http://') === 0 || strpos($redirect, 'https://') === 0){
				return $this->redirect()->toUrl($redirect);
			}
			return $this->redirect()->toRoute($redirect);
		}
		return null;
	}
	
	public function callbackAction(){
		$client = $this->getClient();
		$token = $client->getRefreshToken();
		if($token === null){
			$result = array(
				'success' => false,
				'error' => 'No refresh token',
			);
			$this->getEventManager()->trigger('learning-context.unauthorized', $this, $result);
		} else {
			$result = array(
				'success' => true,
			);
			$this->getEventManager()->trigger('learning-context.authorized', $this, $result);
		}
		$redirect = $this->_redirect();
		if($redirect){
			return $redirect;
		}
		return new JsonModel($result);
	}
	
	public function authorizeAction(){
		$client = $this->getClient();
		$token = $client->getTokenManager()->getAccessToken();
		if($token === null){
			$result = array(
				'success' => false,
				'error' => 'No access token',
			);
		} else {
			$result = array(
				'success' => true,
			);
		}
		
		$redirect = $this->_redirect();
		if($redirect){
			return $redirect;
		}
		return new JsonModel($result);
	}
}
