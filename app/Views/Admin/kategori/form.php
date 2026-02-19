<?= $this->extend('layout/main') ?>

<?= $this->section('title') ?>
<?= ($mode ?? 'tambah') == 'tambah' ? 'Tambah Kategori' : 'Edit Kategori' ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="bg-white p-6 rounded-2xl shadow-sm border border-sage-border max-w-2xl mx-auto">
    <div class="mb-8 border-b border-sage-border pb-4">
        <h3 class="text-xl font-bold text-sage-text">
            <?= ($mode ?? 'tambah') == 'tambah' ? '✨ Tambah Kategori' : '✏️ Edit Kategori' ?>
        </h3>
        <p class="text-sm text-sage-text/60 mt-1">Lengkapi informasi kategori menu di bawah ini.</p>
    </div>

    <?php 
        $currentMode = $mode ?? 'tambah';
        $id = $data['id_kategori'] ?? '';
        $actionUrl = ($currentMode == 'tambah') ? base_url('admin/kategori/store') : base_url('admin/kategori/update/' . $id);
    ?>

    <form action="<?= $actionUrl ?>" method="post">
        <?= csrf_field() ?>

        <div class="space-y-6">
            <div>
                <label class="block text-xs font-bold text-sage-text uppercase mb-2 ml-1">Nama Kategori</label>
                <input type="text" name="nama_kategori" value="<?= $data['nama_kategori'] ?? '' ?>" required placeholder="Contoh: Makanan Berat"
                       class="w-full p-3 bg-gray-50 border border-sage-border rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/50 focus:bg-white text-sage-text transition-all placeholder-gray-400 font-medium">
            </div>

            <div>
                <label class="block text-xs font-bold text-sage-text uppercase mb-3">Status Ketersediaan</label>
                <div class="flex flex-col gap-3">
                    <label class="flex items-center gap-3 p-3 bg-white border border-sage-border rounded-xl cursor-pointer hover:border-primary transition-colors">
                        <input type="radio" name="status_kategori" value="tersedia" class="accent-primary w-4 h-4" <?= (isset($data['status_kategori']) && $data['status_kategori'] == 'tersedia') ? 'checked' : '' ?>>
                        <span class="text-sm font-medium text-sage-text">✅ Tersedia</span>
                    </label>
                    <label class="flex items-center gap-3 p-3 bg-white border border-sage-border rounded-xl cursor-pointer hover:border-red-400 transition-colors">
                        <input type="radio" name="status_kategori" value="tidak tersedia" class="accent-red-500 w-4 h-4" <?= (isset($data['status_kategori']) && $data['status_kategori'] == 'tidak tersedia') ? 'checked' : '' ?>>
                        <span class="text-sm font-medium text-sage-text">❌ Tidak Tersedia</span>
                    </label>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end gap-4 mt-8 pt-6 border-t border-sage-border">
            <a href="<?= base_url('admin/kategori') ?>" class="px-6 py-2.5 rounded-xl text-sage-text font-semibold hover:bg-gray-100 transition-colors">Batal</a>
            <button type="submit" class="bg-primary hover:bg-primary-hover text-white px-8 py-2.5 rounded-xl font-bold shadow-lg shadow-primary/30 transition-all transform hover:-translate-y-0.5 flex items-center gap-2">
                <span class="material-symbols-outlined text-lg">save</span> Simpan Perubahan
            </button>
        </div>
    </form>
</div>
<?= $this->endSection() ?>