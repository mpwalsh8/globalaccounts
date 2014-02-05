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
 * @subpackage GlobalParents
 * @version $Revision$
 * @lastmodified $Author$
 * @lastmodifiedby $Date$
 *
 */

require_once("forms.class.php") ;
require_once("globalparents.class.php") ;

/**
 * Construct the Add Global Parent form
 *
 * @author Mike Walsh <mike_walsh@mentor.com>
 * @access public
 * @see GlobalAccountsForm
 */
class GlobalAccountsGlobalParentAddForm extends GlobalAccountsForm
{
    /**
     * globalparent id property - used to track the globalparent record
     */

    var $__globalparentid ;

    /**
     * Set the Global Parent Id property
     */
    function setGlobalParentId($globalparentid)
    {
        $this->__globalparentid = $globalparentid ;
    }

    /**
     * Get the Id property
     */
    function getGlobalParentId()
    {
        return $this->__globalparentid ;
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
            == strtoupper("GlobalAccountsGlobalParentDeleteForm")) ? true : false ;

        $this->add_hidden_element("globalparentid") ;

        //  This is used to remember the action
        //  which originated from the GUIDataList.
 
        $this->add_hidden_element("_action") ;

        //  Global Parent Name Field
        $cn = new FEText("Global Parent Name", !$disabled_field, "250px");
        $cn->set_disabled($disabled_field) ;
        $this->add_element($cn);
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

        $table->add_row($this->element_label("Global Parent Name"),
            $this->element_form("Global Parent Name")) ;

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

        $globalparent = new GlobalAccountsGlobalParent() ;
        $globalparent->setGlobalParentId($this->get_hidden_element_value("globalparentid")) ;
        $globalparent->setGlobalParentName($this->get_element_value("Global Parent Name")) ;

        //  Make sure the globalparent isn't in use - need to handle
        //  updates to existing globalparents so decision isn't simple.

        if ($globalparent->globalparentExist())
        {
            $qr = $globalparent->getQueryResult() ;

            if (is_null($globalparent->getGlobalParentId()) || ($globalparent->getGlobalParentId() != $qr["globalparentid"]))
            {
                $this->add_error("Global Parent Name", "Global Parent already exists.");
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
        $globalparent = new GlobalAccountsGlobalParent() ;
        $globalparent->setGlobalParentName($this->get_element_value("Global Parent Name")) ;

        $success = $globalparent->addGlobalParent() ;

        //  If successful, store the added globalparent id in so it can be used later.

        if ($success) 
        {
            $globalparent->setGlobalParentId($success) ;
            $this->set_action_message("Global Parent successfully added.") ;
        }
        else
        {
            $this->set_action_message("Global Parent was not successfully added.") ;
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
 * Construct the Update Global Parent form
 *
 * @author Mike Walsh <mike_walsh@mentor.com>
 * @access public
 * @see GlobalAccountsGlobalParentAddForm
 */
class GlobalAccountsGlobalParentUpdateForm extends GlobalAccountsGlobalParentAddForm
{
    /**
     * This method is called only the first time the form
     * page is hit.  This enables u to query a DB and 
     * pre populate the FormElement objects with data.
     *
     */
    function form_init_data()
    {
        $globalparent = new GlobalAccountsGlobalParent() ;
        $globalparent->loadGlobalParentById($this->getGlobalParentId()) ;

        //  Initialize the form fields
        $this->set_hidden_element_value("globalparentid", $this->getGlobalParentId()) ;
        $this->set_hidden_element_value("_action", WPGA_ACTION_UPDATE) ;
        $this->set_element_value("Global Parent Name", $globalparent->getGlobalParentName()) ;
    }

    /**
     * This method is called ONLY after ALL validation has
     * passed.  This is the method that allows you to 
     * do something with the data, say insert/update records
     * in the DB.
     */
    function form_action()
    {
        $globalparent = new GlobalAccountsGlobalParent() ;
        $globalparent->setGlobalParentId($this->get_hidden_element_value("globalparentid")) ;
        $globalparent->setMaxAge($this->get_element_value("Global Parent Name")) ;

        $success = $globalparent->updateGlobalParent() ;

        //  If successful, store the added globalparent id in so it can be used later.

        if ($success) 
        {
            $globalparent->setGlobalParentId($success) ;
            $this->set_action_message("Global Parent successfully updated.") ;
        }
        else
        {
            $this->set_action_message("Global Parent was not successfully updated.") ;
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
        $container->add(html_h4("Global Parent updated.")) ;

        return $container ;
    }
}

/**
 * Construct the Update Global Parent form
 *
 * @author Mike Walsh <mike_walsh@mentor.com>
 * @access public
 * @see GlobalAccountsGlobalParentUpdateForm
 */
class GlobalAccountsGlobalParentDeleteForm extends GlobalAccountsGlobalParentUpdateForm
{
    /**
     * This method is called only the first time the form
     * page is hit.  This enables u to query a DB and 
     * pre populate the FormElement objects with data.
     *
     */
    function form_init_data()
    {
        $globalparent = new GlobalAccountsGlobalParent() ;
        $globalparent->loadGlobalParentById($this->getGlobalParentId()) ;

        //  Initialize the form fields
        $this->set_hidden_element_value("globalparentid", $this->getGlobalParentId()) ;
        $this->set_hidden_element_value("_action", WPGA_ACTION_DELETE) ;
        $this->set_element_value("Global Parent Name", $globalparent->getGlobalParentName()) ;
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
        $globalparent = new GlobalAccountsGlobalParent() ;
        $globalparent->setGlobalParentId($this->get_hidden_element_value("globalparentid")) ;
        $success = $globalparent->deleteGlobalParent() ;

        if ($success) 
            $this->set_action_message("Global Parent successfully deleted.") ;
        else
            $this->set_action_message("Global Parent was not successfully deleted.") ;

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
        $container->add(html_h4("Global Parent deleted.")) ;

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
