<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Photo Gallery</title>
</head>
<body>
    <h1>Upload Foto</h1>

    <!-- Form Upload Foto -->
   <form action="<?= base_url('photo/upload') ?>" method="POST" enctype="multipart/form-data">

        <label for="description">Deskripsi:</label>
        <textarea name="description" id="description"></textarea><br><br>

        <label for="photo">Pilih Foto (PNG, JPG, JPEG):</label>
        <!-- Tambahkan accept=".png,.jpg,.jpeg" agar hanya file gambar yang bisa dipilih -->
        <input type="file" name="photo" id="photo" accept=".png, .jpg, .jpeg" required><br><br>

        <button type="submit">Upload Foto</button>
    </form>

    <?php if (isset($error)): ?>
        <p><?= $error; ?></p>
    <?php endif; ?>

    <!-- Menampilkan Foto dan Komentar -->
    <?php if (!empty($photos)): ?>
        <?php foreach ($photos as $photo): ?>
            <div class="photo">
                <img src="<?= base_url($photo->file_path); ?>" alt="Foto" width="200"><br>
                <p><?= $photo->description; ?></p>
                
                <!-- Komentar -->
                <h3>Komentar:</h3>
                <?php if ($photo->comment): ?>
                    <p><?= $photo->username; ?>: <?= $photo->comment; ?></p>
                <?php else: ?>
                    <p>Belum ada komentar.</p>
                <?php endif; ?>

                <!-- Form Komentar -->
                <form action="<?= base_url('photo/comment') ?>" method="POST">
                    <input type="hidden" name="photo_id" value="<?= $photo->id; ?>">
                    <textarea name="comment" placeholder="Tulis komentar..." required></textarea><br>
                    <button type="submit">Kirim Komentar</button>
                </form>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Tidak ada foto yang diunggah.</p>
    <?php endif; ?>
</body>
</html>
