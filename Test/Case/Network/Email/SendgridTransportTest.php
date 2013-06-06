<?php
App::uses('CakeEmail', 'Network/Email');

/**
 * Test case
 *
 */
class SendgridTransportTest extends CakeTestCase {

    /**
     * CakeEmail
     *
     * @var CakeEmail
     */
    private $email;

    /**
     * Setup
     *
     * @return void
     */
    public function setUp() {
        $this->email = new CakeEmail('sendGrid');
    }

    /**
     * testSendgridSend method
     *
     * @return void
     */
    public function testPostmarkSend() {
        $this->email->template('default', 'default');
        $this->email->emailFormat('both');
        $this->email->to(array('test1@example.com' => 'Recipient'));
        $this->email->subject('Test email via SedGrid');
        $this->email->addHeaders(array('X-Tag' => 'my tag'));

        $sendReturn =  $this->email->send();

//        $headers = $this->email->getHeaders(array('to'));
//        $this->assertEqual($sendReturn['To'], $headers['To']);
//        $this->assertEqual($sendReturn['ErrorCode'], 0);
//        $this->assertEqual($sendReturn['Message'], 'OK');
    }

}
