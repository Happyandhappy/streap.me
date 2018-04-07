<?php $this->loadHelper('Paginator', ['templates' => 'app_paginator']); ?>
<div class="hidden">
    <div id="dynamic-table-container" class="table-responsive-sm">
        <table class="table table-sm table-striped">
            <thead>
                <tr>
                    <th scope="col" class="col-4"><?= $this->Paginator->sort('name') ?></th>
                    <th scope="col" class="col-2 text-center"><?= $this->Paginator->sort('view_count', __('Views')) ?></th>
                    <th scope="col" class="col-2 text-center"><?= $this->Paginator->sort('completion_count', __('Completions')) ?></th>
                    <th scope="col" class="col-4"></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($links as $link) : ?>
                <tr>
                    <td><?= $this->Html->link(h($link->name), ['action' => 'view', $link->slug]) ?></td>
                    <td class="text-center"><?= $this->Number->format($link->view_count) ?></td>
                    <td class="text-center"><?= $this->Number->format($link->completion_count) ?></td>
                    <td class="text-right">
                        <?= $this->Form->button('<span class="fas fa-sign-out-alt" data-fa-transform="rotate-270"></span> ' . __(''), ['escape' => false, 'class' => 'btn btn-secondary share-button', 'data-share-url' => $this->Url->build('/' . $link->slug, true)]) ?>
                        <?= $this->Html->link('<span class="fas fa-bars"></span> ' . __(''), ['action' => 'view', $link->slug], ['escape' => false, 'class' => 'btn btn-secondary']) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator text-center">
        <nav aria-label="page navigation">
            <ul id="pagination-container" class="pagination justify-content-center">
                <?= $this->Paginator->first() ?>
                <?= $this->Paginator->prev() ?>
                <?= $this->Paginator->numbers() ?>
                <?= $this->Paginator->next() ?>
                <?= $this->Paginator->last() ?>
            </ul>
        </nav>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} out of {{count}} total')]) ?></p>
    </div>
</div>