<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php JHTML::_('script', 'tienda.js', 'media/com_tienda/js/'); ?>
<?php $state = @$vars->state; ?>

    <p><?php echo JText::_('DAILY REPORT DESC'); ?></p>

    <div class="note">
	    <?php echo JText::_('COM_TIENDA_SELECT_DATE_RANGE'); ?>:
	    <?php $attribs = array('class' => 'inputbox', 'size' => '1'); ?>
	    
	            <span class="label"><?php echo JText::_('COM_TIENDA_FROM'); ?>:</span>
	            <?php echo JHTML::calendar( @$state->filter_date_from, "filter_date_from", "filter_date_from", '%Y-%m-%d 00:00:00' ); ?>
	            <span class="label"><?php echo JText::_('COM_TIENDA_TO'); ?>:</span>
	            <?php echo JHTML::calendar( @$state->filter_date_to, "filter_date_to", "filter_date_to", '%Y-%m-%d 00:00:00' ); ?>
    </div>
        