<?php
include 'db.php';

// Define how many results you want per page
$resultsPerPage = 5; 

// Find out the number of results stored in database
$categoryId = 2; // Replace with the actual category ID for Technology
$totalArticlesQuery = "SELECT COUNT(*) AS total FROM articles WHERE category_id = $categoryId";
$totalResults = $conn->query($totalArticlesQuery)->fetch_assoc();
$totalPages = ceil($totalResults['total'] / $resultsPerPage); // Calculate total pages

// Determine which page number visitor is currently on
$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Get current page from URL, default to 1
$currentPage = max(1, min($currentPage, $totalPages)); // Ensure current page is within bounds

// Determine the starting limit for the SQL query
$startFrom = ($currentPage - 1) * $resultsPerPage;

// Retrieve articles for the current page
$articlesQuery = "SELECT * FROM articles WHERE category_id = $categoryId ORDER BY created_at DESC LIMIT $startFrom, $resultsPerPage";
$articles = $conn->query($articlesQuery)->fetch_all(MYSQLI_ASSOC);

// Retrieve trending articles in the current category
$trendingQuery = "SELECT * FROM articles WHERE category_id = $categoryId ORDER BY view_count DESC LIMIT 5";
$trendingArticles = $conn->query($trendingQuery)->fetch_all(MYSQLI_ASSOC);
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Technology Articles</title>
    <link rel="stylesheet" href="assets/css/style-starter.css">
</head>
<body>

<!-- Header -->
<header class="w3l-header">
    <nav class="navbar navbar-expand-lg navbar-light fill px-lg-0 py-0 px-3">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <span class="fa fa-pencil-square-o"></span> Web Programming Blog
            </a>
            <button class="navbar-toggler collapsed" type="button" data-toggle="collapse"
                data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="fa icon-expand fa-bars"></span>
                <span class="fa icon-close fa-times"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="technology.php">Technology Posts</a></li>
                    <li class="nav-item"><a class="nav-link" href="lifestyle.php">Lifestyle Posts</a></li>
                    <li class="nav-item"><a class="nav-link" href="form_admin.php">Admin Dashboard</a></li>
                </ul>
            </div>
        </div>
    </nav>
</header>

<!-- Breadcrumbs -->
<nav id="breadcrumbs" class="breadcrumbs">
    <div class="container page-wrapper">
        <a href="index.php">Home</a> / Categories / <span>Technology</span>
    </div>
</nav>

<!-- Main Content -->
<div class="w3l-searchblock w3l-homeblock1 py-5">
    <div class="container py-lg-4 py-md-3">
        <div class="row">
            <!-- Article List -->
            <div class="col-md-8">
                <h3 class="section-title-left">Lifestyle</h3>
                <div id="articles">
                    <?php foreach ($articles as $article): ?>
                        <div class="article">
                            <?php if (!empty($article['photo_path'])): ?>
                                <img src="uploads/<?= $article['photo_path']; ?>" alt="<?= $article['title']; ?>" style="max-width: 100%; height: auto;">
                            <?php endif; ?>
                            <h3><a href="article.php?id=<?= $article['id']; ?>"><?= $article['title']; ?></a></h3>
                            <p><?= substr($article['content'], 0, 150); ?>...</p>
                            <span>Read count: <?= $article['view_count']; ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Pagination -->
                <div class="pagination">
                    <?php if ($currentPage > 1): ?>
                        <a href="technology.php?page=<?= $currentPage - 1; ?>">&laquo; Previous</a>
                    <?php endif; ?>

                    <?php for ($page = 1; $page <= $totalPages; $page++): ?>
                        <a href="technology.php?page=<?= $page; ?>" <?= ($page === $currentPage) ? 'class="active"' : ''; ?>><?= $page; ?></a>
                    <?php endfor; ?>

                    <?php if ($currentPage < $totalPages): ?>
                        <a href="technology.php?page=<?= $currentPage + 1; ?>">Next &raquo;</a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Trending Articles -->
            <div class="col-md-4">
                <h3>Trending in Lifestyle</h3>
                <div id="trending-articles">
                    <?php foreach ($trendingArticles as $trending): ?>
                        <div class="trending-article">
                            <h4><a href="article.php?id=<?= $trending['id']; ?>"><?= $trending['title']; ?></a></h4>
                            <span>Read count: <?= $trending['view_count']; ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<footer class="w3l-footer-16">
    <div class="footer-content py-lg-5 py-4 text-center">
        <div class="container">
            <h6>© 2020 Design Blog. Made with <span class="fa fa-heart"></span>, Designed by W3layouts</h6>
        </div>
    </div>
</footer>

<!-- Scripts -->
<script src="assets/js/jquery-3.3.1.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
</body>
</html>
