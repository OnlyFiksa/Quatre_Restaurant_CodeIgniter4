<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Menu - Quatre Resto</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        sage: { 50: '#f4f7f5', 100: '#e3ebe3', 500: '#558b6e', 600: '#3d6650', 900: '#2f483a' },
                        accent: '#e07a5f'
                    },
                    fontFamily: { sans: ['Plus Jakarta Sans', 'sans-serif'] },
                    animation: {
                        'float': 'float 6s ease-in-out infinite',
                        'fade-up': 'fadeUp 0.5s ease-out forwards',
                        'scale-slow': 'scaleSlow 20s linear infinite alternate',
                    },
                    keyframes: {
                        float: { '0%, 100%': { transform: 'translateY(0)' }, '50%': { transform: 'translateY(-10px)' } },
                        fadeUp: { '0%': { opacity: '0', transform: 'translateY(20px)' }, '100%': { opacity: '1', transform: 'translateY(0)' } },
                        scaleSlow: { '0%': { transform: 'scale(1)' }, '100%': { transform: 'scale(1.1)' } }
                    }
                }
            }
        }
    </script>
    <link rel="stylesheet" href="<?= base_url('assets/style-user.css') ?>">
</head>
<body class="bg-sage-50 text-sage-900 font-sans pb-32 overflow-x-hidden selection:bg-sage-500 selection:text-white">

    <div class="fixed top-0 left-0 w-96 h-96 bg-sage-500/10 rounded-full blur-3xl -translate-x-1/2 -translate-y-1/2 pointer-events-none z-0"></div>
    <div class="fixed bottom-0 right-0 w-96 h-96 bg-sage-500/10 rounded-full blur-3xl translate-x-1/2 translate-y-1/2 pointer-events-none z-0"></div>

    <div class="relative w-full h-[340px] rounded-b-[50px] overflow-hidden shadow-2xl shadow-sage-900/20 z-10">
        <img src="https://images.unsplash.com/photo-1504674900247-0877df9cc836?q=80&w=2070&auto=format&fit=crop" 
             class="w-full h-full object-cover animate-scale-slow">
        
        <?php if(isset($tableNumber) && $tableNumber): ?>
        <div class="absolute top-6 right-6 bg-white/20 backdrop-blur-md border border-white/20 px-4 py-2 rounded-2xl shadow-lg flex items-center gap-3 animate-float z-20 table-badge">
            <div class="bg-white text-sage-600 w-8 h-8 rounded-full flex items-center justify-center shadow-sm">
                <i class='bx bx-map text-lg'></i>
            </div>
            <div class="text-left">
                <p class="text-[10px] text-white font-bold uppercase tracking-wider leading-none opacity-80">Meja</p>
                <p class="text-xl font-extrabold text-white leading-none" id="displayTableNumber"><?= esc($tableNumber) ?></p>
            </div>
        </div>
        <?php endif; ?>

        <div class="absolute inset-0 bg-gradient-to-t from-sage-900/90 via-sage-900/30 to-transparent flex flex-col justify-end items-center pb-14 text-center px-4">
            <span class="text-sage-100 text-[10px] font-bold uppercase tracking-[0.3em] mb-3 border border-sage-100/30 px-4 py-1.5 rounded-full backdrop-blur-sm">Welcome to</span>
            <h1 class="text-4xl md:text-5xl font-extrabold text-white mb-2 drop-shadow-lg tracking-tight">Quatre Resto <span class="text-sage-400">🌿</span></h1>
            <p class="text-sage-100/80 text-sm max-w-md font-medium">Nikmati hidangan lezat dengan suasana yang menenangkan.</p>
        </div>
    </div>

    <div class="w-[92%] max-w-[1400px] mx-auto -mt-8 relative z-20">

        <div class="bg-white/80 backdrop-blur-md p-2 rounded-[30px] shadow-lg shadow-sage-500/5 mb-8 border border-white flex justify-center overflow-hidden">
            <div class="flex gap-2 overflow-x-auto no-scrollbar py-1 w-full md:justify-center">
                <button onclick="filterMenu('all', this)" class="cat-btn active">Semua</button>
                
                <?php foreach($kategori as $k): ?>
                    <button onclick="filterMenu('<?= esc($k['id_kategori']) ?>', this)" class="cat-btn">
                        <?= esc($k['nama_kategori']) ?>
                    </button>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4 md:gap-6" id="menuGrid">
            <?php $delay = 0; foreach($menus as $m): ?>
            <div class="menu-card group bg-white p-3 rounded-[28px] shadow-lg shadow-sage-500/5 hover:shadow-2xl hover:shadow-sage-500/20 transition-all duration-300 cursor-pointer border border-transparent hover:border-sage-100 opacity-0 animate-fade-up"
                 style="animation-delay: <?= $delay ?>ms"
                 data-category="<?= esc($m['id_kategori']) ?>" 
                 onclick='openDetail(<?= json_encode($m) ?>)'>
                
                <div class="relative aspect-square overflow-hidden rounded-[24px] mb-3 bg-sage-50">
                    <img src="<?= base_url('assets/image/' . $m['gambar']) ?>" 
                         class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                         onerror="this.src='https://placehold.co/400x400/f4f7f5/558b6e?text=Menu'">
                    
                    <span class="absolute top-2 left-2 bg-white/90 backdrop-blur-sm text-sage-600 text-[9px] font-bold px-2 py-1 rounded-lg shadow-sm">
                        <?= esc($m['nama_kategori'] ?? 'Umum') ?>
                    </span>

                    <div class="absolute bottom-2 right-2 bg-sage-900 text-white w-9 h-9 rounded-full flex items-center justify-center shadow-lg translate-y-2 opacity-0 group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-300">
                        <i class='bx bx-plus text-xl'></i>
                    </div>
                </div>

                <div class="text-center px-1 pb-1">
                    <h3 class="font-bold text-sage-900 text-sm md:text-base leading-tight mb-1 line-clamp-1 group-hover:text-sage-600 transition-colors"><?= esc($m['nama_menu']) ?></h3>
                    <p class="text-[10px] text-gray-400 mb-2 line-clamp-1">Favorit pelanggan kami</p>
                    <span class="inline-block bg-sage-50 text-sage-700 font-extrabold text-sm px-3 py-1 rounded-lg border border-sage-100">
                        Rp <?= number_format($m['harga'], 0, ',', '.') ?>
                    </span>
                </div>
            </div>
            <?php $delay += 50; endforeach; ?>
        </div>
    </div>

    <div id="cart-float" class="fixed bottom-8 left-1/2 -translate-x-1/2 z-50 w-[90%] max-w-[400px] transition-all duration-500 translate-y-[200%]">
        <div onclick="openCheckout()" class="bg-sage-900/90 backdrop-blur-xl text-white p-2 pr-5 rounded-full shadow-2xl shadow-sage-900/40 flex justify-between items-center cursor-pointer hover:scale-[1.02] transition-transform border border-white/10 ring-4 ring-sage-500/20">
            <div class="flex items-center gap-3">
                <div class="bg-white text-sage-900 w-12 h-12 rounded-full flex items-center justify-center font-bold text-lg shadow-lg relative">
                    <span id="total-qty-float">0</span>
                    <span class="absolute inline-flex h-full w-full rounded-full bg-white opacity-20 animate-ping"></span>
                </div>
                <div class="flex flex-col">
                    <span class="text-[9px] text-sage-300 font-bold uppercase tracking-wider">Total Pesanan</span>
                    <span class="text-lg font-bold leading-none" id="total-price-float">Rp 0</span>
                </div>
            </div>
            <div class="flex items-center gap-2 font-bold text-sm text-sage-50">
                Checkout <i class='bx bx-right-arrow-alt text-xl bg-white/20 rounded-full p-0.5'></i>
            </div>
        </div>
    </div>

    <div id="detailModal" class="fixed inset-0 z-[60] hidden">
        <div class="absolute inset-0 bg-sage-900/60 backdrop-blur-sm transition-opacity opacity-0" onclick="closeModal()"></div>
        <div class="absolute bottom-0 left-0 right-0 bg-white rounded-t-[40px] p-8 transition-transform translate-y-full duration-300 md:relative md:max-w-md md:mx-auto md:rounded-[40px] md:top-1/2 md:-translate-y-1/2 shadow-2xl">
            <div class="w-16 h-1.5 bg-gray-200 rounded-full mx-auto mb-8"></div>
            
            <div class="flex gap-6 items-start">
                <img id="detailImg" class="w-28 h-28 rounded-3xl object-cover bg-gray-100 shrink-0 shadow-lg ring-4 ring-sage-50">
                <div class="pt-2">
                    <span id="detailCat" class="text-[10px] font-bold text-white bg-sage-500 px-2 py-1 rounded-lg uppercase tracking-wider shadow-sm"></span>
                    <h3 id="detailName" class="text-2xl font-bold text-sage-900 mt-2 mb-1 leading-tight"></h3>
                    <p id="detailPrice" class="text-xl font-extrabold text-sage-600"></p>
                </div>
            </div>

            <p id="detailDesc" class="text-gray-500 text-sm mt-6 mb-8 leading-relaxed bg-sage-50 p-4 rounded-2xl border border-sage-100/50"></p>

            <div class="flex items-center gap-3">
                <div class="flex items-center bg-gray-100 rounded-2xl p-1.5">
                    <button onclick="updateQty(-1)" class="w-10 h-10 flex items-center justify-center text-sage-600 font-bold text-2xl hover:bg-white rounded-xl transition-all shadow-sm">-</button>
                    <span id="detailQty" class="w-10 text-center font-bold text-lg text-sage-900">1</span>
                    <button onclick="updateQty(1)" class="w-10 h-10 flex items-center justify-center text-white bg-sage-900 rounded-xl font-bold text-xl shadow-md hover:scale-105 transition-all">+</button>
                </div>
                <button onclick="addToCart()" class="flex-1 bg-gradient-to-r from-sage-600 to-sage-500 text-white font-bold py-4 rounded-2xl shadow-lg shadow-sage-500/30 active:scale-95 transition-transform">
                    Tambah ke Keranjang
                </button>
            </div>
        </div>
    </div>

    <div id="checkoutModal" class="fixed inset-0 z-[70] hidden flex items-center justify-center px-4">
        <div class="absolute inset-0 bg-sage-900/80 backdrop-blur-md" onclick="closeCheckout()"></div>
        <div class="bg-white w-full max-w-lg rounded-[40px] p-8 relative z-10 shadow-2xl max-h-[90vh] flex flex-col animate-fade-up">
            
            <div class="flex justify-between items-center mb-6 pb-4 border-b border-gray-100">
                <h3 class="text-2xl font-bold text-sage-900">Keranjang</h3>
                <button onclick="closeCheckout()" class="w-10 h-10 bg-gray-50 rounded-full flex items-center justify-center hover:bg-red-50 hover:text-red-500 transition-colors">
                    <i class='bx bx-x text-2xl'></i>
                </button>
            </div>

            <div id="checkoutList" class="flex-1 overflow-y-auto pr-2 space-y-3 mb-6"></div>

            <div class="bg-sage-50 p-6 rounded-[30px] border border-sage-100">
                <div class="flex justify-between items-center mb-6">
                    <span class="text-sm font-bold text-sage-500 uppercase tracking-wider">Total Bayar</span>
                    <span id="checkoutTotal" class="text-3xl font-extrabold text-sage-900">Rp 0</span>
                </div>

                <div class="space-y-3 mb-4">
                    <div class="relative">
                        <i class='bx bx-user absolute left-4 top-1/2 -translate-y-1/2 text-sage-400 text-lg'></i>
                        <input type="text" id="inputNama" class="w-full bg-white border-0 py-3 pl-10 pr-4 rounded-2xl text-sage-900 font-bold placeholder-sage-300 focus:ring-2 focus:ring-sage-500 text-sm shadow-sm" placeholder="Nama Pemesan (Wajib)">
                    </div>
                    <div class="relative">
                        <i class='bx bx-phone absolute left-4 top-1/2 -translate-y-1/2 text-sage-400 text-lg'></i>
                        <input type="tel" id="inputHP" class="w-full bg-white border-0 py-3 pl-10 pr-4 rounded-2xl text-sage-900 font-bold placeholder-sage-300 focus:ring-2 focus:ring-sage-500 text-sm shadow-sm" placeholder="Nomor WhatsApp / HP">
                    </div>
                </div>

                <button onclick="openConfirmation()" class="w-full bg-sage-900 text-white font-bold py-4 rounded-2xl shadow-xl shadow-sage-900/20 active:scale-95 transition-transform flex items-center justify-center gap-2 hover:bg-sage-800">
                    <i class='bx bxs-paper-plane'></i> Pesan Sekarang
                </button>
            </div>
        </div>
    </div>

    <div id="confirmModal" class="fixed inset-0 z-[80] hidden flex items-center justify-center px-4">
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm transition-opacity opacity-0" onclick="closeConfirmation()"></div>
        <div class="bg-white w-full max-w-sm rounded-[30px] p-6 relative z-10 shadow-2xl transform scale-95 transition-transform duration-300">
            <div class="text-center mb-5">
                <div class="w-16 h-16 bg-yellow-100 text-yellow-500 rounded-full flex items-center justify-center mx-auto mb-3">
                    <i class='bx bx-question-mark text-4xl'></i>
                </div>
                <h3 class="text-xl font-bold text-sage-900">Sudah Benar?</h3>
                <p class="text-sm text-gray-500 mt-1">Mohon cek kembali pesanan Anda sebelum dikirim ke dapur.</p>
            </div>

            <div class="bg-sage-50 p-4 rounded-2xl border border-sage-100 text-sm text-sage-800 mb-6 space-y-2">
                <div class="flex justify-between">
                    <span class="text-gray-400">Nama:</span>
                    <span class="font-bold" id="confirmNama">-</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-400">Meja:</span>
                    <span class="font-bold" id="confirmMeja">-</span>
                </div>
                <div class="flex justify-between border-t border-dashed border-sage-200 pt-2 mt-1">
                    <span class="text-gray-400">Total Item:</span>
                    <span class="font-bold" id="confirmQty">-</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-400">Total Harga:</span>
                    <span class="font-bold text-sage-600" id="confirmTotal">-</span>
                </div>
            </div>

            <div class="flex gap-3">
                <button onclick="closeConfirmation()" class="flex-1 py-3 rounded-xl border border-gray-200 text-gray-500 font-bold hover:bg-gray-50">
                    Cek Lagi
                </button>
                <button onclick="submitFinalOrder()" id="btnFinalSubmit" class="flex-1 py-3 rounded-xl bg-sage-900 text-white font-bold shadow-lg hover:bg-sage-800 flex justify-center items-center gap-2">
                    Ya, Kirim!
                </button>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="<?= base_url('assets/script-user.js') ?>"></script>
</body>
</html>