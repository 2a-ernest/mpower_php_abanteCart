<?php
class MPower_DirectPay extends MPower {
  public $status;
  public $response_code;
  public $response_text;
  public $transaction_id;
  public $description;

  public function creditAccount($payee_account,$amount)
  {
    $payload = array(
      'account_alias' => $payee_account,
      'amount' => $amount
    );
    
    $result = MPower_Utilities::httpJsonRequest(MPower_Setup::getDirectPayCreditUrl(), $payload);
    if(count($result) > 0) {
      switch ($result['response_code']) {
        case 00:
          $this->status = $result['status'];
          $this->response_text = $result["response_text"];
          $this->description = $result["description"];
          $this->transaction_id = $result["transaction_id"];
          return true;
          break;
        default:
          $this->status = $result['status'];
          $this->response_text = $result["response_text"];
          $this->response_code = $result["response_code"];
          return false;
      }
    }else{
      $this->status = "fail";
      $this->response_code = 4002;
      $this->response_text = "An Unknown MPower Server Error Occured.";
      return false;
    }
  }
}