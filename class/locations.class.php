<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
/**
 * Location profile classes.
 *
 * $Id$
 *
 * (c) 2008 by Mike Walsh
 *
 * @author Mike Walsh <mike_walsh@mentor.com>
 * @package GlobalAccounts
 * @subpackage Locations
 * @version $Revision$
 * @lastmodified $Date$
 * @lastmodifiedby $Author$
 *
 */

require_once("db.class.php") ;
require_once("table.class.php") ;
require_once("widgets.class.php") ;
require_once("locations.include.php") ;
require_once("customers.class.php") ;
require_once(PHPHTMLLIB_ABSPATH . "/widgets/GoogleMap.inc");

/**
 * Class definition of the Locations
 *
 * @author Mike Walsh <mike_walsh@mentor.com>
 * @access public
 * @see GlobalAccountsDBI
 */
class GlobalAccountsLocation extends GlobalAccountsDBI
{
    /**
     * location id property - id
     */
    var $__locationid ;

    /**
     * global parent id property - global parent id 
     */
    var $__globalparentid = WPGA_NULL_ID ;

    /**
     * customer id property - the customer id
     */
    var $__customerid ;

    /**
     * location name property - the name of the locations
     */
    var $__locationname ;

    /**
     * street1 property - street address field 1
     */
    var $__street1 ;

    /**
     * street2 property - street address field 2
     */
    var $__street2 ;

    /**
     * street3 property - street address field 3
     */
    var $__street3 ;

    /**
     * city property
     */
    var $__city ;

    /**
     * stateorprovince property
     */
    var $__stateorprovince ;

    /**
     * postal code property
     */
    var $__postalcode ;

    /**
     * country property
     */
    var $__country ;

    /**
     * primary phone property
     */
    var $__primaryphone ;

    /**
     * secondary phone property
     */
    var $__secondaryphone ;

    /**
     * Set the location id
     *
     * @param - string - location id
     */
    function setLocationId($id)
    {
        $this->__locationid = $id ;
    }

    /**
     * Get the location id
     *
     * @return - string - location id
     */
    function getLocationId()
    {
        return ($this->__locationid) ;
    }

    /**
     * Set the global parent id
     *
     * @param - int - global parent id
     */
    function setGlobalParentId($id)
    {
        $this->__globalparentid = $id ;
    }

    /**
     * Get the global parent id
     *
     * @return - int - global parent id
     */
    function getGlobalParentId()
    {
        return ($this->__globalparentid) ;
    }

    /**
     * Set the customer id
     *
     * @param - string - customer id
     */
    function setCustomerId($name)
    {
        $this->__customerid = $name ;
    }

    /**
     * Get the customer id
     *
     * @return - string - customer id
     */
    function getCustomerId()
    {
        return ($this->__customerid) ;
    }

    /**
     * Set the location name
     *
     * @param - string - team club or pool name
     */
    function setLocationName($name)
    {
        $this->__locationname = $name ;
    }

    /**
     * Get the location name
     *
     * @return - string - team club or pool name
     */
    function getLocationName()
    {
        return ($this->__locationname) ;
    }

    /**
     * Set the wto region
     *
     * @param - string - wto region
     */
    function setWTORegion($name)
    {
        $this->__wtoregion = $name ;
    }

    /**
     * Get the wto region
     *
     * @return - string - wto region
     */
    function getWTORegion()
    {
        return ($this->__wtoregion) ;
    }

    /**
     * Set the street1 property
     *
     * @param - string - street address 1
     */
    function setStreet1($street1)
    {
        $this->__street1 = $street1 ;
    }

    /**
     * Get the street1 property
     *
     * @return - string - street address 1
     */
    function getStreet1()
    {
        return ($this->__street1) ;
    }

    /**
     * Set the street2 property
     *
     * @param - string - street address 2
     */
    function setStreet2($street2)
    {
        $this->__street2 = $street2 ;
    }

    /**
     * Get the street2 property
     *
     * @return - string - street address 2
     */
    function getStreet2()
    {
        return ($this->__street2) ;
    }

    /**
     * Set the street3 property
     *
     * @param - string - street address 3
     */
    function setStreet3($street3)
    {
        $this->__street3 = $street3 ;
    }

    /**
     * Get the street3 property
     *
     * @return - string - street address 3
     */
    function getStreet3()
    {
        return ($this->__street3) ;
    }

