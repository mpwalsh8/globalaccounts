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
 * @subpackage MGCDivisions
 * @version $Revision$
 * @lastmodified $Author$
 * @lastmodifiedby $Date$
 *
 */

require_once("forms.class.php") ;
require_once("mgcdivisions.class.php") ;

/**
 * Construct the Add MGC Division form
 *
 * @author Mike Walsh <mike_walsh@mentor.com>
 * @access public
 * @see GlobalAccountsForm
 */
class GlobalAccountsMGCDivisionAddForm extends GlobalAccountsForm
{
    /**
     * mgcdivision id property - used to track the mgcdivision record
     */

    var $__mgcdivisionid ;

    /**
     * Set the MGC Division Id property
     */
    function setMGCDivisionId($mgcdivisionid)
    {
        $this->__mgcdivisionid = $mgcdivisionid ;
    }

    /**
     * Get the Id property
     */
    function getMGCDivisionId()
    {
        return $this->__mgcdivisionid ;
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
            == strtoupper("GlobalAccountsMGCDivisionDeleteForm")) ? true : false ;

        $this->add_hidden_element("mgcdivisionid") ;

        //  This is used to remember the action
        //  which originated from the GUIDataList.
 
        $this->add_hidden_element("_action") ;

        //  MGC Division Short Name Field
        $dsn = new FEText("MGC Division Short Name", !$disabled_field, "100px");
        $dsn->set_disabled($disabled_field) ;
        $this->add_element($dsn);

        //  MGC Division Long Name Field
        $dln = new FEText("MGC Division Long Name", !$disabled_field, "250px");
        $dln->set_disabled($disabled_field) ;
        $this->add_element($dln);

        //  MGC Division Color Marker Field
        $dcm = new FEColorList("MGC Division Color Marker", !$disabled_field, "250px");
        $dcm->set_disabled($disabled_field) ;
        $this->add_element($dcm);
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

        $table->add_row($this->element_label("MGC Division Short Name"),
            $this->element_form("MGC Division Short Name")) ;

        $table->add_row($this->element_label("MGC Division Long Name"),
            $this->element_form("MGC Division Long Name")) ;

        $table->add_row($this->element_label("MGC Division Color Marker"),
            $this->element_form("MGC Division Color Marker")) ;

        $table->add_row(html_br(20)) ;

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

        $mgcdivision = new GlobalAccountsMGCDivision() ;
        $mgcdivision->setMGCDivisionId($this->get_hidden_element_value("mgcdivisionid")) ;
        $mgcdivision->setMGCDivisionShortName($this->get_element_value("MGC Division Short Name")) ;
        $mgcdivision->setMGCDivisionLongName($this->get_element_value("MGC Division Long Name")) ;

        //  Make sure the mgcdivision isn't in use - need to handle
        //  updates to existing mgcdivisions so decision isn't simple.

        if ($mgcdivision->mgcdivisionExist())
        {
            $qr = $mgcdivision->getQueryResult() ;

            if (is_null($mgcdivision->getMGCDivisionId()) || ($mgcdivision->getMGCDivisionId() != $qr["mgcdivisionid"]))
            {
                $this->add_error("MGC Division Short Name", "MGC Division already exists.");
                $this->add_error("MGC Division Long Name", "MGC Division already exists.");
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
        $mgcdivision = new GlobalAccountsMGCDivision() ;
        $mgcdivision->setMGCDivisionShortName($this->get_element_value("MGC Division Short Name")) ;
        $mgcdivision->setMGCDivisionLongName($this->get_element_value("MGC Division Long Name")) ;

        $success = $mgcdivision->addMGCDivision() ;

        //  If successful, store the added mgcdivision id in so it can be used later.

        if ($success) 
        {
            $mgcdivision->setMGCDivisionId($success) ;
            $this->set_action_message("MGC Division successfully added.") ;
        }
        else
        {
            $this->set_action_message("MGC Division was not successfully added.") ;
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
 * Construct the Update MGC Division form
 *
 * @author Mike Walsh <mike_walsh@mentor.com>
 * @access public
 * @see GlobalAccountsMGCDivisionAddForm
 */
class GlobalAccountsMGCDivisionUpdateForm extends GlobalAccountsMGCDivisionAddForm
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

        $mgcdivision = new GlobalAccountsMGCDivision() ;
        $mgcdivision->loadMGCDivisionById($this->getMGCDivisionId()) ;

        //  Initialize the form fields
        $this->set_hidden_element_value("mgcdivisionid", $this->getMGCDivisionId()) ;
        $this->set_element_value("MGC Division Short Name", $mgcdivision->getMGCDivisionShortName()) ;
        $this->set_element_value("MGC Division Long Name", $mgcdivision->getMGCDivisionLongName()) ;
    }

    /**
     * This method is called ONLY after ALL validation has
     * passed.  This is the method that allows you to 
     * do something with the data, say insert/update records
     * in the DB.
     */
    function form_action()
    {
        $mgcdivision = new GlobalAccountsMGCDivision() ;
        $mgcdivision->setMGCDivisionId($this->get_hidden_element_value("mgcdivisionid")) ;
        $mgcdivision->setMGCDivisionShortName($this->get_element_value("MGC Division Short Name")) ;
        $mgcdivision->setMGCDivisionLongName($this->get_element_value("MGC Division Long Name")) ;

        $success = $mgcdivision->updateMGCDivision() ;

        //  If successful, store the added mgcdivision id in so it can be used later.

        if ($success) 
        {
            $mgcdivision->setMGCDivisionId($success) ;
            $this->set_action_message("MGC Division successfully updated.") ;
        }
        else
        {
            $this->set_action_message("MGC Division was not successfully updated.") ;
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
        $container->add(html_h4("MGC Division updated.")) ;

        return $container ;
    }
}

/**
 * Construct the Update MGC Division form
 *
 * @author Mike Walsh <mike_walsh@mentor.com>
 * @access public
 * @see GlobalAccountsMGCDivisionUpdateForm
 */
class GlobalAccountsMGCDivisionDeleteForm extends GlobalAccountsMGCDivisionUpdateForm
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

        $mgcdivision = new GlobalAccountsMGCDivision() ;
        $mgcdivision->loadMGCDivisionById($this->getMGCDivisionId()) ;

        //  Initialize the form fields
        $this->set_hidden_element_value("mgcdivisionid", $this->getMGCDivisionId()) ;
        $this->set_element_value("MGC Division Short Name", $mgcdivision->getMGCDivisionShortName()) ;
        $this->set_element_value("MGC Division Long Name", $mgcdivision->getMGCDivisionLongName()) ;
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
        $mgcdivision = new GlobalAccountsMGCDivision() ;
        $mgcdivision->setMGCDivisionId($this->get_hidden_element_value("mgcdivisionid")) ;
        $success = $mgcdivision->deleteMGCDivision() ;

        if ($success) 
            $this->set_action_message("MGC Division successfully deleted.") ;
        else
            $this->set_action_message("MGC Division was not successfully deleted.") ;

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
        $container->add(html_h4("MGC Division deleted.")) ;

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
