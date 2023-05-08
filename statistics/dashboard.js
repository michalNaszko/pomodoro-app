/* globals Chart:false, feather:false */

(function () {
  var labels_array = [
    'Monday',
    'Tuesday',
    'Wednesday',
    'Thursday',
    'Friday',
    'Saturday',
    'Sunday'
  ];

  var data_array = [
    40339,
    21345,
    18483,
    24003,
    23489,
    24092,
    30034
  ];

  console.log("Before HTTP request!\n");

  jQuery.ajax({
    type: "POST",
    url: 'statistics.php',
    dataType: 'json',
    data: { functionname: 'retrieveStatistics' },

    success: function (obj, textstatus, jqXHR) {
      if (!('error' in obj)) {
        console.log(obj.result);
        drawGraph(obj.result);
      }
      else {
        console.log(obj.error);
      }
    },

    complete: function (jqXHR, textStatus) {
      console.log("Completed!!!");
    },

    error: function (jqXHR, textStatus, errorThrown) {
      console.log("Error: " + textStatus + " " + errorThrown);
    }
  });

  console.log("After HTTP request!\n");

  function drawGraph(data) {
    'use strict'
    feather.replace({ 'aria-hidden': 'true' })
    labels_array = data.map(o => o.Date);
    data_array = data.map(o => o.Time);
    console.log(data_array);

    // Graphs
    var ctx = document.getElementById('myChart')
    // eslint-disable-next-line no-unused-vars
    var myChart = new Chart(ctx, {
      type: 'line',
      data: {
        labels: labels_array,
        datasets: [{
          data: data_array,
          lineTension: 0,
          backgroundColor: 'transparent',
          borderColor: '#007bff',
          borderWidth: 4,
          pointBackgroundColor: '#007bff'
        }]
      },
      options: {
        scales: {
          yAxes: [{
            ticks: {
              beginAtZero: false
            }
          }]
        },
        legend: {
          display: false
        }
      }
    })
  }

})()
