document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('kategori-modal');
    const tambahKategoriBtn = document.getElementById('tambah-kategori-btn');
    const closeModal = document.getElementById('close-modal');
    const batalBtn = document.getElementById('batal-btn');
    const form = document.querySelector('.form-modal');

    const dropArea = document.getElementById('drop-area');
    const fileInput = document.getElementById('fileElem');
    const preview = document.getElementById('preview');

    let fileCache = []; // ✅ simpan semua file yang dipilih/didrop di sini

    // Modal handler
    tambahKategoriBtn.addEventListener('click', () => modal.style.display = 'flex');
    closeModal.addEventListener('click', () => modal.style.display = 'none');
    batalBtn.addEventListener('click', () => {
        form.reset();
        modal.style.display = 'none';
    });

    window.addEventListener('click', (event) => {
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    });

    dropArea.addEventListener('click', () => fileInput.click());

    dropArea.addEventListener('dragover', (e) => {
        e.preventDefault();
        dropArea.classList.add('hover');
    });

    dropArea.addEventListener('dragleave', () => dropArea.classList.remove('hover'));

    dropArea.addEventListener('drop', (e) => {
        e.preventDefault();
        dropArea.classList.remove('hover');
        const droppedFiles = Array.from(e.dataTransfer.files);
        handleFiles(droppedFiles);
        updateFileInput(droppedFiles);
    });

    fileInput.addEventListener('change', (e) => {
        const selectedFiles = Array.from(e.target.files);
        handleFiles(selectedFiles);
        updateFileInput(selectedFiles);
    });

    function handleFiles(files) {
        files.forEach(file => {
            if (file.type.startsWith('image/')) {
                const exists = fileCache.some(f => f.name === file.name && f.lastModified === file.lastModified);
                if (!exists) {
                    const reader = new FileReader();
                    reader.onload = () => {
                        const wrapper = document.createElement('div');
                        wrapper.style.position = 'relative';

                        const img = document.createElement('img');
                        img.src = reader.result;

                        const removeBtn = document.createElement('button');
                        removeBtn.textContent = 'X';
                        removeBtn.classList.add('remove-image');
                        removeBtn.onclick = () => {
                            wrapper.remove();
                            removeFile(file);
                        };

                        wrapper.appendChild(img);
                        wrapper.appendChild(removeBtn);
                        preview.appendChild(wrapper);
                    };
                    reader.readAsDataURL(file);
                }
            }
        });
    }

    function updateFileInput(newFiles) {
        // Tambah ke cache dan hilangkan duplikat
        newFiles.forEach(file => {
            const alreadyExists = fileCache.some(f => f.name === file.name && f.lastModified === file.lastModified);
            if (!alreadyExists) fileCache.push(file);
        });

        // Update input file dengan semua file dalam cache
        const dataTransfer = new DataTransfer();
        fileCache.forEach(file => dataTransfer.items.add(file));
        fileInput.files = dataTransfer.files;
    }

    function removeFile(fileToRemove) {
        fileCache = fileCache.filter(f => f.name !== fileToRemove.name || f.lastModified !== fileToRemove.lastModified);
        const dataTransfer = new DataTransfer();
        fileCache.forEach(file => dataTransfer.items.add(file));
        fileInput.files = dataTransfer.files;
    }

    // Validasi sebelum submit
    const formSubmit = document.querySelector('form');
    formSubmit.addEventListener('submit', (e) => {
        if (fileInput.files.length > 10) {
            e.preventDefault();
            alert('Maksimal 10 gambar!');
        }

        if (fileInput.files.length === 0) {
            e.preventDefault();
            alert('Harap unggah minimal 1 gambar!');
        }
    });
});