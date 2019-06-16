<?php

class lunapayGiveWPConnect {

  public $url;
  public $header;

  public function __construct() {

    $this->current_url = 'https://uat.lunapay.com';

  }

  public function getToken($tokenParameter){
    $url = $this->current_url.'/oauth/token';
    $data = array(
      'grant_type' => 'client_credentials',
      'client_id' => $tokenParameter['client_id'],
      'client_secret' => $tokenParameter['secret_code']
      );

        $wp_remote_data['body'] = http_build_query($data);
        $wp_remote_data['method'] = 'POST';
        $response = \wp_remote_post($url, $wp_remote_data);
        $body = \wp_remote_retrieve_body($response);
        $newbody = json_decode($body);

        $token = $newbody->access_token;

        return $token;
    }


    public function sentPayment($token, $paymentParameter){

        $url = $this->current_url.'/api/payments/payment';

        $header = array(
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$token
        );

         $wp_remote_data['headers'] = $header;
         $wp_remote_data['body'] = http_build_query($paymentParameter);
         $wp_remote_data['method'] = 'POST';

         $response = \wp_remote_post($url, $wp_remote_data);
         $body = \wp_remote_retrieve_body($response);

         //$newbody = json_decode($body);
         $payment_url = $newbody->payment_url;
         $payment_id = $newbody->payment_id;


         return array($payment_url, $body);

    }

    public function getPaymentStatus($token, $payment_id){

         $url = $this->current_url.'/api/payments/'.$payment_id.'/status';

        $header = array(
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$token
        );

        $data = array(
            'payment_id' => $payment_id
        );

         $wp_remote_data['headers'] = $header;
         $wp_remote_data['method'] = 'GET';

         $response = \wp_remote_get($url, $wp_remote_data);
         $body = \wp_remote_retrieve_body($response);

         $newbody = json_decode($body);

         $payment_id = $newbody->payment_id;
         $status = $newbody->status;


        return array($payment_id, $status);
    }

     public static function afterPayment(){

        if(isset($_GET['payment_id'])) {


            $data = array(
            
                'payment_id' => $_GET['payment_id'],
               
            );
        }
        return $data;
    }

  public function toArray($json) {
    return array($json[0], \json_decode($json[1], true));
  }
}