    /**
     * Set the city property
     *
     * @param - string - city
     */
    function setCity($city)
    {
        $this->__city = $city ;
    }

    /**
     * Get the city property
     *
     * @return - string - city
     */
    function getCity()
    {
        return ($this->__city) ;
    }

    /**
     * Set the stateorprovince property
     *
     * @param - string - stateorprovince
     */
    function setStateOrProvince($stateorprovince)
    {
        $this->__stateorprovince = $stateorprovince ;
    }

    /**
     * Get the stateorprovince property
     *
     * @return - string - stateorprovince
     */
    function getStateOrProvince()
    {
        return ($this->__stateorprovince) ;
    }

    /**
     * Set the postal code property
     *
     * @param - string - postal code
     */
    function setPostalCode($postalcode)
    {
        $this->__postalcode = $postalcode ;
    }

    /**
     * Get the postal code property
     *
     * @return - string - postal code
     */
    function getPostalCode()
    {
        return ($this->__postalcode) ;
    }

    /**
     * Set the country property
     *
     * @param - string - country
     */
    function setCountry($country)
    {
        $this->__country = $country ;
    }

    /**
     * Get the country property
     *
     * @return - string - country
     */
    function getCountry()
    {
        return ($this->__country) ;
    }

    /**
     * Set the primary phone property
     *
     * @param - string - primary phone
     */
    function setPrimaryPhone($p)
    {
        $this->__primaryphone = $p;
    }

    /**
     * Get the primary phone property
     *
     * @return - string - primary phone
     */
    function getPrimaryPhone()
    {
        return ($this->__primaryphone) ;
    }

    /**
     * Set the secondary phone property
     *
     * @param - string - secondary phone
     */
    function setSecondaryPhone($p)
    {
        $this->__secondaryphone = $p;
    }

    /**
     * Get the secondary phone property
     *
     * @return - string - secondary phone
     */
    function getSecondaryPhone()
    {
        return ($this->__secondaryphone) ;
    }

    /**
     * Set the team web site
     *
     * @param - string - team web site
     */
    function setWebSite($s)
    {
        $this->__website = $s;
    }

    /**
     * Get the team web site
     *
     * @return - string - team web site
     */
    function getWebSite()
    {
        return ($this->__website) ;
    }

    /**
     * Check if a location already exists in the database
     * and return a boolean accordingly.
     *
     * @return - boolean - existance of customer
     */
    function getLocationExists()
    {
	    //  Is a similar location already in the database?

        $query = sprintf("SELECT locationid FROM %s WHERE
            customerid = \"%s\" AND locationname = \"%s\"",
            WPGA_LOCATIONS_TABLE, $this->getCustomerId(),
            $this->getLocationName()) ;

        //  Retain the query result so it can be used later if needed
 
        $this->setQuery($query) ;
        $this->runSelectQuery() ;

	    //  Make sure customer doesn't exist

        $customerExists = (bool)($this->getQueryCount() > 0) ;

	    return $customerExists ;
    }

    /**
     *
     * Check if a id already exists in the database
     * and return a boolean accordingly.
     *
     * @param - string - optional id
     * @return - boolean - existance of customer
     */
    function getLocationExistsById($id = null)
    {
        if (is_null($id)) $id = $this->getLocationId() ;

	    //  Is id already in the database?

        $query = sprintf("SELECT locationid FROM %s WHERE locationid = \"%s\"",
            WPGA_LOCATIONS_TABLE, $id) ;

        $this->setQuery($query) ;
        $this->runSelectQuery(false) ;

	    //  Make sure id doesn't exist

        $idExists = (bool)($this->getQueryCount() > 0) ;

	    return $idExists ;
    }

