document.addEventListener("DOMContentLoaded", function() {
    
    // === 1. IMAGE SLIDER ===
    const bgElement = document.getElementById('bg-slider');
    const images = [
        "https://images.unsplash.com/photo-1544025162-d76694265947?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80", 
        "https://images.unsplash.com/photo-1504674900247-0877df9cc836?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80",
        "https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80", 
        "https://images.unsplash.com/photo-1414235077428-338989a2e8c0?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80"
    ];
    let currentIndex = 0;

    function changeBackground() {
        const nextIndex = (currentIndex + 1) % images.length;
        const img = new Image();
        img.src = images[nextIndex];
        img.onload = () => {
            currentIndex = nextIndex;
            if(bgElement) {
                bgElement.style.backgroundImage = `url('${images[currentIndex]}')`;
            }
        };
    }
    setInterval(changeBackground, 5000);


    // === 2. TOGGLE PASSWORD ===
    const toggleBtn = document.getElementById('togglePasswordBtn');
    const passwordField = document.getElementById('password');
    const eyeIcon = document.getElementById('eyeIcon');

    if (toggleBtn) {
        toggleBtn.addEventListener('click', function() {
            if (passwordField.type === "password") {
                passwordField.type = "text";
                eyeIcon.textContent = "visibility"; 
                eyeIcon.style.color = "#11d452"; 
            } else {
                passwordField.type = "password";
                eyeIcon.textContent = "visibility_off";
                eyeIcon.style.color = "#9db99d"; 
            }
        });
    }


    // === 3. AUTO SWEETALERT (FROM DATA ATTRIBUTES) ===
    const flashData = document.getElementById('flash-data');
    
    // Cek apakah ada data error
    const errorMsg = flashData.getAttribute('data-error');
    if (errorMsg) {
        Swal.fire({
            icon: 'error',
            title: 'Access Denied',
            text: errorMsg,
            confirmButtonColor: '#587a58',
            background: '#f4f7f4'
        });
    }

    // Cek apakah ada data sukses
    const successMsg = flashData.getAttribute('data-success');
    if (successMsg) {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true
        });
        Toast.fire({
            icon: 'success',
            title: successMsg
        });
    }
});