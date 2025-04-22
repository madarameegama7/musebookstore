<?php require APPROOT.'/views/inc/header.php';?>
<!--TOP NAV BAR-->
<?php require APPROOT.'/views/inc/components/topnavbar.php';?>

<style>
body {
    font-family: 'Poppins', sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f5faff;
}

/* Hero section styling */
.hero {
    background-image: url('https://images.pexels.com/photos/6437496/pexels-photo-6437496.jpeg');
    background-position: center;
    background-size: cover;
    height: 400px;
    display: flex;
    justify-content: center;
    align-items: center;
    text-align: center;
    position: relative;
    color: white;
}

.hero::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.4);
}

.hero-content {
    position: relative;
    z-index: 2;
    max-width: 800px;
    padding: 0 20px;
}

.hero h1 {
    font-size: 48px;
    margin: 0;
    margin-bottom: 10px;
}

.hero h2 {
    font-size: 32px;
    margin: 0 0 20px;
}

.hero p {
    font-size: 18px;
    margin-bottom: 30px;
}

/* Button styling */
.cta-button {
    display: inline-block;
    background-color: #4CAF50;
    color: white;
    padding: 10px 25px;
    font-size: 18px;
    font-weight: 500;
    text-decoration: none;
    border-radius: 30px;
    margin: 20px 0;
    transition: all 0.3s ease;
    text-align: center;
}

.cta-button:hover {
    background-color: #388E3C;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

/* Search section */
.search {
    padding: 30px 0;
    text-align: center;
}

.search-container {
    max-width: 600px;
    margin: 0 auto;
}

.book-search-form {
    display: flex;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    border-radius: 30px;
    overflow: hidden;
}

.book-search-form input {
    flex: 1;
    padding: 15px 20px;
    border: none;
    font-size: 16px;
}

.book-search-form button {
    padding: 15px 25px;
    background-color: #4CAF50;
    color: white;
    border: none;
    cursor: pointer;
    font-weight: 500;
}

/* Activities section */
.activities {
    max-width: 1200px;
    margin: 30px auto;
    padding: 0 20px;
}

.activities h2 {
    font-size: 32px;
    margin-bottom: 20px;
    text-align: center;
}

.activities-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.news-item {
    display: flex;
    margin-bottom: 20px;
    background-color: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease;
}

.news-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
}

.news-item img {
    width: 150px;
    height: 150px;
    border-radius: 8px;
    margin-right: 20px;
    object-fit: cover;
}

.news-item .news-content {
    flex: 1;
}

.news-item .news-content h3 {
    margin: 0 0 10px;
    font-size: 24px;
}

.news-item .news-content a {
    color: #336699;
    text-decoration: none;
    font-weight: 500;
}

.news-item .news-content a:hover {
    text-decoration: underline;
}

.news-item .news-content p {
    margin: 0;
    color: #666;
}

/* Books section */
.books-container {
    max-width: 1200px;
    margin: 50px auto;
    padding: 0 20px;
}

.books-container h2 {
    font-size: 32px;
    margin-bottom: 10px;
    text-align: center;
}

.books-container .subtitle {
    text-align: center;
    color: #666;
    margin-bottom: 30px;
}

.books {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    justify-content: flex-start;
}

.book-card {
    width: calc(33.333% - 20px);
    margin-bottom: 20px;
    background: white;
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.book-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
}

.book-card img {
    width: 100%;
    height: 200px;
    object-fit: cover;
}

.book-card-content {
    padding: 15px;
}

.book-card h3 {
    margin: 0 0 10px;
    font-size: 18px;
    color: #333;
}

.book-card p {
    margin: 5px 0;
    color: #666;
    font-size: 14px;
}

.book-controls {
    display: flex;
    justify-content: space-between;
    margin-top: 15px;
}

.book-btn {
    padding: 8px 12px;
    border: none;
    border-radius: 5px;
    font-weight: 500;
    cursor: pointer;
    text-decoration: none;
    text-align: center;
    font-size: 14px;
}

.view-btn {
    background-color: #336699;
    color: white;
}

.request-btn {
    background-color: #4CAF50;
    color: white;
}

.view-btn:hover, .request-btn:hover {
    opacity: 0.9;
}

@media (max-width: 992px) {
    .book-card {
        width: calc(50% - 20px);
    }
}

@media (max-width: 768px) {
    .book-card {
        width: 100%;
    }
    
    .news-item {
        flex-direction: column;
    }
    
    .news-item img {
        width: 100%;
        margin-right: 0;
        margin-bottom: 15px;
    }
}

/* Alert styling */
.alert {
    padding: 15px;
    border-radius: 5px;
    margin-bottom: 20px;
}

