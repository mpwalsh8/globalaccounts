<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
/**
 *
 * $Id$
 *
 * Plugin includes.  These includes define information used in 
 * the classes and child classes in the Wp-GlobalAccounts plugin.
 *
 * (c) 2007 by Mike Walsh for Wp-GlobalAccounts.
 *
 * @author Mike Walsh <mike_walsh@mentor.com>
 * @package GlobalAccounts
 * @subpackage Admin
 * @version $Revision$
 * @lastmodified $Date$
 * @lastmodifiedby $Author$
 *
 */

/**
 * Define constants used across the plugin
 */

define("WPGA_GENDER_MALE", "male") ;
define("WPGA_GENDER_FEMALE", "female") ;
define("WPGA_GENDER_BOTH", "both") ;

define('WPGA_SIZE_XS', 'xs') ;
define('WPGA_SIZE_S', 's') ;
define('WPGA_SIZE_M', 'm') ;
define('WPGA_SIZE_L', 'l') ;
define('WPGA_SIZE_LT', 'lt') ;
define('WPGA_SIZE_XL', 'xl') ;
define('WPGA_SIZE_XLT', 'xlt') ;
define('WPGA_SIZE_2XL', '2xl') ;
define('WPGA_SIZE_2XLT', '2xlt') ;
define('WPGA_SIZE_3XL', '3xl') ;
define('WPGA_SIZE_3XLT', '3xlt') ;
define('WPGA_SIZE_4XL', '4xl') ;
define('WPGA_SIZE_4XLT', '4xlt') ;

define("WPGA_ENABLED", "enabled") ;
define("WPGA_DISABLED", "disabled") ;
define("WPGA_REQUIRED", "required") ;
define("WPGA_OPTIONAL", "optional") ;
define("WPGA_US_ONLY", "united states") ;
define("WPGA_EU_ONLY", "european union") ;
define("WPGA_INTERNATIONAL", "international") ;
define("WPGA_ACTIVE", "active") ;
define("WPGA_INACTIVE", "inactive") ;
define("WPGA_HIDDEN", "hidden") ;
define("WPGA_PUBLIC", "public") ;
define("WPGA_PRIVATE", "private") ;
define("WPGA_NULL_ID", 0) ;
define("WPGA_NULL_STRING", "") ;

//  Define some default values, stored in options table
define("WPGA_DEFAULT_GENDER", WPGA_GENDER_BOTH) ;
define("WPGA_DEFAULT_GEOGRAPHY", WPGA_INTERNATIONAL) ;
define("WPGA_DEFAULT_POSTAL_CODE_LABEL", "Postal Code") ;
define("WPGA_DEFAULT_STATE_OR_PROVINCE_LABEL", "State or Province") ;
define("WPGA_DEFAULT_USER_OPTION1", WPGA_DISABLED) ;
define("WPGA_DEFAULT_USER_OPTION2", WPGA_DISABLED) ;
define("WPGA_DEFAULT_USER_OPTION3", WPGA_DISABLED) ;
define("WPGA_DEFAULT_USER_OPTION4", WPGA_DISABLED) ;
define("WPGA_DEFAULT_USER_OPTION5", WPGA_DISABLED) ;
define("WPGA_DEFAULT_USER_OPTION1_LABEL", "Optional Field #1") ;
define("WPGA_DEFAULT_USER_OPTION2_LABEL", "Optional Field #2") ;
define("WPGA_DEFAULT_USER_OPTION3_LABEL", "Optional Field #3") ;
define("WPGA_DEFAULT_USER_OPTION4_LABEL", "Optional Field #4") ;
define("WPGA_DEFAULT_USER_OPTION5_LABEL", "Optional Field #5") ;

//  Define a prefix for the options stored in the options table
define("WPGA_OPTION_PREFIX", "ga_") ;

//  Define the option fields and their default values
define("WPGA_OPTION_GENDER", WPGA_OPTION_PREFIX . "gender") ;
define("WPGA_OPTION_GEOGRAPHY", WPGA_OPTION_PREFIX . "geography") ;
define("WPGA_OPTION_GOOGLE_API_KEY", WPGA_OPTION_PREFIX . "google_api_key") ;

