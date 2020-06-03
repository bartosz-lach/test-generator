<template>
    <div>
        <div class="alert alert-danger m-3" role="alert" v-if="requestResponse">
            {{ requestResponse }}
        </div>

        <p>{{ version.name }}</p>
        <test :test="version.content"></test>
    </div>
</template>

<script>
    import Test from './../shared/Test';
    import { eventBus } from '../../app';

    export default {
        components: {
            test: Test
        },
        data(){
            return{
                version: {},
                requestResponse: ''
            }
        },


        created(){
            axios.get(`/api/test-versions/${this.$route.params.id}`)
                .then(res =>{
                    this.version = res.data.data;
                    // window.console.log(this.version)
                })
                .catch(error =>  {
                    eventBus.$emit('errorMessage', error.response.data.message)

                    // this.error =err.response.data.message
                })
                // .catch(error => window.console.log(response.data));

        }
    }
</script>

<style scoped>

</style>
