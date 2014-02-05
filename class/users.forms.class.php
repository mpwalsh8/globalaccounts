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
 * @author Mike Walsh <mike_walsh@mindspring.com>
 * @package -GlobalAccounts
 * @subpackage User
 * @version $Revision$
 * @lastmodified $Author$
 * @lastmodifiedby $Date$
 *
 */

require_once("users.class.php") ;
require_once("forms.class.php") ;

/**
 * Construct the User form
 *
 * @author Mike Walsh <mike_walsh@mindspring.com>
 * @access public
 * @see GlobalAccountsForm
 */
class GlobalAccountsUserForm extends GlobalAccountsForm
{
    var $__id ;

    function getId()
    {
        return $this->__id ;
    }

    function setId($id)
    {
        $this->__id = $id ;
    }

    function getUserId()
    {
        return $this->__id ;
    }

    function setUserId($id)
    {
        $this->__id = $id ;
    }

    /**
     * Get the array of results key and value pairs
     *
     * @return mixed - array of results key value pairs
     */
    function _genderSelection()
    {
        //  Build an array of labels and values
        $g = array(ucfirst(WPGA_GENDER_MALE) => WPGA_GENDER_MALE
            ,ucfirst(WPGA_GENDER_FEMALE) => WPGA_GENDER_FEMALE
            ) ;

         return $g ;
    }
    
    /**
     * Get the array of results key and value pairs
     *
     * @return mixed - array of results key value pairs
     */
    function _sizeSelection()
    {
        //  Build an array of labels and values
        $s = array(strtoupper(WPGA_SIZE_XS) => WPGA_SIZE_XS
            ,strtoupper(WPGA_SIZE_S) => WPGA_SIZE_S
            ,strtoupper(WPGA_SIZE_M) => WPGA_SIZE_M
            ,strtoupper(WPGA_SIZE_L) => WPGA_SIZE_L
            ,strtoupper(WPGA_SIZE_LT) => WPGA_SIZE_LT
            ,strtoupper(WPGA_SIZE_XL) => WPGA_SIZE_XL
            ,strtoupper(WPGA_SIZE_XLT) => WPGA_SIZE_XLT
            ,strtoupper(WPGA_SIZE_2XL) => WPGA_SIZE_2XL
            ,strtoupper(WPGA_SIZE_2XLT) => WPGA_SIZE_2XLT
            ,strtoupper(WPGA_SIZE_3XL) => WPGA_SIZE_3XL
            ,strtoupper(WPGA_SIZE_3XLT) => WPGA_SIZE_3XLT
            ,strtoupper(WPGA_SIZE_4XL) => WPGA_SIZE_4XL
            ,strtoupper(WPGA_SIZE_4XLT) => WPGA_SIZE_4XLT
            ) ;

         return $s ;
    }
    
