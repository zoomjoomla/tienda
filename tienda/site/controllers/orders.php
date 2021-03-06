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
defined( '_JEXEC' ) or die( 'Restricted access' );

class TiendaControllerOrders extends TiendaController
{
	/**
	 * constructor
	 */
	function __construct()
	{		
		parent::__construct();
		$this->set('suffix', 'orders');
		$this->registerTask( 'print', 'printOrder' );
	}
	
    /**
     * 
     * @return unknown_type
     */
    function _setModelState()
    {
        $state = parent::_setModelState();      
        $app = JFactory::getApplication();
        $model = $this->getModel( $this->get('suffix') );
        $ns = $this->getNamespace();
        
        $config = Tienda::getInstance();
        // adjust offset for when filter has changed
        if (
            $app->getUserState( $ns.'orderstate' ) != $app->getUserStateFromRequest($ns.'orderstate', 'filter_orderstate', '', '') 
        )
        {
            $state['limitstart'] = '0';
        }

        $state['order']     = $app->getUserStateFromRequest($ns.'.filter_order', 'filter_order', 'tbl.created_date', 'cmd');
        $state['direction'] = $app->getUserStateFromRequest($ns.'.filter_direction', 'filter_direction', 'DESC', 'word');
        
        $state['filter_orderstate'] = $app->getUserStateFromRequest($ns.'orderstate', 'filter_orderstate', '', 'string');
        $state['filter_id_from']    = $app->getUserStateFromRequest($ns.'id_from', 'filter_id_from', '', 'int');
        $state['filter_id_to']      = $app->getUserStateFromRequest($ns.'id_to', 'filter_id_to', '', 'int');
        
        $state['filter_userid']     = JFactory::getUser()->id;
        $filter_userid = $app->getUserStateFromRequest($ns.'userid', 'filter_userid', JFactory::getUser()->id, 'int');
        
        $state['filter_id_from']    = $app->getUserStateFromRequest($ns.'id_from', 'filter_id_from', '', 'int');
        $state['filter_id_to']      = $app->getUserStateFromRequest($ns.'id_to', 'filter_id_to', '', 'int');
        $state['filter_total']      = $app->getUserStateFromRequest($ns.'total', 'filter_total', '', 'float');
        
        $state['filter_date_from']  = $app->getUserStateFromRequest($ns.'date_from', 'filter_date_from', '', '');
        $state['filter_date_to']    = $app->getUserStateFromRequest($ns.'date_to', 'filter_date_to', '', '');
        $state['filter_datetype']   = $app->getUserStateFromRequest($ns.'datetype', 'filter_datetype', '', '');
        
        
        foreach (@$state as $key=>$value)
        {
            $model->setState( $key, $value );   
        }
        return $state;
    }
    
    /**
     * (non-PHPdoc)
     * @see tienda/admin/TiendaController#display($cachable)
     */
    function display($cachable = false, $urlparams = '')
    {
        if (empty(JFactory::getUser()->id))
        {
            $url = JRoute::_( "index.php?option=com_tienda&view=orders" );
            Tienda::load( "TiendaHelperUser", 'helpers.user' );
            $redirect = JRoute::_( TiendaHelperUser::getUserLoginUrl( $url ), false );
            JFactory::getApplication()->redirect( $redirect );
            return;
        }

        $model  = $this->getModel( $this->get('suffix') );
        $this-> _setModelState();
        $config = Tienda::getInstance();
        $model->setState('filter_orderstates', $config->get('orderstates_csv', '2, 3, 5, 17') );
        $list = $model->getList();
        
        $view = $this->getView( 'orders', 'html' );
        $view->set( '_controller', 'orders' );
        $view->set( '_view', 'orders' );
        $view->set( '_doTask', true);
        $view->set( 'hidemenu', false);
        $view->setModel( $model, true );
        $view->setLayout( 'view' );
        JRequest::setVar( 'view', $this->get('suffix') );
        JRequest::setVar( 'layout', 'default' );
        parent::display( $cachable, $urlparams );
    }
    
