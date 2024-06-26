<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $message = $_POST['message'];
    $imagePath = '';

    // ファイルがアップロードされた場合の処理
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $targetDir = 'uploads/';
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $targetFile = $targetDir . basename($_FILES['image']['name']);
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // ファイル形式のチェック（例: jpg, png, gif）
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
        if (in_array($imageFileType, $allowedTypes)) {
            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                $imagePath = $targetFile;
            } else {
                echo 'Error: Failed to upload file.';
                exit;
            }
        } else {
            echo 'Error: Only JPG, JPEG, PNG & GIF files are allowed.';
            exit;
        }
    }

    // データベースに投稿を保存
    $stmt = $pdo->prepare('INSERT INTO posts (username, message, image_path) VALUES (?, ?, ?)');
    $stmt->execute([$username, $message, $imagePath]);

    // リダイレクトして投稿が反映されるようにする
    header('Location: index.php');
    exit;
}
?>
