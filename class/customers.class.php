<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
/**
 * Customer classes.
 *
 * $Id$
 *
 * (c) 2008 by Mike Walsh
 *
 * @author Mike Walsh <mike_walsh@mentor.com>
 * @package GlobalAccounts
 * @subpackage Customers
 * @version $Revision$
 * @lastmodified $Date$
 * @lastmodifiedby $Author$
 *
 */

require_once("db.class.php") ;
require_once("table.class.php") ;
require_once("widgets.class.php") ;
require_once("customers.include.php") ;
require_once("globalparents.class.php") ;

/**
 * Need phpHtmlLib's Form Elements ...
 */
require_once(PHPHTMLLIB_ABSPATH . "/form/includes.inc") ;

/**
 * Class definition of the customers
 *
 * @author Mike Walsh <mike_walsh@mentor.com>
 * @access public
 * @see GlobalAccountsDBI
 */
class GlobalAccountsCustomer extends GlobalAccountsDBI
{
    /**
     * customer id property - used for unique database identifier
     */
    var $__customerid ;

    /**
     * globalparentid property - the id of the global parent
     */
    var $__globalparentid ;

    /**
     * customername property - the name of the customer
     */
    var $__customername ;

    /**
     * web site property - web site of the customer
     */
    var $__website ;

    /**
     * modified property
     */
    var $__modified ;

    /**
     * modified by property
     */
    var $__modifiedby ;

    /**
     * Set the customer id
     *
     * @param - int - id of the customer
     */
    function setCustomerId($customerid)
    {
        $this->__customerid = $customerid ;
    }

    /**
     * Get the customer id
     *
     * @return - int - id of the customer
     */
    function getCustomerId()
    {
        return ($this->__customerid) ;
    }

    /**
     * Set the global parent id of the customer
     *
     * @param - int - customer global parent id
     */
    function setGlobalParentId($globalparentid)
    {
        $this->__globalparentid = $globalparentid ;
    }

    /**
     * Get the global parent id of the customer
     *
     * @return - int - customer global parent id
     */
    function getGlobalParentId()
    {
        return ($this->__globalparentid) ;
    }

    /**
     * Set the customername of the customer
     *
     * @param - string - name of the customer
     */
    function setCustomerName($customername)
    {
        $this->__customername = $customername ;
    }

    /**
     * Get the name of the customer
     *
     * @return - string - name of the customer
     */
    function getCustomerName()
    {
        return ($this->__customername) ;
    }

    /**
     * Set the website of the customer
     *
     * @param - string - website of the customer
     */
    function setWebSite($website)
    {
        $this->__website = $website ;
    }

    /**
     * Get the website of the customer
     *
     * @return - string - website of the customer
     */
    function getWebSite()
    {
        return ($this->__website) ;
    }

    /**
     * Set the modified date
     *
     * @param - string - modification date
     */
    function setModified($modified)
    {
        $this->__modified = $modified ;
    }

    /**
     * Get the modified date
     *
     * @return - string - modification date
     */
    function getModified()
    {
        return ($this->__modified) ;
    }

    /**
     * Set the modified by id
     *
     * @param - int - modification by id
     */
    function setModifiedBy($modifiedby)
    {
        $this->__modifiedby = $modifiedby ;
    }

    /**
     * Get the modified by id
     *
     * @return - int - modification by id
     */
    function getModifiedBy()
    {
        return ($this->__modifiedby) ;
    }

    /**
     *
     * Check if a customer already exists in the database
     * and return a boolean accordingly.
     *
     * @return - boolean - existance of customer
     */
    function customerExist()
    {
	    //  Is customer already in the database?

        $query = sprintf("SELECT customerid FROM %s WHERE 
            globalparentid = \"%s\" AND customername=\"%s\"
            AND website=\"%s\"",
            WPGA_CUSTOMERS_TABLE,
            $this->getGlobalParentId(),
            $this->getCustomerName(),
            $this->getWebSite()) ;

        $this->setQuery($query) ;
        $this->runSelectQuery() ;

	    //  Make sure customer doesn't exist

        $customerExists = (bool)($this->getQueryCount() > 0) ;

	    return $customerExists ;
    }

