<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Tests\AppBundle\Utils\CurlUtils;

class DegresControllerTest extends WebTestCase
{

    private $curlUtils;

    public function __construct() {
        parent::__construct();
        $this->curlUtils = new CurlUtils();
    }

    /**
     * Test code 200 on route /users/{id}/degres with autentification token
     */
    public function testGetAllDegresOfUser()
    {
        $this->curlUtils->connect('http://imiebook/app_dev.php/login_check');
        $response = $this->curlUtils->get('http://imiebook/app_dev.php/users/1/degres');
        $this->assertEquals(200, $response['HTTP_CODE']);
    }

    /**
     * Test code 200 on route /degres/{id}
     */
    public function testGetDegre()
    {
        $this->curlUtils->connect('http://imiebook/app_dev.php/login_check');
        $response = $this->curlUtils->get('http://imiebook/app_dev.php/degres/1');
        $this->assertEquals(200, $response['HTTP_CODE']);
    }

    /**
     * Test code 200 on route POST /degres
     */
    public function testPostDegre()
    {
        $this->curlUtils->connect('http://imiebook/app_dev.php/login_check');
        // get formated date
        $date = (new \DateTime("now"))->format('Y-m-d\TH:i:s.u');
        $data = [
            'title' => 'Testeur',
            'description' => 'Je suis un test',
            'enterprise' => 'Anonymous',
            'dateStart' => "2018-03-09T13:30:14+01:00",
            'dateEnd' => "2018-03-09T13:30:14+01:00"
        ];
        $response = $this->curlUtils->post('http://imiebook/app_dev.php/degres', $data);
        $this->assertEquals(200, $response['HTTP_CODE']);
    }

    /**
     * Test code 200 on route PUT /degres/2
     */
    public function testPutDegre()
    {
        $this->curlUtils->connect('http://imiebook/app_dev.php/login_check');
        $data = [
            'title' => 'Designer'
        ];
        $response = $this->curlUtils->put('http://imiebook/app_dev.php/degres/2', $data);
        $this->assertEquals(200, $response['HTTP_CODE']);
    }

    /**
     * Test code 200 on route DELETE /degres/2
     */
    public function testDeleteDegre()
    {
        $this->curlUtils->connect('http://imiebook/app_dev.php/login_check');
        $response = $this->curlUtils->delete('http://imiebook/app_dev.php/degres/2');
        $this->assertEquals(200, $response['HTTP_CODE']);
        $response = $this->curlUtils->get('http://imiebook/app_dev.php/degres/2');
        $this->assertEquals(404, $response['HTTP_CODE']);
    }
}
