<?php
$filename = "posts.txt";

function getPosts($filename)
{
    $posts = [];
    if (file_exists($filename)) {
        $fileContent = file_get_contents($filename);
        if ($fileContent) {
            $posts = unserialize($fileContent);
        }
    }
    return $posts;
}

$posts = getPosts($filename);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Forum Diskusi</title>
    <link rel="stylesheet" href="forcat.css">
</head>

<body>
    <h1>Forum Diskusi</h1>
    <a href="create.php">Tambah Postingan Baru</a>
    <ul>
        <?php foreach ($posts as $index => $post): ?>
            <li>
                <?php if (!empty($post['image'])): ?>
                    <img src="<?php echo htmlspecialchars($post['image']); ?>" alt="Gambar Postingan" style="max-width: 120px; margin-right: 15px;">
                <?php endif; ?>
                <div class="content">
                    <h2><?php echo htmlspecialchars($post['title']); ?></h2>
                    <p><?php echo htmlspecialchars($post['content']); ?></p>
                    <p>
                        <small>Posted on: <?php echo htmlspecialchars($post['time']); ?>
                            <?php if (!empty($post['edit_time'])): ?>
                                | Last edited on: <?php echo htmlspecialchars($post['edit_time']); ?>
                            <?php endif; ?>
                        </small>
                    </p>

                    <a href="edit.php?index=<?php echo $index; ?>">Edit</a> |
                    <a href="delete.php?index=<?php echo $index; ?>" onclick="return confirm('Apakah Anda yakin akan menghapus data ini?')">Hapus</a>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>


</body>

</html>