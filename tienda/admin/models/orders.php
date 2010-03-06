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

JLoader::import( 'com_tienda.models._base', JPATH_ADMINISTRATOR.DS.'components' );

class TiendaModelOrders extends TiendaModelBase
{
    protected function _buildQueryWhere(&$query)
    {
        $filter     = $this->getState('filter');
       	$orderstate	= $this->getState('filter_orderstate');
       	$filter_userid	= $this->getState('filter_userid');
        $filter_id_from	= $this->getState('filter_id_from');
        $filter_id_to	= $this->getState('filter_id_to');
       	$filter_user	= $this->getState('filter_user');
        $filter_date_from	= $this->getState('filter_date_from');
        $filter_date_to		= $this->getState('filter_date_to');
       	$filter_datetype	= $this->getState('filter_datetype');
        $filter_total_from = $this->getState('filter_total_from');
        $filter_total_to   = $this->getState('filter_total_to');

       	if ($filter)
       	{
			$key	= $this->_db->Quote('%'.$this->_db->getEscaped( trim( strtolower( $filter ) ) ).'%');

			$where = array();

			$where[] = 'LOWER(tbl.order_id) LIKE '.$key;
			$where[] = 'LOWER(ui.first_name) LIKE '.$key;
			$where[] = 'LOWER(ui.last_name) LIKE '.$key;
			$where[] = 'LOWER(u.email) LIKE '.$key;
			$where[] = 'LOWER(u.username) LIKE '.$key;
			$where[] = 'LOWER(u.name) LIKE '.$key;

			$query->where('('.implode(' OR ', $where).')');
       	}
        if (strlen($filter_id_from))
        {
			if (strlen($filter_id_to))
        	{
        		$query->where('tbl.order_id >= '.(int) $filter_id_from);
        	}
        		else
        	{
        		$query->where('tbl.order_id = '.(int) $filter_id_from);
        	}
       	}
		if (strlen($filter_id_to))
        {
        	$query->where('tbl.order_id <= '.(int) $filter_id_to);
       	}
    	if (strlen($filter_user))
        {
			$key	= $this->_db->Quote('%'.$this->_db->getEscaped( trim( strtolower( $filter_user ) ) ).'%');

			$where = array();
			$where[] = 'LOWER(ui.first_name) LIKE '.$key;
			$where[] = 'LOWER(ui.last_name) LIKE '.$key;
			$where[] = 'LOWER(u.email) LIKE '.$key;
			$where[] = 'LOWER(u.username) LIKE '.$key;
			$where[] = 'LOWER(u.name) LIKE '.$key;
			$where[] = 'LOWER(u.id) LIKE '.$key;
			$query->where('('.implode(' OR ', $where).')');
       	}
       	
        if (strlen($orderstate))
        {
        	$query->where('tbl.order_state_id = '.$orderstate);
       	}
        if (strlen($filter_userid))
        {
            $query->where('tbl.user_id = '.$filter_userid);
        }

        if (strlen($filter_date_from))
        {
        	switch ($filter_datetype)
        	{
        		case "shipped":
        			$query->where("tbl.shipped_date >= '".$filter_date_from."'");
        		  break;
        		case "modified":
        			$query->where("tbl.modified_date >= '".$filter_date_from."'");
        		  break;
        		case "created":
        		default:
        			$query->where("tbl.created_date >= '".$filter_date_from."'");
        		  break;
        	}
       	}
		if (strlen($filter_date_to))
        {
			switch ($filter_datetype)
        	{
        		case "shipped":
        			$query->where("tbl.shipped_date <= '".$filter_date_to."'");
        		  break;
        		case "modified":
        			$query->where("tbl.modified_date <= '".$filter_date_to."'");
        		  break;
        		case "created":
        		default:
        			$query->where("tbl.created_date <= '".$filter_date_to."'");
        		  break;
        	}
       	}
       	
        if (strlen($filter_total_from))
        {
            if (strlen($filter_total_to))
            {
                $query->where('tbl.order_total >= '.(int) $filter_total_from);
            }
                else
            {
                $query->where('tbl.order_total = '.(int) $filter_total_from);
            }
        }
        if (strlen($filter_total_to))
        {
            $query->where('tbl.order_total <= '.(int) $filter_total_to);
        }
    }
    
