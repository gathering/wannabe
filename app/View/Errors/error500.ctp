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
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       cake.libs.view.templates.errors
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
?>
<div class="alert-message block-message error">
	<p><strong><?php echo __('Error'); ?>: </strong> <?php echo __('An internal error has occured. Please check:'); ?></p>
	<ul>
		<li><?=__("That you've typed in the correct address.")?></li>
		<li><?=__("If the last page was a form, that you've filled in the correct information")?></li>
        </ul>
	<div class="alert-actions">
	<a class="btn small" href="mailto:wannabe@gathering.org"><?=__("Report this")?></a>
	</div>
</div>
<?php
if (Configure::read('debug') > 0 ):
	echo $this->element('exception_stack_trace');
	echo "<pre>";
	print_r($request);
	echo "</pre>";
endif;
?>
