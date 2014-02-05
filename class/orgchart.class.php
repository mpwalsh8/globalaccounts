<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
/**
 *
 * $Id: ldap.class.php,v 1.3 2006/11/07 16:41:26 mike Exp $
 *
 * LDAP functions
 *
 * (c) 2005 by Mike Walsh for Mentor Graphics.
 *
 * @author Mike Walsh <mike_walsh@mentor.com>
 * @package ToolBox
 * @subpackage LDAP
 * @version $Revision: 1.3 $
 *
 */

//define("WPGA_DEBUG", true) ;

require_once("table.class.php") ;
require_once("widgets.class.php") ;
require_once("orgchart.include.php") ;

/**
 * Include Data List objects and XMLDocumentClass
 *
 */
require_once(PHPHTMLLIB_ABSPATH . "/widgets/data_list/includes.inc") ;
require_once(PHPHTMLLIB_ABSPATH . "/widgets/data_list/ArrayDataListSource.inc") ;
require_once(PHPHTMLLIB_ABSPATH . "/widgets/xml/XMLDocumentClass.inc") ;

/**
 * LDAP Query Class - search for data within LDAP
 * based on information supplied by the user.
 *
 * @author Mike Walsh <mike_walsh@mentor.com>
 * @package Global Accounts
 * @subpackage LDAP
 * @access public
 */
class LDAPQuery
{
    var $_dn ;
    var $_filter ;

    var $_queryHeaders ;
    var $_queryResults ;
    var $_queryAttributes ;

    /**
     * Constructor - set the default property values.
     *
     * @param string - optional query filter
     * @param string - optional dn value
     */
    function LDAPQuery($filter = null, $dn = null)
    {
        if (!is_null($filter))
            $this->setFilter($filter) ;

        if (is_null($dn))
            $this->setDn(LDAP_DEFAULT_DN) ;
        else
            $this->setDn($dn) ;

        $this->_queryHeaders = array() ;
        $this->_queryResults = array() ;
        $this->_queryAttributes = array() ;

        $this->setDefaultQueryAttributes() ;
        $this->setDefaultQueryHeaders() ;
    }

    /**
     * Get the value of the dn property.
     *
     * return @string
     */
    function getDn()
    {
        return $this->_dn ;
    }
 
    /**
     * Set the value of the dn property.
     *
     */
    function setDn($dn)
    {
        $this->_dn= $dn ;
    }
 
    /**
     * Get the value of the filter property.
     *
     * @return string
     */
    function getFilter()
    {
        return $this->_filter ;
    }

    /**
     * Set the value of the filter property.
     *
     */
    function setFilter($filter)
    {
        $this->_filter= $filter ;
    }

    /**
     * Set default headers for LDAP query.
     *
     * @return array()
     */
    function getQueryHeaders()
    {
        return $this->_queryHeaders ;
    }

    /**
     * Return the first result from the query.
     *
     * @return array
     */
    function getQueryResult()
    {
        return $this->_queryResults[0] ;
    }

    /**
     * Return results from the query.
     *
     * @return array
     */
    function getQueryResults()
    {
        return $this->_queryResults ;
    }

    /**
     * Return results from the query.
     *
     * @return int
     */
    function getQueryResultsCount()
    {
        return count($this->_queryResults) ;
    }

    /**
     * Set default headers for LDAP query.
     *
     */
    function setDefaultQueryHeaders()
    {
        $this->_queryHeaders = array("Username", "Employee Id", "First Name",
            "Last Name", "Title", "Office", "E-Mail Address") ;
        $this->_queryHeaders = $this->getQueryAttributes() ;
    }
 
    /**
     * Set default attributes for LDAP query.
     *
     */
    function setDefaultQueryAttributes()
    {
        $this->_queryAttributes = array("ou", "sn", "givenname",
            "cn", "mail", "title", "name", "extensionattribute5",
            "physicaldeliveryofficename") ;
    }

    /**
     * Set default attributes for LDAP query.
     *
     */
    function getAllAttributes()
    {
        $attributes = array(
            "name" => "Username"
           ,"extensionattribute5" => "Employee Id"
           ,"givenname" => "First Name"
           ,"sn" => "Last Name"
           ,"title" => "Title"
           ,"mail" => "E-Mail"
           ,"physicaldeliveryofficename" => "Location"
           ,"telephonenumber" => "Phone"
           ,"facsimiletelephonenumber" => "Fax"
           ,"telephoneassistant" => "Assistant's Phone"
           ,"manager" => "Manager"
           ,"directreports" => "Direct Reports"
           ,"company" => "Company"
           ,"department" => "Department"
           ,"co" => "Country"
        ) ;

        return $attributes ;
    }

    /**
     * Get attributes for LDAP query.
     *
     * @return mixed - array of query attributes
     */
    function getQueryAttributes()
    {
        return $this->_queryAttributes ;
    }

    /**
     * Set attributes for LDAP query.
     *
     * @param mixed - array of query attributes
     */
    function setQueryAttributes($attributes)
    {
        $this->_queryAttributes = is_array($attributes) ? $attributes : array($attributes) ;
    }

    /**
     * Run the LDAP query.
     *
     */
    function runQuery()
    {
        $dn = $this->getDn() ;
        $filter = $this->getFilter() ;

        //  Disable PHP timeout - shouldn't be an issue when
        //  running normally within the Mentor network.

        set_time_limit(0) ;

        $ds = ldap_connect(LDAP_SERVER) or die("Unable to connect to LDAP Server") ; 
	    if ($ds)
	    {
	        ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
	        ldap_set_option($ds, LDAP_OPT_REFERRALS, 0);

            //ldap_start_tls($ds) or die("Unable to start LDAP TLS.") ;

	        $ldapstatus = ldap_bind($ds) ;

	        if ($ldapstatus)
	        {
                //  Only return a subset of the LDAP info
                $justthese = $this->getQueryAttributes() ;
		
		        //  Perform the search

		        //$sr = ldap_search($ds, $dn, $filter) ;
		        $sr = ldap_search($ds, $dn, $filter, $justthese) ;

		        if ($sr)
		        {
                    $results = ldap_count_entries($ds, $sr) ;
    
                    $info = ldap_get_entries($ds, $sr) ;
    
                    //  Store the query results after constructing
                    //  them in an array for use later on.

                    $this->_queryResults = array() ;

                    for ($i = 0 ; $i < $info["count"]; $i++)
                    {
                        $queryResult = array() ;

                        foreach ($justthese as $key)
                        {
                            if (key_exists($key, $info[$i]))
                            /*
                            {
                                if ($info[$i][$key]["count"] > 1)
                                {
                                    $queryResult[$key] = array() ;
                                    for ($j = 0 ; $j < $info[$i][$key]["count"] ; $j++)
                                        $queryResult[$key] = $info[$i][$key][$j] ;
                                }
                                else
                                    $queryResult[$key] = $info[$i][$key][0] ;
                            }
                            */
                                    $queryResult[$key] = $info[$i][$key] ;
                            else
                                $queryResult[$key] = "" ;
                        }

                        $this->_queryResults[] = $queryResult ;
                    }
		        }
		        else
		        {
                    die(sprintf("LDAP Search Error (%d):  %s", ldap_errno($ds), ldap_error($ds))) ;
		        }
	        }

	        ldap_close($ds) ;
	    }
    }
}

