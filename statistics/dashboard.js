/* globals Chart:false, feather:false */

function drawDashBoard(period, activity) {
  jQuery.ajax({
    type: "POST",
    url: 'retrieveStatistics.php',
    dataType: 'json',
    data: { functionname: 'retrieveStatistics', period: period, activity: activity },

    success: function (obj, textstatus, jqXHR) {
      if (!('error' in obj)) {
        console.log(obj.result);
        drawGraph(obj.result, period);
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

  function drawGraph(data_in, period) {
    console.log(data_in);
    console.log(period);

    const getAllDaysInMonth = (date) =>
      Array.from(
        { length: new Date(date.getFullYear(), date.getMonth() + 1, 0).getDate() },
        (_, i) => (new Date(date.getFullYear(), date.getMonth(), i + 1 + 1)).toISOString().replace(/(.*?)(T.*)/, "$1") // Adding another one is a riddle
      );
    
    const getAllDaysInWeek = (date) =>
      Array.from(
        { length: 7 },
        (_, i) => (new Date(date.getFullYear(), 
                            date.getMonth(), 
                            date.getDate() - ((date.getDay() + 6) % 7) + i + 1)).toISOString().replace(/(.*?)(T.*)/, "$1") // Adding one is a riddle
      );
    
    var date = new Date();
    var labels_array = null;
    switch (period) {
      case 'This month':
        labels_array = getAllDaysInMonth(date);
        break;
      case 'Last month':
        date.setDate(0);
        labels_array = getAllDaysInMonth(date);
        break;
      case 'This week':
        labels_array = getAllDaysInWeek(date);
        break;
      case 'Last week':
        date.setDate(date.getDate() - 7);
        labels_array = getAllDaysInWeek(date);
        break;
    }

    var data_array = new Array(labels_array.length).fill(0);

    if (data_in !== null && data_in.length !== 0)
    {
      var j = 0;
      labels_array.every(function (value, i) {
        if (value == data_in[j].Date) {
          let time_array = data_in[j].Time.split(":");
          data_array[i] = parseInt(time_array[0]) * 3600 + parseInt(time_array[1]) * 60 + parseInt(time_array[2])
          j++;
          if (j >= data_in.length)
            return false;
        }
        return true;
      });
    }

    let chartStatus = Chart.getChart('myChart');
    if (chartStatus != undefined) {
      chartStatus.destroy();
    }

    var ctx = document.getElementById('myChart');
    var myNewChart = new Chart(ctx, {
      type: "bar",
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
                var maxAxisValue = Math.max(...data_array);// * 0.9; // add 10%
                var step = Math.ceil((Math.ceil(maxAxisValue / 1800) / 10)) * 1800;
                return step < 1800 ? 1800 : step;
              })(),
            }
          },
          x: {
            ticks: {
              callback: function (val, index, ticks) {
                if (period.includes('month'))
                {
                  return this.getLabelForValue(val).replace(/.*?-/, "");
                }
                const weekdays = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday']
                return weekdays[index];
              },
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
              if (period == 'This month' ||
                  period == 'Last month')
              {
                const date = new Date();
                if (period == 'Last month')
                  date.setDate(0);
                const month = date.toLocaleString('default', { month: 'long' });
                return month;
              }
              return period;
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
