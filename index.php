<?php
include 'db.php';
$stmt = $pdo->query('SELECT * FROM posts ORDER BY created_at DESC');
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>掲示板</title>
</head>
<body>
    <h1>まんこく掲示板</h1>
    <a href="rule.php">掲示板ルール</a>
    <form action="post.php" method="post" enctype="multipart/form-data">
        <input type="text" name="username" placeholder="ユーザー名" required>
        <textarea name="message" placeholder="メッセージ" required></textarea>
        <input type="file" name="image" accept="image/*">
        <button type="submit">投稿</button>
    </form>
    <h2>メッセージ一覧</h2>
    <?php foreach ($posts as $post): ?>
        <div>
            <h3><?php echo htmlspecialchars($post['username']); ?> (<?php echo $post['created_at']; ?>)</h3>
            <p><?php echo nl2br(htmlspecialchars($post['message'])); ?></p>
            <?php if (!empty($post['image_path'])): ?>
                <img src="<?php echo htmlspecialchars($post['image_path']); ?>" alt="Image" style="max-width: 300px;">
            <?php endif; ?>
        </div>
        <hr>
    <?php endforeach; ?>
</body>
</html>
