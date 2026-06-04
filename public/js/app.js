document.addEventListener('DOMContentLoaded', () => {
    if (window.jQuery && document.querySelector('.data-table')) {
        $('.data-table').DataTable({
            pageLength: 10,
            responsive: true,
            language: {
                search: 'Cari:',
                lengthMenu: 'Tampilkan _MENU_ data',
                info: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ data',
                paginate: {
                    previous: 'Sebelumnya',
                    next: 'Berikutnya',
                },
            },
        });
    }

    document.querySelectorAll('.btn-delete').forEach((button) => {
        button.addEventListener('click', (event) => {
            if (!window.Swal) {
                return;
            }

            event.preventDefault();
            const targetUrl = button.getAttribute('href');
            Swal.fire({
                title: 'Hapus data ini?',
                text: 'Data yang dihapus tidak dapat dikembalikan.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, hapus',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#dc3545',
            }).then((result) => {
                if (result.isConfirmed && targetUrl) {
                    window.location.href = targetUrl;
                }
            });
        });
    });

    const flash = document.querySelector('.flash-alert');
    if (flash && window.Swal) {
        const message = flash.textContent.trim();
        const isSuccess = flash.classList.contains('alert-success');
        const isWarning = flash.classList.contains('alert-warning');
        const isInfo = flash.classList.contains('alert-info');
        Swal.fire({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            icon: isSuccess ? 'success' : isWarning ? 'warning' : isInfo ? 'info' : 'error',
            title: message,
        });
    }
});
