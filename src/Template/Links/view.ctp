<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Link $link
 */
$this->assign('title',  $title);
$this->loadHelper('Breadcrumbs', ['templates' => 'app_breadcrumbs']);
$this->Breadcrumbs->add('<span class="fas fa-home"></span>', ['controller' => 'Links', 'action' => 'index'], ['escape' => false]);
$this->Breadcrumbs->add(h($link->name));
$this->Html->css('/lib/jquery-ui/jquery-ui.min.css');
$this->Html->css('/lib/jquery-ui/jquery-ui.structure.min.css');
$this->Html->script('/lib/jquery-ui/jquery-ui.min.js', ['block' => 'scriptBottom']);
$this->Html->script('/lib/touch-punch/touch-punch.min.js', ['block' => 'scriptBottom']);
$this->Html->script('links-view.js', ['block' => 'scriptBottom']);
?>
<h1><?= h($link->name) ?> <?= $this->Html->link('<span class="fas fa-edit"><span>', '#', ['escape' => false, 'id' => 'linkNameModalTrigger', 'class' => 'btn btn-primary', 'title' => __('Edit name')]) ?></h1>
<p>
	<div class="btn-toolbar">
		<?= $this->Html->link('<span class="fas fa-eye"></span> ' . __('Preview'), ['controller' => 'Links', 'action' => 'display', $link->slug], ['escape' => false, 'class' => 'btn btn-primary', 'target' => '_blank']) ?>
		<?= $this->Form->postLink('<span class="fas fa-trash"></span> ' . __("Delete Link"), ['action' => 'delete', $link->slug], ['class' => 'btn btn-danger', 'escape' => false, 'confirm' => __('Are you sure you want to delete this link and all it\'s actions?')]) ?>
	</div>
</p>
<div class="table-responsive-sm">
	<table class="table table-sm table-striped">
		<tbody>
			<tr>
				<th><?= __('Heading') ?></th>
				<td><?= h($link->heading) ?> <?= $this->Html->link('<span class="fas fa-edit"><span>', '#', ['escape' => false, 'id' => 'linkHeadingModalTrigger',  'class' => 'btn btn-sm btn-primary', 'title' => __('Edit heading')]) ?></td>
			</tr>
			<tr>
				<th><?= __('Button Label') ?></th>
				<td><?= h($link->button_label) ?> <?= $this->Html->link('<span class="fas fa-edit"><span>', '#', ['escape' => false, 'id' => 'linkButtonLabelModalTrigger', 'class' => 'btn btn-sm btn-primary', 'title' => __('Edit button label')]) ?></td>
			</tr>
			<tr>
				<th><?= __('URL') ?></th>
				<td><?= $this->Html->link($link->url) ?></td>
			</tr>
			<tr>
				<th><?= __('Views') ?></th>
				<td><?= $this->Number->format($link->view_count) ?></td>
			</tr>
			<tr>
				<th><?= __('Completions') ?></th>
				<td><?= $this->Number->format($link->completion_count) ?></td>
			</tr>
		</tbody>
	</table>
</div>
<?php if ($link->actions) : ?>
	<h2><?= __('Actions') ?></h2>
	<p>
		<div class="btn-toolbar">
		<?php if (count($link->actions) < 4) : ?>
			<?= $this->Html->link('<span class="fas fa-plus"></span> ' . __('Add Action'), ['controller' => 'Actions', 'action' => 'add', $link->slug], ['escape' => false, 'class' => 'btn btn-primary']) ?>
		<?php endif; ?>
			<?= $this->Html->link('<span class="fas fa-sort"></span> ' . __('Reorder'), '#', ['id' => 'actionReorderModalTrigger', 'escape' => false, 'class' => 'btn btn-primary']) ?>
		</div>
	</p>
	<div class="table-responsive-sm">
		<table class="table table-sm table-striped">
			<thead>
				<tr>
					<th scope="col"><?= __('Name') ?></th>
					<th scope="col"><?= __('URL') ?></th>
					<th scope="col"><?= __('Clicks') ?></th>
					<th scope="col"></th>
				</tr>
			</thead>
			<tbody>
			<?php foreach ($link->actions as $key => $action) : ?>
				<tr>
					<th scope="row"><?= h($action->name) ?> <?= $this->Html->link('<span class="fas fa-edit"><span>', '#', ['escape' => false, 'id' => 'actionName' . $key . 'ModalTrigger', 'class' => 'btn btn-sm btn-primary', 'title' => __('Edit action name')]) ?></th>
					<td class=""><?= $this->Html->link($action->url) ?></td>
					<td><?= $this->Number->format($action->click_count) ?></td>
					<td class="text-right"><?= $this->Form->postLink('<span class="fas fa-trash"></span> ' . __('Delete Action'), ['controller' => 'Actions', 'action' => 'delete', $action->id], ['class' => 'btn btn-sm btn-danger', 'escape' => false, 'confirm' => __('Are you sure you want to delete this action?')]) ?></td>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
	</div>
<?php endif; ?>

<!-- Edit link name modal -->
<div class="modal fade" id="linkNameModal" tabindex="-1" role="dialog" aria-labelledby="linkNameModalTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="linkNameModalLongTitle"><span class="fas fa-edit"></span> <?= __('Edit: Link Name') ?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<?= $this->Form->create($link, ['id' => 'linkNameModalForm', 'url' => ['action' => 'edit', $link->slug], 'context' => ['validator' => 'singleFieldEdit']]) ?>
			        <?= $this->Form->control('name', ['label' => false, 'placeholder' => __('Name...'), 'class' => 'form-control']) ?>
				<?= $this->Form->end() ?>
			</div>
			<div class="modal-footer">
                <?= $this->Form->button('<span class="fas fa-times"></span> ' . __('Cancel'), ['class' => 'btn btn-secondary', 'data-dismiss' => 'modal']) ?>
                <?= $this->Form->button('<span class="fas fa-save"></span> ' . __('Save'), ['id' => 'linkNameModalSubmitButton', 'class' => 'btn btn-primary']) ?>
			</div>
		</div>
	</div>
