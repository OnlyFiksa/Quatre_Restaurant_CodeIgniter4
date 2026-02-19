<?= $this->extend('layout/main') ?>

<?= $this->section('title') ?>
<?= ($mode ?? 'tambah') == 'tambah' ? 'Tambah Menu Baru' : 'Edit Data Menu' ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="bg-white p-6 rounded-2xl shadow-sm border border-sage-border">
    
    <div class="mb-8 border-b border-sage-border pb-4">
        <h3 class="text-xl font-bold text-sage-text">
            <?= ($mode ?? 'tambah') == 'tambah' ? '✨ Tambah Menu Baru' : '✏️ Edit Menu' ?>
        </h3>
        <p class="text-sm text-sage-text/60 mt-1">Silakan lengkapi informasi menu di bawah ini.</p>
    </div>

    <?php 
        $currentMode = $mode ?? 'tambah';
        $menuId = $menu['id_menu'] ?? '';
        // Determine action URL based on mode
        $actionUrl = ($currentMode == 'tambah') ? base_url('admin/menu/store') : base_url('admin/menu/update/' . $menuId);
    ?>

    <form action="<?= $actionUrl ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="lg:col-span-2 space-y-6">
                
                <div>
                    <label class="block text-xs font-bold text-sage-text uppercase mb-2 ml-1">Nama Menu</label>
                    <input type="text" name="nama_menu" value="<?= $menu['nama_menu'] ?? '' ?>" required placeholder="Contoh: Nasi Goreng Spesial"
                           class="w-full p-3 bg-gray-50 border border-sage-border rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/50 focus:bg-white text-sage-text transition-all placeholder-gray-400 font-medium">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    
                    <div>
                        <label class="block text-xs font-bold text-sage-text uppercase mb-2 ml-1">Kategori</label>
                        <div class="relative">
                            <select name="id_kategori" required class="w-full p-3 bg-gray-50 border border-sage-border rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/50 focus:bg-white text-sage-text transition-all appearance-none cursor-pointer font-medium">
                                <option value="">-- Pilih Kategori --</option>
                                <?php 
                                    $listKategori = $kategori ?? []; 
                                    $selectedKat = $menu['id_kategori'] ?? '';

                                    foreach($listKategori as $kat): 
                                ?>
                                    <option value="<?= $kat['id_kategori'] ?>" <?= $selectedKat == $kat['id_kategori'] ? 'selected' : '' ?>>
                                        🍽️ <?= esc($kat['nama_kategori']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-sage-text">
                                <span class="material-symbols-outlined text-sm">expand_more</span>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-sage-text uppercase mb-2 ml-1">Harga (Rp)</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-sage-text/50 font-bold">Rp</span>
                            <input type="number" name="harga" value="<?= $menu['harga'] ?? '' ?>" required placeholder="0"
                                   class="w-full p-3 pl-10 bg-gray-50 border border-sage-border rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/50 focus:bg-white text-sage-text transition-all font-medium">
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-sage-text uppercase mb-2 ml-1">Deskripsi Menu</label>
                    <textarea name="deskripsi" rows="4" placeholder="Jelaskan detail menu..."
                              class="w-full p-3 bg-gray-50 border border-sage-border rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/50 focus:bg-white text-sage-text transition-all placeholder-gray-400"><?= $menu['deskripsi'] ?? '' ?></textarea>
                </div>
            </div>

            <div class="space-y-6">
                
                <div class="bg-sage-soft/30 p-5 rounded-2xl border border-sage-border">
                    <label class="block text-xs font-bold text-sage-text uppercase mb-3">Status Ketersediaan</label>
                    <div class="flex flex-col gap-3">
                        
                        <label class="flex items-center gap-3 p-3 bg-white border border-sage-border rounded-xl cursor-pointer hover:border-primary transition-colors">
                            <input type="radio" name="status_menu" value="tersedia" class="accent-primary w-4 h-4" 
                                <?= ($menu['status_menu'] ?? 'tersedia') == 'tersedia' ? 'checked' : '' ?>>
                            <span class="text-sm font-medium text-sage-text">✅ Tersedia</span>
                        </label>

                        <label class="flex items-center gap-3 p-3 bg-white border border-sage-border rounded-xl cursor-pointer hover:border-red-400 transition-colors">
                            <input type="radio" name="status_menu" value="habis" class="accent-red-500 w-4 h-4" 
                                <?= ($menu['status_menu'] ?? '') == 'habis' ? 'checked' : '' ?>>
                            <span class="text-sm font-medium text-sage-text">❌ Habis</span>
                        </label>

                    </div>
                </div>

                <div class="bg-white p-4 rounded-2xl border border-sage-border">
                    <label class="block text-xs font-bold text-sage-text uppercase mb-3">Foto Menu</label>
                    
                    <?php if ($currentMode == 'edit' && !empty($menu['gambar'])) : ?>
                        <div class="mb-4 relative group">
                            <div class="aspect-video w-full overflow-hidden rounded-xl border border-gray-200">
                                <img src="<?= base_url('assets/image/' . $menu['gambar']) ?>" class="w-full h-full object-cover">
                            </div>
                            <p class="text-xs text-center mt-2 text-sage-text/60">Foto saat ini</p>
                        </div>
                    <?php endif; ?>

                    <label class="block">
                        <span class="sr-only">Choose profile photo</span>
                        <input type="file" name="gambar" accept="image/*" class="block w-full text-sm text-sage-text
                            file:mr-4 file:py-2.5 file:px-4
                            file:rounded-full file:border-0
                            file:text-xs file:font-bold
                            file:bg-primary file:text-white
                            hover:file:bg-primary-hover
                            cursor-pointer border border-gray-200 rounded-xl bg-gray-50
                        "/>
                    </label>
                    <p class="text-[10px] text-gray-400 mt-2 ml-1">*Upload untuk mengganti foto (Opsional)</p>
                </div>

            </div>
        </div>

        <div class="flex items-center justify-end gap-4 mt-8 pt-6 border-t border-sage-border">
            <a href="<?= base_url('admin/menu') ?>" class="px-6 py-2.5 rounded-xl text-sage-text font-semibold hover:bg-gray-100 transition-colors">
                Batal
            </a>
            <button type="submit" class="bg-primary hover:bg-primary-hover text-white px-8 py-2.5 rounded-xl font-bold shadow-lg shadow-primary/30 transition-all transform hover:-translate-y-0.5 flex items-center gap-2">
                <span class="material-symbols-outlined text-lg">save</span> Simpan Perubahan
            </button>
        </div>

    </form>
</div>

<?= $this->endSection() ?>