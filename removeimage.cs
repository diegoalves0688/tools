using System;
using System.Net;
using System.IO;
using System.Xml;

namespace MakeAPOST
{


    class Program
        {
    
            public static void Execute()
            {
                HttpWebRequest request = CreateWebRequest();
                XmlDocument soapEnvelopeXml = new XmlDocument();
                soapEnvelopeXml.LoadXml(@"<?xml version=""1.0"" encoding=""utf-8""?>
                    <soapenv:Envelope xmlns:soapenv=""http://schemas.xmlsoap.org/soap/envelope/"" xmlns:tem=""http://tempuri.org/""><soapenv:Header/><soapenv:Body><tem:StockKeepingUnitImageRemove><tem:stockKeepingUnitId>11</tem:stockKeepingUnitId></tem:StockKeepingUnitImageRemove></soapenv:Body></soapenv:Envelope>");
    
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
                HttpWebRequest webRequest = (HttpWebRequest)WebRequest.Create(@"http://webservice-lojadosuporte.vtexcommerce.com.br/AdminWebService/Service.svc");
                webRequest.Headers.Add(@"SOAP:Action");
                webRequest.ContentType = "text/xml;charset=\"utf-8\"";
                webRequest.Accept = "text/xml";
                webRequest.Method = "POST";
                webRequest.Headers.Add(@"Authorization", "Basic ZGl==");
                webRequest.Headers.Add(@"SOAPAction", "http://tempuri.org/IService/StockKeepingUnitImageRemove");
                return webRequest;
            }
    
            static void Main(string[] args)
            {
                Execute();
            }
        }
    
}    
