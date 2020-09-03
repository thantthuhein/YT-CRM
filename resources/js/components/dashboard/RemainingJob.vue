<template>
    <tr>
        <td>
            {{ index }}
        </td>
        <td>
            {{ remainingJob.reminder_type.type }}
        </td>
        <td>
            {{ remainingJob.reminder_type.description }}
        </td>
    </tr>
</template>
<script>
export default {
    props: ["index", "job"],
    data(){
        return {
            remainingJob: JSON.parse(this.job)
        }
    }
}
</script>