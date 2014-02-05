<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
/**
 *
 * $Id$
 *
 * LDAP functions
 *
 * (c) 2005 by Mike Walsh for Mentor Graphics.
 *
 * @author Mike Walsh <mike_walsh@mentor.com>
 * @package LDAP
 * @subpackage forms
 * @version $Revision$
 *
 */

//  Define LDAP server

define('LDAP_SERVER', 'svr-njw-adc-01.mgc.mentorg.com') ;
define('LDAP_DEFAULT_DN', 'dc=mgc,dc=mentorg,dc=com') ;
define('LDAP_SORT_FIELD', "sn") ;
define('LDAP_UNIQUE_FIELD', "cn") ;

define("__ACTION_SHOW_DETAIL", "Show Detail") ;
define("__ACTION_EXPORT_ORG_CHART", "Export Org Chart") ;
define("__ACTION_NEW_SEARCH", "New Search") ;

define("LDAP_NAME", "name") ;
define("LDAP_NAME_LABEL", "Username") ;
//define("LDAP_EXTA5", "extensionattribute5") ;
define("LDAP_EXTA5", "name") ;
define("LDAP_EXTA5_LABEL", "Employee Id") ;
define("LDAP_FULLNAME", "fullname") ;
define("LDAP_FULLNAME_LABEL", "Name") ;
define("LDAP_FIRSTNAME", "givenname") ;
define("LDAP_FIRSTNAME_LABEL", "First Name") ;
define("LDAP_LASTNAME", "sn") ;
define("LDAP_LASTNAME_LABEL", "Last Name") ;
define("LDAP_TITLE", "title") ;
define("LDAP_TITLE_LABEL", "Title") ;
define("LDAP_MAIL", "mail") ;
define("LDAP_MAIL_LABEL", "E-Mail") ;
define("LDAP_PDO", "physicaldeliveryofficename") ;
define("LDAP_PDO_LABEL", "Location") ;
define("LDAP_PHONE", "othertelephone") ;
define("LDAP_PHONE_LABEL", "Phone") ;
define("LDAP_EXTENSION", "telephonenumber") ;
define("LDAP_EXTENSION_LABEL", "Extension") ;
define("LDAP_FAX", "facsimiletelephonenumber") ;
define("LDAP_FAX_LABEL", "Fax") ;
define("LDAP_ASSISTANT_PHONE", "telephoneassistant") ;
define("LDAP_ASSISTANT_PHONE_LABEL", "Assistant's Phone") ;
define("LDAP_MANAGER", "manager") ;
define("LDAP_MANAGER_LABEL", "Manager") ;
define("LDAP_DIRECT_REPORTS", "directreports") ;
define("LDAP_DIRECT_REPORTS_LABEL", "Direct Reports") ;
define("LDAP_DEPARTMENT", "department") ;
define("LDAP_DEPARTMENT_LABEL", "Department") ;
define("LDAP_COUNTRY", "co") ;
define("LDAP_COUNTRY_LABEL", "Country") ;

?>
