<?php
	require('config.php');

	spl_autoload_register(function ($class_name){
		// Replace \ with /
		$class_name = str_replace("\\", "/", $class_name);


		if( file_exists(__DIR__."/$class_name.php") ){
			require_once(__DIR__."/$class_name.php");
			return;
		}elseif( file_exists(__DIR__."/$class_name/$class_name.php") ){
			require_once(__DIR__."/$class_name/$class_name.php");
			return;
		}else{
			// echo "Tried: " . __DIR__."/$class_name.php <br/>";
			// echo "Tried: " . __DIR__."/$class_name/$class_name.php<br/>";
			trigger_error("Failed to load class $class_name.", E_USER_ERROR);
		}
	});
