<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
/**
 *
 * $Id$
 *
 * Location includes.  These includes define information used in 
 * the Account classes and child classes in the Global Accounts
 * plugin.
 *
 * (c) 2008 by Mike Walsh for Mentor Graphics
 *
 * @author Mike Walsh <mike_walsh@mentor.com>
 * @package GlobalAccounts
 * @subpackage Accounts
 * @version $Revision$
 * @lastmodified $Date$
 * @lastmodifiedby $Author$
 *
 */

include_once("globalaccounts.include.php") ;

/**
 * Define acocunts table name
 */
define("WPGA_LOCATIONS_TABLE", WPGA_DB_PREFIX . "locations") ;

/**
 * default constants for GUIDataListConstruction
 */
define("WPGA_LOCATIONS_DEFAULT_COLUMNS", "*") ;
define("WPGA_LOCATIONS_DEFAULT_TABLES", WPGA_LOCATIONS_TABLE) ;
define("WPGA_LOCATIONS_DEFAULT_WHERE_CLAUSE", "") ;

/**
 * default constants for GUIDataListConstruction
 */
define("WPGA_LOCATIONS_COLUMNS",
    WPGA_CUSTOMERS_TABLE . ".customername," . WPGA_LOCATIONS_TABLE . ".*") ;
define("WPGA_LOCATIONS_TABLES",
    WPGA_LOCATIONS_TABLE . "," . WPGA_CUSTOMERS_TABLE) ;
define("WPGA_LOCATIONS_WHERE_CLAUSE", WPGA_CUSTOMERS_TABLE .
    ".customerid=" . WPGA_LOCATIONS_TABLE . ".customerid") ;

/**
 * Define acocunts table name
 */
define("WPGA_FRP_TABLE", WPGA_DB_PREFIX . "frp") ;

/**
 * default constants for GUIDataListConstruction
 */
define("WPGA_FRP_DEFAULT_COLUMNS", "*") ;
define("WPGA_FRP_DEFAULT_TABLES", WPGA_FRP_TABLE) ;
define("WPGA_FRP_DEFAULT_WHERE_CLAUSE", "") ;

/**
 * default constants for GUIDataListConstruction
 */
define("WPGA_FRP_COLUMNS", WPGA_FRP_DEFAULT_COLUMNS) ;
define("WPGA_FRP_TABLES", WPGA_FRP_DEFAULT_TABLES) ;
define("WPGA_FRP_WHERE_CLAUSE", WPGA_FRP_DEFAULT_WHERE_CLAUSE) ;

?>
