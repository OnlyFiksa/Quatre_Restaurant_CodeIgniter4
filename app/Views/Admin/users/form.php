<?= $this->extend('layout/main') ?>

<?= $this->section('title') ?>
<?= $mode == 'tambah' ? 'Tambah User' : 'Edit User' ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="form-container">
    <form action="<?= $mode == 'tambah' ? base_url('admin/users/store') : base_url('admin/users/update/' . $user['id_admin']) ?>" method="post">
        <?= csrf_field() ?>

        <div class="form-group">
            <label>Nama Lengkap</label>
            <input type="text" name="nama" value="<?= $user['nama'] ?? '' ?>" required>
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" value="<?= $user['email'] ?? '' ?>" required>
        </div>

        <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" value="<?= $user['username'] ?? '' ?>" required>
        </div>

        <div class="form-group">
            <label>Password <?= $mode == 'edit' ? '(Kosongkan jika tetap)' : '' ?></label>
            <input type="password" name="password" <?= $mode == 'tambah' ? 'required' : '' ?>>
        </div>

        <div class="form-group">
            <label>Jabatan</label>
            <select name="jabatan" required>
                <option value="Staff" <?= (isset($user) && $user['jabatan'] == 'Staff') ? 'selected' : '' ?>>Staff</option>
                <option value="Supervisor" <?= (isset($user) && $user['jabatan'] == 'Supervisor') ? 'selected' : '' ?>>Supervisor</option>
                <option value="Owner" <?= (isset($user) && $user['jabatan'] == 'Owner') ? 'selected' : '' ?>>Owner</option>
            </select>
        </div>

        <div class="form-buttons">
            <a href="<?= base_url('admin/users') ?>" class="btn-cancel">Batal</a>
            <button type="submit" class="btn-filter" style="border:none;">Simpan</button> </div>

    </form>
</div>

<?= $this->endSection() ?>