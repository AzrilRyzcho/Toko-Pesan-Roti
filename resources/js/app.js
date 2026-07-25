// Toko Pesan Roti - JavaScript Bundle

// Import Bootstrap JS components
import * as bootstrap from 'bootstrap';
window.bootstrap = bootstrap;

// Import SweetAlert2
import Swal from 'sweetalert2';
window.Swal = Swal;

// Import Chart.js
import Chart from 'chart.js/auto';
window.Chart = Chart;

// Global helpers
window.showAlert = (title, text, icon = 'info') => {
    Swal.fire({
        title: title,
        text: text,
        icon: icon,
        confirmButtonColor: '#4a3728'
    });
};

window.confirmDelete = (title, text, confirmButtonText = 'Yes, delete it!') => {
    return Swal.fire({
        title: title,
        text: text,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#4a3728',
        cancelButtonColor: '#c5a880',
        confirmButtonText: confirmButtonText
    });
};
