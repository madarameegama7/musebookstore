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
</style>
<section class="hero">
    <div class="hero-content">
        <h1>Welcome to Muse Store</h1>
        <h2>Your Child Reading Journey</h2>
        <p>Discover amazing books, request them from your parents, and explore a world of knowledge and adventure.</p>
    </div>
</section>

<div class="text-center" style="margin: 20px auto; width: 80%; max-width: 600px;">
    <a href="#books" class="cta-button">Browse Available Books</a>
</div>
<section class="search">
    <div class="search-container">
        <form action="<?php echo URLROOT; ?>/child/searchBooks" method="get" class="book-search-form">
            <input type="text" name="q" placeholder="Search for books..." 
                value="<?php echo isset($_GET['q']) ? htmlspecialchars($_GET['q']) : ''; ?>" />
            <button class="search-button">Search</button>
        </form>
    </div>
</section>

<?php flash('request_success'); ?>
<?php flash('request_error'); ?>

<section class="activities">
    <h2>Explore Activities</h2>
    
    <div class="activities-header">
        <h3>Fun Reading Activities</h3>
        <a href="<?=URLROOT?>/child/myRequests" class="cta-button">
            <i class="fas fa-book-reader"></i> My Book Requests
        </a>
    </div>
   
   <div class="news-item">
    <img alt="A colorful book cover with a magical theme" height="150" src="https://storage.googleapis.com/a1aa/image/qf70Mlj8NsymPC19VFcgONBKVBcHGnp6WbdCaHWhRN0pe60TA.jpg" width="150"/>
    <div class="news-content">
     <h3>
     <a href="<?=URLROOT?>/Child/bookRelease">New Book Release: The Magic Forest</a>
     </h3>
     <p>
      Discover the enchanting world of The Magic Forest, a new book by acclaimed author Jane Doe.
     </p>
    </div>
   </div>
   <div class="news-item">
    <img alt="creativity" height="150" src="https://images.pexels.com/photos/288100/pexels-photo-288100.jpeg" width="150"/>
    <div class="news-content">
     <h3>
     Test creativity
     </h3>
     <p>
      Creative life
     </p>
    </div>
   </div>
   <div class="news-item">
    <img alt="A child reading a book under a tree" height="150" src="https://images.pexels.com/photos/4609046/pexels-photo-4609046.jpeg" width="150"/>
    <div class="news-content">
     <h3>
     <!-- <a href="<= route('childAward') ?>">Creative kids of the week</a> -->
     </h3>
     <p>
      Think Different!
     </p>
    </div>
   </div>
   <div class="news-item">
    <img alt="A group of children listening to a storyteller" height="150" src="https://images.pexels.com/photos/2098604/pexels-photo-2098604.jpeg" width="150"/>
    <div class="news-content">
     <h3>
     <a href="<?=URLROOT?>/Child/childAuthourAward">Award winning children books of the week</a> 
     </h3>
     <p>
      Read before death
     </p>
    </div>
   </div>
   <div class="news-item">
    <img alt="A stack of colorful children's books" height="150" src="https://storage.googleapis.com/a1aa/image/oNUjjPaai4LQM5LV7o47tw6PwZRm86eP8j0oqfZYh3xU960TA.jpg" width="150"/>
    <div class="news-content">
     <h3>
     <a href="<?=URLROOT?>/Child/childTopBooks">Top 10 books for kids</a>
     </h3>
     <p>
      Check out our list of the top 10 books for kids this month. Find your next favorite read!
     </p>
    </div>
   </div>
   <div class="news-item">
    <img alt="A stack of colorful children's books" height="150" src="https://images.pexels.com/photos/1820559/pexels-photo-1820559.jpeg" width="150"/>
    <div class="news-content">
     <h3>
     <a href="<?=URLROOT?>/Child/childAuto">Life story of an authour</a>
     </h3>
     <p>
      Learn life from them
     </p>
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