<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
/**
 *
 * $Id$
 *
 * Form classes.  These classes manage the
 * entry and display of the various forms used
 * by the Wp-GlobalAccounts plugin.
 *
 * (c) 2008 by Mike Walsh for GlobalAccounts.
 *
 * @author Mike Walsh <mike_walsh@mentor.com>
 * @package Wp-GlobalAccounts
 * @subpackage db
 * @version $Revision$
 * @lastmodified $Date$
 * @lastmodifiedby $Author$
 *
 */

//  Need the DB defintions so everything will work

require_once('db.include.php') ;

//  Build upon the WordPress database class

include_once(ABSPATH . '/wp-config.php');
include_once(ABSPATH . '/wp-includes/wp-db.php');

/**
 * Class for managing the GlobalAccounts the database interface.
 *
 * @author Mike Walsh <mike_walsh@mentor.com>
 * @access public
 *
 */

class GlobalAccountsDBI
{
    var $wpdb = null ;

    /**
     * Property to store the query to be exectued.
     */
    var $_query ;

   /**
    * Property to store the results of the query
    * assuming the query submitted was a SELECT query.
    */
    var $_queryResults ;

   /**
    * Property to store the number of rows returned by
    * a select query.
    */
    var $_queryCount ;

   /**
    * Property to store the ID of an INSERT query.
    */
    var $_insertId ;

   /**
    * Mode to fetch query results through the WordPress
    * DB class.  By default, use associative mode which
    * constructs rows indexed by the column headers as
    * opposed to numeric index.
    */
    var $_output = ARRAY_A ;

    /**
     * Set the DB fetch mode.
     *
     * @param int - mode to fetch data in
     */
    function setOutput($mode = ARRAY_A)
    {
        $this->_output = $mode ;
    }

    /**
     * Get the DB fetch mode.
     *
     * @return int - mode to fetch data in
     */
    function getOutput()
    {
        return $this->_output ;
    }

    /**
     * Set the query string to be executed.
     *
     * @param string - query string
     */
    function setQuery($query)
    {
        $this->_query = $query ;
    }

    /**
     * Get the query string to be executed.
     *
     * @return string - query string
     */
    function getQuery()
    {
        return $this->_query ;
    }

    /**
     * Run an update query
     *
     * @return int - query insert id
     */
    function runInsertQuery()
    {
        //  Create a database instance

        if ($this->wpgadb == null)
        {
            $this->wpgadb = new wpdb(WPGA_DB_USERNAME,
                WPGA_DB_PASSWORD, WPGA_DB_NAME, WPGA_DB_HOSTNAME);
        }

        //  Execute the query
 
        $this->wpgadb->query($this->getQuery()) ;

        $this->_insertId = $this->wpgadb->insert_id ;

        return $this->_insertId ;
    }

    /**
     * Run a delete query
     *
     * @return int affected row count
     */
    function runDeleteQuery()
    {
        return $this->runDeleteReplaceOrUpdateQuery() ;
    }

    /**
     * Run a replace query
     *
     * @return int affected row count
     */
    function runReplaceQuery()
    {
        return $this->runDeleteReplaceOrUpdateQuery() ;
    }

    /**
     * Run an update query
     *
     * @return int affected row count
     */
    function runUpdateQuery()
    {
        return $this->runDeleteReplaceOrUpdateQuery() ;
    }

    /**
     * Run a delete, replace, or update query
     *
     * @return int affected row count
     */
    function runDeleteReplaceOrUpdateQuery()
    {
        //  Create a database instance

        if ($this->wpgadb == null)
        {
            $this->wpgadb = new wpdb(WPGA_DB_USERNAME,
                WPGA_DB_PASSWORD, WPGA_DB_NAME, WPGA_DB_HOSTNAME);
        }

        //  Execute the query
 
        $this->wpgadb->query($this->getQuery()) ;

        $this->_affectedRows = $this->wpgadb->rows_affected ;

        return $this->_affectedRows ;
    }

    /**
     * Execute a SELECT query
     *
     * @param boolean - retrieve the results or simply perform the query
     *
     */
    function runSelectQuery($retrieveResults = true)
    {
        //  Create a database instance

        if ($this->wpgadb == null)
        {
            $this->wpgadb = new wpdb(WPGA_DB_USERNAME,
                WPGA_DB_PASSWORD, WPGA_DB_NAME, WPGA_DB_HOSTNAME);
        }

        //  Execute the query
 
        if ($retrieveResults)
        {
            $qr = $this->wpgadb->get_results($this->getQuery(), $this->getOutput()) ;

            if (is_null($qr))
                $this->setQueryCount(0) ;
            else if (!is_array($qr))
                $this->setQueryCount(1) ;
            else
                $this->setQueryCount($this->wpgadb->num_rows) ;

            $this->setQueryResults($qr) ;
        }
        else
        {
            $this->setQueryCount($this->wpgadb->query($this->getQuery())) ;
        }

        return $this->getQueryCount() ;
    }

    /**
     * Return the Id value of the last Insert
     */
    function getInsertId()
    {
        return $this->_insertId ;
    }

    /**
     * Set the number of rows matched by the last query.
     */
    function setQueryCount($count)
    {
        $this->_queryCount = $count ;
    }

    /**
     * Return the number of rows matched by the last query.
     */
    function getQueryCount()
    {
        return $this->_queryCount ;
    }

    /**
     * Return the result of the last query.  Since the query
     * results are stored in an array, a query which has one
     * result is stored in an array containtining one element
     * which in turn contains the query result.
     *
     * This is a shortcult to return the result of a single row.
     */
    function getQueryResult()
    {
        return $this->_queryResults[0] ;
    }

    /**
     * Set the results of the submitted query.
     */
    function setQueryResults($results)
    {
        $this->_queryResults = $results ;
    }

    /**
     * Return the results of the submitted query.
     */
    function getQueryResults()
    {
        return $this->_queryResults ;
    }

    /**
     * Display the database error condition
     *
     * @param string - the error source
     */
    function dbError($errorSource)
    {
        if (mysql_errno() || mysql_error())      
            trigger_error("MySQL error: " . mysql_errno() .
	        " : " . mysql_error() . "({$errorSource})", E_USER_ERROR) ;
        else 
            trigger_error("Could not connect to Global Accounts Database ({$errorSource})", E_USER_ERROR) ;
    }
}
