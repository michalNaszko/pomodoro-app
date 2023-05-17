<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard Template · Bootstrap v5.0</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/dashboard/">

    

    <!-- Bootstrap core CSS -->
<link href="../assets/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>

    
    <!-- Custom styles for this template -->
    <link href="dashboard.css" rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script type = "text/javascript" src="dashboard.js"></script>  
  </head>
  <body>

<div class="container-fluid">
  <div class="row">

    <main class="col-md-9 mx-sm-auto col-lg-10 px-md-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Statistics</h1>
        <div class="btn-toolbar">

          <div class="btn-group me-2">
            <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
          </div>

          <div class="btn-block dropdown me-2">
            <div class="activity-list-selected btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
              <span data-feather="activity"></span> 
              Focus time 
            </div>
            <ul class="activity-list dropdown-menu" aria-labelledby="dropdownMenuLink">
              <li><a class="dropdown-item" href="#">Break time</a></li>
            </ul> 
          </div>

          <div class="btn-block dropdown me-2">
            <div class="time-list-selected btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
              <span data-feather="calendar"></span>
              This week
            </div>
            <ul class="time-list dropdown-menu" aria-labelledby="dropdownMenuLink">
              <li><a class="dropdown-item" href="#">This month</a></li>
              <li><a class="dropdown-item" href="#">Last month</a></li>
            </ul> 
          </div>

        </div>

      </div>

      <canvas class="my-4 w-100" id="myChart" width="900" height="380"></canvas>

    </main>
  </div>
</div>

    <script>
      $(".activity-list li a").click(function(){
        var tmp = $(this).text().trim();
        console.log(tmp);
        var activity_type = tmp == "Focus time" ? "activity" : "coffee";
        $(this).html($(".activity-list-selected:first-child").text());
        $(".activity-list-selected:first-child").html(' <span data-feather="' + activity_type + '"></span> '+tmp);
        feather.replace(); 
      });

      $(".time-list li a").click(function(){
        var tmp = $(this).text();
        $(this).html($(".time-list-selected:first-child").text());
        $(".time-list-selected:first-child").html(' <span data-feather="calendar"></span> '+tmp);
        drawDashBoard(tmp);
        feather.replace(); 
      });
    </script>

    <script src="../assets/dist/js/bootstrap.bundle.min.js"></script>

      <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script><script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js" integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous"></script>
      <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
      <script>
        drawDashBoard($(".time-list-selected:first-child").text());
      </script>
  </body>
</html>
