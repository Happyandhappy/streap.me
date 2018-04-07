<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Action $action
 */
$this->assign('title',  $title);
$this->loadHelper('Breadcrumbs', ['templates' => 'app_breadcrumbs']);
$this->Breadcrumbs->add('<span class="fas fa-home"></span>', ['controller' => 'Links', 'action' => 'index'], ['escape' => false]);
$this->Breadcrumbs->add(h($link->name), ['controller' => 'Links', 'action' => 'view', $link->slug], ['escape' => false]);
$this->Breadcrumbs->add(__('Add Action'), '');
?>
<div class="alert alert-success alert-dismissible fade" role="alert" style="background-color:pink; color:white; border-color:white;" id="url_alert">
	Please insert right url	
	<button type="button" class="close" aria-label="Close" id="close_alert">
		<span aria-hidden="true">×</span>
	</button>
</div>

<?= $this->Form->create($action, ['context' => ['validator' => 'individualAdd'],'name'=>"addform"]) ?>
	<fieldset class="action">
	    <legend><?= __('Add Action') ?></legend>
	    <div id="action-input-container">
	    	<?php
				echo $this->Form->control('provider', ['label' => false, 'options' => array(), 'class' => 'hidden form-control']);
				echo $this->Form->control('social',['label' => false, 'options'=>array(), 'class'=> 'hidden form-control', 'placeholder'=> __('Choose one...')]);
				echo $this->Form->control('label', ['label' => false, 'options' => array(), 'class' => 'hidden form-control']);
				echo $this->Form->control('name', ['label' => false, 'placeholder' => __('Custom button label...'), 'class' => 'form-control']);
				echo $this->Form->control('url', ['label' => false, 'placeholder' => __('URL...'), 'class' => 'form-control']);
	    	?>
	    </div>
	</fieldset>
	<p>
		<?= $this->Form->button('<span class="fas fa-save"></span> ' . __('Save'), ['class' => 'btn btn-primary']) ?>
		<?= $this->Html->link('<span class="fas fa-times"></span> ' . __('Cancel'), ['controller' => 'Links', 'action' => 'view', $link->slug], ['class' => 'btn btn-secondary', 'escape' => false]) ?>
	</p>
<?= $this->Form->end() ?>
</div>
<?= $this->Html->script('actions-globals1.js', ['block' => 'scriptBottom']) ?>
<?= $this->Html->script('actions-add1.js', ['block' => 'scriptBottom']) ?>