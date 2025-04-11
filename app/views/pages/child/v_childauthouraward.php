<html>
 <head>
  <title>
   Winners Gallery
  </title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="./public/assets/css/childuser/childAuthorAward.css">
 </head>
 <style>
    body {
    margin: 0;
    font-family: 'Poppins', sans-serif;
    background-color: #f5faff;
    color: #000;
}
.hero {
    background-image: url('https://images.pexels.com/photos/1571734/pexels-photo-1571734.jpeg');
  background-position: center;
  background-size: cover;
  height: 400px;
  display: flex;
  justify-content: center;
  align-items: center;
  text-align: center;
}
.hero img {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    z-index: -1;
}
.hero h1 {
    font-size: 48px;
    margin: 0;
    color: white;
}
.main-content {
    text-align: center;
    padding: 40px 20px;
}
.main-content h1 {
    font-size: 48px;
    margin-bottom: 20px;
}
.gallery {
    display: flex;
    justify-content: center;
    gap: 20px;
    margin: 40px 0;
    flex-wrap: wrap;
}
.gallery img {
    width: 300px;
    height: 200px;
    object-fit: cover;
}
.filter {
    display: flex;
    justify-content: center;
    gap: 20px;
    margin: 20px 0;
    flex-wrap: wrap;
}
.filter button {
    background-color: transparent;
    border: 2px solid #000;
    border-radius: 20px;
    padding: 10px 20px;
    color: #000;
    font-size: 16px;
    cursor: pointer;
}
.filter button:hover {
    background-color: #ff4500;
    border-color: #ff4500;
    color: #fff;
}
.filter .search {
    display: flex;
    align-items: center;
    border: 2px solid #000;
    border-radius: 20px;
    padding: 10px 20px;
}
.filter .search input {
    background-color: transparent;
    border: none;
    color: #000;
    font-size: 16px;
    outline: none;
}
.filter .search i {
    margin-left: 10px;
}
.description {
    margin-top: 20px;
    font-size: 18px;
    color: #666;
}
.image-description {
    margin-top: 10px;
    font-size: 16px;
    color: #666;
}
 </style>
 <body>
  
  <main class="main-content">
  <div class="hero">
   <div>
    <h1>
    Winners Gallery
    </h1>
   </div>
  </div>
   <div class="gallery">
    <div>
     <img alt="person 0" height="200" src="https://images6.alphacoders.com/340/340083.jpg" width="300"/>
     <div class="image-description">
      Best Writer of the week
     </div>
    </div>
    <div>
     <img alt="person 1" height="200" src="https://images7.alphacoders.com/884/884285.jpg" width="300"/>
     <div class="image-description">
      Most Famous Writer of the week
     </div>
    </div>
    <div>
     <img alt="person 2" height="200" src="https://images8.alphacoders.com/564/564618.jpg" width="300"/>
     <div class="image-description">
      Asia memorial award winner of the week
     </div>
    </div>
   </div>
   <div class="description">
    <p>
     Search what you desire
    </p>
   </div>
   <div class="filter">
    <button>
     2024
    </button>
    <button>
     All Categories
    </button>
    <button>
     All Awards
    </button>
    <div class="search">
     <input placeholder="Search" type="text"/>
     <i class="fas fa-search">
     </i>
    </div>
   </div>
  </main>
 
 </body>
</html>