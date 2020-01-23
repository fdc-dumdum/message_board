<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
$cakeVersion = __d('cake_dev', 'CakePHP %s', Configure::version())
?>
<!DOCTYPE html>
<html>
<head>
	<style>
		.ellipsis {
			width: 100%;
			white-space: nowrap;
			overflow: hidden;
			text-overflow: ellipsis 
		}
	</style>

	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $cakeDescription ?>:
		<?php echo $this->fetch('title'); ?>
	</title>
	<?php
		echo $this->Html->meta('icon');

		echo $this->Html->css(array(
			// Conflict in jquery select2 plugin
			'cake.generic.css',
			'custom.css',
			'card.css',
			'select2.min.css'
		));

		// jQuery
		echo $this->Html->script(array(
			'jquery'
		), FALSE);

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
		echo $this->Js->writeBuffer(array('cache' => FALSE));
	?>
</head>
<body>
	<div id="container">
		<div id="header">
			
			<h1>
				<?php 
					$page = '';
					if($page != 'thankyou'){
						if(AuthComponent::user()){
							echo '<h1> Welcome ' . AuthComponent::user('name') . '!</h1>';
							echo $this->Html->link('Home / Dashboard', array(
								'controller' => 'messages',
								'action' => 'index'
							));
							echo '<br><br>';
							echo $this->Html->link('Profile', array(
								'controller' => 'users',
								'action' => 'profile', AuthComponent::user('id')
							));
							echo '<br><br>';
							echo $this->Html->link('Logout', array(
								'controller' => 'users',
								'action' => 'logout'
							));
						}
					} 
				?>
			</h1>
		</div>
		<div id="content">

			<?php echo $this->Flash->render(); ?>

			<?php echo $this->fetch('content'); ?>
		</div>
		<div id="footer">
			<?php echo $this->Html->link(
					$this->Html->image('cake.power.gif', array('alt' => $cakeDescription, 'border' => '0')),
					'https://cakephp.org/',
					array('target' => '_blank', 'escape' => false, 'id' => 'cake-powered')
				);
			?>
			<p>
				<?php echo $cakeVersion; ?>
			</p>
		</div>
	</div>
</body>
</html>