/**
 * LDAP Query By Name Class - search for data within LDAP
 * based on first and/or last name information supplied by
 * the user.
 *
 * @author Mike Walsh <mike_walsh@mentor.com>
 * @package Global Accounts
 * @subpackage LDAP
 * @access public
 */
class LDAPQueryByName extends LDAPQuery
{
    /**
     * first name property
     */
    var $_firstName ;

    /**
     * last name property
     */
    var $_lastName ;

    /**
     * operator property
     */
    var $_operator ;

    /**
     * Constructor - set the default property values.
     *
     * @param string - optional first name value
     * @param string - optional last name value
     * @param string - optional operator value
     */
    function LDAPQueryByName($firstname = null,
        $lastname = null, $operator = "and")
    {
        $this->setFirstName($firstname) ;
        $this->setLastName($lastname) ;
        $this->setOperator($operator) ;

        //  Call parent constructor

        $this->LDAPQuery() ;
    }

    /**
     * Return the value of the first name property.
     *
     * @return string
     */
    function getFirstName()
    {
        return $this->_firstName ;
    }
 
    /**
     * Set the value of the first name property.
     *
     * @param string - first name value
     */
    function setFirstName($firstname)
    {
        $this->_firstName = $firstname ;
    }
 
    /**
     * Return the value of the last name property.
     *
     * @return string
     */
    function getLastName()
    {
        return $this->_lastName ;
    }
 
    /**
     * Set the value of the last name property.
     *
     * @param string - last name value
     */
    function setLastName($lastname)
    {
        $this->_lastName = $lastname ;
    }
 
    /**
     * Return the value of the operator property.
     *
     * return @string
     */
    function getOperator()
    {
        return $this->_operator ;
    }
 
    /**
     * Set the value of the operator property.
     * Only AND and OR are supported and passing
     * anything other than "or" or "|" results
     * in an AND operation.
     *
     * @param string - operator value
     */
    function setOperator($operator)
    {
        switch (strtolower($operator))
	    {
            case "or" :
                $this->_operator = "|" ;
		        break ;

	        default:
                $this->_operator = "&" ;
		        break ;
	    }
    }
 
    /**
     * Provide the ability to search through LDAP for the information
     * specified by the user.
     *
     */
    function runQuery()
    {
        $firstname = $this->getFirstName() ;
        $lastname = $this->getLastName() ;
        $operator = $this->getOperator() ;

        $filter = "(" . $operator ;

		//  Last name search supplied?

        if (!empty($lastname))
            $filter .= "(sn=" . $lastname . ")" ;

		//  First name search supplied?

        if (!empty($firstname))
            $filter .= "(givenName=" . $firstname . ")" ;

		$filter .= ")" ;

        //  Set the filter property

        $this->setFilter($filter) ;

        //  Run the query from the parent class

        parent::runQuery() ;
    }
}

/**
 * LDAP Query By Username Class - search for data within LDAP
 * based on the username information supplied by the user.
 *
 * @author Mike Walsh <mike_walsh@mentor.com>
 * @package Global Accounts
 * @subpackage LDAP
 * @access public
 */
class LDAPQueryByUsername extends LDAPQuery
{
    /**
     * username property
     */
    var $_username ;

    /**
     * Constructor - set the default property values.
     *
     * @param string - optional username value
     */
    function LDAPQueryByUsername($username = null)
    {
        $this->setUsername($username) ;

        //  Call parent constructor

        $this->LDAPQuery() ;
    }
 
    /**
     * Return the value of the username property.
     *
     * @return string
     */
    function getUsername()
    {
        return $this->_username ;
    }
 
    /**
     * Set the value of the username property.
     *
     * @param string - username value
     */
    function setUsername($username)
    {
        $this->_username = $username ;
    }
 
    /**
     * Provide the ability to search through LDAP for
     * the information specified by the user.
     *
     */
    function runQuery()
    {
        $username = $this->getUsername() ;

        $filter = "(cn=" . $username . ")" ;

        //  Set the filter property

        $this->setFilter($filter) ;

        //  Run the query from the parent class

        parent::runQuery() ;
    }
}

/**
 * LDAP Query By Location Class - search for data within LDAP
 * based on the location information supplied by the user.
 *
 * @author Mike Walsh <mike_walsh@mentor.com>
 * @package Global Accounts
 * @subpackage LDAP
 * @access public
 */
class LDAPQueryByLocation extends LDAPQuery
{
    /**
     * location property
     */
    var $_location ;

    /**
     * Constructor - set the default property values.
     *
     * @param string - optional location value
     */
    function LDAPQueryByLocation($location = null)
    {
        $this->setLocation($location) ;

        //  Call parent constructor

        $this->LDAPQuery() ;
    }
 
    /**
     * Return the value of the location property.
     *
     * @return string
     */
    function getLocation()
    {
        return $this->_location ;
    }
 
    /**
     * Set the value of the location property.
     *
     */
    function setLocation($location)
    {
        $this->_location = $location ;
    }
 
    /**
     * Provide the ability to search through LDAP for
     * the information specified by the user.
     *
     */
    function runQuery()
    {
        $location = $this->getLocation() ;

        $filter = "(physicaldeliveryofficename=" . $location . ")" ;

        //  Set the filter property

        $this->setFilter($filter) ;

        //  Run the query from the parent class

        parent::runQuery() ;
    }
}

/**
 * Child class of InfoTable - present the results
 * of an LDAP Query as an InfoTable
 *
 * @author Mike Walsh <mike_walsh@mentor.com>
 * @access public
 * @see GlobalAccountsInfoTable
 *
 */
