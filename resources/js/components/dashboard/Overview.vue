<template>
    <div>
        <div class="overview-head">

            <h5>Overview</h5>
            
            <!-- List group -->
            <div class="list-group list-group-horizontal-xl overview-list-group" id="myList" role="tablist">

                <a @click="getDataForThreeMonths()" class="list-group-item list-group-item-action active text-center bg-transparent" data-toggle="list" href="#three-months" role="tab">3months</a>

                <a @click="getDataForSixMonths()" class="list-group-item list-group-item-action text-center bg-transparent" data-toggle="list" href="#six-months" role="tab">6months</a>

                <a @click="getDataForAYear()" class="list-group-item list-group-item-action text-center bg-transparent" data-toggle="list" href="#one-year" role="tab">1year</a>

                <a @click="getOverallData()" class="list-group-item list-group-item-action text-center bg-transparent" data-toggle="list" href="#all-time" role="tab">all time</a>
           </div>

            <!-- Tab panes -->
            <div class="tab-content">

                <div class="tab-pane overview-content active" id="three-months" role="tabpanel">
                    
                    <div class="overview-main-content">
                        <new-installations 
                        :installations="inhouseInstallations.growthCount" 
                        :showDiff="true"
                        :diffCount="inhouseInstallations.growthDifference"
                        :growthPercent="inhouseInstallations.growthPercent"                                                
                        
                        class="overview-sub-content border-right border-bottom rounded-0 pt-4 pb-4"></new-installations>

                        <new-customers 
                        :customers="customers.growthCount" 
                        :showDiff="true"
                        :diffCount="customers.growthDifference"
                        :growthPercent="customers.growthPercent"                        

                        class="overview-sub-content border-bottom rounded-0 pt-4 pb-4"></new-customers>                                                                        


                        <total-enquiry 
                        :overview-total-enquiries="enquiries.growthCount" 
                        :showDiff="true"
                        :diffCount="enquiries.growthDifference"
                        :growthPercent="enquiries.growthPercent"                                                
                                                                        
                        class="overview-sub-content border-right rounded-0 pt-4"></total-enquiry>


                        <total-quotations 
                        :total-quotations="quotations.growthCount" 
                        :showDiff="true"
                        :diffCount="quotations.growthDifference"
                        :growthPercent="quotations.growthPercent"                                            
                        
                        class="overview-sub-content pt-4"></total-quotations>

                        <success-enquiry 
                        :success-enquiries="successEnquiries.growthCount" 
                        :showDiff="true"
                        :diffCount="successEnquiries.growthDifference"
                        :growthPercent="successEnquiries.growthPercent"
                                                         
                        class="overview-sub-content border-right rounded-0 pt-4"></success-enquiry>

                        <success-quotations 
                        :success-quotations="successQuotations.growthCount" 
                        :showDiff="true"
                        :diffCount="successQuotations.growthDifference"
                        :growthPercent="successQuotations.growthPercent"
                        
                        class="overview-sub-content pt-4"></success-quotations>
                    </div>

                </div>

                <div class="tab-pane overview-content" id="six-months" role="tabpanel">

                    <div class="overview-main-content">
                        <new-installations 
                        :installations="inhouseInstallations.growthCount" 
                        :showDiff="true"
                        :diffCount="inhouseInstallations.growthDifference"
                        :growthPercent="inhouseInstallations.growthPercent"                                                
                        
                        class="overview-sub-content border-right border-bottom rounded-0 pt-4 pb-4"></new-installations>

                        <new-customers 
                        :customers="customers.growthCount" 
                        :showDiff="true"
                        :diffCount="customers.growthDifference"
                        :growthPercent="customers.growthPercent"                        

                        class="overview-sub-content border-bottom rounded-0 pt-4 pb-4"></new-customers>                                                                        


                        <total-enquiry 
                        :overview-total-enquiries="enquiries.growthCount" 
                        :showDiff="true"
                        :diffCount="enquiries.growthDifference"
                        :growthPercent="enquiries.growthPercent"                                                
                                                                        
                        class="overview-sub-content border-right rounded-0 pt-4"></total-enquiry>


                        <total-quotations 
                        :total-quotations="quotations.growthCount" 
                        :showDiff="true"
                        :diffCount="quotations.growthDifference"
                        :growthPercent="quotations.growthPercent"                                            
                        
                        class="overview-sub-content pt-4"></total-quotations>

                        <success-enquiry 
                        :success-enquiries="successEnquiries.growthCount" 
                        :showDiff="true"
                        :diffCount="successEnquiries.growthDifference"
                        :growthPercent="successEnquiries.growthPercent"
                                                         
                        class="overview-sub-content border-right rounded-0 pt-4"></success-enquiry>

                        <success-quotations 
                        :success-quotations="successQuotations.growthCount" 
                        :showDiff="true"
                        :diffCount="successQuotations.growthDifference"
                        :growthPercent="successQuotations.growthPercent"
                        
                        class="overview-sub-content pt-4"></success-quotations>
                    </div>

                </div>

                <div class="tab-pane overview-content" id="one-year" role="tabpanel">
                    
                    <div class="overview-main-content">
                        <new-installations 
                        :installations="inhouseInstallations.growthCount" 
                        :showDiff="true"
                        :diffCount="inhouseInstallations.growthDifference"
                        :growthPercent="inhouseInstallations.growthPercent"                                                
                        
                        class="overview-sub-content border-right border-bottom rounded-0 pt-4 pb-4"></new-installations>

                        <new-customers 
                        :customers="customers.growthCount" 
                        :showDiff="true"
                        :diffCount="customers.growthDifference"
                        :growthPercent="customers.growthPercent"                        

                        class="overview-sub-content border-bottom rounded-0 pt-4 pb-4"></new-customers>                                                                        


                        <total-enquiry 
                        :overview-total-enquiries="enquiries.growthCount" 
                        :showDiff="true"
                        :diffCount="enquiries.growthDifference"
                        :growthPercent="enquiries.growthPercent"                                                
                                                                        
                        class="overview-sub-content border-right rounded-0 pt-4"></total-enquiry>


                        <total-quotations 
                        :total-quotations="quotations.growthCount" 
                        :showDiff="true"
                        :diffCount="quotations.growthDifference"
                        :growthPercent="quotations.growthPercent"                                            
                        
                        class="overview-sub-content pt-4"></total-quotations>

                        <success-enquiry 
                        :success-enquiries="successEnquiries.growthCount" 
                        :showDiff="true"
                        :diffCount="successEnquiries.growthDifference"
                        :growthPercent="successEnquiries.growthPercent"
                                                         
                        class="overview-sub-content border-right rounded-0 pt-4"></success-enquiry>

                        <success-quotations 
                        :success-quotations="successQuotations.growthCount" 
                        :showDiff="true"
                        :diffCount="successQuotations.growthDifference"
                        :growthPercent="successQuotations.growthPercent"
                        
                        class="overview-sub-content pt-4"></success-quotations>
                    </div>

                </div>

                <div class="tab-pane overview-content" id="all-time" role="tabpanel">
                                       
                    <div class="overview-main-content">
                        <new-installations 
                        :installations="inhouseInstallations.growthCount" 
                        :showDiff="false"
                        :diffCount="inhouseInstallations.growthDifference"
                        :growthPercent="inhouseInstallations.growthPercent"                                                
                        
                        class="overview-sub-content border-right border-bottom rounded-0 pt-4 pb-4"></new-installations>

                        <new-customers 
                        :customers="customers.growthCount" 
                        :showDiff="false"
                        :diffCount="customers.growthDifference"
                        :growthPercent="customers.growthPercent"                        

                        class="overview-sub-content border-bottom rounded-0 pt-4 pb-4"></new-customers>                                                                        


                        <total-enquiry 
                        :overview-total-enquiries="enquiries.growthCount" 
                        :showDiff="false"
                        :diffCount="enquiries.growthDifference"
                        :growthPercent="enquiries.growthPercent"                                                
                                                                        
                        class="overview-sub-content border-right rounded-0 pt-4"></total-enquiry>


                        <total-quotations 
                        :total-quotations="quotations.growthCount" 
                        :showDiff="false"
                        :diffCount="quotations.growthDifference"
                        :growthPercent="quotations.growthPercent"                                            
                        
                        class="overview-sub-content pt-4"></total-quotations>

                        <success-enquiry 
                        :success-enquiries="successEnquiries.growthCount" 
                        :showDiff="false"
                        :diffCount="successEnquiries.growthDifference"
                        :growthPercent="successEnquiries.growthPercent"
                                                         
                        class="overview-sub-content border-right rounded-0 pt-4"></success-enquiry>

                        <success-quotations 
                        :success-quotations="successQuotations.growthCount" 
                        :showDiff="false"
                        :diffCount="successQuotations.growthDifference"
                        :growthPercent="successQuotations.growthPercent"
                        
                        class="overview-sub-content pt-4"></success-quotations>
                    </div>

                </div>

            </div>

        </div>
    </div>
