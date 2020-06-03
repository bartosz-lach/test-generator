<template>
    <div>
        <div class="alert alert-danger m-3" role="alert" v-if="error">
            {{ error }}
        </div>
        <test :test="test" :creatable="false"></test>

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
                test: {

                },
                error: ''
            }
        },

        created(){
            axios.get(`/api/tests/${this.$route.params.id}/full`)
                .then(res => this.test = res.data.data)
                .catch(error =>  eventBus.$emit('errorMessage', error.response.data.message)
                );

            window.console.log('Test: ', [this.test, this.error]);
        }
    }

</script>

<style scoped>

</style>
