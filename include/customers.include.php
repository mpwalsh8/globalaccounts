<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
/**
 *
 * $Id$
 *
 * Customer includes.  These includes define information used
 * in the Job classes and child classes in the Global Accounts
 * plugin.
 *
 * (c) 2008 by Mike Walsh for Wp-SwimTeam.
 *
 * @author Mike Walsh <mike_walsh@mentor.com>
 * @package Global Accounts
 * @subpackage Customers
 * @version $Revision$
 * @lastmodified $Date$
 * @lastmodifiedby $Author$
 *
 */

include_once("db.include.php") ;

/**
 * Define age group table name
 */
define("WPGA_CUSTOMERS_TABLE", WPGA_DB_PREFIX . "customers") ;

/**
 * default constants for GUIDataListConstruction
 */
define("WPGA_CUSTOMERS_DEFAULT_COLUMNS", "*") ;
define("WPGA_CUSTOMERS_DEFAULT_TABLES", WPGA_CUSTOMERS_TABLE) ;
define("WPGA_CUSTOMERS_DEFAULT_WHERE_CLAUSE", "") ;

?>
