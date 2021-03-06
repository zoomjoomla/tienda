<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php $row = @$this -> row; ?>

<table class="table table-striped table-bordered">
    <tbody>
        <tr>
            <th style="width: 25%;"><?php echo JText::_('COM_TIENDA_DISPLAY_FACEBOOK_LIKE_BUTTON'); ?>
            </th>
            <td><?php  echo TiendaSelect::btbooleanlist('display_facebook_like', 'class="inputbox"', $this -> row -> get('display_facebook_like', '1')); ?>
            </td>
            <td></td>
        </tr>
        <tr>
            <th style="width: 25%;"><?php echo JText::_('COM_TIENDA_DISPLAY_TWITTER_BUTTON'); ?>
            </th>
            <td><?php  echo TiendaSelect::btbooleanlist('display_tweet', 'class="inputbox"', $this -> row -> get('display_tweet', '1')); ?>
            </td>
            <td></td>
        </tr>
        <tr>
            <th style="width: 25%;"><?php echo JText::_('COM_TIENDA_DEFAULT_TWITTER_MESSAGE'); ?>
            </th>
            <td><input type="text" name="display_tweet_message" value="<?php echo $this -> row -> get('display_tweet_message', 'Check this out!'); ?>" class="inputbox" size="35" />
            </td>
            <td></td>
        </tr>
        <tr>
            <th style="width: 25%;"><?php echo JText::_('COM_TIENDA_DISPLAY_GOOGLE_PLUS1_BUTTON'); ?>
            </th>
            <td><?php  echo TiendaSelect::btbooleanlist('display_google_plus1', 'class="inputbox"', $this -> row -> get('display_google_plus1', '1')); ?>
            </td>
            <td></td>
        </tr>
        <tr>
            <th style="width: 25%;"><?php echo JText::_('COM_TIENDA_DISPLAY_GOOGLE_PLUS1_BUTTON_SIZE'); ?>
            </th>
            <td><?php
            $google_sizes = array();
            $google_sizes[] = JHTML::_('select.option', 'small', JText::_('COM_TIENDA_GOOGLE_SMALL'));
            $google_sizes[] = JHTML::_('select.option', 'medium', JText::_('COM_TIENDA_GOOGLE_MEDIUM'));
            $google_sizes[] = JHTML::_('select.option', '', JText::_('COM_TIENDA_GOOGLE_STANDARD'));
            $google_sizes[] = JHTML::_('select.option', 'tall', JText::_('COM_TIENDA_GOOGLE_TALL'));
            echo JHTML::_('select.genericlist', $google_sizes, 'display_google_plus1_size', array('class' => 'inputbox', 'size' => '1'), 'value', 'text', $this -> row -> get('display_google_plus1_size', 'medium'));
            ?>
            </td>
            <td></td>
        </tr>
        <tr>
            <th style="width: 25%;"><?php echo JText::_('COM_TIENDA_USE_URI_FOR_SOCIAL_BOOKMARK_INTEGRATION'); ?>
            </th>
            <td><?php
            $social_uri_types = array();
            $social_uri_types[] = JHTML::_('select.option', 0, JText::_('COM_TIENDA_LONG_URI'));
            $social_uri_types[] = JHTML::_('select.option', 1, JText::_('COM_TIENDA_BITLY'));
            echo JHTML::_('select.genericlist', $social_uri_types, 'display_bookmark_uri', array('class' => 'inputbox', 'size' => '1'), 'value', 'text', $this -> row -> get('display_bookmark_uri', 0));
            ?>
            </td>
            <td></td>
        </tr>
        <tr>
            <th style="width: 25%;"><?php echo JText::_('COM_TIENDA_BITLY_LOGIN'); ?>
            </th>
            <td><input type="text" name="bitly_login" value="<?php echo $this -> row -> get('bitly_login', ''); ?>" class="inputbox" size="35" />
            </td>
            <td></td>
        </tr>
        <tr>
            <th style="width: 25%;"><?php echo JText::_('COM_TIENDA_BITLY_KEY'); ?>
            </th>
            <td><input type="text" name="bitly_key" value="<?php echo $this -> row -> get('bitly_key', ''); ?>" class="inputbox" size="35" />
            </td>
            <td></td>
        </tr>
    </tbody>
</table>
