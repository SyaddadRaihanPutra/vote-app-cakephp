ini halaman users
<table class="table is-bordered is-fullwidth">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?= h($user->id) ?></td>
                <td><?= h($user->username) ?></td>
                <td><?= h($user->nis) ?></td>
                <td>
                    <?= $this->Html->link('Edit', ['action' => 'edit', $user->id]) ?> |
                    <?= $this->Html->link('Hapus', ['action' => 'delete', $user->id], ['confirm' => 'Apakah Anda yakin ingin menghapus pengguna ini?']) ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- Tambahkan navigasi pagination -->
<?= $this->Paginator->prev('Sebelumnya') ?>
<?= $this->Paginator->numbers() ?>
<?= $this->Paginator->next('Selanjutnya') ?>
