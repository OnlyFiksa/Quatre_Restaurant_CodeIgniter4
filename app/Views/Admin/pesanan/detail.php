<?= $this->extend('layout/main') ?>

<?= $this->section('title') ?>
Detail Pesanan
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="mb-6 flex justify-between items-center">
    <a href="<?= base_url('admin/pesanan') ?>" class="inline-flex items-center gap-2 text-sage-text/60 hover:text-primary font-bold text-sm transition-colors">
        <span class="material-symbols-outlined text-lg">arrow_back</span> Kembali ke Daftar
    </a>
    <span class="text-xs font-mono text-sage-text/40">ID: <?= $order['id_order'] ?></span>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    
    <div class="lg:col-span-1 space-y-6">
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-sage-border">
            <h3 class="text-sm font-bold text-sage-text mb-4 uppercase tracking-wide border-b border-sage-border pb-2">Informasi Order</h3>
            
            <div class="space-y-4">
                <div class="text-center mb-6">
                    <?php if ($order['status_order'] == 'proses') : ?>
                        <div class="inline-block p-4 rounded-full bg-blue-50 text-blue-600 mb-2 border border-blue-100 animate-pulse">
                            <span class="material-symbols-outlined text-3xl">hourglass_top</span>
                        </div>
                        <h4 class="font-bold text-blue-700">Belum Dibayar</h4>
                        <p class="text-xs text-blue-600 font-bold bg-blue-100 px-3 py-1 rounded-full inline-block mt-1">Status: Proses</p>
                    
                    <?php else : ?>
                        <div class="inline-block p-4 rounded-full bg-emerald-50 text-emerald-600 mb-2 border border-emerald-100">
                            <span class="material-symbols-outlined text-3xl">check_circle</span>
                        </div>
                        <h4 class="font-bold text-emerald-700">Selesai</h4>
                        <p class="text-xs text-emerald-600 font-bold">Lunas</p>
                    <?php endif; ?>
                </div>

                <div>
                    <p class="text-xs text-sage-text/60">Nama Customer</p>
                    <p class="text-lg font-bold text-sage-text"><?= esc($order['nama_customer']) ?></p>
                </div>
                
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-xs text-sage-text/60">Nomor Meja</p>
                        <span class="inline-block mt-1 px-3 py-1 bg-gray-100 rounded-lg font-bold text-gray-600 text-sm">
                            Meja <?= $order['id_meja'] ?>
                        </span>
                    </div>
                    <div class="text-right">
                        <p class="text-xs text-sage-text/60">Waktu</p>
                        <p class="text-sm font-bold text-sage-text mt-1"><?= date('H:i', strtotime($order['waktu_order'])) ?></p>
                    </div>
                </div>
            </div>

            <div class="mt-8 pt-6 border-t border-sage-border">
                <?php if ($order['status_order'] == 'proses') : ?>
                    <button type="button" 
                            class="open-payment-popup w-full block text-center bg-emerald-500 hover:bg-emerald-600 text-white font-bold py-3 rounded-xl shadow-lg shadow-emerald-500/30 transition-all flex items-center justify-center gap-2"
                            data-orderid="<?= $order['id_order'] ?>" 
                            data-mejaid="<?= $order['id_meja'] ?>"
                            data-customer="<?= $order['nama_customer'] ?>"
                            data-total="<?= $order['total_harga'] ?>">
                        <span class="material-symbols-outlined">payments</span> Bayar Sekarang
                    </button>

                <?php else : ?>
                    <button disabled class="w-full bg-gray-100 text-gray-400 font-bold py-3 rounded-xl cursor-not-allowed flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined">receipt_long</span> Struk Sudah Dicetak
                    </button>
                <?php endif; ?>
            </div>

        </div>
    </div>

    <div class="lg:col-span-2">
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-sage-border h-full flex flex-col">
            <h3 class="text-sm font-bold text-sage-text mb-4 uppercase tracking-wide">Rincian Menu</h3>
            
            <div class="flex-grow overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-sage-soft text-sage-text text-xs uppercase">
                        <tr>
                            <th class="p-3 rounded-l-lg">Menu</th>
                            <th class="p-3">Harga</th>
                            <th class="p-3 text-center">Qty</th>
                            <th class="p-3 rounded-r-lg text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm divide-y divide-dashed divide-gray-200">
                        <?php foreach ($details as $i) : ?>
                        <tr>
                            <td class="p-4 font-bold text-sage-text"><?= esc($i['nama_menu']) ?></td>
                            <td class="p-4 text-sage-text/60">Rp <?= number_format($i['harga'], 0, ',', '.') ?></td>
                            <td class="p-4 text-center">
                                <span class="bg-gray-100 px-2 py-1 rounded text-xs font-bold">x<?= $i['quantity'] ?></span>
                            </td>
                            <td class="p-4 text-right font-bold text-sage-text">Rp <?= number_format($i['subtotal'], 0, ',', '.') ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="mt-auto border-t-2 border-dashed border-sage-border pt-4">
                <div class="flex justify-between items-center">
                    <span class="text-sage-text font-bold text-sm">TOTAL TAGIHAN</span>
                    <span class="text-3xl font-extrabold text-primary">
                        Rp <?= number_format($order['total_harga'], 0, ',', '.') ?>
                    </span>
                </div>
            </div>
        </div>
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
                    <option value="Tunai">💵 Tunai / Cash</option>
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