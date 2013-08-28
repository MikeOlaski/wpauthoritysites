<?php
add_action( 'wp_ajax_evaluate_js', 'evaluate_js_callback');
define('GOOGLE_MAGIC', 0xE6359A60);

function evaluate_js_callback( $args = null ){
	
	set_time_limit(500); //  Increased the timeout
	
	// Set fields to evaluate for
	$fors = array(
		// General
		'date-founded' => 'awp-date',
		'location' => 'awp-location',
		'language' => 'awp-language',
		
		// Shares and Likes
		'googleplus' => 'awp-shares-goolgeplus',
		'facebook-shares' => 'awp-shares-facebook',
		'facebook-likes' => 'awp-likes-facebook',
		'twitter' => 'awp-shares-twitter',
		'pinterest' => 'awp-shares-pinterest',
		'linkedin' => 'awp-shares-linkedin',
		
		// Network
		'facebook-page' => 'awp-facebook',
		'googleplus-page' => 'awp-googleplus', // Pending
		'twitter-page' => 'awp-twitter',
		'pinterest-page' => 'awp-pinterest', // No page
		'linkedin-page' => 'awp-linkedin', // No page
		
		// Links
		'google-links' => 'awp-google',
		'alexa-links' => 'awp-alexa',
		'yahoo-links' => 'awp-yahoo',
		'majestic-links' => 'awp-majestic',
		
		// Ranks
		'alexa-rank' => 'awp-alexa-rank',
		'google-rank' => 'awp-google-rank',
		'compete-rank' => 'awp-compete-rank',
		'semrush-rank' => 'awp-semrush-rank',
		'one-rank' => 'awp-one-rank'
	);
	
	if( isset($_POST) && '' != $_POST['url'] ){
		$url = $_POST['url'];
		$id = $_POST['id'];
		$die = true;
	} else {
		$url = $args['url'];
		$id = $args['id'];
	}
	
	// Get values of each fields
	$return = array();
	foreach( $fors as $label=>$for ){
		$return[$for] = awp_evaluate($url, $for);
	}
	
	if( !empty($return) ){
		$name = str_replace('http://', '', $url);
		$name = str_replace('www.', '', $name);
		
		$domains = explode('.', $name);
		$slugCount = count($domains);
		$domain = '';
		$i = 1;
		foreach($domains as $sg){
			if($i < $slugCount){
				if('www' != $sg){
					if( $i == 1){
						$domain .= $sg;
					} else {
						$domain .= '.'.$sg;
					}
				}
			}
			$i++;
		}
		
		update_post_meta($id, 'awp-name', $name);
		update_post_meta($id, 'awp-domain', $domain);
		update_post_meta($id, 'awp-tld', '.' . $domains[$slugCount - 1]);
		update_post_meta($id, 'awp-url', 'http://www.'.$name);
		
		foreach( $return as $meta_key=>$meta_value ){
			update_post_meta($id, $meta_key, $meta_value);
		}
		if($die){
			echo 'true';
		} else {
			return true;
		}
	} else {
		if($die){
			echo 'false';
		}
		 else {
			return false;
		}
	}
	
	if($die){
		die();
	}
}

