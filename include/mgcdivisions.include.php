<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
/**
 *
 * $Id$
 *
 * MGC Division includes.  These includes define information used
 * in the MGC Division classes and child classes in the Global Accounts
 * plugin.
 *
 * (c) 2008 by Mike Walsh for Wp-SwimTeam.
 *
 * @author Mike Walsh <mike_walsh@mentor.com>
 * @package Global Accounts
 * @subpackage MGC Divisions
 * @version $Revision$
 * @lastmodified $Date$
 * @lastmodifiedby $Author$
 *
 */

include_once("db.include.php") ;

/**
 * Define age group table name
 */
define("WPGA_MGC_DIVISIONS_TABLE", WPGA_DB_PREFIX . "mgcdivisions") ;

/**
 * default constants for GUIDataListConstruction
 */
define("WPGA_MGC_DIVISIONS_DEFAULT_COLUMNS", "*") ;
define("WPGA_MGC_DIVISIONS_DEFAULT_TABLES", WPGA_MGC_DIVISIONS_TABLE) ;
define("WPGA_MGC_DIVISIONS_DEFAULT_WHERE_CLAUSE", "") ;

?>
