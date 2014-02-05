<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
/**
 *
 * $Id$
 *
 * Form classes.  These classes manage the
 * entry and display of the various forms used
 * by the Global Accounts plugin.
 *
 * (c) 2008 by Mike Walsh for Global Accounts.
 *
 * @author Mike Walsh <mike_walsh@mentor.com>
 * @package Wp-GlobalAccounts
 * @subpackage forms
 * @version $Revision$
 * @lastmodified $Date$
 * @lastmodifiedby $Author$
 *
 */

/**
 * Include the Form Processing objects
 *
 */
include_once(PHPHTMLLIB_ABSPATH . "/form/includes.inc") ;


/**
 * GlobalAccounts Form Base Class - extension of StandardFormContent
 *
 * @author Mike Walsh <mike_walsh@mindspirng.com>
 * @access public
 * @see StandardFormContent
 */
class GlobalAccountsSimpleForm extends FormContent
{
    /**
     * Constructor
     *
     * @param string width
     * @param cancel action
     *
     */
    function GlobalAccountsSimpleForm($width = "100%", $cancel_action = null)
    {
        //  Turn of default confirmation

        $this->set_confirm(false) ;
        
        //  Use a 'dagger' character to denote required fields.

        $this->set_required_marker('&#134;');

        //  Turn on the colons for all labels.

	    $this->set_colon_flag(true) ;

        //  Call the parent constructor

        $this->FormContent($width, $cancel_action) ;
    }
}

/**
 * GlobalAccounts Form Base Class - extension of StandardFormContent
 *
 * @author Mike Walsh <mike_walsh@mindspirng.com>
 * @access public
 * @see StandardFormContent
 */
class GlobalAccountsForm extends StandardFormContent
{
    /**
     * Provide a mechanism to overload form_content_buttons() method
     * to have the button display "Go" instead of "Save" and not
     * display the cancel button.
     *
     * @return HTMLTag object
     */
    function form_content_buttons_Go()
    {
        $div = new DIVtag(array("style" => "background-color: #eeeeee;".
            "padding-top:5px;padding-bottom:5px", "align"=>"center", "nowrap"),
            $this->add_action("Go")) ;

        return $div;
    }

    /**
     * Provide a mechanism to overload form_content_buttons() method
     * to have the button display "Filter" instead of "Save" and not
     * display the cancel button.
     *
     * @return HTMLTag object
     */
    function form_content_buttons_Filter()
    {
        $div = new DIVtag(array("style" => "background-color: #eeeeee;".
            "padding-top:5px;padding-bottom:5px", "align"=>"center", "nowrap"),
            $this->add_action("Filter")) ;

        return $div;
    }

    
    /**
     * Provide a mechanism to overload form_content_buttons() method
     * to have the button display "Ok" instead of "Save" and not
     * display the cancel button.
     *
     * @return HTMLTag object
     */
    function form_content_buttons_Ok($action = "Ok")
    {
        $div = new DIVtag(array("style" => "background-color: #eeeeee;".
            "padding-top:5px;padding-bottom:5px", "align"=>"center", "nowrap"),
            $this->add_action($action)) ;

        return $div;
    }

    /**
     * Provide a mechanism to overload form_content_buttons() method
     * to have the button display "Search" only.
     *
     * @return HTMLTag object
     */
    function form_content_buttons_Search($action = "Search")
    {
        $div = new DIVtag(array("style" => "background-color: #eeeeee;".
            "padding-top:5px;padding-bottom:5px", "align"=>"center", "nowrap"),
            $this->add_action($action)) ;

        return $div;
    }

    /**
     * Provide a mechanism to overload form_content_buttons() method
     * to have the button display "Cancel" only.
     *
     * @return HTMLTag object
     */
    function form_content_buttons_Cancel()
    {
        $div = new DIVtag(array("style" => "background-color: #eeeeee;".
            "padding-top:5px;padding-bottom:5px", "align"=>"center", "nowrap"),
            $this->add_cancel()) ;

        return $div;
    }

    /**
     * Provide a mechanism to overload form_content_buttons() method
     * to have the button display "Login" instead of "Save" and not
     * display the cancel button.
     *
     * @return HTMLTag object
     */
    function form_content_buttons_Login()
    {
        $div = new DIVtag(array("style" => "background-color: #eeeeee;".
            "padding-top:5px;padding-bottom:5px", "align"=>"center", "nowrap"),
            $this->add_action("Login")) ;

        return $div;
    }


    /**
     * Provide a mechanism to overload form_content_buttons() method
     * to have the button display "Login" instead of "Save".
     *
     * @return HTMLTag object
     */
    function form_content_buttons_Login_Cancel()
    {
        $div = new DIVtag(array("style" => "background-color: #eeeeee;".
            "padding-top:5px;padding-bottom:5px", "align"=>"center", "nowrap"),
            $this->add_action("Login"), _HTML_SPACE, $this->add_cancel()) ;

        return $div;
    }

