<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link	  http://cakephp.org CakePHP(tm) Project
 * @package       cake.libs.view.templates.errors
 * @since	 CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
?>
<?php
if(isset($messageError)):
?>
<div class="alert-message block-message error">
	<p><strong><?php echo __('Error'); ?>: </strong> <?php printf(__('The page “%s” returned an error. Maybe you did something wrong?'),"<strong>{$url}</strong>"); ?></p>
	<div class="alert-actions">
	<a class="btn small" href="mailto:wannabe@gathering.org"><?=__("Report this")?></a>
	</div>
</div>
<?php
else:
?>
<div class="alert-message block-message error">
        <p><strong><?php echo __('Error'); ?>: </strong> <?php printf(__('The requested address “%s” could not be found. Please check that you\'ve entered the correct address.'),"<strong>{$url}</strong>"); ?></p>
        <div class="alert-actions">
        <a class="btn small" href="mailto:wannabe@gathering.org"><?=__("Report this")?></a>
        </div>
</div>
<?php
endif;
?>
<?php
if (Configure::read('debug') > 0 ):
	echo $this->element('exception_stack_trace');
        echo "<pre>";
	print_r($request);
	echo "</pre>";
endif;
?>
