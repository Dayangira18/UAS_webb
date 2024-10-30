<?php

$dsn = "mysql:host=localhost;dbname=uas_webb;charset=utf8mb4";
$username = "root";
$password = "";

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Handle form submission for creating/updating categories
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];

    if (isset($_POST['action']) && $_POST['action'] === 'create') {
        // Create category
        $stmt = $pdo->prepare("INSERT INTO categories (name) VALUES (?)");
        $stmt->execute([$name]);
    } elseif (isset($_POST['action']) && $_POST['action'] === 'update') {
        $id = $_POST['id']; // Get the ID for updating
        // Update category
        $stmt = $pdo->prepare("UPDATE categories SET name = ? WHERE id = ?");
        $stmt->execute([$name, $id]);
    } elseif (isset($_POST['action']) && $_POST['action'] === 'delete') {
        $id = $_POST['id']; // Get the ID for deleting
        // Delete category
        $stmt = $pdo->prepare("DELETE FROM categories WHERE id = ?");
        $stmt->execute([$id]);
    }
}

// Fetch categories to display
$stmt = $pdo->query("SELECT * FROM categories");
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Category Management</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f3f4f6; /* Light gray background for contrast */
        }
        .container {
            background-color: #6f42c1; /* Purple background for the container */
            border-radius: 10px;
            padding: 20px;
            color: white; /* White text for better contrast */
        }
        h2, h3 {
            color: #d8bfd8; /* Light purple color for headings */
        }
        .btn-success {
            background-color: #5cb85c; /* Green for create button */
            border-color: #4cae4c;
        }
        .btn-primary {
            background-color: #007bff; /* Blue for update button */
            border-color: #007bff;
        }
        .btn-danger {
            background-color: #dc3545; /* Red for delete button */
            border-color: #dc3545;
        }
        .btn-secondary {
            background-color: #6c757d; /* Gray for back button */
            border-color: #6c757d;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <h2>Category Management</h2>

    <!-- Create Category Form -->
    <h3>Create Category</h3>
    <form method="POST">
        <div class="mb-3">
            <label for="name" class="form-label">Category Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <button type="submit" class="btn btn-success" name="action" value="create">Create Category</button>
    </form>

    <hr>

    <!-- View Categories Section -->
    <h3>View Categories</h3>
    <table class="table table-bordered table-light">
        <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($categories as $category): ?>
            <tr>
                <td><?= $category['id'] ?></td>
                <td><?= $category['name'] ?></td>
                <td>
                    <!-- Update Button -->
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#updateModal<?= $category['id'] ?>">Edit</button>
                    <!-- Delete Button -->
                    <form method="POST" class="d-inline">
                        <input type="hidden" name="id" value="<?= $category['id'] ?>">
                        <button type="submit" class="btn btn-danger btn-sm" name="action" value="delete">Delete</button>
                    </form>
                </td>
            </tr>

            <!-- Update Category Modal -->
            <div class="modal fade" id="updateModal<?= $category['id'] ?>" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="updateModalLabel">Update Category</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form method="POST">
                                <input type="hidden" name="id" value="<?= $category['id'] ?>">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Category Name</label>
                                    <input type="text" class="form-control" name="name" value="<?= $category['name'] ?>" required>
                                </div>
                                <button type="submit" class="btn btn-primary" name="action" value="update">Update Category</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Back Button -->
    <div class="mt-4">
        <a href="form_admin.php" class="btn btn-secondary">Back to Admin Dashboard</a>
    </div>
</div>

<!-- Optional JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
