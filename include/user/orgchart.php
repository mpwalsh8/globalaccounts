<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
/**
 * Csutomers page content.
 *
 * $Id$
 *
 * (c) 2008 by Mike Walsh
 *
 * @author Mike Walsh <mike_walsh@mentor.com>
 * @package Global Accounts
 * @subpackage OrgChart
 * @version $Revision$
 * @lastmodified $Date$
 * @lastmodifiedby $Author$
 *
 */

function whereami($line = __LINE__, $file = __FILE__)
{
    printf("<h4>Where am I?  %s::%s</h4>", basename($file), $line) ;
}

//require_once("orgchart.class.php") ;
require_once("orgchart.forms.class.php") ;

/**
 * Class definition of the Org Chart Tab
 *
 * @author Mike Walsh <mike_walsh@mentor.com>
 * @access public
 * @see Container
 */
class OrgChartTabContainer extends Container
{
    /**
     * query results property
     */
    var $__queryresults ;

    /**
     * query headers property
     */
    var $__queryheaders ;

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
     * Save Query to session
     *
     */
    function saveLDAPQuery()
    {
        //$session = new GlobalAccountsSession() ;

        //$session->writeSession(WPGA_LDAP_QUERY_RESULTS,
        //    array($this->__queryheaders, $this->__queryresults)) ;

        global $userdata ;
        get_currentuserinfo() ;

        update_user_option($userdata->ID, WPGA_LDAP_QUERY_RESULTS,
            array($this->__queryheaders, $this->__queryresults)) ;
    }

    /**
     * Load Query from session
     *
     */
    function loadLDAPQuery()
    {
        global $userdata ;
        get_currentuserinfo() ;

        list($this->__queryheaders, $this->__queryresults) =
            get_user_option(WPGA_LDAP_QUERY_RESULTS, $userdata->ID) ;
    }

    /**
     * Load Query from session
     *
     */
    function flushLDAPQuery()
    {
        //$session = new GlobalAccountsSession() ;

        //$session->purgeSession(WPGA_LDAP_QUERY_RESULTS) ;

        global $userdata ;
        get_currentuserinfo() ;

        update_user_option($userdata->ID, WPGA_LDAP_QUERY_RESULTS, array()) ;
    }

