<!DOCTYPE html>
<html lang="id">

<head>
    <?php $this->load->view('partials/header'); ?>
    <link rel="stylesheet" href="<?= base_url('assets/css/stylesrate.css'); ?>">
    <style>
    /* CSS styles */
    body {
        font-family: 'Poppins', sans-serif;
    }
    
    .page-wrapper {
        display: flex;
        height: 100vh;
        overflow: hidden;
    }

    .main-content {
        flex: 1;
        margin-top: 70px;
        margin-left: 250px;
        padding: 20px;
        height: calc(100vh - 90px);
        overflow-y: auto;
        background: linear-gradient(to right, #e0f7ff, #ffffff);  /* Warna gradient dari biru muda ke putih */
    }

    h1, h2 {
        color: #007bff;
    }

    .main-container {
        max-width: 2400px;
        margin: auto;
    }

    form {
        background: #f9f9f9;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    label {
        font-weight: bold;
        display: block;
        margin-bottom: 8px;
    }

    select, input[type="number"], textarea, input[type="date"] {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
        box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.1);
        font-size: 16px;
        margin-bottom: 20px;
    }

    textarea {
        height: 100px;
        resize: vertical;
    }

    .rating {
        font-size: 24px;
        color: #ffc107;
    }

    .kartu {
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        margin-bottom: 30px;
        padding: 20px;
        text-align: justify;
    }

    .kartu img {
        width: 100%;
        max-width: 400px;
        height: auto;
        border-radius: 8px;
    }

    .kartu h3 {
        color: #007bff;
    }

    .kartu ul {
        list-style: none;
        padding: 0;
    }

    .kartu li {
        margin-bottom: 20px;
    }

    .kartu .ulasan {
        font-size: 18px;
        color: #333;
    }

    button[type="submit"] {
        background-color: #007bff;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
    }

    button[type="submit"]:hover {
        background-color: #0056b3;
    }

    .feedback-message {
        margin-bottom: 20px;
        font-size: 16px;
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
            <h1>Bagikan Pengalaman Anda</h1>
            
            <?php if ($this->session->flashdata('success')): ?>
                <p class="feedback-message" style="color: green;"><?php echo $this->session->flashdata('success'); ?></p>
            <?php elseif ($this->session->flashdata('error')): ?>
                <p class="feedback-message" style="color: red;"><?php echo $this->session->flashdata('error'); ?></p>
            <?php endif; ?>

            <form action="<?php echo site_url('Ctiket/add_review'); ?>" method="post">
                <label for="id_wisata">Tiket Wisata:</label>
                <select name="id_wisata" id="id_wisata" required>
                    <option value="">PILIH</option>
                    <?php foreach ($tickets as $ticket): ?>
                        <option value="<?php echo $ticket['id_wisata']; ?>"><?php echo $ticket['nama_wisata']; ?></option>
                    <?php endforeach; ?>
                </select>

                <label for="rating">Berikan Penilaian (1-5):</label>
                <input type="number" name="rating" id="rating" min="1" max="5" required>

                <label for="review">Tulis Ulasan Anda:</label>
                <textarea name="review" id="review" placeholder="Bagikan pengalaman Anda dan kesan selama berkunjung..."></textarea>

                <button type="submit">Kirim Ulasan</button>
            </form>

      
            <?php foreach ($tickets as $ticket): ?>
                <div class="kartu">
                    <img src="<?php echo base_url('uploads/' . $ticket['foto']); ?>" alt="Gambar <?php echo $ticket['nama_wisata']; ?>">
                    <h3><?php echo $ticket['nama_wisata']; ?></h3>
                    <p><?php echo $ticket['deskripsi_singkat']; ?></p>
                    <?php
                    $reviews = $this->Mtiket->get_reviews_by_ticket_id($ticket['id_wisata']);
                    if ($reviews): ?>
                        <ul>
                            <?php foreach ($reviews as $review): ?>
                                <li>
                                    <div class="rating">
                                        <?php for ($i = 0; $i < $review['rating']; $i++): ?>
                                            <span>⭐</span>
                                        <?php endfor; ?>
                                        <?php for ($i = $review['rating']; $i < 5; $i++): ?>
                                            <span>☆</span>
                                        <?php endfor; ?>
                                    </div>
                                    <p class="ulasan"><?php echo $review['review']; ?></p>
                                    <p class="tanggal"><?php echo date('d M Y', strtotime($review['created_at'])); ?></p> <!-- Menampilkan tanggal -->
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <p>Tidak ada ulasan untuk tiket ini.</p>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<?php $this->load->view('partials/footer'); ?>
</body>
</html>