    /**
     *
     * Check if a id already exists in the database
     * and return a boolean accordingly.
     *
     * @param - string - optional id
     * @return - boolean - existance of customer
     */
    function customerExistById($customerid = null)
    {
        if (is_null($customerid)) $customerid = $this->getCustomerId() ;

	    //  Is id already in the database?

        $query = sprintf("SELECT customerid FROM %s WHERE customerid = \"%s\"",
            WPGA_CUSTOMERS_TABLE, $customerid) ;

        $this->setQuery($query) ;
        $this->runSelectQuery(false) ;

	    //  Make sure id doesn't exist

        $customeridExists = (bool)($this->getQueryCount() > 0) ;

	    return $customeridExists ;
    }

    /**
     * Add a new customer
     */
    function addCustomer()
    {
        $success = null ;

        //  Make sure the customer doesn't exist yet

        if (!$this->customerExist())
        {
            global $userdata ;

            get_currentuserinfo() ;

            //  Construct the insert query
 
            $query = sprintf("INSERT INTO %s SET 
                globalparentid=\"%s\",
                customername=\"%s\",
                website=\"%s\",
                modified=NOW(),
                modifiedby=\"%s\"",
                WPGA_CUSTOMERS_TABLE,
                $this->getGlobalParentId(),
                $this->getCustomerName(),
                $this->getWebSite(),
                $userdata->ID) ;

            $this->setQuery($query) ;
            $this->runInsertQuery() ;
            $success = $this->getInsertId() ;
        }

        return $success ;
    }

    /**
     * Update an customer
     */
    function updateCustomer()
    {
        $success = null ;

        //  Make sure the customer doesn't exist yet

        if (!$this->customerExist())
        {
            global $userdata ;

            get_currentuserinfo() ;

            //  Construct the insert query
 
            $query = sprintf("UPDATE %s SET
                globalparentid=\"%s\",
                customername=\"%s\",
                website=\"%s\",
                modified=NOW(),
                modifiedby=\"%s\"
                WHERE customerid=\"%s\"",
                WPGA_CUSTOMERS_TABLE,
                $this->getGlobalParentId(),
                $this->getCustomerName(),
                $this->getWebSite(),
                $userdata->ID,
                $this->getCustomerId()
            ) ;

            $this->setQuery($query) ;
            $this->runUpdateQuery() ;
            //$success = $this->getInsertId() ;
        }

        //return $success ;
        return true ;
    }

    /**
     * Delete an customer
     */
    function deleteCustomer()
    {
        $success = null ;

        //  Make sure the customer doesn't exist yet

        if (!$this->customerExist())
        {
            //  Construct the insert query
 
            $query = sprintf("DELETE FROM %s
                WHERE customerid=\"%s\"",
                WPGA_CUSTOMERS_TABLE,
                $this->getCustomerId()
            ) ;

            $this->setQuery($query) ;
            $this->runDeleteQuery() ;
        }

        $success = !$this->customerExistById() ;

        return $success ;
    }

    /**
     *
     * Load customer record by Id
     *
     * @param - string - optional customer id
     */
    function loadCustomerByCustomerId($customerid = null)
    {
        if (is_null($customerid)) $customerid = $this->getCustomerId() ;

        //  Dud?
        if (is_null($customerid)) return false ;

        $this->setCustomerId($customerid) ;

        //  Make sure it is a legal customer id
        if ($this->customerExistById())
        {
            $query = sprintf("SELECT * FROM %s WHERE customerid = \"%s\"",
                WPGA_CUSTOMERS_TABLE, $customerid) ;

            $this->setQuery($query) ;
            $this->runSelectQuery() ;

            $result = $this->getQueryResult() ;

            $this->setCustomerId($result['customerid']) ;
            $this->setGlobalParentId($result['globalparentid']) ;
            $this->setCustomerName($result['customername']) ;
            $this->setWebSite($result['website']) ;
        }

        $customeridExists = (bool)($this->getQueryCount() > 0) ;

	    return $customeridExists ;
    }

