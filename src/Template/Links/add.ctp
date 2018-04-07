<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Link $link
 */
$this->assign('title',  $title);
$this->loadHelper('Breadcrumbs', ['templates' => 'app_breadcrumbs']);
$this->Breadcrumbs->add('<span class="fas fa-home"></span>', ['action' => 'index']);
$this->Breadcrumbs->add(__('Add Link'));
?>
<?= $this->Form->create($link) ?>
<?= $this->Flash->render() ?>
<fieldset>
    <h1><?= __('Add Link') ?></h1>
    <?php
        echo $this->Form->control('name', ['label' => false, 'placeholder' => __('Name...'), 'class' => 'form-control']);
        echo $this->Form->control('heading', ['label' => false, 'placeholder' => __('Title ( SUBSCRIBE TO UNLOCK ect )..'), 'class' => 'form-control']);
        echo $this->Form->control('button_label', ['label' => false, 'placeholder' => __('Locked button text...'), 'class' => 'form-control']);
        echo $this->Form->control('url', ['label' => false, 'placeholder' => __('Locked URL...'), 'class' => 'form-control']);
    ?>
</fieldset>
<?php for ($i = 0; $i < 8; $i++) : ?>
<fieldset id="action-<?= $i ?>" style="display: none;">
    <h2><?= __('Action ') . ($i + 1) ?></h2>
    <div id="action-input-container">
        <?= $this->Form->control("provider.$i", ['label' => false, 'options' => array(), 'class' => 'form-control provider-select', 'data-target-select-id' => "#actions-$i-label", 'data-target-input-id' => "#actions-$i-name"]) ?>
        <?= $this->Form->control("social.$i", ['label'=>false, 'options'=>array(), 'class'=>'hidden form-control social-select', 'data-target-id'=>"#actions-$i-social"]) ?>
        <?= $this->Form->control("label.$i", ['label' => false, 'options' => array(), 'class' => 'hidden form-control label-select', 'data-target-id' => "#actions-$i-name"]) ?>
        <?= $this->Form->control("name.$i", ['label' => false, 'placeholder' => __('Custom button label...'), 'class' => 'hidden form-control']) ?>
        <?= $this->Form->control("url.$i", ['label' => false, 'placeholder' => __('Action URL...'), 'class' => 'form-control']) ?>
    </div>
</fieldset>
<?php endfor; ?>
<p>
    <?= $this->form->button('<span class="fas fa-plus"></span> ' . __('Add Action'), ['id' => 'add-action-button', 'class' => 'btn btn-sm btn-secondary', 'type' => 'button']) ?>
    <?= $this->form->button('<span class="fas fa-minus"></span> ' . __('Remove Action'), ['id' => 'remove-action-button', 'class' => 'btn btn-sm btn-secondary', 'type' => 'button']) ?>
</p>
<?= $this->Form->button('<span class="fas fa-save"></span> ' . __('Save Link'), ['class' => 'btn btn-primary']) ?>
<?= $this->Form->end() ?>

<?= $this->Html->script('actions-globals-fixed.js', ['block' => 'scriptBottom']) ?>
<?= $this->Html->script('links-add-fixed.js', ['block' => 'scriptBottom']) ?>