<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
$this->assign('title',  $title);
?>
<div class="row">
    <div id="content-paper" class="col-xl-12">
    	<div class="paper-padder">
		    <?= $this->Form->create($user, ['context' => ['validator' => 'setPassword'], 'class' => 'centered']) ?>
		    <?= $this->Flash->render() ?>
		    <fieldset>
		        <legend><?= __('Set Password') ?></legend>
		        <p class="small">Use the form below to set a new password for your account.</p>
		        <?php
		            echo $this->Form->control('password', ['label' => false, 'placeholder' => __('New Password'), 'class' => 'form-control']);
		            echo $this->Form->control('password-challenge', ['label' => false, 'placeholder' => __('Confirm New Password'), 'type' => 'password', 'class' => 'form-control']);
		        ?>
		    </fieldset>
		    <?= $this->Form->button(__('Set Password'), ['class' => 'btn btn-block btn-primary']) ?>
		    <?= $this->Form->end() ?>
		</div>
	</div>
</div>