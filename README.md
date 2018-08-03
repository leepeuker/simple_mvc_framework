# simple_mvc_framework

This is a simpel PHP framework for (little to medium sized) web applications and sites following the MVC architectural pattern.

This framework is very basic, it almost certainly won't give you all the features you need, but will deliver you a base architecture to build upon. It is meant to be expanded, adjusted and tinkerd with.

### Requirements
- Apache2 + MYSQL Server
- PHP 7.0 or higher
- Composer (for installing dependencies)

### Installation
Clone repository and install dependencies.

```sh
$ git clone https://github.com/leepeuker/simple_mvc_framework
$ cd ./simple_mvc_framework
$ composer install
```
### Configuration
Rename the "config/config.DUMMY.php" to "config/config.php"
Edit the file and fill in your configuration settings.

### Request Life-cycle
The URLs of the incoming requests will be rewritten by the .htaccess and mapped to the index.php.
The index.php will bootstrap the application, add the specified routes and dispatch the request to an action-method of a controller. The Controller processes the request and can send a response back the the client. 
