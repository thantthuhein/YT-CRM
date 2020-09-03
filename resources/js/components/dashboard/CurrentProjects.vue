<template>
    <div>

        <div class="current-project-head container pb-0">
            <div class="row">

                <div class="col-3 mr-auto">
                    <h5 class="mr-auto">Current Projects</h5>
                </div>

                <div class="col-3 ml-auto text-right">
                    <a href="/admin/in-house-installations/current-projects" class="btn btn-view-all text-white py-1 px-3">View all</a>
                </div>
                
            </div>
        </div>

        <div class="current-project-body p-0">

            <slot></slot>

        </div>

    </div>
</template>

<script>
import ProjectList from './current-projects/ProjectList'

export default {
    components: { ProjectList, }    
}
</script>

<style>

    .current-project-body {
        display: grid;
        grid-template-columns: repeat(2, 1fr)
    }

</style>