<?= $this->extend('layout/main') ?>

<?= $this->section('title') ?>
Laporan Penjualan
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="bg-white p-6 rounded-2xl shadow-sm border border-sage-border mb-6">
    <h3 class="text-sm font-bold text-sage-text mb-4 uppercase tracking-wide">Filter Laporan</h3>
    <form action="<?= base_url('admin/laporan') ?>" method="get" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
        
        <div>
            <label class="block text-xs font-medium text-sage-text/60 mb-1">Dari Tanggal</label>
            <input type="date" name="start_date" value="<?= $filters['start_date'] ?>" 
                   class="w-full rounded-xl bg-sage-soft border-transparent focus:border-primary focus:bg-white focus:ring-0 text-sm transition-all text-sage-text">
        </div>

        <div>
            <label class="block text-xs font-medium text-sage-text/60 mb-1">Sampai Tanggal</label>
            <input type="date" name="end_date" value="<?= $filters['end_date'] ?>" 
                   class="w-full rounded-xl bg-sage-soft border-transparent focus:border-primary focus:bg-white focus:ring-0 text-sm transition-all text-sage-text">
        </div>

        <div>
            <label class="block text-xs font-medium text-sage-text/60 mb-1">Kasir</label>
            <select name="kasir" class="w-full rounded-xl bg-sage-soft border-transparent focus:border-primary focus:bg-white focus:ring-0 text-sm transition-all text-sage-text">
                <option value="">Semua Kasir</option>
                <?php foreach ($kasirList as $k) : ?>
                    <option value="<?= $k['id_admin'] ?>" <?= $filters['kasir'] == $k['id_admin'] ? 'selected' : '' ?>>
                        <?= esc($k['nama']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="flex gap-2">
            <button type="submit" class="flex-1 bg-primary hover:bg-primary-hover text-white py-2.5 rounded-xl text-sm font-bold shadow-lg shadow-primary/20 transition-all">
                Filter
            </button>
            <a href="<?= base_url('admin/laporan') ?>" class="px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-600 rounded-xl text-sm font-bold transition-all">
                Reset
            </a>
        </div>

    </form>
</div>

<div class="bg-white p-6 rounded-2xl shadow-sm border border-sage-border">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-sage-soft text-sage-text text-xs uppercase tracking-wider">
                    <th class="p-4 rounded-l-xl font-bold">ID Transaksi</th>
                    <th class="p-4 font-bold">ID Pesanan</th>
                    <th class="p-4 font-bold">Tanggal</th>
                    <th class="p-4 font-bold">Kasir</th>
                    <th class="p-4 rounded-r-xl font-bold text-right">Pendapatan</th>
                </tr>
            </thead>
            <tbody class="text-sm divide-y divide-sage-border">
                <?php if (empty($laporan)) : ?>
                    <tr>
                        <td colspan="5" class="p-12 text-center flex flex-col items-center justify-center text-sage-text/40">
                            <span class="material-symbols-outlined text-4xl mb-2">search_off</span>
                            <span class="italic">Data tidak ditemukan untuk periode ini.</span>
                        </td>
                    </tr>
                <?php else : ?>
                    <?php foreach ($laporan as $row) : ?>
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="p-4 font-mono text-sage-text/70"><?= $row['id_transaksi'] ?></td>
                        <td class="p-4 font-mono"><?= $row['id_order'] ?></td>
                        <td class="p-4 text-sage-text"><?= date('d M Y', strtotime($row['tanggal_transaksi'])) ?></td>
                        <td class="p-4 font-medium"><?= esc($row['nama_kasir']) ?></td>
                        <td class="p-4 text-right font-bold text-sage-text">Rp <?= number_format($row['total_harga'], 0, ',', '.') ?></td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
            <tfoot class="border-t-2 border-primary/20 bg-sage-soft/30">
                <tr>
                    <td colspan="4" class="p-4 text-right font-bold text-sage-text uppercase text-xs tracking-wider">Total Pendapatan</td>
                    <td class="p-4 text-right font-extrabold text-lg text-primary">Rp <?= number_format($total, 0, ',', '.') ?></td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

<?= $this->endSection() ?>