function awp_evaluate($url, $for){
	switch( $for ){
		// General
		case 'awp-language':
			return awp_sharecounts($url, 'language');
		
		case 'awp-location':
			return awp_sharecounts($url, 'location');
		
		case 'awp-date':
			return awp_sharecounts($url, 'founded');
		
		// Shares and likes
		case 'awp-shares-goolgeplus':
			return awp_sharecounts($url, 'googlePlus');
		
		case 'awp-shares-facebook':
			return awp_sharecounts($url, 'facebookShares');
		
		case 'awp-likes-facebook':
			return awp_sharecounts($url, 'facebookLikes');
		
		case 'awp-shares-twitter':
			return awp_sharecounts($url, 'twitterShares');
		
		case 'awp-shares-pinterest':
			return awp_sharecounts($url, 'pinterest');
		
		case 'awp-shares-linkedin':
			return awp_sharecounts($url, 'linkedin');
		
		// Network
		case 'awp-facebook':
			return awp_sharecounts($url, 'facebookPage');
		
		case 'awp-googleplus':
			return awp_sharecounts($url, 'googleplusPage');
		
		case 'awp-twitter':
			return awp_sharecounts($url, 'twitterPage');
		
		case 'awp-pinterest':
			return awp_sharecounts($url, 'pinterestPage');
		
		case 'awp-linkedin':
			return awp_sharecounts($url, 'linkedinPage');
		
		// Links
		case 'awp-google':
			return awp_sharecounts($url, 'googleBackLinks');
		
		case 'awp-alexa':
			return awp_sharecounts($url, 'alexaBackLinks');
		
		case 'awp-yahoo':
			return awp_sharecounts($url, 'yahooBackLinks');
		
		case 'awp-majestic':
			return awp_sharecounts($url, 'majesticBackLinks');
		
		// Ranks
		case 'awp-alexa-rank':
			return awp_sharecounts($url, 'alexaRank');
		
		case 'awp-google-rank':
			return awp_sharecounts($url, 'googleRank');
		
		case 'awp-compete-rank':
			return awp_sharecounts($url, 'competeRank');
	}
}

