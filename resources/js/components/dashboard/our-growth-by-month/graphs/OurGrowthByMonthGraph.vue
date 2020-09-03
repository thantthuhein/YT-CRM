<template>

    <canvas class="p-0 m-0" width="100%" height="30"></canvas>
    
</template>

<script>
export default {
    data() {
        return {
            saleContracts: "",
            inhouseInstallations: "",
            servicings: "",
            repairs: "",
        }
    },

    mounted() {
        this.getData()
    },

    methods: {
        getData: function() {
            axios.get('/api/v1/get-our-growth-by-month-data')
            .then(response => {
                this.saleContracts = response.data.saleContracts;
                this.inhouseInstallations = response.data.inhouseinstallations;
                this.servicings = response.data.servicing;
                this.repairs = response.data.repair;
                this.renderChart()
            })
        },

        renderChart: function() {
            var bar_ctx = this.$el.getContext('2d');

            var sales_color_gradient = bar_ctx.createLinearGradient(0, 0, 0, 600);
            sales_color_gradient.addColorStop(0, '#0ED2F7');
            sales_color_gradient.addColorStop(1, '#112E48');

            var installation_color_gradient = bar_ctx.createLinearGradient(0, 0, 0, 600);
            installation_color_gradient.addColorStop(0, '#EE9CA7');
            installation_color_gradient.addColorStop(0.4, '#3C1053');
            installation_color_gradient.addColorStop(0.8, '#EE9CA7');
            installation_color_gradient.addColorStop(1, '#112E48');

            var service_color_gradient = bar_ctx.createLinearGradient(0, 0, 0, 600);
            service_color_gradient.addColorStop(0, '#A17FE0');
            service_color_gradient.addColorStop(0.5, '#112E48');
            service_color_gradient.addColorStop(1, '#FF9068');

            var repair_color_gradient = bar_ctx.createLinearGradient(0, 0, 0, 600);
            repair_color_gradient.addColorStop(0, '#FDC830');
            repair_color_gradient.addColorStop(1, '#112E48');

            var our_growth_by_month_graph = new Chart(this.$el, {
                type: 'bar',
                options: {
                    tooltips: {
                        callbacks: {
                        backgroundColor: '#FFF',
                        titleFontSize: 16,
                        titleFontColor: '#0066ff',
                        bodyFontColor: '#000',
                        bodyFontSize: 14,
                        displayColors: false
                        }
                    },
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true,
                                min: 0,
                                callback: function (value) {
                                    if ( Number.isInteger(value) ) {
                                        return value;
                                    }
                                },
                                stepSize: 1
                            }
                        }]
                    }
                },
                data: {
                    labels: [
                        'January',
                        'February',
                        'March',
                        'April',
                        'May',
                        'June',
                        'July',
                        'August',
                        'September',
                        'October',
                        'November',
                        'December',
                    ],

                    datasets: [

                        {
                            label: "Sales",
                            backgroundColor: sales_color_gradient,
                            hoverBackgroundColor: sales_color_gradient,
                            hoverBorderWidth: 1,
                            hoverBorderColor: 'purple',
                            data: [
                                this.saleContracts.january.length, 
                                this.saleContracts.february.length, 
                                this.saleContracts.march.length, 
                                this.saleContracts.april.length, 
                                this.saleContracts.may.length, 
                                this.saleContracts.june.length, 
                                this.saleContracts.july.length, 
                                this.saleContracts.august.length, 
                                this.saleContracts.september.length, 
                                this.saleContracts.october.length, 
                                this.saleContracts.november.length, 
                                this.saleContracts.december.length, 
                            ]
                        },
                        {
                            label: "Installation",
                            backgroundColor: installation_color_gradient,
                            hoverBackgroundColor: installation_color_gradient,
                            hoverBorderWidth: 1,
                            hoverBorderColor: 'purple',
                            data: [
                                this.inhouseInstallations.january.length, 
                                this.inhouseInstallations.february.length, 
                                this.inhouseInstallations.march.length, 
                                this.inhouseInstallations.april.length, 
                                this.inhouseInstallations.may.length, 
                                this.inhouseInstallations.june.length, 
                                this.inhouseInstallations.july.length, 
                                this.inhouseInstallations.august.length, 
                                this.inhouseInstallations.september.length, 
                                this.inhouseInstallations.october.length, 
                                this.inhouseInstallations.november.length, 
                                this.inhouseInstallations.december.length, 
                            ]
                        },
                        {
                            label: "Service",
                            backgroundColor: service_color_gradient,
                            hoverBackgroundColor: service_color_gradient,
                            hoverBorderWidth: 1,
                            hoverBorderColor: 'purple',
                            data: [
                                this.servicings.january.length, 
                                this.servicings.february.length, 
                                this.servicings.march.length, 
                                this.servicings.april.length, 
                                this.servicings.may.length, 
                                this.servicings.june.length, 
                                this.servicings.july.length, 
                                this.servicings.august.length, 
                                this.servicings.september.length, 
                                this.servicings.october.length, 
                                this.servicings.november.length, 
                                this.servicings.december.length, 
                            ]
                        },
                        {
                            label: "Repair",
                            backgroundColor: repair_color_gradient,
                            hoverBackgroundColor: repair_color_gradient,
                            hoverBorderWidth: 1,
                            hoverBorderColor: 'purple',
                            data: [
                                this.repairs.january.length, 
                                this.repairs.february.length, 
                                this.repairs.march.length, 
                                this.repairs.april.length, 
                                this.repairs.may.length, 
                                this.repairs.june.length, 
                                this.repairs.july.length, 
                                this.repairs.august.length, 
                                this.repairs.september.length, 
                                this.repairs.october.length, 
                                this.repairs.november.length, 
                                this.repairs.december.length, 
                            ]
                        },
                        
                    ]
                }
            })
        }
    },
}
</script>