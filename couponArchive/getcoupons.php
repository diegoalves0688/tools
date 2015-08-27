<?php

$accountName = $_POST['accountname'];

function getCoupons($accountname){

    $applicationID = $_POST['key'];
    $applicationKey = $_POST['token'];

    // Set the request URL
    $url = 'http://'. $accountname .'.vtexcommercebeta.com.br/api/rnb/pvt/coupon';

    // Set the HTTP request authentication headers
    $headers = array(
        'http' => array(
            'method' => "GET",
            'header' => "X-VTEX-API-AppKey: " . $applicationID . "\r\n" .
                "X-VTEX-API-AppToken: " . $applicationKey . "\r\n" .
                "DecibelTimestamp: " . date('Ymd H:i:s', time()) . "\r\n"
        )
    );

    // Creates a stream context
    $context = stream_context_create($headers);

    // Open the URL with the HTTP headers (fopen wrappers must be enabled)
    $response = file_get_contents($url, false, $context);
    $volta = json_decode($response);
    return $volta;

}



function sendPostData($accountName, $couponId){

    $data = array(
        $couponId
    );
    $str_data = json_encode($data);

    $url = 'http://'. $accountName .'.vtexcommercebeta.com.br/api/rnb/pvt/archive/coupon/'. $couponId .'/';
    $ch = curl_init($url);
    $ID = $_POST['key'];
    $Key = $_POST['token'];
    $headers= array('Content-Type: application/json','X-VTEX-API-AppKey:'.$ID.'', 'X-VTEX-API-AppToken:'.$Key);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS,$str_data);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $result = curl_exec($ch);
    curl_close($ch);  // Seems like good practice
    return $result;
}


$notes = str_replace(
    "\r",
    "\n",
    str_replace( "\r\n", "\n", $_POST[ 'coupons' ] )
);
$couponsToNotArchive = explode( "\n", $notes );

$coupons = getCoupons($accountName);
$i = 1;
$a = 0;
$n = 0;
foreach ($coupons as $value) {
    //echo $value->id;

    if(in_array($value->couponCode, $couponsToNotArchive)){
        echo $i ." - <font color=green>cupon nao arquivado: " . $value->couponCode . "</font></br>";
        $i++;$n++;
    }else{
        sendPostData($accountName, $value->id);
        echo $i ." - <font color=red>cupon arquivado: " . $value->couponCode . "</font></br>";
        $i++;$a++;
    }
}
sleep(1);
echo "</br><font size=6><b>AccountName: ".$accountName."</br><font color=green size=6><b>Total não arquivados: " . $n . "</font>" . " </br><font color=red size=6><b>Total arquivados: " . $a. "</font>";
?>