function awp_sharecounts($url, $type){
	$settings = get_option('awp_settings');
	
	if(filter_var($url, FILTER_VALIDATE_URL)){
		// Shares and Likes
		if($type == 'googlePlus'){
			//source http://www.helmutgranda.com/2011/11/01/get-a-url-google-count-via-php/
			$content = parse("https://plusone.google.com/u/0/_/+1/fastbutton?url=".$url."&count=true");
		  
			$dom = new DOMDocument;
			$dom->preserveWhiteSpace = false;
			@$dom->loadHTML($content);
			$domxpath = new DOMXPath($dom);
			$newDom = new DOMDocument;
			$newDom->formatOutput = true;
			
			$filtered = $domxpath->query("//div[@id='aggregateCount']");
			if (isset($filtered->item(0)->nodeValue)){
				// $count = str_replace('>', '', $filtered->item(0)->nodeValue);
				return str_replace('>', '', $filtered->item(0)->nodeValue);
			}
		
		} else if($type == 'facebookShares'){
			$content = parse_curl("https://graph.facebook.com/fql?q=SELECT%20url,%20share_count%20FROM%20link_stat%20WHERE%20url='".$url."'");
			$content = json_decode( $content );
			return $content->data[0]->share_count;
		
		} else if($type == 'facebookLikes'){
			$content = parse_curl("https://graph.facebook.com/fql?q=SELECT%20url,%20like_count%20FROM%20link_stat%20WHERE%20url='".$url."'");
			$content = json_decode( $content );
			return $content->data[0]->like_count;
			
		} else if($type == 'twitterShares'){
			$content = parse_curl("http://urls.api.twitter.com/1/urls/count.json?url=".$url);
			$content = json_decode( $content );
			return $content->count;
			
			/* Using Twitter API v1.1 just to be ready if they decprecate the v1.0
			if( class_exists('TwitterAPIExchange') ){
				
				$twittings = array(
					'oauth_access_token' => $settings['twitter_access_token'],
					'oauth_access_token_secret' => $settings['twitter_access_secret'],
					'consumer_key' => $settings['twitter_cons_key'],
					'consumer_secret' => $settings['twitter_cons_secret']
				);
				
				$url = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
				$getfield = '?screen_name=Android';
				$requestMethod = 'GET';
				$twitter = new TwitterAPIExchange( $twittings );
				$follow_count=$twitter->setGetfield($getfield)->buildOauth($url, $requestMethod)->performRequest();
				$testCount = json_decode($follow_count, true);
				
				return $testCount[0]['user']['followers_count'];
			} else {
				return 0;
			}
			*/
		
		} else if($type == 'pinterest'){
			$content = parse_curl("http://api.pinterest.com/v1/urls/count.json?callback=&url=".$url);
			$content = json_decode( str_replace(array('(', ')'), array('', ''), $content) );
			if (is_int($content->count)){
				return $content->count;
			} else {
				return 0;
			}
		
		} else if($type == 'linkedin'){
			$content = parse_curl("http://www.linkedin.com/countserv/count/share?format=json&url=".$url);
			$content = json_decode( $content );
			return $content->count;
		
		} else if($type == 'stumbleupon'){
			$content = parse("http://www.stumbleupon.com/services/1.01/badge.getinfo?url=$url");
			
			$result = json_decode($content);
			if (isset($result->result->views)){
				$count = $result->result->views;
			}
		
		// Site
		} else if($type == 'location'){
			$ip = gethostbyname( str_replace('http://www.', '', $url) );
			$content = parse_curl("http://www.geoplugin.net/php.gp?ip=".$ip);
			$content = unserialize( $content );
			return $content['geoplugin_city'] . ', ' . $content['geoplugin_countryName'];
		
		} else if($type == 'language'){
			$content = parse_curl('http://data.alexa.com/data?cli=10&dat=snbamz&url=' . $url);
			$xml = simplexml_load_string($content);
			return isset($xml->SD[0]->LANG) ? (string)$xml->SD[0]->LANG->attributes()->LEX : '';
		
		} else if($type == 'founded'){
			$content = parse_curl('http://data.alexa.com/data?cli=10&dat=snbamz&url=' . $url);
			$xml = simplexml_load_string($content);
			return isset($xml->SD[0]->CREATED) ? (string)$xml->SD[0]->CREATED->attributes()->DATE[0] : '';
		
		// Network
		} else if($type == 'facebookPage'){
			// http://graph.facebook.com/?id=http://reuters.com
			$content = parse_curl("http://graph.facebook.com/?id=".$url);
			$content = json_decode( $content );
			// return isset($content->name) ? 'https://www.facebook.com/' . $content->name : '';
			return parse_social_links($url, 'facebook');
		
		} else if($type == 'googleplusPage'){
			return parse_social_links($url, 'plus.google');
			// return 'https://plus.google.com/u/0/';
		
		} else if($type == 'twitterPage'){
			/*$domains = array(".aero",".biz",".cat",".com",".coop",".edu",".gov",".info",".int",".jobs",".mil",".mobi",".museum", ".name",".net",".org",".travel",".ac",".ad",".ae",".af",".ag",".ai",".al",".am",".an",".ao",".aq",".ar",".as",".at",".au",".aw", ".az",".ba",".bb",".bd",".be",".bf",".bg",".bh",".bi",".bj",".bm",".bn",".bo",".br",".bs",".bt",".bv",".bw",".by",".bz",".ca", ".cc",".cd",".cf",".cg",".ch",".ci",".ck",".cl",".cm",".cn",".co",".cr",".cs",".cu",".cv",".cx",".cy",".cz",".de",".dj",".dk",".dm", ".do",".dz",".ec",".ee",".eg",".eh",".er",".es",".et",".eu",".fi",".fj",".fk",".fm",".fo",".fr",".ga",".gb",".gd",".ge",".gf",".gg",".gh", ".gi",".gl",".gm",".gn",".gp",".gq",".gr",".gs",".gt",".gu",".gw",".gy",".hk",".hm",".hn",".hr",".ht",".hu",".id",".ie",".il",".im", ".in",".io",".iq",".ir",".is",".it",".je",".jm",".jo",".jp",".ke",".kg",".kh",".ki",".km",".kn",".kp",".kr",".kw",".ky",".kz",".la",".lb", ".lc",".li",".lk",".lr",".ls",".lt",".lu",".lv",".ly",".ma",".mc",".md",".mg",".mh",".mk",".ml",".mm",".mn",".mo",".mp",".mq", ".mr",".ms",".mt",".mu",".mv",".mw",".mx",".my",".mz",".na",".nc",".ne",".nf",".ng",".ni",".nl",".no",".np",".nr",".nu", ".nz",".om",".pa",".pe",".pf",".pg",".ph",".pk",".pl",".pm",".pn",".pr",".ps",".pt",".pw",".py",".qa",".re",".ro",".ru",".rw", ".sa",".sb",".sc",".sd",".se",".sg",".sh",".si",".sj",".sk",".sl",".sm",".sn",".so",".sr",".st",".su",".sv",".sy",".sz",".tc",".td",".tf", ".tg",".th",".tj",".tk",".tm",".tn",".to",".tp",".tr",".tt",".tv",".tw",".tz",".ua",".ug",".uk",".um",".us",".uy",".uz", ".va",".vc", ".ve",".vg",".vi",".vn",".vu",".wf",".ws",".ye",".yt",".yu",".za",".zm",".zr",".zw");
			
			$name = str_replace('http://', '', $url);
			$name = str_replace('www.', '', $name);
			$name = str_replace( $domains, array(''), $name);
			
			$twitter = 'https://twitter.com/' . $name;
			
			if( !url_exists( $twitter ) )
				return 0;
			
			return $twitter;*/
			return parse_social_links($url, 'twitter');
			
		} else if($type == 'pinterestPage'){
			return parse_social_links($url, 'pinterest');
		
		} else if($type == 'linkedinPage'){
			return parse_social_links($url, 'linkedin');
		
		// Links
		} else if($type == 'googleBackLinks'){
			
			/*$link = "http://ajax.googleapis.com/ajax/services/search/web?v=1.0&rsz=large&q=link:" . $url;
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $link);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_REFERER, $domain);
			$body = curl_exec($ch);
			curl_close($ch);
			
			$json = json_decode($body);
			$urls = array();
			foreach($json->responseData->results as $result) // Loop through the objects in the result
    			$urls[] = $result->unescapedUrl;
			
			return count($urls);*/
			
			$result_in_html = file_get_contents("http://www.google.com/search?q=link:{$url}");
			if (preg_match('/Results .*? of about (.*?) from/sim', $result_in_html, $regs)){
				$indexed_pages = trim(strip_tags($regs[1])); //use strip_tags to remove bold tags
				return $indexed_pages;
			} elseif (preg_match('/About (.*?) results/sim', $result_in_html, $regs)){
				$indexed_pages = trim(strip_tags($regs[1])); //use strip_tags to remove bold tags
				return $indexed_pages;
			} else {
				return 0;
			}
		
		} else if($type == 'alexaBackLinks'){
			$content = parse_curl('http://data.alexa.com/data?cli=10&dat=snbamz&url=' . $url);
			$xml = simplexml_load_string($content);
			return isset($xml->SD[0]->LINKSIN) ? number_format( (float)$xml->SD[0]->LINKSIN->attributes()->NUM[0] ) : '';
		
		} else if($type == 'yahooBackLinks'){
			$yapi = ($settings['yahoo_api_key']) ? $settings['yahoo_api_key'] : '2RWSO5rV34H1olTtqv201ziFbzAfZLgjWPWIV7hyOXQ1PI6qR914Fs2v6aIpVYcDb6yXnfN_';
			return 0;
		
		} else if($type == 'majesticBackLinks'){
			$api_key = $settings['majestic_api_key'];
			
			if(!$api_key)
				return;
			
			$endpoint = 'http://developer.majesticseo.com/api_command';
			
			$api_service = new APIService($api_key, $endpoint);
			$parameters = array();
			$parameters["datasource"] = "fresh";
			$parameters["MaxSourceURLs"] = 10;
			$parameters["URL"] = $url;
			$parameters["GetUrlData"] = 1;
			$parameters["MaxSourceURLsPerRefDomain"] = 1;
			$response = $api_service->executeCommand("GetTopBackLinks", $parameters);
			if ( $response->isOK() == "false" ){
				// echo "Error Occured" . $response->getErrorMessage(); exit;
				return 0;
			}
			$table = $response->getTableForName("URL");
			$rows = $table->getTableRows();
			$count = 1;
			foreach ( $rows as $row) {
				$count++;
				// echo "URL: ".$row["SourceURL"] ."\n"; echo "AC Rank: ".$row["ACRank"] ."\n";
			}
			return $count;
		
		// Rank
		} else if($type == 'alexaRank'){
			$content = parse_curl('http://data.alexa.com/data?cli=10&dat=snbamz&url=' . $url);
			$xml = simplexml_load_string($content);
			return isset( $xml->SD[1]->POPULARITY ) ? (string)$xml->SD[1]->POPULARITY->attributes()->TEXT : 0;
		
		} else if($type == 'googleRank'){
			$pr = getPageRank( $url );
			return $pr;
		
		} else if($type == 'competeRank'){
			$capi = ($settings['compete_api_key']) ? $settings['compete_api_key'] : 'ce9406ca48b0089750b76ded1ececaea';
			$name = str_replace('http://', '', $url);
			$name = str_replace('www.', '', $name);
			
			$content = parse_curl('http://apps.compete.com/sites/' . $name . '/trended/Rank/?apikey=' . $capi);
			$content = json_decode($content);
			return (string)$content->data->trends->rank[12]->value;
		}
	}
	return null;
}

