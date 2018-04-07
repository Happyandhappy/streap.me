<?php
/**
 * @var \App\View\AppView $this
 */
$this->assign('title',  $title);
$this->Html->script('users-login.js', ['block' => 'scriptBottom']);
?>
<?= $this->Form->create($user, ['context' => ['validator' => 'login'], 'class' => 'centered login']) ?>
<fieldset>
    <h1><?= __('Login') ?></h1>
    <?= $this->Form->control('username', ['label' => false, 'placeholder' => __('Email address'), 'class' => 'form-control', 'type' => 'email']) ?>
    <?= $this->Form->control('password', ['label' => false, 'placeholder' => __('Password'), 'class' => 'form-control']) ?>
    <div class="input captcha required">
        <div class="g-recaptcha" data-sitekey="6LfiBiQUAAAAABTaAFoxwIbMpNYz_QgEbBl9px-7"></div>
        <?= $this->Form->error('g-recaptcha-response') ?>
    </div>
	<div class="input checkbox form-check" style="display: none;">
        <?= $this->Form->checkbox('remember', ['id' => 'remember']) ?>
        <?= $this->Form->label('remember', __('Remember me')) ?>
   	</div>
</fieldset>
<?= $this->Form->button('<span class="fas fa-sign-in-alt"></span> ' . __('Login'), ['class' => 'btn btn-block btn-primary']) ?>
<p class="small text-center">
	<?= $this->Html->link(__('Forgot your password?'), ['action' => 'recoverPassword']) ?><br>
	Don't have an account? <?= $this->Html->link(__('Sign up for free!'), ['action' => 'register']) ?>
</p>
<?= $this->Form->end() ?>