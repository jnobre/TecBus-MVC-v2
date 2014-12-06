<?php
	header('Expires: '.gmdate('D, d M Y H:i:s').'GMT');
	header('Cache-Control: no-store, no-cache, must-revalidate');
	header('Cache-Control: post-check=0, pre-check=0', FALSE);
	header('Pragma: no-cache'); 

	//Chave de acesso ao servidor:
	$ostkey="zjEIPEXmcpAmkkUIcLGlvgawBMnzrXryJKicaMoq";
	//Funcao que dada um nome de uma empresa retorna o seu id se existir
	
	function retornaid($nome)
	{
		global $ostkey;
		$jsonurl="https://api.ost.pt/agencies/?name=$nome&key=$ostkey";
		$json=file_get_contents($jsonurl,0,null,null);
		$json_output=json_decode($json,true);
		$agency=$json_output['Objects'][0]['id'];
		return $agency;
	}
	 
	function gettrip($trip,$route,$agency,$offset)
	{
		global $ostkey;
		$jsonurl="https://api.ost.pt/stops/?trip=".$trip."&route=".$route."&agency=$agency&withroutes=false&offset=$offset&key=$ostkey";
		$json=file_get_contents($jsonurl,0,null,null);
		$json_output=json_decode($json,true);
		
		return $json_output;
	
	}
	
	function gettrips($bus,$offset)	
	{
		global $ostkey;
		//Get TRIPS
		$json_output = array();
		//echo("Teste == " . $pieces[0]);
		$jsonurl="https://api.ost.pt/routes/".$bus."/headsigns/?offset=$offset&key=$ostkey";
		$json=file_get_contents($jsonurl,0,null,null);
		$json_output=json_decode($json,true);
		return $json_output;
	}

	function status($agency) 
	{  
		global $ostkey;
		$url="https://api.ost.pt/routes/?agency=$agency&key=$ostkey";
		//$agent = "Mozilla\4.0 (compatible; MSIE 5.01; Windows NT 5.0)";   
		$ch = curl_init();    
		curl_setopt($ch, CURLOPT_URL, $url);    
		//curl_setopt($ch, CURLOPT_USERAGENT, $agent);    
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);    
		curl_setopt($ch, CURLOPT_VERBOSE, false);     
		curl_setopt($ch, CURLOPT_TIMEOUT, 1);    
		$page = curl_exec($ch);     
		$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);     
		curl_close($ch);    
		return $httpcode; 
	}

	function getbusesinagency($agency,$offset)
	{
		global $ostkey;
		$json_output = array();
		$jsonurl="https://api.ost.pt/routes/?agency=$agency&offset=$offset&key=$ostkey";
		$json=file_get_contents($jsonurl,0,null,null);
		$json_output=json_decode($json,true);
		return $json_output;
	
	
	}

/*function is_url_valid($url) {    
	return preg_match(        
		'/^(https?:\/\/(www\.)?)?([a-z0-9] (-|\.|_)?) \.[a-z]{2,4}(\/([a-z0-9] (-|\.|_)?) )*\/?$/&',        
		strtolower($url)    );

}*/
?>
