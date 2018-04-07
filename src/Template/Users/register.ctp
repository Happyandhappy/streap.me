<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
$this->assign('title',  $title);
$this->loadHelper('Breadcrumbs', ['templates' => 'app_breadcrumbs']);
$this->Breadcrumbs->add('<span class="fas fa-home"></span>', ['controller' => 'Users', 'action' => 'login'], ['escape' => false]);
$this->Breadcrumbs->add(__('Sign Up'));
$this->Html->script('users-register.js', ['block' => 'scriptBottom']);
?>
<?= $this->Form->create($user, ['context' => ['validator' => 'register'], 'class' => 'register centered']) ?>
<fieldset>
    <h1><?= __('Sign Up') ?></h1>
    <p><?= __('Use the form below to create an account.') ?></p>
    <?php
        echo $this->Form->control('username', ['label' => false, 'class' => 'form-control', 'placeholder' => __('Email address')]);
        echo $this->Form->control('password', ['label' => false, 'class' => 'form-control', 'placeholder' => __('Password')]);
        echo $this->Form->control('password-challenge', ['label' => false, 'type' => 'password', 'class' => 'form-control', 'placeholder' => __('Re-enter Password')]);
    ?>
    <div class="input recaptcha required">
        <div class="g-recaptcha" data-sitekey="6LfiBiQUAAAAABTaAFoxwIbMpNYz_QgEbBl9px-7"></div>
        <?= $this->Form->error('g-recaptcha-response') ?>
    </div>
</fieldset>
<?= $this->Form->button('<span class="fas fa-thumbs-up"></span> ' . __('Sign Up & Accept'), ['class' => 'btn btn-block btn-primary']) ?>
<p class="small text-center">By tapping on Sign Up & Accept, you agree to the <?= $this->Html->link(__('Terms of Service'), '#', ['id' => 'terms-of-service-button']) ?> and 
    <?= $this->Html->link(__('Privacy Policy'), '#', ['id' => 'privacy-policy-button']) ?></p>
<?= $this->Form->end() ?>

<!-- Privacy policy modal -->
<div class="modal fade" id="termsOfServiceModalLong" tabindex="-1" role="dialog" aria-labelledby="termsOfServiceModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="termsOfServiceModalLongTitle"><span class="fas fa-users"></span> <?= __('Terms of Service') ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Coming soon...</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><span class="fas fa-times"></span> <?= __('Close') ?></button>
            </div>
        </div>
    </div>
</div>

<!-- Terms of service modal -->
<div class="modal fade" id="privacyPolicyModalLong" tabindex="-1" role="dialog" aria-labelledby="privacyPolicyModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="privacyPolicyModalLongTitle"><span class="fas fa-lock"></span> <?= __('Privacy Policy') ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Coming soon...</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><span class="fas fa-times"></span> <?= __('Close') ?></button>
            </div>
        </div>
    </div>
</div>