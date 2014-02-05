<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
/**
 *
 * $Id$
 *
 * Table classes.  These classes manage the
 * entry and display of the various tables used
 * by the GlobalAccounts web site.
 *
 * (c) 2005 by Mike Walsh for GlobalAccounts.
 *
 * @author Mike Walsh <mike_walsh@mentor.com>
 * @package GlobalAccounts
 * @subpackage Tables
 * @version $Revision$
 * @lastmodified $Date$
 * @lastmodified $Author$
 *
 */

/**
 * GlobalAccountsInfoTable Class - child of InfoTable
 * This class extends the InfoTable class and automatically
 * handles empty strings in tables such that tables are not
 * rendered missing cell borders.
 *
 * @author Mike Walsh <mike_walsh@mentor.com>
 * @access public
 * @see InfoTable
 */
class GlobalAccountsInfoTable extends InfoTable
{
    /**
     * Automatically add "&nbsp;" characters to empty cells?
     */
    var $_add_nonbreaking_space = TRUE ;

    /**
     * This method is used to set the flag to
     * automatically add nonbreaking space chars
     * to empty cells.
     * 
     * @param boolean
     * @return none
     */
    function set_add_nonbreaking_space($flag = true)
    {
        $this->_add_non_breaking_space = $flag ;
    }

    /**
     * This function is used to add a row to the table,
     * it overloads the method in the parent class.
     *
     * @param mixed - n number of items to push
     */
    function add_row()
    {
        $argc = func_num_args();
        $args = array();

        for ($i = 0 ; $i < $argc ; $i++)
        {
            $arg = func_get_arg($i) ;
            $args[] = (($arg == "") && $this->_add_nonbreaking_space) ? _HTML_SPACE : $arg ;
        }

        $this->data[] = $args ;
    }
}

/**
 * GlobalAccountsNavTable Class - child of NavTable
 *
 * This class extends the NavTable class and allows control
 * over the character used as a bullet when rendering the NavTable.
 *
 * @author Mike Walsh <mike_walsh@mentor.com>
 * @access public
 * @see NavTable
 */
class GlobalAccountsNavTable extends NavTable
{
    /**
     * Property for storing "bullet"
     */
    var $_bullet = "&bull;" ;

    /**
     * Set the bullet property and override use
     * of the default bullet character.
     *
     * @param string - bullet text (can be HTML)
     */
    function set_bullet($bullet = "&bull;")
    {
        $this->_bullet = $bullet ;
    }

  /**
   * render a url row.
   * @param array() - the item to render.
   */
  function _render_url( $val ) {
      $tr = parent::_render_url($val) ;
      $bullet = $this->_bullet . "&nbsp;&nbsp;";

      //  Replace the default NavTable bullet with user supplied
      $tr->_content[0]->_content[0] = $bullet ;

      return $tr;
  }
}
?>