    /**
     * Provide a mechanism to overload form_content_buttons() method
     * to have the button display "Upload" instead of "Save".
     *
     * @return HTMLTag object
     */
    function form_content_buttons_Upload_Cancel()
    {
        $div = new DIVtag(array("style" => "background-color: #eeeeee;".
            "padding-top:5px;padding-bottom:5px", "align"=>"center", "nowrap"),
            $this->add_action("Upload"), _HTML_SPACE, $this->add_cancel()) ;

        return $div;
    }

    /**
     * Provide a mechanism to overload form_content_buttons() method
     * to have the button display "Confirm" instead of "Save".
     *
     * @return HTMLTag object
     */
    function form_content_buttons_Confirm_Cancel()
    {
        $div = new DIVtag(array("style" => "background-color: #eeeeee;".
            "padding-top:5px;padding-bottom:5px", "align"=>"center", "nowrap"),
            $this->add_action("Confirm"), _HTML_SPACE, $this->add_cancel()) ;

        return $div;
    }

    /**
     * Provide a mechanism to overload form_content_buttons() method
     * to have the button display "Delete" instead of "Save".
     *
     * @return HTMLTag object
     */
    function form_content_buttons_Delete_Cancel()
    {
        $div = new DIVtag(array("style" => "background-color: #eeeeee;".
            "padding-top:5px;padding-bottom:5px", "align"=>"center", "nowrap"),
            $this->add_action("Delete"), _HTML_SPACE, $this->add_cancel()) ;

        return $div;
    }

    /**
     * Provide a mechanism to overload form_content_buttons() method
     * to have the button display "Open" instead of "Save".
     *
     * @return HTMLTag object
     */
    function form_content_buttons_Open_Cancel()
    {
        $div = new DIVtag(array("style" => "background-color: #eeeeee;".
            "padding-top:5px;padding-bottom:5px", "align"=>"center", "nowrap"),
            $this->add_action("Open"), _HTML_SPACE, $this->add_cancel()) ;

        return $div;
    }

    /**
     * Provide a mechanism to overload form_content_buttons() method
     * to have the button display "Close" instead of "Save".
     *
     * @return HTMLTag object
     */
    function form_content_buttons_Close_Cancel()
    {
        $div = new DIVtag(array("style" => "background-color: #eeeeee;".
            "padding-top:5px;padding-bottom:5px", "align"=>"center", "nowrap"),
            $this->add_action("Close"), _HTML_SPACE, $this->add_cancel()) ;

        return $div;
    }

    /**
     * Provide a mechanism to overload form_content_buttons() method
     * to have the button display "Add" instead of "Save".
     *
     * @return HTMLTag object
     */
    function form_content_buttons_Add_Cancel()
    {
        $div = new DIVtag(array("style" => "background-color: #eeeeee;".
            "padding-top:5px;padding-bottom:5px", "align"=>"center", "nowrap"),
            $this->add_action("Add"), _HTML_SPACE, $this->add_cancel()) ;

        return $div;
    }

    /**
     * Provide a mechanism to overload form_content_buttons() method
     * to have the button display "Search" instead of "Save".
     *
     * @return HTMLTag object
     */
    function form_content_buttons_Search_Cancel()
    {
        $div = new DIVtag(array("style" => "background-color: #eeeeee;".
            "padding-top:5px;padding-bottom:5px", "align"=>"center", "nowrap"),
            $this->add_action("Search"), _HTML_SPACE, $this->add_cancel()) ;

        return $div;
    }

    /**
     * Constructor
     *
     * @param string - title
     * @param string - cancel page redirect
     * @param string - width of form
     */
    function GlobalAccountsForm($title, $cancel_action = null, $width = "100%")
    {
        $this->StandardFormContent($title, $cancel_action, $width) ;

        //  Turn of default confirmation

        $this->set_confirm(false) ;
        
        //  Use a 'dagger' character to denote required fields.

        $this->set_required_marker('&#134;');

        //  Turn on the colons for all labels.

	    $this->set_colon_flag(true) ;
    }

    //  Overload form_action() due to a bug with form confirmation
    //  as "Save" isn't handled when form confirmation is turned off.

    /**
     * This method handles the form action.
     * 
     * @return boolean TRUE = success
     *                 FALSE = failed.
     */
    function form_action() {
        switch ($this->get_action()) {
        case "Edit":
            return FALSE;
            break;
            
        case "Save":
        case "Login":
        case "Confirm":
            if ($this->has_confirm())
                return $this->confirm_action();
            else
                return true ;
            break;

        default:
            return FALSE;
            break;
        }
    }
}

/**
 * FECountries - Country list box element
 *
 * @author Mike Walsh <mike_walsh@mindspirng.com>
 * @access public
 * @see FEListBox
 */
