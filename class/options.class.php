<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
/**
 * Options classes.
 *
 * $Id$
 *
 * (c) 2007 by Mike Walsh
 *
 * @author Mike Walsh <mike_walsh@mentor.com>
 * @package GlobalAccounts
 * @subpackage Options
 * @version $Revision$
 * @lastmodified $Date$
 * @lastmodifiedby $Author$
 *
 */

require_once("db.class.php") ;
require_once("globalaccounts.include.php") ;

/**
 * Class definition of the agegroups
 *
 * @author Mike Walsh <mike_walsh@mentor.com>
 * @access public
 * @see GlobalAccountsDBI
 */
class GlobalAccountsOptions extends GlobalAccountsDBI
{
    /**
     * usonly property - international or US only
     */
    var $__usonly ;

    /**
     * geography property
     */
    var $__geography ;

    /**
     * user state or province label property
     */
    var $__user_stateorprovince_label ;

    /**
     * user postal code label property
     */
    var $__user_postalcode_label ;

    /**
     * google api key property
     */
    var $__google_api_key ;

    /**
     * user option field #1 property
     */
    var $__user_option1 ;

    /**
     * user option field #1 label property
     */
    var $__user_option1_label ;

    /**
     * user option field #2 property
     */
    var $__user_option2 ;

    /**
     * user option field #2 label property
     */
    var $__user_option2_label ;

    /**
     * user option field #3 property
     */
    var $__user_option3 ;

    /**
     * user option field #3 label property
     */
    var $__user_option3_label ;

    /**
     * user option field #4 property
     */
    var $__user_option4 ;

    /**
     * user option field #4 label property
     */
    var $__user_option4_label ;

    /**
     * user option field #5 property
     */
    var $__user_option5 ;

    /**
     * user option field #5 label property
     */
    var $__user_option5_label ;

    /**
     * Set the usonly property - true or false
     *
     * @param - boolean - true for US only configuration
     */
    function setUSOnly($usonly = true)
    {
        $this->__usonly = $usonly ;
    }

    /**
     * Get the usonly property - true or false
     *
     * @return - string - true for US only configuration
     */
    function getUSOnly()
    {
        return ($this->__usonly) ;
    }

    /**
     * Set the state or province label
     *
     * @param - string - state or province label
     */
    function setStateOrProvinceLabel($label)
    {
        $this->__stateorprovince_label = $label ;
    }

    /**
     * Get the state or province label
     *
     * @return - string - state or province label
     */
    function getStateOrProvinceLabel()
    {
        return ($this->__stateorprovince_label) ;
    }

    /**
     * Set the postal code label
     *
     * @param - string - postal code label
     */
    function setPostalCodeLabel($label)
    {
        $this->__postalcode_label = $label ;
    }

    /**
     * Get the postal code label
     *
     * @return - string - postal code label
     */
    function getPostalCodeLabel()
    {
        return ($this->__postalcode_label) ;
    }

    /**
     * Set the geography
     *
     * @param - string - geography
     */
    function setGeography($geography)
    {
        $this->__geography = $geography ;
    }

    /**
     * Get the geography units
     *
     * @return - string - geography units
     */
    function getGeography()
    {
        return ($this->__geography) ;
    }

    /**
     * Set the google api key
     *
     * @param - string - google api key
     */
    function setGoogleAPIKey($key)
    {
        $this->__google_api_key = $key ;
    }

    /**
     * Get the google api key
     *
     * @return - string - google api key
     */
    function getGoogleAPIKey()
    {
        return ($this->__google_api_key) ;
    }

    /**
     * Set the user option #1
     *
     * @param - boolean - true to enable
     */
    function setUserOption1($enable = true)
    {
        $this->__user_option1 = $enable ;
    }

    /**
     * Get the user option #1
     *
     * @return - string - postal code label
     */
    function getUserOption1()
    {
        return ($this->__user_option1) ;
    }

