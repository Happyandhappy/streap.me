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
 * @since         0.10.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */
$username = $this->request->session()->read('Auth.User.username');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?= $this->Html->charset() ?>
    <?= $this->Html->meta('viewport', ['content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']) ?>
    <?= $this->Html->meta('icon', 'favicon.png', ['type' => 'image/png']) ?>

    <?= $this->Html->css('/lib/bootstrap/css/bootstrap.min.css') ?>
    <?= $this->Html->css('styles.css') ?>

    <?= $this->Html->script('https://use.fontawesome.com/releases/v5.0.6/js/all.js', ['defer']) ?>
    <?= $this->Html->script('/lib/jquery/jquery-3.2.1.min.js', ['block' => 'jquery']) ?>
    <?= $this->Html->script('https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js', ['integrity' => 'sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q', 'crossorigin' => 'anonymous', 'block' => 'scriptBottom']) ?>
    <?= $this->Html->script('/lib/bootstrap/js/bootstrap.min.js', ['block' => 'scriptBottom']) ?>
    <?= $this->Html->script('https://www.google.com/recaptcha/api.js', ['block' => 'scriptBottom']) ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>

    <title>
        <?= $this->fetch('title') ?>
    </title>
</head>
<body>

    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12">
            	<?= $this->Breadcrumbs->render(); ?>
                <?= $this->Flash->render() ?>
                <?= $this->fetch('content') ?>
            </div>
        </div>
    </div>
    <?= $this->fetch('jquery') ?>
    <?= $this->fetch('scriptBottom') ?>

</body>
</html>