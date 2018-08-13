[[1,3,6,1,2,1,1,1,0],[1,3,6,1,2,1,1,2,0],[1,3,6,1,2,1,1,3,0],[1,3,6,1,2,1,1,4,0],[1,3,6,1,2,1,1,5,0]
              ,[1,3,6,1,2,1,1,6,0],[1,3,6,1,2,1,1,7,0]]


 //----------------------------------------------
            // pie chart data
            var pieData = [
                {
                    value: 50,
                    color:"#878BB6"//สีเทา
                },
                {
                    value : 10,
                    color : "#4ACAB4"//สีเขียว
                },
                {
                    value : 20,
                    color : "#FF8153"//สีส้ม
                },
                {
                    value : 30,
                    color : "#FFEA88"//
                }
            ];
            // pie chart options
            var pieOptions = {
                 segmentShowStroke : false,
                 animateScale : true
            }
            // get pie chart canvas
            var countries= document.getElementById("countries").getContext("2d");
            // draw pie chart
            new Chart(countries).Pie(pieData, pieOptions);
//--------------------------------------------------------------
            // bar chart data
/*            var barData = {
                labels : ["January","February","March","April","May","June"],
                datasets : [
                    {
                        fillColor : "#48A497",
                        strokeColor : "#48A4D1",
                        data : [456,479,324,569,702,600]
                    },
                    {
                        fillColor : "rgba(73,188,170,0.4)",
                        strokeColor : "rgba(72,174,209,0.4)",
                        data : [364,504,605,400,345,320]
                    }
                ]
            }
            // get bar chart canvas
            var income = document.getElementById("income").getContext("2d");
            // draw bar chart
            new Chart(income).Bar(barData);*/