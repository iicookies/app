<?php

 /**
 * 
 */
 class ProxyController extends BaseController
 {
 	function get(){	
		$url = 'http://www.xdaili.cn/ipagent/freeip/getFreeIps?page=1&rows=10';
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_HEADER, 0);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);//这个是重点。
		$headers = array();
		$headers[] = 'X-Apple-Tz: 0';
		$headers[] = 'X-Apple-Store-Front: 143444,12';
		$headers[] = 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8';
		$headers[] = 'Accept-Encoding: gzip, deflate';
		$headers[] = 'Accept-Language: en-US,en;q=0.5';
		$headers[] = 'Cache-Control: no-cache';
		$headers[] = 'Content-Type: application/x-www-form-urlencoded; charset=utf-8';
		$headers[] = 'User-Agent: Mozilla/5.0 (X11; Ubuntu; Linux i686; rv:28.0) Gecko/20100101 Firefox/28.0';
		$headers[] = 'X-MicrosoftAjax: Delta=true';

		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
		 $html = curl_exec($curl);
		 curl_close($curl);
		   Header( "Content-type:   text/plain "); 
		       // Header( "Accept-Ranges:   bytes "); 
		       header( "Content-Disposition:   inline;   filename=proxy.txt "); 

		$data = json_decode($html,true);
		//echo $data;
		$data2 = json_decode($data,true);
		$list = $data2['rows'];
		$str = '';
		foreach ($list as $proxy) {
			printf($proxy['ip'] .':'. $proxy['port'].PHP_EOL);
		}
 	}
 }
