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

// DELETE FROM `wp_posts` WHERE post_type = "post";


class CustomPlugin 
{
	function __construct(){
		add_action( 'custom_column', array($this, 'addColumn'));
		add_action( 'custom_posts', array($this, 'posts' ));
		// add_action( 'timeout', array($this, 'timeout' ));


		do_action( 'custom_column', array($this, 'addColumn'));
		do_action( 'custom_posts', array($this, 'posts' ));
		// do_action( 'timeout', array($this, 'timeout'));

		// add_action('init', array($this, 'custom_post_type'));
	}
	// THIS FUNCTION STOPS THE WEBSITE.. NOT USING.
	function timeout(){
			set_time_limit(0); // make it run forever
			while(true) {
			    array($this, 'posts' );
			    sleep(300);
			}
	}

	function addColumn(){
		global $wpdb;

		$row = $wpdb->get_results(  "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS
		WHERE table_name = 'wp_posts' AND column_name = 'completed'"  );

		// var_dump($row);
		if(empty($row)){
		   $wpdb->query("ALTER TABLE wp_posts ADD completed BOOLEAN");
		}
	}

	function posts(){

		$files = file_get_contents('https://jsonplaceholder.typicode.com/todos');
		$arr = json_decode($files, true);

		$i = 0;
		$len = count($arr);
		// print_r($len);
		foreach ($arr as $key => $value) {

			// echo $value["userId"]. '<br>';
			// echo $value["title"]. '<br>';
			$userId = $value['userId'];
			$id = $value['id'];
			$title = $value['title'];
			$completed = $value['completed'];
			$user_id = get_current_user_id();
			
			foreach($value as $k)
			global $wpdb;

			 $wpdb->insert( 
			    'wp_posts', 
			    array( 
			    	'post_author'=> $userId,
			    	'post_title'=> $title,
			    	'post_type'=> "post",
			    	'completed'=> $completed,
			    	// 'ID'=> $id,
			    )
			);
			$record_id = $wpdb->insert_id;

			

			// deze werkt nog niet
			// $wpdb->insert( 
			//     'wp_postmeta', 
			//     array( 
			//     	'post_id'=> $id,
			//     )
			// );

			// time out voor de functie werkt nog niet helemaal stopt de activate button van de plugin maar insert wel data
			// sleep(3600);
		}

		// SHOW ALL COMPLETED DATA, ik heb dit uitstaan omdat de timeout niet goed werkt en dus alleen maar meer wordt.
		// global $wpdb;
		// $result = $wpdb->get_results(  "SELECT * FROM wp_posts WHERE completed = 1"  );
		// var_dump($result);

		// BONUS
		// global $wpdb;
		// $bonus = $wpdb->get_results(  "SELECT * FROM wp_posts WHERE completed != 1 AND post_title RLIKE '^[aeiouAEIOU]'"  );
		// var_dump($bonus);
	}

	function activate(){
		flush_rewrite_rules();
	}
	function deactivate(){
		flush_rewrite_rules();
	}
	function uninstall(){

	}
	// testing a function
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

// function foo_command( $args ) {
//     WP_CLI::success( $args[0] );
// }
// if ( class_exists( 'WP_CLI' ) ) {
//     WP_CLI::add_command( 'CustomCommand', 'CustomPlugin' );
// }