using System;
using System.Xml;
using System.Net;
using System.IO;

class Program
    {
          
        public static void Execute()
        {
            HttpWebRequest request = CreateWebRequest();
            XmlDocument soapEnvelopeXml = new XmlDocument();
            soapEnvelopeXml.LoadXml(@"<?xml version=""1.0"" encoding=""utf-8""?>
                <soapenv:Envelope xmlns:soapenv=""http://schemas.xmlsoap.org/soap/envelope/"" xmlns:tem=""http://tempuri.org/"" xmlns:arr=""http://schemas.microsoft.com/2003/10/Serialization/Arrays"">
                  <soapenv:Header/>
                  <soapenv:Body>
                        <tem:StockKeepingUnitEspecificationInsert>
                        <!--Optional:-->
                        <tem:idSku>1082</tem:idSku>
                        <!--Optional:-->
                        <tem:fieldName>Cores</tem:fieldName>
                        <!--Optional:-->
                        <tem:fieldValues>
                              <!--Zero or more repetitions:-->
                              <arr:string>Azul</arr:string>
                        </tem:fieldValues>
                        </tem:StockKeepingUnitEspecificationInsert>
                  </soapenv:Body>
                  </soapenv:Envelope>");

            using (Stream stream = request.GetRequestStream())
            {
                soapEnvelopeXml.Save(stream);
            }

            using (WebResponse response = request.GetResponse())
            {
                using (StreamReader rd = new StreamReader(response.GetResponseStream()))
                {
                    string soapResult = rd.ReadToEnd();
                    Console.WriteLine(soapResult);
                }
            }
        }

        public static HttpWebRequest CreateWebRequest()
        {
            HttpWebRequest webRequest = (HttpWebRequest)WebRequest.Create(@"http://webservice-accountname.vtexcommerce.com.br/AdminWebService/Service.svc");
            webRequest.ContentType = "text/xml;charset=\"utf-8\"";
            webRequest.Accept = "text/xml";
            webRequest.Method = "POST";
            webRequest.Headers["SOAPAction"] = "http://tempuri.org/IService/StockKeepingUnitEspecificationInsert";
            webRequest.Headers["Authorization"] = "Basic userAndPassBase64Encoded";
            return webRequest;
        }

        static void Main(string[] args)
        {
            Execute();
        }
    }