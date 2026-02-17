<?= $this->extend('layout/main') ?>

<?= $this->section('title') ?>
Dashboard
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-8">
    <div>
        <h2 class="text-3xl font-extrabold tracking-tight text-sage-text">Halo, <?= session()->get('nama') ?> 👋</h2>
        <p class="text-sage-text/60 mt-1">Ringkasan operasional restoran hari ini.</p>
    </div>
    <div class="flex gap-3">
        <span class="px-4 py-2 rounded-xl bg-white border border-sage-border text-xs font-bold text-sage-text shadow-sm flex items-center gap-2">
            <span class="material-symbols-outlined text-sm">calendar_month</span>
            <?= date('d M Y') ?>
        </span>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">
    
    <div class="bg-white p-6 rounded-2xl border border-sage-border shadow-sm hover:shadow-md transition-all group">
        <div class="flex items-center justify-between mb-4">
            <div class="size-12 bg-emerald-100 rounded-xl flex items-center justify-center text-emerald-600 group-hover:scale-110 transition-transform">
                <span class="material-symbols-outlined">payments</span>
            </div>
            <span class="text-emerald-600 text-[10px] font-bold uppercase bg-emerald-50 px-2 py-1 rounded-lg tracking-wider">Hari Ini</span>
        </div>
        <p class="text-sage-text/60 text-sm font-medium">Pendapatan</p>
        <h3 class="text-2xl font-black mt-1 text-sage-text">Rp <?= number_format($today_income ?? 0, 0, ',', '.') ?></h3>
    </div>

    <div class="bg-white p-6 rounded-2xl border border-sage-border shadow-sm hover:shadow-md transition-all group">
        <div class="flex items-center justify-between mb-4">
            <div class="size-12 bg-orange-100 rounded-xl flex items-center justify-center text-orange-600 group-hover:scale-110 transition-transform">
                <span class="material-symbols-outlined">restaurant_menu</span>
            </div>
            <span class="text-orange-600 text-[10px] font-bold uppercase bg-orange-50 px-2 py-1 rounded-lg tracking-wider">Total</span>
        </div>
        <p class="text-sage-text/60 text-sm font-medium">Menu Tersedia</p>
        <h3 class="text-2xl font-black mt-1 text-sage-text"><?= number_format($total_menu ?? 0) ?></h3>
    </div>

    <div class="bg-white p-6 rounded-2xl border border-sage-border shadow-sm hover:shadow-md transition-all group">
        <div class="flex items-center justify-between mb-4">
            <div class="size-12 bg-blue-100 rounded-xl flex items-center justify-center text-blue-600 group-hover:scale-110 transition-transform">
                <span class="material-symbols-outlined">receipt_long</span>
            </div>
            <span class="text-blue-600 text-[10px] font-bold uppercase bg-blue-50 px-2 py-1 rounded-lg tracking-wider">Hari Ini</span>
        </div>
        <p class="text-sage-text/60 text-sm font-medium">Pesanan Masuk</p>
        <h3 class="text-2xl font-black mt-1 text-sage-text"><?= number_format($today_orders ?? 0) ?></h3>
    </div>

    <div class="bg-white p-6 rounded-2xl border border-sage-border shadow-sm hover:shadow-md transition-all group">
        <div class="flex items-center justify-between mb-4">
            <div class="size-12 bg-purple-100 rounded-xl flex items-center justify-center text-purple-600 group-hover:scale-110 transition-transform">
                <span class="material-symbols-outlined">groups</span>
            </div>
            <span class="text-purple-600 text-[10px] font-bold uppercase bg-purple-50 px-2 py-1 rounded-lg tracking-wider">Aktif</span>
        </div>
        <p class="text-sage-text/60 text-sm font-medium">Total Staff</p>
        <h3 class="text-2xl font-black mt-1 text-sage-text"><?= number_format($total_staff ?? 0) ?></h3>
    </div>

</div>

<div class="bg-white p-6 rounded-2xl shadow-sm border border-sage-border">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h3 class="font-bold text-sage-text text-lg flex items-center gap-2">
                <span class="material-symbols-outlined text-primary">ssid_chart</span> Tren Penjualan
            </h3>
            <p class="text-xs text-sage-text/60">Grafik pendapatan bersih dalam 7 hari terakhir.</p>
        </div>
    </div>
    <div class="relative h-96 w-full">
        <canvas id="incomeChart" data-url="<?= base_url('admin/dashboard/chart-data') ?>"></canvas>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="<?= base_url('assets/js/script-dashboard.js') ?>"></script>

<?= $this->endSection() ?>