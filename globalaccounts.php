<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
/**
 * Plugin Name: Mentor Graphics Global Accounts
 * Plugin URI: http://global.ncr.mentorg.com
 * Description: WordPress plugin to support Mentor Graphics Global Accounts.
 * Version: $version$
 * Author: Mike Walsh
 * Author URI: http://piglet.ncr.mentorg.com/~mike
 * License: GPL
 * 
 *
 * $Id$
 *
 * Wp-GlobalAccounts plugin constants.
 *
 * (c) 2007 by Mike Walsh
 *
 * @author Mike Walsh <mike_walsh@mentor.com>
 * @package Wp-GlobalAccounts
 * @subpackage admin
 * @version $Revision$
 * @lastmodified $Date$
 * @lastmodifiedby $Author$
 *
 */

include_once("plugininit.include.php") ;
include_once("menus.include.php") ;
include_once("db.include.php") ;
include_once("users.include.php") ;
include_once("globalaccounts.include.php") ;
include_once("mgcdivisions.include.php") ;
include_once("globalparents.include.php") ;
include_once("customers.include.php") ;
include_once("locations.include.php") ;

/**
 * Add wp_head action
 *
 * This function adds the CSS link and Javascript
 * references required by the GlobalAccounts plugin.
 *
 */
function globalaccounts_wp_head()
{
    //globalaccounts_head_js() ;
    globalaccounts_head_css() ;
}

/**
 * Add admin_head action
 *
 * This function adds the CSS link and Javascript
 * references required by the GlobalAccounts plugin.
 *
 */
function globalaccounts_admin_head()
{
    //globalaccounts_head_js() ;
    globalaccounts_head_css() ;
}

/**
 * Add JS action
 *
 * This function generates the JS 
 * references required by the GlobalAccounts plugin.
 *
 */
function globalaccounts_head_js()
{
    include_once(PHPHTMLLIB_ABSPATH . "/widgets/GoogleMap.inc") ;

    //  Initialize Google Map support

    $map = new GoogleMapDivtag() ;
    $map->setAPIKey(get_option(WPGA_OPTION_GOOGLE_API_KEY)) ;

    $head_js_link = html_script($map->getHeadJSLink()) ;
    $head_js_code = html_script() ;
    $head_js_code->add($map->getHeadJSCode()) ;

    print $head_js_link->render() ;
    print $head_js_code->render() ;
}

/**
 * Add CSS action
 *
 * This function generates the CSS 
 * references required by the GlobalAccounts plugin.
 *
 */
function globalaccounts_head_css()
{
    //  Get the web site URL
    $url = get_option('siteurl') ;
    $format = "<link rel=\"stylesheet\" type=\"text/css\" href=\"%s\" />\n" ;

    //  Construct CSS links for phpHtmlLib and echo them into the head
    $css = $url . PHPHTMLLIB_RELPATH . "/css/fonts.css";
    printf($format, $css) ;
    $css = $url . PHPHTMLLIB_RELPATH . "/css/colors.css";
    printf($format, $css) ;

    //  Generate CSS for phpHtmlLib widgets.
    //  CSS for unused widgets is commented
    //  out for performance reasons.

    $css_container = html_style() ;

    //$css_container->add(new FooterNavCSS(true)) ;
    $css_container->add(new InfoTableCSS());
    //$css_container->add(new NavTableCSS()) ;
    //$css_container->add(new TextCSSNavCSS()) ;
    //$css_container->add(new TextNavCSS()) ;
    //$css_container->add(new VerticalCSSNavTableCSS()) ;
    //$css_container->add(new ImageThumbnailWidgetCSS()) ;
    $css_container->add(new ActiveTabCSS()) ;
    //$css_container->add(new RoundTitleTableCSS()) ;
    //$css_container->add(new ButtonPanelCSS()) ;
    //$css_container->add(new TabListCSS()) ;
    //$css_container->add(new TabWidgetCSS()) ;
    $css_container->add(new TabControlCSS()) ;
    //$css_container->add(new ErrorBoxWidgetCSS()) ;
    //$css_container->add(new ProgressWidgetCSS()) ;

    //  GUIDataList CSS isn't included in standard include file
    include_once(PHPHTMLLIB_ABSPATH . "/widgets/data_list/DefaultGUIDataList.inc") ;
    $css_container->add(new DefaultGUIDataListCSS()) ;

    print $css_container->render() ;

    $css = WPGA_PLUGIN_URL . "/globalaccounts.css";
    printf($format, $css) ;
}

/**
 * globalaccounts_install()
 *
 * Install the Swim Team plugin.
 *
 */
