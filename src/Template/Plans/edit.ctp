<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li><?= $this->Html->link(__('行動計画ページに戻る'), ['controller' => 'Activities', 'action' => 'index']) ?></li>
    </ul>
</nav>
<div class="plans form large-9 medium-8 columns content">
    <?= $this->Form->create($plan) ?>
    <fieldset>
        <legend><?= __('ToDoを修正する') ?></legend>
        <?php
            echo $this->Form->input('todo');
            echo $this->Form->input('activity_id', ['type' => 'hidden', 'options' => $activities]);
            echo $this->Form->input('weight', ['label' => '重要度', 'min' => MINPRIORITY, 'max' => MAXPRIORITY]);
            echo $this->Form->input('status', ['label' => '状態(0=ToDo,_1=タスクへ移動する)', 'min' => PROCESS, 'max' => CLOSE]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('修正する')) ?>
    <?= $this->Form->end() ?>
</div>