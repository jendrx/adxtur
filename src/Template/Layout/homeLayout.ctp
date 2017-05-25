<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = 'CakePHP: the rapid development php framework';
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->element('head') ?>
</head>
<body style="height:100%">
<div id ="wrap" style="min-height:100%;">
	<?php
	if ($user)
		echo $this->element('header');

	?>
    <div class="container-fluid" style="overflow: auto;padding-bottom: 10%;">
        <?= $this->Flash->render() ?>
        <?= $this->fetch('content') ?>

	</div>
</div>
<?= $this->element('footer') ?>

</body>
</html>


