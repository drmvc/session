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
