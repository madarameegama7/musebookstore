<?php require APPROOT.'/views/inc/header.php';?>
<!--TOP NAV BAR-->
<?php require APPROOT.'/views/inc/components/topnavbar.php';?><html>
 <head>
  <title>
   Top 10 books
  </title>
  <style>
    body {
    margin: 0;
    font-family: 'Poppins', sans-serif;
    background-color: #f5faff;
    color: #000;
}
.hero {
 position: relative; /* Ensure the pseudo-element is positioned relative to this element */
 height: 400px;
 display: flex;
 justify-content: center;
 align-items: center;
 text-align: center;
 overflow: hidden; /* Prevent the pseudo-element from overflowing */
}

.hero::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-image: url('https://media.newyorker.com/photos/5909773a8b51cf59fc4233a1/master/w_1920,c_limit/bookcovers_final10.jpg');
    background-position: center;
    background-size: cover;
    opacity: 0.5; /* Adjust the opacity here */
    z-index: -1; /* Ensure the background stays behind the content */
}


 .hero h1 {
    font-size: 48px;
    margin: 0;
    color: black;
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
    flex-wrap: wrap;
    justify-content: center;
    gap: 20px;
    margin: 40px 0;
}
.gallery div {
    flex: 1 1 calc(33.333% - 40px);
    max-width: calc(33.333% - 40px);
    box-sizing: border-box;
}
.gallery img {
    width: 100%;
    height: 200px;
    object-fit: cover;
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
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
  <link href="./public/assets/css/childuser/childTopBooks.css" rel="stylesheet"/>
  </head>
 <body>
 
  <main class="main-content">
  <div class="hero">
   <div>
    <h1>
    Top 10 books for kids
    </h1>
   </div>
  </div>
   <div class="gallery">
    <div>
     <img alt="Book winning picture" height="200" src="https://images7.alphacoders.com/133/1338193.png" width="300"/>
     <div class="image-description">
      Harry Potter and the Philosopher's Stone
     </div>
    </div>
    <div>
     <img alt="Futuristic robot with glowing eyes" height="200" src="https://images7.alphacoders.com/133/1338193.png" width="300"/>
     <div class="image-description">
      Jane iyer
     </div>
    </div>
    <div>
     <img alt="Group of people in futuristic costumes with a dog" height="200" src="https://images7.alphacoders.com/133/1338193.png" width="300"/>
     <div class="image-description">
      Prince and the pauper
     </div>
    </div>
    <div>
     <img alt="Futuristic robot with glowing eyes" height="200" src="https://images7.alphacoders.com/133/1338193.png" width="300"/>
     <div class="image-description">
      Madol duwa
     </div>
    </div>
    <div>
     <img alt="Futuristic robot with glowing eyes" height="200" src="https://images7.alphacoders.com/133/1338193.png" width="300"/>
     <div class="image-description">
      Harry potter and the prisoner of azkaban
     </div>
    </div>
    <div>
     <img alt="Futuristic robot with glowing eyes" height="200" src="https://images7.alphacoders.com/133/1338193.png" width="300"/>
     <div class="image-description">
      Harry potter and the goblet of fire
     </div>
    </div>
    <div>
     <img alt="Futuristic robot with glowing eyes" height="200" src="https://images7.alphacoders.com/133/1338193.png" width="300"/>
     <div class="image-description">
      Game of thrones
     </div>
    </div>
    <div>
     <img alt="Futuristic robot with glowing eyes" height="200" src="https://images7.alphacoders.com/133/1338193.png" width="300"/>
     <div class="image-description">
      Stranger things
     </div>
    </div>
   </div>
  </main>
 
 </body>
</html>