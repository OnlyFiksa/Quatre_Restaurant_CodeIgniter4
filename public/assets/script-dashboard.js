document.addEventListener('DOMContentLoaded', function() {

    // ==========================================================
    // 1. HELPER: FUNGSI ANIMASI MODAL (TAILWIND)
    // ==========================================================
    // Fungsi ini menangani efek Fade In/Out agar halus
    function toggleModal(modal, show) {
        if (!modal) return;
        const container = modal.querySelector('div'); // Kotak putih di dalam overlay

        if (show) {
            // Tampilkan Overlay
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            
            // Animasi Masuk (Tunggu 10ms agar class 'flex' ter-render dulu)
            setTimeout(() => {
                modal.classList.remove('opacity-0');
                if(container) {
                    container.classList.remove('scale-95');
                    container.classList.add('scale-100');
                }
            }, 10);
        } else {
            // Animasi Keluar
            modal.classList.add('opacity-0');
            if(container) {
                container.classList.remove('scale-100');
                container.classList.add('scale-95');
            }

            // Sembunyikan elemen setelah durasi animasi selesai (300ms)
            setTimeout(() => {
                modal.classList.remove('flex');
                modal.classList.add('hidden');
            }, 300);
        }
    }

    // ==========================================================
    // 2. LOGIKA POPUP LOGOUT
    // ==========================================================
    const logoutBtn = document.getElementById('logout-btn');
    const logoutPopup = document.getElementById('logout-popup');
    const cancelLogout = document.getElementById('cancel-logout-btn');

    if (logoutBtn && logoutPopup) {
        logoutBtn.addEventListener('click', (e) => {
            e.preventDefault();
            toggleModal(logoutPopup, true); // Buka
        });
    }

    if (cancelLogout && logoutPopup) {
        cancelLogout.addEventListener('click', () => {
            toggleModal(logoutPopup, false); // Tutup
        });
    }

    // ==========================================================
    // 3. LOGIKA POPUP PEMBAYARAN
    // ==========================================================
    const paymentPopup = document.getElementById('payment-popup');
    const cancelPaymentBtn = document.getElementById('cancel-payment-btn');
    const openPaymentButtons = document.querySelectorAll('.open-payment-popup');
    
    // Form Inputs
    const orderIdInput = document.getElementById('id-order-input');
    const tempMejaIdInput = document.getElementById('temp-meja-id-input');
    const displayOrderId = document.getElementById('display-order-id');

    // A. BUKA POPUP PEMBAYARAN
    if (paymentPopup && openPaymentButtons.length > 0) {
        openPaymentButtons.forEach(button => {
            button.addEventListener("click", function(e) {
                e.preventDefault();
                
                // Ambil data dari tombol
                const orderId = this.dataset.orderid;
                const mejaId = this.dataset.mejaid; 

                // Isi Input Hidden
                if(orderIdInput) orderIdInput.value = orderId;
                if(tempMejaIdInput) tempMejaIdInput.value = mejaId; 
                if(displayOrderId) displayOrderId.innerText = orderId;

                // Tampilkan Modal
                toggleModal(paymentPopup, true);
            });
        });
    }

    // B. TUTUP POPUP PEMBAYARAN
    if (cancelPaymentBtn && paymentPopup) {
        cancelPaymentBtn.addEventListener("click", () => {
            toggleModal(paymentPopup, false);
        });
    }

    // C. TUTUP JIKA KLIK AREA GELAP (OVERLAY)
    [logoutPopup, paymentPopup].forEach(popup => {
        if(popup) {
            popup.addEventListener('click', function(event) {
                if (event.target === popup) {
                    toggleModal(popup, false);
                }
            });
        }
    });

    // ==========================================================
    // 4. LOGIKA SUBMIT PEMBAYARAN (AJAX FETCH)
    // ==========================================================
    const submitPaymentBtn = document.getElementById('submit-payment-btn');
    const paymentMethodSelect = document.getElementById('metode_pembayaran');
    const adminIdInput = document.getElementById('id-admin-input');

    if (submitPaymentBtn && orderIdInput) {
        submitPaymentBtn.addEventListener('click', function() {
            // Ambil Data Form
            const orderId = orderIdInput.value;
            const mejaId = tempMejaIdInput ? tempMejaIdInput.value : '';
            const paymentMethod = paymentMethodSelect ? paymentMethodSelect.value : 'Tunai';
            const adminId = adminIdInput ? adminIdInput.value : '';
            
            // Ambil URL dari atribut tombol (Penting untuk CI4!)
            const targetUrl = this.dataset.url;

            // Validasi
            if (!orderId || !targetUrl) {
                alert('Data tidak lengkap. Silakan refresh halaman.');
                return;
            }

            // UI Loading
            const originalText = submitPaymentBtn.textContent;
            submitPaymentBtn.disabled = true;
            submitPaymentBtn.textContent = 'Memproses...';

            // Kirim Data JSON
            fetch(targetUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    id_order: orderId,
                    id_meja: mejaId,
                    metode_pembayaran: paymentMethod,
                    id_admin: adminId
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('PEMBAYARAN BERHASIL!');
                    toggleModal(paymentPopup, false);
                    window.location.reload(); // Refresh tabel
                } else {
                    alert('GAGAL: ' + data.message);
                    submitPaymentBtn.disabled = false;
                    submitPaymentBtn.textContent = originalText;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan koneksi.');
                submitPaymentBtn.disabled = false;
                submitPaymentBtn.textContent = originalText;
            });
        });
    }

    // ==========================================================
    // 5. AUTO HIDE FLASH MESSAGE (Opsional)
    // ==========================================================
    // Menghilangkan notifikasi sukses/error otomatis setelah 3 detik
    const flashMessages = document.querySelectorAll('.flash-msg');
    if(flashMessages.length > 0) {
        setTimeout(() => {
            flashMessages.forEach(msg => {
                msg.style.transition = "opacity 0.5s ease";
                msg.style.opacity = "0";
                setTimeout(() => msg.remove(), 500);
            });
        }, 3000);
    }

    // ==========================================================
    // 6. FIX BUG BACK BUTTON (Logout Security)
    // ==========================================================
    window.addEventListener("pageshow", function (event) {
        var historyTraversal = event.persisted || 
                               (typeof window.performance != "undefined" && 
                                window.performance.navigation.type === 2);
        if (historyTraversal) {
            window.location.reload();
        }
    });
});