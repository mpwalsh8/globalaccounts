<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
/**
 *
 * $Id$
 *
 * (c) 2008 by Mike Walsh
 *
 * @author Mike Walsh <mike_walsh@mentor.com>
 * @package Wp-GlobalAccounts
 * @subpackage OrgCharts
 * @version $Revision$
 * @lastmodified $Author$
 * @lastmodifiedby $Date$
 *
 */

define("TAB_BY_NAME", "By Name") ;
define("TAB_BY_USERNAME", "By Username") ;
define("TAB_BY_LOCATION", "By Location") ;
define("TAB_SELECTED", "div_selected") ;

require_once("orgchart.class.php") ;
require_once("forms.class.php") ;
//require_once("orgchart.class.php") ;

/**
 * Construct the Add Global Parent form
 *
 * @author Mike Walsh <mike_walsh@mentor.com>
 * @access public
 * @see GlobalAccountsForm
 */
class GlobalAccountsOrgChartQueryForm extends GlobalAccountsForm
{
    /**
     * active tab property - used to remember the active tab
     */
    var $__activetab ;

    /**
     * query headers property - used to track the query headers
     */
    var $__queryheaders ;

    /**
     * query results property - used to track the query results
     */
    var $__queryresults ;

    /**
     * Set the Active Tab
     *
     * @param mixed - active tab
     */
    function setActiveTab($activetab)
    {
        $this->__activetab = $activetab ;
    }

    /**
     * Get the Active Tab
     *
     * @return mixed - active tab
     */
    function getActiveTab()
    {
        return $this->__activetab ;
    }

    /**
     * Set the Query Headers
     *
     * @param mixed - query headers
     */
    function setQueryHeaders($queryheaders)
    {
        $this->__queryheaders = $queryheaders ;
    }

    /**
     * Get the QueryHeaders
     *
     * @return mixed - query headers
     */
    function getQueryHeaders()
    {
        return $this->__queryheaders ;
    }

    /**
     * Set the Query Results
     *
     * @param mixed - query results
     */
    function setQueryResults($queryresults)
    {
        $this->__queryresults = $queryresults ;
    }

    /**
     * Get the Query Results
     *
     * @return mixed - query results
     */
    function getQueryResults()
    {
        return $this->__queryresults ;
    }

