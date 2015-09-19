<?php
/*
Plugin Name: VK All in One Expansion Unit
Plugin URI: http://ex-unit.vektor-inc.co.jp
Description: This plug-in is an integrated plug-in with a variety of features that make it powerful your web site. Many features can be stopped individually. Example Facebook Page Plugin,Social Bookmarks,Print OG Tags,Print Twitter Card Tags,Print Google Analytics tag,New post widget,Insert Related Posts and more!
Version: 3.6.0
Author: Vektor,Inc.
Author URI: http://vektor-inc.co.jp
License: GPL2
*/
/*
Copyright 2015 Hidekazu Ishikawa ( email : kurudrive@gmail.com )

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/*-------------------------------------------*/
/*	Load master setting page
/*-------------------------------------------*/
/*	Load modules
/*-------------------------------------------*/
/*	Add Parent menu
/*-------------------------------------------*/
/*	Add vkExUnit css
/*-------------------------------------------*/
/*	Add vkExUnit js
/*-------------------------------------------*/

// Get Plugin version
$data = get_file_data( __FILE__, array( 'version' => 'Version' ) );
global $version;
$version = $data['version'];

//include('plugins/css_customize/css-customize.php');
load_plugin_textdomain('vkExUnit', false, basename( dirname( __FILE__ ) ) . '/languages' );


function vkExUnit_get_directory($path=''){
	return $dirctory = dirname( __FILE__ ) . $path;
}

function vkExUnit_get_directory_uri($path=''){
	return plugins_url( $path , __FILE__);
}

/*-------------------------------------------*/
/*	Add Parent menu
/*-------------------------------------------*/
add_action( 'admin_menu', 'vkExUnit_setting_menu_parent' );
function vkExUnit_setting_menu_parent() {
	global $menu;
	$parent_name = vkExUnit_get_little_short_name();
	$Capability_required = 'activate_plugins';

	$custom_page = add_menu_page(
		$parent_name,				// Name of page
		$parent_name,				// Label in menu
		$Capability_required,
		'vkExUnit_setting_page',	// ユニークなこのサブメニューページの識別子
		'vkExUnit_add_setting_page'	// メニューページのコンテンツを出力する関数
	);
	if ( ! $custom_page ) return;
}

/*-------------------------------------------*/
/*	Load master setting page
/*-------------------------------------------*/
function vkExUnit_add_setting_page(){
	require dirname( __FILE__ ) . '/vkExUnit_admin.php';
}

require_once( 'admin_wrapper.php' );

/*-------------------------------------------*/
/*	Load modules
/*-------------------------------------------*/

require vkExUnit_get_directory() . '/common_init.php';
require vkExUnit_get_directory() . '/package_manager.php';
require vkExUnit_get_directory() . '/packages.php';
$options = vkExUnit_get_common_options();
require vkExUnit_get_directory() . '/common_helpers.php';

require vkExUnit_get_directory() . '/plugins_admin/dashboard_info_widget.php';
require vkExUnit_get_directory() . '/plugins_admin/news_from_exUnit.php';
require vkExUnit_get_directory() . '/plugins_admin/admin_banner.php';
require vkExUnit_get_directory() . '/plugins_admin/admin_bar.php';

require vkExUnit_get_directory() . '/plugins/footer_copyright_change.php';
require vkExUnit_get_directory() . '/plugins/page_custom_field.php';


if ( vkExUnit_package_is_enable( 'wpTitle' ) )
	add_filter('wp_title','vkExUnit_get_wp_head_title',11);

if ( vkExUnit_package_is_enable( 'sns' ) )
	require vkExUnit_get_directory() . '/plugins/sns/sns.php';

if ( vkExUnit_package_is_enable( 'ga' ) )
	require vkExUnit_get_directory() . '/plugins/google_analytics/google_analytics.php';

if ( vkExUnit_package_is_enable( 'relatedPosts' ) )
	require vkExUnit_get_directory() . '/plugins/related_posts/related_posts.php';

if ( vkExUnit_package_is_enable( 'metaDescription' ) )
	require vkExUnit_get_directory() . '/plugins/meta_description.php';

if ( vkExUnit_package_is_enable( 'icon' ) )
	require vkExUnit_get_directory() . '/plugins/icons.php';

if ( vkExUnit_package_is_enable( 'metaKeyword' ) )
	require vkExUnit_get_directory() . '/plugins/meta_keyword.php';

if ( vkExUnit_package_is_enable( 'otherWidgets' ) )
	require vkExUnit_get_directory() . '/plugins/other_widget/other_widget.php';

if ( vkExUnit_package_is_enable( 'css_customize' ) )
	require vkExUnit_get_directory() . '/plugins/css_customize/css_customize.php';

if ( vkExUnit_package_is_enable( 'auto_eyecatch' ) )
	require vkExUnit_get_directory() . '/plugins/auto_eyecatch.php';

if ( vkExUnit_package_is_enable( 'childPageIndex' ) )
	require vkExUnit_get_directory() . '/plugins/child_page_index.php';