</template>

<script>
import NewCustomers from './overview/NewCustomers'
import NewInstallations from './overview/NewInstallations'
import SuccessEnquiry from './overview/SuccessEnquiry'
import SuccessQuotations from './overview/SuccessQuotations'
import TotalEnquiry from './overview/TotalEnquiry'
import TotalQuotations from './overview/TotalQuotations'

export default {
    components: { 
        NewInstallations, 
        NewCustomers, 
        TotalEnquiry, 
        SuccessEnquiry,
        TotalQuotations,
        SuccessQuotations, 
    },

    data() {
        return {
            'inhouseInstallations': [],
            'enquiries': [],
            'successEnquiries': [],            
            'quotations': [],
            'successQuotations': [],
            'customers': [],            
        }
    },

    mounted() {
        this.getDataForThreeMonths()
    },

    methods: {
        getOverallData: function() {    
            axios.get('/api/v1/overall-data/all-time')
            .then(response => {
                this.inhouseInstallations = response.data.inhouseInstallations
                this.enquiries = response.data.enquiries
                this.successEnquiries = response.data.successEnquiries
                this.quotations = response.data.quotations
                this.successQuotations = response.data.successQuotations
                this.customers = response.data.customers
            })
        },

        getDataForThreeMonths: function() {
            axios.get(`/api/v1/overall-data/${1}`)
            .then(response => {
                this.inhouseInstallations = response.data.inhouseInstallations
                this.enquiries = response.data.enquiries
                this.successEnquiries = response.data.successEnquiries
                this.quotations = response.data.quotations
                this.successQuotations = response.data.successQuotations
                this.customers = response.data.customers
            })
        },

        getDataForSixMonths: function() {
            axios.get(`/api/v1/overall-data/${6}`)
            .then(response => {
                this.inhouseInstallations = response.data.inhouseInstallations
                this.enquiries = response.data.enquiries
                this.successEnquiries = response.data.successEnquiries
                this.quotations = response.data.quotations
                this.successQuotations = response.data.successQuotations
                this.customers = response.data.customers
            })
        },

        getDataForAYear: function() {
            axios.get(`/api/v1/overall-data/${12}`)
            .then(response => {
                this.inhouseInstallations = response.data.inhouseInstallations
                this.enquiries = response.data.enquiries
                this.successEnquiries = response.data.successEnquiries
                this.quotations = response.data.quotations
                this.successQuotations = response.data.successQuotations
                this.customers = response.data.customers
            })
        },
    },    
}
</script>

<style>
    .overview-content {
        padding: 0!important;
    }

    .overview-content > div {
        padding: 1em 0!important;
    }

    .overview-main-content {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
    }

    .overview-sub-content {
        display: grid;
        grid-template-columns: 140px 100px 1fr;
    }

    .overview-sub-content > div {
        padding: 0px!important;
    }

    .w-150-px {
        width: 150px;
    }

    .one-five-em {
        font-size: 1.2em;
    }

</style>