    /**
     * (non-PHPdoc)
     * @see tienda/site/TiendaController#view()
     */
    function view() 
    {
    	// if the user cannot view order, fail
        $model  = $this->getModel( $this->get('suffix') );
    	$model->getId();
        $order = $model->getTable( 'orders' );
        $order->load( $model->getId() );        
        $orderitems = $order->getItems();
        $row = $model->getItem();
        $row->order_ships = $order->order_ships;
    	                
        if( $row->user_id > 0 ) // orders of users with joomla accounts
        {
	        $user_id = JFactory::getUser()->id;
	        if (empty($user_id) || $user_id != $row->user_id)
	        {
	        	$this->messagetype  = 'notice';
	        	$this->message      = JText::_('COM_TIENDA_INVALID_ORDER');
	            $redirect = "index.php?option=com_tienda&view=".$this->get('suffix');
	            $redirect = JRoute::_( $redirect, false );
	            $this->setRedirect( $redirect, $this->message, $this->messagetype );
	            return;
	        }
        }
        else // guest user orders
        {
        	$hash = JRequest::getString( 'h', '' );
        	if( $row->order_hash != $hash )
        	{
        	    $this->messagetype  = 'notice';
        	    $this->message      = JText::_('COM_TIENDA_INVALID_ORDER');
        	    $redirect = "index.php?option=com_tienda&view=".$this->get('suffix');
        	    $redirect = JRoute::_( $redirect, false );
        	    $this->setRedirect( $redirect, $this->message, $this->messagetype );
        	    return;
        	}
        }
        
        Tienda::load( 'TiendaUrl', 'library.url' );
        
        $view = $this->getView( 'orders', 'html' );
        $view->set( '_controller', 'orders' );
        $view->set( '_view', 'orders' );
        $view->set( '_doTask', true);
        $view->set( 'hidemenu', false);
        $view->setModel( $model, true );
        $config = Tienda::getInstance();
        $show_tax = $config->get('display_prices_with_tax');
        if( $show_tax )
        	$order->order_subtotal += $order->order_tax;
        
        //START onDisplayOrderItem: trigger plugins for extra orderitem information
        if (!empty($orderitems))
        {
					Tienda::load( 'TiendaHelperOrder', 'helpers.order' );
        	$onDisplayOrderItem = TiendaHelperOrder::onDisplayOrderItems($orderitems);
        		
	        $view->assign( 'onDisplayOrderItem', $onDisplayOrderItem );
        }
        //END onDisplayOrderItem
        foreach( $orderitems as $item )
        {
        	if( $show_tax )
        		$item->orderitem_price += $item->orderitem_tax / $item->orderitem_quantity;
        }

        $view->assign( 'show_tax', $show_tax );
        $view->assign( 'using_default_geozone', false );
              
        $view->assign( 'order', $order );
        $view->setLayout( 'view' );
        $view->display();
        $this->footer();
    }
    
    /**
     * (non-PHPdoc)
     * @see tienda/site/TiendaController#view()
     */
    function printOrder() 
    {
        // if the user cannot view order, fail
        $model  = $this->getModel( $this->get('suffix') );
        $model->getId();
        $order = $model->getTable( 'orders' );
        $order->load( $model->getId() );        
        $row = $model->getItem();
        $row->order_ships = $order->order_ships;
        $orderitems = $order->getItems();
        
        $user_id = JFactory::getUser()->id;
        if( $row->user_id > 0 ) // orders of users with joomla accounts
        {
	        if (empty($user_id) || $user_id != $row->user_id)
	        {
	            $this->messagetype  = 'notice';
	            $this->message      = JText::_('COM_TIENDA_INVALID_ORDER');
	            $redirect = "index.php?option=com_tienda&view=".$this->get('suffix');
	            $redirect = JRoute::_( $redirect, false );
	            $this->setRedirect( $redirect, $this->message, $this->messagetype );
	            return;
	        }
        }
        else // guest user orders
        {
        	$hash = JRequest::getString( 'h', '' );
        	if( $row->order_hash != $hash )
        	{
        	    $this->messagetype  = 'notice';
        	    $this->message      = JText::_('COM_TIENDA_INVALID_ORDER');
        	    $redirect = "index.php?option=com_tienda&view=".$this->get('suffix');
        	    $redirect = JRoute::_( $redirect, false );
        	    $this->setRedirect( $redirect, $this->message, $this->messagetype );
        	    return;
        	}
        }
        Tienda::load( 'TiendaUrl', 'library.url' );
        
        $view = $this->getView( 'orders', 'html' );
        $view->set( '_controller', 'orders' );
        $view->set( '_view', 'orders' );
        $view->set( '_doTask', true);
        $view->set( 'hidemenu', true);
        $view->setModel( $model, true );
        $config = Tienda::getInstance();
        $show_tax = $config->get('display_prices_with_tax');
        if( $show_tax )
        	$order->order_subtotal += $order->order_tax;
        
        //START onDisplayOrderItem: trigger plugins for extra orderitem information
        if (!empty($orderitems))
        {
			Tienda::load( 'TiendaHelperOrder', 'helpers.order' );
        	$onDisplayOrderItem = TiendaHelperOrder::onDisplayOrderItems($orderitems);
        		
	        $view->assign( 'onDisplayOrderItem', $onDisplayOrderItem );
        }
        foreach( $orderitems as $item )
        {
        	if( $show_tax )
        		$item->orderitem_price += $item->orderitem_tax / $item->orderitem_quantity;
        }
        
        //END onDisplayOrderItem
        $view->assign( 'show_tax', $show_tax );
        $view->assign( 'using_default_geozone', false );
        $view->assign( 'order', $order );
        $view->setLayout( 'print' );
        $view->display();
    }
}