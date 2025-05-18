import '../../../css/admin/pengambilan/index.css';

document.addEventListener('DOMContentLoaded', function() {
        // Set default dates if not already set
        if (!document.getElementById('tanggal_mulai').value) {
            let today = new Date().toISOString().split('T')[0];
            document.getElementById('tanggal_mulai').value = today;
            document.getElementById('tanggal_selesai').value = today;
        }

        const deleteSelectedBtn = document.getElementById('deleteSelectedBtn');

        function updateDeleteButtonState() {
            const checked = document.querySelectorAll('.row-checkbox:checked').length;
            deleteSelectedBtn.disabled = checked === 0;
        }

        // Baris dapat diklik untuk memilih checkbox
        document.querySelectorAll('tbody tr').forEach(row => {
            row.addEventListener('click', function(e) {
                // Cegah toggle jika klik langsung pada checkbox
                if (e.target.type === 'checkbox') return;

                const checkbox = this.querySelector('.row-checkbox');
                checkbox.checked = !checkbox.checked;
                updateDeleteButtonState();
            });
        });

        // Tetap dukung perubahan dari klik langsung checkbox
        document.querySelectorAll('.row-checkbox').forEach(cb => {
            cb.addEventListener('change', updateDeleteButtonState);
        });

        deleteSelectedBtn.addEventListener('click', () => {
            const selectedIds = Array.from(document.querySelectorAll('.row-checkbox:checked'))
                .map(cb => cb.value);

            if (selectedIds.length > 0 && confirm('Yakin ingin menghapus data yang dipilih?')) {
                fetch("{{ route('admin/pengambilan.deleteSelected') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        ids: selectedIds
                    })
                }).then(response => {
                    if (response.ok) location.reload();
                    else alert("Gagal menghapus data.");
                });
            }
        });
    });