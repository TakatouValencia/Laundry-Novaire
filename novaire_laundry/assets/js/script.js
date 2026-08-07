// =========================================================
// Novaire Laundry - script.js
// =========================================================

document.addEventListener('DOMContentLoaded', function () {

    // Auto-hitung total harga di form Pesan Laundry (preview real-time)
    const beratInput = document.querySelector('input[name="berat_kg"]');
    const hargaInput = document.querySelector('input[name="harga_per_kg"]');

    if (beratInput && hargaInput) {
        let preview = document.createElement('div');
        preview.className = 'total-preview';
        preview.style.gridColumn = 'span 2';
        preview.style.fontSize = '14px';
        preview.style.fontWeight = '600';
        preview.style.color = '#1A2340';
        hargaInput.closest('form').appendChild(preview);

        function updateTotal() {
            const berat = parseFloat(beratInput.value) || 0;
            const harga = parseFloat(hargaInput.value) || 0;
            const total = berat * harga;
            preview.textContent = total > 0
                ? 'Estimasi Total: Rp ' + total.toLocaleString('id-ID')
                : '';
        }

        beratInput.addEventListener('input', updateTotal);
        hargaInput.addEventListener('input', updateTotal);
    }

    // Konfirmasi sebelum hapus data (fallback tambahan selain inline onclick)
    document.querySelectorAll('.btn-delete').forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            if (!confirm('Yakin ingin menghapus data ini?')) {
                e.preventDefault();
            }
        });
    });

});
