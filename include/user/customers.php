<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
/**
 * Csutomers page content.
 *
 * $Id$
 *
 * (c) 2008 by Mike Walsh
 *
 * @author Mike Walsh <mike_walsh@mindspring.com>
 * @package Global Accounts
 * @subpackage Customers
 * @version $Revision$
 * @lastmodified $Date$
 * @lastmodifiedby $Author$
 *
 */

require_once("customers.class.php") ;
require_once("customers.forms.class.php") ;

/**
 * Class definition of the jobs
 *
 * @author Mike Walsh <mike_walsh@mindspring.com>
 * @access public
 * @see Container
 */
class CustomersTabContainer extends Container
{
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
            __(":  Display a customer's profile.  Show the customer
            detailed information as it will be displayed in the directory."))) ;
        $ul->add(html_li(html_b(__(WPGA_ACTION_ADD)),
            __(":  Add a customer profile."))) ;
        $ul->add(html_li(html_b(__(WPGA_ACTION_UPDATE)),
            __(":  Update a customer profile."))) ;

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
        $gdl = new GlobalAccountsCustomersGUIDataList("Customers",
            "800", "customername, globalparent", true) ;

        $gdl->set_alternating_row_colors(true) ;
        $gdl->set_show_empty_datalist_actionbar(true) ;

        return $gdl ;
    }

    /**
     * Construct the content of the Customers Tab Container
     */
    function CustomersTabContainer()
    {
        //  The container content is either a GUIDataList of 
        //  the jobs which have been defined OR form processor
        //  content to add, delete, or update jobs.  Wbich type
        //  of content the container holds is dependent on how
        //  the page was reached.
 
        $div = html_div() ;
        $div->add(html_h2("Customers"), html_br()) ;

        //  This allows passing arguments eithers as a GET or a POST

        $scriptargs = array_merge($_GET, $_POST) ;

        //  The customerid is the argument which must be
        //  dealt with differently for GET and POST operations

        if (array_key_exists(WPGA_DB_PREFIX . "radio", $scriptargs))
            $customerid = $scriptargs[WPGA_DB_PREFIX . "radio"][0] ;
        else if (array_key_exists("customerid", $scriptargs))
            $customerid = $scriptargs["customerid"] ;
        else
            $customerid = null ;

        //  So, how did we get here?  If $_POST is empty
        //  then it wasn't via a form submission.

        //  Show the list of swimmers or process an action.  If
        //  there is no $_POST or if there isn't an action
        //  specififed, then simply display the GDL.

        if (array_key_exists("_action", $scriptargs))
            $action = $scriptargs['_action'] ;
        else if (array_key_exists("_form_action", $scriptargs))
            $action = $scriptargs['_form_action'] ;
        else
            $action = null ;

        if (empty($scriptargs) || is_null($action))
        {
            $gdl = $this->__buildGDL() ;

            $div->add($gdl, html_br(2), $this->__buildGuidance()) ;
        }
        else  //  Crank up the form processing process
        {
            switch ($action)
            {
                case WPGA_ACTION_PROFILE:
                    $c = container() ;
                    $profile = new GlobalAccountsCustomerProfileInfoTable("Customer Profile", "700px") ;
                    $profile->setCustomerId($customerid) ;
                    $profile->constructCustomerProfile() ;
                    $c->add($profile) ;

                    break ;

                case WPGA_ACTION_ADD:
                    $form = new GlobalAccountsCustomerAddForm("Add Customer",
                        $_SERVER['HTTP_REFERER'], 600) ;
                    break ;

                case WPGA_ACTION_UPDATE:
                    $form = new GlobalAccountsCustomerUpdateForm("Update Customer",
                        $_SERVER['HTTP_REFERER'], 600) ;
                    $form->setCustomerId($customerid) ;
                    break ;

                case WPGA_ACTION_DELETE:
                    $form = new GlobalAccountsCustomerDeleteForm("Delete Customer",
                        $_SERVER['HTTP_REFERER'], 600) ;
                    $form->setCustomerId($customerid) ;
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
                $div->add(GUIBackHomeButtons::getButtons()) ;
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
 * @author Mike Walsh <mike_walsh@mindspring.com>
 * @access public
 * @see Container
 */
class AdminCustomersTabContainer extends CustomersTabContainer
{
    /**
     * Build the GUI DataList used to display the roster
     *
     * @return GUIDataList
     */
    function __buildGDL()
    {
        $gdl = new CustomersAdminGUIDataList("Customers",
            "95%", "customername, country", true) ;

        $gdl->set_alternating_row_colors(true) ;
        $gdl->set_show_empty_datalist_actionbar(true) ;

        return $gdl ;
    }
}