    /**
     * Add a new customer
     */
    function addLocation()
    {
        $success = null ;

        //  Make sure the location doesn't exist yet

        if (!$this->getLocationExists())
        {
            global $userdata ;

            get_currentuserinfo() ;

            //  Construct the insert query
 
            $query = sprintf("INSERT INTO %s SET
                globalparentid=\"%s\",
                customerid=\"%s\",
                locationname=\"%s\",
                wtoregion=\"%s\",
                street1=\"%s\",
                street2=\"%s\",
                street3=\"%s\",
                city=\"%s\",
                stateorprovince=\"%s\",
                postalcode=\"%s\",
                country=\"%s\",
                primaryphone=\"%s\",
                secondaryphone=\"%s\",
                website=\"%s\",
                modified=NOW(),
                modifiedby=\"%s\"",
                WPGA_LOCATIONS_TABLE,
                $this->getGlobalParentId(),
                $this->getCustomerId(),
                $this->getLocationName(),
                $this->getWTORegion(),
                $this->getStreet1(),
                $this->getStreet2(),
                $this->getStreet3(),
                $this->getCity(),
                $this->getStateOrProvince(),
                $this->getPostalCode(),
                $this->getCountry(),
                $this->getPrimaryPhone(),
                $this->getSecondaryPhone(),
                $this->getWebSite(),
                $userdata->ID) ;

            $this->setQuery($query) ;
            $this->runInsertQuery() ;
            $success = $this->getInsertId() ;
        }

        return $success ;
    }

    /**
     * Update a customer location
     *
     * Update the label, start date, and/or end date but
     * don't update the status, that is done by explicity
     * opening or closing a customer.
     */
    function updateLocation()
    {
        $success = null ;

        global $userdata ;

        get_currentuserinfo() ;

        //  Make sure the customer doesn't exist yet

        if ($this->getLocationExistsById())
        {
            //  Construct the insert query
 
            $query = sprintf("UPDATE %s SET
                globalparentid=\"%s\",
                customerid=\"%s\",
                locationname=\"%s\",
                wtoregion=\"%s\",
                street1=\"%s\",
                street2=\"%s\",
                street3=\"%s\",
                city=\"%s\",
                stateorprovince=\"%s\",
                postalcode=\"%s\",
                country=\"%s\",
                primaryphone=\"%s\",
                secondaryphone=\"%s\",
                website=\"%s\",
                modified=NOW(),
                modifiedby=\"%s\"
                WHERE locationid=\"%s\"",
                WPGA_LOCATIONS_TABLE,
                $this->getGlobalParentId(),
                $this->getCustomerId(),
                $this->getLocationName(),
                $this->getWTORegion(),
                $this->getStreet1(),
                $this->getStreet2(),
                $this->getStreet3(),
                $this->getCity(),
                $this->getStateOrProvince(),
                $this->getPostalCode(),
                $this->getCountry(),
                $this->getPrimaryPhone(),
                $this->getSecondaryPhone(),
                $this->getWebSite(),
                $userdata->ID,
                $this->getLocationId()
            ) ;

            $this->setQuery($query) ;
            $this->runUpdateQuery() ;
        }
        else
        {
            wp_die("Serious database update error encountered.") ;
        }

        return true ;
    }

    /**
     * Delete a customer
     *
     * Really need to think about this because deleting a customer
     * means deleting all of the meets that go with it.  So if a
     * customer has meets (which have results), disallow deleting
     * the customer.  It can be "hidden" but can't be deleted.
     *
     */
    function deleteLocation()
    {
        $success = null ;

        //  Make sure the customer doesn't exist yet

        if (!$this->getLocationExists())
        {
            //  Construct the insert query
 
            $query = sprintf("DELETE FROM %s
                WHERE id=\"%s\"",
                WPGA_LOCATIONS_TABLE,
                $this->getLocationId()
            ) ;

            $this->setQuery($query) ;
            $this->runDeleteQuery() ;
        }

        $success = !$this->getLocationExistsById() ;

        return $success ;
    }

    /**
     *
     * Load customer record by Id
     *
     * @param - string - optional customer id
     */
    function loadLocationByLocationId($locationid = null)
    {
        if (is_null($locationid)) $locationid = $this->getLocationId() ;

        //  Dud?
        if (is_null($locationid)) return false ;

        $this->setLocationId($locationid) ;

        //  Make sure it is a legal customer id
        if ($this->getLocationExistsById())
        {
            $query = sprintf("SELECT * FROM %s WHERE locationid = \"%s\"",
                WPGA_LOCATIONS_TABLE, $locationid) ;

            $this->setQuery($query) ;
            $this->runSelectQuery() ;

            $result = $this->getQueryResult() ;

            $this->setLocationId($result['locationid']) ;
            $this->setGlobalParentId($result['globalparentid']) ;
            $this->setCustomerId($result['customerid']) ;
            $this->setLocationName($result['locationname']) ;
            $this->setWTORegion($result['wtoregion']) ;
            $this->setStreet1($result['street1']) ;
            $this->setStreet2($result['street2']) ;
            $this->setStreet3($result['street3']) ;
            $this->setCity($result['city']) ;
            $this->setStateOrProvince($result['stateorprovince']) ;
            $this->setPostalCode($result['postalcode']) ;
            $this->setCountry($result['country']) ;
            $this->setPrimaryPhone($result['primaryphone']) ;
            $this->setSecondaryPhone($result['secondaryphone']) ;
            $this->setWebSite($result['website']) ;
        }

        $idExists = (bool)($this->getQueryCount() > 0) ;

	    return $idExists ;
    }

