window.onload = function () {

    var activityFlag = "btn-time-work";

    const times = new Map([
        ["btn-time-work", "25:00"],
        ["btn-time-sBreak", "5:00"],
        ["btn-time-lBreak", "10:00"]
      ]);
    
    var times_backup = new Map([
        ["btn-time-work", "25:00"],
        ["btn-time-sBreak", "5:00"],
        ["btn-time-lBreak", "10:00"]
      ]);

    const btns_time = document.querySelectorAll("[id^=btn-time]");

    btns_time.forEach( function(item, index){
        item.addEventListener("click", function() {
            document.getElementById("timer-string").innerHTML = times.get(item.getAttribute("id"));
            times_backup[item.getAttribute("id")] = times.get(item.getAttribute("id"));
            activityFlag = item.getAttribute("id");
        });

        item.addEventListener("mouseover", function() {
            times_backup[item.getAttribute("id")] = document.getElementById("timer-string").innerHTML;
            document.getElementById("timer-string").innerHTML = times.get(item.getAttribute("id"));
        });

        item.addEventListener("mouseout", function() {
            document.getElementById("timer-string").innerHTML = times_backup[item.getAttribute("id")]
        });
    })

    var timer = null;
    var isPaused = false;
    const btn_start = document.getElementById("btn-start");
    btn_start.addEventListener("click", function() {
        
        if (btn_start.textContent == "Start")
        {
            btn_start.textContent = "Stop";
            const time = document.getElementById("timer-string").innerHTML.split(':');
            var countDownDate = new Date().getTime();
            countDownDate += Number(time[0]) * 60 * 1000 + Number(time[1]) * 1000;
            isPaused = false;

            if (timer != null)
            {
                clearInterval(timer);
            }

            timer = setInterval(function() {
                if (!isPaused)
                {
                    var now = new Date().getTime();
                    var distance = countDownDate - now;
                
                    var minutes = Math.floor(distance % (60 * 60 * 1000) / (60 * 1000));
                    var seconds = Math.floor(distance % (60 * 1000) / 1000);
                    
                    if (minutes < 0) minutes = 0;
                    if (seconds < 0) seconds = 0;
                    
                    var seconds_str = seconds < 10 ? ("0" + seconds) : seconds;
                    document.getElementById("timer-string").innerHTML = minutes + ":" + seconds_str;
                
                    if (distance <= 0) {
                        clearInterval(timer);
                        addTimeDB(activityFlag);
                    }
                }               
            }, 1000);
        }
        else
        {
            btn_start.textContent = "Start";
            isPaused = true;
        }
        
    });

    function addTimeDB (activity)
    {
        jQuery.ajax({
            type: "POST",
            url: 'updateTime.php',
            dataType: 'json',
            data: { functionname: 'updateTime', time: times.get(activity), activity: activity },
        
            success: function (obj, textstatus, jqXHR) {
              if (!('error' in obj)) {
                console.log(obj.result);
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
    }
} 