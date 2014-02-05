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
 * @subpackage Location
 * @version $Revision$
 * @lastmodified $Author$
 * @lastmodifiedby $Date$
 *
 */

require_once("forms.class.php") ;
require_once("customers.class.php") ;
require_once("locations.class.php") ;
require_once("mgcdivisions.class.php") ;

/**
 * Construct the Location Location Profile
 *
 * @author Mike Walsh <mike_walsh@mentor.com>
 * @access public
 * @see GlobalAccountsForm
 */
class GlobalAccountsLocationAddForm extends GlobalAccountsForm
{
    /**
     * location id property
     */
    var $__locationid ;

    /**
     * Set location id
     *
     * @param int - location id
     */
    function setLocationId($id)
    {
        $this->__locationid = $id ;
    }

    /**
     * Get location id
     *
     * @return int - location id
     */
    function getLocationId()
    {
        return $this->__locationid ;
    }

    /**
     * This method gets called EVERY time the object is
     * created.  It is used to build all of the 
     * FormElement objects used in this Form.
     *
     */
    function form_init_elements()
    {
        $this->add_hidden_element("_action") ;
        $this->add_hidden_element("locationid") ;

        $customer = new FEGlobalAccountsCustomers("Customer Name", true, "200px");
        $this->add_element($customer) ;

        $wto = new FEListBox("WTO Region", true, "200px") ;
        $wto->set_list_data(array(
            WPGA_WTO_REGION_AMERICAS => WPGA_WTO_REGION_AMERICAS
           ,WPGA_WTO_REGION_EUROPE => WPGA_WTO_REGION_EUROPE
           ,WPGA_WTO_REGION_PACRIM => WPGA_WTO_REGION_PACRIM
           ,WPGA_WTO_REGION_JAPAN => WPGA_WTO_REGION_JAPAN
        )) ;
        $this->add_element($wto) ;

        $location = new FEText("Location Name", true, "250px") ;
        $this->add_element($location) ;

        $street1 = new FEText("Street 1", false, "250px") ;
        $this->add_element($street1) ;
        $street2 = new FEText("Street 2", false, "250px") ;
        $this->add_element($street2) ;
        $street3 = new FEText("Street 3", false, "250px") ;
        $this->add_element($street3) ;

        $city = new FEText("City", true, "200px") ;
        $this->add_element($city) ;

        //  How to handle the portion of the address which is
        //  much different for the US than the rest of the world.
 
        //  Check the options!
        
        $label = get_option(WPGA_OPTION_USER_STATE_OR_PROVINCE_LABEL) ;

        $geography = get_option(WPGA_OPTION_GEOGRAPHY) ;

        if ($geography == WPGA_US_ONLY)
            $state = new FEUnitedStates($label, true, "200px") ;
        else
            $state = new FEText($label, true, "250px") ;

        $this->add_element($state) ;

        $label = get_option(WPGA_OPTION_USER_POSTAL_CODE_LABEL) ;

        if ($geography == WPGA_US_ONLY)
            $postalcode = new FEZipcode($label, true, "100px") ;
        else
            $postalcode = new FEText($label, true, "200px") ;

        $this->add_element($postalcode) ;

        //  Country is handled - EU has a drop down,
        //  US is fixed and can't be changed, all others
        //  receive a text box.
 
        if ($geography == WPGA_EU_ONLY)
            $country = new FEEuropeanUnion("Country", true, "150px") ;
        else
            $country = new FECountries("Country", true, "300px") ;

        if ($geography == WPGA_US_ONLY)
            $country->set_disabled(true) ;
        $this->add_element($country) ;

        $primaryphone = new FEText("Primary Phone", false, "150px") ;
        $this->add_element($primaryphone) ;

        $secondaryphone = new FEText("Secondary Phone", false, "150px") ;
        $this->add_element($secondaryphone) ;

        $website = new FEUrl("Web Site", false, "250px") ;
        $this->add_element($website) ;
    }

