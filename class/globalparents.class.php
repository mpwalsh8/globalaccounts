<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
/**
 * GlobalParent classes.
 *
 * $Id$
 *
 * (c) 2008 by Mike Walsh
 *
 * @author Mike Walsh <mike_walsh@mentor.com>
 * @package GlobalAccounts
 * @subpackage GlobalParents
 * @version $Revision$
 * @lastmodified $Date$
 * @lastmodifiedby $Author$
 *
 */

require_once("db.class.php") ;
require_once("table.class.php") ;
require_once("widgets.class.php") ;
require_once("globalparents.include.php") ;

/**
 * Need phpHtmlLib's Form Elements ...
 */
require_once(PHPHTMLLIB_ABSPATH . "/form/includes.inc") ;

/**
 * Class definition of the globalparents
 *
 * @author Mike Walsh <mike_walsh@mentor.com>
 * @access public
 * @see GlobalAccountsDBI
 */
class GlobalAccountsGlobalParent extends GlobalAccountsDBI
{
    /**
     * global parent id property - used for unique database identifier
     */
    var $__globalparentid ;

    
    /**
     * global parent name property
     */
    var $__globalparentname ;

    /**
     * modified property
     */
    var $__modified ;

    /**
     * modified by property
     */
    var $__modifiedby ;

    /**
     * Set the globalparent id
     *
     * @param - int - id of the globalparent
     */
    function setGlobalParentId($globalparentid)
    {
        $this->__globalparentid = $globalparentid ;
    }

