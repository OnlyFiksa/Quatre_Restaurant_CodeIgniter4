<?= $this->extend('layout/main') ?>

<?= $this->section('title') ?>
Kelola Staff
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="bg-white p-6 rounded-2xl shadow-sm border border-sage-border">
    
    <div class="flex flex-col sm:flex-row justify-between items-center gap-4 mb-6">
        <div>
            <h3 class="text-lg font-bold text-sage-text">Daftar Pengguna</h3>
            <p class="text-xs text-sage-text/60">Kelola akun staff yang memiliki akses ke sistem.</p>
        </div>
        <a href="<?= base_url('admin/users/tambah') ?>" class="bg-primary hover:bg-primary-hover text-white px-5 py-2.5 rounded-xl text-sm font-semibold shadow-lg shadow-primary/30 transition-all flex items-center gap-2">
            <span class="material-symbols-outlined text-lg">person_add</span> Tambah User
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-sage-soft text-sage-text text-xs uppercase tracking-wider">
                    <th class="p-4 rounded-l-xl font-bold">ID Admin</th>
                    <th class="p-4 font-bold">Nama Lengkap</th>
                    <th class="p-4 font-bold">Username</th>
                    <th class="p-4 font-bold">Jabatan</th>
                    <th class="p-4 rounded-r-xl font-bold text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-sm divide-y divide-sage-border">
                <?php if(empty($users)): ?>
                    <tr><td colspan="5" class="p-8 text-center text-sage-text/40 italic">Tidak ada data user.</td></tr>
                <?php else: ?>
                    <?php foreach ($users as $u) : ?>
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="p-4 font-mono text-sage-text/70">
                            <?= esc($u['id_admin'] ?? $u['id'] ?? '-') ?>
                        </td>
                        
                        <td class="p-4 font-bold text-sage-text">
                            <?= esc($u['nama'] ?? $u['nama_admin'] ?? '-') ?>
                        </td>
                        
                        <td class="p-4 text-sage-text">
                            <?= esc($u['username'] ?? '-') ?>
                        </td>

                        <td class="p-4">
                            <?php 
                                $jabatan = $u['jabatan'] ?? 'Staff';
                                $badgeColor = 'bg-gray-100 text-gray-600';
                                if($jabatan == 'Owner') $badgeColor = 'bg-purple-100 text-purple-600 border border-purple-200';
                                elseif($jabatan == 'Supervisor') $badgeColor = 'bg-blue-100 text-blue-600 border border-blue-200';
                                elseif($jabatan == 'Kasir') $badgeColor = 'bg-emerald-100 text-emerald-600 border border-emerald-200';
                            ?>
                            <span class="px-3 py-1 rounded-full text-xs font-bold <?= $badgeColor ?>">
                                <?= esc($jabatan) ?>
                            </span>
                        </td>
                        
                        <td class="p-4 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <?php 
                                    $idUser = $u['id_admin'] ?? $u['id'] ?? ''; 
                                    $myId = session()->get('id_admin');
                                ?>
                                
                                <a href="<?= base_url('admin/users/edit/' . $idUser) ?>" class="size-8 rounded-lg bg-orange-100 text-orange-500 hover:bg-orange-500 hover:text-white flex items-center justify-center transition-all">
                                    <span class="material-symbols-outlined text-lg">edit</span>
                                </a>
                                
                                <?php if($idUser != $myId): ?>
                                    <a href="<?= base_url('admin/users/hapus/' . $idUser) ?>" onclick="return confirm('Hapus user ini?')" class="size-8 rounded-lg bg-red-100 text-red-500 hover:bg-red-500 hover:text-white flex items-center justify-center transition-all">
                                        <span class="material-symbols-outlined text-lg">delete</span>
                                    </a>
                                <?php else: ?>
                                    <button disabled class="size-8 rounded-lg bg-gray-100 text-gray-300 cursor-not-allowed flex items-center justify-center">
                                        <span class="material-symbols-outlined text-lg">block</span>
                                    </button>
                                <?php endif; ?>
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