    /**
     * Retrieve the Customer Ids.
     *
     * @return - array - array of customer ids
     */
    function getCustomerIds()
    {
        //  Select the records for the customers

        $query = sprintf("SELECT customerid FROM %s", WPGA_CUSTOMERS_TABLE) ;

        $this->setQuery($query) ;
        $this->runSelectQuery() ;

        return $this->getQueryResults() ;
    }
}

/**
 * Extended GUIDataList Class for presenting GlobalAccounts
 * information extracted from the database.
 *
 * @author Mike Walsh <mike_walsh@mentor.com>
 * @access public
 * @see GlobalAccountsGUIDataList
 */
class GlobalAccountsCustomersGUIDataList extends GlobalAccountsGUIDataList
{
    /**
     * Property to store the possible actions - used to build action buttons
     */
    var $__normal_actions = array(
         "profile" => WPGA_ACTION_PROFILE
        ,"add" => WPGA_ACTION_ADD
        ,"update" => WPGA_ACTION_UPDATE
    ) ;

    /**
     * Property to store the possible actions - used to build action buttons
     */
    var $__empty_actions = array(
         "add" => WPGA_ACTION_ADD
    ) ;

    /**
     * The constructor
     *
     * @param string - the title of the data list
     * @param string - the overall width
     * @param string - the column to use as the default sorting order
     * @param boolean - sort the default column in reverse order?
     * @param string - columns to query return from database
     * @param string - tables to query from database
     * @param string - where clause for database query
     */
    function GlobalAccountsCustomersGUIDataList($title, $width = "100%",
        $default_orderby='', $default_reverseorder=FALSE,
        $columns = WPGA_CUSTOMERS_DEFAULT_COLUMNS,
        $tables = WPGA_CUSTOMERS_DEFAULT_TABLES,
        $where_clause = WPGA_CUSTOMERS_DEFAULT_WHERE_CLAUSE)
    {
        //  Set the properties for this child class
        //$this->setColumns($columns) ;
        //$this->setTables($tables) ;
        //$this->setWhereClause($where_clause) ;

        //  Call the constructor of the parent class
        $this->GlobalAccountsGUIDataList($title, $width,
            $default_orderby, $default_reverseorder,
            $columns, $tables, $where_clause) ;
    }