class LDAPQueryProfile extends GlobalAccountsInfoTable
{
    /**
     * The constructor
     *
     * @param mixed - the LDAP Query Record
     * @param string - the title
     * @param string - the width of the table
     * @param string - the alignment
     */
    function LDAPQueryProfile($lqr, $title, $width="100%", $align=NULL)
    {
        //  Define a look-up table of the fields of interest

        $detailAttributes = array(
            "name" => "Username"
           ,"extensionattribute5" => "Employee Id"
           ,"givenname" => "First Name"
           ,"sn" => "Last Name"
           ,"title" => "Title"
           ,"mail" => "E-Mail"
           ,"physicaldeliveryofficename" => "Location"
           ,"telephonenumber" => "Phone"
           ,"facsimiletelephonenumber" => "Fax"
           ,"telephoneassistant" => "Assistant's Phone"
           ,"manager" => "Manager"
           ,"directreports" => "Direct Reports"
           ,"company" => "Company"
           ,"department" => "Department"
           ,"co" => "Country"
        ) ;

        $attributes = array_keys($detailAttributes) ;

        //  Call the parent constructor

        $this->InfoTable($title, $width, $align) ;

        //  Add the name by combining two fields

        $this->add_row("Name", $lqr["givenname"][0]
            .  " " . $lqr["sn"][0]) ;

        //  Most of the fields can be added directly, skip
        //  the name field and organizational information
        //  since they are handled separately.

        foreach ($detailAttributes as $key => $value)
        {
            switch ($key)
            {
                case "givenname" :
                case "sn" :
                case "manager" :
                case "directreports" :
                    break ;
                case "mail":
                    if (is_array($lqr[$key]))
                        $this->add_row($value,
                            html_a("mailto:" . $lqr[$key][0], $lqr[$key][0])) ;
                    else if ($lqr[$key] != "")
                        $this->add_row($value,
                            html_a("mailto:" . $lqr[$key], $lqr[$key])) ;
                    else
                        $this->add_row($value, "&nbsp;") ;
                    break ;

                default:
                    if (is_array($lqr[$key]))
                        $this->add_row($value, $lqr[$key][0]) ;
                    else if ($lqr[$key] != "")
                        $this->add_row($value, $lqr[$key]) ;
                    else
                        $this->add_row($value, "&nbsp;") ;
                    break ;
            }
        }

        //  Add manager information

        if (key_exists("manager", $lqr))
        {
            if ($lqr["manager"] != "")
            {
                $managerQuery = new LDAPQuery('sn=*',
                    $lqr["manager"][0]) ;
                $managerQuery->setQueryAttributes(array("givenname",
                    "sn", "cn")) ;
                $managerQuery->runQuery() ;

                //  Need to make sure URI doesn't build up
                //  due to walking the organization hierarchy.

                $uri = $_SERVER['PHP_SELF'] . "?" . $_SERVER['QUERY_STRING'] ;

                $uri = preg_replace('/&?username=[^&]*/i', '', $uri) ;

                //  Make sure we only have one result
    
                if ($managerQuery->getQueryResultsCount() == 1)
                {
                    $mgrResults = $managerQuery->getQueryResults() ;
                    $this->add_row("Manager", html_a($uri .
                        "&username=" .  $mgrResults[0]["cn"][0],
                        $mgrResults[0]["givenname"][0] .  " " .
                        $mgrResults[0]["sn"][0])) ;
                }
            }
            else
                $this->add_row("Manager", "Unknown") ;
        }
        else
            $this->add_row("Manager", "Unknown") ;

        //  Add direct reports information

        if (key_exists("directreports", $lqr))
        {
            if ($lqr["directreports"] != "")
            {
            $numReports = $lqr["directreports"]["count"] ;

            $directReports = "" ;
            $div = html_div() ;

            for ($j = 0 ; $j < $numReports ; $j++)
            {
                $directReportsQuery = new LDAPQuery('sn=*',
                    $lqr["directreports"][$j]) ;
                $directReportsQuery->setQueryAttributes(array("givenname", "sn", "cn")) ;
                $directReportsQuery->runQuery() ;

                //  Make sure we only have one result

                if ($directReportsQuery->getQueryResultsCount() == 1)
                {
                    $drResults = $directReportsQuery->getQueryResults() ;
                    $div->add(html_a($uri . "&username=" .
                        $drResults[0]["cn"][0], $drResults[0]["givenname"][0] .
                        " " . $drResults[0]["sn"][0])) ;

                    if ($j != ($numReports - 1)) $div->add(html_br()) ;
                }

                unset($directReportsQuery) ;
            }
                $this->add_row("Direct Reports", $div) ;
            }
            else
                $this->add_row("Direct Reports", "None") ;

        }
        else
            $this->add_row("Direct Reports", "None") ;
    }
}

/**
 * Child class of XMLDocumentClass - present the
 * results of an LDAP Query as an XMLDocumentClass.
 *
 * @author Mike Walsh <mike_walsh@mentor.com>
 * @access public
 * @see XMLDocumentClass
 *
 */
class LDAPQueryXMLTree extends XMLDocumentClass
{
    //  Define a look-up table of the fields of interest

    var $detailAttributes = array(
        "name" => "Username"
       ,"extensionattribute5" => "Employee Id"
       ,"givenname" => "First Name"
       ,"sn" => "Last Name"
       ,"title" => "Title"
       ,"mail" => "E-Mail"
       ,"physicaldeliveryofficename" => "Location"
       ,"othertelephone" => "Phone"
       ,"telephonenumber" => "Extension"
       ,"facsimiletelephonenumber" => "Fax"
       ,"telephoneassistant" => "Assistant's Phone"
       ,"manager" => "Manager"
       ,"directreports" => "Direct Reports"
       ,"department" => "Department"
       ,"co" => "Country"
    ) ;

    /**
     * Debugging
     *
     */
    function whereami($here = null)
    {
        if (is_null($here)) $here = __FILE__ . "::" . __LINE__ ;

        if (WPGA_DEBUG)
            printf("<h3>Here I am:  %s</h3>", $here) ;
    }

