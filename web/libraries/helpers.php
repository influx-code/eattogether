<?php
if (!function_exists('get_request')) {
	function get_request($url, $data=null, $method="POST", $encoding=TRUE, $header=null, $timeout = null){

		if ($method=='POST') {
			if(!is_null($data))$data = http_build_query ( $data );
			if (!$encoding) {
				$data = urldecode($data);
			}
			$opts = array ('http' => array ('method' => $method, 'header' => "Content-type: application/x-www-form-urlencoded\r\n" . "Content-Length: " . strlen ( $data ) . "\r\n", 'content' => $data ) );
			$context = stream_context_create ( $opts );
			$html = file_get_contents ( $url, false, $context );

			return $html;
		} elseif ($method=='JSON') {
			$curl = curl_init();

			$cookie_file = tempnam ( "/dev/null", "CURLCOOK12" );

			// Set some options - we are passing in a useragent too here
			$options = array(
				CURLOPT_SSL_VERIFYHOST => FALSE,
				CURLOPT_SSL_VERIFYPEER => FALSE,
				CURLOPT_HEADER => 0,
				CURLOPT_POST => 1,
				CURLOPT_URL => $url,
				CURLOPT_POSTFIELDS => $data,
				CURLOPT_RETURNTRANSFER => 1,
				CURLOPT_HTTPHEADER => $header,
				CURLOPT_COOKIEJAR => $cookie_file
			);
			if(is_int($timeout)) {
				$options[CURLOPT_TIMEOUT] = $timeout;
			}

			curl_setopt_array($curl, $options);

			// Send the request & save response to $resp
			$resp = curl_exec($curl);

			// Close request to clear up some resources
			curl_close($curl);
			unlink($cookie_file);

			return $resp;
		} else {

			$curl = curl_init();

			$fields_string= '';
			if ( $data ) {
				foreach ( $data as $key => $value ) {
					$fields_string .= $key . '=' . $value . '&';
				}
				rtrim ( $fields_string, '&' );
			}
			$url = $url.$fields_string;

			$cookie_file = tempnam ( "/dev/null", "CURLCOOK12" );

			// Set some options - we are passing in a useragent too here
			$options = array(
				CURLOPT_RETURNTRANSFER => 1,
				CURLOPT_URL => $url,
				CURLOPT_USERAGENT => $data['user_agent'],
				CURLOPT_COOKIEJAR => $cookie_file
			);
			if(is_int($timeout)) {
				$options[CURLOPT_TIMEOUT] = $timeout;
			}
			curl_setopt_array($curl, $options);

			// Send the request & save response to $resp
			$resp = curl_exec($curl);
			$errNo = curl_errno($curl);
			if ($errNo) {
			    $errMsg = curl_error($curl);
			    error_log("curl $url failed, errno is $errNo, errmsg is $errMsg");
			}


			// Close request to clear up some resources
			curl_close($curl);
			unlink($cookie_file);

			return $resp;
		}
	}
}

if (!function_exists('output')) {
    function output($data) {
        if (version_compare(PHP_VERSION, '5.4.0', '>=')) {
            echo json_encode($data, JSON_UNESCAPED_UNICODE);
        } else {
            echo json_encode($data);
        }

        return NULL;
    }
}

if (!function_exists('get_env')) {
    function get_env() {
        return getenv('APP_ENV');
    }
}

if (!function_exists('is_production')) {
    function is_production() {
        if (get_env('APP_ENV') === 'development') {
            return false;
        }
        return true;
    }
}


if ( ! function_exists('getip') ) {
    function getip(){
        if (defined('SLB_TCP') and SLB_TCP) {
            $realclientip = getenv("REMOTE_ADDR");
        }elseif (getenv("HTTP_X_FORWARDED")) {
            $realclientip=getenv("HTTP_X_FORWARDED");
        }
        elseif (getenv("HTTP_X_FORWARDED_FOR")) {
            $tmp = getenv("HTTP_X_FORWARDED_FOR");
            $tmp = explode(',',$tmp);
            $realclientip = $tmp[0];
        } else {
            $realclientip = getenv("REMOTE_ADDR");
        }

        return $realclientip;
    }
}