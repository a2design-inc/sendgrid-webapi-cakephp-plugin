# CakePHP plugin for SendGrid WebAPI

### Usage

This plugin uses [CakeEmail class](http://book.cakephp.org/2.0/en/core-utility-libraries/email.html), and works almost the same.

Basic example:

```php
App::uses('CakeEmail', 'Network/Email');
$email = new CakeEmail('sendGrid');

$email->to('recipient@domain.com');
$email->subject('Test email via SendGrid');
$email->send('Message');
```

More advanced example:

```php
App::uses('CakeEmail', 'Network/Email');
$email = new CakeEmail('sendGrid');

$email->template('default', 'default');
$email->emailFormat('html');
$email->viewVars(array('name' => 'Your Name'));
$email->to(array('recipient1@domain.com' => 'Recipient1', 'recipient2@domain.com' => 'Recipient2'));
$email->subject('Test email via SendGrid');
$email->addHeaders(array('X-Tag' => 'my tag'));
$email->attachments(array(
    'cake.icon.png' => array(
        'file' => WWW_ROOT . 'img' . DS . 'cake.icon.png'
	)
));

$email->send();
```

The syntax of all parameters is the same as the default [CakeEmail class](http://book.cakephp.org/2.0/en/core-utility-libraries/email.html):


### Installation

You can clone the plugin into your project:

```
cd path/to/app/Plugin
git clone git@github.com:a2design-company/sendgrid-webapi-cakephp-plugin.git Sendgrid
```

Bootstrap the plugin in app/Config/bootstrap.php:

```php
CakePlugin::load('Sendgrid');
```

### Configuration

Create the file app/Config/email.php with the class EmailConfig.

```php
<?php
class EmailConfig {
	public $sendGrid = array(
            'transport' => 'Sendgrid.Sendgrid',
            'from' => 'you-email@sendgrid.com',
            'fromName' => 'You name',
            'timeout' => 30,
            'username' => 'username@sendgrid.com', //SendGrid username
            'password' => 'password', //SendGrid password
            'client' => null,
            'log' => false,
            'emailFormat' => 'both',
            'category' => 'transaction', //default SendGrid category for emails
            'count' => 200, //count of email to send in one API call, max 500, default 500
        );
}
```


### Requirements

CakePHP 2.0+

### License

Licensed under The MIT License

Developed by [A2 Design Inc.](http://www.a2design.biz)