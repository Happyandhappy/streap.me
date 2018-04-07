<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
$this->assign('title',  $title);
$this->loadHelper('Breadcrumbs', ['templates' => 'app_breadcrumbs']);
$this->Breadcrumbs->add('<span class="fas fa-home"></span>', ['controller' => 'Users', 'action' => 'login'], ['escape' => false]);
$this->Breadcrumbs->add(__('Reset Password'), '');
?>
<?= $this->Form->create($user, ['context' => ['validator' => 'recoverPassword'], 'class' => 'recoverpassword centered']) ?>
<fieldset>
    <h1><?= __('Reset Password') ?></h1>
    <p><?= __('Enter your email adress that you used to register. We will send you an email with a link where you can reset your current password.') ?></p>
    <?= $this->Form->control('username', ['label' => false, 'placeholder' => __('Email address'), 'class' => 'form-control', 'type' => 'email']) ?>
    <div class="input recaptcha required">
        <div class="g-recaptcha" data-sitekey="6LfiBiQUAAAAABTaAFoxwIbMpNYz_QgEbBl9px-7"></div>
        <?= $this->Form->error('g-recaptcha-response') ?>
    </div>
</fieldset>
<?= $this->Form->button('<span class="fas fa-life-ring"></span> ' . __('Recover Password'), ['class' => 'btn btn-block btn-primary']) ?>
<p class="small text-center">Still need help? <?= $this->Html->link(__('Contact the Support'), 'mailto:support@viid.su') ?></p>
<?= $this->Form->end() ?>
