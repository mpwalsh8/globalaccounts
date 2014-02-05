<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
/**
 *
 * $Id$
 *
 * Global Parent includes.  These includes define information used
 * in the Global Parent classes and child classes in the Global Accounts
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
define("WPGA_GLOBAL_PARENTS_TABLE", WPGA_DB_PREFIX . "globalparents") ;

/**
 * default constants for GUIDataListConstruction
 */
define("WPGA_GLOBAL_PARENTS_DEFAULT_COLUMNS", "*") ;
define("WPGA_GLOBAL_PARENTS_DEFAULT_TABLES", WPGA_GLOBAL_PARENTS_TABLE) ;
define("WPGA_GLOBAL_PARENTS_DEFAULT_WHERE_CLAUSE", "") ;

?>
