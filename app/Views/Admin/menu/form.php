<?= $this->extend('layout/main') ?>

<?= $this->section('title') ?>
<?= $mode == 'tambah' ? 'Tambah Menu' : 'Edit Menu' ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="form-container">
    <form action="<?= $mode == 'tambah' ? base_url('admin/menu/store') : base_url('admin/menu/update/' . $menu['id_menu']) ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>

        <div class="form-group">
            <label>Nama Menu</label>
            <input type="text" name="nama_menu" value="<?= $menu['nama_menu'] ?? '' ?>" required>
        </div>

        <div class="form-group">
            <label>Deskripsi</label>
            <textarea name="deskripsi"><?= $menu['deskripsi'] ?? '' ?></textarea>
        </div>

        <div class="form-group">
            <label>Kategori</label>
            <select name="id_kategori" required>
                <option value="">-- Pilih Kategori --</option>
                <option value="kat001" <?= (isset($menu) && $menu['id_kategori'] == 'kat001') ? 'selected' : '' ?>>Makanan (kat001)</option>
                <option value="kat002" <?= (isset($menu) && $menu['id_kategori'] == 'kat002') ? 'selected' : '' ?>>Minuman (kat002)</option>
            </select>
        </div>

        <div class="form-group">
            <label>Harga (Rp)</label>
            <input type="number" name="harga" value="<?= $menu['harga'] ?? '' ?>" required>
        </div>

        <div class="form-group">
            <label>Status</label>
            <select name="status_menu" required>
                <option value="tersedia" <?= (isset($menu) && $menu['status_menu'] == 'tersedia') ? 'selected' : '' ?>>Tersedia</option>
                <option value="habis" <?= (isset($menu) && $menu['status_menu'] == 'habis') ? 'selected' : '' ?>>Habis</option>
            </select>
        </div>

        <div class="form-group">
            <label>Gambar</label>
            <?php if ($mode == 'edit' && !empty($menu['gambar'])) : ?>
                <div class="image-preview">
                    <img src="<?= base_url('assets/image/' . $menu['gambar']) ?>">
                </div>
            <?php endif; ?>
            <input type="file" name="gambar" accept="image/*">
        </div>

        <div class="form-buttons">
            <a href="<?= base_url('admin/menu') ?>" class="btn-cancel">Batal</a>
            <button type="submit" class="btn-filter" style="border:none;">Simpan</button>
        </div>
    </form>
</div>

<?= $this->endSection() ?>