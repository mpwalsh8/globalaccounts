<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
/**
 *
 * $Id$
 *
 * DB includes.  These includes define information used in 
 * the DB classes and child classes in the Wp-GlobalAccounts plugin.
 *
 * (c) 2007 by Mike Walsh for Wp-GlobalAccounts.
 *
 * @author Mike Walsh <mike_walsh@mentor.com>
 * @package Wp-GlobalAccounts
 * @subpackage DB
 * @version $Revision$
 * @lastmodified $Date$
 * @lastmodifiedby $Author$
 *
 */

global $wpdb ;

/**
 * The username to use
 */
define("WPGA_DB_USERNAME", DB_USER) ;

/**
 * The password to use
 */
define("WPGA_DB_PASSWORD", DB_PASSWORD) ;

/**
 * The database server to use
 */
define("WPGA_DB_HOSTNAME", DB_HOST);

/**
 * The database name to use
 */
define("WPGA_DB_NAME", DB_NAME) ;

/**
 * build the DSN which is used by phpHtmlLib
 */
define("WPGA_DB_DSN", "mysql://" . WPGA_DB_USERNAME .
    ":" . WPGA_DB_PASSWORD . "@" . WPGA_DB_HOSTNAME . "/" . WPGA_DB_NAME) ;


/**
 * Define table prefix
 */
define("WPGA_DB_PREFIX", $wpdb->prefix . "ga_") ;

/**
 * Database version - stored as a WP option
 */
define("WPGA_DB_VERSION", "0.14") ;
define("WPGA_DB_OPTION", WPGA_DB_PREFIX . "db_version") ;

?>