    /**
     * The constructor
     *
     * @param mixed - the LDAP Query Record
     */
    function LDAPQueryXMLTree($lqr, $levels = 0)
    {
        //printf("<h2>Level:  %d</h2>", $levels) ;
        $attributes = array_keys($this->detailAttributes) ;
        //var_dump($attributes) ;

        //  Call the parent constructor

        $this->XMLDocumentClass("Company") ;
        $this->set_root_attribute("title", "Mentor Org Chart") ;
        $this->set_root_attribute( "xmlns", "x-schema:OrgLiteML.xdr") ;

        //  When constructing the Org, the employee's manager
        //  is the outer most record so we start with the manager.

        $employeeTag = $this->ProcessEmployeeRecord($lqr) ;

        //  Add direct reports information

        if (key_exists("directreports", $lqr))
        {
            if ($lqr["directreports"] != "")
            {
                $employeeTag = $this->WalkOrgHierarchyXML($employeeTag, $lqr, $levels) ;
            }
        }
        $this->whereami(basename(__FILE__) . "::" . __LINE__) ;

        //  Add manager information, if it exists, otherwise
        //  simply add the employee as the top level XML tag

        if (key_exists("manager", $lqr))
        {
            if ($lqr["manager"] != "")
            {
                $managerQuery = new LDAPQuery('sn=*', $lqr["manager"][0]) ;
                $managerQuery->setQueryAttributes($attributes) ;
                $managerQuery->runQuery() ;

                //  Make sure we only have one result

                if ($managerQuery->getQueryResultsCount() == 1)
                {
                    $mqr = $managerQuery->getQueryResult() ;
                    //$mqr = $mqr[0] ;

                    $managerTag = $this->ProcessEmployeeRecord($mqr) ;

                    //  Sometimes "department" is
                    //  an array and sometimes it isn't ....

                    if (is_array($mqr["department"]))
                        $department = $mqr["department"][0] ;
                    else
                        $department = $mqr["department"] ;

                    $deptTag = xml_tag("Department") ;
                    $deptTag->set_tag_attribute("title", htmlentities($department)) ;

                    //  Add the employee to the Department then
                    //  add the Department to the Manager and then
                    //  add the Manager to the XML document.

                    //$deptTag->add($employeeTag) ;
                    //$managerTag->add($deptTag) ;
                    $managerTag->add($employeeTag) ;
                    $this->add($managerTag) ;
                }
                else
                {
                    //  Add the employee to the XML document
                    $this->add($employeeTag) ;
                }
            }
            else
            {
                //  Add the employee to the XML document
                $this->add($employeeTag) ;
            }
        }
        else
        {
            //  Add the employee to the XML document
            $this->add($employeeTag) ;
        }
    }

    /**
     *
     *  Recursive method to walk down
     *  the organization's hierarchy.
     */
    function WalkOrgHierarchyXML($employeeTag, $qr, $levels = 0)
    {
        $this->whereami(basename(__FILE__) . "::" . __LINE__) ;
        //printf("<h4>Level:  %d</h4>", $levels) ;
        $numReports = $qr["directreports"]["count"] ;

        $attributes = array_keys($this->detailAttributes) ;

        $this->whereami("working on " . $qr["name"][0]) ;

        //  Sometimes "department" is
        //  an array and sometimes it isn't ....

        if (is_array($qr["department"]))
            $department = $qr["department"][0] ;
        else
            $department = $qr["department"] ;

        $deptTag = xml_tag("Department") ;
        $deptTag->set_tag_attribute("title", htmlentities($department)) ;

        //  Loop through the direct reports

        for ($j = 0 ; $j < $numReports ; $j++)
        {
            $drQuery = new LDAPQuery('sn=*', $qr["directreports"][$j]) ;
            $drQuery->setQueryAttributes($attributes) ;
            $drQuery->runQuery() ;

            //  Make sure we only have one result

            if ($drQuery->getQueryResultsCount() == 1)
            {
                $drqr = $drQuery->getQueryResult() ;

                $drTag = $this->ProcessEmployeeRecord($drqr) ;

                if ($levels)
                {
                    if (key_exists("directreports", $drqr))
                    {
                        if ($drqr["directreports"] != "")
                        {
                            $drTag = $this->WalkOrgHierarchyXML($drTag, $drqr, $levels - 1) ;
                        }
                    }
                }

                $employeeTag->add($drTag) ;
                //$deptTag->add($drTag) ;
            }

            unset($drQuery) ;
        }

        //$employeeTag->add($deptTag) ;

        return $employeeTag ;
    }

    /**
     * Process the query result and turn it into an XML tag
     *
     * LDAP data is somewhat inconsistent - sometimes data is in
     * an array and sometimes it isn't.  Need to handle both cases.
     *
     * @param mixed query result
     * @return XMLTagClass - XML tag containing query result
     */
    function ProcessEmployeeRecord($qr)
    {
        $this->whereami(basename(__FILE__) . "::" . __LINE__) ;
        //  Sometimes "givenname" is
        //  an array and sometimes it isn't ....

        if (is_array($qr["givenname"]))
            $gn = $qr["givenname"][0] ;
        else
            $gn = $qr["givenname"] ;

        //  Sometimes "sn" is
        //  an array and sometimes it isn't ....

        if (is_array($qr["sn"]))
            $sn = $qr["sn"][0] ;
        else
            $sn = $qr["sn"] ;

        //  Sometimes "extensionattribute5" is
        //  an array and sometimes it isn't ....

        if (is_array($qr["extensionattribute5"]))
            $exta5 = $qr["extensionattribute5"][0] ;
        else
            $exta5 = $qr["extensionattribute5"] ;

        //  Sometimes "title" is
        //  an array and sometimes it isn't ....

        if (is_array($qr["title"]))
            $title = $qr["title"][0] ;
        else
            $title = $qr["title"] ;

        //  Sometimes "mail" is
        //  an array and sometimes it isn't ....

        if (is_array($qr["mail"]))
            $mail = $qr["mail"][0] ;
        else
            $mail = $qr["mail"] ;

        //  Sometimes "telephonenumber" is
        //  an array and sometimes it isn't ....

        if (is_array($qr["telephonenumber"]))
            $telephonenumber = $qr["telephonenumber"][0] ;
        else
            $telephonenumber = $qr["telephonenumber"] ;

        //  Sometimes "othertelephone" is
        //  an array and sometimes it isn't ....

        if (is_array($qr["othertelephone"]))
            $othertelephone = $qr["othertelephone"][0] ;
        else
            $othertelephone = $qr["othertelephone"] ;

        //  Sometimes "department" is
        //  an array and sometimes it isn't ....

        if (is_array($qr["department"]))
            $department = $qr["department"][0] ;
        else
            $department = $qr["department"] ;

        //  Sometimes "physical office" is
        //  an array and sometimes it isn't ....

        if (is_array($qr["physicaldeliveryofficename"]))
            $office = $qr["physicaldeliveryofficename"][0] ;
        else
            $office = $qr["physicaldeliveryofficename"] ;

        //  Build the tag

        $tag = $this->buildEmployeeXMLTags( $gn .  " " . $sn, $exta5,
            $title, $mail, $othertelephone, $telephonenumber, $department,
            $office) ;

        return $tag ;
    }

