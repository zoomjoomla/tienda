<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php
$form = @$this->form;
$row = @$this->row;
$helper_product = new TiendaHelperProduct();
?>

<div style="float: left; width: 50%;">
    <div class="well options">
        <legend>
            <?php echo JText::_('COM_TIENDA_PRICES_AND_INVENTORY'); ?>
        </legend>

        <table class="table table-striped table-bordered">
            <tr>
                <td class="dsc-key"><?php echo JText::_('COM_TIENDA_ITEM_FOR_SALE'); ?>
                </td>
                <td>
                <?php //swapping yes and no because  this is a NOT for SALE so the logic is in reverse. 
                echo TiendaSelect::btbooleanlist( 'product_notforsale', '', @$row->product_notforsale, 'JNO', 'JYES' ); ?>
                </td>
            </tr>
            <?php
            $prices = $helper_product->getPrices( $row->product_id );
            if (empty($row->product_id) || empty($prices))
            {
                // new product (or no prices set) - ask for normal price
                ?>
            <tr>
                <td class="dsc-key"><?php echo JText::_('COM_TIENDA_NORMAL_PRICE'); ?>:
                </td>
                <td><input type="text" name="product_price" id="product_price" value="<?php echo @$row->product_price; ?>" size="25" maxlength="25" />
                    <div class="note well">
                        <?php echo JText::_('COM_TIENDA_SET_NORMAL_PRICE_NOW_SPECIAL_PRICES_LATER'); ?>
                    </div>
                </td>
            </tr>
            <?php
            }
            else
            {
                // display lightbox link to manage prices
                ?>
            <tr>
                <td class="dsc-key"><?php echo JText::_('COM_TIENDA_PRICES'); ?>:
                </td>
                <td><?php
                Tienda::load( 'TiendaUrl', 'library.url' );
                ?> [<?php echo TiendaUrl::popup( "index.php?option=com_tienda&view=products&task=setprices&id=".$row->product_id."&tmpl=component", JText::_('COM_TIENDA_SET_PRICES') ); ?>]
                    <div id="current_prices">
                        <?php foreach (@$prices as $price) : ?>
                        [<a href="<?php echo $price->link_remove."&return=".base64_encode("index.php?option=com_tienda&view=products&task=edit&id=".$row->product_id); ?>"> <?php echo JText::_('COM_TIENDA_REMOVE'); ?>
                        </a>]
                        <?php echo TiendaHelperBase::currency( $price->product_price ); ?>
                        <br />
                        <?php endforeach; ?>
                    </div>
                </td>
            </tr>
            <?php
            }
            ?>
            <tr>
                <td class="dsc-key"><?php echo JText::_('COM_TIENDA_TAX_CLASS'); ?>:</td>
                <td><?php echo TiendaSelect::taxclass( @$row->tax_class_id, 'tax_class_id', '', 'tax_class_id', false ); ?>
                </td>
            </tr>
            <tr>
                <td class="dsc-key"><?php echo JText::_('COM_TIENDA_CHECK_PRODUCT_INVENTORY'); ?>:</td>
                <td><?php  echo TiendaSelect::btbooleanlist( 'product_check_inventory', '', @$row->product_check_inventory ); ?>
                </td>
            </tr>


            <?php
            if (empty($row->product_check_inventory) && !empty($row->product_id))
            {
                ?>
            <tr>
                <td class="dsc-key"><?php echo JText::_('COM_TIENDA_PRODUCT_QUANTITIES'); ?>:</td>
                <td>
                    <div class="note well">
                        <?php echo JText::_('COM_TIENDA_PRODUCT_INVENTORY_IS_DISABLED_ENABLE_IT_TO_SET_QUANTITIES'); ?>
                    </div>
                </td>
            </tr>
            <?php
            }
            else
            {
                if (empty($row->product_id))
                {
                    // doing a new product
                    ?>
            <tr>
                <td class="dsc-key"><?php echo JText::_('COM_TIENDA_STARTING_QUANTITY'); ?>:</td>
                <td><input type="text" name="product_quantity" value="" size="15" maxlength="11" />
                </td>
            </tr>
            <?php
                }
                else
                {
                    // display lightbox link to manage quantities
                    ?>
            <tr>
                <td class="dsc-key"><?php echo JText::_('COM_TIENDA_PRODUCT_QUANTITIES'); ?>:</td>
                <td><?php
                echo $row->product_quantity;
                echo "<br/>";
                Tienda::load( 'TiendaUrl', 'library.url' );
                $options = array('update' => true );
                ?> [<?php echo TiendaUrl::popup( "index.php?option=com_tienda&view=products&task=setquantities&id=".$row->product_id."&tmpl=component", JText::_('COM_TIENDA_SET_QUANTITIES'), $options); ?>]</td>
            </tr>
            <?php
                }
            }
            ?>
            <tr>
                <td title="<?php echo JText::_('COM_TIENDA_PURCHASE_QUANTITY_RESTRICTION').'::'.JText::_('COM_TIENDA_PURCHASE_QUANTITY_RESTRICTION_TIP'); ?>" class="dsc-key hasTip"><?php echo JText::_('COM_TIENDA_PURCHASE_QUANTITY_RESTRICTION'); ?>:</td>
                <td>
                    <div class="control-group">
                        <div class="controls">
                            <fieldset id="quantity_restriction" class="radio btn-group">
                                <input type="radio" <?php if (empty($row->quantity_restriction)) { echo "checked='checked'"; } ?> value="0" name="quantity_restriction" id="quantity_restriction0" /><label for="quantity_restriction0"><?php echo JText::_('COM_TIENDA_NO'); ?> </label> <input type="radio" <?php if (!empty($row->quantity_restriction)) { echo "checked='checked'"; } ?> value="1" name="quantity_restriction" id="quantity_restriction1" /><label onclick="tiendaShowHideDiv('quantity_restrictions');" for="quantity_restriction1"><?php echo JText::_('COM_TIENDA_YES'); ?> </label>
                            </fieldset>
                        </div>
                    </div>
                    
                    <div id="quantity_restrictions">
                        <table class="table table-striped table-bordered" style="width: 100%;">
                            <tr>
                                <td class="dsc-key"><?php echo JText::_('COM_TIENDA_MINIMUM_QUANTITY'); ?>:
                                </td>
                                <td><input type="text" name="quantity_min" id="quantity_min" value="<?php echo @$row->quantity_min; ?>" size="30" maxlength="250" />
                                </td>
                            </tr>
                            <tr>
                                <td class="dsc-key"><?php echo JText::_('COM_TIENDA_MAXIUM_QUANTITY'); ?>:
                                </td>
                                <td><input type="text" name="quantity_max" id="quantity_max" value="<?php echo @$row->quantity_max; ?>" size="30" maxlength="250" />
                                </td>
                            </tr>

                            <tr>
                                <td class="dsc-key"><?php echo JText::_('COM_TIENDA_STEP_QUANTITY'); ?>:
                                </td>
                                <td><input type="text" name="quantity_step" id="quantity_step" value="<?php echo @$row->quantity_step; ?>" size="30" maxlength="250" />
                                </td>
                            </tr>
                        </table>
                    </div>
                </td>
            </tr>
            <tr>
                <td class="dsc-key"><?php echo JText::_('COM_TIENDA_HIDE_QUANTITY_INPUT_ON_PRODUCT_FORM'); ?>:</td>
                <td><?php  echo TiendaSelect::btbooleanlist( 'param_hide_quantity_input', '', @$row->product_parameters->get('hide_quantity_input') ); ?>
                </td>
            </tr>
            <tr>
                <td class="dsc-key"><?php echo JText::_('COM_TIENDA_DEFAULT_QUANTITY_IF_INPUT_HIDDEN_ON_PRODUCT_FORM'); ?>:</td>
                <td><input type="text" name="param_default_quantity" id="param_default_quantity" value="<?php echo @$row->product_parameters->get('default_quantity'); ?>" size="10" maxlength="250" />
                </td>
            </tr>
            <tr>
                <td class="dsc-key"><?php echo JText::_('COM_TIENDA_DISABLE_ABILITY_TO_UPDATE_QUANTITY_IN_CART'); ?>:</td>
                <td><?php  echo TiendaSelect::btbooleanlist( 'param_hide_quantity_cart', '', @$row->product_parameters->get('hide_quantity_cart') ); ?>
                </td>
            </tr>
        </table>
    </div>
