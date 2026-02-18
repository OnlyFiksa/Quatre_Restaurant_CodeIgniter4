<?= $this->extend('layout/main') ?>

<?= $this->section('title') ?>
<?= ($mode ?? 'tambah') == 'tambah' ? 'Tambah User Baru' : 'Edit Data User' ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="bg-white p-6 rounded-2xl shadow-sm border border-sage-border">
    
    <div class="mb-8 border-b border-sage-border pb-4">
        <h3 class="text-xl font-bold text-sage-text">
            <?= ($mode ?? 'tambah') == 'tambah' ? '✨ Tambah User Baru' : '✏️ Edit User' ?>
        </h3>
        <p class="text-sm text-sage-text/60 mt-1">Lengkapi informasi akun staff di bawah ini.</p>
    </div>

    <?php 
        // Logic URL Action
        $currentMode = $mode ?? 'tambah';
        $userId = $user['id_admin'] ?? $user['id'] ?? '';
        
        $actionUrl = ($currentMode == 'tambah') 
            ? base_url('admin/users/store') 
            : base_url('admin/users/update/' . $userId);
    ?>

    <form action="<?= $actionUrl ?>" method="post">
        <?= csrf_field() ?>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            
            <div class="md:col-span-2">
                <label class="block text-xs font-bold text-sage-text uppercase mb-2 ml-1">Nama Lengkap <span class="text-red-500">*</span></label>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-sage-text/50">badge</span>
                    <input type="text" name="nama" value="<?= $user['nama'] ?? $user['nama_admin'] ?? '' ?>" required placeholder="Masukkan nama lengkap staff"
                           class="w-full p-3 pl-10 bg-gray-50 border border-sage-border rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/50 focus:bg-white text-sage-text transition-all placeholder-gray-400 font-medium">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-sage-text uppercase mb-2 ml-1">Email <span class="text-red-500">*</span></label>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-sage-text/50">mail</span>
                    <input type="email" name="email" value="<?= $user['email'] ?? '' ?>" required placeholder="contoh@email.com"
                           class="w-full p-3 pl-10 bg-gray-50 border border-sage-border rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/50 focus:bg-white text-sage-text transition-all placeholder-gray-400">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-sage-text uppercase mb-2 ml-1">Username Login <span class="text-red-500">*</span></label>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-sage-text/50">person</span>
                    <input type="text" name="username" value="<?= $user['username'] ?? '' ?>" required placeholder="Username untuk login"
                           class="w-full p-3 pl-10 bg-gray-50 border border-sage-border rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/50 focus:bg-white text-sage-text transition-all placeholder-gray-400 font-bold">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-sage-text uppercase mb-2 ml-1">Jabatan / Role <span class="text-red-500">*</span></label>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-sage-text/50">work</span>
                    <select name="jabatan" required 
                            class="w-full p-3 pl-10 bg-gray-50 border border-sage-border rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/50 focus:bg-white text-sage-text transition-all appearance-none cursor-pointer font-medium">
                        <option value="">-- Pilih Jabatan --</option>
                        
                        <?php 
                            $listJabatan = ['Owner', 'Supervisor', 'Staff'];
                            $jabatanUser = $user['jabatan'] ?? '';

                            foreach($listJabatan as $jab):
                        ?>
                            <option value="<?= $jab ?>" <?= $jabatanUser == $jab ? 'selected' : '' ?>>
                                <?= $jab ?>
                            </option>
                        <?php endforeach; ?>

                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-sage-text">
                        <span class="material-symbols-outlined text-sm">expand_more</span>
                    </div>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-sage-text uppercase mb-2 ml-1">
                    Password <?= $currentMode == 'edit' ? '<span class="text-gray-400 normal-case font-normal">(Kosongkan jika tetap)</span>' : '<span class="text-red-500">*</span>' ?>
                </label>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-sage-text/50">lock</span>
                    <input type="password" name="password" <?= $currentMode == 'tambah' ? 'required' : '' ?> placeholder="••••••••"
                           class="w-full p-3 pl-10 bg-gray-50 border border-sage-border rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/50 focus:bg-white text-sage-text transition-all placeholder-gray-400">
                </div>
            </div>

        </div>

        <div class="flex items-center justify-end gap-4 mt-8 pt-6 border-t border-sage-border">
            <a href="<?= base_url('admin/users') ?>" class="px-6 py-2.5 rounded-xl text-sage-text font-semibold hover:bg-gray-100 transition-colors">
                Batal
            </a>
            <button type="submit" class="bg-primary hover:bg-primary-hover text-white px-8 py-2.5 rounded-xl font-bold shadow-lg shadow-primary/30 transition-all transform hover:-translate-y-0.5 flex items-center gap-2">
                <span class="material-symbols-outlined text-lg">save</span> Simpan Data
            </button>
        </div>

    </form>
</div>

<?= $this->endSection() ?>