function url_exists($url) {
    if (!$fp = curl_init($url)) return false;
	
	$file_headers = @get_headers( $url );
	if($file_headers[0] == '404 Not Found') {
		print_r( $file_headers );
		return false;
	}
	
    return true;
}

function parse_social_links($url, $type = 'facebook'){
	$ch = curl_init();
	$timeout = 5;
	$userAgent = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; .NET CLR 1.1.4322)'; // tell them we're Mozilla
	
	curl_setopt($ch, CURLOPT_USERAGENT, $userAgent);
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	curl_setopt($ch, CURLOPT_FAILONERROR, true);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($ch, CURLOPT_AUTOREFERER, true);
	
	$data = curl_exec($ch);
	curl_close($ch);
	
	$page = str_get_html($data);
	
	switch($type){
		case 'facebook':
			$find = 'facebook.com'; break;
		case 'twitter':
			$find = 'twitter.com'; break;
		case 'linkedin':
			$find = 'linkedin.com'; break;
		case 'pinterest':
			$find = 'pinterest.com'; break;
		case 'plus.google':
			$find = 'plus.google.com'; break;
	}
	
	foreach($page->find('a[href*='.$find.']') as $element) {
		// from the page find DOM elements that have attributes of "href" with values starting with "$find"
		$links = $element->href; // get the value of the attribute
		/*$string = str_replace("'", "|", $value); // for easier formatting of the value I substitute single quote for pipe
		if(preg_match('/\|(.*)\|/', $string, $matches) === 1){
			$links[] = $matches[1]; // add links to array
		}*/
	}
	
	return $links;
	
}