function globalaccounts_install()
{
    global $wpdb ;

    //require_once(ABSPATH . 'wp-admin/upgrade-functions.php');

    //  New install or an upgrade?
 
    $wpga_db_version = get_option(WPGA_DB_OPTION) ;

    if ($wpga_db_version != WPGA_DB_VERSION)
    {
        //  Construct or update the Users table

        $sql = "CREATE TABLE " . WPGA_USERS_TABLE . " (
            id BIGINT(20) NOT NULL AUTO_INCREMENT,
            userid BIGINT(20) NOT NULL,
            street1 VARCHAR(100) NOT NULL DEFAULT '',
            street2 VARCHAR(100) NOT NULL DEFAULT '',
            street3 VARCHAR(100) NOT NULL DEFAULT '',
            city VARCHAR(100) NOT NULL DEFAULT '',
            stateorprovince VARCHAR(100) NOT NULL DEFAULT '',
            postalcode VARCHAR(100) NOT NULL DEFAULT '',
            country VARCHAR(100) NOT NULL DEFAULT '',
            primaryphone VARCHAR(100) NOT NULL DEFAULT '',
            secondaryphone VARCHAR(100) NOT NULL DEFAULT '',
            birthday DATE NOT NULL DEFAULT '0000-00-00',
            gender ENUM('" . WPGA_GENDER_MALE . "', '" . WPGA_GENDER_FEMALE . "') NOT NULL,
            dressshirtsize ENUM('" . WPGA_SIZE_XS . "', '" . WPGA_SIZE_S . "', '" . WPGA_SIZE_M . "', '" . WPGA_SIZE_L . "', '" . WPGA_SIZE_LT . "', '" . WPGA_SIZE_XL . "', '" . WPGA_SIZE_XLT . "', '" . WPGA_SIZE_2XL . "', '" . WPGA_SIZE_2XLT . "', '" . WPGA_SIZE_3XL . "', '" . WPGA_SIZE_3XLT . "', '" . WPGA_SIZE_4XL . "', '" . WPGA_SIZE_4XLT . "') NOT NULL,
            poloshirtsize ENUM('" . WPGA_SIZE_XS . "', '" . WPGA_SIZE_S . "', '" . WPGA_SIZE_M . "', '" . WPGA_SIZE_L . "', '" . WPGA_SIZE_LT . "', '" . WPGA_SIZE_XL . "', '" . WPGA_SIZE_XLT . "', '" . WPGA_SIZE_2XL . "', '" . WPGA_SIZE_2XLT . "', '" . WPGA_SIZE_3XL . "', '" . WPGA_SIZE_3XLT . "', '" . WPGA_SIZE_4XL . "', '" . WPGA_SIZE_4XLT . "') NOT NULL,
            teeshirtsize ENUM('" . WPGA_SIZE_XS . "', '" . WPGA_SIZE_S . "', '" . WPGA_SIZE_M . "', '" . WPGA_SIZE_L . "', '" . WPGA_SIZE_LT . "', '" . WPGA_SIZE_XL . "', '" . WPGA_SIZE_XLT . "', '" . WPGA_SIZE_2XL . "', '" . WPGA_SIZE_2XLT . "', '" . WPGA_SIZE_3XL . "', '" . WPGA_SIZE_3XLT . "', '" . WPGA_SIZE_4XL . "', '" . WPGA_SIZE_4XLT . "') NOT NULL,
            jacketsize ENUM('" . WPGA_SIZE_XS . "', '" . WPGA_SIZE_S . "', '" . WPGA_SIZE_M . "', '" . WPGA_SIZE_L . "', '" . WPGA_SIZE_LT . "', '" . WPGA_SIZE_XL . "', '" . WPGA_SIZE_XLT . "', '" . WPGA_SIZE_2XL . "', '" . WPGA_SIZE_2XLT . "', '" . WPGA_SIZE_3XL . "', '" . WPGA_SIZE_3XLT . "', '" . WPGA_SIZE_4XL . "', '" . WPGA_SIZE_4XLT . "') NOT NULL,
            sweatersize ENUM('" . WPGA_SIZE_XS . "', '" . WPGA_SIZE_S . "', '" . WPGA_SIZE_M . "', '" . WPGA_SIZE_L . "', '" . WPGA_SIZE_LT . "', '" . WPGA_SIZE_XL . "', '" . WPGA_SIZE_XLT . "', '" . WPGA_SIZE_2XL . "', '" . WPGA_SIZE_2XLT . "', '" . WPGA_SIZE_3XL . "', '" . WPGA_SIZE_3XLT . "', '" . WPGA_SIZE_4XL . "', '" . WPGA_SIZE_4XLT . "') NOT NULL,
            option1 VARCHAR(100) NOT NULL DEFAULT '',
            option2 VARCHAR(100) NOT NULL DEFAULT '',
            option3 VARCHAR(100) NOT NULL DEFAULT '',
            option4 VARCHAR(100) NOT NULL DEFAULT '',
            option5 VARCHAR(100) NOT NULL DEFAULT '',
            registered DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
            KEY userid (userid),
            PRIMARY KEY  (id)
	    );" ;
      
        dbDelta($sql) ;

        //  Construct or update the MGC Divisions table

        $sql = "CREATE TABLE " . WPGA_MGC_DIVISIONS_TABLE . " (
            mgcdivisionid BIGINT(20) NOT NULL AUTO_INCREMENT,
            mgcdivisionshortname VARCHAR(100) NOT NULL DEFAULT '',
            mgcdivisionlongname VARCHAR(100) NOT NULL DEFAULT '',
            mgcdivisioncolormarker VARCHAR(100) NOT NULL DEFAULT '',
            modified DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
            modifiedby BIGINT(20) NOT NULL,
            PRIMARY KEY  (mgcdivisionid)
	    );" ;
      
        dbDelta($sql) ;

        //  Construct or update the Global Parents table

        $sql = "CREATE TABLE " . WPGA_GLOBAL_PARENTS_TABLE . " (
            globalparentid BIGINT(20) NOT NULL AUTO_INCREMENT,
            globalparentname VARCHAR(100) NOT NULL DEFAULT '',
            modified DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
            modifiedby BIGINT(20) NOT NULL,
            PRIMARY KEY  (globalparentid)
	    );" ;
      
        dbDelta($sql) ;

        //  Construct or update the Customers table

        $sql = "CREATE TABLE " . WPGA_CUSTOMERS_TABLE . " (
            customerid BIGINT(20) NOT NULL AUTO_INCREMENT,
            globalparentid BIGINT(20) NOT NULL,
            customername VARCHAR(100) NOT NULL DEFAULT '',
            website VARCHAR(100) NOT NULL DEFAULT '',
            modified DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
            modifiedby BIGINT(20) NOT NULL,
            PRIMARY KEY  (customerid)
	    );" ;
      
        dbDelta($sql) ;

        //  Construct or update the Locations table

        $sql = "CREATE TABLE " . WPGA_LOCATIONS_TABLE . " (
            locationid BIGINT(20) NOT NULL AUTO_INCREMENT,
            customerid BIGINT(20) NOT NULL,
            globalparentid BIGINT(20) NOT NULL,
            locationname VARCHAR(100) NOT NULL DEFAULT '',
            wtoregion VARCHAR(100) NOT NULL DEFAULT '',
            street1 VARCHAR(100) NOT NULL DEFAULT '',
            street2 VARCHAR(100) NOT NULL DEFAULT '',
            street3 VARCHAR(100) NOT NULL DEFAULT '',
            city VARCHAR(100) NOT NULL DEFAULT '',
            stateorprovince VARCHAR(100) NOT NULL DEFAULT '',
            postalcode VARCHAR(100) NOT NULL DEFAULT '',
            country VARCHAR(100) NOT NULL DEFAULT '',
            primaryphone VARCHAR(100) NOT NULL DEFAULT '',
            secondaryphone VARCHAR(100) NOT NULL DEFAULT '',
            website VARCHAR(100) NOT NULL DEFAULT '',
            modified DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
            modifiedby BIGINT(20) NOT NULL,
            KEY globalparentid (globalparentid),
            KEY customerid (customerid),
            PRIMARY KEY  (locationid)
	    );" ;
      
        dbDelta($sql) ;

        //  Construct or update the FRP table

        $sql = "CREATE TABLE " . WPGA_FRP_TABLE . " (
            frpid BIGINT(20) NOT NULL AUTO_INCREMENT,
            locationid BIGINT(20) NOT NULL,
            mgcdivisionid BIGINT(20) NOT NULL,
            mgcdivisionfrp BIGINT(20) NOT NULL,
            modified DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
            modifiedby BIGINT(20) NOT NULL,
            KEY mgcdivisionid (mgcdivisionid),
            KEY locationid (locationid),
            PRIMARY KEY  (frpid)
	    );" ;
      
        dbDelta($sql) ;

        update_option(WPGA_DB_OPTION, WPGA_DB_VERSION) ;
    }
}

/**
 * globalaccounts_uninstall - clean up when the plugin is deactivated
 *
 */
function globalaccounts_uninstall()
{
}

/**
 * Hook for adding CSS links and other HEAD stuff
 */
add_action('wp_head', 'globalaccounts_wp_head');
add_action('admin_head', 'globalaccounts_admin_head');


/**
 * Hook for adding admin menus
 */
add_action('admin_menu', 'globalaccounts_add_menu_pages');

/**
 *  Activate the plugin initialization function
 */
register_activation_hook(plugin_basename(__FILE__), 'globalaccounts_install') ;
register_deactivation_hook(plugin_basename(__FILE__), 'globalaccounts_uninstall') ;
?>
