<?php

/*
Plugin Name: Rss news display
Plugin URI: http://www.gopipulse.com/work/2012/04/03/rss-news-display-wordpress-plugin/
Description: RSS news display is a simple plug-in to show the RSS title with cycle jQuery script. This plug-in retrieve the title and corresponding links from the given RSS feed and setup the news display in the website. Its display one title at a time and cycle all the remaining title in the mentioned location. and we have option to set four different cycle left to right, right to left, down to up, up to down. using this plugin we can easily setup the news display under top menu or footer. the plug-in have separate CSS file to configure the style.
Author: Gopi.R
Version: 5.0
Author URI: http://www.gopipulse.com/work/2012/04/03/rss-news-display-wordpress-plugin/
Donate link: http://www.gopipulse.com/work/2012/04/03/rss-news-display-wordpress-plugin/
Tags: RSS, news, display, wordpress, plugin
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

global $wpdb, $wp_version;

function RssNewsDisplay($setting) 
{
	global $wpdb;
	$settings = rssnews_helper($setting);
	$rss = $settings[0]->rss;
	$slider = trim($settings[0]->direction);
	?>
	<!-- begin rssnewssetting -->
	<div id="rssnewssetting<?php echo $setting; ?>">
	<?php
	$xml = "";
	$cnt=0;
	$f = fopen( $rss, 'r' );
	while( $data = fread( $f, 4096 ) ) { $xml .= $data; }
	fclose( $f );
	preg_match_all( "/\<item\>(.*?)\<\/item\>/s", $xml, $itemblocks );
	if ( ! empty($itemblocks) ) 
	{
		foreach( $itemblocks[1] as $block )
		{ 
			preg_match_all( "/\<title\>(.*?)\<\/title\>/",  $block, $title );
			preg_match_all( "/\<link\>(.*?)\<\/link\>/", $block, $link );
			
			$rssnews_title = $title[1][0];
			$rssnews_title = mysql_real_escape_string(trim($rssnews_title));
			$rssnews_link = $link[1][0];
			$rssnews_link = trim($rssnews_link);
			?>
            <p><a target="_blank" href="<?php echo $rssnews_link; ?>"><?php echo $rssnews_title; ?></a></p>
			<?php 
		}
	}
	?>
	</div>
    <script type="text/javascript">
    $(function() {
	$('#rssnewssetting<?php echo $setting; ?>').cycle({
		fx: 'scroll<?php echo @$slider; ?>',
		speed: 700,
		timeout: 5000
	});
	});
	</script>
    <!-- end rssnewssetting -->
    <?php
}

# Plugin helper
function rssnews_helper($direction) 
{
	$settings = array();
	
	switch ($direction) 
	{
		case 1:
			$settings[0]->rss = get_option('rssnews_rss1');
			$settings[0]->direction = get_option('rssnews_direction1');
			break;
		case 2:
			$settings[0]->rss = get_option('rssnews_rss2');
			$settings[0]->direction = get_option('rssnews_direction2');
			break;
		case 3:
			$settings[0]->rss = get_option('rssnews_rss3');
			$settings[0]->direction = get_option('rssnews_direction3');
			break;
		case 4:
			$settings[0]->rss = get_option('rssnews_rss4');
			$settings[0]->direction = get_option('rssnews_direction4');
			break;
		case 5:
			$settings[0]->rss = get_option('rssnews_rss5');
			$settings[0]->direction = get_option('rssnews_direction5');
			break;
	}
	
	return $settings;
}

# Plugin installation and default value
function rssnews_install() 
{
	add_option('rssnews_rss1', "http://www.gopipulse.com/work/category/word-press-plug-in/feed/");
	add_option('rssnews_direction1', "Left");
	add_option('rssnews_rss2', "http://www.gopipulse.com/extensions/feed");
	add_option('rssnews_direction2', "Right");
	add_option('rssnews_rss3', "http://www.wordpress.org/news/feed/");
	add_option('rssnews_direction3', "Up");
	add_option('rssnews_rss4', "http://www.wordpress.org/news/feed/");
	add_option('rssnews_direction4', "Down");
	add_option('rssnews_rss5', "http://www.wordpress.org/news/feed/");
	add_option('rssnews_direction5', "Left");
}

# Admin update option for default value
function rssnews_admin_options() 
{
	echo "<div class='wrap'>";
	echo "<h2>"; 
	echo "Rss news display";
	echo "</h2>";
	
	$rssnews_rss1 = get_option('rssnews_rss1');
	$rssnews_rss2 = get_option('rssnews_rss2');
	$rssnews_rss3 = get_option('rssnews_rss3');
	$rssnews_rss4 = get_option('rssnews_rss4');
	$rssnews_rss5 = get_option('rssnews_rss5');
	$rssnews_direction1 = get_option('rssnews_direction1');
	$rssnews_direction2 = get_option('rssnews_direction3');
	$rssnews_direction3 = get_option('rssnews_direction3');
	$rssnews_direction4 = get_option('rssnews_direction4');
	$rssnews_direction5 = get_option('rssnews_direction5');

	if (@$_POST['rssnews_submit']) 
	{
		$rssnews_rss1 = stripslashes($_POST['rssnews_rss1']);
		$rssnews_rss2 = stripslashes($_POST['rssnews_rss2']);
		$rssnews_rss3 = stripslashes($_POST['rssnews_rss3']);
		$rssnews_rss4 = stripslashes($_POST['rssnews_rss4']);
		$rssnews_rss5 = stripslashes($_POST['rssnews_rss5']);
		$rssnews_direction1 = stripslashes($_POST['rssnews_direction1']);
		$rssnews_direction2 = stripslashes($_POST['rssnews_direction2']);
		$rssnews_direction3 = stripslashes($_POST['rssnews_direction3']);
		$rssnews_direction4 = stripslashes($_POST['rssnews_direction4']);
		$rssnews_direction5 = stripslashes($_POST['rssnews_direction5']);
		
		update_option('rssnews_rss1', $rssnews_rss1 );
		update_option('rssnews_rss2', $rssnews_rss2 );
		update_option('rssnews_rss3', $rssnews_rss3 );
		update_option('rssnews_rss4', $rssnews_rss4 );
		update_option('rssnews_rss5', $rssnews_rss5 );
		update_option('rssnews_direction1', $rssnews_direction1 );
		update_option('rssnews_direction2', $rssnews_direction2 );
		update_option('rssnews_direction3', $rssnews_direction3 );
		update_option('rssnews_direction4', $rssnews_direction4 );
		update_option('rssnews_direction5', $rssnews_direction5 );
	}
	
	echo '<form name="rssnews_form" method="post" action="">';

	echo '<br><strong>SETTING 1</strong>';
	echo '<p>RSS Link:<br><input  style="width: 550px;" type="text" value="';
	echo $rssnews_rss1 . '" name="rssnews_rss1" id="rssnews_rss1" /> (Widget)<br>';
	echo 'Slider Direction:<br><input  style="width: 200px;" maxlength="5" type="text" value="';
	echo $rssnews_direction1 . '" name="rssnews_direction1" id="rssnews_direction1" /> (Left / Right / Up / Down)</p>';
	
	echo '<br><strong>SETTING 2</strong>';
	echo '<p>RSS Link:<br><input  style="width: 550px;" type="text" value="';
	echo $rssnews_rss2 . '" name="rssnews_rss2" id="rssnews_rss2" /><br>';
	echo 'Slider Direction:<br><input  style="width: 200px;" maxlength="5" type="text" value="';
	echo $rssnews_direction2 . '" name="rssnews_direction2" id="rssnews_direction2" /> (Left / Right / Up / Down)</p>';

	echo '<br><strong>SETTING 3</strong>';
	echo '<p>RSS Link:<br><input  style="width: 550px;" type="text" value="';
	echo $rssnews_rss3 . '" name="rssnews_rss3" id="rssnews_rss3" /><br>';
	echo 'Slider Direction:<br><input  style="width: 200px;" maxlength="5" type="text" value="';
	echo $rssnews_direction3 . '" name="rssnews_direction3" id="rssnews_direction3" /> (Left / Right / Up / Down)</p>';
	
	echo '<br><strong>SETTING 4</strong>';
	echo '<p>RSS Link:<br><input  style="width: 550px;" type="text" value="';
	echo $rssnews_rss4 . '" name="rssnews_rss4" id="rssnews_rss4" /><br>';
	echo 'Slider Direction:<br><input  style="width: 200px;" maxlength="5" type="text" value="';
	echo $rssnews_direction4 . '" name="rssnews_direction4" id="rssnews_direction4" /> (Left / Right / Up / Down)</p>';

	echo '<br><strong>SETTING 5</strong>';
	echo '<p>RSS Link:<br><input  style="width: 550px;" type="text" value="';
	echo $rssnews_rss5 . '" name="rssnews_rss5" id="rssnews_rss5" /><br>';
	echo 'Slider Direction:<br><input  style="width: 200px;" maxlength="5" type="text" value="';
	echo $rssnews_direction5 . '" name="rssnews_direction5" id="rssnews_direction5" /> (Left / Right / Up / Down)</p>';

	echo '<input name="rssnews_submit" id="rssnews_submit" class="button-primary" value="Update All" type="submit" />';
	echo '</form>';
	echo '</div>';
	?>
	<h2>Plugin configuration</h2>
    <ul>
    <li>Short code option for pages and post</li>
    </ul>
	Check official website for live demo <a href="http://www.gopipulse.com/work/2012/04/03/rss-news-display-wordpress-plugin/" target="_blank">click here</a>
    <?php
}

# Function to filter short code
function rssnews_shortcode( $atts ) 
{
	global $wpdb;
	//[rss-news-display setting="1"]
	if ( ! is_array( $atts ) )
	{
		return '';
	}
	$setting = $atts['setting'];
	
	
	$settings = rssnews_helper($setting);
	$rss = $settings[0]->rss;
	$slider = trim($settings[0]->direction);
	$rssnews = "";
	$rssnews = $rssnews . '<div id="rssnewssetting'.$setting.'">';
	$cnt=0;
	$doc = new DOMDocument();
	$doc->load( $rss );
	$item = $doc->getElementsByTagName( "item" );
	foreach( $item as $item )
	{
		$paths = $item->getElementsByTagName( "title" );
	  	$text = mysql_real_escape_string($paths->item(0)->nodeValue);
	  	$paths = $item->getElementsByTagName( "link" );
	  	$link = $paths->item(0)->nodeValue;
		$rssnews = $rssnews . '<p><a target="_blank" href="'.$link.'">'.$text.'</a></p>';
		$cnt++;
	}

	$rssnews = $rssnews . '</div>';
	$rssnews = $rssnews . '<script type="text/javascript">';
    $rssnews = $rssnews . '$(function() {';
	$rssnews = $rssnews . "$('#rssnewssetting".$setting."').cycle({fx: 'scroll".$slider."',speed: 700,timeout: 5000";
	$rssnews = $rssnews . '});';
	$rssnews = $rssnews . '});';
	$rssnews = $rssnews . '</script>';
	
	return $rssnews;
}

# Function to add the link under setting menu
function rssnews_add_to_menu() 
{
	if (is_admin()) 
	{
		add_options_page('Rss news display', 'Rss news display', 'manage_options', __FILE__, 'rssnews_admin_options' );
	}
}

# Function to call at the time of deactivation
function rssnews_deactivation() 
{
	
}

# To add javascript and css link in the header
function rssnews_add_javascript_files() 
{
	if (!is_admin())
	{
		wp_enqueue_script( 'jquery-1.3.2.min', get_option('siteurl').'/wp-content/plugins/rss-news-display/js/jquery-1.3.2.min.js');
		wp_enqueue_script( 'jquery.cycle.all.min', get_option('siteurl').'/wp-content/plugins/rss-news-display/js/jquery.cycle.all.min.js');
		wp_enqueue_style( 'rss-news-display.css', get_option('siteurl').'/wp-content/plugins/rss-news-display/rss-news-display.css');
	}	
}

# For widget control
function rssnews_control() 
{
	echo 'Rss news display';
}

# For widget
function rssnews_widget($args) 
{
	extract($args);
	echo $before_widget;
	RssNewsDisplay(1);
	echo $after_widget;
}

# For widget
function rssnews_init()
{
	if(function_exists('wp_register_sidebar_widget')) 
	{
		wp_register_sidebar_widget('rss-news-display', 'Rss news display', 'rssnews_widget');
	}
	
	if(function_exists('wp_register_widget_control')) 
	{
		wp_register_widget_control('rss-news-display', array('Rss news display', 'widgets'), 'rssnews_control');
	} 
}

# Plugin hook
add_shortcode( 'rss-news-display', 'rssnews_shortcode' );
add_action('admin_menu', 'rssnews_add_to_menu');
add_action('wp_enqueue_scripts', 'rssnews_add_javascript_files');
add_action("plugins_loaded", "rssnews_init");
register_activation_hook(__FILE__, 'rssnews_install');
register_deactivation_hook(__FILE__, 'rssnews_deactivation');
?>