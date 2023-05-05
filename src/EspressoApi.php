<?php
namespace Espresso; 
session_start();
require_once("includes/EspressoConfigrationManage.php");	


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class EspressoApi
{
    public static function CurlOperation($url, $data = false, $headers = array(), $method = 'GET')
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
    if ($method == 'POST' && $data) {
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    }
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $response = curl_exec($ch);
    curl_close($ch);

    return $response;
}
    function getLoginURL($apiKey, $vendorKey) {
        $Configration = EspressoConfigrationManage::EspressoConfigrationData();
        $baseUrl = $Configration["login"] . "?api_key=" . urlencode($apiKey);
      
        if ($vendorKey != null) {
            $baseUrl .= "&vendor_key=" . urlencode($vendorKey) . "&state=12345";
            return $baseUrl;
        } else {
            echo "no vendor key \n ";
        }
        $baseUrl .= "&state=12345";
        return $baseUrl;
    }

    private function decryptAPIString($requestToken, $secretKey) {
        $key = $secretKey;
        // echo $key;
        $iv = base64_decode("AAAAAAAAAAAAAAAAAAAAAA==");
    
        // Decrypt request token using provided decryption algorithm
        $cipher = "aes-256-gcm";
        $tag_length = 16;
        $requestToken = base64_decode(strtr($requestToken, '-_', '+/'));
        $enc = substr($requestToken, 0, -$tag_length);
        $tag = substr($requestToken, -$tag_length);
    
        return openssl_decrypt($enc, $cipher, $key, OPENSSL_RAW_DATA, $iv, $tag);
    }

    private function encryptAPIString($plaintext,$secretKey){
     $key = $secretKey;
     $iv = base64_decode("AAAAAAAAAAAAAAAAAAAAAA==");
     $raw = utf8_encode($plaintext);
     $ciphertext = openssl_encrypt($raw, "aes-256-gcm", $key, OPENSSL_RAW_DATA, $iv, $tag, "", 16);
     return rtrim(strtr(base64_encode($ciphertext . $tag), "+/", "-_"), "=");
    }

    public function generateToken($requestToken, $secretKey,$apiKey,$state) {
      
        // Decrypt the request token using the provided secret key
        $decryptedToken = $this->decryptAPIString($requestToken, $secretKey);
       
        // Split the string by the pipe operator
        $array = explode('|', $decryptedToken);

        // Rearrange the array elements
        $newArray = array($array[1], $array[0]);

        // Join the array elements back into a string with the pipe operator
        $newString = implode('|', $newArray);
        // echo $newString;
        $encryptedToken = $this->encryptAPIString($newString, $secretKey); 
        // echo $encryptedToken;
        $token =$encryptedToken;
        // echo $token;
        // Build the post data array
    $postData = array(
        'apiKey' => "$apiKey",
        'requestToken' => "$encryptedToken",
        'state' => $state
    );
    $headers = array(
        'Content-Type: application/json'
    );
    $path= EspressoConfigrationManage::EspressoConfigrationData();
    $root=$path['root'].$path['token'];

    $response  =   self::CurlOperation($root, $postData, $headers, 'POST');
   
        $responseData = array(
      
            'response' => json_decode($response, true)
        );
    
        header('Content-Type: application/json');
        echo json_encode($responseData, JSON_PRETTY_PRINT);
    
        return $response;
     
    }