class FEColorList extends FEListBox
{
    /**
     * List of colors.
     */
    var $_colors = array(
        "Color" => ""
       ,"Sky Blue" => "skyblue"
       ,"Royal Blue" => "royalblue"
       ,"Blue" => "blue"
       ,"Dark Blue" => "darkblue"
       ,"Orange" => "orange"
       ,"Orange Red" => "orangered"
       ,"Crimson" => "crimson"
       ,"Red" => "red"
       ,"Firebrick" => "Firebrick"
       ,"Dark Red" => "darkred"
       ,"Green" => "green"
       ,"Lime Green" => "limegreen"
       ,"Sea Green" => "seagreen"
       ,"Deep Pink" => "deeppink"
       ,"Tomato" => "tomato"
       ,"Coral" => "coral"
       ,"Purple" => "purple"
       ,"Indigo" => "indigo"
       ,"Burly Wood" => "burlywood"
       ,"Sandy Brown" => "sandybrown"
       ,"Sienna" => "sienna"
       ,"Chocolate" => "chocolate"
       ,"Teal" => "teal"
       ,"Silver" => "silver"
    ) ;
    
    /**
     * The constructor
     *
     * @param string text label for the element
     * @param boolean is this a required element?
     * @param int element width in characters, pixels (px),
              percentage (%) or elements (em)
     * @param int element height in px
     * @param array data_list - list of data elements (name=>value)
     */
    function FEColorList($label, $required = true,
        $width = null, $height = null)
    {
        $this->FEListBox($label, $required, $width, $height, $this->_colors) ;
    }
}

/**
 * FECountries - Country list box element
 *
 * @author Mike Walsh <mike_walsh@mindspirng.com>
 * @access public
 * @see FEListBox
 */
