<?php
/**
*@package opdrachtPlugin
*/
/*
Plugin Name: Opdracht Plugin
Plugin URI: http://wordpress.com/plugin
Description: This is a plugin
Version: 1.0.0
Author: Vedat Aydin
Author URI: hhtps://wordpress.com
License: GPLv2 or later
Text domain: opdracht-plugin
*/

// $url = 'https://jsonplaceholder.typicode.com/todos';
// $url_components = parse_url($url);
// parse_str($url_components['query'], $params);

// echo ' Hi '.$params['title'];
// var_dump($url_components);

// $names = file_get_contents('https://jsonplaceholder.typicode.com/todos');
// print_r (explode("<br>",$php_array));

$files=file('https://jsonplaceholder.typicode.com/todos');

// $title = $files[4];
// print_r($title);
print_r($files);

// $files = array_diff($files, array('{','}','[',']'));
// $files = array_values($files);
// To check the number of lines
// echo count($names).'<br>';
// var_dump($names);
// print_r($names);



// print_r(array_values($names));
// foreach($files as $key => $value)
// {
// // echo $value->find("title")->plaintext;
// 	echo $key. $value.'<br>';
// 	// $x = explode("{", "}", $value);
// }

	// echo $key.'<br>';
	// echo $value.'<br>';
	// echo $value[$title].'<br>';


	// echo $name[$title].'<br>';
	// echo $name['title'], '<br>';


// foreach($names['data'] as $result) {
//     echo $result['title'], '<br>';
// }

// defined('ABSPATH') or die('You can\t acces this file.');



// andere methode
// $files = file_get_contents('https://jsonplaceholder.typicode.com/todos');
// foreach((array)$files as $file)
// {


// 	echo $file.'<br>';
// 	// echo $file[$title].'<br>';
// 	// echo $file[$title];

// }

/**
 * 
 */



class CustomPlugin 
{
	function __construct(){
		add_action( 'custom_column', array($this, 'addColumn' ));
		add_action( 'custom_posts', array($this, 'posts' ));
		// add_action('init', array($this, 'custom_post_type'));

	}
	function addColumn(){
		global $wpdb;
		$row = $wpdb->get_results(  "SELECT COLUMN_NAME FROM bitnami_wordpress.COLUMNS
		WHERE table_name = 'wp_posts' AND column_name = 'completed'"  );

		if(empty($row)){
		   $wpdb->query("ALTER TABLE wp_posts ADD completed BOOLEAN");
		}
	}

	function posts(){
		global $wpdb;
		$wpdb->insert( 
		    'wp_posts', 
		    array( 
		    	'post_title'=> "x",
		    	'post_content'=> "a",

		    )
		);
		$record_id = $wpdb->insert_id;
	}
	// function __construct(){
	// 	add_action('init', array($this, 'posts'));
	// }

	function activate(){
		flush_rewrite_rules();
	}
	function deactivate(){
		flush_rewrite_rules();
	}
	function uninstall(){

	}
	function custom_post_type(){
		register_post_type('book', ['public' => true, 'label' => 'Books' ]);
	}


}

if(class_exists('CustomPlugin')){
	$customPlugin = new CustomPlugin();
}

//activation
register_activation_hook( __FILE__, array( $customPlugin, 'activate' ));
//deactivation
register_deactivation_hook( __FILE__, array( $customPlugin, 'deactivate' ));



	// add_action("wp", function() { 
	//     echo sprintf( "Yes! I am creating with WordPress v. %s!\n", get_bloginfo("version") );
	//     exit("I exits\n");
	// });



// addColumn();
// add_action( 'addColumn', 'posts' );



// add_action( 'call_customPlugin', array ( $customPlugin, 'addColumn' ));

// add_action( 'call_customPlugin', 'addColumn' );

// add_action( 'postsx', 'posts' );




	// $demo = new Demo_Class;
	// add_action( 'call_dynamic_method', array ( $demo, 'dynamic_method' );
// addColumn();
// posts();



		// global $wpdb;
		// $wpdb->insert( 
		//     'wp_posts', 
		//     array( 
		//     	'post_title'=> "x",
		//     	'post_content'=> "a",

		//     )
		// );

		// $record_id = $wpdb->insert_id;