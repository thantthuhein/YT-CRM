<template>
    <canvas class="p-0 m-0" width="" height="3" style="border-radius:10px;"></canvas>
</template>

<script>
export default {
    mounted() {
        var installation_graph = new Chart(this.$el, {
            type: 'horizontalBar',
            // curvature: 0,
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
                        stacked: true,
                        ticks: {
                            beginAtZero: true
                        },
                        display: false,
                    }],
                    yAxes: [{
                        stacked: true,
                        display: false,
                    }]
                }
            },
            
        })
    },
}
</script>