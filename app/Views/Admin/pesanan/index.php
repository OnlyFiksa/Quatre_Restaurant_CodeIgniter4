<?= $this->extend('layout/main') ?>

<?= $this->section('title') ?>
Daftar Pesanan
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="bg-white p-6 rounded-2xl shadow-sm border border-sage-border">
    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
        <div>
            <h3 class="text-lg font-bold text-sage-text">📋 Pesanan Masuk</h3>
            <p class="text-xs text-sage-text/60">Kelola pembayaran dan status pesanan pelanggan.</p>
        </div>
        
        <div class="flex gap-2">
            <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-lg text-xs font-bold flex items-center gap-1">
                <span class="size-2 bg-blue-500 rounded-full animate-pulse"></span> Proses
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
                    <th class="p-4 rounded-l-xl font-bold">ID Order</th>
                    <th class="p-4 font-bold">Customer</th>
                    <th class="p-4 font-bold text-center">Meja</th>
                    <th class="p-4 font-bold">Waktu</th>
                    <th class="p-4 font-bold">Total</th>
                    <th class="p-4 font-bold text-center">Status</th>
                    <th class="p-4 rounded-r-xl font-bold text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-sm divide-y divide-sage-border">
                <?php if (empty($orders)) : ?>
                    <tr>
                        <td colspan="7" class="p-12 text-center text-sage-text/40 italic">
                            Belum ada data pesanan yang masuk.
                        </td>
                    </tr>
                <?php else : ?>
                    <?php foreach ($orders as $o) : ?>
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="p-4 font-mono text-primary font-bold text-xs"><?= $o['id_order'] ?></td>
                        <td class="p-4 font-bold text-sage-text"><?= esc($o['nama_customer']) ?></td>
                        <td class="p-4 text-center">
                            <span class="size-8 inline-flex items-center justify-center bg-gray-100 rounded-lg font-bold text-gray-600 text-xs">
                                <?= $o['id_meja'] ?>
                            </span>
                        </td>
                        <td class="p-4 text-sage-text text-xs">
                            <?= date('H:i', strtotime($o['waktu_order'])) ?><br>
                            <span class="text-[10px] text-gray-400"><?= date('d M Y', strtotime($o['tanggal_order'])) ?></span>
                        </td>
                        <td class="p-4 font-bold text-sage-text">Rp <?= number_format($o['total_harga'], 0, ',', '.') ?></td>
                        
                        <td class="p-4 text-center">
                            <?php if ($o['status_order'] == 'proses') : ?>
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-700 border border-blue-200">
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
                                <a href="<?= base_url('admin/pesanan/detail/' . $o['id_order']) ?>" class="size-8 flex items-center justify-center rounded-lg bg-gray-100 text-gray-500 hover:bg-gray-200 transition-all" title="Lihat Detail">
                                    <span class="material-symbols-outlined text-lg">visibility</span>
                                </a>

                                <?php if ($o['status_order'] == 'proses') : ?>
                                    <button type="button" 
                                            class="open-payment-popup px-4 py-1.5 rounded-lg bg-emerald-500 hover:bg-emerald-600 text-white text-xs font-bold transition-all shadow-md shadow-emerald-500/20 flex items-center gap-1"
                                            data-orderid="<?= $o['id_order'] ?>" 
                                            data-mejaid="<?= $o['id_meja'] ?>"
                                            data-customer="<?= $o['nama_customer'] ?>"
                                            
                                            data-total="<?= $o['total_harga'] ?>">
                                            
                                        <span class="material-symbols-outlined text-sm">payments</span> Bayar
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

<div id="payment-popup" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black/40 backdrop-blur-sm opacity-0 transition-opacity duration-300">
    <div class="bg-white p-8 rounded-2xl shadow-2xl w-full max-w-sm transform scale-95 transition-transform duration-300" id="payment-content">
        
        <div class="text-center mb-6">
            <div class="size-14 bg-emerald-50 text-emerald-600 rounded-full flex items-center justify-center mx-auto mb-4 border border-emerald-100">
                <span class="material-symbols-outlined text-3xl">payments</span>
            </div>
            <h2 class="text-xl font-bold text-sage-text">Proses Pembayaran</h2>
            <p class="text-sage-text/60 text-sm mt-1">ID Order: <span id="display-order-id" class="font-mono font-bold text-primary"></span></p>
            <p class="text-sage-text/60 text-sm italic">Pelanggan: <span id="modal-customer" class="font-bold"></span></p>
        </div>

        <form id="payment-form">
            <input type="hidden" id="id-order-input">
            <input type="hidden" id="temp-meja-id-input">
            <input type="hidden" id="id-admin-input" value="<?= session()->get('id_admin') ?? 1 ?>">

            <div class="mb-4 text-center">
                <span class="text-xs text-sage-text/40 uppercase font-bold tracking-widest">Total Tagihan</span>
                <p class="text-2xl font-black text-sage-text">Rp <span id="modal-total-display">0</span></p>
            </div>

            <div class="mb-6">
                <label class="block text-xs font-bold text-sage-text mb-2">Metode Pembayaran</label>
                <select id="metode_pembayaran" class="w-full rounded-xl bg-gray-50 border border-gray-200 focus:border-primary focus:ring-1 focus:ring-primary text-sm p-3 font-medium cursor-pointer transition-all">
                    <option value="Cash">💵 Tunai </option>
                    <option value="Transfer">💳 Transfer Bank</option>
                </select>
            </div>

            <div class="flex gap-3">
                <button type="button" id="cancel-payment-btn" class="flex-1 px-5 py-3 rounded-xl bg-gray-100 text-sage-text font-bold hover:bg-gray-200 transition-colors">
                    Batal
                </button>
                <button type="button" id="submit-payment-btn" 
                        class="flex-1 px-5 py-3 rounded-xl bg-primary text-white font-bold hover:bg-primary-hover shadow-lg shadow-primary/30 transition-all"
                        data-url="<?= base_url('admin/transaksi/proses') ?>">
                    Konfirmasi
                </button>
            </div>
        </form>
    </div>
</div>

<script src="<?= base_url('assets/js/script-dashboard.js') ?>"></script>

<?= $this->endSection() ?>