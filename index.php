<?php
require "libs/all.php";

$animes_data = $connector->query("SELECT * FROM animes");
$news_data = $connector->query("
    SELECT 
        news.id, 
        news.title, 
        news.image, 
        news.content, 
        users.nama AS created_by, 
        DATE_FORMAT(news.created_at, '%M %d, %Y %H:%i') AS created_at

    FROM 
        news 
    JOIN 
        users ON news.created_by = users.id
");


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cretoo | Nonton Anime Dimana Saja</title>
    <link rel="stylesheet" href="static/assets/css/app.css?v=<?= time() ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <nav>
        <h3>Cretoo</h3>
        <ul class="nav-list">
            <li><a href="/">Genre</a></li>
            <li><a href="/popular">Popular</a></li>
            <li><a href="/events">Events</a></li>
            <li><a href="/shows">Shows</a></li>
            <li><a href="/character">Character</a></li>
        </ul>
        <div class="nav-right">
            <form action="/search.html" method="get" class="search-form">
                <input type="text" name="q" id="q" class="search-input" placeholder="Search...">
            </form>
            <button class="join-btn">Join Now</button>
        </div>
    </nav>
    <div class="hero">
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <p>SEASON 1 | 2019</p>
            <h1>Demon Slayer: Kimetsu no Yaiba</h1>
            <div class="rating">
                <span>⭐️⭐️⭐️⭐️⭐️</span>
            </div>
            <div class="tags">
                <span>Drama</span>
                <span>Thriller</span>
                <span>Action</span>
            </div>
            <p class="description">A youth begins a quest to fight demons and save his sister after finding his family
                slaughtered and his sister turned into a demon.</p>
            <button class="watch-btn">Watch Now</button>
            <button class="save-btn">Save for later</button>
        </div>
    </div>

    <div class="recent-anime">
        <div class="recent-anime-container">
            <div class="recent-anime-header">
                <h2>Trending Anime</h2>
                <a href="#">See all</a>
            </div>
            <div class="anime-list">
                <?php while ($anime = $animes_data->fetch_assoc()) { ?>
                    <div class="anime-item">
                        <img src="uploads/<?= $anime['banner'] ?>" alt="<?= $anime['title'] ?>">
                        <p><?= $anime['title'] ?></p>
                    </div>
                <?php } ?>
            </div>
        </div>
        <!-- <div class="recent-anime-container">
            <div class="recent-anime-header">
                <h2>On-Going Anime</h2>
                <a href="#">See all</a>
            </div>
            <div class="anime-list">
                <div class="anime-item">
                    <img src="/assets/image/animes/isekai-shikkaku.jpg" alt="Yofukashi no Uta">
                    <p>Isekai Shikkaku</p>
                </div>
                <div class="anime-item">
                    <img src="/assets/image/animes/kami-no-tou-tower-of-god-ouji-no-kikan.jpg"
                        alt="Bleach: Thousand-Year Blood War">
                    <p>Kami no Tou: Tower of God - Ouji no Kikan</p>
                </div>
                <div class="anime-item">
                    <img src="/assets/image/animes/one-piece.jpg" alt="Attack on Titan">
                    <p>ONE PIECE</p>
                </div>
                <div class="anime-item">
                    <img src="/assets/image/animes/tsue-to-tsurugi-no-wistoria.jpg" alt="The Seven Deadly Sins">
                    <p>Tsue to Tsurugi no Wistoria</p>
                </div>
                <div class="anime-item">
                    <img src="/assets/image/animes/shikanoko-nokonoko-koshitantan.jpg" alt="Death Note">
                    <p>Shikanoko Nokonoko Koshitantan</p>
                </div>
                <div class="anime-item">
                    <img src="/assets/image/animes/shikanoko-nokonoko-koshitantan.jpg" alt="Death Note">
                    <p>Shikanoko Nokonoko Koshitantan</p>
                </div>
                <div class="anime-item">
                    <img src="/assets/image/animes/shikanoko-nokonoko-koshitantan.jpg" alt="Death Note">
                    <p>Shikanoko Nokonoko Koshitantan</p>
                </div>
                <div class="anime-item">
                    <img src="/assets/image/animes/shikanoko-nokonoko-koshitantan.jpg" alt="Death Note">
                    <p>Shikanoko Nokonoko Koshitantan</p>
                </div>
                <div class="anime-item">
                    <img src="/assets/image/animes/shikanoko-nokonoko-koshitantan.jpg" alt="Death Note">
                    <p>Shikanoko Nokonoko Koshitantan</p>
                </div>
                <div class="anime-item">
                    <img src="/assets/image/animes/shikanoko-nokonoko-koshitantan.jpg" alt="Death Note">
                    <p>Shikanoko Nokonoko Koshitantan</p>
                </div>
            </div>
        </div> -->
    </div>
    <div class="anime-news-container">
        <h2>Berita Terbaru</h2>
        <div class="anime-news-list">
            <?php while ($berita = $news_data->fetch_assoc()) {  ?>
                <div class="anime-news-card">
                    <img src="uploads/<?= $berita['image'] ?>"
                        alt="<?= $berita['title'] ?>">
                    <div class="anime-news-content">
                        <div class="anime-news-title"><?= $berita['title'] ?></div>
                        <div class="anime-news-meta">BY <?= $berita['created_by'] ?>, <?= $berita['created_at'] ?></div>
                        <div class="anime-news-description">
                            <?= substr(strip_tags(html_entity_decode($berita['content'])), 0, 100) ?> ...
                        </div>
                    </div>
                </div>

            <?php } ?>
        </div>
    </div>

    <footer>
        <div class="footer-container">
            <div class="footer-item">
                <h3>Cretoo Indonesia</h3>
                <p>
                    Cretoo Indonesia adalah sebuah media yang membahas berita-berita yang berkaitan dengan Jepang, baik
                    itu culture
                    maupun pop-culture, mulai dari yang unik, aneh hingga yang luar biasa penting.
                </p>
            </div>
            <div class="footer-item">
                <h3>Ikuti Saya</h3>

                <div class="social-media-list">
                    <div class="social-media-item">
                        <i class="fab fa-facebook"></i>
                    </div>
                    <div class="social-media-item">
                        <i class="fab fa-whatsapp"></i>
                    </div>
                    <div class="social-media-item">
                        <i class="fab fa-medium"></i>
                    </div>
                    <div class="social-media-item">
                        <i class="fab fa-twitter"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-copyright">
            <p>Copyright &copy; 2024 Billal Fauzan. All Right Reversed.</p>
        </div>
    </footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/js/all.min.js"
        integrity="sha512-6sSYJqDreZRZGkJ3b+YfdhB3MzmuP9R7X1QZ6g5aIXhRvR1Y/N/P47jmnkENm7YL3oqsmI6AK+V6AD99uWDnIw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</body>

</html>