<html>
 <head>
  <title>
   MuseAdmin Dashboard
  </title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
  <style>
   body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f6fa;
        }
        .container {
            display: flex;
        }
     
        .stat-content {
            flex-grow: 1;
            padding: 20px;
        }
        .dashboard {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .dashboard h2 {
            font-size: 24px;
            margin-bottom: 20px;
        }
        .stats {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .stats .stat {
            background-color: #f5f6fa;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            flex: 1;
            margin-right: 20px;
        }
        .stats .stat:last-child {
            margin-right: 0;
        }
        .stats .stat h3 {
            font-size: 20px;
            margin-bottom: 10px;
        }
        .stats .stat p {
            font-size: 16px;
            color: #888;
        }
        .stats .stat .icon {
            font-size: 40px;
            margin-bottom: 10px;
        }
        .stats .stat .up {
            color: #4caf50;
        }
        .stats .stat .down {
            color: #f44336;
        }
        .chart {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        .chart h3 {
            font-size: 20px;
            margin-bottom: 20px;
        }
   
  </style>
 </head>
 <body>
   <div class="stat-content">
    <div class="dashboard">
     <h2><center>Summary</center></h2>
     <div class="stats">
      <div class="stat">
       <div class="icon">
        <i class="fas fa-child">
        </i>
       </div>
       <h3>
        Child Accounts
       </h3>
       <p>
        1
       </p>
      </div>
      <div class="stat">
       <div class="icon">
        <i class="fas fa-book">
        </i>
       </div>
       <h3>
        Total books
       </h3>
       <p>
        3
       </p>
       <p class="up">
        3% Up from past month
       </p>
      </div>
      <div class="stat">
       <div class="icon">
        <i class="fas fa-dollar-sign">
        </i>
       </div>
       <h3>
        Tokens
       </h3>
       <p>
        3
       </p>
       <p class="up">
        3 more book tokens
       </p>
      </div>
      <div class="stat">
       <div class="icon">
        <i class="fas fa-tasks">
        </i>
       </div>
       <h3>
        Progress
       </h3>
       <p>
        5
       </p>
       <p class="up">
        10% increase of enagegment of books
       </p>
      </div>
     </div>
    </div>
    
   </div>
 </body>
</html>