</div>

<div style="float: left; width: 50%;">
    <div class="well options">
        <legend>
            <?php echo JText::_('COM_TIENDA_PRODUCT_LIST_PRICE'); ?>
        </legend>
        <table class="table table-striped table-bordered">
            <tr>
                <td title="<?php echo JText::_('COM_TIENDA_DISPLAY_PRODUCT_LIST_PRICE').'::'.JText::_('COM_TIENDA_DISPLAY_PRODUCT_LIST_PRICE_TIP'); ?>" class="key hasTip"><?php echo JText::_('COM_TIENDA_DISPLAY_PRODUCT_LIST_PRICE'); ?>:</td>
                <td><?php  echo TiendaSelect::btbooleanlist( 'product_listprice_enabled', '', @$row->product_listprice_enabled ); ?>
                </td>
            </tr>
            <tr>
                <td title="<?php echo JText::_('COM_TIENDA_DISPLAY_PRODUCT_LIST_PRICE').'::'.JText::_('COM_TIENDA_DISPLAY_PRODUCT_LIST_PRICE_TIP'); ?>" class="key hasTip"><?php echo JText::_('COM_TIENDA_DISPLAY_PRODUCT_LIST_PRICE'); ?>
                </td>
                <td><input type="text" name="product_listprice" value="<?php echo @$row->product_listprice; ?>" size="15" maxlength="11" />
                </td>
            </tr>

        </table>
    </div>
</div>

<div style="clear: both;"></div>
