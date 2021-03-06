<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <?php if ($user['role'] === 'admin'): ?>
          <li><?= $this->Html->link(__('管理者用の行動計画ページに戻る'), ['controller' => 'Admins', 'action' => 'activities', $plan['activity']['user_id']]) ?></li>
        <?php else: ?>
          <li><?= $this->Html->link(__('行動計画ページに戻る'), ['controller' => 'Activities', 'action' => 'index']) ?></li>
        <?php endif ?>
    </ul>
</nav>
<div class="plans form large-9 medium-8 columns content">
    <?= $this->Form->create($plan) ?>
    <fieldset>
        <legend><?= __('ToDoを修正する') ?></legend>
        <div class="row">
          <div class="form-group col-xs-12">
            <?= $this->Form->input('todo', ['type' => 'text', 'class' => 'form-control']); ?>
          </div>
        </div>
        <div class="row">
          <div class="form-group col-sm-3 col-sm-offset-5">
            <?= $this->Form->input('weight', ['label' => '重要度(1~5)', 'min' => MINPRIORITY, 'max' => MAXPRIORITY, 'class' => 'form-control']); ?>
          </div>
          <div class="form-group col-sm-4">
            <?= $this->Form->input('status', ['label' => '0=ToDoのまま,_1=タスクへ移動する', 'min' => PROCESS, 'max' => CLOSE, 'class' => 'form-control']); ?>
          </div>
        </div>
        <?php
            echo $this->Form->input('activity_id', ['type' => 'hidden', 'options' => $activities]);
        ?>
    </fieldset>
    <div class="text-right">
      <?= $this->Form->button(__('修正する'), ['class' => 'btn btn-raised btn-success']) ?>
    </div>
    <?= $this->Form->end() ?>
</div>
