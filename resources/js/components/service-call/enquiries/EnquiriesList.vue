<template>
    <div>

        <div class="enquiries-list-content">
            <h5 class="text-white">Enquiries List</h5>

            <table class="table table-borderless text-white mt-4">
                <thead>
                    <tr>
                        <td scope="col" style="padding-left:0;">Enquiry type</td>
                        <td scope="col">Type of sales</td>
                        <td scope="col">Customer name</td>
                        <td scope="col">Company name</td>
                        <td scope="col">Email</td>
                        <td scope="col">Contact number</td>
                        <td scope="col">Project name</td>
                        <td scope="col">Location</td>
                    </tr>
                </thead>
                
                <tbody class="mt-5">

                    <tr class="border-top-solid-white text-custom-1">
                        <td scope="row" style="padding-left: 0;">Phone Call</td>
                        <td>Product Sales</td>
                        <td>Swan Yi</td>
                        <td>MMDS</td>
                        <td>example@example.com</td>
                        <td>09 799 123 456</td>
                        <td>MMDS</td>
                        <td>Pazundaung</td>
                    </tr>
                    
                    <tr class="border-top-solid-white text-custom-1">
                        <td scope="row" style="padding-left: 0;">Phone Call</td>
                        <td>Product Sales</td>
                        <td>Swan Yi</td>
                        <td>MMDS</td>
                        <td>example@example.com</td>
                        <td>09 799 123 456</td>
                        <td>MMDS</td>
                        <td>Pazundaung</td>
                    </tr>

                    <tr class="border-top-solid-white text-custom-1">
                        <td scope="row" style="padding-left: 0;">Phone Call</td>
                        <td>Product Sales</td>
                        <td>Swan Yi</td>
                        <td>MMDS</td>
                        <td>example@example.com</td>
                        <td>09 799 123 456</td>
                        <td>MMDS</td>
                        <td>Pazundaung</td>
                    </tr>

                    <tr class="border-top-solid-white text-custom-1">
                        <td scope="row" style="padding-left: 0;">Phone Call</td>
                        <td>Product Sales</td>
                        <td>Swan Yi</td>
                        <td>MMDS</td>
                        <td>example@example.com</td>
                        <td>09 799 123 456</td>
                        <td>MMDS</td>
                        <td>Pazundaung</td>
                    </tr>

                    <tr class="border-top-solid-white text-custom-1">
                        <td scope="row" style="padding-left: 0;">Phone Call</td>
                        <td>Product Sales</td>
                        <td>Swan Yi</td>
                        <td>MMDS</td>
                        <td>example@example.com</td>
                        <td>09 799 123 456</td>
                        <td>MMDS</td>
                        <td>Pazundaung</td>
                    </tr>
                    
                </tbody>

            </table>
        </div>
    </div>
</template>

<script>
export default {
    mounted() {

        axios.get('/api/v1/searchEnquiries')
        .then(response => console.log(response.data))
        
    },
}
</script>

<style>
    /* tbody:before {
        content:"@";
        display:block;
        line-height: 26px;
        text-indent:-99999px;
    } */
</style>