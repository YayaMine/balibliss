<!DOCTYPE html>
<html lang="id">
<head>
    <?php $this->load->view('partials/header'); ?>
    <link rel="stylesheet" href="<?= base_url('assets/css/stylesform.css'); ?>">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700&display=swap" rel="stylesheet">
    <style>
     /* Gaya umum halaman */
body {
    font-family: 'Nunito', sans-serif;
    margin: 0;
    padding: 0;
    background: linear-gradient(to right, #e0f7ff, #ffffff);
}

.page-wrapper {
    display: flex;
    height: 100vh;
    overflow: hidden;
}

.sidebar {
    width: 250px;
    height: 100vh;
    position: fixed;
    top: 0;
    left: 0;
    background-color: #343a40;
    color: white;
    padding: 20px;
    box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
    z-index: 1000;
}

.navbar {
    background-color: #fff;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    z-index: 999;
    position: fixed;
    top: 0;
    right: 0;
    width: calc(100% - 250px);
    padding: 10px 20px;
    border-bottom: 1px solid #ddd;
}

.navbar-brand img {
    height: 50px;
    width: auto;
}

.main-content {
    flex: 1;
    margin-top: 60px; /* Adjusted for navbar */
    margin-left: 300px;
    overflow-y: auto;
    padding: 80px;
   
}

.container {
    display: flex;
    flex-direction: column; /* Tampilkan card utama di atas */
    align-items: center;
    gap: 20px;
}

.card-main {
    background: #ffffff;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    width: 100%;
    max-width: 800px; /* Lebar maksimum card utama */
    padding: 20px;
    text-align: center; /* Teks tengah-tengah */
}

.card-main h2 {
    margin-top: 0;
}

.card-main p {
    margin-bottom: 20px;
}

.card-small-container {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    justify-content: justify;
}

.card-small {
    background: #ffffff;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    width: 300px;
    flex-shrink: 0;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    display: flex;
    flex-direction: column;
    text-align: center; /* Teks tengah-tengah */
}

.card-small-header {
    background: #007bff;
    color: #fff;
    padding: 15px;
    border-radius: 10px 10px 0 0;
    font-size: 16px;
    font-weight: 700; /* Font bold */
    display: flex;
    align-items: center;
    justify-content: center; /* Teks tengah-tengah */
}

.card-small-header i {
    margin-right: 10px;
    font-size: 20px;
}

.card-small-body {
    padding: 20px;
    font-size: 14px;
    color: #333;
    display: flex;
    flex-direction: column;
    text-align: center; /* Teks tengah-tengah */
}

.card-small-body p {
    margin: 0;
    font-weight: 700; /* Font bold */
}

.card-small-footer {
    background: #f8f9fa;
    border-radius: 0 0 10px 10px;
    padding: 15px;
    text-align: center; /* Teks tengah-tengah */
}

.btn-remove {
    background-color: #dc3545;
    color: #fff;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
    text-decoration: none;
    font-weight: 700; /* Font bold */
}

.btn-remove:hover {
    background-color: #c82333;
}

#message-container {
    margin-bottom: 20px;
}

.alert {
    padding: 10px 20px;
    border-radius: 5px;
    margin-bottom: 20px;
    font-size: 16px;
    text-align: center; /* Teks tengah-tengah */
}

.alert-success {
    background-color: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

.alert-danger {
    background-color: #d4edda;
    color: #721c24;
    border: 1px solid #f5c6cb;
}

.text-center {
    text-align: center; /* Teks tengah-tengah */
}

.btn-print {
    background-color: #3498db; /* Warna biru untuk cetak */
}

    </style>
</head>
<body>
<div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
    <?php $this->load->view('pengguna/sidebar'); ?>
    <div class="main-content">
        <?php $this->load->view('pengguna/navbar'); ?>
        <div class="main-container">
            <div class="card-main">
                <h2>Riwayat Pembelian Tiket</h2>
                <p>Berikut adalah riwayat pembelian tiket Anda. Anda dapat menghapus tiket yang tidak diperlukan lagi menggunakan tombol di bawah setiap card.</p>
            </div>
            
            <div id="message-container">
                <!-- Pesan sukses atau kesalahan akan ditampilkan di sini -->
            </div>
            
            <div class="card-small-container">
                <?php foreach ($cart_data as $item): ?>
                    <div class="card-small">
                        <div class="card-small-header">
                            <i class="fas fa-ticket-alt"></i> ID Pesanan: <?= isset($item['id_pesanan']) ? htmlspecialchars($item['id_pesanan'], ENT_QUOTES, 'UTF-8') : 'Tidak ada ID' ?>
                        </div>
                        <div class="card-small-body">
                            <p>Tanggal Kunjungan: <?= isset($item['tgl_kunjungan']) ? htmlspecialchars($item['tgl_kunjungan'], ENT_QUOTES, 'UTF-8') : 'Tidak ada tanggal' ?></p>
                        </div>
                        <div class="card-small-footer">
                            <a href="#" data-id="<?= htmlspecialchars($item['id_pesanan'], ENT_QUOTES, 'UTF-8') ?>" class="btn-remove">Hapus Checkout</a>
                            <a href="<?= site_url('Ctiket/cetakpdf/' . htmlspecialchars($item['id_pesanan'], ENT_QUOTES, 'UTF-8')); ?>" class="btn-print">Cetak Tiket</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
<script>
$(document).ready(function() {
    $('.btn-remove').click(function(e) {
        e.preventDefault(); // Mencegah aksi default link
        var id = $(this).data('id');
        
        $.ajax({
            url: '<?= site_url('Ctiket/remove') ?>/' + id,
            type: 'POST',
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    $('#message-container').html('<div class="alert alert-success">' + response.message + '</div>');
                    // Menghapus card dari DOM setelah penghapusan sukses
                    $('a[data-id="' + id + '"]').closest('.card-small').remove();
                } else {
                    $('#message-container').html('<div class="alert alert-danger">' + response.message + '</div>');
                }
            },
            error: function() {
                $('#message-container').html('<div class="alert alert-danger">Terjadi kesalahan saat memproses permintaan.</div>');
            }
        });
    });
});
</script>
</body>
</html>
