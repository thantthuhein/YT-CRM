<template>
    <div>
        <div class="pending-quotations-list-head container pb-0">
            <div class="row">

                <div class="col-3 mr-auto">
                    <h5 class="mr-auto">Pending Quotations List</h5>
                </div>

                <div class="col-3 ml-auto text-right">
                    <a :href="link" class="btn btn-view-all text-white py-1 px-3">
                        View All
                    </a>
                </div>
                
            </div>
        </div>

        <div class="pending-quotations-list-body p-0">

            <slot></slot>

        </div>

    </div>
</template>

<script>
export default {
    data() {
        return {
            link: `admin/quotations?selected_status=pending`
        }
    },
}
</script>

<style>
    .pending-quotations-list-body {
        display: grid;
        grid-template-columns: repeat(4, 1fr)
    }
</style>