	protected function _buildQueryFields(&$query)
	{
		$field = array();

		$field[] = " tbl.* ";
		$field[] = " u.name AS user_name ";
		$field[] = " u.username AS user_username ";	
		$field[] = " u.email ";
		$field[] = " ui.phone_1 ";
		$field[] = " ui.fax ";
		$field[] = " ui.first_name as first_name";
		$field[] = " ui.last_name as last_name";
		$field[] = " s.* ";
		$field[] = " shipping.shipping_method_name ";
        $field[] = " oi.billing_company ";
        $field[] = " oi.billing_last_name ";
        $field[] = " oi.billing_first_name ";
        $field[] = " oi.billing_middle_name ";
        $field[] = " oi.billing_phone_1 ";
        $field[] = " oi.billing_phone_2 ";
        $field[] = " oi.billing_fax ";
        $field[] = " oi.billing_address_1 ";
        $field[] = " oi.billing_address_2 ";
        $field[] = " oi.billing_city ";
        $field[] = " oi.billing_zone_name ";
        $field[] = " oi.billing_country_name ";
        $field[] = " oi.billing_postal_code ";
        $field[] = " oi.shipping_company ";
        $field[] = " oi.shipping_last_name ";
        $field[] = " oi.shipping_first_name ";
        $field[] = " oi.shipping_middle_name ";
        $field[] = " oi.shipping_phone_1 ";
        $field[] = " oi.shipping_phone_2 ";
        $field[] = " oi.shipping_fax ";        
        $field[] = " oi.shipping_address_1 ";
        $field[] = " oi.shipping_address_2 ";
        $field[] = " oi.shipping_city ";
        $field[] = " oi.shipping_zone_name ";
        $field[] = " oi.shipping_country_name ";
        $field[] = " oi.shipping_postal_code ";

        $field[] = "
            (
            SELECT 
                COUNT(*)
            FROM
                #__tienda_orderitems AS items 
            WHERE 
                items.order_id = tbl.order_id 
            ) 
            AS items_count 
        ";

		$query->select( $field );
	}
	
	protected function _buildQueryJoins(&$query)
	{
		$query->join('LEFT', '#__tienda_userinfo AS ui ON ui.user_id = tbl.user_id');
		$query->join('LEFT', '#__users AS u ON u.id = tbl.user_id');
		$query->join('LEFT', '#__tienda_orderstates AS s ON s.order_state_id = tbl.order_state_id');
        $query->join('LEFT', '#__tienda_orderinfo AS oi ON tbl.order_id = oi.order_id');
        $query->join('LEFT', '#__tienda_shippingmethods AS shipping ON shipping.shipping_method_id = tbl.shipping_method_id');   
	}

    protected function _buildQueryOrder(&$query)
    {
		$order      = $this->_db->getEscaped( $this->getState('order') );
       	$direction  = $this->_db->getEscaped( strtoupper($this->getState('direction') ) );
		if ($order)
		{
       		$query->order("$order $direction");
       	}
       	else
       	{
            $query->order("tbl.order_id ASC");
       	}
    }	
	