class FECountries extends FEListBox
{
    /**
     * List of countries - obtained from the 
     * United States Post Office web site on
     * September 3, 2008.
     */
    var $_countries = array(
        "Select Country" => ""
       ,"Abu Dhabi" => "Abu Dhabi"
       ,"Admiralty Islands" => "Admiralty Islands"
       ,"Afars" => "Afars"
       ,"Afghanistan" => "Afghanistan"
       ,"Aitutaki" => "Aitutaki"
       ,"Ajman" => "Ajman"
       ,"Aland Island" => "Aland Island"
       ,"Albania" => "Albania"
       ,"Alberta" => "Alberta"
       ,"Alderney" => "Alderney"
       ,"Alderney, Channel Islands" => "Alderney, Channel Islands"
       ,"Algeria" => "Algeria"
       ,"Alhucemas" => "Alhucemas"
       ,"Alofi Island" => "Alofi Island"
       ,"American Samoa" => "American Samoa"
       ,"Andaman Islands" => "Andaman Islands"
       ,"Andorra" => "Andorra"
       ,"Angola" => "Angola"
       ,"Anguilla" => "Anguilla"
       ,"Anjouan" => "Anjouan"
       ,"Annobon Island" => "Annobon Island"
       ,"Antigua" => "Antigua"
       ,"Antigua and Barbuda" => "Antigua and Barbuda"
       ,"Argentina" => "Argentina"
       ,"Armenia" => "Armenia"
       ,"Aruba" => "Aruba"
       ,"Ascension" => "Ascension"
       ,"Astypalaia" => "Astypalaia"
       ,"Atafu" => "Atafu"
       ,"Atiu" => "Atiu"
       ,"Australia" => "Australia"
       ,"Austria" => "Austria"
       ,"Avarua" => "Avarua"
       ,"Azerbaijan" => "Azerbaijan"
       ,"Azores" => "Azores"
       ,"Bahamas" => "Bahamas"
       ,"Bahrain" => "Bahrain"
       ,"Baker Island" => "Baker Island"
       ,"Balearic Islands" => "Balearic Islands"
       ,"Baluchistan" => "Baluchistan"
       ,"Bangladesh" => "Bangladesh"
       ,"Bank Island" => "Bank Island"
       ,"Banks Island" => "Banks Island"
       ,"Barbados" => "Barbados"
       ,"Barbuda" => "Barbuda"
       ,"Barthelemy" => "Barthelemy"
       ,"Belarus" => "Belarus"
       ,"Belgium" => "Belgium"
       ,"Belize" => "Belize"
       ,"Benin" => "Benin"
       ,"Bermuda" => "Bermuda"
       ,"Bhutan" => "Bhutan"
       ,"Bismark Archipelago" => "Bismark Archipelago"
       ,"Bolivia" => "Bolivia"
       ,"Bonaire" => "Bonaire"
       ,"Borabora" => "Borabora"
       ,"Borneo" => "Borneo"
       ,"Bosnia-Herzegovina" => "Bosnia-Herzegovina"
       ,"Botswana" => "Botswana"
       ,"Bougainville" => "Bougainville"
       ,"Bourbon" => "Bourbon"
       ,"Brazil" => "Brazil"
       ,"British Columbia" => "British Columbia"
       ,"British Guiana" => "British Guiana"
       ,"British Honduras" => "British Honduras"
       ,"British Virgin Islands" => "British Virgin Islands"
       ,"Brunei Darussalam" => "Brunei Darussalam"
       ,"Buka" => "Buka"
       ,"Bulgaria" => "Bulgaria"
       ,"Burkina Faso" => "Burkina Faso"
       ,"Burma" => "Burma"
       ,"Burundi" => "Burundi"
       ,"Caicos Islands" => "Caicos Islands"
       ,"Cambodia" => "Cambodia"
       ,"Cameroon" => "Cameroon"
       ,"Canada" => "Canada"
       ,"Canary Islands" => "Canary Islands"
       ,"Canton Island" => "Canton Island"
       ,"Cape Verde" => "Cape Verde"
       ,"Cayman Islands" => "Cayman Islands"
       ,"Central African Republic" => "Central African Republic"
       ,"Ceuta" => "Ceuta"
       ,"Ceylon" => "Ceylon"
       ,"Chad" => "Chad"
       ,"Chaferinas Islands" => "Chaferinas Islands"
       ,"Chalki" => "Chalki"
       ,"Channel Islands" => "Channel Islands"
       ,"Chile" => "Chile"
       ,"China" => "China"
       ,"Christiansted, US Virgin Islands" => "Christiansted, US Virgin Islands"
       ,"Christmas Island" => "Christmas Island"
       ,"Chuuk" => "Chuuk"
       ,"Cocos Island" => "Cocos Island"
       ,"Cocos Island" => "Cocos Island"
       ,"Colombia" => "Colombia"
       ,"Commonwealth of the Northern Mariana Islands" => "Commonwealth of the Northern Mariana Islands"
       ,"Comoros" => "Comoros"
       ,"Congo" => "Congo"
       ,"Congo, Democratic Republic of the" => "Congo, Democratic Republic of the"
       ,"Cook Islands" => "Cook Islands"
       ,"Corisco Island" => "Corisco Island"
       ,"Corisco Island" => "Corisco Island"
       ,"Corsica" => "Corsica"
       ,"Costa Rica" => "Costa Rica"
       ,"Cote d Ivoire" => "Cote d Ivoire"
       ,"Crete" => "Crete"
       ,"Croatia" => "Croatia"
       ,"Cuba" => "Cuba"
       ,"Cumino Island" => "Cumino Island"
       ,"Curacao" => "Curacao"
       ,"Cyjrenaica" => "Cyjrenaica"
       ,"Cyprus" => "Cyprus"
       ,"Czech Republic" => "Czech Republic"
       ,"Dahomey" => "Dahomey"
       ,"Damao" => "Damao"
       ,"Danger Islands" => "Danger Islands"
       ,"Democratic People's Republic of Korea" => "Democratic People's Republic of Korea"
       ,"Democratic Republic of the Congo" => "Democratic Republic of the Congo"
       ,"Denmark" => "Denmark"
       ,"Desirade Island" => "Desirade Island"
       ,"Diu" => "Diu"
       ,"Djibouti" => "Djibouti"
       ,"Dodecanese Islands" => "Dodecanese Islands"
       ,"Doha" => "Doha"
       ,"Dominica" => "Dominica"
       ,"Dominican Republic" => "Dominican Republic"
       ,"Dubai" => "Dubai"
       ,"East Timor" => "East Timor"
       ,"Eastern Island, Midway Islands" => "Eastern Island, Midway Islands"
       ,"Ebeye, Marshall Islands" => "Ebeye, Marshall Islands"
       ,"Ecuador" => "Ecuador"
       ,"Egypt" => "Egypt"
       ,"Eire" => "Eire"
       ,"El Salvador" => "El Salvador"
       ,"Ellice Islands" => "Ellice Islands"
       ,"Elobey Islands" => "Elobey Islands"
       ,"Enderbury Island" => "Enderbury Island"
       ,"England" => "England"
       ,"Equatorial Guinea" => "Equatorial Guinea"
       ,"Eritrea" => "Eritrea"
       ,"Estonia" => "Estonia"
       ,"Ethiopia" => "Ethiopia"
       ,"Fakaofo" => "Fakaofo"
       ,"Falkland Islands" => "Falkland Islands"
       ,"Fanning Island" => "Fanning Island"
       ,"Faroe Islands" => "Faroe Islands"
       ,"Federated States of Micronesia" => "Federated States of Micronesia"
       ,"Fernando Po" => "Fernando Po"
       ,"Fezzan" => "Fezzan"
       ,"Fiji" => "Fiji"
       ,"Finland" => "Finland"
       ,"Formosa" => "Formosa"
       ,"France" => "France"
       ,"France, Metropolitan" => "France, Metropolitan"
       ,"Frederiksted, US Virgin Islands" => "Frederiksted, US Virgin Islands"
       ,"French Guiana" => "French Guiana"
       ,"French Oceania" => "French Oceania"
       ,"French Polynesia" => "French Polynesia"
       ,"French Somaliland" => "French Somaliland"
       ,"French Territory of the Afars and Issas" => "French Territory of the Afars and Issas"
       ,"French West Indies" => "French West Indies"
       ,"Friendly Islands" => "Friendly Islands"
       ,"Fujairah" => "Fujairah"
       ,"Futuna" => "Futuna"
       ,"Gabon" => "Gabon"
       ,"Gambia" => "Gambia"
       ,"Gambier" => "Gambier"
       ,"Georgia, Republic of" => "Georgia, Republic of"
       ,"Germany" => "Germany"
       ,"Ghana" => "Ghana"
       ,"Gibraltar" => "Gibraltar"
       ,"Gilbert Islands" => "Gilbert Islands"
       ,"Goa" => "Goa"
       ,"Gozo Island" => "Gozo Island"
       ,"Grand Comoro" => "Grand Comoro"
       ,"Great Britain" => "Great Britain"
       ,"Great Britain and Northern Ireland" => "Great Britain and Northern Ireland"
       ,"Greece" => "Greece"
       ,"Greenland" => "Greenland"
       ,"Grenada" => "Grenada"
       ,"Grenadines" => "Grenadines"
       ,"Guadeloupe" => "Guadeloupe"
       ,"Guam" => "Guam"
       ,"Guatemala" => "Guatemala"
       ,"Guernsey" => "Guernsey"
       ,"Guernsey, Channel Islands" => "Guernsey, Channel Islands"
       ,"Guinea" => "Guinea"
       ,"Guinea-Bissau" => "Guinea-Bissau"
       ,"Guyana" => "Guyana"
       ,"Hainan Island" => "Hainan Island"
       ,"Haiti" => "Haiti"
       ,"Hashemite Kingdom" => "Hashemite Kingdom"
       ,"Hervey" => "Hervey"
       ,"Hivaoa" => "Hivaoa"
       ,"Holland" => "Holland"
       ,"Honduras" => "Honduras"
       ,"Hong Kong" => "Hong Kong"
       ,"Howard Island" => "Howard Island"
       ,"Huahine" => "Huahine"
       ,"Huan Island" => "Huan Island"
       ,"Hungary" => "Hungary"
       ,"Iceland" => "Iceland"
       ,"India" => "India"
       ,"Indonesia" => "Indonesia"
       ,"Iran" => "Iran"
       ,"Iraq" => "Iraq"
       ,"Ireland" => "Ireland"
       ,"Irian Barat" => "Irian Barat"
       ,"Isle of Man" => "Isle of Man"
       ,"Isle of Pines" => "Isle of Pines"
       ,"Isle of Pines, West Indies" => "Isle of Pines, West Indies"
       ,"Israel" => "Israel"
       ,"Issas" => "Issas"
       ,"Italy" => "Italy"
       ,"Jamaica" => "Jamaica"
       ,"Japan" => "Japan"
       ,"Jarvis Island" => "Jarvis Island"
       ,"Jersey" => "Jersey"
       ,"Johnston Island" => "Johnston Island"
       ,"Johore" => "Johore"
       ,"Jordan" => "Jordan"
       ,"Kalimantan" => "Kalimantan"
       ,"Kalymnos" => "Kalymnos"
       ,"Kampuchea" => "Kampuchea"
       ,"Karpathos" => "Karpathos"
       ,"Kassos" => "Kassos"
       ,"Kastellorizon" => "Kastellorizon"
       ,"Kazakhstan" => "Kazakhstan"
       ,"Kedah" => "Kedah"
       ,"Keeling Islands" => "Keeling Islands"
       ,"Kelantan" => "Kelantan"
       ,"Kenya" => "Kenya"
       ,"Kingman Reef" => "Kingman Reef"
       ,"Kingshill, US Virgin Islands" => "Kingshill, US Virgin Islands"
       ,"Kiribati" => "Kiribati"
       ,"Korea, Democratic Peoples Republic of" => "Korea, Democratic Peoples Republic of"
       ,"Korea, Republic of" => "Korea, Republic of"
       ,"Koror" => "Koror"
       ,"Kos" => "Kos"
       ,"Kosrae, Micronesia" => "Kosrae, Micronesia"
       ,"Kowloon" => "Kowloon"
       ,"Kuwait" => "Kuwait"
       ,"Kwajalein, Marshall Islands" => "Kwajalein, Marshall Islands"
       ,"Kyrgyzstan" => "Kyrgyzstan"
       ,"Labrador" => "Labrador"
       ,"Labrador" => "Labrador"
       ,"Labuan" => "Labuan"
       ,"Labuan" => "Labuan"
       ,"Laos" => "Laos"
       ,"Latvia" => "Latvia"
       ,"Lebanon" => "Lebanon"
       ,"Leipsos" => "Leipsos"
       ,"Leros" => "Leros"
       ,"Les Saints Island" => "Les Saints Island"
       ,"Lesotho" => "Lesotho"
       ,"Liberia" => "Liberia"
       ,"Libya" => "Libya"
       ,"Liechtenstein" => "Liechtenstein"
       ,"Lithuania" => "Lithuania"
       ,"Lord Howe Island" => "Lord Howe Island"
       ,"Lord Howe Island" => "Lord Howe Island"
       ,"Loyalty Islands" => "Loyalty Islands"
       ,"Loyalty Islands" => "Loyalty Islands"
       ,"Luxembourg" => "Luxembourg"
       ,"Macao" => "Macao"
       ,"Macau" => "Macau"
       ,"Macedonia, Republic of" => "Macedonia, Republic of"
       ,"Madagascar" => "Madagascar"
       ,"Madeira Islands" => "Madeira Islands"
       ,"Maderia Islands" => "Maderia Islands"
       ,"Majuro, Marshall Islands" => "Majuro, Marshall Islands"
       ,"Malacca" => "Malacca"
       ,"Malagasy Republic" => "Malagasy Republic"
       ,"Malawi" => "Malawi"
       ,"Malaya" => "Malaya"
       ,"Malaya" => "Malaya"
       ,"Malaysia" => "Malaysia"
       ,"Maldives" => "Maldives"
       ,"Mali" => "Mali"
       ,"Malta" => "Malta"
       ,"Manahiki" => "Manahiki"
       ,"Manchuria" => "Manchuria"
       ,"Mangaia" => "Mangaia"
       ,"Manitoba" => "Manitoba"
       ,"Manua Islands, American Samoa" => "Manua Islands, American Samoa"
       ,"Manuai" => "Manuai"
       ,"Marie Galante" => "Marie Galante"
       ,"Marquesas Islands" => "Marquesas Islands"
       ,"Marshall Islands" => "Marshall Islands"
       ,"Martinique" => "Martinique"
       ,"Mauke" => "Mauke"
       ,"Mauritania" => "Mauritania"
       ,"Mauritius" => "Mauritius"
       ,"Mayotte" => "Mayotte"
       ,"Melilla" => "Melilla"
       ,"Mexico" => "Mexico"
       ,"Micronesia, Federated States of" => "Micronesia, Federated States of"
       ,"Midway Island" => "Midway Island"
       ,"Midway Islands" => "Midway Islands"
       ,"Miquelon" => "Miquelon"
       ,"Mitiaro" => "Mitiaro"
       ,"Moheli" => "Moheli"
       ,"Moldova" => "Moldova"
       ,"Monaco" => "Monaco"
       ,"Mongolia" => "Mongolia"
       ,"Montserrat" => "Montserrat"
       ,"Moorea" => "Moorea"
       ,"Morocco" => "Morocco"
       ,"Mozambique" => "Mozambique"
       ,"Muscat" => "Muscat"
       ,"Myanmar" => "Myanmar"
       ,"Namibia" => "Namibia"
       ,"Nansil Islands" => "Nansil Islands"
       ,"Nauru" => "Nauru"
       ,"Navassa Island" => "Navassa Island"
       ,"Negri Sembilan" => "Negri Sembilan"
       ,"Nepal" => "Nepal"
       ,"Netherlands" => "Netherlands"
       ,"Netherlands Antilles" => "Netherlands Antilles"
       ,"Netherlands West Indies" => "Netherlands West Indies"
       ,"Nevis" => "Nevis"
       ,"New Britain" => "New Britain"
       ,"New Brunswick" => "New Brunswick"
       ,"New Caledonia" => "New Caledonia"
       ,"New Hanover" => "New Hanover"
       ,"New Hebrides" => "New Hebrides"
       ,"New Ireland" => "New Ireland"
       ,"New South Wales" => "New South Wales"
       ,"New Zealand" => "New Zealand"
       ,"Newfoundland" => "Newfoundland"
       ,"Nicaragua" => "Nicaragua"
       ,"Niger" => "Niger"
       ,"Nigeria" => "Nigeria"
       ,"Nissiros" => "Nissiros"
       ,"Niue" => "Niue"
       ,"Norfolk Island" => "Norfolk Island"
       ,"North Borneo" => "North Borneo"
       ,"North Korea" => "North Korea"
       ,"Northern Ireland" => "Northern Ireland"
       ,"Northern Mariana Islands, Commonwealth of" => "Northern Mariana Islands, Commonwealth of"
       ,"Northwest Territory" => "Northwest Territory"
       ,"Norway" => "Norway"
       ,"Nova Scotia" => "Nova Scotia"
       ,"Nukahiva" => "Nukahiva"
       ,"Nukunonu" => "Nukunonu"
       ,"Nyasaland" => "Nyasaland"
       ,"Ocean Island" => "Ocean Island"
       ,"Okinawa" => "Okinawa"
       ,"Oman" => "Oman"
       ,"Ontario" => "Ontario"
       ,"Pago Pago, American Samoa" => "Pago Pago, American Samoa"
       ,"Pahang" => "Pahang"
       ,"Pakistan" => "Pakistan"
       ,"Palau" => "Palau"
       ,"Palmerston" => "Palmerston"
       ,"Palmyra Island" => "Palmyra Island"
       ,"Panama" => "Panama"
       ,"Papua New Guinea" => "Papua New Guinea"
       ,"Paraguay" => "Paraguay"
       ,"Parry" => "Parry"
       ,"Patmos" => "Patmos"
       ,"Pemba" => "Pemba"
       ,"Penang" => "Penang"
       ,"Penghu Islands" => "Penghu Islands"
       ,"Penon de Velez de la Gomera" => "Penon de Velez de la Gomera"
       ,"Penrhyn" => "Penrhyn"
       ,"Perak" => "Perak"
       ,"Perlis" => "Perlis"
       ,"Persia" => "Persia"
       ,"Peru" => "Peru"
       ,"Pescadores Islands" => "Pescadores Islands"
       ,"Petite Terre" => "Petite Terre"
       ,"Philippines" => "Philippines"
       ,"Pitcairn Island" => "Pitcairn Island"
       ,"Pohnpei, Micronesia" => "Pohnpei, Micronesia"
       ,"Poland" => "Poland"
       ,"Portugal" => "Portugal"
       ,"Prince Edward Island" => "Prince Edward Island"
       ,"Province Wellesley" => "Province Wellesley"
       ,"Puerto Rico" => "Puerto Rico"
       ,"Pukapuka" => "Pukapuka"
       ,"Qatar" => "Qatar"
       ,"Quebec" => "Quebec"
       ,"Queensland" => "Queensland"
       ,"Quemoy" => "Quemoy"
       ,"Raiatea" => "Raiatea"
       ,"Rakaanga" => "Rakaanga"
       ,"Rapa" => "Rapa"
       ,"Rarotonga" => "Rarotonga"
       ,"Ras al Kaimah" => "Ras al Kaimah"
       ,"Redonda" => "Redonda"
       ,"Republic of Georgia" => "Republic of Georgia"
       ,"Republic of Korea" => "Republic of Korea"
       ,"Republic of the Congo" => "Republic of the Congo"
       ,"Republic of the Marshall Islands" => "Republic of the Marshall Islands"
       ,"Reunion" => "Reunion"
       ,"Rhodesia" => "Rhodesia"
       ,"Rio Muni" => "Rio Muni"
       ,"Rodos" => "Rodos"
       ,"Rodrigues" => "Rodrigues"
       ,"Romania" => "Romania"
       ,"Rota, Northern Mariana Islands" => "Rota, Northern Mariana Islands"
       ,"Russia" => "Russia"
       ,"Rwanda" => "Rwanda"
       ,"Saba" => "Saba"
       ,"Sabah" => "Sabah"
       ,"Saint Bartholomew" => "Saint Bartholomew"
       ,"Saint Christopher" => "Saint Christopher"
       ,"Saint Christopher and Nevis" => "Saint Christopher and Nevis"
       ,"Saint Croix, US Virgin Islands" => "Saint Croix, US Virgin Islands"
       ,"Saint Eustatius" => "Saint Eustatius"
       ,"Saint Helena" => "Saint Helena"
       ,"Saint John, US Virgin Islands" => "Saint John, US Virgin Islands"
       ,"Saint Kitts" => "Saint Kitts"
       ,"Saint Lucia" => "Saint Lucia"
       ,"Saint Maarten" => "Saint Maarten"
       ,"Saint Martin" => "Saint Martin"
       ,"Saint Pierre and Miquelon" => "Saint Pierre and Miquelon"
       ,"Saint Thomas, US Virgin Islands" => "Saint Thomas, US Virgin Islands"
       ,"Saint Vincent and the Grenadines" => "Saint Vincent and the Grenadines"
       ,"Sainte Marie de Madagascar" => "Sainte Marie de Madagascar"
       ,"Saipan, Northern Mariana Islands" => "Saipan, Northern Mariana Islands"
       ,"Salvador" => "Salvador"
       ,"San Marino" => "San Marino"
       ,"Sand Island, Midway Islands" => "Sand Island, Midway Islands"
       ,"Santa Cruz Islands" => "Santa Cruz Islands"
       ,"Sao Tome and Principe" => "Sao Tome and Principe"
       ,"Sarawak" => "Sarawak"
       ,"Sark" => "Sark"
       ,"Sark, Channel Islands" => "Sark, Channel Islands"
       ,"Saskatchewan" => "Saskatchewan"
       ,"Saudi Arabia" => "Saudi Arabia"
       ,"Savage Island" => "Savage Island"
       ,"Savaii Island" => "Savaii Island"
       ,"Scotland" => "Scotland"
       ,"Selangor" => "Selangor"
       ,"Senegal" => "Senegal"
       ,"Serbia-Montenegro" => "Serbia-Montenegro"
       ,"Seychelles" => "Seychelles"
       ,"Sharja" => "Sharja"
       ,"Shikoku" => "Shikoku"
       ,"Siam" => "Siam"
       ,"Sierra Leone" => "Sierra Leone"
       ,"Sikkim" => "Sikkim"
       ,"Singapore" => "Singapore"
       ,"Slovak Republic" => "Slovak Republic"
       ,"Slovenia" => "Slovenia"
       ,"Society Islands" => "Society Islands"
       ,"Solomon Islands" => "Solomon Islands"
       ,"Somali Democratic Republic" => "Somali Democratic Republic"
       ,"Somalia" => "Somalia"
       ,"Somaliland" => "Somaliland"
       ,"South Africa" => "South Africa"
       ,"South Australia" => "South Australia"
       ,"South Georgia" => "South Georgia"
       ,"South Korea" => "South Korea"
       ,"South-West Africa" => "South-West Africa"
       ,"Spain" => "Spain"
       ,"Spitzbergen" => "Spitzbergen"
       ,"Sri Lanka" => "Sri Lanka"
       ,"St. Barthelemy" => "St. Barthelemy"
       ,"St. Eustatius" => "St. Eustatius"
       ,"St. Kitts" => "St. Kitts"
       ,"St. Lucia" => "St. Lucia"
       ,"St. Maarten" => "St. Maarten"
       ,"St. Martin" => "St. Martin"
       ,"St. Vincent" => "St. Vincent"
       ,"Ste. Marie de Madagascar" => "Ste. Marie de Madagascar"
       ,"Sudan" => "Sudan"
       ,"Suriname" => "Suriname"
       ,"Suwarrow Islands" => "Suwarrow Islands"
       ,"Swain's Island, American Samoa" => "Swain's Island, American Samoa"
       ,"Swan Islands" => "Swan Islands"
       ,"Swaziland" => "Swaziland"
       ,"Sweden" => "Sweden"
       ,"Switzerland" => "Switzerland"
       ,"Symi" => "Symi"
       ,"Syrian Arab Republic" => "Syrian Arab Republic"
       ,"Tahaa" => "Tahaa"
       ,"Tahiti" => "Tahiti"
       ,"Taiwan" => "Taiwan"
       ,"Tajikistan" => "Tajikistan"
       ,"Tanzania" => "Tanzania"
       ,"Tasmania" => "Tasmania"
       ,"Tchad" => "Tchad"
       ,"Thailand" => "Thailand"
       ,"Thursday Island" => "Thursday Island"
       ,"Tibet" => "Tibet"
       ,"Tilos" => "Tilos"
       ,"Timor" => "Timor"
       ,"Tinian, Northern Mariana Islands(US Possession)" => "Tinian, Northern Mariana Islands(US Possession)"
       ,"Tobago" => "Tobago"
       ,"Togo" => "Togo"
       ,"Tokelau" => "Tokelau"
       ,"Tokelau Group" => "Tokelau Group"
       ,"Tonga" => "Tonga"
       ,"Tongareva" => "Tongareva"
       ,"Tori Shima" => "Tori Shima"
       ,"Torres Island" => "Torres Island"
       ,"Trans-Jordan" => "Trans-Jordan"
       ,"Transkei" => "Transkei"
       ,"Trengganu" => "Trengganu"
       ,"Trinidad and Tobago" => "Trinidad and Tobago"
       ,"Tripolitania" => "Tripolitania"
       ,"Tristan da Cunha" => "Tristan da Cunha"
       ,"Trucial States" => "Trucial States"
       ,"Truk" => "Truk"
       ,"Tuamotou" => "Tuamotou"
       ,"Tubuai" => "Tubuai"
       ,"Tunisia" => "Tunisia"
       ,"Turkey" => "Turkey"
       ,"Turkmenistan" => "Turkmenistan"
       ,"Turks and Caicos Islands" => "Turks and Caicos Islands"
       ,"Tutuila Island, American Samoa" => "Tutuila Island, American Samoa"
       ,"Tuvalu" => "Tuvalu"
       ,"U.S. Virgin Islands" => "U.S. Virgin Islands"
       ,"Uganda" => "Uganda"
       ,"Ukraine" => "Ukraine"
       ,"Umm Said" => "Umm Said"
       ,"Umm al Quaiwain" => "Umm al Quaiwain"
       ,"Union Group" => "Union Group"
       ,"United Arab Emirates" => "United Arab Emirates"
       ,"United Kingdom" => "United Kingdom"
       ,"United Nations, New York" => "United Nations, New York"
       ,"United States" => "United States"
       ,"Upolu Island" => "Upolu Island"
       ,"Uruguay" => "Uruguay"
       ,"Uzbekistan" => "Uzbekistan"
       ,"Vanuatu" => "Vanuatu"
       ,"Vatican City" => "Vatican City"
       ,"Venezuela" => "Venezuela"
       ,"Victoria" => "Victoria"
       ,"Vietnam" => "Vietnam"
       ,"Virgin Islands" => "Virgin Islands"
       ,"Wake Island" => "Wake Island"
       ,"Wales" => "Wales"
       ,"Wallis and Futuna Islands" => "Wallis and Futuna Islands"
       ,"Wellesley" => "Wellesley"
       ,"Wellesley, Province" => "Wellesley, Province"
       ,"West New Guinea" => "West New Guinea"
       ,"Western Australia" => "Western Australia"
       ,"Western Samoa" => "Western Samoa"
       ,"Yap, Micronesia" => "Yap, Micronesia"
       ,"Yemen" => "Yemen"
       ,"Yugoslavia" => "Yugoslavia"
       ,"Yukon Territory" => "Yukon Territory"
       ,"Zafarani Islands" => "Zafarani Islands"
       ,"Zaire" => "Zaire"
       ,"Zambia" => "Zambia"
       ,"Zanzibar" => "Zanzibar"
       ,"Zimbabwe" => "Zimbabwe"
    ) ;

    /**
     * The constructor
     *
     * @param string text label for the element
     * @param boolean is this a required element?
     * @param int element width in characters, pixels (px),
              percentage (%) or elements (em)
     * @param int element height in px
     * @param array data_list - list of data elements (name=>value)
     */
    function FECountries($label, $required = true,
        $width = null, $height = null)
    {
        $this->FEListBox($label, $required, $width, $height, $this->_countries) ;
    }
}
?>
