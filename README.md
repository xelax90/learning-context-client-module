# Learning Context Client Module

This is a small Zend Framework 2 module for xelax90/learning-context-client

## Setup

* Install this module with composer

 ```
 composer require xelax90/learning-context-client-module
 ```

* Add `LearningContextClientModule` to your modules array in `config/application.config.php`

 ```php
  $config = array(
    'modules' => array(
      // ...
      'LearningContextClientModule',
      // ...
    ),
    // ...
 );
 ```
 
* Copy the provided local configuration under `vendor/xelax90/learning-context-client-module/learning-context.local.php.dist` into your `config/autoload` folder and copy it again without the `.dist` extension.
* Enter your app id and secret into the `conig/autoload/learning-context.local.php` file.
* Enter the `callback_url`. The callback URL is the URL corresponding to the `learning-context/callback` route.
* Enter the `redirect_after_authentication`. It can be either a full URL or route name. This is the place where the authentication controller will redirect to after successful or unsuccessful authentication. 

## Usage
You can use the `learning-context/authenticate` route for authentication. Access `/learning-context/authenticate` in the browser and the authentication process starts.

You can access the client via `ServiceLocator` using its class name:

```php
use use LearningContextClient\Client;
$client = $container->get(Client::class);
```

To check wether the user is authenticated, check if the client has a refresh token:
```php
$authenticated = $client->getRefreshToken() !== null;
if($authenticated){
  // authenticated
} else {
  // not authenticated
}
```

For documentation about the client and the Learning Context API consult the respective documentations:
* Client: https://github.com/xelax90/learning-context-client
* Learning Context: http://learning-context.de/text/19/APIDoc

## Events

The `LearningContextClientModule\Controller\LearningContextController` class triggers authentication events when the callback URL is accessed. It triggers `learning-context.authorized` if a refresh token was provided and `learning-context.unauthorized` if not.

