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
                <p>This privacy notice discloses the privacy practices for (website address). This privacy notice applies solely to information collected by this website. It will notify you of the following:</p>
                <ul>
                    <li>What personally identifiable information is collected from you through the website, how it is used and with whom it may be shared.</li>
                    <li>What choices are available to you regarding the use of your data.</li>
                    <li>The security procedures in place to protect the misuse of your information.</li>
                    <li>How you can correct any inaccuracies in the information.</li>
                </ul>

                <h5>Information Collection, Use, and Sharing</h5>
                <p>We are the sole owners of the information collected on this site. We only have access to/collect information that you voluntarily give us via email or other direct contact from you. We will not 
                    sell or rent this information to anyone.</p>

                <p>We will use your information to respond to you, regarding the reason you contacted us. We will not share your information with any third party outside of our organization, other than as necessary 
                    to fulfill your request, e.g. to ship an order.</p>

                <p>Unless you ask us not to, we may contact you via email in the future to tell you about specials, new products or services, or changes to this privacy policy.</p>
                <h5>Your Access to and Control Over Information</h5>
                <p>You may opt out of any future contacts from us at any time. You can do the following at any time by contacting us via the email address or phone number given on our website:</p>

                <ul>
                    <li>See what data we have about you, if any.</li>
                    <li>Change/correct any data we have about you.</li>
                    <li>Have us delete any data we have about you.</li>
                    <li>Express any concern you have about our use of your data.</li>
                </ul>

                <h5>Security</h5>
                <p>We take precautions to protect your information. When you submit sensitive information via the website, your information is protected both online and offline.</p>

                <p>Wherever we collect sensitive information (such as credit card data), that information is encrypted and transmitted to us in a secure way. You can verify this by looking for a lock 
                    icon in the address bar and looking for "https" at the beginning of the address of the Web page.</p>

                <p>While we use encryption to protect sensitive information transmitted online, we also protect your information offline. Only employees who need the information to perform a specific 
                    job (for example, billing or customer service) are granted access to personally identifiable information. The computers/servers in which we store personally identifiable information 
                    are kept in a secure environment.</p>

                <p>If you feel that we are not abiding by this privacy policy, you should contact us immediately via email.</p>
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
                <h4 class="modal-title" id="privacyPolicyModalLongTitle"><span class="fas fa-lock"></span> <?= __('Terms of Service') ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>This privacy notice discloses the privacy practices for (website address). This privacy notice applies solely to information collected by this website. It will notify you of the following:</p>
                <ul>
                    <li>What personally identifiable information is collected from you through the website, how it is used and with whom it may be shared.</li>
                    <li>What choices are available to you regarding the use of your data.</li>
                    <li>The security procedures in place to protect the misuse of your information.</li>
                    <li>How you can correct any inaccuracies in the information.</li>
                </ul>

                <h5>Information Collection, Use, and Sharing</h5>
                <p>We are the sole owners of the information collected on this site. We only have access to/collect information that you voluntarily give us via email or other direct contact from you. We will not 
                    sell or rent this information to anyone.</p>

                <p>We will use your information to respond to you, regarding the reason you contacted us. We will not share your information with any third party outside of our organization, other than as necessary 
                    to fulfill your request, e.g. to ship an order.</p>

                <p>Unless you ask us not to, we may contact you via email in the future to tell you about specials, new products or services, or changes to this privacy policy.</p>
                <h5>Your Access to and Control Over Information</h5>
                <p>You may opt out of any future contacts from us at any time. You can do the following at any time by contacting us via the email address or phone number given on our website:</p>

                <ul>
                    <li>See what data we have about you, if any.</li>
                    <li>Change/correct any data we have about you.</li>
                    <li>Have us delete any data we have about you.</li>
                    <li>Express any concern you have about our use of your data.</li>
                </ul>

                <h5>Security</h5>
                <p>We take precautions to protect your information. When you submit sensitive information via the website, your information is protected both online and offline.</p>

                <p>Wherever we collect sensitive information (such as credit card data), that information is encrypted and transmitted to us in a secure way. You can verify this by looking for a lock 
                    icon in the address bar and looking for "https" at the beginning of the address of the Web page.</p>

                <p>While we use encryption to protect sensitive information transmitted online, we also protect your information offline. Only employees who need the information to perform a specific 
                    job (for example, billing or customer service) are granted access to personally identifiable information. The computers/servers in which we store personally identifiable information 
                    are kept in a secure environment.</p>

                <p>If you feel that we are not abiding by this privacy policy, you should contact us immediately via email.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><span class="fas fa-times"></span> <?= __('Close') ?></button>
            </div>
        </div>
    </div>
</div>