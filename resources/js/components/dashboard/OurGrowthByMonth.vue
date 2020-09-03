<template>
    <div>
        <div class="our-growth-by-month-head">
            <h5>Our Growth By Month</h5>

            <our-growth-by-month-graph></our-growth-by-month-graph>
        </div> 
    </div>
</template>

<script>
import OurGrowthByMonthGraph from './our-growth-by-month/graphs/OurGrowthByMonthGraph'

export default {
    components: { OurGrowthByMonthGraph, }
}
</script>