    /**
     * This method gets called EVERY time the object is
     * created.  It is used to build all of the 
     * FormElement objects used in this Form.
     *
     */
    function form_init_elements()
    {
        $isadmin = current_user_can('manage_options') ;

        $name = new FEText("Name", !$isadmin, "200px") ;
        $name->set_disabled(true) ;
        $this->add_element($name) ;

        $this->add_hidden_element("WpUserId") ;
        $this->add_hidden_element("_action") ;

        $street1 = new FEText("Street 1", !$isadmin, "250px") ;
        $this->add_element($street1) ;
        $street2 = new FEText("Street 2", false, "250px") ;
        $this->add_element($street2) ;
        $street3 = new FEText("Street 3", false, "250px") ;
        $this->add_element($street3) ;

        $city = new FEText("City", !$isadmin, "200px") ;
        $this->add_element($city) ;

        //  How to handle the portion of the address which is
        //  much different for the US than the rest of the world.
 
        //  Check the options!
        
        $label = get_option(WPGA_OPTION_USER_STATE_OR_PROVINCE_LABEL) ;

        $geography = get_option(WPGA_OPTION_GEOGRAPHY) ;

        if ($geography == WPGA_US_ONLY)
            $state = new FEUnitedStates($label, !$isadmin, "200px") ;
        else
            $state = new FEText($label, !$isadmin, "250px") ;

        $this->add_element($state) ;

        $label = get_option(WPGA_OPTION_USER_POSTAL_CODE_LABEL) ;

        if ($geography == WPGA_US_ONLY)
            $postalcode = new FEZipcode($label, !$isadmin, "100px") ;
        else
            $postalcode = new FEText($label, !$isadmin, "200px") ;

        $this->add_element($postalcode) ;

        //  Country is handled - EU has a drop down,
        //  US is fixed and can't be changed, all others
        //  receive a text box.
 
        if ($geography == WPGA_EU_ONLY)
            $country = new FEEuropeanUnion("Country", !$isadmin, "150px") ;
        else
            $country = new FEText("Country", !$isadmin, "200px") ;

        if ($geography == WPGA_US_ONLY)
            $country->set_disabled(true) ;
        $this->add_element($country) ;

        $primaryphone = new FEText("Primary Phone", !$isadmin, "150px") ;
        $this->add_element($primaryphone) ;

        $secondaryphone = new FEText("Secondary Phone", !$isadmin, "150px") ;
        $this->add_element($secondaryphone) ;

        $gender = new FEListBox("Gender", !$isadmin, "100px") ;
        $gender->set_list_data($this->_genderSelection()) ;

        $this->add_element($gender) ;

        //  Day of Birth field
        $dob = new FEDay("Day of Birth", !$isadmin, null, null, "Fd") ;
        $this->add_element($dob) ;

        //  Handle the optional user fields, there are as many as 5
 
        //  option #1
        $option = get_option(WPGA_OPTION_USER_OPTION1) ;
        $label = get_option(WPGA_OPTION_USER_OPTION1_LABEL) ;

        if ($option == WPGA_REQUIRED)
            $this->add_element(new FEText($label, !$isadmin, "250px")) ;
        else if ($option == WPGA_OPTIONAL)
            $this->add_element(new FEText($label, false, "250px")) ;
        else
            $this->add_hidden_element($label) ;

        //  option #2
        $option = get_option(WPGA_OPTION_USER_OPTION2) ;
        $label = get_option(WPGA_OPTION_USER_OPTION2_LABEL) ;

        if ($option == WPGA_REQUIRED)
            $this->add_element(new FEText($label, !$isadmin, "250px")) ;
        else if ($option == WPGA_OPTIONAL)
            $this->add_element(new FEText($label, false, "250px")) ;
        else
            $this->add_hidden_element($label) ;

        //  option #3
        $option = get_option(WPGA_OPTION_USER_OPTION3) ;
        $label = get_option(WPGA_OPTION_USER_OPTION3_LABEL) ;

        if ($option == WPGA_REQUIRED)
            $this->add_element(new FEText($label, !$isadmin, "250px")) ;
        else if ($option == WPGA_OPTIONAL)
            $this->add_element(new FEText($label, false, "250px")) ;
        else
            $this->add_hidden_element($label) ;

        //  option #4
        $option = get_option(WPGA_OPTION_USER_OPTION4) ;
        $label = get_option(WPGA_OPTION_USER_OPTION4_LABEL) ;

        if ($option == WPGA_REQUIRED)
            $this->add_element(new FEText($label, !$isadmin, "250px")) ;
        else if ($option == WPGA_OPTIONAL)
            $this->add_element(new FEText($label, false, "250px")) ;
        else
            $this->add_hidden_element($label) ;

        //  option #5
        $option = get_option(WPGA_OPTION_USER_OPTION5) ;
        $label = get_option(WPGA_OPTION_USER_OPTION5_LABEL) ;

        if ($option == WPGA_REQUIRED)
            $this->add_element(new FEText($label, !$isadmin, "250px")) ;
        else if ($option == WPGA_OPTIONAL)
            $this->add_element(new FEText($label, false, "250px")) ;
        else
            $this->add_hidden_element($label) ;

        //  Size fields - eventually these will go on another tab
 
        $dressshirt = new FEListBox("Dress Shirt Size", !$isadmin, "75px") ;
        $dressshirt->set_list_data($this->_sizeSelection()) ;

        $this->add_element($dressshirt) ;

        $poloshirt = new FEListBox("Polo Shirt Size", !$isadmin, "75px") ;
        $poloshirt->set_list_data($this->_sizeSelection()) ;

        $this->add_element($poloshirt) ;

        $teeshirt = new FEListBox("Tee Shirt Size", !$isadmin, "75px") ;
        $teeshirt->set_list_data($this->_sizeSelection()) ;

        $this->add_element($teeshirt) ;

        $jacket = new FEListBox("Jacket Size", !$isadmin, "75px") ;
        $jacket->set_list_data($this->_sizeSelection()) ;

        $this->add_element($jacket) ;

        $sweater = new FEListBox("Sweater Size", !$isadmin, "75px") ;
        $sweater->set_list_data($this->_sizeSelection()) ;

        $this->add_element($sweater) ;
    }