    /**
     * Get the globalparent id
     *
     * @return - int - id of the globalparent
     */
    function getGlobalParentId()
    {
        return ($this->__globalparentid) ;
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
     * Set the globalparentname of the globalparent
     *
     * @param - string - name of the globalparent
     */
    function setGlobalParentName($globalparentname)
    {
        $this->__globalparentname = $globalparentname ;
    }

    /**
     * Get the name of the globalparent
     *
     * @return - string - name of the globalparent
     */
    function getGlobalParentName()
    {
        return ($this->__globalparentname) ;
    }

    /**
     *
     * Check if a globalparent already exists in the database
     * and return a boolean accordingly.
     *
     * @return - boolean - existance of globalparent
     */
    function globalparentExist()
    {
	    //  Is globalparent already in the database?

        $query = sprintf("SELECT globalparentid FROM %s WHERE globalparentname=\"%s\"",
            WPGA_GLOBAL_PARENTS_TABLE,
            $this->getGlobalParentName()) ;

        $this->setQuery($query) ;
        $this->runSelectQuery() ;

	    //  Make sure globalparent doesn't exist

        $globalparentExists = (bool)($this->getQueryCount() > 0) ;

	    return $globalparentExists ;
    }

    /**
     *
     * Check if a id already exists in the database
     * and return a boolean accordingly.
     *
     * @param - string - optional id
     * @return - boolean - existance of globalparent
     */
    function globalparentExistById($globalparentid = null)
    {
        if (is_null($globalparentid)) $globalparentid = $this->getGlobalParentId() ;

	    //  Is id already in the database?

        $query = sprintf("SELECT globalparentid FROM %s WHERE globalparentid = \"%s\"",
            WPGA_GLOBAL_PARENTS_TABLE, $globalparentid) ;

        $this->setQuery($query) ;
        $this->runSelectQuery(false) ;

	    //  Make sure id doesn't exist

        $globalparentidExists = (bool)($this->getQueryCount() > 0) ;

	    return $globalparentidExists ;
    }

    /**
     * Add a new globalparent
     */
    function addGlobalParent()
    {
        $success = null ;

        //  Make sure the globalparent doesn't exist yet

        if (!$this->globalparentExist())
        {
            global $userdata ;

            get_currentuserinfo() ;

            //  Construct the insert query
 
            $query = sprintf("INSERT INTO %s SET 
                globalparentname=\"%s\",
                modified=NOW(),
                modifiedby=\"%s\"",
                WPGA_GLOBAL_PARENTS_TABLE,
                $this->getGlobalParentName(),
                $userdata->ID) ;

            $this->setQuery($query) ;
            $this->runInsertQuery() ;
            $success = $this->getInsertId() ;
        }

        return $success ;
    }

    /**
     * Update a global parent
     */
    function updateGlobalParent()
    {
        $success = null ;

        //  Make sure the globalparent doesn't exist yet

        if (!$this->globalparentExist())
        {
            global $userdata ;

            get_currentuserinfo() ;

            //  Construct the insert query
 
            $query = sprintf("UPDATE %s SET
                globalparentname=\"%s\",
                modified=NOW(),
                modifiedby=\"%s\"
                WHERE globalparentid=\"%s\"",
                WPGA_GLOBAL_PARENTS_TABLE,
                $this->getGlobalParentName(),
                $userdata->ID,
                $this->getGlobalParentId()
            ) ;

            $this->setQuery($query) ;
            $this->runUpdateQuery() ;
            //$success = $this->getInsertId() ;
        }

        //return $success ;
        return true ;
    }

    /**
     * Delete a global parent
     */
    function deleteGlobalParent()
    {
        $success = null ;

        //  Make sure the globalparent doesn't exist yet

        if (!$this->globalparentExist())
        {
            //  Construct the insert query
 
            $query = sprintf("DELETE FROM %s
                WHERE globalparentid=\"%s\"",
                WPGA_GLOBAL_PARENTS_TABLE,
                $this->getGlobalParentId()
            ) ;

            $this->setQuery($query) ;
            $this->runDeleteQuery() ;
        }

        $success = !$this->globalparentExistById() ;

        return $success ;
    }

    /**
     *
     * Load globalparent record by Id
     *
     * @param - string - optional globalparent id
     */
    function loadGlobalParentById($globalparentid = null)
    {
        if (is_null($globalparentid)) $globalparentid = $this->getGlobalParentId() ;

        //  Dud?
        if (is_null($globalparentid)) return false ;

        $this->setGlobalParentId($globalparentid) ;

        //  Make sure it is a legal globalparent id
        if ($this->globalparentExistById())
        {
            $query = sprintf("SELECT * FROM %s WHERE globalparentid = \"%s\"",
                WPGA_GLOBAL_PARENTS_TABLE, $globalparentid) ;

            $this->setQuery($query) ;
            $this->runSelectQuery() ;

            $result = $this->getQueryResult() ;

            $this->setGlobalParentId($result['globalparentid']) ;
            $this->setGlobalParentName($result['globalparentname']) ;
            $this->setModified($result['modified']) ;
            $this->setModifiedBy($result['modifiedby']) ;
        }

        $globalparentidExists = (bool)($this->getQueryCount() > 0) ;

	    return $globalparentidExists ;
    }

    /**
     * Retrieve the GlobalParent Ids.
     *
     * @return - array - array of globalparent ids
     */
    function getGlobalParentIds()
    {
        //  Select the records for the globalparents

        $query = sprintf("SELECT globalparentid FROM %s", WPGA_GLOBAL_PARENTS_TABLE) ;

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
class GlobalAccountsGlobalParentsGUIDataList extends GlobalAccountsGUIDataList
{
    /**
     * Property to store the possible actions - used to build action buttons
     */
    var $__normal_actions = array(
         "add" => WPGA_ACTION_ADD
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
    function GlobalAccountsGlobalParentsGUIDataList($title, $width = "100%",
        $default_orderby='', $default_reverseorder=FALSE,
        $columns = WPGA_GLOBAL_PARENTS_DEFAULT_COLUMNS,
        $tables = WPGA_GLOBAL_PARENTS_DEFAULT_TABLES,
        $where_clause = WPGA_GLOBAL_PARENTS_DEFAULT_WHERE_CLAUSE)
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
		$this->add_header_item("Global Parent",
	       	    "300", "globalparentname", SORTABLE, SEARCHABLE, "left") ;

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

	    $this->add_action_column('radio', 'FIRST', "globalparentid") ;

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
		    default:
			    $obj = DefaultGUIDataList::build_column_item($row_data, $col_name);
			    break;
		}
		return $obj;
    }
}

/**
 * GUIDataList class for performaing administration tasks
 * on the various globalparents.
 *
 * @author Mike Walsh <mike_walsh@mentor.com>
 * @access public
 * @see GlobalAccountsGlobalParentsGUIDataList
 */
class GlobalAccountsGlobalParentsAdminGUIDataList extends GlobalAccountsGlobalParentsGUIDataList
{
    /**
     * Property to store the possible actions - used to build action buttons
     */
    var $__normal_actions = array(
         "add" => WPGA_ACTION_ADD
        ,"update" => WPGA_ACTION_UPDATE
        ,"delete" => WPGA_ACTION_DELETE
    ) ;
}

/**
 * FEGlobalAccountsGlobalParents - Global Parents list box element
 *
 * @author Mike Walsh <mike_walsh@mentor.com>
 * @access public
 * @see FEListBox
 */
class FEGlobalAccountsGlobalParents extends FEListBox
{
    /**
     * Get the array of season key and value pairs
     *
     * @return mixed - array of season key value pairs
     */
    function _getGlobalParentArray()
    {
        //  GlobalParent Names and Ids

        $globalparents = array() ;

        $globalparent = new GlobalAccountsGlobalParent() ;
        $globalparentIds = $globalparent->getGlobalParentIds() ;

        if (!is_null($globalparentIds))
        {
            foreach ($globalparentIds as $globalparentId)
            {
                $globalparent->loadGlobalParentById($globalparentId["globalparentid"]) ;
                $globalparents[$globalparent->getGlobalParentName()] = $globalparent->getGlobalParentId() ;
            }
        }

        ksort($globalparents) ;

        return $globalparents ;
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
    function FEGlobalAccountsGlobalParents($label, $required = true,
        $width = null, $height = null)
    {
        $this->FEListBox($label, $required,
            $width, $height, $this->_getGlobalParentArray()) ;
    }
}
?>
