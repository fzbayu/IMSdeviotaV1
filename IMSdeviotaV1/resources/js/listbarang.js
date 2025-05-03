let cart = []; // Array of { id_barang, nama, jumlah, stok }

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.tambah').forEach(button => {
        button.addEventListener('click', function () {
            const barang = this.closest('.barang');
            const id_barang = parseInt(barang.dataset.id);
            const nama = barang.querySelector('h4').textContent;
            const stok = parseInt(barang.dataset.stok);
            const jumlahEl = barang.querySelector('.jumlah');

            let item = cart.find(i => i.id_barang === id_barang);

            if (item) {
                if (item.jumlah < item.stok) {
                    item.jumlah++;
                    jumlahEl.textContent = item.jumlah;
                } else {
                    alert('Stok tidak mencukupi!');
                }
            } else {
                cart.push({ id_barang, nama, jumlah: 1, stok });
                jumlahEl.textContent = 1;
                barang.classList.add('selected');
            }

            updateCart();
        });
    });

    document.querySelectorAll('.kurang').forEach(button => {
        button.addEventListener('click', function () {
            const barang = this.closest('.barang');
            const id_barang = parseInt(barang.dataset.id);
            const jumlahEl = barang.querySelector('.jumlah');

            let itemIndex = cart.findIndex(i => i.id_barang === id_barang);

            if (itemIndex !== -1) {
                let item = cart[itemIndex];
                if (item.jumlah > 1) {
                    item.jumlah--;
                    jumlahEl.textContent = item.jumlah;
                } else {
                    cart.splice(itemIndex, 1);
                    jumlahEl.textContent = 0;
                    barang.classList.remove('selected');
                }
                updateCart();
            }
        });
    });
});

function syncCartToInput() {
    if (cart.length === 0) {
        alert("Silakan pilih barang terlebih dahulu.");
        return false;
    }
    document.getElementById('cart-input').value = JSON.stringify(cart);
    return true;
}

function updateCart() {
    const total = cart.reduce((sum, item) => sum + item.jumlah, 0);
    document.getElementById('total-pinjam').textContent = total;
    console.log('Isi keranjang:', cart);
}

window.syncCartToInput = syncCartToInput; // agar bisa diakses dari onsubmit form