    /**
     * Build XML Tags for Person
     *
     * @param string - name
     * @param string - employee id
     * @param string - title
     * @param string - email address
     * @param string - phone
     * @return XMLTagClass
     */
    function buildEmployeeXMLTags($name, $id, $title, $email,
        $phone, $extension, $department, $office)
    {
        $fnameTag = xml_tag("FormattedName") ;
        $fnameTag->add(htmlentities($name)) ;

        $nameTag = xml_tag("PersonName") ;
        $nameTag->add($fnameTag) ;

        $phoneTag1 = xml_tag("Phone") ;
        $phoneTag1->set_tag_attribute("type", "business") ;
        $phoneTag1->add(htmlentities($phone)) ;

        $phoneTag2 = xml_tag("Phone") ;
        $phoneTag2->set_tag_attribute("type", "extension") ;
        $phoneTag2->add(htmlentities($extension)) ;

        $emailTag = xml_tag("ElectronicAddress") ;
        $emailTag->set_tag_attribute("type", "email") ;
        $emailTag->add(htmlentities($email)) ;

        $officeTag = xml_tag("ElectronicAddress") ;
        $officeTag->set_tag_attribute("type", "homepage") ;
        $officeTag->add(htmlentities($office)) ;

        $contactTag = xml_tag("PersonContact") ;
        $contactTag->add($phoneTag1, $phoneTag2, $emailTag, $officeTag) ;

        $personTag = xml_tag("Person") ;
        $personTag->set_tag_attribute("id", htmlentities($id)) ;
        $personTag->set_tag_attribute("title", htmlentities($title)) ;
        $personTag->add($nameTag, $contactTag) ;
        //$personTag->add($deptTag, $nameTag, $contactTag) ;
        //$personTag->add($deptTag) ;

        $deptTag = xml_tag("Department") ;
        $deptTag->set_tag_attribute("title", htmlentities($department)) ;
        $deptTag->add($personTag) ;

        return $personTag ;
        //return $deptTag ;
    }
}

/**
 * CSV Record Class
 *
 * @author Mike Walsh <nike_walsh@mentor.com>
 * @access public
 */
class LDAPQueryCSVRecord
{
    /**
     * CSV Record Property
     */
    var $__csvRecord ;

    /**
     * Constructor
     *
     */
    function LDAPQueryCSVRecord()
    {
        //  Define a look-up table of the fields of interest

        $detailAttributes = array(
            LDAP_NAME => LDAP_NAME_LABEL
           ,LDAP_EXTA5 => LDAP_EXTA5_LABEL
           ,LDAP_FULLNAME => LDAP_FULLNAME_LABEL
           ,LDAP_FIRSTNAME => LDAP_FIRSTNAME_LABEL
           ,LDAP_LASTNAME => LDAP_LASTNAME_LABEL
           ,LDAP_TITLE => LDAP_TITLE_LABEL
           ,LDAP_MAIL => LDAP_MAIL_LABEL
           ,LDAP_PDO => LDAP_PDO_LABEL
           ,LDAP_PHONE => LDAP_PHONE_LABEL
           ,LDAP_EXTENSION => LDAP_EXTENSION_LABEL
           ,LDAP_FAX => LDAP_FAX_LABEL
           ,LDAP_ASSISTANT_PHONE => LDAP_ASSISTANT_PHONE_LABEL
           ,LDAP_MANAGER => LDAP_MANAGER_LABEL
           ,LDAP_DIRECT_REPORTS => LDAP_DIRECT_REPORTS_LABEL
           ,LDAP_DEPARTMENT => LDAP_DEPARTMENT_LABEL
           ,LDAP_COUNTRY => LDAP_COUNTRY_LABEL
        ) ;

        $this->__csvRecord = array() ;

        foreach ($detailAttributes as $key => $value)
            $this->__csvRecord[$key] = "" ;
    }

    /**
     * Set Element Value
     *
     * @param string element name
     * @param string element value
     */
    function setElementValue($element, $value)
    {
        if (array_key_exists($element, $this->__csvRecord))
            $this->__csvRecord[$element] = $value ;
    }

    /**
     * Get Element Value
     *
     * @param string element name
     * @return string element value
     */
    function getElementValue($element)
    {
        if (array_key_exists($element, $this->__csvRecord))
            return $this->__csvRecord[$element] ;
        else
            return null ;
    }

    /**
     * render the csvRecord
     *
     * @return string - CSV representation of the record
     */
    function render()
    {
        $csv = "" ;

        //  Encapsulate each value with double quotes
        //  and append it on to the CSV string.  Account
        //  for a value that has double quotes in it by
        //  stripping them from the value.

        foreach ($this->__csvRecord as $key => $value)
            $csv .= sprintf("\"%s\",", preg_replace('/"/', '', $value)) ;

        //  Need to trim the trailing comma
 
        return substr($csv, 0, strlen($csv) - 1) ;
    }
}

/**
 *
 * @author Mike Walsh <mike_walsh@mentor.com>
 * @access public
 *
 */
class LDAPQueryCSVTree
{
    //  Define a look-up table of the fields of interest

    var $detailAttributes = array(
        LDAP_NAME => LDAP_NAME_LABEL
       ,LDAP_EXTA5 => LDAP_EXTA5_LABEL
       ,LDAP_FULLNAME => LDAP_FULLNAME_LABEL
       ,LDAP_FIRSTNAME => LDAP_FIRSTNAME_LABEL
       ,LDAP_LASTNAME => LDAP_LASTNAME_LABEL
       ,LDAP_TITLE => LDAP_TITLE_LABEL
       ,LDAP_MAIL => LDAP_MAIL_LABEL
       ,LDAP_PDO => LDAP_PDO_LABEL
       ,LDAP_PHONE => LDAP_PHONE_LABEL
       ,LDAP_EXTENSION => LDAP_EXTENSION_LABEL
       ,LDAP_FAX => LDAP_FAX_LABEL
       ,LDAP_ASSISTANT_PHONE => LDAP_ASSISTANT_PHONE_LABEL
       ,LDAP_MANAGER => LDAP_MANAGER_LABEL
       ,LDAP_DIRECT_REPORTS => LDAP_DIRECT_REPORTS_LABEL
       ,LDAP_DEPARTMENT => LDAP_DEPARTMENT_LABEL
       ,LDAP_COUNTRY => LDAP_COUNTRY_LABEL
    ) ;