    /**
     * This method is called only the first time the form
     * page is hit.  This enables u to query a DB and 
     * pre populate the FormElement objects with data.
     *
     */
    function form_init_data()
    {
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
        $table = html_table($this->_width, 0, 4) ;

        $table->add_row($this->element_label("Customer Name"),
            $this->element_form("Customer Name")) ;

        $table->add_row($this->element_label("Location Name"),
            $this->element_form("Location Name")) ;

        $table->add_row($this->element_label("WTO Region"),
            $this->element_form("WTO Region")) ;

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

        //  Make sure phone numbers are unique

        $p = $this->get_element_value("Primary Phone") ;
        $s = $this->get_element_value("Secondary Phone") ;

        if (($p == $s) && ($p != WPGA_NULL_STRING))
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
        $l = new GlobalAccountsLocation() ;
        $l->setCustomerId($this->get_element_value("Customer Name")) ;
        $l->setLocationName($this->get_element_value("Location Name")) ;
        $l->setWTORegion($this->get_element_value("WTO Region")) ;
        $l->setStreet1($this->get_element_value("Street 1")) ;
        $l->setStreet2($this->get_element_value("Street 2")) ;
        $l->setStreet3($this->get_element_value("Street 3")) ;
        $l->setCity($this->get_element_value("City")) ;

        $label = get_option(WPGA_OPTION_USER_STATE_OR_PROVINCE_LABEL) ;
        $l->setStateOrProvince($this->get_element_value($label)) ;

        $label = get_option(WPGA_OPTION_USER_POSTAL_CODE_LABEL) ;
        $l->setPostalCode($this->get_element_value($label)) ;

        $geography = get_option(WPGA_OPTION_GEOGRAPHY) ;

        if ($geography == WPGA_US_ONLY)
            $l->setCountry(ucwords(WPGA_US_ONLY)) ;
        else
            $l->setCountry($this->get_element_value("Country")) ;

        $l->setPrimaryPhone($this->get_element_value("Primary Phone")) ;
        $l->setSecondaryPhone($this->get_element_value("Secondary Phone")) ;
        $l->setWebSite($this->get_element_value("Web Site")) ;

        return $l->addLocation() ;
    }

    /**
     * Build success container
     *
     * @return container
     */
    function form_success()
    {
        $container = container() ;
        $container->add(html_h3("Location added.")) ;

        return $container ;
    }
}

/**
 * Construct the Update Location Profile form
 *
 * @author Mike Walsh <mike_walsh@mentor.com>
 * @access public
 * @see GlobalAccountsForm
 */
class GlobalAccountsLocationUpdateForm extends GlobalAccountsLocationAddForm
{
    /**
     * This method is called only the first time the form
     * page is hit.  This enables u to query a DB and 
     * pre populate the FormElement objects with data.
     *
     */
    function form_init_data()
    {
        //  Re-use the parent form_init_data()

        parent::form_init_data() ;

        $this->set_hidden_element_value("_action", WPGA_ACTION_UPDATE) ;

        $l = new GlobalAccountsLocation() ;
        $l->loadLocationByLocationId($this->getLocationId()) ;

        $this->set_hidden_element_value("locationid", $this->getLocationId()) ;

         //  Initialize the form fields
        $this->set_element_value("Customer Name", $l->getCustomerId()) ;
        $this->set_element_value("Location Name", $l->getLocationName()) ;
        $this->set_element_value("WTO Region", $l->getWTORegion()) ;
        $this->set_element_value("Street 1", $l->getStreet1()) ;
        $this->set_element_value("Street 2", $l->getStreet2()) ;
        $this->set_element_value("Street 3", $l->getStreet3()) ;
        $this->set_element_value("City", $l->getCity()) ;

        $label = get_option(WPGA_OPTION_USER_STATE_OR_PROVINCE_LABEL) ;
        $this->set_element_value($label, $l->getStateOrProvince()) ;

        $label = get_option(WPGA_OPTION_USER_POSTAL_CODE_LABEL) ;
        $this->set_element_value($label, $l->getPostalCode()) ;

        $this->set_element_value("Country", $l->getCountry()) ;

        $this->set_element_value("Primary Phone", $l->getPrimaryPhone()) ;
        $this->set_element_value("Secondary Phone", $l->getSecondaryPhone()) ;
        $this->set_element_value("Web Site", $l->getWebSite()) ;
    }

    /**
     * This method is called ONLY after ALL validation has
     * passed.  This is the method that allows you to 
     * do something with the data, say insert/update records
     * in the DB.
     */
    function form_action()
    {
        $l = new GlobalAccountsLocation() ;
        $l->setLocationId($this->get_hidden_element_value("locationid")) ;
        $l->setCustomerId($this->get_element_value("Customer Name")) ;
        $l->setLocationName($this->get_element_value("Location Name")) ;
        $l->setWTORegion($this->get_element_value("WTO Region")) ;
        $l->setStreet1($this->get_element_value("Street 1")) ;
        $l->setStreet2($this->get_element_value("Street 2")) ;
        $l->setStreet3($this->get_element_value("Street 3")) ;
        $l->setCity($this->get_element_value("City")) ;

        $label = get_option(WPGA_OPTION_USER_STATE_OR_PROVINCE_LABEL) ;
        $l->setStateOrProvince($this->get_element_value($label)) ;

        $label = get_option(WPGA_OPTION_USER_POSTAL_CODE_LABEL) ;
        $l->setPostalCode($this->get_element_value($label)) ;

        $l->setCountry($this->get_element_value("Country")) ;
        $l->setPrimaryPhone($this->get_element_value("Primary Phone")) ;
        $l->setSecondaryPhone($this->get_element_value("Secondary Phone")) ;
        $l->setWebSite($this->get_element_value("Web Site")) ;

        $success = $l->updateLocation() ;

        if ($success) 
        {
            $l->setLocationId($success) ;
            $this->set_action_message("Location successfully updated.") ;
        }
        else
        {
            $this->set_action_message("Location was not successfully updated.") ;
        }

        return $success ;
    }
}
/**
 * Construct the Update Location Profile form
 *
 * @author Mike Walsh <mike_walsh@mentor.com>
 * @access public
 * @see GlobalAccountsForm
 */