    /**
     * Retrieve all the Swim Club Ids for the customer locations.
     * Swim Clubs can be filtered to return a subset of records
     *
     * @param - string - optional filter to restrict query
     * @return - array - array of swimmers ids
     */
    function getAllLocationIds($filter = null, $orderby = "customerid")
    {
        //  Select the records for the season

        $query = sprintf("SELECT locationid FROM %s", WPGA_LOCATIONS_TABLE) ;
        if (!is_null($filter) && ($filter != ""))
            $query .= sprintf(" WHERE %s", $filter) ;

        $query .= sprintf(" ORDER BY %s", $orderby) ;

        $this->setQuery($query) ;
        $this->runSelectQuery() ;

        return $this->getQueryResults() ;
    }
}

/**
 * Class definition of the Locations
 *
 * @author Mike Walsh <mike_walsh@mentor.com>
 * @access public
 * @see GlobalAccountsDBI
 */
class GlobalAccountsLocationFRP extends GlobalAccountsLocation
{
    /**
     * FRP
     */
    var $__locationfrp ;

    /**
     * Set Location FRP
     *
     * @param mixed - array of mgc product ids and FRP values
     */
    function setLocationFRP($frp)
    {
        $this->__locationfrp = $frp ;
    }

    /**
     * Get Location FRP
     *
     * @return mixed - array of mgc product ids and FRP values
     */
    function getLocationFRP()
    {
        return $this->__locationfrp ;
    }

    /**
     * Update location FRP
     *
     * @param int - location id
     */
    function updateLocationFRP($locationid = null)
    {
        if (is_null($locationid)) $locationid = $this->getLocationId() ;

        //  Dud?
        if (is_null($locationid)) return false ;

        $this->loadLocationByLocationId($locationid) ;

        $frp = $this->getLocationFRP() ;

        global $userdata ;
        get_currentuserinfo() ;

        foreach ($frp as $key => $value)
        {
            $query = sprintf("SELECT frpid FROM %s WHERE
                locationid = \"%s\" AND mgcdivisionid = \"%s\"",
                WPGA_FRP_TABLE,
                $locationid,
                $key) ;

            $this->setQuery($query) ;
            $this->runSelectQuery() ;

            $query = sprintf("%s %s SET
                locationid = \"%s\",
                mgcdivisionid = \"%s\",
                mgcdivisionfrp = \"%s\",
                modified=NOW(),
                modifiedby=\"%s\"",
                ($this->getQueryCount() == 0) ? "INSERT INTO" : "UPDATE",
                WPGA_FRP_TABLE,
                $locationid,
                $key,
                $value,
                $userdata->ID) ;

            $this->setQuery($query) ;
            $this->runReplaceQuery() ;
        }

        return true ;
    }

    /**
     * Load FRP by location id
     *
     */
    function loadLocationFRP($locationid = null)
    {
        if (is_null($locationid)) $locationid = $this->getLocationId() ;

        //  Dud?
        if (is_null($locationid)) return false ;

        $this->setLocationId($locationid) ;

        //  Make sure it is a legal customer id
        if ($this->getLocationExistsById())
        {
            $query = sprintf("SELECT * FROM %s WHERE locationid='%s'",
                WPGA_FRP_TABLE, $locationid) ;

            $this->setQuery($query) ;
            $this->runSelectQuery() ;

            $results = $this->getQueryResults() ;

            //  Reset FRP array

            $this->__locationfrp = array() ;

            //  Loop through results, loading array

            if (!is_null($results))
            {
                foreach ($results as $result)
                {
                    $this->__locationfrp[$result["mgcdivisionid"]] =
                        $result["mgcdivisionfrp"] ;
                }
            }
        }

        $idExists = (bool)($this->getQueryCount() > 0) ;

	    return $idExists ;
    }
}