	public function getList()
	{
		JLoader::import( 'com_tienda.helpers._base', JPATH_ADMINISTRATOR.DS.'components' );
		$list = parent::getList();
		
		foreach(@$list as $item)
		{
			$item->link = 'index.php?option=com_tienda&controller=orders&view=orders&task=edit&id='.$item->order_id;
			$item->link_view = 'index.php?option=com_tienda&view=orders&task=view&id='.$item->order_id;
			
			// retrieve the order's currency
			// this loads the currency, using the FK is it is the same of the
    		// currency used in the order, or the JParameter currency of the order otherwise
    		$order_currency = new JParameter($item->order_currency);
    		$order_currency = $order_currency->toArray();
    		
    		JModel::addIncludePath( JPATH_ADMINISTRATOR.DS.'components'.DS.'com_tienda'.DS.'models' );
    		$cmodel = JModel::getInstance( 'Currencies', 'TiendaModel' );
            $cmodel->setState('filter_id_from', $item->currency_id);
            $cmodel->setState('filter_id_to', $item->currency_id);
            $item->currency = $cmodel->getItem();
            
    		// if the order currency is not the same as it was during the order
    		if (!empty($item->currency) && !empty($order_currency['currency_code']) && $item->currency->currency_code != $order_currency['currency_code'])
    		{
    			// overwrite it with the original one
    			foreach(@$order_currency as $k => $v)
    			{
    				$item->currency->$k = $v;
    			}
    		}
		}
		return $list;
	}
	
	public function getItem()
	{
        JLoader::import( 'com_tienda.helpers._base', JPATH_ADMINISTRATOR.DS.'components' );
        JModel::addIncludePath( JPATH_ADMINISTRATOR.DS.'components'.DS.'com_tienda'.DS.'models' );
		
		if ($item = parent::getItem())
		{
	        //retrieve the order's items
	        $model = JModel::getInstance( 'OrderItems', 'TiendaModel' );
	        $model->setState( 'filter_orderid', $item->order_id);
	        $model->setState( 'order', 'tbl.orderitem_name' );
	        $model->setState( 'direction', 'ASC' );
	        $item->orderitems = $model->getList();
	        foreach ($item->orderitems as $orderitem)
	        {
	        	$model = JModel::getInstance( 'OrderItemAttributes', 'TiendaModel' );
	        	$model->setState( 'filter_orderitemid', $orderitem->orderitem_id);
	        	$attributes = $model->getList();
	            $attributes_names = array();
	            foreach ($attributes as $attribute)
	            {
	                // store a csv of the attrib names
	                $attributes_names[] = JText::_( $attribute->orderitemattribute_name ); 
	            }
	            $orderitem->attributes_names = implode(', ', $attributes_names);
	            
	            // adjust the price
	            $orderitem->orderitem_price = $orderitem->orderitem_price + floatval($orderitem->orderitem_attributes_price);
	        }
	        
	        
            //retrieve the order's history
            $model = JModel::getInstance( 'OrderHistory', 'TiendaModel' );
            $model->setState( 'filter_orderid', $item->order_id);
            $model->setState( 'order', 'tbl.date_added' );
            $model->setState( 'direction', 'ASC' );
            $item->orderhistory = $model->getList();
            $item->link_view = 'index.php?option=com_tienda&view=orders&task=view&id='.$item->order_id;
            
            //retrieve the order's payments
            $model = JModel::getInstance( 'OrderPayments', 'TiendaModel' );
            $model->setState( 'filter_orderid', $item->order_id);
            $model->setState( 'order', 'tbl.created_date' );
            $model->setState( 'direction', 'ASC' );
            $item->orderpayments = $model->getList();
            
            // retrieve the order's currency
			// this loads the currency, using the FK is it is the same of the
    		// currency used in the order, or the JParameter currency of the order otherwise
    		$order_currency = new JParameter($item->order_currency);
    		$order_currency = $order_currency->toArray();
    		
    		$model = JModel::getInstance( 'Currencies', 'TiendaModel' );
            $model->setState('filter_id_from', $item->currency_id);
            $model->setState('filter_id_to', $item->currency_id);
            $item->currency = $model->getItem();
            
    		// if the order currency is not the same as it was during the order
    		if (!empty($item->currency) && !empty($order_currency['currency_code']) && $item->currency->currency_code != $order_currency['currency_code'])
    		{
    			// overwrite it with the original one
    			foreach(@$order_currency as $k => $v){
    				$item->currency->$k = $v;
    			}
    		}
		}
        return $item;
	}	
}