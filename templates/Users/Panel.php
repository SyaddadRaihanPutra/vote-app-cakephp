<div class="row">
    <div class="column-responsive column">
        <div class="users form content">
            <?= $this->Form->create($user) ?>
            <fieldset>
                <legend><?= __('Masuk dengan Akun Administator') ?></legend>
                <?= $this->Form->control('username', ['required' => true]) ?>
                <?= $this->Form->control('password', ['required' => true]) ?>
            </fieldset>
            <?= $this->Form->button(__('Login')); ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
