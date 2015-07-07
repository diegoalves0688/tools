<?php

$var = json_decode(file_get_contents('php://input'), true);

$accountname  = $_GET['an'];
$brandid = $var[0]['brandid'];
$CategoryId = $var[0]['categoryid'];
$DepartmentId = $var[0]['departmentid'];
$Description = $var[0]['description'];
$DescriptionShort = $var[0]['descriptionshort'];
$LinkId = $var[0]['linkid'];
$Name = $var[0]['name'];
$RefId = $var[0]['refid'];
$Title = $var[0]['title'];
$Id = $var[0]['productid'];

if ($Id != ""){ $Id = "<vtex:Id>$Id</vtex:Id>"; }

$soapUrl = "http://webservice-". $accountname .".vtexcommerce.com.br/AdminWebService/Service.svc";


$xml_post_string = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:tem="http://tempuri.org/" xmlns:vtex="http://schemas.datacontract.org/2004/07/Vtex.Commerce.WebApps.AdminWcfService.Contracts" xmlns:arr="http://schemas.microsoft.com/2003/10/Serialization/Arrays">
                       <soapenv:Header/>
                       <soapenv:Body>
                          <tem:ProductInsertUpdate>
                             <!--Optional:-->
                             <tem:productVO>
                                <vtex:BrandId>'.$brandid.'</vtex:BrandId>
                                <vtex:CategoryId>'.$CategoryId.'</vtex:CategoryId>
                                <vtex:Description>'.$Description.'</vtex:Description>
                                <vtex:DescriptionShort>'.$DescriptionShort.'</vtex:DescriptionShort>
                                '.$Id.'
                                <vtex:IsActive>true</vtex:IsActive>
                                <vtex:IsVisible>true</vtex:IsVisible>
                                <vtex:LinkId>'.$LinkId.'</vtex:LinkId>
                                <vtex:Name>'.$Name.'</vtex:Name>
                                <vtex:RefId>'.$RefId.'</vtex:RefId>
                                <vtex:Title>'.$Title.'</vtex:Title>
                             </tem:productVO>
                          </tem:ProductInsertUpdate>
                       </soapenv:Body>
                    </soapenv:Envelope>';

           $headers = array(
                        "Content-type: text/xml;charset=\"utf-8\"",
                        "SOAPAction: http://tempuri.org/IService/ProductInsertUpdate",
                        "Authorization: Basic ".base64_encode($var[1]['user'].":".$var[1]['password']),
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

?>