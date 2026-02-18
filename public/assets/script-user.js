/**
 * FINAL CODE - script-user.js
 * Fitur: Filter, Cart, Modal, Checkout, Konfirmasi Popup, Integrasi Database
 */

let cart = {};
let currentItem = null;
let currentQty = 1;

// =========================================
// 1. FILTER MENU
// =========================================
function filterMenu(category, btn) {
    document.querySelectorAll('.cat-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');

    const items = document.querySelectorAll('.menu-card');
    items.forEach((item, index) => {
        if (category === 'all' || item.dataset.category === category) {
            item.style.display = 'block';
            item.style.animation = 'none';
            item.offsetHeight; /* trigger reflow */
            item.style.animation = `fadeUp 0.5s ease-out forwards ${index * 0.05}s`;
        } else {
            item.style.display = 'none';
        }
    });
}

// =========================================
// 2. MODAL DETAIL
// =========================================
function openDetail(menu) {
    currentItem = menu;
    currentQty = 1;

    document.getElementById('detailImg').src = 'http://localhost:8080/assets/image/' + menu.gambar;
    document.getElementById('detailCat').innerText = menu.nama_kategori || 'Umum';
    document.getElementById('detailName').innerText = menu.nama_menu;
    document.getElementById('detailDesc').innerText = menu.deskripsi || 'Menu spesial pilihan chef kami.';
    document.getElementById('detailPrice').innerText = formatRupiah(menu.harga);
    document.getElementById('detailQty').innerText = 1;

    const modal = document.getElementById('detailModal');
    modal.classList.remove('hidden');
    setTimeout(() => {
        modal.querySelector('div:first-child').classList.remove('opacity-0');
        modal.querySelector('div:last-child').classList.remove('translate-y-full');
    }, 10);
}

function closeModal() {
    const modal = document.getElementById('detailModal');
    modal.querySelector('div:first-child').classList.add('opacity-0');
    modal.querySelector('div:last-child').classList.add('translate-y-full');
    setTimeout(() => modal.classList.add('hidden'), 300);
}

function updateQty(change) {
    if (currentQty + change > 0) {
        currentQty += change;
        document.getElementById('detailQty').innerText = currentQty;
    }
}

// =========================================
// 3. CART SYSTEM
// =========================================
function addToCart() {
    const id = currentItem.id_menu;
    if (!cart[id]) cart[id] = { ...currentItem, qty: 0 };
    cart[id].qty += currentQty;
    
    updateCartUI();
    closeModal();
    
    const Toast = Swal.mixin({
        toast: true, position: 'top', showConfirmButton: false, timer: 1500,
        background: '#2f483a', color: '#fff', iconColor: '#fff'
    });
    Toast.fire({ icon: 'success', title: `+${currentQty} ${currentItem.nama_menu}` });
}

function updateCartUI() {
    let totalQty = 0;
    let totalPrice = 0;
    for (let id in cart) {
        totalQty += cart[id].qty;
        totalPrice += cart[id].qty * cart[id].harga;
    }
    
    const float = document.getElementById('cart-float');
    if (totalQty > 0) {
        document.getElementById('total-qty-float').innerText = totalQty;
        document.getElementById('total-price-float').innerText = formatRupiah(totalPrice);
        float.classList.remove('translate-y-[200%]');
        float.classList.add('translate-y-0');
    } else {
        float.classList.add('translate-y-[200%]');
        float.classList.remove('translate-y-0');
    }
}

// =========================================
// 4. CHECKOUT LOGIC
// =========================================
function openCheckout() {
    renderCheckoutList();
    document.getElementById('checkoutModal').classList.remove('hidden');
}

function renderCheckoutList() {
    const list = document.getElementById('checkoutList');
    const totalEl = document.getElementById('checkoutTotal');
    list.innerHTML = '';
    
    let total = 0;
    let hasItem = false;

    for (let id in cart) {
        if (cart[id].qty > 0) {
            hasItem = true;
            let sub = cart[id].qty * cart[id].harga;
            total += sub;
            
            list.innerHTML += `
                <div class="flex items-center gap-3 bg-white border border-gray-100 p-3 rounded-2xl shadow-sm hover:shadow-md transition-shadow">
                    <img src="http://localhost:8080/assets/image/${cart[id].gambar}" class="w-14 h-14 rounded-xl object-cover bg-gray-50">
                    <div class="flex-1">
                        <h4 class="text-sm font-bold text-sage-900 line-clamp-1">${cart[id].nama_menu}</h4>
                        <p class="text-[10px] text-gray-400 font-bold mb-1">${formatRupiah(cart[id].harga)} / item</p>
                        <div class="flex items-center gap-2">
                             <button onclick="changeCartQty('${id}', -1)" class="w-6 h-6 bg-gray-50 rounded-lg flex items-center justify-center font-bold text-gray-500 hover:bg-gray-200">-</button>
                             <span class="text-xs font-bold text-sage-900 w-4 text-center">${cart[id].qty}</span>
                             <button onclick="changeCartQty('${id}', 1)" class="w-6 h-6 bg-sage-500 rounded-lg flex items-center justify-center font-bold text-white hover:bg-sage-600">+</button>
                        </div>
                    </div>
                    <div class="flex flex-col items-end gap-2">
                        <button onclick="deleteItem('${id}')" class="text-red-300 hover:text-red-500 transition-colors">
                            <i class='bx bxs-trash-alt text-lg'></i>
                        </button>
                        <span class="font-bold text-sage-700 text-xs">${formatRupiah(sub)}</span>
                    </div>
                </div>
            `;
        }
    }

    if (!hasItem) {
        closeCheckout();
        return;
    }
    totalEl.innerText = formatRupiah(total);
}

