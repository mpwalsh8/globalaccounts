<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
/**
 *
 * $Id$
 *
 * Widget classes.  These classes create and/or extend
 * phpHtmlLib based widgets used by the Wp-GlobalAccounts plugin.
 *
 * (c) 2008 by Mike Walsh for Global Accounts.
 *
 * @author Mike Walsh <mike_walsh@mentor.com>
 * @package Wp-GlobalAccounts
 * @subpackage widget
 * @version $Revision$
 * @lastmodified $Date$
 * @lastmodifiedby $Author$
 *
 */

include_once(PHPHTMLLIB_ABSPATH . "/widgets/data_list/includes.inc") ;
include_once(PHPHTMLLIB_ABSPATH . "/widgets/data_list/WordPressSQLDataListSource.inc") ;

include_once("db.include.php") ;

/**
 * Class to construct Javscript Back and Home buttons
 *
 *
 * @author Mike Walsh <mike_walsh@mentor.com>
 * @access public
 * @see SPANtag
 */
class GlobalAccountsGUIBackHomeButtons extends SPANtag
{
    function getButtons()
    {
        if (!array_key_exists('QUERY_STRING', $_SERVER))
            $uri = $_SERVER['PHP_SELF'] ;
        else
            $uri = $_SERVER['PHP_SELF'] . "?" . $_SERVER['QUERY_STRING'] ;
        
        $back = html_button("button", "Back") ;
        $back->set_tag_attribute("onclick",
            "javascript:document.location='" .
            get_option('siteurl') . $uri . "' ;") ;
        $back->set_tag_attribute("style", "margin: 10px;") ;

        $home = html_button("button", "Home") ;
        $home->set_tag_attribute("onclick",
            "javascript:document.location='" .  get_option('siteurl') . "' ;") ;
        $home->set_tag_attribute("style", "margin: 10px;") ;

        return html_span(null, $back, $home) ;
    }
}

/**
 * Extended GUIDataList Class for presenting GlobalAccounts
 * information extracted from the database.
 *
 * @author Mike Walsh <mike_walsh@mentor.com>
 * @access public
 * @see DefaultGUIDataList
 */
class GlobalAccountsGUIDataList extends DefaultGUIDataList
{
	// change the # of rows to display to 20 from 10
	var $_default_rows_per_page = 10 ;

    /**
     * Class properties to drive the GUIDataList
     */

    var $__columns ;
    var $__tables ;
    var $__where_clause ;

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
    function GlobalAccountsGUIDataList($title, $width = "100%",
        $default_orderby = '', $default_reverseorder = FALSE,
        $columns, $tables, $where_clause)
    {
        //  Set the properties for this child class
        $this->setColumns($columns) ;
        $this->setTables($tables) ;
        $this->setWhereClause($where_clause) ;

        //  Call the constructor of the parent class
        $this->DefaultGUIDataList($title, $width,
            $default_orderby, $default_reverseorder) ;

        //  Alternate row colors
        $this->set_alternating_row_colors(true) ;
    }

    /**
     * Return columns which GUIDataList is sourced from
     *
     * @return string - the comma separated column list
     *
     */
    function getColumns()
    {
        return $this->__columns ;
    }

    /**
     * Set columns which GUIDataList is sourced from
     *
     * @param string - $columns - the comma separated column list
     *
     */
    function setColumns($columns)
    {
        $this->__columns = $columns ;
    }

    /**
     * Return tables which GUIDataList is sourced from
     *
     * @return string - the comma separated table list
     *
     */
    function getTables()
    {
        return $this->__tables ;
    }

    /**
     * Set table(s) which GUIDataList is sourced from
     *
     * @param string - $tables - the comma separated table list
     *
     */
    function setTables($tables)
    {
        $this->__tables = $tables ;
    }

    /**
     * Return the WHERE CLAUSE which GUIDataList is sourced from
     *
     * @return string - the WHERE CLAUSE
     *
     */
    function getWhereClause()
    {
        return $this->__where_clause ;
    }

