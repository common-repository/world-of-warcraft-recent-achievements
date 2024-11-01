<?php
/*
Plugin Name: WoW Recent Achievements
Plugin URI: http://oneroguesjourney.com/wowrecentachiev
Description: This plugin will query the World of Warcraft Armory and return a list of your recent achievements
Version: 1.30
Author: Danny Scott
Author URI: http://oneroguesjourney.com
*/
/*  Copyright 2008 Danny Scott(email : oneroguesjourney@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

function widget_wow_recent_achiev_init() {
	add_action('admin_menu', 'wow_recent_achiev_menu');
	add_action('wp_head','wow_achiev_headscript');
	wp_enqueue_script('jquery');
    wp_enqueue_script('wow_recent_achieve', get_bloginfo('wpurl') . '/wp-content/plugins/world-of-warcraft-recent-achievements/js/achiev.js',array('jquery'),'1.30');
    
	function widget_wowrecentachiev($args) {
	    extract($args);
		echo $before_widget;
		$num_char = get_option('num_characters');
	    if (!strlen(get_option('num_characters')))
	    	$num_char = 1;
	    $recent_title = explode(',',get_option('recent_title'));
	    for ($i=0;$i<$num_char;$i++)
	    {
	    	echo $before_title;
	    	if (isset($recent_title[$i]) && strlen($recent_title[$i]))
	    		echo $recent_title[$i];
	    	elseif (strlen($recent_title[0]))
	    		echo $recent_title[0];
	    	else
	    		echo 'Recent Achievements';
	    	echo $after_title;	    
			echo '<div id="achiev' . $i . '"></div>';
	    }	   
	    echo $after_widget;
	}
	if ( function_exists('register_sidebar_widget') )
		register_sidebar_widget('WoW Recent Achievements','widget_wowrecentachiev');
		
	function wow_recent_achiev_menu() {
	  add_options_page('WoW Recent Achievements', 'WoW Recent Achievements', 8, 'wowrecentachievoptions', 'wow_recent_achiev_options');
	}
	
	function wow_recent_achiev_options() {
	  echo '<div class="wrap">';
	  echo '<h2>WoW Recent Achievements</h2>';
	  echo '<form method="post" action="options.php">';
	  wp_nonce_field('update-options');
	  echo '<table class="form-table">';
	  echo '<tr valign="top">';
	  echo '<th scope="row">Number of Characters  **If you wish to display more than one character, seperate Multiple Character Names, Server Names and Titles with a comma**</th>';
	  echo '<td><select name="num_characters">';
	  for ($j=1;$j<=10;$j++)
	  {
	  		echo '<option value="'. $j .'"';
	  		if (get_option('num_characters') == $j)
	  			echo ' selected';
	  		echo '>' . $j . '</option>';
	  }
	  echo '</select></td>';
	  echo '</tr>';
	  echo '<tr valign="top">';
	  echo '<th scope="row">Title</th>';
	  echo '<td><input type="text" name="recent_title" value="';
	  if (strlen(get_option('recent_title')))
	  	echo get_option('recent_title');
	  else
	  	echo 'Recent Achievements';
	  	
	  echo '"/></td>'; 		  
	  echo '</tr>';
	  echo '<tr valign="top">';
	  echo '<th scope="row">Character Name</th>';
	  echo '<td><input type="text" name="character_name" value="' . get_option('character_name') .'"/></td>';
	  echo '</tr>';
	  echo '<tr valign="top">';
	  echo '<th scope="row">Server</th>';
	  echo '<td><input type="text" name="character_server" value="' . get_option('character_server') .'"/></td>';
	  echo '</tr>';
	  echo '<tr>';
	  echo '<th scope="row">Location</td>';
	  echo '<td><select name="realm_type"><option value="US"';
	  if (get_option('realm_type') == 'US')
	  	echo 'selected';
	  echo '>US</option><option value="EU"';
	  if (get_option('realm_type') == "EU")
	  	echo 'selected';
	  echo '>EU</option></select>';
	  echo '</tr>';
	  echo '</table>';
	  echo '<input type="hidden" name="action" value="update" />';
	  echo '<input type="hidden" name="page_options" value="character_name,character_server,realm_type,recent_title,num_characters" />';
	  echo '<p class="submit">';  
	  echo '<input type="submit" name="Submit" value="Update" />';
	  echo '</p>';
	  echo '</form>';
	  
	  echo '</div>';
	}
	function wow_achiev_headscript(){		
		echo '<script>';
	    echo 'jQuery(document).ready(function(){';
	    $num_char = get_option('num_characters');
	    if (!strlen(get_option('num_characters')))
	    	$num_char = 1;
	    $character_name = explode(',',get_option('character_name'));
	    $character_server = explode(',',get_option('character_server'));
	    for ($k=0;$k<$num_char;$k++)
	    {
	    	echo "getAchiev('";
	    	if (isset($character_name[$k]))
	    		echo $character_name[$k];
	    	else
	    		echo $character_name[0];
	    	echo "','";
	    	if (isset($character_server[$k]))
	    		echo str_replace("'","\'",$character_server[$k]);
	    	else
	    		echo str_replace("'","\'",$character_server[0]);
	    	echo "','" . get_option('realm_type') . "','" . get_bloginfo('wpurl') ."','". $k . "');";
	    }	    	
	    //echo "getAchiev('". get_option('character_name') ."','" . str_replace("'","\'",get_option('character_server')) ."','" . get_option('realm_type') . "','" . get_bloginfo('wpurl') ."')";	
	    echo '});';
		echo '</script>';
	}		
}
add_action('plugins_loaded','widget_wow_recent_achiev_init');
?>