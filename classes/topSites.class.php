<?php
!defined( 'ABSPATH' ) ? exit : '';

/**
 * Make a request for AWIS for top sites.
 *
 * Taken from AWS Sample Code & Libraries. 
 * This has been modified to get global sites and specifies a number of return instead of countries.
 *
 * @source http://aws.amazon.com/code/Alexa-Top-Sites?browse=1
 * @since 1.2.0
 * @author Ian Tumulak
 * @return Array of sites
 */

class TopSites {

    protected static $ActionName        = 'TopSites';
    protected static $ResponseGroupName = 'Country';
    protected static $ServiceHost       = 'ats.amazonaws.com';
    //protected static $NumReturn         = 50;
    //protected static $StartNum          = 1;
    protected static $SigVersion        = '2';
    protected static $HashAlgorithm     = 'HmacSHA256';   

    public function TopSites($accessKeyId, $secretAccessKey, $StartNum, $NumReturn) {
        $this->accessKeyId     = $accessKeyId;
        $this->secretAccessKey = $secretAccessKey;
        $this->NumReturn       = $NumReturn;
		$this->StartNum        = $StartNum;
    }

    /**
     * Get top sites from ATS
     */ 
    public function getTopSites() {
        $queryParams = $this->buildQueryParams();
        $sig = $this->generateSignature($queryParams);
        $url = 'http://' . self::$ServiceHost . '/?' . $queryParams . 
            '&Signature=' . $sig;
		
        $ret = self::makeRequest($url);
        return self::parseResponse($ret);
    }

    /**
     * Builds an ISO 8601 timestamp for request
     */
    protected static function getTimestamp() {
        return gmdate("Y-m-d\TH:i:s.\\0\\0\\0\\Z", time());
    }

    /**
     * Builds the url for the request to ATS
     * The url will be urlencoded as per RFC 3986 and the uri params
     * will be in alphabetical order
     */
    protected function buildQueryParams() {
        $params = array(
            'Action'            => self::$ActionName,
            'ResponseGroup'     => self::$ResponseGroupName,
            'AWSAccessKeyId'    => $this->accessKeyId,
            'Timestamp'         => self::getTimestamp(),
            //'CountryCode'       => $this->countryCode,
            'Count'             => $this->NumReturn,
            'Start'             => $this->StartNum,
            'SignatureVersion'  => self::$SigVersion,
            'SignatureMethod'   => self::$HashAlgorithm
        );
        ksort($params);
        $keyvalue = array();
        foreach($params as $k => $v) {
            $keyvalue[] = $k . '=' . rawurlencode($v);
        }
        return implode('&',$keyvalue);
    }

    /**
     * Makes an http request
     *
     * @param $url      URL to make request to
     * @return String   Result of request
     */
    protected static function makeRequest($url) {
        //print_r("Making request to: \n$url\n");
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 4);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    /**
     * Parses the XML response from ATS and echoes the DataUrl element 
     * for each returned site
     *
     * @param String $response    xml response from ATS
     */
    protected static function parseResponse($response) {
       // echo "\nSites: \n";
	   //error_reporting(0); // Remove all error
	   global $wpdb;
	    $results = array();
        $xml = new SimpleXMLElement($response,null, false, 
                                    'http://ats.amazonaws.com/doc/2005-11-21');
		
		if( $xml ){
			foreach($xml->Response->TopSitesResult->Alexa->TopSites->Country->Sites->children('http://ats.amazonaws.com/doc/2005-11-21') as $site) {
				//set_time_limit(300); //  Increased the timeout
				$results[] = (string) $site->DataUrl;
			}
		}
		return $results;
    }

    /**
     * Generates a signature per RFC 2104
     *
     * @param String $queryParams query parameters to use in creating signature
     * @return String             signature
     */
    protected function generateSignature($queryParams) {
        $sign = "GET\n" . strtolower(self::$ServiceHost) . "\n/\n". $queryParams;
        //echo "String to sign: \n" . $sign . "\n\n";
        $sig = base64_encode(hash_hmac('sha256', $sign, $this->secretAccessKey, true));
        return rawurlencode($sig);
    }

}
?>