public function placeOrder($params,$apiKey,$accessToken) {
    $postData = array(
        'customerId' => $params['customerId'],
        'scripCode' => $params['scripCode'],
        'tradingSymbol' => $params['tradingSymbol'],
        'exchange' => $params['exchange'],
        'transactionType' => $params['transactionType'],
        'quantity' => $params['quantity'],
        'disclosedQty' => $params['disclosedQty'],
        'executedQty' => $params['executedQty'],
        'price' => $params['price'],
        'triggerPrice' => $params['triggerPrice'],
        'rmsCode' => $params['rmsCode'],
        'afterHour' => $params['afterHour'],
        'orderType' => $params['orderType'],
        'channelUser' => $params['channelUser'],
        'validity' => $params['validity'],
        'requestType' => $params['requestType'],
        'productType' => $params['productType'],
        'instrumentType' => $params['instrumentType'],
        'strikePrice' => $params['strikePrice'],
        'optionType' => $params['optionType'],
        'expiry' => $params['expiry']
    );
   
    $path = EspressoConfigrationManage::EspressoConfigrationData();
    $root = $path['root'].$path['place'];

    // Set headers
    $headers = array(
        'access-token: ' . $accessToken,
        'api-key: ' . $apiKey,
        'Content-Type: application/json'
    );
$response  =   self::CurlOperation($root, $postData, $headers, 'POST');
$responseData = array(
      
        'response' => json_decode($response, true)
    );

    header('Content-Type: application/json');
    echo json_encode($responseData, JSON_PRETTY_PRINT);

    return $response;
}
public function modifyOrder($params,$apiKey,$accessToken) {
    $postData = array(
        'orderId' => $params['orderId'],
        'customerId' => $params['customerId'],
        'scripCode' => $params['scripCode'],
        'tradingSymbol' => $params['tradingSymbol'],
        'exchange' => $params['exchange'],
        'transactionType' => $params['transactionType'],
        'quantity' => $params['quantity'],
        'disclosedQty' => $params['disclosedQty'],
        'executedQty' => $params['executedQty'],
        'price' => $params['price'],
        'triggerPrice' => $params['triggerPrice'],
        'rmsCode' => $params['rmsCode'],
        'afterHour' => $params['afterHour'],
        'orderType' => $params['orderType'],
        'channelUser' => $params['channelUser'],
        'validity' => $params['validity'],
        'requestType' => $params['requestType'],
        'productType' => $params['productType'],
        'instrumentType' => $params['instrumentType'],
        'strikePrice' => $params['strikePrice'],
        'optionType' => $params['optionType'],
        'expiry' => $params['expiry']
    );
    $path = EspressoConfigrationManage::EspressoConfigrationData();
    $root = $path['root'].$path['modify'];

    // Set headers
    $headers = array(
        'access-token: ' . $accessToken,
        'api-key: ' . $apiKey,
        'Content-Type: application/json'
    );
   
    $response  =   self::CurlOperation($root, $postData, $headers, 'POST');

    $responseData = array(
      
        'response' => json_decode($response, true)
    );

    header('Content-Type: application/json');
    echo json_encode($responseData, JSON_PRETTY_PRINT);

    return $response;
}

