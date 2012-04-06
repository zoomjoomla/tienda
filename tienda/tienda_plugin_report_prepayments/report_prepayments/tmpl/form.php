<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php JHTML::_('script', 'tienda.js', 'media/com_tienda/js/'); ?>
<?php $state = @$vars->state; ?>

    <p><?php echo JText::_('COM_TIENDA_THIS_REPORTS_ON_PRE-PAYMENT_ORDERS'); ?></p>
<div>
<table class="adminlist">
	<thead>
		<tr>
			<th style="text-align: center;" class="key">
                <?php echo JText::_('COM_TIENDA_ID'); ?>
            </th>
            <th style="text-align: center;" class="key">
                <?php echo JText::_('COM_TIENDA_DATE_OF_ORDER'); ?>
            </th>
            <th style="text-align: center;" class="key">
                <?php echo JText::_('COM_TIENDA_CUSTOMER'); ?>
            </th> 
            <th style="text-align: center;" class="key">
                <?php echo JText::_('COM_TIENDA_TOTAL'); ?>
            </th> 
		</tr>
		<tr>
			<th align="left" style="text-align: left;" class="key">
				<span class="label"><?php echo JText::_('COM_TIENDA_FROM'); ?>:</span> <input id="filter_id_from" name="filter_id_from" value="<?php echo @$state->filter_id_from; ?>" size="5" class="input" />
				<span class="label"><?php echo JText::_('COM_TIENDA_TO'); ?>:</span> <input id="filter_id_to" name="filter_id_to" value="<?php echo @$state->filter_id_to; ?>" size="5" class="input" />
			</th>
			<th class="key" style="text-align: left;">
				<span class="label"><?php echo JText::_('COM_TIENDA_FROM'); ?>:</span>
               	<?php echo JHTML::calendar( @$state->filter_date_from, "filter_date_from", "filter_date_from", '%Y-%m-%d %H:%M:%S' ); ?>
				 <span class="label"><?php echo JText::_('COM_TIENDA_TO'); ?>:</span>
				 <?php echo JHTML::calendar( @$state->filter_date_to, "filter_date_to", "filter_date_to", '%Y-%m-%d %H:%M:%S' ); ?>
 				 <span class="label"><?php echo JText::_('COM_TIENDA_TYPE'); ?>:</span>
                 <?php echo TiendaSelect::datetype( @$state->filter_datetype, 'filter_datetype', '', 'datetype' ); ?>
			</th>
			<th class="key">
					<input id="filter_user" name="filter_user" value="<?php echo @$state->filter_user; ?>" size="25"/>
			</th>
			<th class="key" style="text-align: left;">
				<span class="label"><?php echo JText::_('COM_TIENDA_FROM'); ?>:</span> <input id="filter_total_from" name="filter_total_from" value="<?php echo @$state->filter_total_from; ?>" size="5" class="input" />
	   <span class="label"><?php echo JText::_('COM_TIENDA_TO'); ?>:</span> <input id="filter_total_to" name="filter_total_to" value="<?php echo @$state->filter_total_to; ?>" size="5" class="input" />
			</th>
		</tr>		
	</thead>
</table>
   </div>