function parse($encUrl){
	$options = array(
		CURLOPT_RETURNTRANSFER => true, // return web page
		CURLOPT_HEADER => false, // don't return headers
		CURLOPT_FOLLOWLOCATION => true, // follow redirects
		CURLOPT_ENCODING => "", // handle all encodings
		CURLOPT_USERAGENT => 'sharrre', // who am i
		CURLOPT_AUTOREFERER => true, // set referer on redirect
		CURLOPT_CONNECTTIMEOUT => 5, // timeout on connect
		CURLOPT_TIMEOUT => 10, // timeout on response
		CURLOPT_MAXREDIRS => 3, // stop after 10 redirects
		CURLOPT_SSL_VERIFYHOST => 0,
		CURLOPT_SSL_VERIFYPEER => false,
	);
	$ch = curl_init();
    
	$options[CURLOPT_URL] = $encUrl;  
	curl_setopt_array($ch, $options);
	
	$content = curl_exec($ch);
	$err = curl_errno($ch);
	$errmsg = curl_error($ch);
	
	curl_close($ch);
	
	if ($errmsg != '' || $err != ''){
		//print_r($errmsg);
	}
	return $content;
}

function parse_curl($url){
	// header('Content-Type: text/html; charset=utf-8');
	$curl_handle = curl_init();
	curl_setopt($curl_handle, CURLOPT_URL, $url );
	curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 20 );
	curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false );
	curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true );
	$curl_data = curl_exec($curl_handle);
	curl_close($curl_handle);
	return $curl_data;
}

