<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Link[]|\Cake\Collection\CollectionInterface $links
 */
$this->assign('title',  $title);
if (!empty($links)) {
    $this->Html->script('links-index.js', ['block' => 'scriptBottom']);
}
?>
<div>
    <h1>
        <div class="d-flex">
            <div class="mr-auto"><?= __('My Stats') ?></div>
            <?= $this->Html->link('<span class="fas fa-plus" ></span> ' . __(' Create'), ['action' => 'add'], ['class' => 'btn btn-light btn-viid-yellow', 'escape' => false]) ?>
        </div>
    </h1>
</div>

<div id="stats-container" class="container-fluid">
    <div class="row">
        <div class="col- col-md-6 col-lg-3 text-center">
            <div class="stat-container">
                <h5><?= __('Impressions') ?></h5>
                <span class="stat-value fas fa-circle-notch fa-spin"></span>
            </div>
        </div>
        <div class="col- col-md-6 col-lg-3 text-center">
            <div class="stat-container">
                <h5><?= __('Uses') ?></h5>
                <span class="stat-value fas fa-circle-notch fa-spin"></span>
            </div>
        </div>
        <div class="col- col-md-6 col-lg-3 text-center">
            <div class="stat-container">
                <h5><?= __('Completions') ?></h5>
                <span class="stat-value fas fa-circle-notch fa-spin"></span>
            </div>
        </div>
        <div class="col- col-md-6 col-lg-3 text-center">
            <div class="stat-container">
                <h5><?= __('Top Countries') ?></h5>
                <span class="stat-value fas fa-circle-notch fa-spin"></span>
            </div>
        </div>
    </div>
</div>

</div>

<h2><?= __('My Links') ?></h2>
	<p>WE HAVE CONTINUED DEVELOPMENT! IT'S GOING TO GET EPIC!</p>

<div id="link-table-container">
	<div class="text-center">
	        <?php if (!empty($links)) : ?>
        <span class="stat-value fas fa-circle-notch fa-spin"></span>
    <?php endif; ?>
	</div>
</div>

<!-- Link creation alert modal -->
<?php if (isset($alertLink)) : ?>
<div class="modal fade" id="linkCreationModal" tabindex="-1" role="dialog" aria-labelledby="linkCreationModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="linkCreationModalLongTitle"><span class="fas fa-share-alt"></span> <?= __('Share Link') ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            	<p>Your new link has been created! Use the copy button below to share it on social media.</p>
                <?= $this->Form->control('button_label', ['id' => 'alert-link-share-url-input', 'label' => false, 'class' => 'form-control', 'readonly' => true, 'value' =>  $this->Url->build('/' . $alertLink->slug, true)]) ?>
                <?= $this->Form->button('<span class="fas fa-clipboard"></span> ' . __('Copy'), ['id' => 'alert-link-copy-button', 'class' => 'btn btn-primary', 'escape' => false]) ?>
            </div>
            <div class="modal-footer">
                <?= $this->Form->button('<span class="fas fa-times"></span> ' . __('Dismiss'), ['class' => 'btn btn-secondary', 'data-dismiss' => 'modal']) ?>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- Share modal -->
<div class="modal fade" id="shareModal" tabindex="-1" role="dialog" aria-labelledby="shareModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="shareModalLongTitle"><span class="fas fa-share-alt"></span> <?= __('Share Link') ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?= $this->Form->control('button_label', ['id' => 'share-url-input', 'label' => false, 'class' => 'form-control', 'readonly' => true]) ?>
                <?= $this->Form->button('<span class="fas fa-clipboard"></span> ' . __('Copy'), ['id' => 'copy-button', 'class' => 'btn btn-primary', 'escape' => false]) ?>
            </div>
            <div class="modal-footer">
                <?= $this->Form->button('<span class="fas fa-times"></span> ' . __('Close'), ['class' => 'btn btn-secondary', 'data-dismiss' => 'modal']) ?>
            </div>
        </div>
    </div>
</div>