    /**
     * This method is used to setup the options
	 * for the DataList object's display
	 * Which columns to show, their respective 
	 * source column name, width, etc. etc.
	 *
     * The constructor automatically calls 
	 * this function.
	 *
     */
	function user_setup()
    {
		//add the columns in the display that you want to view.
		//The API is :
		//Title, width, DB column name, field SORTABLE?, field SEARCHABLE?, align
		$this->add_header_item("Customer Name",
	       	    "200", "customername", SORTABLE, SEARCHABLE, "left") ;

	  	$this->add_header_item("Global Parent",
	         	    "300", "globalparentid", SORTABLE, SEARCHABLE, "left") ;

	  	$this->add_header_item("Web Site",
	         	    "200", "website", SORTABLE, SEARCHABLE, "left") ;

        //  Construct the DB query
        $this->_datasource->setup_db_options($this->getColumns(),
            $this->getTables(), $this->getWhereClause()) ;

        //  turn on the 'collapsable' search block.
        //  The word 'Search' in the output will be clickable,
        //  and hide/show the search box.

        $this->_collapsable_search = true ;

        //  lets add an action column of checkboxes,
        //  and allow us to save the checked items between pages.
	    //  Use the last field for the check box action.

        //  The unique item is the second column.

	    $this->add_action_column('radio', 'FIRST', "customerid") ;

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

    /**
     * This is the basic function for letting us
     * do a mapping between the column name in
     * the header, to the value found in the DataListSource.
     *
     * NOTE: this function can be overridden so that you can
     *       return whatever you want for any given column.  
     *
     * @param array - $row_data - the entire data for the row
     * @param string - $col_name - the name of the column header
     *                             for this row to render.
     * @return mixed - either a HTMLTag object, or raw text.
     */
	function build_column_item($row_data, $col_name)
    {
		switch ($col_name)
        {
                /*
            case "Updated" :
                $obj = strftime("%Y-%m-%d @ %T", (int)$row_data["updated"]) ;
                break ;
                */
            case "Global Parent" :
                $gp = new GlobalAccountsGlobalParent() ;
                $gp->loadGlobalParentById($row_data["globalparentid"]) ;
                $obj = $gp->getGlobalParentName() ;
                break ;

            case "Web Site" :
                $obj = html_a($row_data["website"], $row_data["website"]) ;
                break ;

		    default:
			    $obj = DefaultGUIDataList::build_column_item($row_data, $col_name);
			    break;
		}
		return $obj;
    }
}

/**
 * GUIDataList class for performaing administration tasks
 * on the various customers.
 *
 * @author Mike Walsh <mike_walsh@mentor.com>
 * @access public
 * @see GlobalAccountsCustomersGUIDataList
 */
class GlobalAccountsCustomersAdminGUIDataList extends GlobalAccountsCustomersGUIDataList
{
    /**
     * Property to store the possible actions - used to build action buttons
     */
    var $__normal_actions = array(
         "profile" => WPGA_ACTION_PROFILE
        ,"add" => WPGA_ACTION_ADD
        ,"update" => WPGA_ACTION_UPDATE
        ,"delete" => WPGA_ACTION_DELETE
    ) ;
}

/**
 * FEGlobalAccountsCustomers - Customers list box element
 *
 * @author Mike Walsh <mike_walsh@mindspirng.com>
 * @access public
 * @see FEListBox
 */
class FEGlobalAccountsCustomers extends FEListBox
{
    /**
     * Get the array of season key and value pairs
     *
     * @return mixed - array of season key value pairs
     */
    function _getCustomerArray()
    {
        //  Customer Names and Ids

        $customers = array() ;

        $customer = new GlobalAccountsCustomer() ;
        $customerIds = $customer->getCustomerIds() ;

        if (!is_null($customerIds))
        {
            foreach ($customerIds as $customerId)
            {
                $customer->loadCustomerByCustomerId($customerId["customerid"]) ;
                $customers[$customer->getCustomerName()] = $customer->getCustomerId() ;
            }
        }

        ksort($customers) ;

        return $customers ;
    }