/**
 * Class definition of the Location Map
 *
 * @author Mike Walsh <mike_walsh@mentor.com>
 * @access public
 * @see GlobalAccountsDBI
 */
class GlobalAccountsLocationMap extends GlobalAccountsLocationFRP
{
    /**
     * Map the location
     *
     * @param none
     * @return DIVTag
     */
    function mapLocation()
    {
        $customer = new GlobalAccountsCustomer() ;

        $customer->loadCustomerByCustomerId($this->getCustomerId()) ;

        $infotext = $customer->GetCustomerName() ;
        $infotext .= "<br>" . $this->getLocationName() ;

        $address = $this->getStreet1() ;

        if ($this->getStreet2() != WPGA_NULL_STRING)
        {
            $address .= " " . $this->getStreet2() ;
            $infotext .= "<br>" . $this->getStreet2() ;
        }

        if ($this->getStreet3() != WPGA_NULL_STRING)
        {
            $address .= " " . $this->getStreet3() ;
            $infotext .= "<br>" . $this->getStreet3() ;
        }

        $address .= " " . $this->getCity() ;
        $infotext .= "<br>" . $this->getCity() ;
        $address .= ", " . $this->getStateOrProvince() ;
        $infotext .= ", " . $this->getStateOrProvince() ;
        $address .= " " . $this->getPostalCode() ;
        $infotext .= " " . $this->getPostalCode() ;
        $address .= " " . $this->getCountry() ;
        $infotext .= "<br>" . $this->getCountry() ;

        //  Create a GoogleMapDIVtag

        $div = new GoogleMapDIVtag() ;

        $div->set_id("map_canvas_" . $this->getLocationId()) ;
        $div->set_style("border: 3px solid #afb5ff") ;
        $div->setInfoWindowType(PHL_GMAPS_INFO_WINDOW_HTML) ;
        $div->setZoomLevel(10) ;
        $div->setAddress($address) ;
        $div->setInfoText($infotext) ;
        
        $div->setAPIKey(get_option(WPGA_OPTION_GOOGLE_API_KEY)) ;

        $div->generateMap() ;

        return $div ;
    }
}    

/**
 * Class definition of the Locations
 *
 * @author Mike Walsh <mike_walsh@mentor.com>
 * @access public
 * @see GlobalAccountsDBI
 */
class GlobalAccountsMultipleLocationMap extends GlobalAccountsLocationFRP
{
    /**
     * location ids
     */
    var $__locationids ;

    /**
     * height
     */
    var $__height = "300" ;

    /**
     * width
     */
    var $__width = "400" ;

    /**
     * Set height
     *
     * @param int - height
     */
    function setMapHeight($height)
    {
        $this->__height = $height ;
    }

    /**
     * Get height
     *
     * @return int - height
     */
    function getMapHeight()
    {
        return $this->__height ;
    }

    /**
     * Set width
     *
     * @param int - width
     */
    function setMapWidth($width)
    {
        $this->__width = $width ;
    }

    /**
     * Get width
     *
     * @return int - width
     */
    function getMapWidth()
    {
        return $this->__width ;
    }

    /**
     * Set location ids
     *
     * @param mixed - location ids
     */
    function setLocationIds($ids)
    {
        $this->__locationids = $ids ;
    }

    /**
     * Get location ids
     *
     * @return mixed - location ids
     */
    function getLocationIds()
    {
        return $this->__locationids ;
    }

