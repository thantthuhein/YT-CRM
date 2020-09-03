<template>
    <div>
        <div class="d-flex">
            <h5>Today Tasks</h5>

            <div class="ml-auto">
                <a :href="viewAllLink" class="btn btn-view-all py-1 text-white">
                    View all
                </a>
            </div>

            <div>
                <a 
                class="btn btn-create py-1" 
                :href="excelExportLink"
                >
                    Excel Export
                </a>
            </div>
        </div>

        <div class="p-0">
            <slot></slot>
        </div>
    </div>
</template>

<script>
export default {
    props: ['remainingJobIndex', 'viewAllLink', 'excelExportLink']
}
</script>