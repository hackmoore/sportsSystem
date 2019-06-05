<?php
	// Basic session stuff
	session_start();
	require('core.php');

	$METHOD = $_SERVER['REQUEST_METHOD'];
	$REQUEST = explode("&", explode("?", $_SERVER['REQUEST_URI'])[1])[0];

	if( $REQUEST == "login" ){
		requireMethod('POST');
		requireArgs($_POST, ['username', 'password']);

		$user = sportsSystem\db::authenticate($_POST['username'], $_POST['password']);

		if( $user === false ){
			jsonOut([
				'success' => false,
				'message' => "Incorrect username/password."
			]);
		}else{
			// Login

			jsonOut([
				'success' => true,
				'message' => "Login successful!"
			]);
		}
	}












//// Helper functions
	function requireMethod(String $requiredMethod){
		global $METHOD;

		if( $METHOD != $requiredMethod ){
			header("HTTP/1.0 405 Method Not Allowed");
			die("Method Not Allowed");
		}
	}

	function requireArgs(array $args, array $required){
		$missing = array();
		foreach($required as $requirement){
			if( !isset($args[$requirement]) ){
				array_push($missing, $requirement);
			}
		}

		if( count($missing) > 0 ){
			header("HTTP/1.0 400 Bad Request");
			die("Bad Request: missing: " . join(",", $missing));
		}
	}