// if ( vkExUnit_package_is_enable('pageList_ancestor' ) )
// 	require vkExUnit_get_directory() . '/plugins/pageList_ancestor.php';

if ( vkExUnit_package_is_enable( 'sitemap_page' ) )
	require vkExUnit_get_directory() . '/plugins/sitemap_page/sitemap_page.php';

if ( vkExUnit_package_is_enable( 'contact_section' ) )
	require vkExUnit_get_directory() . '/plugins/contact_section.php';

if ( vkExUnit_package_is_enable( 'call_to_action' ) )
	require vkExUnit_get_directory() . '/plugins/call_to_action/call_to_action.php';

if ( vkExUnit_package_is_enable( 'insert_ads' ) )
	require vkExUnit_get_directory() . '/plugins/insert_ads.php';

// if ( isset($options['active_disable_ping-back']) && $options['active_disable_ping-back'] )
// 	require vkExUnit_get_directory() . '/plugins/disable_ping-back.php';

/*-------------------------------------------*/
/*	Add vkExUnit css
/*-------------------------------------------*/
// Add vkExUnit css
add_action('wp_enqueue_scripts','vkExUnit_print_css');
function vkExUnit_print_css(){
	global $version;
	$options = vkExUnit_get_common_options();
	if ( isset($options['active_bootstrap']) && $options['active_bootstrap'] ) {
		wp_enqueue_style('vkExUnit_common_style', plugins_url('', __FILE__).'/css/vkExUnit_style_in_bs.css', array(), $version, 'all');
	} else {
		wp_enqueue_style('vkExUnit_common_style', plugins_url('', __FILE__).'/css/vkExUnit_style.css', array(), $version, 'all');
	}
}
/*-------------------------------------------*/
/*	Add vkExUnit js
/*-------------------------------------------*/
add_action('wp_head','vkExUnit_addJs');
function vkExUnit_addJs(){
	global $version;
	$options = vkExUnit_get_common_options();
	if ( isset($options['active_bootstrap']) && $options['active_bootstrap'] ) {
	wp_register_script( 'vkExUnit_master-js' , plugins_url('', __FILE__).'/js/all_in_bs.min.js', array('jquery'), $version );
	} else {
		wp_register_script( 'vkExUnit_master-js' , plugins_url('', __FILE__).'/js/all.min.js', array('jquery'), $version );
	}
	wp_enqueue_script( 'vkExUnit_master-js' );
}

/*-------------------------------------------*/
/*	Print admin js
/*-------------------------------------------*/
add_action('admin_print_scripts-vk-ex-unit_page_vkExUnit_main_setting', 'vkExUnit_admin_add_js');
function vkExUnit_admin_add_js( $hook_suffix ) {
	global $version;
	wp_enqueue_media();
	wp_register_script( 'vkExUnit_admin_js', plugins_url('', __FILE__).'/js/vkExUnit_admin.js', array('jquery'), $version );
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'vkExUnit_admin_js' );
}

/*-------------------------------------------*/
/*	Add fontawesome
/*-------------------------------------------*/
add_action('wp_head','vkExUnit_addfontawesome', 5);
function vkExUnit_addfontawesome(){
	$options = vkExUnit_get_common_options();
	if ( isset($options['active_fontawesome']) && $options['active_fontawesome'] ) {
		echo '<link href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">'.PHP_EOL;
	}
}

add_action( 'admin_print_styles-index.php', 'vkExUnit_admin_enq');
add_action( 'admin_print_styles-toplevel_page_vkExUnit_setting_page', 'vkExUnit_admin_enq');
add_action( 'admin_print_styles-vk-ex-unit_page_vkExUnit_main_setting', 'vkExUnit_admin_enq');
function vkExUnit_admin_enq(){
	wp_enqueue_style('vkexunit-css-admin', plugins_url('/css/vkExUnit_admin.css', __FILE__));
}

/*-------------------------------------------*/
/*	管理画面_admin_head JavaScriptのデバッグコンソールにhook_suffixの値を出力
/*-------------------------------------------*/

// add_action("admin_head", 'vkExUnit_suffix2console');
// function vkExUnit_suffix2console() {
//     global $hook_suffix;
//     if (is_user_logged_in()) {
//         $str = "<script type=\"text/javascript\">console.log('%s')</script>";
//         printf($str, $hook_suffix);
//     }
// }

if( function_exists('register_activation_hook') ){
	register_activation_hook( __FILE__ , 'vkExUnit_install_function' );
}
function vkExUnit_install_function(){
	$opt = get_option('vkExUnit_common_options');
	if( !$opt ){
		add_option( 'vkExUnit_common_options', vkExUnit_get_common_options_default() );
	}
}

if (function_exists('register_deactivation_hook')){
    register_deactivation_hook( __FILE__, 'vkExUnit_uninstall_function' );
}

function vkExUnit_uninstall_function()
{
	include vkExUnit_get_directory( '/uninstaller.php' );
}