<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
/**
 *
 * $Id$
 *
 * Users includes.  These includes define information used in 
 * the Users classes and child classes in the Wp-GlobalAccounts plugin.
 *
 * (c) 2007 by Mike Walsh for Wp-GlobalAccounts.
 *
 * @author Mike Walsh <mike_walsh@mentor.com>
 * @package Wp-GlobalAccounts
 * @subpackage Users
 * @version $Revision$
 * @lastmodified $Date$
 * @lastmodifiedby $Author$
 *
 */

/**
 * Define users table name
 */
define("WPGA_USERS_TABLE", WPGA_DB_PREFIX . "users") ;

/**
 * default constants for GUIDataListConstruction
 */
define("WPGA_USERS_DEFAULT_COLUMNS", "*") ;
define("WPGA_USERS_DEFAULT_TABLES", WPGA_USERS_TABLE) ;
define("WPGA_USERS_DEFAULT_WHERE_CLAUSE", "") ;

/**
 * complex constants for GUIDataList to show names from
 * WP tables and other information from plugin tables.
 */
define("WPGA_USERS_COLUMNS", "ID AS userid, user_login, firstname, lastname") ;
define("WPGA_USERS_TABLES", "`" . $wpdb->prefix . "users`
            LEFT JOIN (
	            SELECT user_id AS uid, meta_value AS firstname
	            FROM `" . $wpdb->prefix . "usermeta` 
	            WHERE meta_key = 'first_name'
            ) AS metaF ON " . $wpdb->prefix . "users.ID = metaF.uid
            LEFT JOIN (
	            SELECT user_id AS uid, meta_value AS lastname
	            FROM `" . $wpdb->prefix . "usermeta` 
	            WHERE meta_key = 'last_name'
            ) AS metaL ON " . $wpdb->prefix . "users.ID = metaL.uid") ;
define("WPGA_USERS_WHERE_CLAUSE", WPGA_USERS_DEFAULT_WHERE_CLAUSE) ;

/**
 * default constants for GUIDataListConstruction Action Buttons
 */
define("WPGA_USERS_ADD_USER", "Add") ;
define("WPGA_USERS_UPDATE_USER", "Update") ;
define("WPGA_USERS_DELETE_USER", "Delete") ;
define("WPGA_USERS_RETIRE_USER", "Retire") ;
define("WPGA_USERS_REGISTER_USER", "Register") ;
define("WPGA_USERS_PROFILE_USER", "Profile") ;

?>
