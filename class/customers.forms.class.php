<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
/**
 *
 * $Id$
 *
 * Plugin initialization.  This code will ensure that the
 * include_path is correct for phpHtmlLib, PEAR, and the local
 * site class and include files.
 *
 * (c) 2007 by Mike Walsh
 *
 * @author Mike Walsh <mike_walsh@mentor.com>
 * @package Wp-GlobalAccounts
 * @subpackage Customers
 * @version $Revision$
 * @lastmodified $Author$
 * @lastmodifiedby $Date$
 *
 */

require_once("forms.class.php") ;
require_once("customers.class.php") ;
require_once("globalparents.class.php") ;

/**
 * Construct the Add Customer form
 *
 * @author Mike Walsh <mike_walsh@mentor.com>
 * @access public
 * @see GlobalAccountsForm
 */
class GlobalAccountsCustomerAddForm extends GlobalAccountsForm
{
    /**
     * customer id property - used to track the customer record
     */

    var $__customerid ;

    /**
     * Set the Customer Id property
     */
    function setCustomerId($customerid)
    {
        $this->__customerid = $customerid ;
    }

    /**
     * Get the Id property
     */
    function getCustomerId()
    {
        return $this->__customerid ;
    }

    /**
     * This method gets called EVERY time the object is
     * created.  It is used to build all of the 
     * FormElement objects used in this Form.
     *
     */
    function form_init_elements()
    {
        //  If the class constructing the form is for
        //  the delete operation, the fields are displayed
        //  but are set in the disabled state.
        $disabled_field = (strtoupper(get_class($this))
            == strtoupper("GlobalAccountsCustomerDeleteForm")) ? true : false ;

        $this->add_hidden_element("customerid") ;

        //  This is used to remember the action
        //  which originated from the GUIDataList.
 
        $this->add_hidden_element("_action") ;

        //  Global Parent Field
        $gp = new FEGlobalAccountsGlobalParents("Global Parent", !$disabled_field, "200px");
        //$gp->set_list_data(GlobalParentListArray()) ;
        $gp->set_disabled($disabled_field) ;
        $this->add_element($gp);
		
        //  Customer Name Field
        $cn = new FEText("Customer Name", !$disabled_field, "250px");
        $cn->set_disabled($disabled_field) ;
        $this->add_element($cn);
		
        //  Web Site Field
        $ws = new FEUrl("Web Site", !$disabled_field, "200px");
        $ws->set_disabled($disabled_field) ;

        $this->add_element($ws) ;
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

        $this->set_hidden_element_value("_action", WPGA_ACTION_ADD) ;
    }


    /**
     * This is the method that builds the layout of where the
     * FormElements will live.  You can lay it out any way
     * you like.
     *
     */
    function form_content()
    {
        $table = html_table($this->_width,0,4) ;
        $table->set_style("border: 1px solid") ;

        $table->add_row($this->element_label("Global Parent"),
            $this->element_form("Global Parent")) ;

        $table->add_row($this->element_label("Customer Name"),
            $this->element_form("Customer Name")) ;

        $table->add_row($this->element_label("Web Site"),
            $this->element_form("Web Site")) ;

        $this->add_form_block(null, $table) ;
    }

    /**
     * This method gets called after the FormElement data has
     * passed the validation.  This enables you to validate the
     * data against some backend mechanism, say a DB.
     *
     */
    function form_backend_validation()
    {
        $valid = true ;

        //  Need to validate several fields ...

        //  Make sure position is unique

        $customer = new GlobalAccountsCustomer() ;
        $customer->setCustomerId($this->get_hidden_element_value("customerid")) ;
        $customer->setGlobalParentId($this->get_element_value("Global Parent")) ;
        $customer->setCustomerName($this->get_element_value("Customer Name")) ;
        $customer->setWebSite($this->get_element_value("Web Site")) ;

        //  Make sure the customer isn't in use - need to handle
        //  updates to existing customers so decision isn't simple.

        if ($customer->customerExist())
        {
            $qr = $customer->getQueryResult() ;

            if (is_null($customer->getCustomerId()) || ($customer->getCustomerId() != $qr["customerid"]))
            {
                $this->add_error("Global Parent", "Customer already exists.");
                $this->add_error("Customer Name", "Customer already exists.");
                $this->add_error("Web Site", "Customer already exists.");
                $valid = false ;
            }
        }

	    return $valid ;
    }

    /**
     * This method is called ONLY after ALL validation has
     * passed.  This is the method that allows you to 
     * do something with the data, say insert/update records
     * in the DB.
     */
    function form_action()
    {
        $customer = new GlobalAccountsCustomer() ;
        $customer->setGlobalParentId($this->get_element_value("Global Parent")) ;
        $customer->setCustomerName($this->get_element_value("Customer Name")) ;
        $customer->setWebSite($this->get_element_value("Web Site")) ;

        $success = $customer->addCustomer() ;

        //  If successful, store the added customer id in so it can be used later.

        if ($success) 
        {
            $customer->setCustomerId($success) ;
            $this->set_action_message("Customer successfully added.") ;
        }
        else
        {
            $this->set_action_message("Customer was not successfully added.") ;
        }

        return $success ;
    }