    /**
     * Map the locations
     *
     * @param none
     * @return DIVTag
     */
    function mapLocations()
    {
        $locationids = $this->getLocationIds() ;

        //  Create a GoogleMapDIVtag

        $div = new GoogleMapDIVtag() ;

        $div->set_id("map_canvas") ;
        $div->set_style("border: 3px solid #afb5ff") ;
        $div->setShowControls(true) ;
        $div->setInfoWindowType(PHL_GMAPS_INFO_WINDOW_HTML) ;
        $div->setZoomLevel(3) ;
        $div->setMapHeight($this->getMapHeight()) ;
        $div->setMapWidth($this->getMapWidth()) ;

        $div->setAPIKey(get_option(WPGA_OPTION_GOOGLE_API_KEY)) ;

        $customer = new GlobalAccountsCustomer() ;

        foreach ($locationids as $locationid)
        {
            if ($this->loadLocationByLocationId($locationid))
            {
                $customer->loadCustomerByCustomerId($this->getCustomerId()) ;

                $infotext = $customer->GetCustomerName() ;
                $infotext .= "<br>" . $this->getLocationName() ;

                $address = $this->getStreet1() ;

                if ($this->getStreet2() != WPGA_NULL_STRING)
                {
                    $address .= " " . $this->getStreet2() ;
                    $infotext .= "<br>" . $this->getStreet2() ;
                }

                if ($this->getStreet3() != WPGA_NULL_STRING)
                {
                    $address .= " " . $this->getStreet3() ;
                    $infotext .= "<br>" . $this->getStreet3() ;
                }

                $address .= " " . $this->getCity() ;
                $infotext .= "<br>" . $this->getCity() ;
                $address .= ", " . $this->getStateOrProvince() ;
                $infotext .= ", " . $this->getStateOrProvince() ;
                $address .= " " . $this->getPostalCode() ;
                $infotext .= " " . $this->getPostalCode() ;
                $address .= " " . $this->getCountry() ;
                $infotext .= "<br>" . $this->getCountry() ;

                $div->setAddress($address) ;
                $div->setInfoText($infotext) ;
            }
            else
            {
                wp_die("Serious database query error encountered.") ;
            }
        }

        $div->generateMap() ;

        return $div ;
    }
}    

/**
 * Extended InfoTable Class for presenting Swimmer
 * information as a table extracted from the database.
 *
 * @author Mike Walsh <mike_walsh@mentor.com>
 * @access public
 * @see GlobalAccountsInfoTable
 */
class GlobalAccountsLocationProfile extends GlobalAccountsLocationMap
{
    /**
     * Build the location profile as an InfoTable
     *
     * @return GlobalAccountsInfoTable
     * @see InfoTable
     */
    function profileLocation($title = null, $width = "700px")
    {
        if (is_null($this->getLocationId()))
        {
            $profile = new GlobalAccountsInfoTable("Location Profile", $width) ;
            $profile->add_row("No customer location profile data.") ;
        }
        else
        {
            if (is_null($title)) $title = $this->getLocationName() ;

            $profile = new GlobalAccountsInfoTable($title, $width) ;

            $profile->set_alt_color_flag(true) ;
            $profile->set_show_cellborders(true) ;

            $customer = new GlobalAccountsCustomer() ;
            $customer->loadCustomerByCustomerId($this->getCustomerId()) ;

            $profile->add_row("Customer", $customer->getCustomerName()) ;
            $profile->add_row("Location Name", $this->getLocationName()) ;
            $profile->add_row("WTO Region", $this->getWTORegion()) ;

            $address = "" ;

            if ($this->getStreet1() != "")
                $address .= $this->getStreet1() ;
            if ($this->getStreet2() != "")
                $address .= "<br/>" . $this->getStreet2() ;
            if ($this->getStreet3() != "")
                $address .= "<br/>" . $this->getStreet3() ;

            $address .= (($address == "") ? "" : "<br/>") . $this->getCity() ;
            $address .= ", " . $this->getStateOrProvince() ;
            $address .= "<br/>" . $this->getPostalCode() ;
            $address .= "<br/>" . $this->getCountry() ;

            $profile->add_row("Address", $address) ;

            $profile->add_row("Primary Phone", $this->getPrimaryPhone()) ;
            $profile->add_row("Secondary Phone", $this->getSecondaryPhone()) ;
            $profile->add_row("Map", $this->mapLocation()) ;
        }

        return $profile ;
    }
}

/**
 * Extended GUIDataList Class for presenting GlobalAccounts
 * information extracted from the database.
 *
 * @author Mike Walsh <mike_walsh@mentor.com>
 * @access public
 * @see GlobalAccountsGUIDataList
 */
class GlobalAccountsLocationsGUIDataList extends GlobalAccountsGUIDataList
{
    /**
     * Property to store the requested action
     */
    var $__action ;

    /**
     * Property to store the possible actions - used to build action buttons
     */
    var $__normal_actions = array(
         "profile" => WPGA_ACTION_PROFILE
        ,"add" => WPGA_ACTION_ADD
        ,"update" => WPGA_ACTION_UPDATE
        ,"frp" => WPGA_ACTION_FRP
        ,"map_location" => WPGA_ACTION_MAP_LOCATION
    ) ;

