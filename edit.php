<?php
$filename = "posts.txt";

if (isset($_GET['index']) && file_exists($filename)) {
    $index = (int)$_GET['index'];
    $posts = unserialize(file_get_contents($filename));

    // Periksa apakah index valid
    if (isset($posts[$index])) {
        $post = $posts[$index];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Ambil data baru dari form
            $title = $_POST['title'];
            $content = $_POST['content'];
            $editTime = date("Y-m-d H:i:s");

            // Proses gambar jika di-upload ulang
            $imagePath = $post['image']; // Gunakan gambar lama sebagai default
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = "uploads/";
                $imageName = basename($_FILES['image']['name']);
                $targetFilePath = $uploadDir . $imageName;

                if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFilePath)) {
                    $imagePath = $targetFilePath;
                }
            }

            // Buat data postingan baru
            $updatedPost = [
                'title' => $title,
                'content' => $content,
                'time' => $post['time'], // Tetap gunakan waktu asli pembuatan
                'edit_time' => $editTime, // Waktu saat ini sebagai waktu edit
                'image' => $imagePath
            ];

            // Hapus postingan lama dari array
            unset($posts[$index]);

            // Tambahkan postingan yang diperbarui ke awal array
            array_unshift($posts, $updatedPost);

            // Simpan kembali data ke file
            file_put_contents($filename, serialize($posts));
            
            // Redirect kembali ke halaman utama
            header("Location: index.php");
            exit;
        }
    } else {
        echo "Postingan tidak ditemukan.";
        exit;
    }
} else {
    echo "Postingan tidak ditemukan.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Postingan</title>
    <link rel="stylesheet" href="forcat.css">
</head>
<body>
    <h1>Edit Postingan</h1>
    <form method="post" enctype="multipart/form-data">
        <label>Judul:</label>
        <input type="text" name="title" value="<?php echo htmlspecialchars($post['title']); ?>" required>

        <label>Konten:</label>
        <textarea name="content" required><?php echo htmlspecialchars($post['content']); ?></textarea>

        <label>Gambar (opsional):</label>
        <input type="file" name="image">
        <?php if (!empty($post['image'])): ?>
            <img src="<?php echo htmlspecialchars($post['image']); ?>" alt="Gambar Postingan" style="max-width: 100px; margin-top: 10px;">
        <?php endif; ?>

        <button type="submit">Simpan Perubahan</button>
    </form>
</body>
</html>