    /**
     * Set the user option #1 label
     *
     * @param - string - user option field #1 label
     */
    function setUserOption1Label($label)
    {
        $this->__user_option1_label = $label ;
    }

    /**
     * Get the user option #1 label
     *
     * @return - string - postal code label
     */
    function getUserOption1Label()
    {
        return ($this->__user_option1_label) ;
    }

    /**
     * Set the user option #2
     *
     * @param - boolean - true to enable
     */
    function setUserOption2($enable = true)
    {
        $this->__user_option2 = $enable ;
    }

    /**
     * Get the user option #2
     *
     * @return - string - postal code label
     */
    function getUserOption2()
    {
        return ($this->__user_option2) ;
    }

    /**
     * Set the user option #2 label
     *
     * @param - string - user option field #2 label
     */
    function setUserOption2Label($label)
    {
        $this->__user_option2_label = $label ;
    }

    /**
     * Get the user option #2 label
     *
     * @return - string - postal code label
     */
    function getUserOption2Label()
    {
        return ($this->__user_option2_label) ;
    }

    /**
     * Set the user option #3
     *
     * @param - boolean - true to enable
     */
    function setUserOption3($enable = true)
    {
        $this->__user_option3 = $enable ;
    }

    /**
     * Get the user option #3
     *
     * @return - string - postal code label
     */
    function getUserOption3()
    {
        return ($this->__user_option3) ;
    }

    /**
     * Set the user option #3 label
     *
     * @param - string - user option field #3 label
     */
    function setUserOption3Label($label)
    {
        $this->__user_option3_label = $label ;
    }

    /**
     * Get the user option #3 label
     *
     * @return - string - postal code label
     */
    function getUserOption3Label()
    {
        return ($this->__user_option3_label) ;
    }

    /**
     * Set the user option #4
     *
     * @param - boolean - true to enable
     */
    function setUserOption4($enable = true)
    {
        $this->__user_option4 = $enable ;
    }

    /**
     * Get the user option #4
     *
     * @return - string - postal code label
     */
    function getUserOption4()
    {
        return ($this->__user_option4) ;
    }

    /**
     * Set the user option #4 label
     *
     * @param - string - user option field #4 label
     */
    function setUserOption4Label($label)
    {
        $this->__user_option4_label = $label ;
    }

    /**
     * Get the user option #4 label
     *
     * @return - string - postal code label
     */
    function getUserOption4Label()
    {
        return ($this->__user_option4_label) ;
    }

    /**
     * Set the user option #5
     *
     * @param - boolean - true to enable
     */
    function setUserOption5($enable = true)
    {
        $this->__user_option5 = $enable ;
    }

    /**
     * Get the user option #5
     *
     * @return - string - postal code label
     */
    function getUserOption5()
    {
        return ($this->__user_option5) ;
    }

    /**
     * Set the user option #5 label
     *
     * @param - string - user option field #5 label
     */
    function setUserOption5Label($label)
    {
        $this->__user_option5_label = $label ;
    }

    /**
     * Get the user option #5 label
     *
     * @return - string - postal code label
     */
    function getUserOption5Label()
    {
        return ($this->__user_option5_label) ;
    }