    /**
     * Property to store the possible actions - used to build action buttons
     */
    var $__empty_actions = array(
         "add" => WPGA_ACTION_ADD
    ) ;

    /**
     * The constructor
     *
     * @param string - the title of the data list
     * @param string - the overall width
     * @param string - the column to use as the default sorting order
     * @param boolean - sort the default column in reverse order?
     * @param string - columns to query return from database
     * @param string - tables to query from database
     * @param string - where clause for database query
     */
    function GlobalAccountsLocationsGUIDataList($title, $width = "100%",
        $default_orderby='', $default_reverseorder=FALSE,
        $columns = WPGA_LOCATIONS_COLUMNS,
        $tables = WPGA_LOCATIONS_TABLES,
        $where_clause = WPGA_LOCATIONS_WHERE_CLAUSE)
    {
        //  Set the properties for this child class
        //$this->setColumns($columns) ;
        //$this->setTables($tables) ;
        //$this->setWhereClause($where_clause) ;

        //  Call the constructor of the parent class
        $this->GlobalAccountsGUIDataList($title, $width,
            $default_orderby, $default_reverseorder,
            $columns, $tables, $where_clause) ;
    }

    /**
     * This method is used to setup the options
	 * for the DataList object's display
	 * Which columns to show, their respective 
	 * source column name, width, etc. etc.
	 *
     * The constructor automatically calls 
	 * this function.
	 *
     */
	function user_setup($actiontype = 'radio')
    {
		//  Add the columns in the display that you want to view.  The API is :
		//  Title, width, DB column name, field SORTABLE?, field SEARCHABLE?, align
		$this->add_header_item("Customer",
	       	    "200", "customerid", SORTABLE, SEARCHABLE, "left") ;

		$this->add_header_item("Location",
	       	    "200", "locationname", SORTABLE, SEARCHABLE, "left") ;

		$this->add_header_item("WTO Region",
	       	    "200", "wtoregion", SORTABLE, SEARCHABLE, "left") ;

	  	$this->add_header_item("City",
	         	    "150", "city", SORTABLE, SEARCHABLE, "left") ;

        $label = get_option(WPGA_OPTION_USER_STATE_OR_PROVINCE_LABEL) ;
	  	$this->add_header_item($label,
	         	    "150", "stateorprovince", SORTABLE, SEARCHABLE, "left") ;

	  	$this->add_header_item("Country",
	         	    "150", "country", SORTABLE, SEARCHABLE, "left") ;

        //  Construct the DB query
        $this->_datasource->setup_db_options($this->getColumns(),
            $this->getTables(), $this->getWhereClause()) ;

        //  turn on the 'collapsable' search block.
        //  The word 'Search' in the output will be clickable,
        //  and hide/show the search box.

        $this->_collapsable_search = true ;

        //  lets add an action column of checkboxes,
        //  and allow us to save the checked items between pages.
	    //  Use the last field for the check box action.

        //  The unique item is the second column.

	    $this->add_action_column($actiontype, 'FIRST', "locationid") ;

        //  we have to be in POST mode, or we could run out
        //  of space in the http request with the saved
        //  checkbox items
        
        $this->set_form_method('POST') ;

        //  set the flag to save the checked items
        //  between pages.
        
        $this->save_checked_items(true) ;
	}

    /**
     * This is the basic function for letting us
     * do a mapping between the column name in
     * the header, to the value found in the DataListSource.
     *
     * NOTE: this function can be overridden so that you can
     *       return whatever you want for any given column.  
     *
     * @param array - $row_data - the entire data for the row
     * @param string - $col_name - the name of the column header
     *                             for this row to render.
     * @return mixed - either a HTMLTag object, or raw text.
     */
	function build_column_item($row_data, $col_name)
    {
		switch ($col_name)
        {
                /*
            case "Updated" :
                $obj = strftime("%Y-%m-%d @ %T", (int)$row_data["updated"]) ;
                break ;
                */

            case "Customer" :
                $customer = new GlobalAccountsCustomer() ;
                $customer->loadCustomerByCustomerId($row_data["customerid"]) ;
                $obj = $customer->getCustomerName() ;
                break ;

            case "Web Site" :
                if ($row_data["website"] == WPGA_NULL_STRING)
                {
                    $customer = new GlobalAccountsCustomer() ;
                    $customer->loadCustomerById($row_data["customerid"]) ;
                    $obj = html_a($customer->getWebSite(), $customer->getWebSite()) ;
                }
                else
                {
                    $obj = html_a($row_data["website"], $row_data["website"]) ;
                }

                break ;

		    default:
			    $obj = DefaultGUIDataList::build_column_item($row_data, $col_name);
			    break;
		}
		return $obj;
    }

