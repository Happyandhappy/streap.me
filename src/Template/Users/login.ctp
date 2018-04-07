<?php
/**
 * @var \App\View\AppView $this
 */
$this->assign('title',  $title);
$this->Html->script('users-login.js', ['block' => 'scriptBottom']);
?>
<?= $this->Form->create($user, ['context' => ['validator' => 'login'], 'class' => 'centered login']) ?>
<style>
    .form-control {
  display: block;
  width: 100%;
  height: 50px;
  padding: 14px 12px;
  font-size: 14px;
  line-height: 1.42857;
  color: #555555;
  border: 1px solid #ccc;
  -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
  -webkit-transition: border-color ease-in-out 0.15s, box-shadow ease-in-out 0.15s;
  -o-transition: border-color ease-in-out 0.15s, box-shadow ease-in-out 0.15s;
  transition: border-color ease-in-out 0.15s, box-shadow ease-in-out 0.15s;
  font-family: "InsaniBurger02", arial, sans-serif;
  border-top: none;
  border-left: none;
  border-bottom: 1px solid #DFE3E7;
  border-right: none;
  border-radius: 0;
}
.form-signin-heading{
	margin: 80px 13px 14px;
}
.centered_form  {
    margin: 0px auto;
}
</style>
<fieldset class="centered_form">
    <h1 class="form-signin-heading"><?= __('Login') ?></h1>
    <?= $this->Form->control('username', ['label' => false, 'placeholder' => __('Email address'), 'class' => 'form-control login-control', 'type' => 'email']) ?>
    <?= $this->Form->control('password', ['label' => false, 'placeholder' => __('Password'), 'class' => 'form-control']) ?>
    <div class="input captcha required">
        <div class="g-recaptcha" data-sitekey="6LfiBiQUAAAAABTaAFoxwIbMpNYz_QgEbBl9px-7"></div>
        <?= $this->Form->error('g-recaptcha-response') ?>
    </div>
	<div class="input checkbox form-check" style="">
        <?= $this->Form->checkbox('remember', ['id' => 'remember']) ?>
        <?= $this->Form->label('remember', __('Remember me')) ?>
   	</div>
</fieldset>
<?= $this->Form->button('<span class="fas fa-sign-in-alt"></span> ' . __('Login'), ['class' => 'btn btn-block btn-login btn-primary']) ?>
<p class="small text-center">
	<?= $this->Html->link(__('Forgot your password?'), ['action' => 'recoverPassword']) ?><br>
	Don't have an account? <?= $this->Html->link(__('Sign up for free!'), ['action' => 'register']) ?>
</p>

<?= $this->Form->end() ?>