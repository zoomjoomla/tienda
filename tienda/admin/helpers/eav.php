<?php
/**
 * @package Tienda
 * @author  Dioscouri Design
 * @link    http://www.dioscouri.com
 * @copyright Copyright (C) 2007 Dioscouri Design. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
*/

/** ensure this file is being included by a parent file */
defined('_JEXEC') or die('Restricted access');

if ( !class_exists('Tienda') ) 
    JLoader::register( "Tienda", JPATH_ADMINISTRATOR.DS."components".DS."com_tienda".DS."defines.php" );

Tienda::load( "TiendaHelperBase", 'helpers._base' );

class TiendaHelperEav extends TiendaHelperBase 
{
	/**
	 * Get the Eav Attributes for a particular entity
	 * @param unknown_type $entity
	 * @param unknown_type $id
	 */
    function getAttributes( $entity, $id )
    {
        JModel::addIncludePath( JPATH_ADMINISTRATOR.DS.'components'.DS.'com_tienda'.DS.'models' );
    	$model = JModel::getInstance('EavAttributes', 'TiendaModel');
    	$model->setState('filter_entitytype', $entity);
    	$model->setState('filter_entityid', $id);
    	$model->setState('filter_published', '1');
    	
    	$eavs = $model->getList();
    	
    	return $eavs;
    }
    
    /**
     * Show the correct edit field based on the eav type
     * @param EavAttribute $eav
     * @param unknown_type $value
     */
    function editForm($eav, $value = null)
    {
    	// Type of the field
    	switch($eav->eavattribute_type)
    	{
    		case "bool":
    			Tienda::load('TiendaSelect', 'library.select');
    			return TiendaSelect::booleans($value, $eav->eavattribute_alias);
    			break;
    		case "datetime":
    			return JHTML::calendar( $value, $eav->eavattribute_alias, "eavattribute_alias", "%Y-%m-%d %H:%M:%p" );
    			break;
    		case "text":
    			$editor = &JFactory::getEditor();
    			return $editor->display($eav->eavattribute_alias, $value, '300', '200', '50', '20');
    			break;
    		case "decimal":
    		case "int":	
    		case "varchar":
    		default:
    			return '<input type="text" name="'.$eav->eavattribute_alias.'" id="'.$eav->eavattribute_alias.'" value="'.$value.'" />';
    			break;
    	}
    	
    	return '';
    }
    
    /**
     * Show the field based on the eav type
     * @param EavAttribute $eav
     * @param unknown_type $value
     */
    function showValue($eav, $value = null)
    {
    	// Type of the field
    	switch($eav->eavattribute_type)
    	{
    		case "bool":
    			if($value)
    			{
    				echo JText::_('Yes');
    			}
    			else
    			{
    				echo JText::_('No');
    			}
    			break;
    		case "datetime":
    			return JHTML::date($value, TiendaConfig::getInstance()->get('date_format'));
    			break;
    		case "text":
    			$dispatcher =& JDispatcher::getInstance();
    			$item = new JObject();
		        $item->text = &$value;  
		        $item->params = array();
		        JPluginHelper::importPlugin('content'); 
		        $dispatcher->trigger('onPrepareContent', array (& $item, & $item->params, 0));
		        return $value;
    		case "decimal":
    		case "int":	
    			return self::number($value);
    		case "varchar":
    		default:
    			return $value;
    			break;
    	}
    	
    	return '';
    }
    
    /**
     * Show the edit form or the field value based on the eav status
     * @param EavAttribute $eav
     * @param unknown_type $value
     */
    function showField($eav, $value = null)
    {
    	$gid = JFactory::getUser()->gid;
    	if($gid >= 23)
    	{
    		$isAdmin = true;
    	}
    	else
    	{
    		$isAdmin = false;
    	}
    	
    	switch($eav->editable_by)
    	{
    		// No one
    		case "0":
    			return self::showValue($eav, $value);
    			break;
    		// Admin
    		case "1":
    			if($isAdmin)
    			{
    				return self::editForm($eav, $value);
    			}
    			else
    			{
    				return self::showValue($eav, $value);
    			}
    			break;
    		case "2":
    		default:
    			return self::editForm($eav, $value);
    			break;
    	}	
    	
    }
}