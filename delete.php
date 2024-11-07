<?php
$filename = "posts.txt";

if (isset($_GET['index'])) {
    $index = (int)$_GET['index'];
    $posts = file_exists($filename) ? unserialize(file_get_contents($filename)) : [];

    if (isset($posts[$index])) {
        unset($posts[$index]);
        $posts = array_values($posts); // Re-indexing the array
        file_put_contents($filename, serialize($posts));
    }
}

header("Location: index.php");
exit;
?>