    /**
     * This method is called only the first time the form
     * page is hit.  This enables u to query a DB and 
     * pre populate the FormElement objects with data.
     *
     */
    function form_init_data()
    {
        //  WP's global userdata
        //global $userdata ;

        //get_currentuserinfo() ;
        //var_dump($userdata) ;

        $userdata = get_userdata($this->getId()) ;

        //  Set the name field to what is stored in the WP profile
        $this->set_element_value("Name",
            $userdata->user_firstname . " " . $userdata->user_lastname) ;

        $geography = get_option(WPGA_OPTION_GEOGRAPHY) ;

        if ($geography == WPGA_US_ONLY)
            $this->set_element_value("Country", ucwords(WPGA_US_ONLY)) ;

        //  Need to pass the WP UserId along to the next step
        $this->set_hidden_element_value("WpUserId", $userdata->ID) ;
        $this->set_hidden_element_value("_action", WPGA_ACTION_UPDATE) ;

        $u = new GlobalAccountsUser() ;

        if ($u->userExistsByWpUserId($userdata->ID))
        {
            $u->setWpUserId($userdata->ID) ;
            $u->loadUserByWpUserId() ;

            //  Initialize the form fields
            $this->set_element_value("Street 1", $u->getStreet1()) ;
            $this->set_element_value("Street 2", $u->getStreet2()) ;
            $this->set_element_value("Street 3", $u->getStreet3()) ;
            $this->set_element_value("City", $u->getCity()) ;

            $label = get_option(WPGA_OPTION_USER_STATE_OR_PROVINCE_LABEL) ;
            $this->set_element_value($label, $u->getStateOrProvince()) ;

            $label = get_option(WPGA_OPTION_USER_POSTAL_CODE_LABEL) ;
            $this->set_element_value($label, $u->getPostalCode()) ;

            $this->set_element_value("Country", $u->getCountry()) ;

            $this->set_element_value("Primary Phone", $u->getPrimaryPhone()) ;
            $this->set_element_value("Secondary Phone", $u->getSecondaryPhone()) ;
            $this->set_element_value("Gender", $u->getGender()) ;
            $this->set_element_value("Day of Birth", $u->getBirthDay()) ;
            
            $label = get_option(WPGA_OPTION_USER_OPTION1_LABEL) ;
            if (get_option(WPGA_OPTION_USER_OPTION1) != WPGA_DISABLED)
                $this->set_element_value($label, $u->getUserOption1()) ;
            else
                $this->set_hidden_element_value($label, $u->getUserOption1()) ;

            $label = get_option(WPGA_OPTION_USER_OPTION2_LABEL) ;
            if (get_option(WPGA_OPTION_USER_OPTION2) != WPGA_DISABLED)
                $this->set_element_value($label, $u->getUserOption2()) ;
            else
                $this->set_hidden_element_value($label, $u->getUserOption2()) ;

            $label = get_option(WPGA_OPTION_USER_OPTION3_LABEL) ;
            if (get_option(WPGA_OPTION_USER_OPTION3) != WPGA_DISABLED)
                $this->set_element_value($label, $u->getUserOption3()) ;
            else
                $this->set_hidden_element_value($label, $u->getUserOption3()) ;

            $label = get_option(WPGA_OPTION_USER_OPTION4_LABEL) ;
            if (get_option(WPGA_OPTION_USER_OPTION4) != WPGA_DISABLED)
                $this->set_element_value($label, $u->getUserOption4()) ;
            else
                $this->set_hidden_element_value($label, $u->getUserOption4()) ;

            $label = get_option(WPGA_OPTION_USER_OPTION5_LABEL) ;
            if (get_option(WPGA_OPTION_USER_OPTION5) != WPGA_DISABLED)
                $this->set_element_value($label, $u->getUserOption5()) ;
            else
                $this->set_hidden_element_value($label, $u->getUserOption5()) ;

            //  Clothing sizes
            $this->set_element_value("Dress Shirt Size", $u->getDressShirtSize()) ;
            $this->set_element_value("Polo Shirt Size", $u->getPoloShirtSize()) ;
            $this->set_element_value("Tee Shirt Size", $u->getTeeShirtSize()) ;
            $this->set_element_value("Jacket Size", $u->getJacketSize()) ;
            $this->set_element_value("Sweater Size", $u->getSweaterSize()) ;
        }
        else
        {
            $this->set_element_value("Dress Shirt Size", WPGA_SIZE_L) ;
            $this->set_element_value("Polo Shirt Size", WPGA_SIZE_L) ;
            $this->set_element_value("Tee Shirt Size", WPGA_SIZE_L) ;
            $this->set_element_value("Jacket Size", WPGA_SIZE_L) ;
            $this->set_element_value("Sweater Size", WPGA_SIZE_L) ;
        }
    }

