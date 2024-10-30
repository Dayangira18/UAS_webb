<?php
include 'db.php'; // Include database connection file

// Check if an action is set (view or edit)
$action = isset($_GET['action']) ? $_GET['action'] : 'view';
$articleId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Initialize article variables
$article = null;

// Handle viewing an article and increment the view count
if ($action === 'view' && $articleId > 0) {
    // Increment the view count
    $conn->query("UPDATE articles SET view_count = view_count + 1 WHERE id = $articleId");

    // Fetch the article details
    $articleQuery = "SELECT * FROM articles WHERE id = $articleId";
    $article = $conn->query($articleQuery)->fetch_assoc();
}

// Handle editing an article
if ($action === 'edit' && $articleId > 0) {
    $articleQuery = "SELECT * FROM articles WHERE id = $articleId";
    $article = $conn->query($articleQuery)->fetch_assoc();
    
    // Handle form submission for updating the article
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $title = $conn->real_escape_string($_POST['title']);
        $content = $conn->real_escape_string($_POST['content']);
        $photoPath = $conn->real_escape_string($_POST['photo_path']); // Handle file upload for the photo

        $updateQuery = "UPDATE articles SET title = '$title', content = '$content', photo_path = '$photoPath' WHERE id = $articleId";
        if ($conn->query($updateQuery)) {
            header("Location: article.php?id=$articleId&action=view");
            exit();
        } else {
            echo "Error updating article: " . $conn->error;
        }
    }
}

// Handle creating a new article
if ($action === 'create') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $title = $conn->real_escape_string($_POST['title']);
        $content = $conn->real_escape_string($_POST['content']);
        $photoPath = $conn->real_escape_string($_POST['photo_path']); // Handle file upload for the photo

        $insertQuery = "INSERT INTO articles (title, content, photo_path) VALUES ('$title', '$content', '$photoPath')";
        if ($conn->query($insertQuery)) {
            header("Location: index.php");
            exit();
        } else {
            echo "Error creating article: " . $conn->error;
        }
    }
}

// Handle deleting an article
if ($action === 'delete' && $articleId > 0) {
    $deleteQuery = "DELETE FROM articles WHERE id = $articleId";
    if ($conn->query($deleteQuery)) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error deleting article: " . $conn->error;
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Article Management</title>
    <link rel="stylesheet" href="assets/css/style-starter.css">
</head>
<body>
    <div class="container">
        <?php if ($action === 'view' && $article): ?>
            <h1><?= htmlspecialchars($article['title']); ?></h1>
            <?php if (!empty($article['photo_path'])): ?>
                <img src="uploads/<?= htmlspecialchars($article['photo_path']); ?>" alt="<?= htmlspecialchars($article['title']); ?>" style="max-width: 100%; height: auto;">
            <?php endif; ?>
            <p><?= nl2br(htmlspecialchars($article['content'])); ?></p>
            <span>Read count: <?= $article['view_count']; ?></span>
            <a href="article.php?id=<?= $articleId; ?>&action=edit">Edit Article</a>
            <a href="article.php?id=<?= $articleId; ?>&action=delete" onclick="return confirm('Are you sure you want to delete this article?');">Delete Article</a>
            <a href="index.php">Back to Articles</a>
        <?php elseif ($action === 'edit' && $article): ?>
            <h1>Edit Article</h1>
            <form method="POST" action="">
                <div>
                    <label for="title">Title</label>
                    <input type="text" name="title" id="title" value="<?= htmlspecialchars($article['title']); ?>" required>
                </div>
                <div>
                    <label for="content">Content</label>
                    <textarea name="content" id="content" required><?= htmlspecialchars($article['content']); ?></textarea>
                </div>
                <div>
                    <label for="photo_path">Photo Path</label>
                    <input type="text" name="photo_path" id="photo_path" value="<?= htmlspecialchars($article['photo_path']); ?>">
                </div>
                <button type="submit">Update Article</button>
            </form>
            <a href="index.php">Cancel</a>
        <?php elseif ($action === 'create'): ?>
            <h1>Create New Article</h1>
            <form method="POST" action="">
                <div>
                    <label for="title">Title</label>
                    <input type="text" name="title" id="title" required>
                </div>
                <div>
                    <label for="content">Content</label>
                    <textarea name="content" id="content" required></textarea>
                </div>
                <div>
                    <label for="photo_path">Photo Path</label>
                    <input type="text" name="photo_path" id="photo_path">
                </div>
                <button type="submit">Create Article</button>
            </form>
            <a href="index.php">Cancel</a>
        <?php else: ?>
            <h1>No article found</h1>
            <a href="index.php">Back to Articles</a>
        <?php endif; ?>
    </div>
</body>
</html>