    /**
     * load Options
     *
     * Load the option values from the Wordpress database.
     * If for some reason, the option doesn't exist, use the
     * default value.
     *
     */
    function loadOptions()
    {
        //  geography
        $option = get_option(WPGA_OPTION_GEOGRAPHY) ;

        //  If option isn't stored in the database, use the default
        if ($option)
        {
            $this->setGeography($option) ;
        }
        else
        {
            $this->setGeography(WPGA_DEFAULT_GEOGRAPHY) ;
            update_option(WPGA_OPTION_GEOGRAPHY, WPGA_DEFAULT_GEOGRAPHY) ;
        }

        //  postal code label
        $option = get_option(WPGA_OPTION_USER_POSTAL_CODE_LABEL) ;

        //  If option isn't stored in the database, use the default
        if ($option)
        {
            $this->setPostalCodeLabel($option) ;
        }
        else
        {
            $this->setPostalCodeLabel(WPGA_DEFAULT_POSTAL_CODE_LABEL) ;
            update_option(WPGA_OPTION_USER_POSTAL_CODE_LABEL, WPGA_DEFAULT_POSTAL_CODE_LABEL) ;
        }

        //  state or province label
        $option = get_option(WPGA_OPTION_USER_STATE_OR_PROVINCE_LABEL) ;

        //  If option isn't stored in the database, use the default
        if ($option)
        {
            $this->setStateOrProvinceLabel($option) ;
        }
        else
        {
            $this->setStateOrProvinceLabel(WPGA_DEFAULT_STATE_OR_PROVINCE_LABEL) ;
            update_option(WPGA_OPTION_USER_STATE_OR_PROVINCE_LABEL, WPGA_DEFAULT_STATE_OR_PROVINCE_LABEL) ;
        }

        //  google api key
        $option = get_option(WPGA_OPTION_GOOGLE_API_KEY) ;

        //  If option isn't stored in the database, use the default
        if ($option)
        {
            $this->setGoogleAPIKey($option) ;
        }
        else
        {
            $this->setGoogleAPIKey(WPGA_NULL_STRING) ;
            update_option(WPGA_GOOGLE_API_KEY, WPGA_NULL_STRING) ;
        }

        //  user option1
        $option = get_option(WPGA_OPTION_USER_OPTION1) ;

        //  If option isn't stored in the database, use the default
        if ($option)
        {
            $this->setUserOption1($option) ;
        }
        else
        {
            $this->setUserOption1(WPGA_DEFAULT_USER_OPTION1) ;
            update_option(WPGA_OPTION_USER_OPTION1, WPGA_DEFAULT_USER_OPTION1) ;
        }

        //  user option2
        $option = get_option(WPGA_OPTION_USER_OPTION2) ;

        //  If option isn't stored in the database, use the default
        if ($option)
        {
            $this->setUserOption2($option) ;
        }
        else
        {
            $this->setUserOption2(WPGA_DEFAULT_USER_OPTION2) ;
            update_option(WPGA_OPTION_USER_OPTION2, WPGA_DEFAULT_USER_OPTION2) ;
        }

        //  user option3
        $option = get_option(WPGA_OPTION_USER_OPTION3) ;

        //  If option isn't stored in the database, use the default
        if ($option)
        {
            $this->setUserOption3($option) ;
        }
        else
        {
            $this->setUserOption3(WPGA_DEFAULT_USER_OPTION3) ;
            update_option(WPGA_OPTION_USER_OPTION3, WPGA_DEFAULT_USER_OPTION3) ;
        }

        //  user option4
        $option = get_option(WPGA_OPTION_USER_OPTION4) ;

        //  If option isn't stored in the database, use the default
        if ($option)
        {
            $this->setUserOption4($option) ;
        }
        else
        {
            $this->setUserOption4(WPGA_DEFAULT_USER_OPTION4) ;
            update_option(WPGA_OPTION_USER_OPTION4, WPGA_DEFAULT_USER_OPTION4) ;
        }

        //  user option5
        $option = get_option(WPGA_OPTION_USER_OPTION5) ;

        //  If option isn't stored in the database, use the default
        if ($option)
        {
            $this->setUserOption5($option) ;
        }
        else
        {
            $this->setUserOption5(WPGA_DEFAULT_USER_OPTION5) ;
            update_option(WPGA_OPTION_USER_OPTION5, WPGA_DEFAULT_USER_OPTION5) ;
        }

        //  user option1 label
        $option = get_option(WPGA_OPTION_USER_OPTION1_LABEL) ;

        //  If option isn't stored in the database, use the default
        if ($option)
        {
            $this->setUserOption1Label($option) ;
        }
        else
        {
            $this->setUserOption1Label(WPGA_DEFAULT_USER_OPTION1_LABEL) ;
            update_option(WPGA_OPTION_USER_OPTION1_LABEL, WPGA_DEFAULT_USER_OPTION1_LABEL) ;
        }

        //  user option2 label
        $option = get_option(WPGA_OPTION_USER_OPTION2_LABEL) ;

        //  If option isn't stored in the database, use the default
        if ($option)
        {
            $this->setUserOption2Label($option) ;
        }
        else
        {
            $this->setUserOption2Label(WPGA_DEFAULT_USER_OPTION2_LABEL) ;
            update_option(WPGA_OPTION_USER_OPTION2_LABEL, WPGA_DEFAULT_USER_OPTION2_LABEL) ;
        }

        //  user option3 label
        $option = get_option(WPGA_OPTION_USER_OPTION3_LABEL) ;

        //  If option isn't stored in the database, use the default
        if ($option)
        {
            $this->setUserOption3Label($option) ;
        }
        else
        {
            $this->setUserOption3Label(WPGA_DEFAULT_USER_OPTION3_LABEL) ;
            update_option(WPGA_OPTION_USER_OPTION3_LABEL, WPGA_DEFAULT_USER_OPTION3_LABEL) ;
        }

        //  user option4 label
        $option = get_option(WPGA_OPTION_USER_OPTION4_LABEL) ;

        //  If option isn't stored in the database, use the default
        if ($option)
        {
            $this->setUserOption4Label($option) ;
        }
        else
        {
            $this->setUserOption4Label(WPGA_DEFAULT_USER_OPTION4_LABEL) ;
            update_option(WPGA_OPTION_USER_OPTION4_LABEL, WPGA_DEFAULT_USER_OPTION4_LABEL) ;
        }

        //  user option5 label
        $option = get_option(WPGA_OPTION_USER_OPTION5_LABEL) ;

        //  If option isn't stored in the database, use the default
        if ($option)
        {
            $this->setUserOption5Label($option) ;
        }
        else
        {
            $this->setUserOption5Label(WPGA_DEFAULT_USER_OPTION5_LABEL) ;
            update_option(WPGA_OPTION_USER_OPTION5_LABEL, WPGA_DEFAULT_USER_OPTION5_LABEL) ;
        }
    }

