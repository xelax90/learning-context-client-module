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

namespace LearningContextClientModule\Options;

use Zend\Stdlib\AbstractOptions;
use LearningContextClient\Storage\StorageInterface;

/**
 * Description of LearningContextOptions
 *
 * @author schurix
 */
class LearningContextOptions extends AbstractOptions{
	/**
	 * Learning context API URL
	 * @var string
	 */
	protected $apiUrl = null;
	
	/**
	 * Learning Context API Version
	 * @var int
	 */
	protected $apiVersion = null;
	
	/**
	 * Your APP-ID (see API Keys on the Learning Context page)
	 * @var int
	 */
	protected $appId;
	
	/**
	 * Your APP-Secret (See API Keys on the Learning Context page)
	 * @var string
	 */
	protected $appSecret;
	
	/**
	 * This URL will be called when the user allows your app to access his data
	 * It will recieve a refresh token as 'rt' parameter in $_REQUEST
	 * @var string
	 */
	protected $callbackUrl;
	
	/**
	 * Learning Context OAuth Endpoint
	 * @var string
	 */
	protected $oAuthServer = null;
	
	/**
	 * Redirect that is used after authentication is completed. Can be Response, 
	 * string or null. The string can be either URL or route name. If null is 
	 * passed, no redirect will occur.
	 * @var string|Response|null
	 */
	protected $redirectAfterAuthentication = null;
	
	/**
	 * Storage that saves the tokens
	 * @var StorageInterface
	 */
	protected $storageService = StorageInterface::class;
	
	public function getAppId() {
		return $this->appId;
	}

	public function getAppSecret() {
		return $this->appSecret;
	}

	public function getCallbackUrl() {
		return $this->callbackUrl;
	}

	public function setAppId($appId) {
		$this->appId = $appId;
		return $this;
	}

	public function setAppSecret($appSecret) {
		$this->appSecret = $appSecret;
		return $this;
	}

	public function setCallbackUrl($callbackUrl) {
		$this->callbackUrl = $callbackUrl;
		return $this;
	}
	
	public function getApiUrl() {
		return $this->apiUrl;
	}

	public function getApiVersion() {
		return $this->apiVersion;
	}

	public function setApiUrl($apiUrl) {
		$this->apiUrl = $apiUrl;
		return $this;
	}

	public function setApiVersion($apiVersion) {
		$this->apiVersion = $apiVersion;
		return $this;
	}
	
	public function getOAuthServer() {
		return $this->oAuthServer;
	}

	public function getStorageService() {
		return $this->storageService;
	}

	public function setOAuthServer($oAuthServer) {
		$this->oAuthServer = $oAuthServer;
		return $this;
	}

	public function setStorageService($storageService) {
		$this->storageService = $storageService;
		return $this;
	}
	
	public function getRedirectAfterAuthentication() {
		return $this->redirectAfterAuthentication;
	}

	public function setRedirectAfterAuthentication($redirectAfterAuthentication) {
		$this->redirectAfterAuthentication = $redirectAfterAuthentication;
		return $this;
	}
}
