<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
/**
 * MGCDivision classes.
 *
 * $Id$
 *
 * (c) 2008 by Mike Walsh
 *
 * @author Mike Walsh <mike_walsh@mentor.com>
 * @package GlobalAccounts
 * @subpackage MGCDivisions
 * @version $Revision$
 * @lastmodified $Date$
 * @lastmodifiedby $Author$
 *
 */

require_once("db.class.php") ;
require_once("table.class.php") ;
require_once("widgets.class.php") ;
require_once("mgcdivisions.include.php") ;

/**
 * Need phpHtmlLib's Form Elements ...
 */
require_once(PHPHTMLLIB_ABSPATH . "/form/includes.inc") ;

/**
 * Class definition of the mgcdivisions
 *
 * @author Mike Walsh <mike_walsh@mentor.com>
 * @access public
 * @see GlobalAccountsDBI
 */
class GlobalAccountsMGCDivision extends GlobalAccountsDBI
{
    /**
     * mgc division id property - used for unique database identifier
     */
    var $__mgcdivisionid ;

    /**
     * mgc division short name property
     */
    var $__mgcdivisionshortname ;

    /**
     * mgc division long name property
     */
    var $__mgcdivisionlongname ;

    /**
     * mgc division color marker property
     */
    var $__mgcdivisioncolormarker ;

    /**
     * modified property
     */
    var $__modified ;

    /**
     * modified by property
     */
    var $__modifiedby ;

    /**
     * Set the mgcdivision id
     *
     * @param - int - id of the mgcdivision
     */
    function setMGCDivisionId($mgcdivisionid)
    {
        $this->__mgcdivisionid = $mgcdivisionid ;
    }