.alert-success {
    background-color: #d4edda;
    border-color: #c3e6cb;
    color: #155724;
}

.alert-info {
    background-color: #d1ecf1;
    border-color: #bee5eb;
    color: #0c5460;
}

.alert-warning {
    background-color: #fff3cd;
    border-color: #ffeeba;
    color: #856404;
}

.alert-danger {
    background-color: #f8d7da;
    border-color: #f5c6cb;
    color: #721c24;
}

/* Features section */
.features-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
    margin: 20px 0;
}

.feature-tile {
    background-color: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.feature-tile:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
}

.feature-icon {
    font-size: 48px;
    margin-bottom: 10px;
    text-align: center;
}

.feature-icon i {
    color: #4CAF50;
}

.heart-icon i {
    color: #ff69b4;
}

.article-icon i {
    color: #2196f3;
}

.my-article-icon i {
    color: #ff9800;
}

.request-icon i {
    color: #4CAF50;
}

.feature-link {
    text-decoration: none;
    color: #4CAF50;
    font-weight: 500;
    transition: color 0.3s ease;
}

.feature-link:hover {
    color: #388E3C;
}
</style>
<section class="hero">
    <div class="hero-content">
        <h1>Welcome to Muse Store</h1>
        <h2>Your Child Reading Journey</h2>
        <p>Discover amazing books, request them from your parents, and explore a world of knowledge and adventure.</p>
    </div>
</section>
<?php flash('request_success'); ?>
<?php flash('request_error'); ?>

<section class="activities">
    <h2>Features</h2>
    
    <div class="features-grid">
        <div class="feature-tile">
            <div class="feature-icon">
                <i class="fas fa-book fa-3x"></i>
            </div>
            <h3>Browse All Books</h3>
            <p>Explore our collection of books available for request</p>
            <a href="<?=URLROOT?>/pages/index" class="feature-link">Browse Books</a>
        </div>
        
        <div class="feature-tile">
            <div class="feature-icon heart-icon">
                <i class="fas fa-heart fa-3x"></i>
            </div>
            <h3>My Favorites</h3>
            <p>View and manage your favorite books</p>
            <a href="<?=URLROOT?>/child/favorites" class="feature-link">View Favorites</a>
        </div>
        
        <div class="feature-tile">
            <div class="feature-icon article-icon">
                <i class="fas fa-newspaper fa-3x"></i>
            </div>
            <h3>Articles</h3>
            <p>Read interesting articles written by other children</p>
            <a href="<?=URLROOT?>/child/articles" class="feature-link">Read Articles</a>
        </div>
        
        <div class="feature-tile">
            <div class="feature-icon my-article-icon">
                <i class="fas fa-pencil-alt fa-3x"></i>
            </div>
            <h3>My Articles</h3>
            <p>Write and manage your own articles</p>
            <a href="<?=URLROOT?>/child/myArticles" class="feature-link">My Articles</a>
        </div>
        
        <div class="feature-tile">
            <div class="feature-icon request-icon">
                <i class="fas fa-bookmark fa-3x"></i>
            </div>
            <h3>My Requests</h3>
            <p>Track the status of your book requests</p>
            <a href="<?=URLROOT?>/child/myRequests" class="feature-link">View Requests</a>
        </div>
    </div>
    

<section id="books" class="books-container">
    <h2>Available Books</h2>
    <p class="subtitle">Browse books and request them from your parent</p>
    
    <?php if(empty($data['books'])) : ?>
      <div class="alert alert-info">No books available at the moment. Please check back later.</div>
    <?php else : ?>
      <div class="books">
        <?php foreach($data['books'] as $book) : ?>
          <div class="book-card">
            <!-- Use a placeholder image if no specific book image is available -->
            <img src="<?= URLROOT ?>/public/img/index-page.jpg" alt="<?= $book->book_title ?>">
            <div class="book-card-content">
              <h3><?= $book->book_title ?></h3>
              <p><strong>By:</strong> <?= $book->book_author ?></p>
              <p><strong>Genre:</strong> <?= $book->book_genre ?></p>
              <p><strong>Condition:</strong> <?= $book->book_condition ?></p>
              <p><strong>Price:</strong> <?= number_format($book->book_price, 2) ?> LKR</p>
              <div class="book-controls">
                <a href="<?= URLROOT ?>/child/viewBook/<?= $book->book_id ?>" class="book-btn view-btn">View Details</a>
                <a href="<?= URLROOT ?>/child/requestBook/<?= $book->book_id ?>" class="book-btn request-btn">Request Book</a>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
</section>
<?php
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'child') {
    die("Access denied! You do not have permission to view this page.");
}
?>

<?php require APPROOT.'/views/inc/footer.php';?>