    /**
     * The constructor
     *
     * @param string text label for the element
     * @param boolean is this a required element?
     * @param int element width in characters, pixels (px),
              percentage (%) or elements (em)
     * @param int element height in px
     * @param array data_list - list of data elements (name=>value)
     */
    function FEGlobalAccountsCustomers($label, $required = true,
        $width = null, $height = null)
    {
        $this->FEListBox($label, $required,
            $width, $height, $this->_getCustomerArray()) ;
    }
}


/**
 * Extended InfoTable Class for presenting GlobalAccounts
 * customer information as a table extracted from the database.
 *
 * @author Mike Walsh <mike_walsh@mentor.com>
 * @access public
 * @see GlobalAccountsInfoTable
 */
if (0) {
class CustomerInfoTable extends GlobalAccountsInfoTable
{
    function __buildSelectClause()
    {
        $cutoffdate = sprintf("%s-%02s-%02s", date("Y"), 
            get_option(WPGA_OPTION_AGE_CUTOFF_MONTH),
            get_option(WPGA_OPTION_AGE_CUTOFF_DAY)) ;

        $select_clause = sprintf(WPGA_ROSTER_COUNT_COLUMNS, 
            $cutoffdate, $cutoffdate, $cutoffdate) ;

        return $select_clause ;
    }

    /**
     * Build query where clause
     *
     * @return string - where clause for GUIDataList query
     */
    function __buildWhereClause()
    {
        $cutoffdate = sprintf("%s-%02s-%02s", date("Y"), 
            get_option(WPGA_OPTION_AGE_CUTOFF_MONTH),
            get_option(WPGA_OPTION_AGE_CUTOFF_DAY)) ;

        $season = new GlobalAccountsSeason() ;
        $seasonId = $season->getActiveSeasonId() ;

        //  On the off chance there isn't an active season
        //  set the season id to an invalid number so the SQL
        //  won't fail.
        
        if ($seasonId == null) $seasonId = -1 ;

        $where_clause = sprintf(WPGA_ROSTER_COUNT_WHERE_CLAUSE, $seasonId,
            $cutoffdate, $cutoffdate, $cutoffdate, $cutoffdate, $cutoffdate,
            $cutoffdate) ;

        return $where_clause ;
    }

    /**
     * construct the InfoTable
     *
     */
    function constructCustomerInfoTable()
    {
        //  Alternate the row colors
        $this->set_alt_color_flag(true) ;

        //  Count the number of customers under each global parent
 
        $a = new GlobalAccountsDBI() ;
        $a->setQuery(sprintf("SELECT %s FROM %s WHERE %s",
            $this->__buildSelectClause(), WPGA_ROSTER_COUNT_TABLES,
            $this->__buildWhereClause())) ;
        $a->runSelectQuery() ;

        $agc = $a->getQueryResults() ;

        //  Build a complete customer report for all defined
        //  customers.  The prior query only reports customers
        //  which contains swimmers - we need to customer for the
        //  customers which are unpopulated as well.
 
        $a = new Customer() ;

        $a->setQuery(sprintf("SELECT customerid FROM %s
            ORDER BY globalparentid, customername", WPGA_CUSTOMERS_TABLE)) ;
        $a->runSelectQuery() ;

        //  Make sure we have some data

        if ($a->getQueryCount() > 0)
        {
            $totals = array(__(ucfirst("swimmers")) => 0) ;

            $this->add_row(html_b(__("Global Parent")), html_b(__("Customers"))) ;

            $customers = $a->getQueryResults() ;

            foreach ($customers as $customer)
            {
                $a->setCustomerId($customer["customerid"]) ;
                $a->loadCustomerByCustomerId() ;

                $customercount = 0 ;

                for ($i = 0 ; $i < count($agc) ; $i++)
                {

                    if ($agc[$i]["customer"] == $a->getWebSite() . " " . $a->getGlobalParent() . " - " . $a->getCustomerName())
                    {
                        $customercount = $agc[$i]["customercount"] ;
                        break ;
                    }
                }

                $this->add_row(__(ucfirst($a->getWebSiteLabel() . "s")) . " " .
                    $a->getGlobalParent() . " - " . $a->getCustomerName(),
                   sprintf("%s", $customercount)) ;

                //  Keep a running total of swimmers by website and total count
                
                if (array_key_exists(__(ucfirst($a->getWebSiteLabel() . "s")), $totals))
                    $totals[__(ucfirst($a->getWebSiteLabel() . "s"))] += $customercount ;
                else
                    $totals[__(ucfirst($a->getWebSiteLabel() . "s"))] = $customercount ;

                $totals[__(ucfirst("swimmers"))] += $customercount ;
            }

            foreach ($totals as $key => $total)
                $this->add_row(html_b(__("Total " . $key)), html_b($total)) ;
        }
        else
        {
            $this->add_row(html_b("No customers defined.")) ;
        }
    }
}}
?>
