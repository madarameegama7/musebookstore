<?php require APPROOT.'/views/inc/header.php';?>
<!--TOP NAV BAR-->
<?php require APPROOT.'/views/inc/components/topnavbar.php';?>
<html lang="en">
 <head>
  <meta charset="utf-8"/>
  <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
  <title>
   Muse Bookstore
  </title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="./public/assets/css/childuser/childhome.css">
  </head>
 <body>

 <style>
 body {
    font-family: 'Poppins', sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f5faff;
    font-size: large;
}


.hero {
  background-image: url('https://images.pexels.com/photos/6437496/pexels-photo-6437496.jpeg');
  background-position: center;
  background-size: cover;
  height: 400px;
  display: flex;
  justify-content: center;
  align-items: center;
  text-align: center;
}

 .hero h1 {
    font-size: 48px;
    margin: 0;
    color: white;
}
.hero p {
    font-size: 24px;
    color: white;
} 

.content {
    max-width: 1200px;
    margin: 20px auto;
    padding: 0 20px;
}
.content h2 {
    font-size: 32px;
    margin-bottom: 20px;
}
.news-item {
    display: flex;
    margin-bottom: 20px;
    background-color: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}
.news-item img {
    width: 150px;
    height: 150px;
    border-radius: 8px;
    margin-right: 20px;
}
.news-item .news-content {
    flex: 1;
}
.news-item .news-content h3 {
    margin: 0 0 10px;
    font-size: 24px;
}
.news-item .news-content p {
    margin: 0;
}
</style>
  <div class="hero">
   <div>
    <h1>
     Welcome to Muse Store
    </h1>
    <p>
     Your gateway to magical stories
    </p>
   </div>
  </div>
  <div class="content">
   <h2>
    Explore Muse
   </h2>
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
  </div>
  
 </body>
</html>
<?php
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'child') {
    die("Access denied! You do not have permission to view this page.");
}
?>
<?php require APPROOT.'/views/inc/footer.php';?>