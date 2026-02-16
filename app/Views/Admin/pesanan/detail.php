<?= $this->extend('layout/main') ?>

<?= $this->section('title') ?>
Detail Pesanan
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="mb-6">
    <a href="<?= base_url('admin/pesanan') ?>" class="inline-flex items-center gap-2 text-sage-text/60 hover:text-primary font-bold text-sm transition-colors">
        <span class="material-symbols-outlined text-lg">arrow_back</span> Kembali ke Daftar
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    
    <div class="lg:col-span-1 space-y-6">
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-sage-border">
            <h3 class="text-sm font-bold text-sage-text mb-4 uppercase tracking-wide">Informasi Pelanggan</h3>
            
            <div class="space-y-4">
                <div>
                    <p class="text-xs text-sage-text/60">Nama Customer</p>
                    <p class="text-lg font-bold text-sage-text"><?= esc($order['nama_customer']) ?></p>
                </div>
                <div class="flex justify-between">
                    <div>
                        <p class="text-xs text-sage-text/60">Nomor Meja</p>
                        <span class="inline-block mt-1 size-8 text-center leading-8 bg-gray-100 rounded-lg font-bold text-gray-600">
                            <?= $order['nomor_meja'] ?>
                        </span>
                    </div>
                    <div class="text-right">
                        <p class="text-xs text-sage-text/60">Waktu Pesan</p>
                        <p class="text-sm font-medium text-sage-text mt-1">
                            <?= date('H:i', strtotime($order['waktu_order'])) ?><br>
                            <span class="text-xs text-sage-text/40"><?= date('d M Y', strtotime($order['tanggal_order'])) ?></span>
                        </p>
                    </div>
                </div>
                <div>
                    <p class="text-xs text-sage-text/60 mb-1">Status</p>
                    <?php if ($order['status_order'] == 'proses') : ?>
                        <span class="px-3 py-1.5 rounded-lg text-xs font-bold bg-yellow-100 text-yellow-700 w-full block text-center">
                            Sedang Diproses
                        </span>
                    <?php else : ?>
                        <span class="px-3 py-1.5 rounded-lg text-xs font-bold bg-emerald-100 text-emerald-700 w-full block text-center">
                            Selesai / Lunas
                        </span>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="lg:col-span-2">
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-sage-border h-full">
            <h3 class="text-sm font-bold text-sage-text mb-4 uppercase tracking-wide">Rincian Menu</h3>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-sage-soft text-sage-text text-xs uppercase">
                        <tr>
                            <th class="p-3 rounded-l-lg">Menu</th>
                            <th class="p-3">Harga</th>
                            <th class="p-3 text-center">Qty</th>
                            <th class="p-3 rounded-r-lg text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm divide-y divide-gray-100">
                        <?php foreach ($items as $i) : ?>
                        <tr>
                            <td class="p-3 font-medium text-sage-text"><?= esc($i['nama_menu']) ?></td>
                            <td class="p-3 text-sage-text/60">Rp <?= number_format($i['harga'], 0, ',', '.') ?></td>
                            <td class="p-3 text-center font-bold">x<?= $i['quantity'] ?></td>
                            <td class="p-3 text-right font-bold text-sage-text">Rp <?= number_format($i['subtotal'], 0, ',', '.') ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot class="border-t-2 border-dashed border-sage-border">
                        <tr>
                            <td colspan="3" class="p-4 text-right font-bold text-sage-text text-sm">TOTAL TAGIHAN</td>
                            <td class="p-4 text-right font-extrabold text-xl text-primary">
                                Rp <?= number_format($order['total_harga'], 0, ',', '.') ?>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>