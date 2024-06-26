<?php
function call_api(string $url, string $method, array $payload = null)
{
    $curl = curl_init();
    // echo $url;
    curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_SSL_VERIFYHOST => 0,
        CURLOPT_SSL_VERIFYPEER => 0,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => $method,
    ));
    if ($method == "POST") {
        // echo "post";
        // $headerSent = curl_getinfo($curl, CURLINFO_HEADER_OUT, true);
        // echo $headerSent;
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($curl, CURLINFO_HEADER_OUT, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            "authorization: xAsoOGfahZVrT1tz8Xvc3UJeBYdmynw64INK2DiRSuEHb5kMqCP4WV8muxEkfh0MnrbABU3psiTDOtaz",
            "accept: */*",
            "cache-control: no-cache",
            "Content-Type:application/json"
        ));
        
    }
    
    $response = curl_exec($curl);
    // print_r($response);
    return json_decode($response, true);
}