//  Define the option fields for the extended user profile
define("WPGA_OPTION_USONLY", WPGA_OPTION_PREFIX . "usonly") ;
define("WPGA_OPTION_USER_STATE_OR_PROVINCE_LABEL", WPGA_OPTION_PREFIX . "user_stateorprovince_label") ;
define("WPGA_OPTION_USER_POSTAL_CODE_LABEL", WPGA_OPTION_PREFIX . "user_postalcode_label") ;
define("WPGA_OPTION_USER_OPTION1", WPGA_OPTION_PREFIX . "user_option1") ;
define("WPGA_OPTION_USER_OPTION1_LABEL", WPGA_OPTION_PREFIX . "user_option1_label") ;
define("WPGA_OPTION_USER_OPTION2", WPGA_OPTION_PREFIX . "user_option2") ;
define("WPGA_OPTION_USER_OPTION2_LABEL", WPGA_OPTION_PREFIX . "user_option2_label") ;
define("WPGA_OPTION_USER_OPTION3", WPGA_OPTION_PREFIX . "user_option3") ;
define("WPGA_OPTION_USER_OPTION3_LABEL", WPGA_OPTION_PREFIX . "user_option3_label") ;
define("WPGA_OPTION_USER_OPTION4", WPGA_OPTION_PREFIX . "user_option4") ;
define("WPGA_OPTION_USER_OPTION4_LABEL", WPGA_OPTION_PREFIX . "user_option4_label") ;
define("WPGA_OPTION_USER_OPTION5", WPGA_OPTION_PREFIX . "user_option5") ;
define("WPGA_OPTION_USER_OPTION5_LABEL", WPGA_OPTION_PREFIX . "user_option5_label") ;

/**
 * Mentor's WTO regions
 */
define("WPGA_WTO_REGION_AMERICAS", "Americas") ;
define("WPGA_WTO_REGION_EUROPE", "Europe") ;
define("WPGA_WTO_REGION_PACRIM", "Pac-Rim") ;
define("WPGA_WTO_REGION_JAPAN", "Japan") ;

/**
 * Relative size of FPR deployment.
 */
define("WPGA_FRP_DEPLOYMENT_NONE_LABEL", "None") ;
define("WPGA_FRP_DEPLOYMENT_SMALL_LABEL", "Small - $0k - $500k") ;
define("WPGA_FRP_DEPLOYMENT_MEDIUM_LABEL", "Medium - $500k - $2m") ;
define("WPGA_FRP_DEPLOYMENT_LARGE_LABEL", "Large - $2m - $5m") ;
define("WPGA_FRP_DEPLOYMENT_ENORMOUS_LABEL", "Enormous - $5m+") ;
define("WPGA_FRP_DEPLOYMENT_NONE_VALUE", 0) ;
define("WPGA_FRP_DEPLOYMENT_SMALL_VALUE", 1) ;
define("WPGA_FRP_DEPLOYMENT_MEDIUM_VALUE", 2) ;
define("WPGA_FRP_DEPLOYMENT_LARGE_VALUE", 3) ;
define("WPGA_FRP_DEPLOYMENT_ENORMOUS_VALUE", 4) ;
define("WPGA_FRP_DEPLOYMENT_NONE_COLOR", "red") ;
define("WPGA_FRP_DEPLOYMENT_SMALL_COLOR", "yellow") ;
define("WPGA_FRP_DEPLOYMENT_MEDIUM_COLOR", "orange") ;
define("WPGA_FRP_DEPLOYMENT_LARGE_COLOR", "green") ;
define("WPGA_FRP_DEPLOYMENT_ENORMOUS_COLOR", "blue") ;

/**
 * Constants for GUIDataListConstruction Action Buttons
 */
define("WPGA_ACTION_ADD", "Add") ;
define("WPGA_ACTION_UPDATE", "Update") ;
define("WPGA_ACTION_REGISTER", "Register") ;
define("WPGA_ACTION_DELETE", "Delete") ;
define("WPGA_ACTION_PROFILE", "Profile") ;
define("WPGA_ACTION_EXPORT_CSV", "Export CSV") ;
define("WPGA_ACTION_EXPORT_XML", "Export XML") ;
define("WPGA_ACTION_DIRECTORY", "Directory") ;
define("WPGA_ACTION_FRP", "FRP") ;
define("WPGA_ACTION_MAP_LOCATION", "Map Location") ;
define("WPGA_ACTION_MAP_LOCATIONS", "Map Locations") ;
define("WPGA_ACTION_MAP_FRP", "Map FRP") ;
define("WPGA_ACTION_LDAP_QUERY", "New Search") ;
define("WPGA_ACTION_LDAP_QUERY_BY_NAME", "Query By Name") ;
define("WPGA_ACTION_LDAP_QUERY_BY_USERNAME", "Query By Username") ;
define("WPGA_ACTION_LDAP_QUERY_BY_LOCATION", "Query By Location") ;

?>