class GlobalAccountsLocationFRPForm extends GlobalAccountsForm
{
    /**
     * location id property
     */
    var $__locationid ;

    /**
     * Set location id
     *
     * @param int - location id
     */
    function setLocationId($id)
    {
        $this->__locationid = $id ;
    }

    /**
     * Get location id
     *
     * @return int - location id
     */
    function getLocationId()
    {
        return $this->__locationid ;
    }

    /**
     * Get the array of season key and value pairs
     *
     * @return mixed - array of season key value pairs
     */
    function _getMGCDivisionsArray()
    {
        //  Division Names and Ids

        $mgcdivisions = array() ;

        $mgcdivision = new GlobalAccountsMGCDivision() ;
        $mgcdivisionIds = $mgcdivision->getMGCDivisionIds() ;

        if (!is_null($mgcdivisionIds))
        {
            foreach ($mgcdivisionIds as $mgcdivisionId)
            {
                $mgcdivision->loadMGCDivisionById($mgcdivisionId["mgcdivisionid"]) ;
                $mgcdivisions[$mgcdivision->getMGCDivisionShortName() .
                    " ( " .  $mgcdivision->getMGCDivisionLongName() .
                    " )"] = $mgcdivision->getMGCDivisionId() ;
            }
        }

        ksort($mgcdivisions) ;

        return $mgcdivisions ;
    }

    /**
     * This method gets called EVERY time the object is
     * created.  It is used to build all of the 
     * FormElement objects used in this Form.
     *
     */
    function form_init_elements()
    {
        $this->add_hidden_element("_action") ;
        $this->add_hidden_element("locationid") ;

        $divs = $this->_getMGCDivisionsArray() ;

        $f = array() ;

        foreach ($divs as $key => $div)
        {
            $f[] = new FEListBox($key, false, "200px") ;
            //$f[count($f) - 1]->set_element_name("mgcdivisionid[" . $div . "]") ;
            $f[count($f) - 1]->set_list_data(
                array(
                    WPGA_FRP_DEPLOYMENT_NONE_LABEL => WPGA_FRP_DEPLOYMENT_NONE_VALUE
                   ,WPGA_FRP_DEPLOYMENT_SMALL_LABEL => WPGA_FRP_DEPLOYMENT_SMALL_VALUE
                   ,WPGA_FRP_DEPLOYMENT_MEDIUM_LABEL => WPGA_FRP_DEPLOYMENT_MEDIUM_VALUE
                   ,WPGA_FRP_DEPLOYMENT_LARGE_LABEL => WPGA_FRP_DEPLOYMENT_LARGE_VALUE
                   ,WPGA_FRP_DEPLOYMENT_ENORMOUS_LABEL => WPGA_FRP_DEPLOYMENT_ENORMOUS_VALUE
               )) ;
            $this->add_element($f[count($f) - 1]) ;
        }
    }

    /**
     * This method is called only the first time the form
     * page is hit.  This enables u to query a DB and 
     * pre populate the FormElement objects with data.
     *
     */
    function form_init_data()
    {
        $this->set_hidden_element_value("_action", WPGA_ACTION_FRP) ;
        $this->set_hidden_element_value("locationid", $this->getLocationId()) ;

        $l = new GlobalAccountsLocationFRP() ;
        $l->loadLocationFRP($this->getLocationId()) ;

        //  Get any exisiting FRP

        $frp = $l->getLocationFRP() ;

        //  Loop through the divisions and initialize FRP
        //  fields based on what is already stored in the
        //  database (if anything).

        $divs = $this->_getMGCDivisionsArray() ;

        foreach ($divs as $key => $div)
        {
            printf("Div:  %s  Id:  %s<br>", $key, $div) ;
            if (array_key_exists($div, $frp))
                $this->set_element_value($key, $frp[$div]) ;
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
        $table = html_table($this->_width, 0, 4) ;

        $divs = $this->_getMGCDivisionsArray() ;

        foreach ($divs as $key => $div)
        {
            $table->add_row($this->element_label($key), $this->element_form($key)) ;
        }

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
        $this->setLocationId($this->get_hidden_element_value("locationid")) ;

        $divs = $this->_getMGCDivisionsArray() ;

        $frp = array() ;

        foreach ($divs as $key => $div)
            $frp[$div] = $this->get_element_value($key) ;

        $l = new GlobalAccountsLocationFRP() ;
        $l->loadLocationByLocationId($this->getLocationId()) ;
        $l->setLocationFRP($frp) ;

        return $l->updateLocationFRP() ;
    }

    /**
     * Build success container
     *
     * @return container
     */
    function form_success()
    {
        $container = container() ;
        $container->add(html_h3("Location FRP updated.")) ;

        return $container ;
    }
}
?>
