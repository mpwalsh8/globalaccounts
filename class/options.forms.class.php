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
 * (c) 2008 by Mike Walsh
 *
 * @author Mike Walsh <mike_walsh@mentor.com>
 * @package GlobalAccounts
 * @subpackage Options
 * @version $Revision$
 * @lastmodified $Author$
 * @lastmodifiedby $Date$
 *
 */

require_once("options.class.php") ;
require_once("forms.class.php") ;

/**
 * Construct the Add Age Group form
 *
 * @author Mike Walsh <mike_walsh@mentor.com>
 * @access public
 * @see GlobalAccountsForm
 */
class GlobalAccountsOptionsForm extends GlobalAccountsForm
{
    /**
     * This method gets called EVERY time the object is
     * created.  It is used to build all of the 
     * FormElement objects used in this Form.
     *
     */
    function form_init_elements()
    {
        $geography = new FEListBox("Geography", true, "150px");
        $geography->set_list_data(array(
             ucwords(WPGA_US_ONLY) => WPGA_US_ONLY
            ,ucwords(WPGA_EU_ONLY) => WPGA_EU_ONLY
            ,ucwords(WPGA_INTERNATIONAL) => WPGA_INTERNATIONAL
        )) ;
        $this->add_element($geography) ;

        $stateorprovincelabel = new FEText("State or Province Label", true, "200px");
        $this->add_element($stateorprovincelabel) ;

        $postalcodelabel = new FEText("Postal Code Label", true, "200px");
        $this->add_element($postalcodelabel) ;

        $googlemapsapikey = new FETextArea("Google API Key", false, 3, 60, "300px") ;
        $this->add_element($googlemapsapikey) ;

        $user_option1 = new FEListBox("User Option #1", true, "100px");
        $user_option1->set_list_data(array(
             ucfirst(WPGA_REQUIRED) => WPGA_REQUIRED
            ,ucfirst(WPGA_OPTIONAL) => WPGA_OPTIONAL
            ,ucfirst(WPGA_DISABLED) => WPGA_DISABLED
        )) ;
        $this->add_element($user_option1) ;

        $user_option1_label = new FEText("User Option #1 Label", true, "200px");
        $this->add_element($user_option1_label) ;

        $user_option2 = new FEListBox("User Option #2", true, "100px");
        $user_option2->set_list_data(array(
             ucfirst(WPGA_REQUIRED) => WPGA_REQUIRED
            ,ucfirst(WPGA_OPTIONAL) => WPGA_OPTIONAL
            ,ucfirst(WPGA_DISABLED) => WPGA_DISABLED
        )) ;
        $this->add_element($user_option2) ;

        $user_option2_label = new FEText("User Option #2 Label", true, "200px");
        $this->add_element($user_option2_label) ;

        $user_option3 = new FEListBox("User Option #3", true, "100px");
        $user_option3->set_list_data(array(
             ucfirst(WPGA_REQUIRED) => WPGA_REQUIRED
            ,ucfirst(WPGA_OPTIONAL) => WPGA_OPTIONAL
            ,ucfirst(WPGA_DISABLED) => WPGA_DISABLED
        )) ;
        $this->add_element($user_option3) ;

        $user_option3_label = new FEText("User Option #3 Label", true, "200px");
        $this->add_element($user_option3_label) ;

        $user_option4 = new FEListBox("User Option #4", true, "100px");
        $user_option4->set_list_data(array(
             ucfirst(WPGA_REQUIRED) => WPGA_REQUIRED
            ,ucfirst(WPGA_OPTIONAL) => WPGA_OPTIONAL
            ,ucfirst(WPGA_DISABLED) => WPGA_DISABLED
        )) ;
        $this->add_element($user_option4) ;

        $user_option4_label = new FEText("User Option #4 Label", true, "200px");
        $this->add_element($user_option4_label) ;

        $user_option5 = new FEListBox("User Option #5", true, "100px");
        $user_option5->set_list_data(array(
             ucfirst(WPGA_REQUIRED) => WPGA_REQUIRED
            ,ucfirst(WPGA_OPTIONAL) => WPGA_OPTIONAL
            ,ucfirst(WPGA_DISABLED) => WPGA_DISABLED
        )) ;
        $this->add_element($user_option5) ;

        $user_option5_label = new FEText("User Option #5 Label", true, "200px");
        $this->add_element($user_option5_label) ;
    }

