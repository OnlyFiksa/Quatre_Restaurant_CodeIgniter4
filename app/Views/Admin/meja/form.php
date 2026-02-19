<?= $this->extend('layout/main') ?>

<?= $this->section('title') ?>
<?= ($mode ?? 'tambah') == 'tambah' ? 'Tambah Meja' : 'Edit Meja' ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="bg-white p-6 rounded-2xl shadow-sm border border-sage-border max-w-2xl mx-auto">
    <div class="mb-8 border-b border-sage-border pb-4">
        <h3 class="text-xl font-bold text-sage-text">
            <?= ($mode ?? 'tambah') == 'tambah' ? '✨ Tambah Meja Baru' : '✏️ Edit Data Meja' ?>
        </h3>
        <p class="text-sm text-sage-text/60 mt-1">Lengkapi informasi meja restoran di bawah ini.</p>
    </div>

    <?php 
        $currentMode = $mode ?? 'tambah';
        $id = $data['id_meja'] ?? '';
        $actionUrl = ($currentMode == 'tambah') ? base_url('admin/meja/store') : base_url('admin/meja/update/' . $id);
    ?>

    <form action="<?= $actionUrl ?>" method="post">
        <?= csrf_field() ?>

        <div class="space-y-6">
            <div>
                <label class="block text-xs font-bold text-sage-text uppercase mb-2 ml-1">Nomor Meja</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-sage-text/50 font-bold text-sm">No.</span>
                    <input type="number" name="nomor_meja" value="<?= $data['nomor_meja'] ?? '' ?>" required placeholder="12"
                           class="w-full p-3 pl-10 bg-gray-50 border border-sage-border rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/50 focus:bg-white text-sage-text transition-all font-bold text-lg">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-sage-text uppercase mb-3">Status Meja</label>
                <div class="flex flex-col gap-3">
                    <label class="flex items-center gap-3 p-3 bg-white border border-sage-border rounded-xl cursor-pointer hover:border-emerald-400 transition-colors">
                        <input type="radio" name="status_meja" value="tersedia" class="accent-emerald-500 w-4 h-4" <?= (isset($data['status_meja']) && $data['status_meja'] == 'tersedia') ? 'checked' : '' ?>>
                        <span class="text-sm font-medium text-sage-text">✅ Tersedia (Kosong)</span>
                    </label>
                    <label class="flex items-center gap-3 p-3 bg-white border border-sage-border rounded-xl cursor-pointer hover:border-orange-400 transition-colors">
                        <input type="radio" name="status_meja" value="terisi" class="accent-orange-500 w-4 h-4" <?= (isset($data['status_meja']) && $data['status_meja'] == 'terisi') ? 'checked' : '' ?>>
                        <span class="text-sm font-medium text-sage-text">🍽️ Terisi (Sedang Makan)</span>
                    </label>
                    <label class="flex items-center gap-3 p-3 bg-white border border-sage-border rounded-xl cursor-pointer hover:border-red-400 transition-colors">
                        <input type="radio" name="status_meja" value="tidak_tersedia" class="accent-gray-500 w-4 h-4" <?= (isset($data['status_meja']) && $data['status_meja'] == 'tidak_tersedia') ? 'checked' : '' ?>>
                        <span class="text-sm font-medium text-sage-text">🚫 Tidak Tersedia (Rusak/Off)</span>
                    </label>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end gap-4 mt-8 pt-6 border-t border-sage-border">
            <a href="<?= base_url('admin/meja') ?>" class="px-6 py-2.5 rounded-xl text-sage-text font-semibold hover:bg-gray-100 transition-colors">Batal</a>
            <button type="submit" class="bg-primary hover:bg-primary-hover text-white px-8 py-2.5 rounded-xl font-bold shadow-lg shadow-primary/30 transition-all transform hover:-translate-y-0.5 flex items-center gap-2">
                <span class="material-symbols-outlined text-lg">save</span> Simpan Perubahan
            </button>
        </div>
    </form>
</div>
<?= $this->endSection() ?>