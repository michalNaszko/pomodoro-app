<div class="modal-header border-bottom-0">
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
          <span data-feather="calendar"></span>This week
        </div>
        <ul class="time-list dropdown-menu" aria-labelledby="dropdownMenuLink">
          <li><a class="dropdown-item" href="#">Last week</a></li>
          <li><a class="dropdown-item" href="#">This month</a></li>
          <li><a class="dropdown-item" href="#">Last month</a></li>
        </ul>
      </div>

    </div>
  </div>
</div>

<div class="modal-body">
  <canvas class="container-fluid" id="myChart"></canvas>
</div>

<script>
  if (typeof period === 'undefined') {
    $(".activity-list li a").click(function() {
      var activity = $(this).text().trim();
      let period = $(".time-list-selected:first-child").text().trim();
      var activity_type = activity == "Focus time" ? "activity" : "coffee";
      $(this).html($(".activity-list-selected:first-child").text());
      $(".activity-list-selected:first-child").html(' <span data-feather="' + activity_type + '"></span> ' + activity);
      drawDashBoard(period, activity);
      feather.replace();
    });

    $(".time-list li a").click(function() {
      let period = $(this).text().trim();
      let activity = $(".activity-list-selected:first-child").text().trim();
      $(this).html($(".time-list-selected:first-child").text());
      $(".time-list-selected:first-child").html('<span data-feather="calendar"></span>' + period);
      drawDashBoard(period, activity);
      feather.replace();
    });

    feather.replace();
    var period = $(".time-list-selected:first-child").text().trim();
    var activity = $(".activity-list-selected:first-child").text().trim();
    drawDashBoard(period, activity);
  }
  else {
    drawDashBoard(period, activity);
  }
</script>