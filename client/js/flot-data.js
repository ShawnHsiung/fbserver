// Flot Pie Chart with Tooltips
function ajaxdata(){
    $.ajax({
        type: "GET",
        url: server_root + "feedback",
        dataType:"json",
        cache: false,
        success:function (data) {
            if(!data.error){
                undatepie(data.message);
            }
        },
        error: function () { $("#info").html("Asynchronous read failed！"); }
    }); 
}
function undatepie(binddata){
        $("#option_1").html(binddata[0].amount);
        $("#option_2").html(binddata[1].amount);
        $("#option_3").html(binddata[2].amount);
        $("#option_4").html(binddata[3].amount);
        var data = [{
            label: "Great",
            color: '#0033CC',
            data: parseInt(binddata[0].amount)
        }, {
            label: "Very good",
            color: '#009933',
            data: parseInt(binddata[1].amount)
        }, {
            label: "Good",
            color: '#FF8533',
            data: parseInt(binddata[2].amount)
        }, {
            label: "Bad",
            color: '#CC3300',  
            data: parseInt(binddata[3].amount)
        }];
        if(typeof plotObj == "undefined"){
            var plotObj = $.plot($("#flot-pie-chart"), data, {
                series: {
                    pie: {
                        show: true
                    }
                },
                grid: {
                    hoverable: true
                },
                tooltip: true,
                tooltipOpts: {
                    content: "%p.0%, %s", // show percentages, rounding to 2 decimal places
                    shifts: {
                        x: 20,
                        y: 0
                    },
                    defaultTheme: false
                }
            });
        }else{
            plotObj.setData(data);
        }
    }
    var timerId;
$(function() {
    ajaxdata();
    timerId = setInterval(function() {ajaxdata();console.log(1);}, 5000);
});