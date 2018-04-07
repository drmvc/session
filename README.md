[![Latest Stable Version](https://poser.pugx.org/drmvc/session/v/stable)](https://packagist.org/packages/drmvc/session)
[![Build Status](https://travis-ci.org/drmvc/session.svg?branch=master)](https://travis-ci.org/drmvc/session)
[![Total Downloads](https://poser.pugx.org/drmvc/session/downloads)](https://packagist.org/packages/drmvc/session)
[![License](https://poser.pugx.org/drmvc/session/license)](https://packagist.org/packages/drmvc/session)
[![PHP 7 ready](https://php7ready.timesplinter.ch/drmvc/session/master/badge.svg)](https://travis-ci.org/drmvc/session)
[![Code Climate](https://codeclimate.com/github/drmvc/session/badges/gpa.svg)](https://codeclimate.com/github/drmvc/session)
[![Scrutinizer CQ](https://scrutinizer-ci.com/g/drmvc/session/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/drmvc/session/)

# DrMVC\Session

Module for working with PHP sessions.

    composer require drmvc/session

## How to use

More examples you can find [here](extra).

```php
<?php
require_once __DIR__ . '/../vendor/autoload.php';

use DrMVC\Session;

// Create session object, you can also set prefix
// as first argument of Session class
$session = new Session();

// Init session object
$session->init();

// Get ID of current session
$session_id = $session->id();

// Set few keys in session
$session
    ->set('text', 'value')
    ->set('integer', 123)
    ->set('boolean', true)
    ->set('array', ['mama', 'ama', 'criminal']);

// Receive variables of current session
$keys = $session->display();
var_dump($keys);

// Get some single value by key
$value = $session->get('integer');
var_dump($value);
```

## About PHP Unit Tests

First need to install all dev dependencies via `composer update`, then
you can run tests by hands from source directory via `./vendor/bin/phpunit` command.

# Links

* [DrMVC Framework](https://drmvc.com)
