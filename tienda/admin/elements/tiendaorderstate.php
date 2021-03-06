<?php
/**
 * @version	1.5
 * @package	Tienda
 * @author 	Dioscouri Design
 * @link 	http://www.dioscouri.com
 * @copyright Copyright (C) 2007 Dioscouri Design. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
*/

/** ensure this file is being included by a parent file */
defined('_JEXEC') or die('Restricted access');

if ( !class_exists('Tienda') ) 
    JLoader::register( "Tienda", JPATH_ADMINISTRATOR."/components/com_tienda/defines.php" );



if(!class_exists('JFakeElementBase')) {
	if(version_compare(JVERSION,'1.6.0','ge')) {
		class JFakeElementBase extends JFormField {
			// This line is required to keep Joomla! 1.6/1.7 from complaining
			public function getInput() {
			}
		}
	} else {
		class JFakeElementBase extends JElement {}
	}
}

class JFakeElementTiendaOrderState extends JFakeElementBase
{

		
	var	$_name = 'TiendaOrderState';
	
	public function getInput() 
	{
		$select = Tienda::getClass( 'TiendaSelect', 'library.select' );
	    $list = $select->orderstate($this->value, $this->options['control'].$this->name, '', $this->options['control'].$this->name, false, false, 'Select Order State', '', true );
		return $list;
	}
	
	
	public function fetchElement($name, $value, &$node, $control_name)
	{
	    $select = Tienda::getClass( 'TiendaSelect', 'library.select' );
	    $list = $select->orderstate($value, $control_name.'['.$name.']', '', $control_name.$name, false, false, 'Select Order State', '', true );
		return $list;
	}
	
	
	
}

if(version_compare(JVERSION,'1.6.0','ge')) {
	class JFormFieldTiendaOrderState extends JFakeElementTiendaOrderState {}
} else {
	class JElementTiendaOrderState extends JFakeElementTiendaOrderState {}
}


?>