    /**
     * Property to hold CSV Records
     *
     */
    var $__csvRecords ;


    /**
     * addCSVRecord()
     *
     * Add CSV text to the 
     *
     * @param string - CSV record
     */
    function addRecord($csvRecord)
    {
        $this->__csvRecords[] = $csvRecord ;

        //if (is_null($csvRecord))
        //{
            //print "<br/>Adding Record<br/>" ;
            //var_dump($csvRecord) ;
            //print "<br/><br/>" ;
            //die("1234567890") ;
        //}
    }

    /**
     * Debugging
     *
     */
    function whereami($here = null)
    {
        if (is_null($here)) $here = __FILE__ . "::" . __LINE__ ;

        if (WPGA_DEBUG)
            printf("<h3>Here I am:  %s</h3>", $here) ;
    }

    /**
     * The constructor
     *
     * @param mixed - the LDAP Query Record
     */
    function LDAPQueryCSVTree($lqr, $levels = 0)
    {
        //  Initialize record structure
        $this->__csvRecords = array() ;

        //printf("<h2>Level:  %d</h2>", $levels) ;
        $attributes = array_keys($this->detailAttributes) ;
        //var_dump($attributes) ;

        //  Call the parent constructor

        //$this->CSVDocumentClass("Company") ;
        //$this->set_root_attribute(LDAP_TITLE, "Mentor Org Chart") ;
        //$this->set_root_attribute( "xmlns", "x-schema:OrgLiteML.xdr") ;

        //  When constructing the Org, the employee's manager
        //  is the outer most record so we start with the manager.

        //  Add manager information, if it exists, otherwise
        //  simply add the employee as the top level CSV tag

        if (key_exists(LDAP_MANAGER, $lqr))
        {
            if ($lqr[LDAP_MANAGER] != "")
            {
                $managerQuery = new LDAPQuery('sn=*', $lqr[LDAP_MANAGER][0]) ;
                $managerQuery->setQueryAttributes($attributes) ;
                $managerQuery->runQuery() ;

                //  Make sure we only have one result

                if ($managerQuery->getQueryResultsCount() == 1)
                {
                    $mqr = $managerQuery->getQueryResult() ;
                    $managerRecord = $this->ProcessEmployeeRecordCSV($mqr) ;
        $this->whereami(basename(__FILE__) . "::" . __LINE__ . ":  Adding Record") ;

                    $this->addRecord($managerRecord) ;
                    $mgrId = $managerRecord->getElementValue(LDAP_EXTA5) ;
                }
            }
            else
            {
                $mgrId = null ;
            }
        }
        else
        {
            $mgrId = null ;
        }

        //  Add the employee's record

        $employeeRecord = $this->ProcessEmployeeRecordCSV($lqr, $mgrId) ;
        $this->whereami(basename(__FILE__) . "::" . __LINE__ . ":  Adding Record") ;
        $this->addRecord($employeeRecord) ;

        //var_dump($employeeRecord) ;
        //die("12345") ;

        //  Add direct reports information

        if (key_exists(LDAP_DIRECT_REPORTS, $lqr))
        {
            if ($lqr[LDAP_DIRECT_REPORTS] != "")
            {
                //$employeeRecord = $this->WalkOrgHierarchyCSV($lqr,
                //    $levels, $employeeRecord->getElementValue(LDAP_EXTA5)) ;
                $this->WalkOrgHierarchyCSV($lqr, $levels,
                    $employeeRecord->getElementValue(LDAP_EXTA5)) ;

                //var_dump($employeeRecord) ;
                //die("1234567890") ;
            }

            //var_dump($employeeRecord) ;
            //die("Dead:  " . __LINE__) ;
        }
        $this->whereami(basename(__FILE__) . "::" . __LINE__) ;

    }

    /**
     *
     *  Recursive method to walk down
     *  the organization's hierarchy.
     */
    function WalkOrgHierarchyCSV($qr, $levels = 0, $mgrId = null)
    {
        $this->whereami(basename(__FILE__) . "::" . __LINE__) ;
        //printf("<h4>Level:  %d</h4>", $levels) ;
        //var_dump($mgrId) ;
        //print "<br>" ;
        $numReports = $qr[LDAP_DIRECT_REPORTS]["count"] ;

        //if (is_null($mgrId))
        //    $mgrId = $qr[LDAP_EXTA5] ;

        $attributes = array_keys($this->detailAttributes) ;

        $this->whereami("working on " . $qr["name"][0]) ;

        //  Loop through the direct reports

        for ($j = 0 ; $j < $numReports ; $j++)
        {
            $drQuery = new LDAPQuery('sn=*', $qr[LDAP_DIRECT_REPORTS][$j]) ;
            $drQuery->setQueryAttributes($attributes) ;
            $drQuery->runQuery() ;

            //  Make sure we only have one result

            if ($drQuery->getQueryResultsCount() == 1)
            {
                $drqr = $drQuery->getQueryResult() ;

                $drRecord = $this->ProcessEmployeeRecordCSV($drqr, $mgrId) ;
        $this->whereami(basename(__FILE__) . "::" . __LINE__ . ":  Adding Record") ;
                //if (is_null($drRecord))
                //{
                    //print "<h3>" ;
                //var_dump($drqr, $drRecord) ;
                    //print "</h3>" ;
                //}
                $this->addRecord($drRecord) ;

                if ($levels != 0)
                {
                    if (key_exists(LDAP_DIRECT_REPORTS, $drqr))
                    {
                        //  Sometimes LDAP_DIRECT_REPORTS is
                        //  an array and sometimes it isn't ....

                        if (is_array($drqr[LDAP_DIRECT_REPORTS]))
                            $reports = $drqr[LDAP_DIRECT_REPORTS][0] ;
                        else
                            $reports = $drqr[LDAP_DIRECT_REPORTS] ;

                        if ($reports != "")
                        {
                            //$drRecord = $this->WalkOrgHierarchyCSV($drqr, $levels - 1, $mgrId) ;
                            $this->WalkOrgHierarchyCSV($drqr, $levels - 1, $drRecord->getElementValue(LDAP_EXTA5)) ;
                            //$this->addRecord($drRecord) ;
                        }
                    }
                }
            }

            unset($drQuery) ;
        }
    }

