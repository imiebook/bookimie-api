<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Tests\AppBundle\Utils\CurlUtils;

class SkillsControllerTest extends WebTestCase
{

    private $curlUtils;

    public function __construct() {
        parent::__construct();
        $this->curlUtils = new CurlUtils();
    }

    /**
     * Test code 200 on route /users/{id}/skills with autentification token
     */
    public function testGetAllSkillsOfUser()
    {
        $this->curlUtils->connect('http://imiebook/app_dev.php/login_check');
        $response = $this->curlUtils->get('http://imiebook/app_dev.php/users/1/skills');
        $this->assertEquals(200, $response['HTTP_CODE']);
    }

    /**
     * Test code 200 on route /skills/{id}
     */
    public function testGetSkill()
    {
        $this->curlUtils->connect('http://imiebook/app_dev.php/login_check');
        $response = $this->curlUtils->get('http://imiebook/app_dev.php/skills/1');
        $this->assertEquals(200, $response['HTTP_CODE']);
    }

    /**
     * Test code 200 on route POST /skills
     */
    public function testPostSkill()
    {
        $this->curlUtils->connect('http://imiebook/app_dev.php/login_check');
        $data = [
            'label' => 'JEE'
        ];
        $response = $this->curlUtils->post('http://imiebook/app_dev.php/skills', $data);
        $this->assertEquals(200, $response['HTTP_CODE']);
    }

    /**
     * Test code 200 on route PUT /skills/2
     */
    public function testPutSkill()
    {
        $this->curlUtils->connect('http://imiebook/app_dev.php/login_check');
        $data = [
            'label' => 'JAVA'
        ];
        $response = $this->curlUtils->put('http://imiebook/app_dev.php/skills/2', $data);
        $this->assertEquals(200, $response['HTTP_CODE']);
    }

    /**
     * Test code 200 on route DELETE /skills/2
     */
    public function testDeleteSkill()
    {
        $this->curlUtils->connect('http://imiebook/app_dev.php/login_check');
        $response = $this->curlUtils->delete('http://imiebook/app_dev.php/skills/2');
        $this->assertEquals(200, $response['HTTP_CODE']);
        $response = $this->curlUtils->get('http://imiebook/app_dev.php/skills/2');
        $this->assertEquals(404, $response['HTTP_CODE']);
    }
}