public function cancelOrder($params,$apiKey,$accessToken) {
    $postData = array(
        'orderId' => $params['orderId'],
        'customerId' => $params['customerId'],
        'scripCode' => $params['scripCode'],
        'tradingSymbol' => $params['tradingSymbol'],
        'exchange' => $params['exchange'],
        'transactionType' => $params['transactionType'],
        'quantity' => $params['quantity'],
        'disclosedQty' => $params['disclosedQty'],
        'executedQty' => $params['executedQty'],
        'price' => $params['price'],
        'triggerPrice' => $params['triggerPrice'],
        'rmsCode' => $params['rmsCode'],
        'afterHour' => $params['afterHour'],
        'orderType' => $params['orderType'],
        'channelUser' => $params['channelUser'],
        'validity' => $params['validity'],
        'requestType' => $params['requestType'],
        'productType' => $params['productType'],
        'instrumentType' => $params['instrumentType'],
        'strikePrice' => $params['strikePrice'],
        'optionType' => $params['optionType'],
        'expiry' => $params['expiry']
    );
    $path = EspressoConfigrationManage::EspressoConfigrationData();
    $root = $path['root'].$path['cancel'];

    // Set headers
    $headers = array(
        'access-token: ' . $accessToken,
        'api-key: ' . $apiKey,
        'Content-Type: application/json'
    );
   
    $response  =   self::CurlOperation($root, $postData, $headers, 'POST');

    $responseData = array(
      
        'response' => json_decode($response, true)
    );

    header('Content-Type: application/json');
    echo json_encode($responseData, JSON_PRETTY_PRINT);

    return $response;
}
public function getFunds($exchange,$customerId, $apiKey, $accessToken) {
    $path = EspressoConfigrationManage::EspressoConfigrationData();
    $root = $path['root'] . $path['funds'] . '/' . $exchange. '/' . $customerId;

    // Set headers
    $headers = array(
        'access-token: ' . $accessToken,
        'api-key: ' . $apiKey,
        'Content-Type: application/json'
    );
    $response = self::CurlOperation($root, false, $headers, 'GET');

    $responseData = array(
      
        'response' => json_decode($response, true)
    );

    header('Content-Type: application/json');
    echo json_encode($responseData, JSON_PRETTY_PRINT);

    return $response;
}
public function getReports($customerId, $apiKey, $accessToken) {
    $path = EspressoConfigrationManage::EspressoConfigrationData();
    $root = $path['root'] . $path['report'] . '/' . $customerId;
    $headers = array(
        'access-token: ' . $accessToken,
        'api-key: ' . $apiKey,
        'Content-Type: application/json'
    );
    $response = self::CurlOperation($root, false, $headers, 'GET');
    $responseData = array(
        'response' => json_decode($response, true)
    );
     header('Content-Type: application/json');
    echo json_encode($responseData, JSON_PRETTY_PRINT);
    return $response;
}
public function getPositions($customerId, $apiKey, $accessToken) {
    $path = EspressoConfigrationManage::EspressoConfigrationData();
    $root = $path['root'] . $path['position'] . '/' . $customerId;
    $headers = array(
        'access-token: ' . $accessToken,
        'api-key: ' . $apiKey,
        'Content-Type: application/json'
    );
    $response = self::CurlOperation($root, false, $headers, 'GET');
    $responseData = array(
        'response' => json_decode($response, true)
    );
     header('Content-Type: application/json');
    echo json_encode($responseData, JSON_PRETTY_PRINT);
    return $response;
}
public function getHistory($exchange,$customerId,$orderId, $apiKey, $accessToken) {
    $path = EspressoConfigrationManage::EspressoConfigrationData();
    $root = $path['root'] . $path['history'] . '/' . $exchange . '/' . $customerId . '/' . $orderId;
    $headers = array(
        'access-token: ' . $accessToken,
        'api-key: ' . $apiKey,
        'Content-Type: application/json'
    );
    $response = self::CurlOperation($root, false, $headers, 'GET');
    $responseData = array(
        'response' => json_decode($response, true)
    );
     header('Content-Type: application/json');
    echo json_encode($responseData, JSON_PRETTY_PRINT);
    return $response;
}
public function getTrades($exchange,$customerId,$orderId, $apiKey, $accessToken) {
    $path = EspressoConfigrationManage::EspressoConfigrationData();
    $root = $path['root'] . $path['trades'] . '/' . $exchange . '/' . $customerId . '/' . $orderId . '/trades';
    $headers = array(
        'access-token: ' . $accessToken,
        'api-key: ' . $apiKey,
        'Content-Type: application/json'
    );
    $response = self::CurlOperation($root, false, $headers, 'GET');
    $responseData = array(
        'response' => json_decode($response, true)
    );
     header('Content-Type: application/json');
    echo json_encode($responseData, JSON_PRETTY_PRINT);
    return $response;
}
public function cancelById($orderId, $apiKey, $accessToken) {
    $path = EspressoConfigrationManage::EspressoConfigrationData();
    $root = $path['root'] . $path['cancelById'] . '/' . $orderId ;
    $headers = array(
        'access-token: ' . $accessToken,
        'api-key: ' . $apiKey,
        'Content-Type: application/json'
    );
    $response = self::CurlOperation($root, false, $headers, 'GET');
    $responseData = array(
        'response' => json_decode($response, true)
    );
     header('Content-Type: application/json');
    echo json_encode($responseData, JSON_PRETTY_PRINT);
    return $response;
}
public function getHoldings($customerId, $apiKey, $accessToken) {
    $path = EspressoConfigrationManage::EspressoConfigrationData();
    $root = $path['root'] . $path['holdings'] . '/' . $customerId ;
    $headers = array(
        'access-token: ' . $accessToken,
        'api-key: ' . $apiKey,
        'Content-Type: application/json'
    );
    $response = self::CurlOperation($root, false, $headers, 'GET');
    $responseData = array(
        'response' => json_decode($response, true)
    );
     header('Content-Type: application/json');
    echo json_encode($responseData, JSON_PRETTY_PRINT);
    return $response;
}
public function getActiveScrips($exchange, $apiKey, $accessToken) {
    $path = EspressoConfigrationManage::EspressoConfigrationData();
    $root = $path['root'] . $path['master'] . '/' . $exchange ;
    $headers = array(
        'access-token: ' . $accessToken,
        'api-key: ' . $apiKey,
        'Content-Type: application/json'
    );
    $response = self::CurlOperation($root, false, $headers, 'GET');
    $responseData = array(
        'response' => json_decode($response, true)
    );
     header('Content-Type: application/json');
    echo json_encode($responseData, JSON_PRETTY_PRINT);
    return $response;
}
public function getSymbol($exchange, $apiKey, $accessToken) {
    $path = EspressoConfigrationManage::EspressoConfigrationData();
    $root = $path['root'] . $path['symbol'] . '/' . $exchange ;
    $headers = array(
        // 'access-token: ' . $accessToken,
        'api-key: ' . $apiKey,
        'Content-Type: application/json'
    );
    $response = self::CurlOperation($root, false, $headers, 'GET');
    echo $response;
    return $response;
}
public function getHistorical($exchange,$scripcode,$interval,$apiKey,$accessToken) {
    $path = EspressoConfigrationManage::EspressoConfigrationData();
    $root = $path['root'] . $path['historical'] . '/' . $exchange . '/' . $scripcode . '/' . $interval;
    $headers = array(
        'access-token: ' . $accessToken,
        'api-key: ' . $apiKey,
        'Content-Type: application/json'
    );
   
    $response = self::CurlOperation($root, false, $headers, 'GET');
    echo $response;
    $responseData = array(
        'response' => json_decode($response, true)
    );
     header('Content-Type: application/json');
    echo json_encode($responseData, JSON_PRETTY_PRINT);
    return $response;
}


}

?>
