<template>
    <!-- <div class="p-0">
        <div class="project-box-wrapper pt-0">
            <div class="project-box pr-0 mr-0">
                <div class="p-0">
                    <p class="text-muted">Project Name</p> 

                    <h5>{{ currentProject.project.name }}</h5>
                </div>
                <br>
                <div class="p-0">
                    <p class="text-muted">Customer Name</p> 

                    <h5>{{ currentProject.customer.name }}</h5>
                </div>
                <br>
                <div class="p-0">
                    <p class="text-muted">Allocate Team</p> 

                    <h5>{{ currentProject.in_house_installation.inhouse_installation_teams.join(" + <br>")}} </h5>
                </div>

                <br>

                <div class="p-0 pt-4">
                    <i class="fas fa-info-circle"></i>
                    <a href="{{ routeName }}" class="text-light">View Details</a>
                </div>
            </div>

            <div class="project-box-2">

                <div class="p-0">
                    <p class="mb-2">Installation Process {{ currentProject.in_house_installation.installation_progresses[currentProject.in_house_installation.installation_progresses.length - 1].progress }}</p>

                    <div class="bg-dark p-0">
                        <installation-graph></installation-graph>
                    </div>
                </div>

                <div class="p-0 pt-3">
                    <p class="mb-2">Delivery Process 93 %</p>

                    <div class="bg-dark p-0">
                        <delivery-graph></delivery-graph>
                    </div>
                </div>

                <div class="pb-2 px-2 pt-4 mt-3 remark-box">

                    <h5>Remark</h5>
                    <p class="text-secondary">
                        Installation is completed on 100% but need to be approved by Service Manager and Project Manager.
                    </p>
                    <p class="text-right text-secondary">Aung Aung ( Service Admin)</p>
                </div>

            </div>
            
        </div>
    </div> -->
</template>

<script>
import InstallationGraph from './graphs/InstallationGraph';
import DeliveryGraph from './graphs/DeliveryGraph';

export default {
    props: ["currentProject", "routeName"],
    components: { InstallationGraph, DeliveryGraph }    
}
</script>

<style>

    .project-box-wrapper {
        display: grid;
        grid-template-columns: 200px 1fr;
    }

    .remark-box {
        border: 1px solid #ffffff5f!important;
    }

</style>