    /**
     * Get the mgcdivision id
     *
     * @return - int - id of the mgcdivision
     */
    function getMGCDivisionId()
    {
        return ($this->__mgcdivisionid) ;
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
     * Set the short name of the mgc division
     *
     * @param - string - short name of the mgc division
     */
    function setMGCDivisionShortName($mgcdivisionshortname)
    {
        $this->__mgcdivisionshortname = $mgcdivisionshortname ;
    }

    /**
     * Get the short name of the mgc division
     *
     * @return - string - short name of the mgc division
     */
    function getMGCDivisionShortName()
    {
        return ($this->__mgcdivisionshortname) ;
    }

    /**
     * Set the long name of the mgc division
     *
     * @param - string - long name of the mgc division
     */
    function setMGCDivisionLongName($mgcdivisionlongname)
    {
        $this->__mgcdivisionlongname = $mgcdivisionlongname ;
    }

    /**
     * Get the long name of the mgc division
     *
     * @return - string - long name of the mgc division
     */
    function getMGCDivisionLongName()
    {
        return ($this->__mgcdivisionlongname) ;
    }

    /**
     * Set the color marker of the mgc division
     *
     * @param - string - color marker of the mgc division
     */
    function setMGCDivisionColorMarker($mgcdivisioncolormarker)
    {
        $this->__mgcdivisioncolormarker = $mgcdivisioncolormarker ;
    }

    /**
     * Get the color marker of the mgc division
     *
     * @return - string - color marker of the mgc division
     */
    function getMGCDivisionColorMarker()
    {
        return ($this->__mgcdivisioncolormarker) ;
    }

    /**
     *
     * Check if a mgcdivision already exists in the database
     * and return a boolean accordingly.
     *
     * @return - boolean - existance of mgcdivision
     */
    function mgcdivisionExist()
    {
	    //  Is mgcdivision already in the database?

        $query = sprintf("SELECT mgcdivisionid FROM %s
            WHERE mgcdivisionshortname=\"%s\"
            AND mgcdivisionlongname=\"%s\"",
            WPGA_MGC_DIVISIONS_TABLE,
            $this->getMGCDivisionShortName(),
            $this->getMGCDivisionLongName()) ;

        $this->setQuery($query) ;
        $this->runSelectQuery() ;

	    //  Make sure mgcdivision doesn't exist

        $mgcdivisionExists = (bool)($this->getQueryCount() > 0) ;

	    return $mgcdivisionExists ;
    }

    /**
     *
     * Check if a id already exists in the database
     * and return a boolean accordingly.
     *
     * @param - string - optional id
     * @return - boolean - existance of mgcdivision
     */
    function mgcdivisionExistById($mgcdivisionid = null)
    {
        if (is_null($mgcdivisionid)) $mgcdivisionid = $this->getMGCDivisionId() ;

	    //  Is id already in the database?

        $query = sprintf("SELECT mgcdivisionid FROM %s WHERE mgcdivisionid = \"%s\"",
            WPGA_MGC_DIVISIONS_TABLE, $mgcdivisionid) ;

        $this->setQuery($query) ;
        $this->runSelectQuery(false) ;

	    //  Make sure id doesn't exist

        $mgcdivisionidExists = (bool)($this->getQueryCount() > 0) ;

	    return $mgcdivisionidExists ;
    }

    /**
     * Add a new mgcdivision
     */
    function addMGCDivision()
    {
        $success = null ;

        //  Make sure the mgcdivision doesn't exist yet

        if (!$this->mgcdivisionExist())
        {
            global $userdata ;

            get_currentuserinfo() ;

            //  Construct the insert query
 
            $query = sprintf("INSERT INTO %s SET 
                mgcdivisionshortname=\"%s\",
                mgcdivisionlongname=\"%s\",
                mgcdivisionwcolormarker=\"%s\",
                modified=NOW(),
                modifiedby=\"%s\"",
                WPGA_MGC_DIVISIONS_TABLE,
                $this->getMGCDivisionShortName(),
                $this->getMGCDivisionLongName(),
                $this->getMGCDivisionColorMarker(),
                $userdata->ID) ;

            $this->setQuery($query) ;
            $this->runInsertQuery() ;
            $success = $this->getInsertId() ;
        }

        return $success ;
    }

    /**
     * Update a mgc division
     */
    function updateMGCDivision()
    {
        $success = null ;

        //  Make sure the mgcdivision doesn't exist yet

        if (!$this->mgcdivisionExist())
        {
            global $userdata ;

            get_currentuserinfo() ;

            //  Construct the insert query
 
            $query = sprintf("UPDATE %s SET
                mgcdivisionshortname=\"%s\",
                mgcdivisionlongname=\"%s\",
                mgcdivisioncolormarker=\"%s\",
                modified=NOW(),
                modifiedby=\"%s\"
                WHERE mgcdivisionid=\"%s\"",
                WPGA_MGC_DIVISIONS_TABLE,
                $this->getMGCDivisionShortName(),
                $this->getMGCDivisionLongName(),
                $this->getMGCDivisionColorMarker(),
                $userdata->ID,
                $this->getMGCDivisionId()
            ) ;

            $this->setQuery($query) ;
            $this->runUpdateQuery() ;
            //$success = $this->getInsertId() ;
        }

        //return $success ;
        return true ;
    }

    /**
     * Delete a mgc division
     */
    function deleteMGCDivision()
    {
        $success = null ;

        //  Make sure the mgcdivision doesn't exist yet

        if (!$this->mgcdivisionExist())
        {
            //  Construct the insert query
 
            $query = sprintf("DELETE FROM %s
                WHERE mgcdivisionid=\"%s\"",
                WPGA_MGC_DIVISIONS_TABLE,
                $this->getMGCDivisionId()
            ) ;

            $this->setQuery($query) ;
            $this->runDeleteQuery() ;
        }

        $success = !$this->mgcdivisionExistById() ;

        return $success ;
    }

    /**
     *
     * Load mgcdivision record by Id
     *
     * @param - string - optional mgcdivision id
     */
    function loadMGCDivisionById($mgcdivisionid = null)
    {
        if (is_null($mgcdivisionid)) $mgcdivisionid = $this->getMGCDivisionId() ;

        //  Dud?
        if (is_null($mgcdivisionid)) return false ;

        $this->setMGCDivisionId($mgcdivisionid) ;

        //  Make sure it is a legal mgcdivision id
        if ($this->mgcdivisionExistById())
        {
            $query = sprintf("SELECT * FROM %s WHERE mgcdivisionid = \"%s\"",
                WPGA_MGC_DIVISIONS_TABLE, $mgcdivisionid) ;

            $this->setQuery($query) ;
            $this->runSelectQuery() ;

            $result = $this->getQueryResult() ;

            $this->setMGCDivisionId($result['mgcdivisionid']) ;
            $this->setMGCDivisionShortName($result['mgcdivisionshortname']) ;
            $this->setMGCDivisionLongName($result['mgcdivisionlongname']) ;
            $this->setMGCDivisionColorMarker($result['mgcdivisioncolormarker']) ;
            $this->setModified($result['modified']) ;
            $this->setModifiedBy($result['modifiedby']) ;
        }

        $mgcdivisionidExists = (bool)($this->getQueryCount() > 0) ;

	    return $mgcdivisionidExists ;
    }

    /**
     * Retrieve the MGCDivision Ids.
     *
     * @return - array - array of mgcdivision ids
     */
    function getMGCDivisionIds()
    {
        //  Select the records for the mgcdivisions

        $query = sprintf("SELECT mgcdivisionid FROM %s", WPGA_MGC_DIVISIONS_TABLE) ;

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
class GlobalAccountsMGCDivisionsGUIDataList extends GlobalAccountsGUIDataList
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
    function GlobalAccountsMGCDivisionsGUIDataList($title, $width = "100%",
        $default_orderby='', $default_reverseorder=FALSE,
        $columns = WPGA_MGC_DIVISIONS_DEFAULT_COLUMNS,
        $tables = WPGA_MGC_DIVISIONS_DEFAULT_TABLES,
        $where_clause = WPGA_MGC_DIVISIONS_DEFAULT_WHERE_CLAUSE)
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
		$this->add_header_item("MGC Division",
	       	    "125", "mgcdivisionshortname", SORTABLE, SEARCHABLE, "left") ;

		$this->add_header_item("MGC Division Full Name",
	       	    "300", "mgcdivisionlongname", SORTABLE, SEARCHABLE, "left") ;

		$this->add_header_item("MGC Division Color Marker",
	       	    "200", "mgcdivisioncolormarker", SORTABLE, SEARCHABLE, "left") ;

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

	    $this->add_action_column('radio', 'FIRST', "mgcdivisionid") ;

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
            case "MGC Division Color Marker":
                $obj = html_span(null, $row_data["mgcdivisioncolormarker"]) ;
                $obj->set_style(sprintf("color: %s;", $row_data["mgcdivisioncolormarker"])) ;
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
 * on the various mgcdivisions.
 *
 * @author Mike Walsh <mike_walsh@mentor.com>
 * @access public
 * @see GlobalAccountsMGCDivisionsGUIDataList
 */
class GlobalAccountsMGCDivisionsAdminGUIDataList extends GlobalAccountsMGCDivisionsGUIDataList
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
 * FEGlobalAccountsMGCDivisions - Global Parents list box element
 *
 * @author Mike Walsh <mike_walsh@mentor.com>
 * @access public
 * @see FEListBox
 */
class FEGlobalAccountsMGCDivisions extends FEListBox
{
    /**
     * Get the array of season key and value pairs
     *
     * @return mixed - array of season key value pairs
     */
    function _getMGCDivisionArray()
    {
        //  MGCDivision Names and Ids

        $mgcdivisions = array() ;

        $mgcdivision = new GlobalAccountsMGCDivision() ;
        $mgcdivisionIds = $mgcdivision->getMGCDivisionIds() ;

        if (!is_null($mgcdivisionIds))
        {
            foreach ($mgcdivisionIds as $mgcdivisionId)
            {
                $mgcdivision->loadMGCDivisionById($mgcdivisionId["mgcdivisionid"]) ;
                $mgcdivisions[$mgcdivision->getMGCDivisionShortName()] = $mgcdivision->getMGCDivisionId() ;
            }
        }

        return $mgcdivisions ;
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
    function FEGlobalAccountsMGCDivisions($label, $required = true,
        $width = null, $height = null)
    {
        $this->FEListBox($label, $required,
            $width, $height, $this->_getMGCDivisionArray()) ;
    }
}
?>
