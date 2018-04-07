<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Statistic $statistic
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Back'), ['action' => 'index']) ?> </li>
    </ul>
</nav>
<div class="statistics view large-9 medium-8 columns content">
    <h3><?= h($statistic->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Model') ?></th>
            <td><?= h($statistic->model) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Ip') ?></th>
            <td><?= h($statistic->ip) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Agent') ?></th>
            <td><?= h($statistic->agent) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($statistic->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Foreign Id') ?></th>
            <td><?= $this->Number->format($statistic->foreign_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($statistic->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($statistic->modified) ?></td>
        </tr>
    </table>
</div>
