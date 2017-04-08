<?php

function dropdown_restaurant_specials_shortcode() {
	require_once(realpath(__DIR__ . '/../..') . "/Facebook/autoload.php");
	
	wp_enqueue_style('restaurant_menu_specials_css');
	
	$fb = new Facebook\Facebook([
		'app_id' => '1301019019928554',
		'app_secret' => '09f6dec135cca63762a56d2dde84108e',
		'default_graph_version' => 'v2.5',
	]);
	
	$output = "";
	
	$request = $fb->request('GET', '/1115668138487226/nativeoffers');
	//$request->setAccessToken("1301019019928554|SC6heHcKb4I-hN4DoEOVCFfoQBA");
	$request->setAccessToken("EAACEdEose0cBAN8cHKzJjYS6U9cxnJWddwLhIZBgOBWCJf5ljMyU5pTr5BCJq8ZCDnft12LN38oyQayHX0zv3m0hwjblTS1hLbxojDDjXP2Gg339J5e3DHoZCZBlz5gAlNTko4H267xnZCtQswbJURMRuLn7r5Q6m8XaAZAq3UuAZDZD");
	
	try {
		$response = $fb->getClient()->sendRequest($request);
	} catch(Facebook\Exceptions\FacebookResponseException $e) {
		// When Graph returns an error
		return 'Graph returned an error: ' . $e->getMessage();
	} catch(Facebook\Exceptions\FacebookSDKException $e) {
		// When validation fails or other local issues
		return 'Facebook SDK returned an error: ' . $e->getMessage();
	}

	$graphNode = $response->getGraphNode();
	
	return $graphNode;
}

?>