    /**
     * This method gets called EVERY time the object is
     * created.  It is used to build all of the 
     * FormElement objects used in this Form.
     *
     */
    function form_init_elements()
    {
        //  This is used to remember the action
        //  which originated from the GUIDataList.
 
        $this->add_hidden_element("_action") ;

        //  This hidden element is used to capture
        //  the name of the Tab which was active when
        //  the end user submitted the form.  The name,
        //  TAB_SELECTED, is hard coded in the library.

        $this->add_hidden_element(TAB_SELECTED) ;

        //  First Name field
        $firstName = new FEText("First Name", false, "200px");
        $this->add_element($firstName) ;
		
        //  Last Name field

        $lastName = new FEText("Last Name", false, "200px");
        $this->add_element($lastName) ;
		
        //  Operator

        $this->add_element( new FEListBox("Operator", false,
            "100px", NULL, array("And" => "and", "Or" => "or")) );

        //  Username field
        $username = new FEText("Username", false, "200px");
        $this->add_element($username) ;

        //  Location field
        $location = new FEText("Location", false, "200px");
        $this->add_element($location) ;
        //
        //  dn Override field

        $dnOverride = new FEText("dn Override", false, "200px");
        $this->add_element($dnOverride) ;
		
        //  filter Override field

        $filterOverride = new FEText("filter Override", false, "200px");
        $this->add_element($filterOverride) ;
 
        //  filter Override field

        $this->add_element( new FEListBox("Traverse Hierarchy Levels", false,
            "50px", NULL, array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10))) ;
    }

    /**
     * This method is called only the first time the form
     * page is hit.  This enables u to query a DB and 
     * pre populate the FormElement objects with data.
     *
     */
    function form_init_data()
    {
        //  Initialize the form fields

        $this->set_hidden_element_value("_action", WPGA_ACTION_LDAP_QUERY) ;
    }

    /**
     * This method is called by the StandardFormContent object
     * to allow you to build the 'blocks' of fields you want to
     * display.  Each form block will live inside a fieldset tag
     * with the a title. 
     *
     * In this example we have 2 form 'blocks'.
     */
    function form_content()
    {
        $tabs = new ActiveTab('100%', '200px');

        //  Add tabs, first tab is special because it
        //  will be the active tab by default.  Since
        //  we need to know which tab is active when
        //  the form is submitted, the form element used
        //  to remember it is initialized using the tab's
        //  method.

	    $tabs->add_tab(TAB_BY_NAME, $this->_name_info()) ;

        $this->set_hidden_element_value(TAB_SELECTED, $tabs->name(TAB_BY_NAME)) ;

        $tabs->add_tab(TAB_BY_USERNAME, $this->_username_info()) ;
        $tabs->add_tab(TAB_BY_LOCATION, $this->_location_info()) ;
	    //$tabs->add_tab("Optional Info", $this->_optional_info()) ;

        //  In order to get the ActiveTab to work on a form, the
        //  Javascript must be manually added (this is a bug).

        $script = html_script() ;
        $script->add($tabs->get_javascript()) ;

        //  Add the ActiveTab widget and its Javascript to a table.

        $table = html_table($this->_width, 0, 4) ;
        $table->add_row($tabs, $script) ;

	    $this->add_form_block(null, $table) ;
    }

    /**
     * This private method builds the table that holds
     * the 'name' form fields
     *
     */
    function &_name_info()
    {
        $table = html_table($this->_width, 0, 2) ;
        $table->add_row(html_br(), html_br()) ;

        $table->add_row($this->element_label("First Name"), 
                        $this->element_form("First Name"));

        $table->add_row("&nbsp;", $this->element_form("Operator")) ;

        $table->add_row($this->element_label("Last Name"), 
                        $this->element_form("Last Name"));

        $td = html_td(null, null,
            div_font8bold("Use the * character for wild card searches")) ;
        $td->set_tag_attributes(array("align" => "center", "colspan" => "2")) ;
        $table->add_row($td) ;

        $table->add_row(html_br(), html_br()) ;
        $table->add_row($this->element_label("Traverse Hierarchy Levels"), 
                        $this->element_form("Traverse Hierarchy Levels"));

        return $table;
    }

    /**
     * This private method builds the table that holds
     * the 'username' form fields'
     *
     */
    function &_username_info()
    {
        $table = html_table($this->_width, 0, 2) ;
        $table->add_row(html_br(), html_br()) ;
        $table->add_row($this->element_label("Username"), 
                        $this->element_form("Username"));

        $td = html_td(null, null,
            div_font8bold("Use the * character for wild card searches")) ;
        $td->set_tag_attributes(array("align" => "center", "colspan" => "2")) ;
        $table->add_row($td) ;

        $table->add_row(html_br(), html_br()) ;
        $table->add_row($this->element_label("Traverse Hierarchy Levels"), 
                        $this->element_form("Traverse Hierarchy Levels"));

        return $table;
    }

    /**
     * This private method builds the table that holds
     * the 'user' form fields'
     *
     */
    function &_location_info()
    {
        $table = html_table($this->_width, 0, 2) ;
        $table->add_row(html_br(), html_br()) ;
        $table->add_row($this->element_label("Location"), 
                        $this->element_form("Location"));

        $td = html_td(null, null,
            div_font8bold("Use the * character for wild card searches")) ;
        $td->set_tag_attributes(array("align" => "center", "colspan" => "2")) ;
        $table->add_row($td) ;

        $table->add_row(html_br(), html_br()) ;
        $table->add_row($this->element_label("Traverse Hierarchy Levels"), 
                        $this->element_form("Traverse Hierarchy Levels"));

        return $table;
    }

    /**
     * This private method builds the table that holds
     * the 'optional' form fields'
     *
     */
    function &_optional_info()
    {
        $table = &html_table($this->_width, 0, 2) ;

        $table->add_row(html_br(), html_br()) ;

        $table->add_row($this->element_label("dn Override"), 
                        $this->element_form("dn Override"));

        $table->add_row($this->element_label("filter Override"), 
                        $this->element_form("filter Override"));

        return $table;
    }

    /**
     * This method gets called after the FormElement data has
     * passed the validation.  This enables you to validate the
     * data against some backend mechanism, say a DB.
     *
     */
    function form_backend_validation()
    {
        $valid = false ;

        //  What to validate?  Depends on which tab
        //  was active when the form was submitted.

        $tabs = new ActiveTab('100%', '200px');
        $tbn = $tabs->name(TAB_BY_NAME) ;
        $tbu = $tabs->name(TAB_BY_USERNAME) ;
        $tbl = $tabs->name(TAB_BY_LOCATION) ;
        unset($tabs) ;

        switch ($this->get_hidden_element_value(TAB_SELECTED))
        {
            case $tbn:
                $valid = $this->_form_backend_validation_by_name() ;
                break ;

            case $tbu:
                $valid = $this->_form_backend_validation_by_username() ;
                break ;

            case $tbl:
                $valid = $this->_form_backend_validation_by_location() ;
                break ;

            default:
                die($this->get_hidden_element_value(TAB_SELECTED)) ;
                break ;
        }

	    return $valid ;
    }

    /**
     * Validate a query by name request
     *
     * @return boolean
     */
    function _form_backend_validation_by_name()
    {
        $fn = $this->get_element_value("First Name") ;
        $ln = $this->get_element_value("Last Name") ;

        //  Make sure user asked to search for something otherwise
        //  the volume of data requested will be enormous.

        if (empty($fn) && empty($ln))
        {
            $this->add_error("Error", "First Name and Last Name cannot both be empty.");
            return false ;
        }

        return true ;
    }

    /**
     * Validate a query by username request
     *
     * @return boolean
     */
    function _form_backend_validation_by_username()
    {
        $un = $this->get_element_value("Username") ;

        //  Make sure user asked to search for something otherwise
        //  the volume of data requested will be enormous.

        if (empty($un))
        {
            $this->add_error("Error", "Userame cannot be empty.");
            return false ;
        }

        return true ;
    }

    /**
     * Validate a query by location request
     *
     * @return boolean
     */
    function _form_backend_validation_by_location()
    {
        $loc = $this->get_element_value("Location") ;

        //  Make sure user asked to search for something otherwise
        //  the volume of data requested will be enormous.

        if (empty($loc))
        {
            $this->add_error("Error", "Location cannot be empty.");
            return false ;
        }

        return true ;
    }

    /**
     * This method is called ONLY after ALL validation has
     * passed.  This is the method that allows you to 
     * do something with the data, say insert/update records
     * in the DB.
     */
    function form_action()
    {
        $valid = false ;

        //  What to act on?  Depends on which tab
        //  was active when the form was submitted.

        $tabs = new ActiveTab('100%', '200px');
        $tbn = $tabs->name(TAB_BY_NAME) ;
        $tbu = $tabs->name(TAB_BY_USERNAME) ;
        $tbl = $tabs->name(TAB_BY_LOCATION) ;
        unset($tabs) ;

        //  Remember the selected tab
        $this->setActiveTab($this->get_hidden_element_value(TAB_SELECTED)) ;

        switch ($this->getActiveTab())
        {
            case $tbn:
                $valid = $this->_form_action_by_name() ;
                break ;

            case $tbu:
                $valid = $this->_form_action_by_username() ;
                break ;

            case $tbl:
                $valid = $this->_form_action_by_location() ;
                break ;

            default:
                die($this->get_hidden_element_value(TAB_SELECTED)) ;
                break ;
        }

	    return $valid ;
    }

    /**
     * This method is called ONLY after ALL validation has
     * passed.  This is the method that allows you to 
     * do something with the data, say insert/update records
     * in the DB.
     */
    function _form_action_by_name()
    {
        $this->set_action_message("Name Search Successful") ;

        $fn = $this->get_element_value("First Name") ;
        $ln = $this->get_element_value("Last Name") ;
        $op = $this->get_element_value("Operator") ;

        //  Build and run the LDAP query

        $ldapQuery = new LDAPQueryByName($fn, $ln, $op) ;
               
        $ldapQuery->runQuery() ;

        $queryResults = $ldapQuery->getQueryResults() ;

        //  The intial query results need to be cleaned up because
        //  the LDAP data is returned with nested arrays.

        for ($i = 0 ; $i < count($queryResults) ; $i++)
        {
            foreach ($queryResults[$i] as $key => $value)
            {
                if (is_array($value))
                    $queryResults[$i][$key] = $value[0] ;
            }
        }

        $queryHeaders = $ldapQuery->getQueryHeaders() ;

        //  Cache the query results in session storage

        //$session = new Toolbox_Session() ;
        //$session->writeSession(TOOLBOX_LDAP_QUERY_RESULTS,
        //    array($queryHeaders, $queryResults)) ;

        $this->setQueryHeaders($queryHeaders) ;
        $this->setQueryResults($queryResults) ;

        return true ;
    }

    /**
     * This method is called ONLY after ALL validation has
     * passed.  This is the method that allows you to 
     * do something with the data, say insert/update records
     * in the DB.
     */
    function _form_action_by_username()
    {
        $this->set_action_message("Username Search Successful") ;

        $un = $this->get_element_value("Username") ;

        //  Build and run the LDAP query

        $ldapQuery = new LDAPQueryByUsername($un) ;

        $ldapQuery->runQuery() ;

        $queryResults = $ldapQuery->getQueryResults() ;

        //  The intial query results need to be cleaned up because
        //  the LDAP data is returned with nested arrays.

        for ($i = 0 ; $i < count($queryResults) ; $i++)
        {
            foreach ($queryResults[$i] as $key => $value)
            {
                if (is_array($value))
                    $queryResults[$i][$key] = $value[0] ;
            }
        }

        $queryHeaders = $ldapQuery->getQueryHeaders() ;

        //  Cache the query results in session storage

        //$session = new Toolbox_Session() ;
        //$session->writeSession(TOOLBOX_LDAP_QUERY_RESULTS,
        //    array($queryHeaders, $queryResults)) ;

        $this->setQueryHeaders($queryHeaders) ;
        $this->setQueryResults($queryResults) ;

        return TRUE ;
    }

    /**
     * This method is called ONLY after ALL validation has
     * passed.  This is the method that allows you to 
     * do something with the data, say insert/update records
     * in the DB.
     */
    function _form_action_by_location()
    {
        $this->set_action_message("Location Search Successful") ;

        $loc = $this->get_element_value("Location") ;

        //  Build and run the LDAP query

        $ldapQuery = new LDAPQueryByLocation($loc) ;

        $ldapQuery->runQuery() ;

        $queryResults = $ldapQuery->getQueryResults() ;

        //  The intial query results need to be cleaned up because
        //  the LDAP data is returned with nested arrays.

        for ($i = 0 ; $i < count($queryResults) ; $i++)
        {
            foreach ($queryResults[$i] as $key => $value)
            {
                if (is_array($value))
                    $queryResults[$i][$key] = $value[0] ;
            }
        }

        $queryHeaders = $ldapQuery->getQueryHeaders() ;

        //  Cache the query results in session storage

        //$session = new Toolbox_Session() ;
        //$session->writeSession(TOOLBOX_LDAP_QUERY_RESULTS,
        //    array($queryHeaders, $queryResults)) ;

        $this->setQueryHeaders($queryHeaders) ;
        $this->setQueryResults($queryResults) ;

        return true ;
    }

    /**
     * Build the form success message.
     *
     */
    function form_success()
    {
        $container = container() ;
        $container->add(html_h4($this->_action_message)) ;

        return $container ;
    }

    /**
     * Overload form_content_buttons() method to have the
     * button display "Search" instead of the default "Save".
     *
     */
    function form_content_buttons()
    {
        return $this->form_content_buttons_Search_Cancel() ;
    }
}
?>
