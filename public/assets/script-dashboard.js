/**
 * FINAL CODE - script-dashboard.js
 * Lokasi: public/assets/js/script-dashboard.js
 */

document.addEventListener('DOMContentLoaded', function() {

    // ==========================================================
    // 1. HELPER: FUNGSI ANIMASI MODAL
    // ==========================================================
    function toggleModal(modal, show) {
        if (!modal) return;
        const container = modal.querySelector('div'); 

        if (show) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            setTimeout(() => {
                modal.classList.remove('opacity-0');
                if(container) {
                    container.classList.remove('scale-95');
                    container.classList.add('scale-100');
                }
            }, 10);
        } else {
            modal.classList.add('opacity-0');
            if(container) {
                container.classList.remove('scale-100');
                container.classList.add('scale-95');
            }
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
            toggleModal(logoutPopup, true);
        });
    }

    if (cancelLogout && logoutPopup) {
        cancelLogout.addEventListener('click', () => {
            toggleModal(logoutPopup, false);
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
    const modalCustomer = document.getElementById('modal-customer'); 
    const modalTotalDisplay = document.getElementById('modal-total-display'); 

    if (paymentPopup && openPaymentButtons.length > 0) {
        openPaymentButtons.forEach(button => {
            button.addEventListener("click", function(e) {
                e.preventDefault();
                
                const orderId = this.dataset.orderid;
                const mejaId = this.dataset.mejaid; 
                const customerName = this.dataset.customer;
                const rawTotal = this.dataset.total;
                const totalHarga = parseFloat(rawTotal) || 0;

                if(orderIdInput) orderIdInput.value = orderId;
                if(tempMejaIdInput) tempMejaIdInput.value = mejaId; 
                if(displayOrderId) displayOrderId.innerText = orderId;
                if(modalCustomer) modalCustomer.innerText = customerName;

                if(modalTotalDisplay) {
                    modalTotalDisplay.innerText = new Intl.NumberFormat('id-ID').format(totalHarga);
                }

                toggleModal(paymentPopup, true);
            });
        });
    }

    if (cancelPaymentBtn && paymentPopup) {
        cancelPaymentBtn.addEventListener("click", () => {
            toggleModal(paymentPopup, false);
        });
    }

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
    // 4. LOGIKA SUBMIT PEMBAYARAN (AJAX)
    // ==========================================================
    const submitPaymentBtn = document.getElementById('submit-payment-btn');
    const paymentMethodSelect = document.getElementById('metode_pembayaran');
    const adminIdInput = document.getElementById('id-admin-input');

    if (submitPaymentBtn && orderIdInput) {
        submitPaymentBtn.addEventListener('click', function() {
            const orderId = orderIdInput.value;
            const mejaId = tempMejaIdInput ? tempMejaIdInput.value : '';
            const paymentMethod = paymentMethodSelect ? paymentMethodSelect.value : 'Tunai';
            const adminId = adminIdInput ? adminIdInput.value : '';
            const targetUrl = this.dataset.url;

            if (!orderId || !targetUrl) {
                alert('Data tidak lengkap. Silakan refresh halaman.');
                return;
            }

            const originalText = submitPaymentBtn.textContent;
            submitPaymentBtn.disabled = true;
            submitPaymentBtn.textContent = 'Memproses...';

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
                    toggleModal(paymentPopup, false);
                    window.location.reload(); 
                } else {
                    alert('GAGAL: ' + (data.message || 'Terjadi kesalahan'));
                    submitPaymentBtn.disabled = false;
                    submitPaymentBtn.textContent = originalText;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan koneksi server.');
                submitPaymentBtn.disabled = false;
                submitPaymentBtn.textContent = originalText;
            });
        });
    }

    // ==========================================================
    // 5. AUTO HIDE FLASH MESSAGE
    // ==========================================================
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
    // 6. LOGIKA GRAFIK DASHBOARD (HANYA INCOME CHART)
    // ==========================================================
    const incomeChartCanvas = document.getElementById('incomeChart');

    if (incomeChartCanvas) {
        const chartUrl = incomeChartCanvas.dataset.url; 

        if (chartUrl) {
            fetch(chartUrl)
                .then(response => {
                    if (!response.ok) throw new Error('Network response was not ok');
                    return response.json();
                })
                .then(data => {
                    renderIncomeChart(incomeChartCanvas, data.income);
                    // Pie Chart dihapus sesuai request
                })
                .catch(error => console.error('Gagal memuat data grafik:', error));
        }
    }

    function renderIncomeChart(canvas, incomeData) {
        const ctx = canvas.getContext('2d');
        
        const labels = incomeData.map(item => {
            const d = new Date(item.tanggal);
            return d.toLocaleDateString('id-ID', { day: 'numeric', month: 'short' });
        });
        const values = incomeData.map(item => item.total);

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Pendapatan (Rp)',
                    data: values,
                    borderColor: '#10b981', 
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    borderWidth: 3,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#10b981',
                    pointRadius: 6,
                    pointHoverRadius: 8,
                    fill: true,
                    tension: 0.3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { borderDash: [2, 4] },
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + (value/1000) + 'k'; 
                            }
                        }
                    },
                    x: { grid: { display: false } }
                }
            }
        });
    }
});