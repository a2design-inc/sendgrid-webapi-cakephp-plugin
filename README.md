# Sendgrid WebAPI plugin for CakePHP

Copyright 2013, [a2design-company](http://a2design.biz)
Licensed under The MIT License

### Version

Written for CakePHP 2.0+

### Installation

You can clone the plugin into your project:

```
cd path/to/app/Plugin
git clone git@github.com:a2design-company/Sendgrid-WebAPI-CakePHP-plugin.git
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
            'username' => 'username@sendgrid.com', //credentials username
            'password' => 'password', //credentials password
            'client' => null,
            'log' => false,
            'emailFormat' => 'both',
            'category' => 'transaction', //default Sendgrid category for email
            'count' => 200, //count of email to send for one API call, max 500, default 500
        );
}
```

### Usage

This plugin uses [CakeEmail](http://book.cakephp.org/2.0/en/core-utility-libraries/email.html), and works virtually the same.

Then, simply send messages like this:

```php
App::uses('CakeEmail', 'Network/Email');
$email = new CakeEmail('sendGrid');

$email->to('recipient@domain.com');
$email->subject('Test email via SedGrid');
$email->send('Message');
```

Or use more resources:

```php
App::uses('CakeEmail', 'Network/Email');
$email = new CakeEmail('sendGrid');

$email->template('default', 'default');
$email->emailFormat('html');
$email->viewVars(array('name' => 'Your Name'));
$email->to(array('recipient1@domain.com' => 'Recipient1', 'recipient2@domain.com' => 'Recipient2'));
$email->subject('Test email via SedGrid');
$email->addHeaders(array('X-Tag' => 'my tag'));
$email->attachments(array(
    'cake.icon.png' => array(
        'file' => WWW_ROOT . 'img' . DS . 'cake.icon.png'
	)
));

$email->send();
```


The syntax of all parameters is the same as the default CakeEmail:

http://book.cakephp.org/2.0/en/core-utility-libraries/email.html