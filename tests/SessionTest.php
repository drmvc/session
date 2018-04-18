<?php

namespace DrMVC\Session\Tests;

use PHPUnit\Framework\TestCase;
use DrMVC\Session\Session;

class SessionTest extends TestCase
{

    public function __construct(string $name = null, array $data = [], string $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        ob_start();
    }

    public function test__construct()
    {
        try {
            $obj = new Session();
            $this->assertInternalType('object', $obj);
            $this->assertInstanceOf(Session::class, $obj);
        } catch (\Exception $e) {
            $this->assertContains('Must be initialized ', $e->getMessage());
        }
    }

    public function testInit()
    {
        $obj = new Session();
        $session_id = $obj->init();

        $this->assertInternalType('array', $_SESSION);
        $this->assertEmpty($_SESSION);
        $this->assertNotEmpty($session_id);
        $obj->destroy();
    }

    public function testDestroy()
    {
        $obj = new Session();
        $obj->init();

        $session_old = $obj->id();
        $obj->destroy();
        $session_new = $obj->id();
        $this->assertNotEmpty($session_old);
        $this->assertEmpty($session_new);
    }

    public function testId()
    {
        $obj = new Session();
        $obj->init();

        $session_id = $obj->id();
        $this->assertInternalType('string', $session_id);
        $this->assertNotEmpty($session_id);
        $obj->destroy();
    }

    public function testIsStarted()
    {
        $obj = new Session();
        $obj->init();

        $started = $obj->isStarted();
        $this->assertTrue($started);
        $obj->destroy();
    }

    public function testGetPrefix()
    {
        $obj = new Session();
        $obj->init();

        $prefix = $obj->getPrefix();
        $this->assertEmpty($prefix);
        $obj->destroy();
    }

    public function testSetPrefix()
    {
        $obj = new Session();
        $obj->init();

        $obj->setPrefix('zzz');
        $prefix = $obj->getPrefix();
        $this->assertNotEmpty($prefix);
        $this->assertEquals('zzz', $prefix);
        $obj->destroy();
    }

    public function testGet()
    {
        $obj = new Session();
        $obj->init();
        $_SESSION['key'] = 'value';
        $value = $obj->get('key');

        $this->assertNotEmpty($value);
        $this->assertEquals('value', $value);

        $obj->destroy();
    }

    public function testSet()
    {
        $obj = new Session();
        $obj->init();

        // Set normal key
        $obj->set('key', 'value');
        $value = $obj->get('key');
        $this->assertNotEmpty($value);
        $this->assertEquals('value', $value);

        // Set array of values
        $obj->set(['k1' => 'v1', 'k2' => 'v2']);
        $value = $obj->get('k1');
        $this->assertNotEmpty($value);
        $this->assertInternalType('string', $value);

        $obj->destroy();
    }

    public function testPull()
    {
        $obj = new Session();
        $obj->init();

        $obj->set('key', 'value');
        $value = $obj->get('key');
        $this->assertNotEmpty($value);

        $value = $obj->pull('key');
        $this->assertNotEmpty($value);
        $this->assertEquals('value', $value);

        $value = $obj->get('key');
        $this->assertEmpty($value);

        $value100 = $obj->pull('key100');
        $this->assertEmpty($value100);

        $obj->destroy();
    }

    public function testDisplay()
    {
        $obj = new Session();
        $obj->init();

        $session = $obj->display();
        $this->assertEmpty($session);

        $obj
            ->set('key1', 'value')
            ->set('key2', 'value')
            ->set('key3', 'value');
        $session = $obj->display();
        $this->assertNotEmpty($session);
        $this->assertCount(3, $session);

        $obj->destroy();
    }

    public function testRegenerate()
    {
        $obj = new Session();
        $obj->init();

        $session_old = $obj->id();
        $session_new = $obj->regenerate();
        $session_new2 = $obj->id();

        $this->assertNotEmpty($session_old);
        $this->assertNotEmpty($session_new);
        $this->assertNotEquals($session_old, $session_new);
        $this->assertEquals($session_new, $session_new2);

        $obj->destroy();
    }

}
