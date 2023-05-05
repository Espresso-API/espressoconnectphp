<?php
namespace Espresso\Example;


require_once("../src/EspressoApi.php");


use Espresso\EspressoApi;

class EspressoApiTest {

    private $espressoApi;
    private $accessToken;
    private $apiKey;

    public function __construct() {
        $this->apiKey = "enter-your-apiKey";
        $this->accessToken = "enter-your-accessToken";
        $this->espressoApi = new EspressoApi();
    }

    public function testGetLoginURL() {
        $vendorKey = null;
        $loginUrl = $this->espressoApi->getLoginURL($this->apiKey,$vendorKey);
          echo "Login URL: <a href=\"$loginUrl\">$loginUrl</a>\n";
    }

    public function testGenerateToken() {
        $requestToken = "enter-your-requestToken";
        $secretKey = "enter-your-secretKey";
       
        $state = "12345";
         // Call method under test
         $response = $this->espressoApi->generateToken($requestToken, $secretKey, $this->apiKey,$state);

         // Verify response
         if (empty($response)) {
             echo 'Response is empty';
         }
         if (!json_decode($response)) {
             echo 'Response is not valid JSON';
         }
         die;
     }
     public function testPlaceOrder() {
        $params = array(
            'customerId' => 0000000,
            'scripCode' => 35019,
            'tradingSymbol' => 'NIFTY',
            'exchange' => 'NF',
            'transactionType' => 'B',
            'quantity' => 50,
            'disclosedQty' => 0,
            'executedQty' => 0,
            'price' => '0',
            'triggerPrice' => '0',
            'rmsCode' => 'ANY',
            'afterHour' => 'N',
            'orderType' => 'NORMAL',
            'channelUser' => '0000000',
            'validity' => 'GFD',
            'requestType' => 'NEW',
            'productType' => 'CNF',
            'instrumentType' => 'FI',
            'strikePrice' => '-1',
            'optionType' => 'XX',
            'expiry' => '27/04/2023'
        );
        // Call method under test
        $response = $this->espressoApi->placeOrder($params, $this->apiKey, $this->accessToken);
        
    
        // Verify response
        if (empty($response)) {
            echo 'Response is empty';
        }
        if (!json_decode($response)) {
            echo 'Response is not valid JSON';
        }
        die;
    }

    public function testModifyOrder() {
        $params = array(
            'orderId' => 0000000,
            'customerId' => 0000000,
            'scripCode' => 5657,
            'tradingSymbol' => 'USDINR',
            'exchange' => 'RN',
            'transactionType' => 'B',
            'quantity' => 2,
            'disclosedQty' => 0,
            'executedQty' => 0,
            'price' => '76',
            'triggerPrice' => '0',
            'rmsCode' => 'ANY',
            'afterHour' => 'N',
            'orderType' => 'NORMAL',
            'channelUser' => '0000000',
            'validity' => 'GFD',
            'requestType' => 'MODIFY',
            'productType' => 'CNF',
            'instrumentType' => 'FUTCUR',
            'strikePrice' => '-1',
            'optionType' => 'XX',
            'expiry' => '21/04/2023'
        );
        // Call method under test
        $response = $this->espressoApi->modifyOrder($params, $this->apiKey, $this->accessToken);
        
        // Verify response
        if (empty($response)) {
            echo 'Response is empty';
        }
        if (!json_decode($response)) {
            echo 'Response is not valid JSON';
        }
        die;
    }
    public function testCancelOrder() {
        $params = array(
            'orderId' => 0000000,
            'customerId' => 0000000,
            'scripCode' => 2475,
            'tradingSymbol' => 'ONGC',
            'exchange' => 'NC',
            'transactionType' => 'B',
            'quantity' => 1,
            'disclosedQty' => 0,
            'executedQty' => 0,
            'price' => '92.50',
            'triggerPrice' => '0',
            'rmsCode' => 'ANY',
            'afterHour' => 'N',
            'orderType' => 'NORMAL',
            'channelUser' => '0000000',
            'validity' => 'GFD',
            'requestType' => 'CANCEL',
            'productType' => 'CNC',
            'instrumentType' => 'FS',
            'strikePrice' => '-1',
            'optionType' => 'XX',
            'expiry' => '28/04/2023'
        );
        // Call method under test
        $response = $this->espressoApi->cancelOrder($params, $this->apiKey, $this->accessToken);
      
    
        // Verify response
        if (empty($response)) {
            echo 'Response is empty';
        }
        if (!json_decode($response)) {
            echo 'Response is not valid JSON';
        }
        die;
    }
    public function testFunds() {
        $exchange = "RN";
        $customerId = "0000000";
        // Call method under test
        $response = $this->espressoApi->getFunds($exchange,$customerId, $this->apiKey, $this->accessToken);
        
       // Verify response
if (empty($response)) {
    echo 'Response is empty';
    }
    if (!json_decode($response)) {
    echo 'Response is not valid JSON';
    }
    die;

    }
    
