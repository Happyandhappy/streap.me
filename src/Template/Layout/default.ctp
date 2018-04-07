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
    <?php
    if(strtolower($this->request->getParam('action')) == 'display'){
    ?>
    <?= $this->Html->meta('ROBOTS', ['content' => 'NOINDEX, NOFOLLOW']) ?>
    <?php
    }
    ?>
    
<?= $this->Html->meta('description', 'lol');
?>
    <?= $this->Html->meta('icon', 'favicon.png', ['type' => 'image/png']) ?>

    <?= $this->Html->css('/lib/bootstrap/css/bootstrap.min.css') ?>
    <?= $this->Html->css('master.css') ?>

    <?= $this->Html->script('https://use.fontawesome.com/releases/v5.0.6/js/all.js', ['defer' => true]) ?>
    <?= $this->Html->script('https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js', ['block' => 'jquery']) ?>
    <?= $this->Html->script('https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js', ['integrity' => 'sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q', 'crossorigin' => 'anonymous', 'block' => 'scriptBottom']) ?>
    <?= $this->Html->script('/lib/bootstrap/js/bootstrap.min.js', ['block' => 'scriptBottom']) ?>
    <?= $this->Html->script('/js/global.js', ['block' => 'scriptBottom']) ?>
    <?= $this->Html->script('https://www.google.com/recaptcha/api.js', ['block' => 'scriptBottom']) ?>
    <?= $this->Html->script('/lib/metrica/metrica.js', ['block' => 'scriptBottom']) ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
<meta name="fo-verify" content="da935e94-a96e-4640-b7d7-eceed2bbfe3c">
    <title>
        <?= $this->fetch('title') ?>
    </title>
</head>
<body class="colored <?= strtolower($this->request->getParam('controller')) ?>-<?= strtolower($this->request->getParam('action')) ?>">

    <nav class="navbar navbar-expand-sm">
    <?php if ($username) : ?>
        <?= $this->Html->link($this->Html->image('/img/logo.png', ['class' => 'logo img img-responsive']), ['controller' => 'Links', 'action' => 'index'], ['escape' => false, 'class' => 'navbar-brand']) ?>
    <?php else : ?>
        <?= $this->Html->link($this->Html->image('/img/logo.png', ['class' => 'logo img img-responsive']), '/', ['escape' => false, 'class' => 'navbar-brand']) ?>
    <?php endif; ?>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#viid-menu" aria-controls="viid-menu" aria-expanded="false" aria-label="Toggle navigation">
            <?= $this->Html->link('<span class="fas fa-bars"></span>', ['controller' => 'Users', 'action' => 'logout'], ['class' => 'btn nav-btn', 'escape' => false]) ?>
        </button>
        <div class="collapse navbar-collapse" id="viid-menu">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item leading"><a href="/" class="nav-link">Home</a></li>
                <li class="nav-item leading"><a href="/login" class="nav-link">Login</a></li>
                <?php if ($username) : ?>
                    <?php if ($this->request->getParam('action') != 'manageSettings') : ?>

                    <li class="nav-item setting"><?= $this->Html->link('<span class="fas fa-cog"></span> ' . __('Settings'), ['controller' => 'Users', 'action' => 'manageSettings'], ['escape' => false, 'class' => 'btn nav-btn nav-link']) ?></li>
                    <?php endif; ?>
                    <li class="nav-item sign-out"><?= $this->Html->link('<span class="fas fa-sign-out-alt"></span> ' . __('Sign out'), ['controller' => 'Users', 'action' => 'logout'], ['escape' => false, 'class' => 'btn nav-btn nav-link']) ?></li>

                <?php else : ?>
                    <?php if ($this->request->getParam('action') == 'register') : ?>
                    <li class="nav-item"><?= $this->Html->link('<span class="fas fa-sign-in-alt"></span> ' . __('Login'), ['controller' => 'Users', 'action' => 'login'], ['escape' => false, 'class' => 'btn nav-btn nav-link']) ?></li>
                    <?php else : ?>
                        <?php if ($this->request->getParam('controller') != 'Pages') : ?>
                    <li class="nav-item"><?= $this->Html->link('<span class="fas fa-user-plus"></span> ' . __('Sign up for free!'), ['controller' => 'Users', 'action' => 'register'], ['escape' => false, 'class' => 'btn nav-btn nav-link']) ?></li>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php endif; ?>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <div id="content-paper" class="col-xl-12">
                <div class="paper-padder">
                	<?= $this->Breadcrumbs->render(); ?>
                    <?= $this->Flash->render() ?>
                    <?= $this->fetch('content') ?>
                </div>
            </div>
        </div>
    </div>
    <div class="toolbox">
        <div class="container">
            <div class="row">
                <div class="col-xl-3 d-flex">
				<a href="https://snapchat.com/add/le_e350">
                    <?= $this->Html->image('https://viid.su/webroot/img/snapcodeBitmoji.svg', ['id' => 'footer-bitmoji', 'class' => 'img img-responsive mx-auto my-auto']); ?>
				</a>
                </div>
                <div class="col-xl-3">
                    <h4>Useful Stuff</h4>
                    <ul class="list-unstyled">
                        <li>News 'n' Stuff</li>
                        <li>Services For Creators</li>
                        <li>Advertise Here</li>
                        <li>Gucci Gang</li>
                    </ul>
                </div>
                <div class="col-xl-3">
                    <h4>More</h4>
                    <ul class="list-unstyled">
                        <li>Guidelines</li>
                        <li>Policy and Safety!</li>
                        <li>Support</li>
                    </ul>
                </div>
                <div class="col-xl-3">
                </div>
            </div>
        </div>
    </div>
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                	<div class="d-flex flex-wrap">
                		<div class="p-2"><?= $this->Html->link(__('Datenschutzbestimmungen'), '#') ?></div>
                		<div class="p-2"><?= $this->Html->link(__('Nutzungsbedingungen'), '#') ?></div>
                	</div>
                </div>
            </div>
        </div>
    </footer>
    <?= $this->fetch('jquery') ?>
    <?= $this->fetch('scriptBottom') ?>

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-115950156-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-115950156-1');
</script>
</body>
</html>