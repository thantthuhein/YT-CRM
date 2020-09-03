<template>
    <div>
        <div class="enquiry-type-head">

            <h5>Enquiry Type</h5>

            <our-visits-graph :enquiryTypes="JSON.parse(enquiries)"></our-visits-graph>

        </div>
    </div>
</template>

<script>
import OurVisitsGraph from './enquiry-type/graphs/OurVisitsGraph'

export default {
    props: ['enquiries'],

    components: { OurVisitsGraph, },

    mounted() {
        // console.log(enquiries)
    },
}
</script>