    /**
     * Process the query result and turn it into an CSV tag
     *
     * LDAP data is somewhat inconsistent - sometimes data is in
     * an array and sometimes it isn't.  Need to handle both cases.
     *
     * @param mixed query result
     * @return CSVRecordClass - CSV tag containing query result
     */
    function ProcessEmployeeRecordCSV($qr, $mgrId = null)
    {
        $this->whereami(basename(__FILE__) . "::" . __LINE__) ;

        if (is_null($qr))
            print "<h1>Null Query Result</h1>" ;

        //var_dump($mgrId) ;
        //print "<br>" ;
        //  Sometimes LDAP_NAME is
        //  an array and sometimes it isn't ....

        if (is_array($qr[LDAP_NAME]))
            $un = $qr[LDAP_NAME][0] ;
        else
            $un = $qr[LDAP_NAME] ;

        //  Sometimes LDAP_FIRSTNAME is
        //  an array and sometimes it isn't ....

        if (is_array($qr[LDAP_FIRSTNAME]))
            $gn = $qr[LDAP_FIRSTNAME][0] ;
        else
            $gn = $qr[LDAP_FIRSTNAME] ;

        //  Sometimes LDAP_LASTNAME is
        //  an array and sometimes it isn't ....

        if (is_array($qr[LDAP_LASTNAME]))
            $sn = $qr[LDAP_LASTNAME][0] ;
        else
            $sn = $qr[LDAP_LASTNAME] ;

        //  Sometimes LDAP_EXTA5 is
        //  an array and sometimes it isn't ....

        if (is_array($qr[LDAP_EXTA5]))
            $exta5 = $qr[LDAP_EXTA5][0] ;
        else
            $exta5 = $qr[LDAP_EXTA5] ;

        //  Sometimes LDAP_TITLE is
        //  an array and sometimes it isn't ....

        if (is_array($qr[LDAP_TITLE]))
            $title = $qr[LDAP_TITLE][0] ;
        else
            $title = $qr[LDAP_TITLE] ;

        //  Sometimes LDAP_MAIL is
        //  an array and sometimes it isn't ....

        if (is_array($qr[LDAP_MAIL]))
            $mail = $qr[LDAP_MAIL][0] ;
        else
            $mail = $qr[LDAP_MAIL] ;

        //  Sometimes LDAP_PHONE is
        //  an array and sometimes it isn't ....

        if (is_array($qr[LDAP_PHONE]))
            $telephonenumber = $qr[LDAP_PHONE][0] ;
        else
            $telephonenumber = $qr[LDAP_PHONE] ;

        //  Sometimes LDAP_EXTENSION is
        //  an array and sometimes it isn't ....

        if (is_array($qr[LDAP_EXTENSION]))
            $othertelephone = $qr[LDAP_EXTENSION][0] ;
        else
            $othertelephone = $qr[LDAP_EXTENSION] ;

        //  Sometimes LDAP_DEPARTMENT is
        //  an array and sometimes it isn't ....

        if (is_array($qr[LDAP_DEPARTMENT]))
            $department = $qr[LDAP_DEPARTMENT][0] ;
        else
            $department = $qr[LDAP_DEPARTMENT] ;

        //  Sometimes "physical office" is
        //  an array and sometimes it isn't ....

        if (is_array($qr[LDAP_PDO]))
            $office = $qr[LDAP_PDO][0] ;
        else
            $office = $qr[LDAP_PDO] ;

        //  Build the record

        //$record = $this->buildEmployeeCSVRecord($un, $exta5,
        $record = $this->buildEmployeeCSVRecord($gn .  " " . $sn, $sn,
            $exta5, $title, $mail, $othertelephone, $telephonenumber,
            $department, $office, $mgrId, $gn, $sn) ;

        //print "<h6>" ;
        //var_dump($record) ;
        //print "</h6>" ;
        return $record ;
    }



    /**
     * Build CSV Records for Person
     *
     * @param string - name
     * @param string - employee id
     * @param string - title
     * @param string - email address
     * @param string - phone
     * @return CSVRecordClass
     */
    function buildEmployeeCSVRecord($fullname, $name, $id, $title, $email,
        $phone, $extension, $department, $office, $mgrId, $gn, $sn)
    {
        //$this->whereami(__LINE__) ;
        //var_dump($name) ;
        //$this->whereami(__LINE__) ;
        $employeeRecord = new LDAPQueryCSVRecord() ;

        $employeeRecord->setElementValue(LDAP_FULLNAME, $fullname) ;
        $employeeRecord->setElementValue(LDAP_NAME, $name) ;
        $employeeRecord->setElementValue(LDAP_EXTA5, $id) ;
        $employeeRecord->setElementValue(LDAP_TITLE, $title) ;
        $employeeRecord->setElementValue(LDAP_MAIL, $email) ;
        $employeeRecord->setElementValue(LDAP_PHONE, $phone) ;
        $employeeRecord->setElementValue(LDAP_EXTENSION, $extension) ;
        $employeeRecord->setElementValue(LDAP_DEPARTMENT, $department) ;
        $employeeRecord->setElementValue(LDAP_PDO, $office) ;
        $employeeRecord->setElementValue(LDAP_FIRSTNAME, $gn) ;
        $employeeRecord->setElementValue(LDAP_LASTNAME, $sn) ;

        if (!is_null($mgrId))
            $employeeRecord->setElementValue(LDAP_MANAGER, $mgrId) ;

        //var_dump($employeeRecord) ;
        //print "<br><br>" ;
        return $employeeRecord ;
    }