    /**
     * update (save) Options
     *
     * Write the options to the Worpress database
     */
    function updateOptions()
    {
        update_option(WPGA_OPTION_GEOGRAPHY, $this->getGeography()) ;
        update_option(WPGA_OPTION_USER_STATE_OR_PROVINCE_LABEL, $this->getStateOrProvinceLabel()) ;
        update_option(WPGA_OPTION_USER_POSTAL_CODE_LABEL, $this->getPostalCodeLabel()) ;
        update_option(WPGA_OPTION_GOOGLE_API_KEY, $this->getGoogleAPIKey()) ;
        update_option(WPGA_OPTION_USER_OPTION1, $this->getUserOption1()) ;
        update_option(WPGA_OPTION_USER_OPTION1_LABEL, $this->getUserOption1Label()) ;
        update_option(WPGA_OPTION_USER_OPTION2, $this->getUserOption2()) ;
        update_option(WPGA_OPTION_USER_OPTION2_LABEL, $this->getUserOption2Label()) ;
        update_option(WPGA_OPTION_USER_OPTION3, $this->getUserOption3()) ;
        update_option(WPGA_OPTION_USER_OPTION3_LABEL, $this->getUserOption3Label()) ;
        update_option(WPGA_OPTION_USER_OPTION4, $this->getUserOption4()) ;
        update_option(WPGA_OPTION_USER_OPTION4_LABEL, $this->getUserOption4Label()) ;
        update_option(WPGA_OPTION_USER_OPTION5, $this->getUserOption5()) ;
        update_option(WPGA_OPTION_USER_OPTION5_LABEL, $this->getUserOption5Label()) ;
    }
}
?>
