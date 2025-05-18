document.addEventListener('DOMContentLoaded', function () {
    const dropArea = document.getElementById('drop-area');
    const fileInput = document.getElementById('fileElem');
    const preview = document.getElementById('preview');
    
    let fileCache = []; // Store the selected files
    
    // When the drop area is clicked, trigger file input click
    dropArea.addEventListener('click', () => fileInput.click());

    // Handle drag over and drag leave for styling
    dropArea.addEventListener('dragover', (e) => {
        e.preventDefault();
        dropArea.classList.add('hover');
    });

    dropArea.addEventListener('dragleave', () => dropArea.classList.remove('hover'));

    // Handle file drop event
    dropArea.addEventListener('drop', (e) => {
        e.preventDefault();
        dropArea.classList.remove('hover');
        const droppedFiles = Array.from(e.dataTransfer.files);
        handleFiles(droppedFiles);
        updateFileInput(droppedFiles);
    });

    // Handle file input change event
    fileInput.addEventListener('change', (e) => {
        const selectedFiles = Array.from(e.target.files);
        handleFiles(selectedFiles);
        updateFileInput(selectedFiles);
    });

    // Handle file preview and cache update
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

    // Update the file input with the selected files
    function updateFileInput(newFiles) {
        newFiles.forEach(file => {
            const alreadyExists = fileCache.some(f => f.name === file.name && f.lastModified === file.lastModified);
            if (!alreadyExists) fileCache.push(file);
        });

        const dataTransfer = new DataTransfer();
        fileCache.forEach(file => dataTransfer.items.add(file));
        fileInput.files = dataTransfer.files;
    }

    // Remove file from the cache
    function removeFile(fileToRemove) {
        fileCache = fileCache.filter(f => f.name !== fileToRemove.name || f.lastModified !== fileToRemove.lastModified);
        const dataTransfer = new DataTransfer();
        fileCache.forEach(file => dataTransfer.items.add(file));
        fileInput.files = dataTransfer.files;
    }

    // Modify form submission validation
    const formSubmit = document.querySelector('form');
    formSubmit.addEventListener('submit', (e) => {
        // Cek jika file melebihi batas maksimum
        if (fileInput.files.length > 10) {
            e.preventDefault();
            alert('Maksimal 10 gambar!');
            return;
        }
        
        // Jangan validasi keberadaan file baru pada edit
        // Hapus validasi ini: if (fileInput.files.length === 0) { ... }
        // Karena pada edit, pengguna mungkin tidak ingin mengubah gambar
    });
});