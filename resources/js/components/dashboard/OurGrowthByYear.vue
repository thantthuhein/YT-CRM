<template>
    <div>
        <div class="our-growth-by-year-head">
            <h5>Our Growth By Year</h5>

            <our-growth-by-year-graph></our-growth-by-year-graph>
        </div> 
    </div>
</template>

<script>
import OurGrowthByYearGraph from './our-growth-by-year/graphs/OurGrowthByYearGraph'

export default {
    components: { OurGrowthByYearGraph, }
}
</script>