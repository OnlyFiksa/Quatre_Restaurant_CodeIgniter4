<?= $this->extend('layout/main') ?>

<?= $this->section('title') ?>
Kelola Meja
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="bg-white p-6 rounded-2xl shadow-sm border border-sage-border">
    
    <div class="flex flex-col sm:flex-row justify-between items-center gap-4 mb-6">
        <div>
            <h3 class="text-lg font-bold text-sage-text">Daftar Meja Restoran</h3>
            <p class="text-xs text-sage-text/60">Kelola ketersediaan meja untuk pelanggan.</p>
        </div>
        <a href="<?= base_url('admin/meja/tambah') ?>" class="bg-primary hover:bg-primary-hover text-white px-5 py-2.5 rounded-xl text-sm font-semibold shadow-lg shadow-primary/30 transition-all flex items-center gap-2">
            <span class="material-symbols-outlined text-lg">add</span> Tambah Meja
        </a>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
        <?php if(empty($meja)): ?>
            <div class="col-span-full p-8 text-center text-sage-text/40 italic">Belum ada data meja.</div>
        <?php else: ?>
            <?php foreach ($meja as $m) : ?>
                <div class="group bg-gray-50 border border-sage-border rounded-2xl p-4 flex flex-col items-center hover:shadow-md transition-all relative">
                    
                    <?php 
                        $iconColor = 'text-emerald-500';
                        $statusText = 'Tersedia';
                        $statusClass = 'bg-emerald-100 text-emerald-600 border-emerald-200';
                        
                        if($m['status_meja'] == 'terisi') { 
                            $iconColor = 'text-orange-500'; 
                            $statusText = 'Terisi';
                            $statusClass = 'bg-orange-100 text-orange-600 border-orange-200';
                        } elseif($m['status_meja'] == 'tidak_tersedia') { 
                            $iconColor = 'text-gray-400'; 
                            $statusText = 'Rusak';
                            $statusClass = 'bg-gray-100 text-gray-500 border-gray-200';
                        }
                    ?>
                    
                    <span class="material-symbols-outlined text-4xl mb-2 <?= $iconColor ?>">table_restaurant</span>
                    
                    <h4 class="font-bold text-xl text-sage-text mb-1">Meja <?= $m['nomor_meja'] ?></h4>
                    <span class="px-2 py-0.5 rounded-md text-[10px] font-bold uppercase tracking-wider border <?= $statusClass ?>">
                        <?= $statusText ?>
                    </span>

                    <div class="absolute inset-0 bg-white/90 backdrop-blur-sm rounded-2xl flex items-center justify-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                        <a href="<?= base_url('admin/meja/edit/' . $m['id_meja']) ?>" class="size-10 rounded-full bg-orange-100 text-orange-600 flex items-center justify-center hover:bg-orange-500 hover:text-white transition-all shadow-sm">
                            <span class="material-symbols-outlined">edit</span>
                        </a>
                        <a href="<?= base_url('admin/meja/hapus/' . $m['id_meja']) ?>" onclick="return confirm('Hapus meja ini?')" class="size-10 rounded-full bg-red-100 text-red-600 flex items-center justify-center hover:bg-red-500 hover:text-white transition-all shadow-sm">
                            <span class="material-symbols-outlined">delete</span>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
<?= $this->endSection() ?>