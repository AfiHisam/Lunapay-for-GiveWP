<?php

class lunapayGiveAPI {
  private $connect;

  public function __construct($connect) {
    $this->connect = $connect;
  }

  public function setConnect($connect) {
    $this->connect = $connect;
  }

  public function toArray($json) {
    return $this->connect->toArray($json);
  }

    public function getToken($tokenParameter){
        return $this->connect->getToken($tokenParameter);
    }

    public function sentPayment($token, $paymentParameter){
        return $this->connect->sentPayment($token, $paymentParameter);
    }

    public function getPaymentStatus($token, $payment_id){
        return $this->connect->getPaymentStatus($token, $payment_id);
    }
}