<template>
    <canvas class="p-0 m-0" width="80" height="3" style="border-radius:10px;"></canvas>
</template>

<script>
export default {
    mounted() {
        var installation_graph = new Chart(this.$el, {
            type: 'horizontalBar',
            data: {                
                datasets: [{
                    data: [88],
                    backgroundColor: 'grey',
                    borderColor: 'green',
                    fillColor: "red",
                    strokeColor: "#79D1CF",
                    borderWidth: 10,
                }]
            },
            options: {
                legend: {
                    display: false
                },
                tooltips: {
                    enabled: false
                },
                scales: {
                    xAxes: [{
                        ticks: {
                            display: false,
                            beginAtZero: true,
                        },
                        display: false,
                        gridLines: {
                            display: false
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            display: true,
                            beginAtZero: true,
                            min: 0,
                            max: 100,
                            callback: function(value = 50) {
                                return value + "%"
                            }
                        },
                        type: 'category',
                        offset: true,
                        position: 'top',
                        ticks: {
                            fontColor: "#fff",
                            callback: function(value, index, values) {
                                return data[0].data[index] + data[1].data[index]
                            }
                        },
                        scaleLabel: {
                            display: true,
                            labelString: 'Percentage',
                        },
                        display: false,
                        gridLines: {
                            display: false
                        }
                    }]
                }
            },
            
        })
    },
}
</script>