    function form_success()
    {
        $container = container() ;
        $container->add(html_h4($this->_action_message)) ;

        return $container ;
    }
}

/**
 * Construct the Update Customer form
 *
 * @author Mike Walsh <mike_walsh@mentor.com>
 * @access public
 * @see GlobalAccountsCustomerAddForm
 */
class GlobalAccountsCustomerUpdateForm extends GlobalAccountsCustomerAddForm
{
    /**
     * This method is called only the first time the form
     * page is hit.  This enables u to query a DB and 
     * pre populate the FormElement objects with data.
     *
     */
    function form_init_data()
    {
        $this->set_hidden_element_value("_action", WPGA_ACTION_UPDATE) ;

        $customer = new GlobalAccountsCustomer() ;
        $customer->loadCustomerById($this->getCustomerId()) ;

        //  Initialize the form fields
        $this->set_hidden_element_value("customerid", $this->getCustomerId()) ;
        $this->set_element_value("Global Parent", $customer->getGlobalParentId()) ;
        $this->set_element_value("Customer Name", $customer->getCustomerName()) ;
        $this->set_element_value("Web Site", $customer->getWebSite()) ;
    }

    /**
     * This method is called ONLY after ALL validation has
     * passed.  This is the method that allows you to 
     * do something with the data, say insert/update records
     * in the DB.
     */
    function form_action()
    {
        $customer = new GlobalAccountsCustomer() ;
        $customer->setCustomerId($this->get_hidden_element_value("customerid")) ;
        $customer->setGlobalParentId($this->get_element_value("Global Parent")) ;
        $customer->setCustomerName($this->get_element_value("Customer Name")) ;
        $customer->setWebSite($this->get_element_value("Web Site")) ;

        $success = $customer->updateCustomer() ;

        //  If successful, store the added customer id in so it can be used later.

        if ($success) 
        {
            $customer->setCustomerId($success) ;
            $this->set_action_message("Customer successfully updated.") ;
        }
        else
        {
            $this->set_action_message("Customer was not successfully updated.") ;
        }

        return $success ;
    }

    /**
     * Construct a container with a success message
     * which can be displayed after form processing
     * is complete.
     *
     * @return Container
     */
    function form_success()
    {
        $container = container() ;
        $container->add(html_h4("Customer updated.")) ;

        return $container ;
    }
}

/**
 * Construct the Update Customer form
 *
 * @author Mike Walsh <mike_walsh@mentor.com>
 * @access public
 * @see GlobalAccountsCustomerUpdateForm
 */
class GlobalAccountsCustomerDeleteForm extends GlobalAccountsCustomerUpdateForm
{
    /**
     * This method is called only the first time the form
     * page is hit.  This enables u to query a DB and 
     * pre populate the FormElement objects with data.
     *
     */
    function form_init_data()
    {
        $this->set_hidden_element_value("_action", WPGA_ACTION_DELETE) ;

        $customer = new GlobalAccountsCustomer() ;
        $customer->loadCustomerById($this->getCustomerId()) ;

        //  Initialize the form fields
        $this->set_hidden_element_value("customerid", $this->getCustomerId()) ;
        $this->set_element_value("Global Parent", $customer->getGlobalParent()) ;
        $this->set_element_value("Customer Name", $customer->getCustomerName()) ;
        $this->set_element_value("Web Site", $customer->getWebSite()) ;
    }

    /**
     * Validate the form elements.  In this case, there is
     * no need to validate anything because it is a delete
     * operation and the form elements are disabled and
     * not passed to the form processor.
     *
     * @return boolean
     */
    function form_backend_validation()
    {
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
        $customer = new GlobalAccountsCustomer() ;
        $customer->setCustomerId($this->get_hidden_element_value("customerid")) ;
        $success = $customer->deleteCustomer() ;

        if ($success) 
            $this->set_action_message("Customer successfully deleted.") ;
        else
            $this->set_action_message("Customer was not successfully deleted.") ;

        return $success ;
    }

    /**
     * Construct a container with a success message
     * which can be displayed after form processing
     * is complete.
     *
     * @return Container
     */
    function form_success()
    {
        $container = container() ;
        $container->add(html_h4("Customer deleted.")) ;

        return $container ;
    }
    
    /**
     * Overload form_content_buttons() method to have the
     * button display "Delete" instead of the default "Save".
     *
     */
    function form_content_buttons()
    {
        return $this->form_content_buttons_Delete_Cancel() ;
    }
}
?>
