<template>
    <div>
        <ul class="list-unstyled font-weight-light text-light">

            <li class="mb-1">
                <i class="fas fa-bars mr-2"></i> 
                <span class="red-tooltip font-weight-light" data-toggle="tooltip" data-placement="top" title="YwarTaw">
                    {{ quotationNumber }}
                </span>
            </li>

            <li class="mb-1">
                <i class="fas fa-briefcase mr-2"></i> 
                <span data-toggle="tooltip" data-placement="top" title="Sales Engineer">
                    {{ salesEngineer }}
                </span>
            </li>

            <li class="mb-1">
                <i class="far fa-user mr-2"></i> 
                <span data-toggle="tooltip" data-placement="top" title="Customer">
                    {{ customerName }}
                </span>
            </li>

            <li class="mb-1">
                <i class="far fa-calendar-check mr-2"></i> 
                <span data-toggle="tooltip" data-placement="top" title="Date">
                    {{ quotationDate }}
                </span>
            </li>
            
            <li>
                <i class="fas fa-info-circle mr-2"></i>
                <a :href="link" data-toggle="tooltip" data-placement="top" title="Show all details" class="text-light"> View details</a>
            </li>

        </ul>
    </div>
</template>

<script>
export default {
    props: [
        'quotationNumber', 
        'salesEngineer',
        'customerName',
        'quotationDate',
        'quotationId'
    ],

    data() {
        return {
            link: "admin/quotations/" + this.quotationId,
        }
    },
}
</script>

<style>
    .tooltip-inner {
        color: black!important;
        padding: 0px 12px!important;
        border-radius: 12px!important;
        background-color: rgba(255, 255, 255, 1)!important;
    }

    .arrow {
        display:none!important;
    }
</style>