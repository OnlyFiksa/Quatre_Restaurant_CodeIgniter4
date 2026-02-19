<?= $this->extend('layout/main') ?>

<?= $this->section('title') ?>
Kelola Kategori
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="bg-white p-6 rounded-2xl shadow-sm border border-sage-border">
    
    <div class="flex flex-col sm:flex-row justify-between items-center gap-4 mb-6">
        <div>
            <h3 class="text-lg font-bold text-sage-text">Daftar Kategori</h3>
            <p class="text-xs text-sage-text/60">Kelola kategori untuk pengelompokan menu.</p>
        </div>
        <a href="<?= base_url('admin/kategori/tambah') ?>" class="bg-primary hover:bg-primary-hover text-white px-5 py-2.5 rounded-xl text-sm font-semibold shadow-lg shadow-primary/30 transition-all flex items-center gap-2">
            <span class="material-symbols-outlined text-lg">add</span> Tambah Kategori
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-sage-soft text-sage-text text-xs uppercase tracking-wider">
                    <th class="p-4 rounded-l-xl font-bold">ID Kategori</th>
                    <th class="p-4 font-bold">Nama Kategori</th>
                    <th class="p-4 font-bold">Status</th>
                    <th class="p-4 rounded-r-xl font-bold text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-sm divide-y divide-sage-border">
                <?php if(empty($kategori)): ?>
                    <tr><td colspan="4" class="p-8 text-center text-sage-text/40 italic">Belum ada data kategori.</td></tr>
                <?php else: ?>
                    <?php foreach ($kategori as $k) : ?>
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="p-4 font-mono text-sage-text/70"><?= $k['id_kategori'] ?></td>
                        <td class="p-4 font-bold text-sage-text"><?= $k['nama_kategori'] ?></td>
                        <td class="p-4">
                            <?php if($k['status_kategori'] == 'tersedia'): ?>
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-600 border border-emerald-200 flex w-fit items-center gap-1">
                                    <span class="size-1.5 bg-emerald-500 rounded-full"></span> Tersedia
                                </span>
                            <?php else: ?>
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-600 border border-red-200 flex w-fit items-center gap-1">
                                    <span class="size-1.5 bg-red-500 rounded-full"></span> Tidak Tersedia
                                </span>
                            <?php endif; ?>
                        </td>
                        <td class="p-4 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <a href="<?= base_url('admin/kategori/edit/' . $k['id_kategori']) ?>" class="size-8 rounded-lg bg-orange-100 text-orange-500 hover:bg-orange-500 hover:text-white flex items-center justify-center transition-all">
                                    <span class="material-symbols-outlined text-lg">edit</span>
                                </a>
                                <a href="<?= base_url('admin/kategori/hapus/' . $k['id_kategori']) ?>" onclick="return confirm('Hapus kategori ini?')" class="size-8 rounded-lg bg-red-100 text-red-500 hover:bg-red-500 hover:text-white flex items-center justify-center transition-all">
                                    <span class="material-symbols-outlined text-lg">delete</span>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>