function _zeroFill($a, $b){
   	$z = hexdec(80000000);
   	if ($z & $a){
     	$a = ($a>>1);
     	$a &= (~$z);
     	$a |= 0x40000000;
     	$a = ($a>>($b-1));
   	} else {
     	$a = ($a>>$b);
	}
	return $a;
}

function _mix($a,$b,$c){
   	$a -= $b; $a -= $c; $a ^= (_zeroFill($c,13));
   	$b -= $c; $b -= $a; $b ^= ($a<<8);
   	$c -= $a; $c -= $b; $c ^= (_zeroFill($b,13));
   	$a -= $b; $a -= $c; $a ^= (_zeroFill($c,12));
   	$b -= $c; $b -= $a; $b ^= ($a<<16);
   	$c -= $a; $c -= $b; $c ^= (_zeroFill($b,5));
   	$a -= $b; $a -= $c; $a ^= (_zeroFill($c,3));
   	$b -= $c; $b -= $a; $b ^= ($a<<10);
   	$c -= $a; $c -= $b; $c ^= (_zeroFill($b,15));
	
   	return array($a,$b,$c);
}

function _GoogleCH($url, $length=null, $init=GOOGLE_MAGIC){
   	if(is_null($length))
     	$length = sizeof($url); 
	
   	$a = $b = 0x9E3779B9;
   	$c = $init;
   	$k = 0;
   	$len = $length;
   	while($len >= 12){
     	$a += ($url[$k + 0] + ($url[$k + 1] << 8) + ($url[$k + 2] << 16) + ($url[$k + 3] << 24));
     	$b += ($url[$k + 4] + ($url[$k + 5] << 8) + ($url[$k + 6] << 16) + ($url[$k + 7] << 24));
     	$c += ($url[$k + 8] + ($url[$k + 9] << 8) + ($url[$k + 10] << 16) + ($url[$k + 11] << 24));
     	$_mix = _mix($a,$b,$c);
     	$a = $_mix[0]; $b = $_mix[1]; $c = $_mix[2];
     	$k += 12;
     	$len -= 12;
   	}
   	$c += $length;
   	switch($len){
     	case 11: $c += ($url[$k + 10] << 24);
     	case 10: $c += ($url[$k + 9] << 16);
     	case 9 : $c += ($url[$k + 8] << 8);
     	case 8 : $b += ($url[$k + 7] << 24);
     	case 7 : $b += ($url[$k + 6] << 16);
     	case 6 : $b += ($url[$k + 5] << 8);
     	case 5 : $b += ($url[$k + 4]);
     	case 4 : $a += ($url[$k + 3] << 24);
     	case 3 : $a += ($url[$k + 2] << 16);
     	case 2 : $a += ($url[$k + 1] << 8);
     	case 1 : $a += ($url[$k + 0]);
   	}
   	$_mix = _mix($a,$b,$c);
   	return $_mix[2];
}

function _strord($string){
   	for($i = 0;$i < strlen($string);$i++)
     	$result[$i] = ord($string{$i});
   	return $result;
}

function getPageRank($url){
   	$pagerank = -1;
   	$ch = "6"._GoogleCH(_strord("info:" . $url));
   	$fp = fsockopen("www.google.com", 80, $errno, $errstr, 30);
   	if($fp){
     	$out = "GET /search?client=navclient-auto&ch=" . $ch . "&features=Rank&q=info:" . $url . " HTTP/1.1\r\n";
     	$out .= "Host: www.google.com\r\n";
     	$out .= "Connection: Close\r\n\r\n";
     	fwrite($fp, $out);
     	while (!feof($fp)){
       	$data = fgets($fp, 128);
       	$pos = strpos($data, "Rank_");
       	if($pos === false){
       	}else
         	$pagerank = substr($data, $pos + 9);
     	}
     	fclose($fp);
   	}
   	return $pagerank;
}
?>