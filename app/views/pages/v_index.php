<?php require APPROOT.'/views/inc/header.php';?>
<!--TOP NAV BAR-->
<?php require APPROOT.'/views/inc/components/topnavbar.php';?>


<section class="hero">

    <div class="index-content">
    <h1>Learn faster. Get smarter.</h1>
    <h2>Welcome to <br>Muse Bookstore</h2>
    <p>Your go-to platform for swapping, selling, and buying books. <br>
        Connect with fellow book lovers and expand your library today!</p>
    </div>
    <div class="index-top-image">
    <img src="/musebookstore/public/img/index-page.jpg">
    </div>
   
</section>

<a href="<?php echo URLROOT?>/books/show" class="cta-button">Browse Books</a>
<br><br><br>

<section class="search">
    <div class="search-container">
        <form action="<?php echo URLROOT; ?>/books/search" method="get" class="book-search-form">
            <input type="text" name="q" placeholder="Search your book"
                value="<?php echo isset($_GET['q']) ? htmlspecialchars($_GET['q']) : ''; ?>" />
            <button class="search-button">Search</button>
        </form>


    </div>

</section>

<section class="categories">
    <h2>Book Categories</h2>
    <div class="category-container">
        <?php 
        $categories = [
            ["Arts / Design", "https://www.shortform.com/img/category-arts-design.9db953f8.svg"],
            ["Biography / Memoir", "https://www.shortform.com/img/category-biography-memoir.1cda77e8.svg"],
            ["Business", "https://www.shortform.com/img/category-business.3fdcc799.svg"],
            ["Career / Success", "https://www.shortform.com/img/category-career-success.1fd4c933.svg"],
            ["Communication", "https://www.shortform.com/img/category-communication.d9361d2d.svg"],
            ["Economics", "https://www.shortform.com/img/category-economics.5d16d92a.svg"],
            ["Education", "https://www.shortform.com/img/category-education.e2d66ba6.svg"],
            ["Entrepreneurship", "https://www.shortform.com/img/category-entrepreneurship.a02a6518.svg"],
            ["Entertainment", "https://www.shortform.com/img/category-entertainment.334b0bc4.svg"],
            ["Fiction", "https://www.shortform.com/img/category-fiction.4af0eb77.svg"],
            ["Food", "https://www.shortform.com/img/category-food.db963bdd.svg"],
            ["Health", "https://www.shortform.com/img/category-health.39a0c6e6.svg"],
            ["History", "https://www.shortform.com/img/category-history.64059bb0.svg"],
            ["Law", "https://www.shortform.com/img/category-law.4fac1439.svg"],
            ["Lifestyle", "https://www.shortform.com/img/category-lifestyle.095e8217.svg"],
            ["Leadership", "https://www.shortform.com/img/category-management-leadership.4c573f15.svg"],
            ["Marketing", "https://www.shortform.com/img/category-marketing.253cad52.svg"],
            ["Media", "https://www.shortform.com/img/category-media.08084c56.svg"],
            ["Money/Finance", "https://www.shortform.com/img/category-money-finance.fe3de532.svg"],
            ["Philosophy", "https://www.shortform.com/img/category-motivation.e26ba4a0.svg"],
            ["Parenting", "https://www.shortform.com/img/category-parenting.6fd1745d.svg"],
            ["Politics", "https://www.shortform.com/img/category-politics.7f01f14c.svg"],
            ["Productivity", "https://www.shortform.com/img/category-productivity.68829822.svg"],
            ["Psychology", "https://www.shortform.com/img/category-psychology.ba45293c.svg"],
            ["Relationships", "https://www.shortform.com/img/category-relationships.5ac526ba.svg"],
            ["Sales", "https://www.shortform.com/img/category-sales.d0fe0d79.svg"],
            ["Science", "https://www.shortform.com/img/category-science.880ec37e.svg"],
            ["Self-Improvement", "https://www.shortform.com/img/category-self-improvement.f43ca3b1.svg"],
            ["Society/Culture", "https://www.shortform.com/img/category-society-culture.05797f8f.svg"],
            ["Spirituality", "https://www.shortform.com/img/category-spirituality.54b2657d.svg"],
            ["Sports", "https://www.shortform.com/img/category-sports.0fcc6932.svg"],
            ["Technology", "https://www.shortform.com/img/category-technology.e9763a48.svg"]
        ];

        foreach ($categories as $index => $category) {
            $hiddenClass = $index >= 6 ? 'hidden' : '';
            $categoryUrl = URLROOT . "/books/category?name=" . urlencode($category[0]);
        
            echo "<a href='$categoryUrl' class='category-link $hiddenClass'>
                    <div class='category'>
                        <img src='{$category[1]}' alt='{$category[0]}'><br>
                        <span>{$category[0]}</span>
                    </div>
                  </a>";
        }        
        ?>
    </div>
    <br>
    <a href="#" id="showMoreBtn">Show More Book Categories</a>
</section>

<script>
    document.getElementById("showMoreBtn").addEventListener("click", function() {
        document.querySelectorAll(".hidden").forEach(category => {
            category.style.display = "block";
        });
        this.style.display = "none"; // Hide the button after clicking
    });
</script>

<div class="articles-container">
        <h2>Articles</h2>
        <div class="articles">
            <div class="articles-card">
            <img src="/musebookstore/public/img/index-page.jpg">
                <h3>Great Thinkers: How Suffering Can Improve Your Life</h3>
                <p>By Ann Francis</p>
                <p class="year">Muse (2024)</p>
            </div>
            <div class="articles-card">
                <img src="/musebookstore/public/img/index-lifestyle.jpg" alt="Lifestyle">
                <h3>This Year’s Travelers Seek Calm and Connection</h3>
                <p>By Jame Peterson</p>
                <p class="year">Muse (2025)</p>
            </div>
            <div class="articles-card">
                <img src="/musebookstore/public/img/index-comm.jpeg" alt="Communication">
                <h3>Quick Help: 10 Steps to Stay Cool in Political Conversations</h3>
                <p>By Andriana Swans</p>
                <p class="year">Muse (2025)</p>
            </div>
        </div>
        <br>
        <a href="#" id="showMoreBtn">Show More Articles</a>
</div>

<div class="communities-container">
        <h2>Communities</h2>
        <div class="communities">
            <div class="communities-card">
            <img src="/musebookstore/public/img/index-page.jpg">
                <h3>Great Thinkers: How Suffering Can Improve Your Life</h3>
                
            </div>
            <div class="communities-card">
                <img src="/musebookstore/public/img/index-lifestyle.jpg" alt="Lifestyle">
                <h3>This Year’s Travelers Seek Calm and Connection</h3>
               
            </div>
            <div class="communities-card">
                <img src="/musebookstore/public/img/index-comm.jpeg" alt="Communication">
                <h3>Quick Help: 10 Steps to Stay Cool in Political Conversations</h3>
                
            </div>
        </div>
        <br>
</div>

<?php require APPROOT.'/views/inc/footer.php';?>