    /**
     * Build verbage to explain what can be done
     *
     * @return DIVTag
     */
    function __buildGuidance()
    {
        $div = html_div("guidance") ;

        $ul = html_ul() ;
        $ul->add(html_li(html_b(__(WPGA_ACTION_PROFILE)),
            __(":  Display a Mentor user's profile.  Show the detailed
            information as it is stored in Mentor's LDAP directory."))) ;
        $ul->add(html_li(html_b(__(WPGA_ACTION_EXPORT_CSV)),
            __(":  Export org chart information in CSV format.  The exported
            data can be imported into Org Plus or Microsoft Excel."))) ;
        $ul->add(html_li(html_b(__(WPGA_ACTION_EXPORT_XML)),
            __(":  Export org chart information in Org Plus XML format.  The
            exported data can be imported into Org Plus."))) ;

        $ul->set_tag_attribute("style", "text-align: left;") ;
        $div->add($ul) ;

        return html_div_center($div) ;
    }

    
    /**
     * Build the GUI DataList used to display the roster
     *
     * @return GUIDataList
     */
    function __buildGDL()
    {
        $gdl = new LDAPQueryDataList("Search Results", "95%",
            LDAP_UNIQUE_FIELD, false, $this->getQueryHeaders(),
            $this->getQueryResults()) ;

        $gdl->set_records($this->getQueryResults()) ;

        $gdl->set_alternating_row_colors(true) ;

        return $gdl ;
    }

    /**
     * Construct the content of the OrgChart Tab Container
     */
    function OrgChartTabContainer()
    {
        //  The container content is either a GUIDataList of 
        //  the jobs which have been defined OR form processor
        //  content to add, delete, or update jobs.  Wbich type
        //  of content the container holds is dependent on how
        //  the page was reached.
 
        $div = html_div() ;
        $div->add(html_h2("Mentor Graphics Organizational Tools"), html_br()) ;

        //  This allows passing arguments eithers as a GET or a POST

        $scriptargs = array_merge($_GET, $_POST) ;
        //$scriptargs = $_POST ;

        //  The username is the argument which must be
        //  dealt with differently for GET and POST operations

        if (array_key_exists(WPGA_DB_PREFIX . "radio", $scriptargs))
            $username = $scriptargs[WPGA_DB_PREFIX . "radio"][0] ;
        else if (array_key_exists("username", $scriptargs))
            $username = $scriptargs["username"] ;
        else
            $username = null ;

        //  So, how did we get here?  If $_POST is empty
        //  then it wasn't via a form submission.

        //  Show the list of swimmers or process an action.  If
        //  there is no $_POST or if there isn't an action
        //  specififed, then simply display the GDL.

            //whereami(__LINE__) ;
            //var_dump($scriptargs, $username) ;
        if (array_key_exists("_action", $scriptargs))
            $action = $scriptargs['_action'] ;
        else if (array_key_exists("_form_action", $scriptargs))
            $action = $scriptargs['_form_action'] ;
        else if (!is_null($username))
            $action = WPGA_ACTION_PROFILE ;
        else
            //$action = null ;
            $action = WPGA_ACTION_LDAP_QUERY ;


        if (empty($scriptargs) || is_null($action))
        {
            //whereami(__LINE__) ;
            //var_dump($scriptargs) ;
            //var_dump($action) ;
            //  Either need to show the intial form or the results
            //  of a successful search in a GUIDataList.  Which to
            //  show depends on the action.  If there are no script
            //  args and no action, show the initial form.

            if (empty($scriptargs))
            {
                $this->flushLDAPQuery() ;

                $form = new GlobalAccountsOrgChartQueryForm("Organizational Query",
                    $_SERVER['HTTP_REFERER'], 600) ;
                $fp = new FormProcessor($form) ;
                $fp->set_form_action($_SERVER['PHP_SELF'] .
                    "?" . $_SERVER['QUERY_STRING']) ;

                //  Don't display the form again

                $fp->set_render_form_after_success(false) ;

                $div->add($fp) ;
            }
            else
            {
                //whereami(__LINE__) ;
                $this->loadLDAPQuery() ;

                $gdl = $this->__buildGDL() ;

                $div->add($gdl, html_br(2), $this->__buildGuidance()) ;
            }
        }
        else  //  Crank up the form processing process
        {
                //whereami(__LINE__) ;
            switch ($action)
            {
                case WPGA_ACTION_LDAP_QUERY:
                //whereami(__LINE__) ;
                    $form = new GlobalAccountsOrgChartQueryForm("Organizational Query",
                        $_SERVER['HTTP_REFERER'], 600) ;
                    break ;


                case WPGA_ACTION_PROFILE:
                //whereami(__LINE__) ;
                    $c = container() ;
                    $lqr = new LDAPQueryByUsername($username) ;
                    $lqr->setQueryAttributes(array_keys($lqr->getAllAttributes())) ;
                    $lqr->runQuery() ;

                    //var_dump($lqr->getQueryResult()) ;
                    $profile = new LDAPQueryProfile($lqr->getQueryResult(),
                        "Mentor Employee Profile", "700px") ;
                    $c->add($profile) ;

                    break ;

                case WPGA_ACTION_EXPORT_XML:
                //whereami(__LINE__) ;
                    $c = container() ;
                    $if = html_iframe(sprintf("%s/include/user/exportOrgPlusXML.php?username=%s", WPGA_PLUGIN_URL, $username)) ;
                    $if->set_tag_attributes(array("width" => 0, "height" => 0)) ;
                    $c->add($if) ;

                    $c->add(html_h4("Org Chart exported in XML format.")) ;
                    break ;

                case WPGA_ACTION_EXPORT_CSV:
                //whereami(__LINE__) ;
                    $c = container() ;
                    $if = html_iframe(sprintf("%s/include/user/exportOrgPlusCSV.php?username=%s", WPGA_PLUGIN_URL, $username)) ;
                    $if->set_tag_attributes(array("width" => 600, "height" => 600)) ;
                    //$if->set_tag_attributes(array("width" => 0, "height" => 0)) ;
                    $c->add($if) ;

                    $c->add(html_h4("Org Chart exported in CSV format.")) ;
                    break ;

                default:
                    $div->add(html_h4(sprintf("Unsupported action \"%s\" requested.", $action))) ;
                    break ;
            }

            //  Not all actions are form based ...

            if (isset($form))
            {
                //  Create the form processor

                $fp = new FormProcessor($form) ;
                $fp->set_form_action($_SERVER['PHP_SELF'] .
                    "?" . $_SERVER['QUERY_STRING']) ;

                //  Display the form again even if processing was successful.

                $fp->set_render_form_after_success(false) ;

                //  If the Form Processor was succesful, display
                //  some statistics about the uploaded file.

                if ($fp->is_action_successful())
                {
                    //  Need to show a different GDL based on whether or
                    //  not the end user has a level of Admin ability.

                    $this->setQueryHeaders($form->getQueryHeaders()) ;
                    $this->setQueryResults($form->getQueryResults()) ;
                    $this->saveLDAPQuery() ;
                    
                    $gdl = $this->__buildGDL() ;

                    $div->add($gdl, html_br(2), $this->__buildGuidance()) ;

	                $div->add(html_br(2), $form->form_success()) ;
                }
                else
                {
	                $div->add($fp) ;
                }
            }
            else if (isset($c))
            {
                $div->add(html_br(2), $c) ;
                $div->add(GlobalAccountsGUIBackHomeButtons::getButtons()) ;
            }
            else
            {
                $div->add(html_br(2), html_h4("No content to display.")) ;
            }
        }

        $this->add($div) ;
    }
}

/**
 * Class definition of the swim clubs
 *
 * @author Mike Walsh <mike_walsh@mentor.com>
 * @access public
 * @see Container
 */
class AdminOrgChartTabContainer extends OrgChartTabContainer
{
}