function changeCartQty(id, change) {
    if (cart[id].qty + change > 0) {
        cart[id].qty += change;
    } else {
        delete cart[id];
    }
    renderCheckoutList(); 
    updateCartUI(); 
}

function deleteItem(id) {
    delete cart[id];
    renderCheckoutList();
    updateCartUI();
}

function closeCheckout() {
    document.getElementById('checkoutModal').classList.add('hidden');
}

// =========================================
// 5. CONFIRMATION POPUP (NEW)
// =========================================
function openConfirmation() {
    const nama = document.getElementById('inputNama').value;
    
    // 1. Validasi Nama Dulu
    if (!nama) {
        Swal.fire('Eits!', 'Nama pemesan wajib diisi ya.', 'warning');
        return;
    }

    // 2. Hitung Ulang Total untuk Display
    let totalHarga = 0;
    let totalQty = 0;
    let noMeja = '0';
    const mejaEl = document.getElementById('displayTableNumber');
    if (mejaEl) noMeja = mejaEl.innerText.trim();

    for (let id in cart) {
        if (cart[id].qty > 0) {
            totalHarga += (cart[id].qty * cart[id].harga);
            totalQty += cart[id].qty;
        }
    }

    if (totalQty === 0) {
        Swal.fire('Kosong', 'Pilih menu dulu dong.', 'warning');
        return;
    }

    // 3. Isi Data ke Modal Konfirmasi
    document.getElementById('confirmNama').innerText = nama;
    document.getElementById('confirmMeja').innerText = "Meja " + noMeja;
    document.getElementById('confirmQty').innerText = totalQty + " Item";
    document.getElementById('confirmTotal').innerText = formatRupiah(totalHarga);

    // 4. Buka Modal dengan Animasi
    const modal = document.getElementById('confirmModal');
    modal.classList.remove('hidden');
    setTimeout(() => {
        modal.querySelector('div:first-child').classList.remove('opacity-0');
        modal.querySelector('div:last-child').classList.remove('scale-95');
        modal.querySelector('div:last-child').classList.add('scale-100');
    }, 10);
}

function closeConfirmation() {
    const modal = document.getElementById('confirmModal');
    modal.querySelector('div:first-child').classList.add('opacity-0');
    modal.querySelector('div:last-child').classList.remove('scale-100');
    modal.querySelector('div:last-child').classList.add('scale-95');
    setTimeout(() => modal.classList.add('hidden'), 300);
}


// =========================================
// 6. PROSES ORDER KE DATABASE
// =========================================
async function submitFinalOrder() {
    const btn = document.getElementById('btnFinalSubmit');
    const originalText = btn.innerHTML;
    
    // Loading State
    btn.innerHTML = `<i class='bx bx-loader-alt animate-spin'></i> Kirim...`;
    btn.disabled = true;

    // Ambil Data Final
    const nama = document.getElementById('inputNama').value;
    const hp = document.getElementById('inputHP').value;
    let noMeja = '0';
    const mejaEl = document.getElementById('displayTableNumber');
    if (mejaEl) noMeja = mejaEl.innerText.trim();

    let items = [];
    let totalHarga = 0;

    for (let id in cart) {
        if (cart[id].qty > 0) {
            items.push({
                id_menu: id,
                qty: cart[id].qty,
                harga: cart[id].harga
            });
            totalHarga += (cart[id].qty * cart[id].harga);
        }
    }

    try {
        const response = await fetch('http://localhost:8080/order/process', { 
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                nama: nama,
                no_hp: hp,
                no_meja: noMeja,
                total_harga: totalHarga,
                items: items
            })
        });

        const result = await response.json();

        if (result.success) {
            closeConfirmation(); // Tutup Popup Konfirmasi
            closeCheckout();     // Tutup Checkout

            Swal.fire({
                icon: 'success',
                title: 'Pesanan Diterima!',
                text: `Terima kasih ${nama}, pesanan sedang diproses dapur.`,
                timer: 2000,
                showConfirmButton: false
            }).then(() => {
                cart = {};
                window.location.href = 'http://localhost:8080/order/success/' + result.id_order;
            });
        } else {
            // Tampilkan error dari validasi backend
            let errMsg = result.message;
            if (result.errors) {
                errMsg += '\n' + JSON.stringify(result.errors);
            }
            Swal.fire('Gagal', errMsg, 'error');
            btn.innerHTML = originalText;
            btn.disabled = false;
        }

    } catch (error) {
        console.error(error);
        Swal.fire('Error', 'Gagal menghubungi server.', 'error');
        btn.innerHTML = originalText;
        btn.disabled = false;
    }
}

// Helper Format Rupiah
function formatRupiah(n) {
    return 'Rp ' + new Intl.NumberFormat('id-ID').format(n);
}