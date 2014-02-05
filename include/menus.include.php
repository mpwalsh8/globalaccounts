<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
/**
 * Plugin menus.
 *
 * $Id$
 *
 * (c) 2007 by Mike Walsh
 *
 * @author Mike Walsh <mike_walsh@mentor.com>
 * @package Wp-GlobalAccounts
 * @subpackage menus
 * @version $Revision$
 * @lastmodified $Date$
 * @lastmodifiedby $Author$
 *
 */

//error_reporting(E_ALL) ;

/**
 * Global Accounts page content
 *
 * @param string - content to be displayed within the div.
 *
 */
function globalaccounts_menu_page_content($content)
{
    printf("<div class=\"wrap\">\n%s\n</div>\n", $content) ;
}

// Hook for adding admin menus
add_action('admin_menu', 'globalaccounts_add_menu_pages') ;


/**
 * Add pages action for admin hook
 *
 * This function adds all of the plugin admin menus.
 *
 */
function globalaccounts_add_menu_pages()
{
    $adminAccessLevel = 8 ;
    $userAccessLevel = 0 ;

    //$globalaccountsFileName = plugin_basename(__FILE__);
    $globalaccountsFileName = basename(__FILE__) ;

    // Option, Management, and Theme (aka Presentation) menus MUST
    // be added after new top level and connected sub-menus are defined.
    // Doing this out of order will result in the submenus not working.

    // Add a new submenu under Options:
    add_options_page('Global Accounts', 'Global Accounts',
        'manage_options', $globalaccountsFileName, 'globalaccounts_options_page') ;

    // Add a new submenu under Users but with
    // capability 'read' so all users can see it:
    add_users_page('Global Accounts', 'Global Accounts',
        'read', 'globalaccounts_users_page', 'globalaccounts_users_page') ;

    // Add a new submenu under Tools:
    add_management_page('Global Accounts', 'Global Accounts',
        'manage_options', 'globalaccounts_manage_page', 'globalaccounts_manage_page') ;
}

/**
 * Build the User submenu page content
 *
 * This function is called when the user selects
 * "Global Accounts" under the "Users" menu.
 */
function globalaccounts_users_page()
{
    error_log(sprintf('%s::%s', basename(__FILE__), __LINE__)) ;
    //swimteam_menu_page_content( "<h2>Global Accounts Users Page</h2>") ;
    require_once("user/users_menu.php") ;
}

/**
 * Build the Manage submenu page content
 *
 * This function is called when the user selects
 * "Global Accounts" under the "Tools" menu.
 */
function globalaccounts_manage_page()
{
    error_log(sprintf('%s::%s', basename(__FILE__), __LINE__)) ;
    //swimteam_menu_page_content( "<h2>Global Accounts Manage Page</h2>") ;
    require_once("user/manage_menu.php") ;
}


/**
 * Build the submenu page content
 *
 */
function globalaccounts_sublevel_tab_test()
{
    error_log(sprintf('%s::%s', basename(__FILE__), __LINE__)) ;
    globalaccounts_menu_page_content("<h2>Global Accounts Test</h2>") ;
    //require_once("admin/overview.php") ;
}

/**
 * Build the submenu page content
 *
 */
function globalaccounts_sublevel_tab_overview()
{
    error_log(sprintf('%s::%s', basename(__FILE__), __LINE__)) ;
    globalaccounts_menu_page_content("<h2>Global Accounts Overview</h2>") ;
    //require_once("admin/overview.php") ;
}

/**
 * Build the submenu page content
 *
 */
function globalaccounts_sublevel_tab_2()
{
    error_log(sprintf('%s::%s', basename(__FILE__), __LINE__)) ;
    globalaccounts_menu_page_content("<h2>Global Accounts Tab 2</h2>") ;
}

/**
 * Build the submenu page content
 *
 */
function globalaccounts_sublevel_tab_3()
{
    error_log(sprintf('%s::%s', basename(__FILE__), __LINE__)) ;
    globalaccounts_menu_page_content("<h2>Global Accounts Tab 3</h2>") ;
}

/**
 * Build the Options submenu page content
 *
 * This function is called when the user selects
 * "Global Accounts" under the "Settings" menu.
 */
function globalaccounts_options_page()
{
    error_log(sprintf('%s::%s', basename(__FILE__), __LINE__)) ;
    //globalaccounts_menu_page_content("<h2>Global Accounts Options Page</h2>") ;
    require_once("admin/options.php") ;
}

/**
 * Build the Users submenu page content
 *
 */
function globalaccounts_roster()
{
    error_log(sprintf('%s::%s', basename(__FILE__), __LINE__)) ;
    //globalaccounts_menu_page_content("<h2>Global Accounts Roster Page</h2>") ;
    require_once("admin/roster.php") ;
}

/**
 * Build the Users submenu page content
 *
 */
function globalaccounts_profile()
{
    error_log(sprintf('%s::%s', basename(__FILE__), __LINE__)) ;
    //globalaccounts_menu_page_content("<h2>Global Accounts Profile Page</h2>") ;
    require_once("user/profile.php") ;
}

/**
 * Build the Users submenu page content
 *
 */
function global_accounts_user_menu()
{
    error_log(sprintf('%s::%s', basename(__FILE__), __LINE__)) ;
    //globalaccounts_menu_page_content("<h2>Global Accounts User Menu</h2>") ;
    require_once("user/users_menu.php") ;
}

/**
 * Build the manage submenu page content
 *
 */
function global_accounts_manage_menu()
{
    error_log(sprintf('%s::%s', basename(__FILE__), __LINE__)) ;
    //globalaccounts_menu_page_content("<h2>Global Accounts Manage Menu</h2>") ;
    require_once("user/manage_menu.php") ;
}

/**
 * Build the theme (presentation) menu page content
 *
 */
function globalaccounts_theme_page()
{
    error_log(sprintf('%s::%s', basename(__FILE__), __LINE__)) ;
    globalaccounts_menu_page_content( "<h2>Global Accounts Theme Page</h2>") ;
}

/**
 * Build the top level menu page content
 *
 */
function globalaccounts_toplevel_page()
{
    error_log(sprintf('%s::%s', basename(__FILE__), __LINE__)) ;
    globalaccounts_menu_page_content( "<h2>Global Accounts Top Level Page</h2>") ;
}

?>