</div>

<!-- Edit link heading modal -->
<div class="modal fade" id="linkHeadingModal" tabindex="-1" role="dialog" aria-labelledby="linkHeadingModalTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="linkHeadingModalLongTitle"><span class="fas fa-edit"></span> <?= __('Edit: Link Heading') ?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<?= $this->Form->create($link, ['id' => 'linkHeadingModalForm', 'url' => ['action' => 'edit', $link->slug], 'context' => ['validator' => 'singleFieldEdit']]) ?>
			        <?= $this->Form->control('heading', ['label' => false, 'placeholder' => __('Heading...'), 'class' => 'form-control']) ?>
				<?= $this->Form->end() ?>
			</div>
			<div class="modal-footer">
                <?= $this->Form->button('<span class="fas fa-times"></span> ' . __('Cancel'), ['class' => 'btn btn-secondary', 'data-dismiss' => 'modal']) ?>
                <?= $this->Form->button('<span class="fas fa-save"></span> ' . __('Save'), ['id' => 'linkHeadingModalSubmitButton', 'class' => 'btn btn-primary']) ?>
			</div>
		</div>
	</div>
</div>

<!-- Edit link button label modal -->
<div class="modal fade" id="linkButtonLabelModal" tabindex="-1" role="dialog" aria-labelledby="linkButtonLabelModalTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="linkButtonLabelModalLongTitle"><span class="fas fa-edit"></span> <?= __('Edit: Link Success Button Label') ?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<?= $this->Form->create($link, ['id' => 'linkButtonLabelModalForm', 'url' => ['action' => 'edit', $link->slug], 'context' => ['validator' => 'singleFieldEdit']]) ?>
			        <?= $this->Form->control('button_label', ['label' => false, 'placeholder' => __('Success button label...'), 'class' => 'form-control']) ?>
				<?= $this->Form->end() ?>
			</div>
			<div class="modal-footer">
                <?= $this->Form->button('<span class="fas fa-times"></span> ' . __('Cancel'), ['class' => 'btn btn-secondary', 'data-dismiss' => 'modal']) ?>
                <?= $this->Form->button('<span class="fas fa-save"></span> ' . __('Save'), ['id' => 'linkButtonLabelModalSubmitButton', 'class' => 'btn btn-primary']) ?>
			</div>
		</div>
	</div>
</div>

<?php foreach ($link->actions as $key => $action) : ?>
<!-- Edit action name modal -->
<div class="modal fade" id="actionName<?= $key ?>Modal" tabindex="-1" role="dialog" aria-labelledby="actionName<?= $key ?>ModalTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="actionName<?= $key ?>ModalLongTitle"><span class="fas fa-edit"></span> <?= __('Edit: Action Name') ?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<?= $this->Form->create($action, ['id' => 'actionName' . $key . 'ModalForm', 'url' => ['controller' => 'Actions', 'action' => 'edit', $action->id]]) ?>
			        <?= $this->Form->control('name', ['label' => false, 'placeholder' => __('URL...'), 'class' => 'form-control']) ?>
				<?= $this->Form->end() ?>
			</div>
			<div class="modal-footer">
                <?= $this->Form->button('<span class="fas fa-times"></span> ' . __('Cancel'), ['class' => 'btn btn-secondary', 'data-dismiss' => 'modal']) ?>
                <?= $this->Form->button('<span class="fas fa-save"></span> ' . __('Save'), ['id' => 'actionName' . $key . 'ModalSubmitButton', 'class' => 'btn btn-primary']) ?>
			</div>
		</div>
	</div>
</div>
<?php endforeach; ?>

<!-- Edit action reorder modal -->
<div class="modal fade" id="actionReorderModal" tabindex="-1" role="dialog" aria-labelledby="actionReorderModalTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="actionReorderModalLongTitle"><span class="fas fa-edit"></span> <?= __('Drag To Reorder') ?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<?= $this->Form->create($link, ['id' => 'actionReorderModalForm', 'url' => ['controller' => 'Links', 'action' => 'reorderActions', $link->slug], 'context' => ['validator' => null]]) ?>
					<ul id="sortable-action-list" class="list-unstyled">
					<?php foreach ($link->actions as $action) : ?>
						<li class="ui-state-default sortable-list-item">
							<span class="fas fa-sort reorder-icon"></span>
							<span class="reorder-name"><?= h($action->name) ?></span> - <span class="reorder-url text-muted small"><?= $this->Text->truncate(h($action->url), 20) ?></span>
					        <?= $this->Form->control('sort[]', ['type' => 'hidden', 'value' => $action->id]) ?>
						</li>
					<?php endforeach; ?>
					</ul>
				<?= $this->Form->end() ?>
			</div>
			<div class="modal-footer">
                <?= $this->Form->button('<span class="fas fa-times"></span> ' . __('Cancel'), ['class' => 'btn btn-secondary', 'data-dismiss' => 'modal']) ?>
                <?= $this->Form->button('<span class="fas fa-save"></span> ' . __('Save'), ['id' => 'actionReorderModalSubmitButton', 'class' => 'btn btn-primary']) ?>
			</div>
		</div>
	</div>
</div>
