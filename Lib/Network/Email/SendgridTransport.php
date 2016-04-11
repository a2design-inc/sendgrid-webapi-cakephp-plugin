<?php

App::uses('AbstractTransport', 'Network/Email');
App::uses('HttpSocket', 'Network/Http');

class SendgridTransport extends AbstractTransport {
    /**
     * CakeEmail
     *
     * @var CakeEmail
     */
    protected $_cakeEmail;

    /**
     * CakeEmail headers
     *
     * @var array
     */
    protected $_headers;

    /**
     * Configuration to transport
     *
     * @var mixed
     */
    protected $_config = array();

    /**
     * Recipients list
     *
     * @var mixed
     */
    protected $_recipients = array();

    /**
     * Sends out email via SendGrid
     *
     * @return bool
     */
    public function send(CakeEmail $email) {

        // CakeEmail
        $this->_cakeEmail = $email;

        $this->_config = $this->_cakeEmail->config();

        if (empty($this->_config['count']) || $this->_config['count'] > 500) {
            $this->_config['count'] = 500;
        }

        $this->_headers = $this->_cakeEmail->getHeaders();
        $this->_recipients = $email->to();
        $this->_replyTo = $email->replyTo();

        return $this->_sendPart();

    }

    private function _sendPart() {

        if(empty($this->_recipients)) {
            return true;
        }

        $json = array(
            'to' => $this->_getAddress(array_splice($this->_recipients, 0, $this->_config['count'])),
            'category' => !empty($this->_headers['X-Category']) ? $this->_headers['X-Category'] : $this->_config['category'],
        );

        //Sendgrid Substitution Tags
        if (!empty($this->_headers['X-Sub'])) {
            foreach ($this->_headers['X-Sub'] as $key => $value) {
                $json['sub'][$key] = array_splice($value, 0, $this->_config['count']);
            }
        }

        $replyTos = array_keys($this->_replyTo);
        $params = array(
            'api_user'  => $this->_config['username'],
            'api_key'   => $this->_config['password'],
            'x-smtpapi' => json_encode($json),
            'to'        => 'example3@sendgrid.com',
            'subject'   => $this->_cakeEmail->subject(),
            'html'      => $this->_cakeEmail->message('html'),
            'text'      => $this->_cakeEmail->message('text'),
            'from'      => $this->_config['from'],
            'fromname'  => $this->_config['fromName'],
            'replyto'   => $replyTos[0],
        );

        $attachments = $this->_cakeEmail->attachments();
        if (!empty($attachments)) {
            foreach ($attachments as $key => $value) {
                $params['files[' . $key . ']'] = '@' . $value['file'];
            }
        }

        $result = json_decode($this->_exec($params));

        if ($result->message != 'success') {
            return  $result;
        } else {
            return $this->_sendPart();
        }
    }

    private function _getAddress($addresses = array(), $asString = false) {

        $output = array();

        foreach($addresses as $key => $value) {
            $output[] = "$value <{$key}>";
        }

        if ($asString) {
            return implode(', ', $output);
        }
        else {
            return $output;
        }
    }

    private function _exec($params) {
        $request =  'https://api.sendgrid.com/api/mail.send.json';
        $email = new HttpSocket(array(
          'ssl_verify_host' => false
        ));
        $response = $email->post($request, $params);
        return $response->body;
    }

}
