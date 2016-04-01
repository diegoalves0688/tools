<?php
/**
 * Created by JetBrains PhpStorm.
 * User: vtexuser
 * Date: 01/04/16
 * Time: 12:42
 * To change this template use File | Settings | File Templates.
 */

$text = trim($_POST['skus']);
$textAr = explode("\n", $text);
$textAr = str_replace("\r", "", $textAr);
$textAr = array_filter($textAr, 'trim');

foreach($textAr as $sku){

    $soapUrl = "http://webservice-". $_POST['accountname'] .".vtexcommerce.com.br/AdminWebService/Service.svc";


    $xml_post_string = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:tem="http://tempuri.org/">
                        <soapenv:Header/>
                           <soapenv:Body>
                              <tem:StockKeepingUnitImageRemove>
                                 <tem:stockKeepingUnitId>'. $sku .'</tem:stockKeepingUnitId>
                              </tem:StockKeepingUnitImageRemove>
                           </soapenv:Body>
                        </soapenv:Envelope>';

    $headers = array(
        "Content-type: text/xml;charset=\"utf-8\"",
        "SOAPAction: http://tempuri.org/IService/StockKeepingUnitImageRemove",
        "Authorization: Basic ".base64_encode($_POST['user'].":".$_POST['password']),
        "Content-length: ".strlen($xml_post_string),
    );

    $url = $soapUrl;

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_post_string);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);


    $response = curl_exec($ch);
    curl_close($ch);

    $response1 = str_replace("<soap:Body>","",$response);
    $response2 = str_replace("</soap:Body>","",$response1);

    $parser = simplexml_load_string($response2);
    echo $response;


}


