<?php
$filename = "posts.txt"; // Nama file penyimpanan
$uploadDir = "uploads/"; // Folder penyimpanan gambar

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $title = $_POST['title'];
    $content = $_POST['content'];
    $time = date("Y-m-d H:i:s");

    // Proses gambar jika ada
    $imagePath = "";
    if (isset($_FILES['image'])) {
        $imageName = basename($_FILES['image']['name']);
        $targetFilePath = $uploadDir . $imageName;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFilePath)) {
            $imagePath = $targetFilePath; // Gambar disimpan di folder uploads
        }
    }

    // Ambil data postingan yang sudah ada (jika ada)
    $posts = file_exists($filename) ? unserialize(file_get_contents($filename)) : [];

    // Simpan postingan baru
    $newPost = [
        'title' => $title,
        'content' => $content,
        'time' => $time,
        'image' => $imagePath
    ];

    // Tambahkan postingan baru ke array
    array_unshift($posts, $newPost); // Menambahkan ke depan array

    // Simpan data yang sudah diperbarui ke dalam file
    file_put_contents($filename, serialize($posts)); // Serialize untuk menyimpan dalam file

    // Redirect ke halaman utama setelah berhasil menyimpan
    header("Location: index.php"); // Gantilah 'index.php' dengan halaman yang sesuai jika diperlukan
    exit; // Pastikan tidak ada kode lain yang dieksekusi setelah header
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Postingan Baru</title>
    <link rel="stylesheet" href="forcat.css">
</head>
<body>
    <div class="container">
        <h1>Buat Postingan Baru</h1>
        <form action="create.php" method="POST" enctype="multipart/form-data">
            <label>Judul: </label><input type="text" name="title" required><br>
            <label>Konten: </label><textarea name="content" required></textarea><br>
            <label>Gambar: </label><input type="file" name="image"><br>
            <button type="submit">Simpan Postingan</button>
        </form>
    </div>
</body>
</html>
