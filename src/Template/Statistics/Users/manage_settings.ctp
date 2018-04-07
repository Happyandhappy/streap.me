<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
$this->assign('title',  $title);
$this->loadHelper('Breadcrumbs', ['templates' => 'app_breadcrumbs']);
$this->Breadcrumbs->add('<span class="fas fa-home"></span>', ['controller' => 'Links', 'action' => 'index'], ['escape' => false]);
$this->Breadcrumbs->add(__('Manage Settings'));
?>
<h1>Manage Settings</h1>
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-5 col-md-4 col-lg-3 col-xl-2">
			<ul id="settings-nav-list" class="list-unstyled">
				<li><?= $this->Form->button('<span class="fas fa-user"></span> ' . __('Change Username'), ['id' => 'showChangeUsername', 'escape' => false, 'class' => 'btn btn-block btn-secondary', 'disabled' => true]) ?></li>
				<li><?= $this->Form->button('<span class="fas fa-lock"></span> ' . __('Change Password'), ['id' => 'showChangePassword', 'escape' => false, 'class' => 'btn btn-block btn-secondary']) ?></li>
			</ul>
		</div>
		<div id="changeUsernameContainer" class="col-sm-7 col-md-8 col-lg-9 col-xl-10">
			<?= $this->Form->create($user, ['context' => ['validator' => 'changeUsername'], 'url' => ['action' => 'changeUsername']]) ?>
			<fieldset>
			    <legend><?= __('Change Username') ?></legend>
			    <p class="small">Use the form below to change your username.</p>
			    <?php
			        echo $this->Form->control('username', ['label' => false, 'placeholder' => __('New Email'), 'class' => 'form-control']);
			        echo $this->Form->control('username-challenge', ['label' => false, 'placeholder' => __('Re-enter New Email'), 'class' => 'form-control']);
			        echo $this->Form->control('password-verify', ['type' => 'password', 'label' => false, 'placeholder' => __('Current Password'), 'class' => 'form-control']);
			    ?>
			</fieldset>
			<?= $this->Form->button('<span class="fas fa-save"></span> ' . __('Save'), ['class' => 'btn btn-primary']) ?>
			<?= $this->Form->end() ?>
		</div>
		<div id="changePasswordContainer" class="col-sm-7 col-md-8 col-lg-9 col-xl-10 hidden">
			<?= $this->Form->create($user, ['context' => ['validator' => 'changePassword'], 'url' => ['action' => 'changePassword']]) ?>
			<fieldset>
			    <legend><?= __('Change Password') ?></legend>
			    <p class="small">Use the form below to change your current password.</p>
			    <?php
			        echo $this->Form->control('password', ['label' => false, 'placeholder' => __('New Password'), 'class' => 'form-control']);
			        echo $this->Form->control('password-challenge', ['label' => false, 'placeholder' => __('Confirm New Password'), 'type' => 'password', 'class' => 'form-control']);
			        echo $this->Form->control('password-verify', ['label' => false, 'placeholder' => __('Current Password'), 'type' => 'password', 'class' => 'form-control']);
			    ?>
			</fieldset>
			<?= $this->Form->button('<span class="fas fa-save"></span> ' . __('Save'), ['class' => 'btn btn-primary']) ?>
			<?= $this->Form->end() ?>
		</div>
	</div>
</div>
<?= $this->Html->script('users-managesettings.js', ['block' => 'scriptBottom']) ?>