    /**
     * Render the CSV Tree
     *
     * @return string CSV tree
     */
    function render()
    {
        $csv = "" ;

        //  Need to build the header
        //  Encapsulate each value with double quotes
        //  and append it on to the CSV string. Need to 
        //  account for double quotes in any value.

        foreach ($this->detailAttributes as $key => $value)
            $csv .= sprintf("\"%s\",", preg_replace('/"/', '', $value)) ;

        //  Need to trim the trailing comma
 
        $csv = substr($csv, 0, strlen($csv) - 1) . "\r\n" ;

        //print_r($this->__csvRecords)  ;
        //print "<br>" ;
        //print_r(count($this->__csvRecords))  ;
        //print "<br>" ;
        //die(basename(__FILE__) . "::" . __LINE__) ;
        foreach ($this->__csvRecords as $key => $value)
        {
            //print "<h1>$key</h1>" ;
            $record = &$this->__csvRecords[$key] ;
            //var_dump($record) ;
            //print "<br><br>" ;
            //var_dump(get_class($record)) ;
            //print "<br><br>" ;
            //var_dump(get_class_methods($record)) ;
            //print "<br><br>" ;
            //print $record->render() ;
            $csv .= $record->render() . "\r\n" ;
        //die(basename(__FILE__) . "::" . __LINE__) ;
        }

        return $csv ;
    }
}

/**
 * Child class of DefaultGUIDataList to present
 * information from an LDAP query to the user.
 *
 * @author Mike Walsh <mike_walsh@mentor.com>
 * @package ToolBox
 * @subpackage LDAP
 */
class LDAPQueryDataList extends GlobalAccountsGUIDataList
{
    /**
     * Property to store the possible actions - used to build action buttons
     */
    var $__normal_actions = array(
         "query" => WPGA_ACTION_LDAP_QUERY
        ,"profile" => WPGA_ACTION_PROFILE
        ,"exportcsv" => WPGA_ACTION_EXPORT_CSV
        ,"exportxml" => WPGA_ACTION_EXPORT_XML
    ) ;

    /**
     * Property to store the possible actions - used to build action buttons
     */
    var $__empty_actions = array(
         "add" => WPGA_ACTION_ADD
    ) ;

    /**
     * Property to store headers for data list.
     */
    var $__headers ;

    /**
     * Property to store the data source.
     */
    var $__data_source ;

    /**
     * The constructor
     *
     * @param string - the title of the data list
     * @param string - the overall width
     * @param string - the column to use as the default sorting order
     * @param boolean - sort the default column in reverse order?
     * @param mixed - header(s)
     */
    function LDAPQueryDataList($title, $width = "100%",
        $orderby='', $reverseorder = false, $headers, $records)
    {
        $this->set_headers($headers) ;
        $this->set_records($records) ;

        //  Call the parent class constructor

        $this->DataList($title, $width, $orderby, $reverseorder) ;
    }

    /**
     * Set the data list headers.
     *
     * This function accept either a single string
     * argument or an array of strings.
     *
     */
    function set_headers($headers = null)
    {
        if (is_array($headers))
	    {
	        $this->__headers = array() ;
	        foreach ($headers as $header)
	            $this->__headers["$header"] = $header ;
	    }
	    else if (!is_null($headers))
	    {
	        $this->__headers = array() ;
	        $this->__headers[$headers] = $headers ;
	    }
	    else
	        $this->__headers = array() ;
    }

    /**
     * Set the source data array
     *
     */
    function set_records(&$sa)
    {
	    $this->__data_source = &$sa ;
    }

    /**
     * Get the source data array
     *
     */
    function get_data_source()
    {
        //print "<h4>get_data_source()</h4>" ;
	    $ds = new ArrayDataListSource($this->__data_source) ;
	    $this->set_data_source($ds) ;
        $this->set_global_prefix(WPGA_DB_PREFIX) ;
    }

    /**
     * user_setup -  set up the DataList
     *
     */
    function user_setup()
    {
	    //  Add the headers to the GUIDataList - default sort column
	    //  is the first header.

        $this->add_header_item("Username", "200", "cn", SORTABLE, SEARCHABLE);
        $this->add_header_item("First Name", "200", "givenname", SORTABLE, SEARCHABLE);
        $this->add_header_item("Last Name", "200", "sn", SORTABLE, SEARCHABLE);
        $this->add_header_item("Title", "200", "title", SORTABLE, SEARCHABLE);
        $this->add_header_item("E-Mail", "200", "mail", SORTABLE, SEARCHABLE);
        $this->add_header_item("Location", "200", "physicaldeliveryofficename", SORTABLE, SEARCHABLE);
        //  turn on the 'collapsable' search block.
        //  The word 'Search' in the output will be clickable,
        //  and hide/show the search box.

        $this->_collapsable_search = true ;

        //  lets add an action column of checkboxes,
        //  and allow us to save the checked items between pages.
	    //  Use the last field for the check box action.

        //  The unique item is the second column.

	    $this->add_action_column('radio', 'FIRST', LDAP_UNIQUE_FIELD) ;

        //  we have to be in POST mode, or we could run out
        //  of space in the http request with the saved
        //  checkbox items
        $this->set_form_method('POST') ;

        //  set the flag to save the checked items
        //  between pages.
        $this->save_checked_items(true) ;
    }

    /**
     * Action Bar - build a set of Action Bar buttons
     *
     * @return container - container holding action bar content
     */
    function actionbar_cell()
    {
        //  Add an ActionBar button based on the action the page
        //  was called with.

        $c = container() ;

        foreach($this->__normal_actions as $key => $button)
        {
            //$b = $this->action_button($button, $_SERVER['REQUEST_URI']) ;

            /**
             * The above line is commented out because it doesn't work
             * under Safari.  For some reason Safari doesn't pass the value
             * argument of the submit button via Javascript.  The below line
             * will work as long as the intended target is the same as
             * what is specified in the FORM's action tag.
             */

            $b = $this->action_button($button) ;
            $b->set_tag_attribute("type", "submit") ;
            $c->add($b) ;
        }

        return $c ;
    }

    /**
     * Action Bar - build a set of Action Bar buttons
     *
     * @return container - container holding action bar content
     */
    function empty_datalist_actionbar_cell()
    {
        //  Add an ActionBar button based on the action the page
        //  was called with.

        $c = container() ;

        foreach($this->__empty_actions as $key => $button)
        {
            //$b = $this->action_button($button, $_SERVER['REQUEST_URI']) ;

            /**
             * The above line is commented out because it doesn't work
             * under Safari.  For some reason Safari doesn't pass the value
             * argument of the submit button via Javascript.  The below line
             * will work as long as the intended target is the same as
             * what is specified in the FORM's action tag.
             */

            $b = $this->action_button($button) ;
            $b->set_tag_attribute("type", "submit") ;
            $c->add($b) ;
        }

        return $c ;
    }
}
?>
