<template>
    <div>
        <div class="w-150-px pt-0"><h3 class="font-italic font-style-baskerville">{{ successQuotations }}</h3> Success Quotations</div>
        
        <div class="d-flex align-items-center">
            <h5 v-if="showDiff" 
            :class="diffCount >= 0 ? 'font-italic font-style-baskerville overview-custom-color-1' : 'font-italic font-style-baskerville overview-custom-color-2'"
            >
                <span v-if="diffCount >= 0">+</span>
                {{ diffCount }} (<span v-if="diffCount >= 0">+</span>{{ growthPercent }}%) 
            </h5>
        </div>

    </div>
</template>
<script>
export default {
    props: ['successQuotations', 'showDiff', 'diffCount', 'growthPercent']
}
</script>