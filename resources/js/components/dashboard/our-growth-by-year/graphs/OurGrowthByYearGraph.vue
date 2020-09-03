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
            axios.get('/api/v1/get-our-growth-by-year-data')
            .then(response => {            
                // console.log(response.data)
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

            var our_growth_by_year_graph = new Chart(this.$el, {
                type: 'bar',
                options: {
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
                                stepSize: 5
                            }
                        }]
                    }
                },
                data: {
                    labels: [
                        '2019',
                        '2020',
                        '2021',
                        '2022',
                        '2023',
                        '2024',
                        '2025',
                        '2026',
                        '2027',
                        '2028',
                        '2029',
                        '2030',
                    ],

                    datasets: [
                        
                        {
                            label: "Sales",
                            backgroundColor: sales_color_gradient,
                            hoverBackgroundColor: sales_color_gradient,
                            hoverBorderWidth: 1,
                            hoverBorderColor: 'purple',
                            data: [
                                this.saleContracts.twentyNineteen.length, 
                                this.saleContracts.twentyTwenty.length, 
                                this.saleContracts.twentyTwentyOne.length, 
                                this.saleContracts.twentyTwentyTwo.length, 
                                this.saleContracts.twentyTwentyThree.length, 
                                this.saleContracts.twentyTwentyFour.length, 
                                this.saleContracts.twentyTwentyFive.length, 
                                this.saleContracts.twentyTwentySix.length, 
                                this.saleContracts.twentyTwentySeven.length, 
                                this.saleContracts.twentyTwentyEight.length, 
                                this.saleContracts.twentyTwentyNine.length, 
                                this.saleContracts.twentyThirty.length, 
                            ]
                        },
                        {
                            label: "Installation",
                            backgroundColor: installation_color_gradient,
                            hoverBackgroundColor: installation_color_gradient,
                            hoverBorderWidth: 1,
                            hoverBorderColor: 'purple',
                            data: [
                                this.inhouseInstallations.twentyNineteen.length, 
                                this.inhouseInstallations.twentyTwenty.length, 
                                this.inhouseInstallations.twentyTwentyOne.length, 
                                this.inhouseInstallations.twentyTwentyTwo.length, 
                                this.inhouseInstallations.twentyTwentyThree.length, 
                                this.inhouseInstallations.twentyTwentyFour.length, 
                                this.inhouseInstallations.twentyTwentyFive.length, 
                                this.inhouseInstallations.twentyTwentySix.length, 
                                this.inhouseInstallations.twentyTwentySeven.length, 
                                this.inhouseInstallations.twentyTwentyEight.length, 
                                this.inhouseInstallations.twentyTwentyNine.length, 
                                this.inhouseInstallations.twentyThirty.length, 
                            ]
                        },
                        {
                            label: "Service",
                            backgroundColor: service_color_gradient,
                            hoverBackgroundColor: service_color_gradient,
                            hoverBorderWidth: 1,
                            hoverBorderColor: 'purple',
                            data: [
                                this.servicings.twentyNineteen.length, 
                                this.servicings.twentyTwenty.length, 
                                this.servicings.twentyTwentyOne.length, 
                                this.servicings.twentyTwentyTwo.length, 
                                this.servicings.twentyTwentyThree.length, 
                                this.servicings.twentyTwentyFour.length, 
                                this.servicings.twentyTwentyFive.length, 
                                this.servicings.twentyTwentySix.length, 
                                this.servicings.twentyTwentySeven.length, 
                                this.servicings.twentyTwentyEight.length, 
                                this.servicings.twentyTwentyNine.length, 
                                this.servicings.twentyThirty.length, 
                            ]
                        },
                        {
                            label: "Repair",
                            backgroundColor: repair_color_gradient,
                            hoverBackgroundColor: repair_color_gradient,
                            hoverBorderWidth: 1,
                            hoverBorderColor: 'purple',
                            data: [
                                this.repairs.twentyNineteen.length, 
                                this.repairs.twentyTwenty.length, 
                                this.repairs.twentyTwentyOne.length, 
                                this.repairs.twentyTwentyTwo.length, 
                                this.repairs.twentyTwentyThree.length, 
                                this.repairs.twentyTwentyFour.length, 
                                this.repairs.twentyTwentyFive.length, 
                                this.repairs.twentyTwentySix.length, 
                                this.repairs.twentyTwentySeven.length, 
                                this.repairs.twentyTwentyEight.length, 
                                this.repairs.twentyTwentyNine.length, 
                                this.repairs.twentyThirty.length,
                            ]
                        },
                        
                    ],
                }
            })
        }    
    },
}
</script>