    /**
     * Action Bar - build a set of Action Bar buttons
     *
     * @return container - container holding action bar content
     */
    function actionbar_cell()
    {
        //  Add an ActionBar button based on the action the page
        //  was called with.

        $c = container() ;

        foreach($this->__normal_actions as $key => $button)
        {
            //$b = $this->action_button($button, $_SERVER['REQUEST_URI']) ;

            /**
             * The above line is commented out because it doesn't work
             * under Safari.  For some reason Safari doesn't pass the value
             * argument of the submit button via Javascript.  The below line
             * will work as long as the intended target is the same as
             * what is specified in the FORM's action tag.
             */

            $b = $this->action_button($button) ;
            $b->set_tag_attribute("type", "submit") ;
            $c->add($b) ;
        }

        return $c ;
    }

    /**
     * Action Bar - build a set of Action Bar buttons
     *
     * @return container - container holding action bar content
     */
    function empty_datalist_actionbar_cell()
    {
        //  Add an ActionBar button based on the action the page
        //  was called with.

        $c = container() ;

        foreach($this->__empty_actions as $key => $button)
        {
            //$b = $this->action_button($button, $_SERVER['REQUEST_URI']) ;

            /**
             * The above line is commented out because it doesn't work
             * under Safari.  For some reason Safari doesn't pass the value
             * argument of the submit button via Javascript.  The below line
             * will work as long as the intended target is the same as
             * what is specified in the FORM's action tag.
             */

            $b = $this->action_button($button) ;
            $b->set_tag_attribute("type", "submit") ;
            $c->add($b) ;
        }

        return $c ;
    }
}

/**
 * GUIDataList class for performaing administration tasks
 * on the various customers.
 *
 * @author Mike Walsh <mike_walsh@mentor.com>
 * @access public
 * @see GlobalAccountsLocationsGUIDataList
 */
class GlobalAccountsLocationsAdminGUIDataList extends GlobalAccountsLocationsGUIDataList
{
    /**
     * Property to store the possible actions - used to build action buttons
     */
    var $__normal_actions = array(
         "profile" => WPGA_ACTION_PROFILE
        ,"add" => WPGA_ACTION_ADD
        ,"update" => WPGA_ACTION_UPDATE
        ,"frp" => WPGA_ACTION_FRP
        ,"map_location" => WPGA_ACTION_MAP_LOCATION
        //,"delete" => WPGA_ACTION_DELETE
    ) ;

    /**
     * This method is used to setup the options
	 * for the DataList object's display
	 * Which columns to show, their respective 
	 * source column name, width, etc. etc.
	 *
     * The constructor automatically calls 
	 * this function.
	 *
     */
    function user_setup()
    {
        //  make use of the parent class user_setup()
        //  function to set up the display of the fields

        parent::user_setup() ;

		$this->add_header_item("Id",
	       	    "50", "locationid", SORTABLE, SEARCHABLE, "left") ;

    }
}

/**
 * Extended GUIDataList Class for presenting GlobalAccounts
 * information extracted from the database.
 *
 * @author Mike Walsh <mike_walsh@mentor.com>
 * @access public
 * @see GlobalAccountsGUIDataList
 */
class GlobalAccountsMapsGUIDataList extends GlobalAccountsLocationsGUIDataList
{
    /**
     * Property to store the possible actions - used to build action buttons
     */
    var $__normal_actions = array(
         "map_locations" => WPGA_ACTION_MAP_LOCATIONS
        ,"map_frp" => WPGA_ACTION_MAP_FRP
    ) ;

    /**
     * This method is used to setup the options
	 * for the DataList object's display
	 * Which columns to show, their respective 
	 * source column name, width, etc. etc.
	 *
     * The constructor automatically calls 
	 * this function.
	 *
     */
	function user_setup()
    {
        parent::user_setup('checkbox') ;
    }
}
?>