    /**
     * Set the WHERE CLAUSE which GUIDataList is sourced from
     *
     * @param string - $where_clause - the WHERE CLAUSE
     *
     */
    function setWhereClause($where_clause)
    {
        $this->__where_clause = $where_clause ;
    }

	/**
	 * This function is called automatically by
	 * the DataList constructor.  It must be
	 * extended by the child class to actually
	 * set the DataListSource object.
	 *
	 * 
	 */
    function get_data_source()
    {
		//build the PEAR DB object and connect
		//to the database.

        $db = new wpdb(WPGA_DB_USERNAME,
            WPGA_DB_PASSWORD, WPGA_DB_NAME, WPGA_DB_HOSTNAME);

		//  Create the DataListSource object
		//  and pass in the WordPress DB object
		$source = new WordPressSQLDataListSource($db) ;
		//$source = new PEARSQLDataListSource($wpdb->dbh) ;

		//  Set the DataListSource for this DataList
		//  Every DataList needs a Source for it's data.
		$this->set_data_source($source) ;

		//  Set the prefix for all the internal query string 
		//  variables.  You really only need to change this
		//  if you have more then 1 DataList object per page.
		$this->set_global_prefix(WPGA_DB_PREFIX) ;
	}

	/**
     * This method is used to setup the optons
	 * for the DataList object's display. 
	 * Which columns to show, their respective 
	 * source column name, width, etc. etc.
	 *
     * The constructor automatically calls 
	 * this function.
	 *
     */
    function user_setup()
    {
        user_error("GlobalAccountsGUIDataList::actionbar_cell() - child class " .
            "must override this to set the the database table.") ;
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

		    default:
			    $obj = DefaultGUIDataList::build_column_item($row_data, $col_name);
			    break;
		}
		return $obj;
	}

    /**
     * This function is called automatically by the DataList constructor.
     * It must be extended by the child class to actually provide buttons
     * which do something useful.
     *
     */
    function actionbar_cell()
    {
        user_error("GlobalAccountsGUIDataList::actionbar_cell() - child class " .
            "must override this to set the the database table.") ;
    }

    /**
     * This function overloads the DataList class function
     * supplied with phpHtmlLib.  As delivered, the build_base_url()
     * function incorrectly builds a page in certain instances in the
     * Wordpress Admin chain.  By using REQUEST_URI instead of PHP_SELF
     * the correct URL is constructed and the widget works as expected.
     *
     * This builds the base url used
     * by the column headers as well
     * as the page tool links.
     *
     * it basically builds:
     * $_SELF?$_GET - not anymore, now it builds $_SELF?$_QUERY_STRING
     *
     * @return string
     */
    function build_base_url()
    {

        //$url = $_SERVER["PHP_SELF"]."?";
        $url = $_SERVER["PHP_SELF"]."?";
        $uri = $_SERVER["PHP_SELF"] . "?" . $_SERVER["QUERY_STRING"] ;

        //  On a POST, return the URI instead of
        //  constructing a page url.
        if ( $this->get_form_method() == "POST" ) {
            return $uri;
        }

        $vars = array_merge($_POST, $_GET);
        //request method independant access to
        //browser variable
        if ( count($vars) ) {
            //walk through all of the get vars
            //and add them to the url to save them.
            foreach($vars as $name => $value) {

                if ( $name != $this->_vars["offsetVar"] &&
                     $name != $this->_vars["orderbyVar"] &&
                     $name != $this->_vars["reverseorderVar"] &&
                     $name != $this->_vars["search_valueVar"]
                   ) {
                    if ( is_array($value) ) {
                        $url .= $name."[]=".implode("&".$name."[]=",$value)."&";
                    } else {
                        $url .= $name."=".urlencode(stripslashes($value))."&";
                    }
                }
            }
        }

        return $url;
    }
}
?>
