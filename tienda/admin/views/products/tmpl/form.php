<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php JHTML::_('script', 'tienda.js', 'media/com_tienda/js/'); ?>
<?php JHTML::_('script', 'tienda_admin.js', 'media/com_tienda/js/'); ?>
<?php JHTML::_('behavior.tooltip'); ?>
<?php
$form = @$this->form;
$row = @$this->row;
$helper_product = new TiendaHelperProduct();
?>

<form id="adminForm" action="<?php echo JRoute::_( @$form['action'] ) ?>" method="post" class="adminform" name="adminForm" id="adminForm" enctype="multipart/form-data" >

    <div id="form-basics" class="well options pull-left" style="width: 97%;">
        <?php $this->setLayout( 'form_basics' ); echo $this->loadTemplate(); ?>
    </div>

    <div class="reset"></div>

    <?php
    // fire plugin event here to enable extending the form
    JDispatcher::getInstance()->trigger('onBeforeDisplayProductForm', array( $row ) );                    
    ?>
    
    <?php $tabs = array(); #TODO add the tabs to an array or object and than make a display method so plugins can edit the tabs and the ordering ?>
    
    <div class="tabbable">
        
        <ul class="nav nav-tabs" id="TiendaProductTabs">
            <li class="active"><a href="#tab-properties" data-toggle="tab"><?php echo  JText::_('COM_TIENDA_PROPERTIES'); ?> </a></li>
            <li class=""><a href="#tab-descriptions" data-toggle="tab"><?php echo JText::_('COM_TIENDA_DESCRIPTIONS'); ?> </a></li>
            <li class=""><a href="#tab-images" data-toggle="tab"><?php echo JText::_('COM_TIENDA_IMAGES'); ?> </a></li>
            <li class=""><a href="#tab-pricing" data-toggle="tab"><?php echo JText::_('COM_TIENDA_PRICING_AND_INVENTORY'); ?> </a></li>
            <li class=""><a href="#tab-shipping" data-toggle="tab"><?php echo JText::_('COM_TIENDA_SHIPPING'); ?> </a></li>
            <li class=""><a href="#tab-display" data-toggle="tab"><?php echo JText::_('COM_TIENDA_DISPLAY'); ?> </a></li>
            <li class=""><a href="#tab-files" data-toggle="tab"><?php echo JText::_('COM_TIENDA_FILES'); ?> </a></li>
            <li class=""><a href="#tab-subscriptions" data-toggle="tab"><?php echo  JText::_('COM_TIENDA_SUBSCRIPTIONS'); ?> </a></li>
            <li class=""><a href="#tab-relationships" data-toggle="tab"><?php echo JText::_('COM_TIENDA_RELATED_ITEMS'); ?> </a></li>
            <li class=""><a href="#tab-integrations" data-toggle="tab"><?php echo JText::_('COM_TIENDA_INTEGRATIONS'); ?> </a></li>
            <li class=""><a href="#tab-advanced" data-toggle="tab"><?php echo JText::_('COM_TIENDA_ADVANCED'); ?> </a></li>
            <?php JDispatcher::getInstance()->trigger('onDisplayProductFormTabs', array( $tabs, $row ) );?>
        </ul>
        

        <div class="tab-content">
            <div class="tab-pane active" id="tab-properties">
                <?php $this->setLayout( 'form_properties' ); echo $this->loadTemplate(); ?>
            </div>
            
            <div class="tab-pane" id="tab-descriptions">
                <?php $this->setLayout( 'form_descriptions' ); echo $this->loadTemplate(); ?>
            </div>
            
            <div class="tab-pane" id="tab-images">
                <?php $this->setLayout( 'form_images' ); echo $this->loadTemplate(); ?>
            </div>
                        
            <div class="tab-pane" id="tab-pricing">
                <?php $this->setLayout( 'form_pricing' ); echo $this->loadTemplate(); ?>
            </div>
            
            <div class="tab-pane" id="tab-shipping">
                <?php $this->setLayout( 'form_shipping' ); echo $this->loadTemplate(); ?>
            </div>

            <div class="tab-pane" id="tab-display">
                <?php $this->setLayout( 'form_display' ); echo $this->loadTemplate(); ?>
            </div>

            <div class="tab-pane" id="tab-files">
                <?php $this->setLayout( 'form_files' ); echo $this->loadTemplate(); ?>
            </div>
            
            <div class="tab-pane" id="tab-subscriptions">
                <?php $this->setLayout( 'form_subscriptions' ); echo $this->loadTemplate(); ?>
            </div>
            
            <div class="tab-pane" id="tab-relationships">
                <?php $this->setLayout( 'form_relationships' ); echo $this->loadTemplate(); ?>
            </div>
            
            <div class="tab-pane" id="tab-integrations">
                <?php $this->setLayout( 'form_integrations' ); echo $this->loadTemplate(); ?>
            </div>
            
            <div class="tab-pane" id="tab-advanced">
                <?php $this->setLayout( 'form_advanced' ); echo $this->loadTemplate(); ?>
            </div>
            
            <?php 
            // fire plugin event here to enable extending the form's tabs
            JDispatcher::getInstance()->trigger('onAfterDisplayProductFormTabs', array( $tabs, $row ) );
            ?>
        </div>
        
    </div>


    <?php
    // fire plugin event here to enable extending the form
    JDispatcher::getInstance()->trigger('onAfterDisplayProductForm', array( $row ) );                    
    ?>

    <div>
    	<input type="hidden" name="id" id="product_id" value="<?php echo @$row->product_id; ?>" />
    	<input type="hidden" name="task" value="" />
    </div>

</form>

<?php $multiscript = Tienda::getInstance()->get( 'multiupload_script', 0 ); ?>
<script type="text/javascript">
    <?php $timestamp = time();?>

    // showing/hiding elementes related to pro-rated payments
    function showProRatedFields()
    {
    	val = jQuery('input[name=subscription_prorated]:checked').val();
    	if( val == 1 )
    	{
    		jQuery( '.prorated_unrelated' ).hide( 'fast' );
    		jQuery( '.prorated_related' ).show( 'fast' );
    		jQuery( '.trial_price' ).text( '<?php echo JText::_('COM_TIENDA_INITIAL_PERIOD_PRICE');?>:' );
    	}
    	else
    	{
    		jQuery( '.prorated_unrelated' ).show( 'fast' );
    		jQuery( '.prorated_related' ).hide( 'fast' );
    		jQuery( '.trial_price' ).text( '<?php echo JText::_('COM_TIENDA_TRIAL_PERIOD_PRICE');?>:' );
    	}
    }

    //showProRatedFields();
</script>