<?= $this->extend('layout/main') ?>

<?= $this->section('title') ?>
Kelola Menu
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="bg-white p-6 rounded-2xl shadow-sm border border-sage-border">
    
    <div class="flex flex-col sm:flex-row justify-between items-center gap-4 mb-6">
        <div>
            <h3 class="text-lg font-bold text-sage-text">Daftar Menu Makanan</h3>
            <p class="text-xs text-sage-text/60">Kelola daftar menu yang tersedia di restoran.</p>
        </div>
        <a href="<?= base_url('admin/menu/tambah') ?>" class="bg-primary hover:bg-primary-hover text-white px-5 py-2.5 rounded-xl text-sm font-semibold shadow-lg shadow-primary/30 transition-all flex items-center gap-2">
            <span class="material-symbols-outlined text-lg">add</span> Tambah Menu
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-sage-soft text-sage-text text-xs uppercase tracking-wider">
                    <th class="p-4 rounded-l-xl font-bold">Gambar</th>
                    <th class="p-4 font-bold">Nama Menu</th>
                    <th class="p-4 font-bold">Harga</th>
                    <th class="p-4 font-bold">Status</th>
                    <th class="p-4 rounded-r-xl font-bold text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-sm divide-y divide-sage-border">
                <?php if(empty($menus)): ?>
                    <tr>
                        <td colspan="5" class="p-8 text-center text-sage-text/40 italic">Belum ada data menu.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($menus as $m) : ?>
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="p-4">
                            <img src="<?= base_url('assets/image/' . $m['gambar']) ?>" class="w-16 h-16 object-cover rounded-xl shadow-sm border border-sage-border" onerror="this.src='https://via.placeholder.com/100'">
                        </td>
                        <td class="p-4 font-semibold text-sage-text"><?= esc($m['nama_menu']) ?></td>
                        <td class="p-4 text-sage-text font-medium">Rp <?= number_format($m['harga'], 0, ',', '.') ?></td>
                        
                        <td class="p-4">
                            <?php if($m['status_menu'] == 'tersedia'): ?>
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-600 border border-emerald-200 flex w-fit items-center gap-1">
                                    <span class="size-1.5 bg-emerald-500 rounded-full"></span> Tersedia
                                </span>
                            <?php else: ?>
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-600 border border-red-200 flex w-fit items-center gap-1">
                                    <span class="size-1.5 bg-red-500 rounded-full"></span> Habis
                                </span>
                            <?php endif; ?>
                        </td>
                        <td class="p-4 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <a href="<?= base_url('admin/menu/edit/' . $m['id_menu']) ?>" class="size-8 rounded-lg bg-orange-100 text-orange-500 hover:bg-orange-500 hover:text-white flex items-center justify-center transition-all">
                                    <span class="material-symbols-outlined text-lg">edit</span>
                                </a>
                                <a href="<?= base_url('admin/menu/hapus/' . $m['id_menu']) ?>" onclick="return confirm('Hapus menu ini?')" class="size-8 rounded-lg bg-red-100 text-red-500 hover:bg-red-500 hover:text-white flex items-center justify-center transition-all">
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