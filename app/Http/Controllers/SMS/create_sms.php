<?php

namespace App\Http\Controllers\SMS;

trait create_sms
{
  public function SendSMS($toUser, $Message)
  {
    $my_url = "http://103.53.84.15:8746/sendtext/6948f557699c4b79/3c084517";
    $data = array();
    $data['callerID']="cn";
    $data['toUser']=$toUser;
    $data['messageContent']=$Message;
    $json = json_encode($data);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $my_url);
    $response = curl_exec($ch);
    curl_close($ch);

    // massage status check
    $dataArray = json_decode($response, true);
    if (isset($dataArray)) {
      if ($dataArray["Text"] == "ACCEPTD") {
        return 'success';
      } else {
        return 'faild';
      }
    } else {
      return 'sms send faild !';
    }
    //   if dataArray
  }
  //end function
}
