/* globals Chart:false, feather:false */

function drawDashboard(period) {
  function decycle(obj, stack = []) {
    if (!obj || typeof obj !== 'object')
      return obj;

    if (stack.includes(obj))
      return null;

    let s = stack.concat([obj]);

    return Array.isArray(obj)
      ? obj.map(x => decycle(x, s))
      : Object.fromEntries(
        Object.entries(obj)
          .map(([k, v]) => [k, decycle(v, s)]));
  }

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

  function drawGraph(data_in) {

    var labels_array = data_in.map(label => label.Date);
    var data_array = data_in.map(function (item) {
      let time_array = item.Time.split(":");
      return parseInt(time_array[0]) * 3600 + parseInt(time_array[1]) * 60 + parseInt(time_array[2]);
    });

    var ctx = document.getElementById('myChart');
    var myNewChart = new Chart(ctx, {
      type: "line",
      data: {
        labels: labels_array,
        datasets: [{
          data: data_array
        }]
      },
      options: {
        scales: {
          y: {
            min: 0,
            ticks: {
              callback: function (val, index) {
                return new Date(val * 1000).toISOString().substring(11, 16);
              },
              stepSize: (function () {
                var maxAxisValue = Math.max(...data_array) * 0.9; // add 10%
                var step = Math.ceil((Math.ceil(maxAxisValue / 1800) / 10)) * 1800;
                return step < 1800 ? 1800 : step;
              })(),
            }
          }
        },
        plugins: {
          legend: {
            display: false
          },
          title: {
            display: true,
            text: (function () {
              return "Happy chart!!!";
            })(),
            font: {
              size: 18
            }
          },
          tooltip: {
            callbacks: {
              label: function (context) {
                return new Date(context.parsed.y * 1000).toISOString().substring(11, 16);
              }
            }
          }
        }
      }
    });
  }

};
