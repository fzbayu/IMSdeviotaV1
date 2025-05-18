import '../../../css/admin/peminjaman/index.css';

// Set tanggal default (opsional)
    document.addEventListener('DOMContentLoaded', function() {
        if (!document.getElementById('tanggal_mulai').value) {
            let today = new Date().toISOString().split('T')[0];
            document.getElementById('tanggal_mulai').value = today;
            document.getElementById('tanggal_selesai').value = today;
        }

        // Row selection functionality
        const checkboxes = document.querySelectorAll('.row-checkbox');
        const deleteSelectedBtn = document.getElementById('deleteSelectedBtn');
        const deleteAllBtn = document.getElementById('deleteAllBtn');
        const rows = document.querySelectorAll('tbody tr');

        // Add event listeners to checkboxes
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const row = this.closest('tr');
                if (this.checked) {
                    row.classList.add('selected-row');
                } else {
                    row.classList.remove('selected-row');
                }
                updateDeleteButtonState();
            });
        });

        rows.forEach(row => {
            row.addEventListener('click', function(e) {
                // Cegah toggle checkbox jika klik terjadi di elemen interaktif
                if (
                    e.target.tagName !== 'INPUT' &&
                    e.target.tagName !== 'A' &&
                    !e.target.closest('.foto-thumbs') && // ⬅ cegah jika klik di gambar
                    !e.target.classList.contains('foto-more-indicator') &&
                    !e.target.closest('.foto-popover')
                ) {
                    const checkbox = this.querySelector('.row-checkbox');
                    checkbox.checked = !checkbox.checked;
                    checkbox.dispatchEvent(new Event('change'));
                }
            });
        });


        // Update delete button state based on selected rows
        function updateDeleteButtonState() {
            const selectedCount = document.querySelectorAll('.row-checkbox:checked').length;
            deleteSelectedBtn.disabled = selectedCount === 0;
        }

        // Delete selected rows
        deleteSelectedBtn.addEventListener('click', function() {
            const selectedIds = Array.from(document.querySelectorAll('.row-checkbox:checked'))
                .map(checkbox => checkbox.value);

            if (selectedIds.length > 0 && confirm('Apakah Anda yakin ingin menghapus data yang dipilih?')) {
                // Send AJAX request to delete selected items
                fetch('{{ route("admin/peminjaman.deleteSelected") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            ids: selectedIds
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            window.location.reload();
                        } else {
                            alert('Gagal menghapus data');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan saat menghapus data');
                    });
            }
        });

        deleteAllBtn.addEventListener('click', function() {
            if (confirm('Apakah Anda yakin ingin menghapus SEMUA data peminjaman?')) {
                fetch('{{ route("admin/peminjaman.deleteAll") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            window.location.reload();
                        } else {
                            alert('Gagal menghapus semua data');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan saat menghapus data');
                    });
            }
        });
    });

    // Tambahkan di bagian script
    // Modal foto
    const modal = document.createElement('div');
    modal.className = 'modal-foto';
    modal.innerHTML = `
    <span class="close-modal">&times;</span>
    <div class="modal-nav">
        <span class="modal-nav-btn prev-btn">&#10094;</span>
        <span class="modal-nav-btn next-btn">&#10095;</span>
    </div>
    <div class="modal-content">
        <img class="modal-img" src="">
        <div class="foto-counter" style="position: absolute; bottom: 20px; left: 50%; transform: translateX(-50%); 
            background: rgba(0,0,0,0.7); color: white; padding: 5px 10px; border-radius: 10px;">
            <span class="current-index">1</span>/<span class="total-fotos">0</span>
        </div>
    </div>
`;
    document.body.appendChild(modal);

    let currentFotoIndex = 0;
    let currentFotoSet = [];

    // Fungsi untuk membuka modal dengan semua foto
    function openFotoModal(fotos, startIndex = 0) {
        currentFotoSet = fotos;
        currentFotoIndex = startIndex;
        modal.querySelector('.modal-img').src = currentFotoSet[currentFotoIndex];
        modal.querySelector('.current-index').textContent = currentFotoIndex + 1;
        modal.querySelector('.total-fotos').textContent = currentFotoSet.length;
        modal.style.display = 'block';
        document.body.style.overflow = 'hidden';
    }

    // Event listener untuk thumbnail dan indicator
    document.querySelectorAll('.foto-thumbnail, .foto-more-indicator').forEach(element => {
        element.addEventListener('click', function(e) {
            e.preventDefault();
            const fotos = JSON.parse(this.getAttribute('data-all-fotos'));
            // Jika klik thumbnail, cari indexnya
            const startIndex = this.classList.contains('foto-thumbnail') ?
                Array.from(this.parentElement.parentElement.querySelectorAll('.foto-thumbnail')).indexOf(this) : 0;
            openFotoModal(fotos, startIndex);
        });
    });

    // Navigasi foto
    modal.querySelector('.prev-btn').addEventListener('click', function() {
        currentFotoIndex = (currentFotoIndex - 1 + currentFotoSet.length) % currentFotoSet.length;
        modal.querySelector('.modal-img').src = currentFotoSet[currentFotoIndex];
        modal.querySelector('.current-index').textContent = currentFotoIndex + 1;
    });

    modal.querySelector('.next-btn').addEventListener('click', function() {
        currentFotoIndex = (currentFotoIndex + 1) % currentFotoSet.length;
        modal.querySelector('.modal-img').src = currentFotoSet[currentFotoIndex];
        modal.querySelector('.current-index').textContent = currentFotoIndex + 1;
    });

    // Tutup modal
    modal.querySelector('.close-modal').addEventListener('click', function() {
        modal.style.display = 'none';
        document.body.style.overflow = 'auto';
    });

    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            modal.style.display = 'none';
            document.body.style.overflow = 'auto';
        }
    });

    // // Tambahkan tooltip untuk foto
    // document.querySelectorAll('.foto-thumbs a img').forEach(img => {
    //     img.addEventListener('mouseover', function() {
    //         const tooltip = document.createElement('div');
    //         tooltip.className = 'tooltip';
    //         tooltip.textContent = this.title;
    //         tooltip.style.position = 'absolute';
    //         tooltip.style.backgroundColor = 'rgba(0,0,0,0.8)';
    //         tooltip.style.color = 'white';
    //         tooltip.style.padding = '5px 10px';
    //         tooltip.style.borderRadius = '4px';
    //         tooltip.style.zIndex = '100';

    //         const rect = this.getBoundingClientRect();
    //         tooltip.style.left = `${rect.left + window.scrollX}px`;
    //         tooltip.style.top = `${rect.top + window.scrollY - 35}px`;

    //         document.body.appendChild(tooltip);

    //         this.addEventListener('mouseout', function() {
    //             document.body.removeChild(tooltip);
    //         });
    //     });
    // });