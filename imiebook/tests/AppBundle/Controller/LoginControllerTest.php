<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Tests\AppBundle\Utils\CurlUtils;

class LoginControllerTest extends WebTestCase
{

    private $curlUtils;

    public function __construct() {
        parent::__construct();
        $this->curlUtils = new CurlUtils();
    }

    /**
     * Test access to /users without authentification
     */
    public function testNoAuthentification()
    {
        $response = $this->curlUtils->get('http://imiebook/app_dev.php/users');
        $this->assertEquals(401, $response['HTTP_CODE']);
    }

    /**
     * Test code 200 on route /users with autentification token
     */
    public function testAuthentification()
    {
        $this->curlUtils->connect('http://imiebook/app_dev.php/login_check');
        $response = $this->curlUtils->get('http://imiebook/app_dev.php/users');
        $this->assertEquals(200, $response['HTTP_CODE']);
    }
}
