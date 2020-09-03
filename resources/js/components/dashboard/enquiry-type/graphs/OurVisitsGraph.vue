<template>
    <div>
        <canvas id="our-visits-graph" class="p-0 m-0" width="100" height="150"></canvas>

        <div style="display:flex; align-item:center;" class="p-0 m-0">
            <p>Phone Call</p> <p style="margin-left: auto;">{{ enquiryTypes.phoneCall }}</p>
        </div>

        <div style="display:flex; align-item:center;" class="p-0 m-0">
            <p>Email</p> <p style="margin-left: auto;">{{ enquiryTypes.email }}</p>
        </div>

        <div style="display:flex; align-item:center;" class="p-0 m-0">
            <p>Walk In</p> <p style="margin-left: auto;">{{ enquiryTypes.walkIn }}</p>
        </div>
        
    </div>
</template>

<script>
export default {
    props:['enquiryTypes'],    

    mounted() {
        var context = document.querySelector('#our-visits-graph')
        var our_visits_graph = new Chart(context, {
            type: 'doughnut',
            responsive: true,
            title: {
                display: true,
                position: "top",
                text: "Doughnut Chart",
                fontSize: 18,
                fontColor: "#111"
            },
            legend: {   
                display: true,
                position: "bottom",
                labels: {
                fontColor: "#333",
                fontSize: 16
                }
            },
            data: {                
                labels: [ 'Phone Calls', 'Email', 'Walk In'],
                datasets: [{
                    data: [
                        this.enquiryTypes.phoneCall,
                        this.enquiryTypes.email,
                        this.enquiryTypes.walkIn,
                    ],
                    backgroundColor: [
                        "rgb(53, 76, 206)",
                        "rgb(79, 166, 216)",
                        "rgb(117, 153, 173)",
                    ],
                    borderColor: [
                        'green',
                    ],
                    borderWidth: 0,
                }]
            },
            options: {
                cutoutPercentage: 75,
                elements: {
                    center: {
                        text: 'Our Visits',
                        color: 'white', 
                        fontSize: 80,
                        // fontStyle: 'Helvetica', 
                        sidePadding: 15,
                    }
                },
                legend: {
                    display: false
                },
                scales: {
                    xAxes: [{
                        ticks: {
                            display: true,
                            beginAtZero: true
                        },
                        display: false,
                        gridLines: {
                            display: true
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            display: false,
                            beginAtZero: true
                        },
                        display: false,
                        gridLines: {
                            display: false
                        }
                    }]
                }
            },    
            
        })

        Chart.pluginService.register({
            beforeDraw: function (chart) {
                if (chart.config.options.elements.center) {
                //Get ctx from string
                var ctx = chart.chart.ctx;

                //Get options from the center object in options
                var centerConfig = chart.config.options.elements.center;
                var fontStyle = centerConfig.fontStyle || 'Arial';
                var txt = centerConfig.text;
                var color = centerConfig.color || '#000';
                var sidePadding = centerConfig.sidePadding || 20;
                var sidePaddingCalculated = (sidePadding/100) * (chart.innerRadius * 2)
                //Start with a base font of 30px
                ctx.font = "40px " + fontStyle;

                //Get the width of the string and also the width of the element minus 10 to give it 5px side padding
                var stringWidth = ctx.measureText(txt).width;
                var elementWidth = (chart.innerRadius * 2) - sidePaddingCalculated;

                // Find out how much the font can grow in width.
                var widthRatio = elementWidth / stringWidth;
                var newFontSize = Math.floor(30 * widthRatio);
                var elementHeight = (chart.innerRadius * 2);

                // Pick a new font size so it will not be larger than the height of label.
                var fontSizeToUse = Math.min(newFontSize, elementHeight);

                //Set font settings to draw it correctly.
                ctx.textAlign = 'center';
                ctx.textBaseline = 'middle';
                var centerX = ((chart.chartArea.left + chart.chartArea.right) / 2);
                var centerY = ((chart.chartArea.top + chart.chartArea.bottom) / 2);
                ctx.font = fontSizeToUse+"px " + fontStyle;
                ctx.fillStyle = color;

                //Draw text in center
                ctx.fillText(txt, centerX, centerY);
                }
            }
        });

    },
    
}
</script>
    