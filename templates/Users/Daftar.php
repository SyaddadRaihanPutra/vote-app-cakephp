<div class="row">
    <div class="column-responsive column">
        <div class="users form content">
            <?= $this->Form->create($user) ?>
            <fieldset>
                <legend><?= __('Daftar dengan NIS dan Password yang dimiliki') ?></legend>
                <?= $this->Form->control('nis', ['required' => true]) ?>
                <?= $this->Form->control('username', ['required' => true]) ?>
                <?= $this->Form->control('password', ['required' => true]) ?>
            </fieldset>
            <?= $this->Form->button(__('Daftar')); ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