    /**
     * This is the method that builds the layout of where the
     * FormElements will live.  You can lay it out any way
     * you like.
     *
     */
    function form_content()
    {
        $this->add_form_block(html_b("Home Address"), $this->_home_address()) ;
        $this->add_form_block(html_b("Personal Details"), $this->_personal_details()) ;
    }

    /**
     * This is the method that builds the layout of where the
     * FormElements will live.  You can lay it out any way
     * you like.
     *
     */
    function &_home_address()
    {
        $table = html_table($this->_width, 0, 2) ;
        $table->set_style("border: 1px solid #30669a") ;

        $table->add_row($this->element_label("Name"),
            $this->element_form("Name")) ;

        $table->add_row($this->element_label("Street 1"),
            $this->element_form("Street 1")) ;

        $table->add_row($this->element_label("Street 2"),
            $this->element_form("Street 2")) ;

        $table->add_row($this->element_label("Street 3"),
            $this->element_form("Street 3")) ;

        $table->add_row($this->element_label("City"),
            $this->element_form("City")) ;

        $label = get_option(WPGA_OPTION_USER_STATE_OR_PROVINCE_LABEL) ;

        $table->add_row($this->element_label($label),
            $this->element_form($label)) ;

        $label = get_option(WPGA_OPTION_USER_POSTAL_CODE_LABEL) ;

        $table->add_row($this->element_label($label),
            $this->element_form($label)) ;

        $table->add_row($this->element_label("Country"),
            $this->element_form("Country")) ;

        $table->add_row($this->element_label("Primary Phone"),
            $this->element_form("Primary Phone")) ;

        $table->add_row($this->element_label("Secondary Phone"),
            $this->element_form("Secondary Phone")) ;

        return $table ;
    }

