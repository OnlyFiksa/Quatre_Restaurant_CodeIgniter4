<?= $this->extend('layout/main') ?>

<?= $this->section('title') ?>
Dashboard
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-8">
    <div>
        <h2 class="text-3xl font-extrabold tracking-tight text-sage-text">Halo, <?= session()->get('nama') ?> 👋</h2>
        <p class="text-sage-text/60 mt-1">Berikut adalah ringkasan performa Quatre Restaurant hari ini.</p>
    </div>
    <div class="flex gap-3">
        <span class="px-4 py-2 rounded-xl bg-white border border-sage-border text-xs font-bold text-sage-text shadow-sm">
            📅 <?= date('d M Y') ?>
        </span>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">
    
    <div class="bg-white p-6 rounded-2xl border border-sage-border shadow-sm hover:shadow-md transition-all group">
        <div class="flex items-center justify-between mb-4">
            <div class="size-12 bg-primary/10 rounded-xl flex items-center justify-center text-primary group-hover:scale-110 transition-transform">
                <span class="material-symbols-outlined">payments</span>
            </div>
            <span class="text-emerald-500 text-xs font-bold flex items-center gap-0.5 bg-emerald-50 px-2 py-1 rounded-lg">
                <span class="material-symbols-outlined text-sm">trending_up</span> Income
            </span>
        </div>
        <p class="text-sage-text/60 text-sm font-medium">Total Pendapatan</p>
        <h3 class="text-2xl font-bold mt-1 text-sage-text">Rp <?= number_format($pendapatan, 0, ',', '.') ?></h3>
    </div>

    <div class="bg-white p-6 rounded-2xl border border-sage-border shadow-sm hover:shadow-md transition-all group">
        <div class="flex items-center justify-between mb-4">
            <div class="size-12 bg-orange-100 rounded-xl flex items-center justify-center text-orange-500 group-hover:scale-110 transition-transform">
                <span class="material-symbols-outlined">receipt_long</span>
            </div>
        </div>
        <p class="text-sage-text/60 text-sm font-medium">Total Pesanan</p>
        <h3 class="text-2xl font-bold mt-1 text-sage-text"><?= number_format($count_transaksi) ?></h3>
    </div>

    <div class="bg-white p-6 rounded-2xl border border-sage-border shadow-sm hover:shadow-md transition-all group">
        <div class="flex items-center justify-between mb-4">
            <div class="size-12 bg-blue-100 rounded-xl flex items-center justify-center text-blue-500 group-hover:scale-110 transition-transform">
                <span class="material-symbols-outlined">restaurant_menu</span>
            </div>
        </div>
        <p class="text-sage-text/60 text-sm font-medium">Menu Aktif</p>
        <h3 class="text-2xl font-bold mt-1 text-sage-text"><?= number_format($count_menu) ?></h3>
    </div>

    <div class="bg-white p-6 rounded-2xl border border-sage-border shadow-sm hover:shadow-md transition-all group">
        <div class="flex items-center justify-between mb-4">
            <div class="size-12 bg-purple-100 rounded-xl flex items-center justify-center text-purple-500 group-hover:scale-110 transition-transform">
                <span class="material-symbols-outlined">group</span>
            </div>
        </div>
        <p class="text-sage-text/60 text-sm font-medium">Total Staff</p>
        <h3 class="text-2xl font-bold mt-1 text-sage-text"><?= number_format($count_admin) ?></h3>
    </div>

</div>

<div class="bg-white rounded-3xl border border-sage-border shadow-sm overflow-hidden min-h-[300px] flex flex-col items-center justify-center text-center p-8">
    <div class="size-20 bg-sage-soft rounded-full flex items-center justify-center text-sage-text/20 mb-4">
        <span class="material-symbols-outlined text-4xl">bar_chart</span>
    </div>
    <h5 class="text-xl font-bold text-sage-text/60">Analisis Penjualan</h5>
    <p class="text-sage-text/40 mt-2 max-w-md">Grafik detail penjualan bulanan akan ditampilkan di sini pada update berikutnya.</p>
</div>

<?= $this->endSection() ?>