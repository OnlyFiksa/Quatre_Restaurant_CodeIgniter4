<?= $this->extend('layout/main') ?>

<?= $this->section('title') ?>
Daftar Pesanan
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="bg-white p-6 rounded-2xl shadow-sm border border-sage-border">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h3 class="text-lg font-bold text-sage-text">Pesanan Masuk</h3>
            <p class="text-xs text-sage-text/60">Pantau pesanan pelanggan secara real-time.</p>
        </div>
        <div class="flex gap-2">
            <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-lg text-xs font-bold flex items-center gap-1">
                <span class="size-2 bg-yellow-500 rounded-full"></span> Proses
            </span>
            <span class="px-3 py-1 bg-emerald-100 text-emerald-700 rounded-lg text-xs font-bold flex items-center gap-1">
                <span class="size-2 bg-emerald-500 rounded-full"></span> Selesai
            </span>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-sage-soft text-sage-text text-xs uppercase tracking-wider">
                    <th class="p-4 rounded-l-xl font-bold">ID Pesanan</th>
                    <th class="p-4 font-bold">Customer</th>
                    <th class="p-4 font-bold">No. Meja</th>
                    <th class="p-4 font-bold">Waktu</th>
                    <th class="p-4 font-bold">Total</th>
                    <th class="p-4 font-bold">Status</th>
                    <th class="p-4 rounded-r-xl font-bold text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-sm divide-y divide-sage-border">
                <?php if (empty($orders)) : ?>
                    <tr>
                        <td colspan="7" class="p-12 text-center text-sage-text/40">
                            <span class="material-symbols-outlined text-4xl mb-2">inbox</span><br>
                            Belum ada pesanan masuk.
                        </td>
                    </tr>
                <?php else : ?>
                    <?php foreach ($orders as $o) : ?>
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="p-4 font-mono text-sage-text/70 text-xs"><?= $o['id_order'] ?></td>
                        <td class="p-4 font-bold text-sage-text"><?= esc($o['nama_customer']) ?></td>
                        <td class="p-4 text-center">
                            <span class="size-8 flex items-center justify-center bg-gray-100 rounded-full font-bold text-gray-600 text-xs">
                                <?= $o['nomor_meja'] ?>
                            </span>
                        </td>
                        <td class="p-4 text-sage-text text-xs">
                            <?= date('d M, H:i', strtotime($o['tanggal_order'] . ' ' . $o['waktu_order'])) ?>
                        </td>
                        <td class="p-4 font-bold text-sage-text">Rp <?= number_format($o['total_harga'], 0, ',', '.') ?></td>
                        <td class="p-4">
                            <?php if ($o['status_order'] == 'proses') : ?>
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-yellow-100 text-yellow-700 border border-yellow-200">
                                    Proses
                                </span>
                            <?php else : ?>
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700 border border-emerald-200">
                                    Selesai
                                </span>
                            <?php endif; ?>
                        </td>
                        <td class="p-4 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <a href="<?= base_url('admin/pesanan/detail/' . $o['id_order']) ?>" class="px-3 py-1.5 rounded-lg bg-gray-100 text-gray-600 hover:bg-gray-200 text-xs font-bold transition-all">
                                    Detail
                                </a>

                                <?php if ($o['status_order'] == 'proses') : ?>
                                    <button class="open-payment-popup px-3 py-1.5 rounded-lg bg-primary hover:bg-primary-hover text-white text-xs font-bold transition-all shadow-md shadow-primary/20"
                                       data-orderid="<?= $o['id_order'] ?>" 
                                       data-mejaid="<?= $o['id_meja'] ?>">
                                       Bayar
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

<div id="payment-popup" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40 backdrop-blur-sm transition-all opacity-0">
    <div class="bg-white p-8 rounded-2xl shadow-2xl w-full max-w-sm transform scale-95 transition-all">
        
        <div class="text-center mb-6">
            <div class="size-14 bg-emerald-50 text-primary rounded-full flex items-center justify-center mx-auto mb-4">
                <span class="material-symbols-outlined text-3xl">payments</span>
            </div>
            <h2 class="text-xl font-bold text-sage-text">Proses Pembayaran</h2>
            <p class="text-sage-text/60 text-sm">Order ID: <span id="display-order-id" class="font-mono font-bold text-primary"></span></p>
        </div>

        <form id="payment-form" onsubmit="return false;">
            <input type="hidden" name="id_order" id="id-order-input">
            <input type="hidden" name="id_meja" id="temp-meja-id-input">
            <input type="hidden" name="id_admin" id="id-admin-input" value="<?= session()->get('id_admin') ?>">

            <div class="mb-6">
                <label class="block text-xs font-bold text-sage-text mb-2">Pilih Metode Pembayaran</label>
                <select name="metode_pembayaran" id="metode_pembayaran" class="w-full rounded-xl bg-sage-soft border-transparent focus:border-primary focus:bg-white focus:ring-0 text-sm py-3 text-sage-text font-medium">
                    <option value="Tunai">💵 Tunai</option>
                    <option value="Transfer">💳 Transfer Bank</option>
                    <option value="QRIS">📱 QRIS</option>
                </select>
            </div>

            <div class="flex gap-3">
                <button type="button" id="cancel-payment-btn" class="flex-1 px-5 py-3 rounded-xl bg-gray-100 text-sage-text font-bold hover:bg-gray-200 transition-colors">Batal</button>
                
                <button type="button" id="submit-payment-btn" 
                        class="flex-1 px-5 py-3 rounded-xl bg-primary text-white font-bold hover:bg-primary-hover shadow-lg shadow-primary/30 transition-all"
                        data-url="<?= base_url('admin/transaksi/proses') ?>">
                    Konfirmasi Bayar
                </button>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>