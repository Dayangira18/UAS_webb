<?php
include 'db.php'; // menyertakan file koneksi database

// Mengatur pagination
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 5; // batas artikel per halaman
$offset = ($page - 1) * $limit;

// Mengambil artikel terbaru termasuk foto
$recentArticlesQuery = "SELECT * FROM articles ORDER BY created_at DESC LIMIT $limit OFFSET $offset";
$recentArticles = $conn->query($recentArticlesQuery)->fetch_all(MYSQLI_ASSOC);

// Menghitung total artikel untuk pagination
$totalArticlesQuery = "SELECT COUNT(*) FROM articles";
$totalArticles = $conn->query($totalArticlesQuery)->fetch_row()[0];
$totalPages = ceil($totalArticles / $limit);

// Mengambil trending articles
$trendingArticlesQuery = "SELECT * FROM articles ORDER BY view_count DESC LIMIT 5";
$trendingArticles = $conn->query($trendingArticlesQuery)->fetch_all(MYSQLI_ASSOC);
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Web Programming - Final Semester Exam</title>

    <link href="https://fonts.googleapis.com/css2?family=Cabin:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="//fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800&display=swap" rel="stylesheet">

    <!-- Template CSS -->
    <link rel="stylesheet" href="assets/css/style-starter.css">
</head>

<body>
    <!-- header -->
    <header class="w3l-header">
        <!--/nav-->
        <nav class="navbar navbar-expand-lg navbar-light fill px-lg-0 py-0 px-3">
            <div class="container">
                <a class="navbar-brand" href="index.php">
                    <span class="fa fa-pencil-square-o"></span> Web Programming Blog</a>
                <button class="navbar-toggler collapsed" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="fa icon-expand fa-bars"></span>
                    <span class="fa icon-close fa-times"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item active">
                            <a class="nav-link" href="index.php">Home</a>
                        </li>
                        <li class="nav-item active">
                            <a class="nav-link" href="technology.php">Technology posts</a>
                        </li>
                        <li class="nav-item active">
                            <a class="nav-link" href="lifestyle.php">Lifestyle posts</a>
                        </li>
                        
                        <li class="nav-item @@contact__active">
                            <a class="nav-link" href="form_admin.php">Admin Dashboard</a>
                        </li>
                    </ul>

                    <div class="search-right mt-lg-0 mt-2">
                        <a href="#search" title="search"><span class="fa fa-search" aria-hidden="true"></span></a>
                        <div id="search" class="pop-overlay">
                            <div class="popup">
                                <h3 class="hny-title two">Search here</h3>
                                <form action="#" method="Get" class="search-box">
                                    <input type="search" placeholder="Search for blog posts" name="search"
                                        required="required" autofocus="">
                                    <button type="submit" class="btn">Search</button>
                                </form>
                                <a class="close" href="#close">×</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
        <!--//nav-->
    </header>
    <!-- //header -->

    <div class="w3l-homeblock1">
        <div class="container pt-lg-5 pt-md-4">
            <div class="container mt-4">
                <div class="row">
                    <!-- Main content area for Recent Posts -->
                    <div class="col-lg-8">
                        <h2>Most Recent Posts</h2>
                        <div id="recent-posts">
                            <!-- Loop through your articles and display the latest 5 -->
                            <?php foreach ($recentArticles as $article): ?>
                                <div class="post">
                                    <?php if (!empty($article['photo_path'])): ?>
                                        <img src="uploads/<?= $article['photo_path']; ?>" alt="<?= $article['title']; ?>" style="max-width: 100%; height: auto;">
                                    <?php endif; ?>
                                    <h3><a href="article.php?id=<?= $article['id']; ?>"><?= $article['title']; ?></a></h3>
                                    <p><?= substr($article['content'], 0, 150); ?>...</p>
                                    <span>
                                        <a href="article.php?id=<?= $article['id']; ?>" style="text-decoration: none; color: inherit;">
                                            Read count: <?= $article['view_count']; ?>
                                        </a>
                                    </span>
                                </div>
                            <?php endforeach; ?><!-- Loop through your articles and display the latest 5 -->
                                <?php foreach ($recentArticles as $article): ?>
                                    <div class="post">
                                        <?php if (!empty($article['photo_path'])): ?>
                                            <img src="uploads/<?= $article['photo_path']; ?>" alt="<?= $article['title']; ?>" style="max-width: 100%; height: auto;">
                                        <?php endif; ?>
                                        <h3><a href="article.php?id=<?= $article['id']; ?>&action=view"><?= $article['title']; ?></a></h3>
                                        <p><?= substr($article['content'], 0, 150); ?>...</p>
                                        <span>
                                            <a href="article.php?id=<?= $article['id']; ?>&action=view" style="text-decoration: none; color: inherit;">
                                                Read count: <?= $article['view_count']; ?>
                                            </a>
                                        </span>
                                    </div>
                                <?php endforeach; ?>

                        </div>
                        <nav aria-label="Page navigation">
                            <ul class="pagination">
                                <!-- Pagination links -->
                                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                    <li class="page-item"><a class="page-link" href="index.php?page=<?= $i; ?>"><?= $i; ?></a></li>
                                <?php endfor; ?>
                            </ul>
                        </nav>
                    </div>

                    <div class="col-lg-4">
                        <h2>Trending Articles</h2>
                        <div id="trending-posts">
                            <?php foreach ($trendingArticles as $article): ?>
                                <div class="post">
                                    <?php if (!empty($article['photo_path'])): ?>
                                        <img src="<?= $article['photo_path']; ?>" alt="<?= $article['title']; ?>" style="max-width: 100%; height: auto;">
                                    <?php endif; ?>
                                    <h3><a href="article.php?id=<?= $article['id']; ?>"><?= $article['title']; ?></a></h3>
                                    <span>Read count: <?= $article['view_count']; ?></span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- footer -->
    <footer class="w3l-footer-16">
        <div class="footer-content py-lg-5 py-4 text-center">
            <div class="container">
                <div class="copy-right">
                    <h6>© 2024 Web Programming Blog . Made by <i>(Farah)</i> with <span class="fa fa-heart" aria-hidden="true"></span><br>Designed by
                        <a href="https://w3layouts.com">W3layouts</a> </h6>
                </div>
                <ul class="author-icons mt-4">
                    <li><a class="facebook" href="#url"><span class="fa fa-facebook" aria-hidden="true"></span></a></li>
                    <li><a class="twitter" href="#url"><span class="fa fa-twitter" aria-hidden="true"></span></a></li>
                    <li><a class="google" href="#url"><span class="fa fa-google-plus" aria-hidden="true"></span></a></li>
                    <li><a class="linkedin" href="#url"><span class="fa fa-linkedin" aria-hidden="true"></span></a></li>
                    <li><a class="github" href="#url"><span class="fa fa-github" aria-hidden="true"></span></a></li>
                    <li><a class="dribbble" href="#url"><span class="fa fa-dribbble" aria-hidden="true"></span></a></li>
                </ul>
                <button onclick="topFunction()" id="movetop" title="Go to top">
                    <span class="fa fa-angle-up"></span>
                </button>
            </div>
        </div>
        <script>
            window.onscroll = function () {
                scrollFunction()
            };

            function scrollFunction() {
                if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
                    document.getElementById("movetop").style.display = "block";
                } else {
                    document.getElementById("movetop").style.display = "none";
                }
            }

            function topFunction() {
                document.body.scrollTop = 0;
                document.documentElement.scrollTop = 0;
            }
        </script>
        <!-- Bootstrap JS -->
        <script src="assets/js/bootstrap.min.js"></script>
    </footer>
</body>
</html>
