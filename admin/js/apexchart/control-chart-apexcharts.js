'use strict';
jQuery(function() {
    chartG();
    chartC();
    // getGaData();
    // var Param = {};
       
    // function getGaData() {
        
    //     Param.loCation = $('#Locations').val();		
    //     Param.appName = $('#appName').val();
    //     Param.type = $('#Dtype').val();
    //     Param.propertyId = $('#propertyId').val();
    //     Param.startDate = startDate.format('MMMM D, YYYY');
    //     Param.endDate = endDate.format('MMMM D, YYYY');
    //     Param.action = 'usersAnalyticsData';
    //     $.ajax({
    //         method: "POST",
    //         url: ajaxurl,
    //         data:  getVal(),
    //         success: function(data, status) {
    //             var resp = $.parseJSON(data);
            
    //             let arrays = [];                      
    //         },
    //         error: function(data) {
    //             if (data.responseJSON && data.responseJSON.message) {
    //                 alert(data.responseJSON.message);
    //             } else {
    //             alert('Something went wrong, please try again.');
    //             }
    //         }
    //     });
    //     return false;
    // }
});


/* Basic Line Chart */

function chartG() {
    var options = {
        chart: {
            height: 350,
            type: 'line',
            toolbar: {
                show: false
            },
            zoom: {
                enabled: false
            },
            shadow: {
                enabled: true,
                top: 18,
                left: 7,
                blur: 10,
                opacity: 1
            },
        },
        series: [{
            name: "Desktops",
            data: [10, 41, 35, 51, 49, 62, 69, 91, 148]
        }],

        dataLabels: {
            enabled: false
        },
        stroke: {
            curve: 'smooth'
        },
        title: {
            text: 'Product Trends by Month',
            align: 'left'
        },
        grid: {
            row: {
                colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
                opacity: 0.5
            },
        },
        xaxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep'],
        },
        colors: ['#1b4962', '#ffa000']
    };


    var chart = new ApexCharts(
        document.querySelector("#chartG"),
        options
    );

    chart.render();
}

/* Basic Bar Chart  */
function chartC() {
    var options = {
        series: [{
            data: [400, 430, 448, 470, 540, 580, 690, 1100, 1200, 1380]
        }],
        chart: {
            height: 350,
            type: 'bar',
            fontFamily: 'Poppins, sans-serif',
            toolbar: {
                show: false
            },
            zoom: {
                enabled: false
            },
        },
        plotOptions: {
            bar: {
                horizontal: true,
            }
        },
        dataLabels: {
            enabled: false
        },
        xaxis: {
            categories: ['South Korea', 'Canada', 'United Kingdom', 'Netherlands', 'Italy', 'France', 'Japan',
                'United States', 'China', 'Germany'
            ],
        },
        colors: ["#1a73e8"],
    };

    var chart = new ApexCharts(
        document.querySelector("#chartC"),
        options
    );

    chart.render();
}
