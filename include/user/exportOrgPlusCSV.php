<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
/**
 *
 * $Id: showDetail.php,v 1.2 2006/05/31 11:56:57 mike Exp $
 *
 * Sample page used to build site infrastructure.
 *
 * (c) 2005 by Mike Walsh for Mentir Graphics.
 *
 * @author Mike Walsh <mike_walsh@mentor.com>
 * @package Toolbox
 * @subpackage LDAP
 * @version $Revision: 1.2 $
 * @lastmodified $Date: 2006/05/31 11:56:57 $
 * @lastmodifiedby $Author: mike $
 *
 */

//  Initialize the Web Site

require_once("../../../../../wp-config.php") ;
require_once("../../plugininit.include.php") ;
require_once("../db.include.php") ;

//  Load the OrgChart classes

require_once("orgchart.class.php");

function whereami($line = __LINE__, $file = __FILE__)
{
    printf("Where am I?  %s::%s<br>", basename($file), $line) ;
}

/**
 * OrgPlus CSV Document class
 *
 * @author Mike Walsh <mike_walsh@mentor.com>
 * @package Global Accounts
 * @subpackage OrgChart
 * @access public
 */
class OrgPlusCSVDoc extends LDAPQueryCSVTree
{
    /**
     * Org Key - the username the org chart is derived from
     */
    var $orgKey ;

    /**
     * Levels - number of levels to traverse, 0 is no traversal
     */
    var $levels ;

    /**
     * set the Org Key
     *
     * @param - string - username to key org chart from
     */
    function setOrgKey($key)
    {
        $this->orgKey = $key ;
    }

    /**
     * get the Org Key
     *
     * @return - string - username to key org chart from
     */
    function getOrgKey()
    {
        return $this->orgKey ;
    }

    /**
     * set the traverse level
     *
     * @param - int - number of levels to traverse
     */
    function setLevels($levels)
    {
        $this->levels = $levels ;
    }

    /**
     * get the traverse level
     *
     * @return - int - number of levels to traverse
     */
    function getLevels()
    {
        return $this->levels ;
    }

    /**
     * Constructor
     *
     */
    function OrgPlusCSVDoc()
    {
        $scriptargs = array_merge($_GET, $_POST) ;

        if ($_SERVER['REQUEST_METHOD'] == 'GET')
        {
            if (empty($_GET['username']))
                header("Location: " . $_SERVER['HTTP_REFERER']) ;
            else
                $username = $_GET['username'] ;

            if (empty($_GET['levels']))
                $levels = 10 ;
            else if (is_numeric($_GET['levels']))
                $levels = $_GET['levels'] ;
            else
                $levels = 0 ;
        }
        else
        {
            header("Location: " . $_SERVER['HTTP_REFERER']) ;
            //$levels = 0 ;
            //$username = $_POST["radio"][0] ;
        }

        //  Set up the CSV document

        $this->setLevels($levels) ;
        $this->setOrgKey($username) ;

        //  Configure the attributes, use the defaults

        $attributes = array_keys($this->detailAttributes) ;
        
        //  Run the LDAP query

        $ldapQuery = new LDAPQueryByUsername($this->getOrgKey()) ;
        $ldapQuery->setQueryAttributes($attributes) ;
        $ldapQuery->runQuery() ;

        //  Process the query results

        if ($ldapQuery->getQueryResultsCount() != 0)
        {
            $queryResults = $ldapQuery->getQueryResults() ;

            //whereami(__LINE__) ;
            //var_dump($queryResults) ;
            //die("<br><h1>Dead</h1>") ;

            // Make sure the script doesn't time out
            // if the username has a large  organization.

            set_time_limit(0) ;

            //  Build the CSV tree

            parent::LDAPQueryCSVTree($queryResults[0], $this->getLevels()) ;
        }
    }
}

//whereami(__LINE__) ;
$csvdoc = new OrgPlusCSVDoc();
//whereami(__LINE__) ;

//  Make sure we have the CSVDocumentClass automatically
//  output the correct http Content-Type value and header.

//$csvdoc->show_http_header() ;

//  Render the CSV document
   
header('Content-Type: application/csv');
header(sprintf("Content-disposition:  attachment; filename=OrgChart-%s-%s.csv",
    $csvdoc->getOrgKey(), date("Y-m-d"))) ;

//  Render the page

print $csvdoc->render();

?>