    /**
     * This method is called only the first time the form
     * page is hit.  This enables u to query a DB and 
     * pre populate the FormElement objects with data.
     *
     */
    function form_init_data()
    {
        $options = new GlobalAccountsOptions() ;
        $options->loadOptions() ;

        //  Initialize the form fields
        $this->set_element_value("Geography", $options->getGeography()) ;
        $this->set_element_value("State or Province Label", $options->getStateOrProvinceLabel()) ;
        $this->set_element_value("Postal Code Label", $options->getPostalCodeLabel()) ;
        $this->set_element_value("Google API Key", $options->getGoogleAPIKey()) ;
        $this->set_element_value("User Option #1", $options->getUserOption1()) ;
        $this->set_element_value("User Option #1 Label", $options->getUserOption1Label()) ;
        $this->set_element_value("User Option #2", $options->getUserOption2()) ;
        $this->set_element_value("User Option #2 Label", $options->getUserOption2Label()) ;
        $this->set_element_value("User Option #3", $options->getUserOption3()) ;
        $this->set_element_value("User Option #3 Label", $options->getUserOption3Label()) ;
        $this->set_element_value("User Option #4", $options->getUserOption4()) ;
        $this->set_element_value("User Option #4 Label", $options->getUserOption4Label()) ;
        $this->set_element_value("User Option #5", $options->getUserOption5()) ;
        $this->set_element_value("User Option #5 Label", $options->getUserOption5Label()) ;
    }


    /**
     * This is the method that builds the layout of where the
     * FormElements will live.  You can lay it out any way
     * you like.
     *
     */
    function form_content()
    {
        $this->add_form_block("General Options", $this->_general_options()) ;
        $this->add_form_block("User Profile Options", $this->_user_profile_options()) ;
    }

    /**
     * This is the method that builds the layout of
     * the Global Accounts plugin options.
     *
     */
    function &_general_options()
    {
        $table = html_table($this->_width, 0, 4) ;
        //$table->set_style("border: 1px solid") ;

        $table->add_row($this->element_label("Geography"),
            $this->element_form("Geography")) ;

        $table->add_row($this->element_label("State or Province Label"),
            $this->element_form("State or Province Label")) ;

        $table->add_row($this->element_label("Postal Code Label"),
            $this->element_form("Postal Code Label")) ;

        $table->add_row($this->element_label("Google API Key"),
            $this->element_form("Google API Key")) ;

        return $table ;
    }

    /**
     * This is the method that builds the layout of
     * the Global Accounts plugin options.
     *
     */
    function &_user_profile_options()
    {
        $table = html_table($this->_width, 0, 4) ;

        $table->add_row($this->element_label("User Option #1 Label"),
            $this->element_form("User Option #1 Label"),
            $this->element_form("User Option #1")) ;

        $table->add_row($this->element_label("User Option #2 Label"),
            $this->element_form("User Option #2 Label"),
            $this->element_form("User Option #2")) ;

        $table->add_row($this->element_label("User Option #3 Label"),
            $this->element_form("User Option #3 Label"),
            $this->element_form("User Option #3")) ;

        $table->add_row($this->element_label("User Option #4 Label"),
            $this->element_form("User Option #4 Label"),
            $this->element_form("User Option #4")) ;

        $table->add_row($this->element_label("User Option #5 Label"),
            $this->element_form("User Option #5 Label"),
            $this->element_form("User Option #5")) ;

        return $table ;
    }

    /**
     * This method gets called after the FormElement data has
     * passed the validation.  This enables you to validate the
     * data against some backend mechanism, say a DB.
     *
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
        $options = new GlobalAccountsOptions() ;
        $options->setGeography($this->get_element_value("Geography")) ;
        $options->setStateOrProvinceLabel($this->get_element_value("State or Province Label")) ;
        $options->setPostalCodeLabel($this->get_element_value("Postal Code Label")) ;
        $options->setGoogleAPIKey($this->get_element_value("Google API Key")) ;
        $options->setUserOption1($this->get_element_value("User Option #1")) ;
        $options->setUserOption1Label($this->get_element_value("User Option #1 Label")) ;
        $options->setUserOption2($this->get_element_value("User Option #2")) ;
        $options->setUserOption2Label($this->get_element_value("User Option #2 Label")) ;
        $options->setUserOption3($this->get_element_value("User Option #3")) ;
        $options->setUserOption3Label($this->get_element_value("User Option #3 Label")) ;
        $options->setUserOption4($this->get_element_value("User Option #4")) ;
        $options->setUserOption4Label($this->get_element_value("User Option #4 Label")) ;
        $options->setUserOption5($this->get_element_value("User Option #5")) ;
        $options->setUserOption5Label($this->get_element_value("User Option #5 Label")) ;
        $options->updateOptions() ;

        return true ;
    }

    function form_success()
    {
        $container = container() ;
        $container->add(html_h3("Global Accounts options updated.")) ;

        return $container ;
    }
}
?>
