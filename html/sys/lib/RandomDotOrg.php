<?php
######################################
# Класс RandomDotOrg
# Автор Siroshtan Vlad
# ICQ: 690164490
# Skype: Siroshtan97
# EMAIL: shilovladshilo@gmail.com
######################################
class RandomDotOrg
{

    private $url = 'https://api.random.org/json-rpc/1/invoke';// The URL for invoking the API
    private $apiKey = '';// Random.org API-KEY
    private $timeLimit = 300;// Http time limit

	/*======================================================================*\
	Function:	__construct
	Output:		Нет
	Descriiption: Выполняется при создании экземпляра класса
	\*======================================================================*/
    public function __construct($apiKey)
    {
        $this->setTimelimit($this->timeLimit);
		$this->apiKey = $apiKey;
    }

	/*======================================================================*\
	Function:	setTimelimit
	Output:		Нет
	Descriiption: Set time limit
	\*======================================================================*/
    private function setTimelimit($timeLimit)
    {
        $this->timeLimit = $timeLimit;
        set_time_limit($this->timeLimit);
    }

	/*======================================================================*\
	Function:	call
	Output:		return array
	Descriiption: Http Json-RPC Request ausfuehren
	\*======================================================================*/
    private function call($method, $params = null)
    {
        $request = array();
        $request['jsonrpc'] = '2.0';
        $request['id'] = mt_rand(1, 999999);
        $request['method'] = $method;
        if (isset($params)) {
            $request['params'] = $params;
        }

        $json = $this->encodeJson($request);
        $responseData = $this->post($json);
        $response = $this->decodeJson($responseData);
        return $response;
    }

	/*======================================================================*\
	Function:	post
	Output:		string
	Descriiption: HTTP POST-Request
	\*======================================================================*/
    private function post($content = '')
    {
        $defaults = array(
            CURLOPT_POST => 1,
            CURLOPT_HEADER => 0,
            CURLOPT_URL => $this->url,
            CURLOPT_FRESH_CONNECT => 1,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_FORBID_REUSE => 1,
            CURLOPT_TIMEOUT => $this->timeLimit,
            CURLOPT_HTTPHEADER => array('Content-Type: application/json'),
            CURLOPT_POSTFIELDS => $content,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => false
        );

        $ch = curl_init();
        curl_setopt_array($ch, $defaults);

        $result = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($httpCode < 200 || $httpCode >= 300) {
            $errorCode = curl_errno($ch);
            $errorMsg = curl_error($ch);
            $text = trim(strip_tags($result));
            curl_close($ch);
            throw new Exception(trim("HTTP Error [$httpCode] $errorMsg. $text"), $errorCode);
        }

        curl_close($ch);
        return $result;
    }

	/*======================================================================*\
	Function:	decodeJson
	Output:		array
	Descriiption: Json decoder
	\*======================================================================*/
    private function decodeJson($strJson)
    {
        return json_decode($strJson, true);
    }
	
	/*======================================================================*\
	Function:	encodeJson
	Output:		string
	Descriiption: Json encoder
	\*======================================================================*/
    public function encodeJson($array, $options = 0)
    {
        return json_encode($array, $options);
    }

	/*======================================================================*\
	Function:	generateSignedIntegers
	Output:		array
	Descriiption: return namber
	\*======================================================================*/
	public function Rand_om($min, $max) 
	{ 
		$params = array(); 

		$apiKey = $this->apiKey; 
		$params['apiKey'] = $apiKey; 
		$params['n'] = 1; 
		$params['min'] = $min; 
		$params['max'] = $max; 
		$response = $this->call('generateSignedIntegers', $params); 

		if (isset($response['error']['message'])) { 
		
			throw new Exception($response['error']['message']); 
			
		} 

		$result = array(); 
		
		if (isset($response['result'])) { 
		
			$result = $response['result']; 
			
		} 
		 
		return $result; 
	}
}

?>