    public function testReports() {
        $customerId = "0000000";
        // Call method under test
        $response = $this->espressoApi->getReports($customerId, $this->apiKey, $this->accessToken);
    
   // Verify response
   if (empty($response)) {
    echo 'Response is empty';
}
if (!json_decode($response)) {
    echo 'Response is not valid JSON';
}
die;

    }
    public function testPositions() {
        $customerId = "0000000";
        // Call method under test
        $response = $this->espressoApi->getPositions($customerId, $this->apiKey, $this->accessToken);
    
   // Verify response
   if (empty($response)) {
    echo 'Response is empty';
}
if (!json_decode($response)) {
    echo 'Response is not valid JSON';
}
die;
 }
 public function testHistory() {
    $exchange = "NF";
    $customerId = "0000000";
    $orderId = "0000000";
    // Call method under test
    $response = $this->espressoApi->getHistory($exchange,$customerId,$orderId, $this->apiKey, $this->accessToken);

// Verify response
if (empty($response)) {
echo 'Response is empty';
}
if (!json_decode($response)) {
echo 'Response is not valid JSON';
}
die;
}
public function testTrades() {
    $exchange = "NC";
    $customerId = "0000000";
    $orderId = "0000000";
    // Call method under test
    $response = $this->espressoApi->getTrades($exchange,$customerId,$orderId, $this->apiKey, $this->accessToken);

// Verify response
if (empty($response)) {
echo 'Response is empty';
}
if (!json_decode($response)) {
echo 'Response is not valid JSON';
}
die;
}
public function testCancelById() {
   
    $orderId = "0000000";
    // Call method under test
    $response = $this->espressoApi->cancelById($orderId, $this->apiKey, $this->accessToken);

// Verify response
if (empty($response)) {
echo 'Response is empty';
}
if (!json_decode($response)) {
echo 'Response is not valid JSON';
}
die;
}
public function testHoldings() {
   
    $customerId = "0000000";
    // Call method under test
    $response = $this->espressoApi->getHoldings($customerId, $this->apiKey, $this->accessToken);

// Verify response
if (empty($response)) {
echo 'Response is empty';
}
if (!json_decode($response)) {
echo 'Response is not valid JSON';
}
die;
}
public function testActiveScrips() {
   
    $exchange = "NC";
    // Call method under test
    $response = $this->espressoApi->getActiveScrips($exchange, $this->apiKey, $this->accessToken);

// Verify response
if (empty($response)) {
echo 'Response is empty';
}
if (!json_decode($response)) {
echo 'Response is not valid JSON';
}
die;
}
public function testSymbol() {
   
    $exchange = "NC";
    // Call method under test
    $response = $this->espressoApi->getSymbol($exchange, $this->apiKey, $this->accessToken);

// Verify response
if (empty($response)) {
echo 'Response is empty';
}
if (!json_decode($response)) {
echo 'Response is not valid JSON';
}
die;
}
public function testHistorical() {
   
    $exchange = "MX";
    $scripcode = "251800";
    $interval = "daily";
    // Call method under test
    $response = $this->espressoApi->getHistorical($exchange,$scripcode,$interval, $this->apiKey, $this->accessToken);

// Verify response
if (empty($response)) {
echo 'Response is empty';
}
if (!json_decode($response)) {
echo 'Response is not valid JSON';
}
die;
}

}
$test = new EspressoApiTest();
// $test->testGetLoginURL();
$test->testgenerateToken();
// $test->testPlaceOrder();
// $test->testModifyOrder();
// $test->testCancelOrder();
// $test->testFunds();
// $test->testReports();
// $test->testPositions();
// $test->testHistory();
// $test->testTrades();
// $test->testCancelById();
// $test->testHoldings();
// $test->testActiveScrips();
// $test->testSymbol();
// $test->testHistorical();
?>
<!-- <script src="http://localhost/espresso/src/socket.js"></script><script type="text/javascript">
    var accesstoken = 'enter-your-accesstoken';
    var feedName = 'ltp';
    var feedValue = 'RN5657';
    websocket(accesstoken, feedName, feedValue);
</script> -->