    /**
     * This is the method that builds the layout of where the
     * FormElements will live.  You can lay it out any way
     * you like.
     *
     */
    function &_personal_details()
    {
        $table = html_table($this->_width, 0, 2) ;
        $table->set_style("border: 1px solid #30669a") ;

        $table->add_row($this->element_label("Gender"),
            $this->element_form("Gender")) ;

        $table->add_row($this->element_label("Day of Birth"),
            $this->element_form("Day of Birth")) ;

        //  Show optional fields if they are enabled
 
        $option = get_option(WPGA_OPTION_USER_OPTION1) ;
        $label = get_option(WPGA_OPTION_USER_OPTION1_LABEL) ;

        if ($option != WPGA_DISABLED)
            $table->add_row($this->element_label($label),
                $this->element_form($label)) ;

        $option = get_option(WPGA_OPTION_USER_OPTION2) ;
        $label = get_option(WPGA_OPTION_USER_OPTION2_LABEL) ;

        if ($option != WPGA_DISABLED)
            $table->add_row($this->element_label($label),
                $this->element_form($label)) ;

        $option = get_option(WPGA_OPTION_USER_OPTION3) ;
        $label = get_option(WPGA_OPTION_USER_OPTION3_LABEL) ;

        if ($option != WPGA_DISABLED)
            $table->add_row($this->element_label($label),
                $this->element_form($label)) ;

        $option = get_option(WPGA_OPTION_USER_OPTION4) ;
        $label = get_option(WPGA_OPTION_USER_OPTION4_LABEL) ;

        if ($option != WPGA_DISABLED)
            $table->add_row($this->element_label($label),
                $this->element_form($label)) ;

        $option = get_option(WPGA_OPTION_USER_OPTION5) ;
        $label = get_option(WPGA_OPTION_USER_OPTION5_LABEL) ;

        if ($option != WPGA_DISABLED)
            $table->add_row($this->element_label($label),
                $this->element_form($label)) ;

        $table->add_row($this->element_label("Dress Shirt Size"),
            $this->element_form("Dress Shirt Size")) ;

        $table->add_row($this->element_label("Polo Shirt Size"),
            $this->element_form("Polo Shirt Size")) ;

        $table->add_row($this->element_label("Tee Shirt Size"),
            $this->element_form("Tee Shirt Size")) ;

        $table->add_row($this->element_label("Jacket Size"),
            $this->element_form("Jacket Size")) ;

        $table->add_row($this->element_label("Sweater Size"),
            $this->element_form("Sweater Size")) ;

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
        $valid = true ;

        //  Make sure phone numbers are unique

        $p = $this->get_element_value("Primary Phone") ;
        $s = $this->get_element_value("Secondary Phone") ;

        if (($p == $s) && ($p . $s != ''))
        {
            $this->add_error("Primary Phone", "Primary Phone is the same as the Secondary Phone.") ;
            $this->add_error("Secondary Phone", "Secondary Phone is the same as the Primary Phone.") ;
            $valid = false ;
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
        $u = new GlobalAccountsUser() ;
        $u->setWpUserId($this->get_hidden_element_value("WpUserId")) ;
        $u->setStreet1($this->get_element_value("Street 1")) ;
        $u->setStreet2($this->get_element_value("Street 2")) ;
        $u->setStreet3($this->get_element_value("Street 3")) ;
        $u->setCity($this->get_element_value("City")) ;

        $label = get_option(WPGA_OPTION_USER_STATE_OR_PROVINCE_LABEL) ;
        $u->setStateOrProvince($this->get_element_value($label)) ;

        $label = get_option(WPGA_OPTION_USER_POSTAL_CODE_LABEL) ;
        $u->setPostalCode($this->get_element_value($label)) ;

        $geography = get_option(WPGA_OPTION_GEOGRAPHY) ;

        if ($geography == WPGA_US_ONLY)
            $u->setCountry(ucwords(WPGA_US_ONLY)) ;
        else
            $u->setCountry($this->get_element_value("Country")) ;

        $u->setPrimaryPhone($this->get_element_value("Primary Phone")) ;
        $u->setSecondaryPhone($this->get_element_value("Secondary Phone")) ;
        $u->setGender($this->get_element_value("Gender")) ;
        $u->setBirthDay($this->get_element_value("Day of Birth")) ;

        if (get_option(WPGA_OPTION_USER_OPTION1) != WPGA_DISABLED)
        {
            $label = get_option(WPGA_OPTION_USER_OPTION1_LABEL) ;
            $u->setUserOption1($this->get_element_value($label)) ;
        }

        if (get_option(WPGA_OPTION_USER_OPTION2) != WPGA_DISABLED)
        {
            $label = get_option(WPGA_OPTION_USER_OPTION2_LABEL) ;
            $u->setUserOption2($this->get_element_value($label)) ;
        }

        if (get_option(WPGA_OPTION_USER_OPTION3) != WPGA_DISABLED)
        {
            $label = get_option(WPGA_OPTION_USER_OPTION3_LABEL) ;
            $u->setUserOption3($this->get_element_value($label)) ;
        }

        if (get_option(WPGA_OPTION_USER_OPTION4) != WPGA_DISABLED)
        {
            $label = get_option(WPGA_OPTION_USER_OPTION4_LABEL) ;
            $u->setUserOption4($this->get_element_value($label)) ;
        }

        if (get_option(WPGA_OPTION_USER_OPTION5) != WPGA_DISABLED)
        {
            $label = get_option(WPGA_OPTION_USER_OPTION5_LABEL) ;
            $u->setUserOption5($this->get_element_value($label)) ;
        }

        //  Clothing Sizes
        $u->setDressShirtSize($this->get_element_value("Dress Shirt Size")) ;
        $u->setPoloShirtSize($this->get_element_value("Polo Shirt Size")) ;
        $u->setTeeShirtSize($this->get_element_value("Tee Shirt Size")) ;
        $u->setJacketSize($this->get_element_value("Jacket Size")) ;
        $u->setSweaterSize($this->get_element_value("Sweater Size")) ;

        $u->saveUser() ;

        return true ;
    }

    function form_success()
    {
        $container = container() ;
        $container->add(html_div("updated fade", html_h4("Global Accounts profile updated."))) ;

        return $container ;
    }
}

/**
 * Construct the User form
 *
 * @author Mike Walsh <mike_walsh@mindspring.com>
 * @access public
 * @see GlobalAccountsForm
 */
class GlobalAccountsUserUpdateForm extends GlobalAccountsUserForm
{
}
?>
