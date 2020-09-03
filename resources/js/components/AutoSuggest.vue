<template>
    <div class="autocomplete">
        <input @input="" v-model="search" type="text">
        <ul v-show="isOpen" class="autocomplete-results text-white">
            <a class="text-white text-decoration-none" href="/admin/enquiries">
                <li v-for="(result, i) in results" :key="i" class="autocomplete-result">
                    {{ result }}
                </li>
            </a>
        </ul>
    </div>
</template>

<script>
export default {
    name: 'autocomplete',
    props: {
        items: {
            type: Array,
            required: false,
            default: () => [],
        },
    },
    data() {
        return {
            search: '',
            results: [],
            isOpen: false,
        }
    },

    methods: {
        onChange() {
            this.filterResults();
            this.isShow()
        },

        isShow() {
            if (this.results.length == 0 ) {
                return this.isOpen = false
            }
            this.isOpen = true
        },

        filterResults() {
            this.results = this.items.filter(
                item => item.toLowerCase().indexOf(this.search.toLowerCase()) > -1
            );
        },

    },

    mounted() {
        
    },
    
    created: function() {
        let self = this;
        window.addEventListener('click', function(e) {
            if (! self.$el.contains(e.target) ) {
                self.isOpen = false
            }
        })
    }
}
</script>

<style>
    .autocomplete {
        position: relative;
        width: 130px;
        padding: 12px 24px;
        width: 400px!important;
    }

    .autocomplete-results {
        padding: 0;
        margin: 0;
        border: 1px solid #eeeeee;
        height: 120px;
        overflow: auto;
    }

    .autocomplete-result {
        list-style: none;
        text-align: left;
        padding: 4px 2px;
        cursor: pointer;
    }

    .autocomplete-result:hover {
        background-color: #4AAE9B;
        color: white;
    }
</style>