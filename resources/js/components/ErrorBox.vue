<template>
    <div>
        <v-snackbar
            v-model="snackbar"
            color="error"
            :timeout="7000"
            top="top"
        >
            {{ error }}
            <v-btn
                dark
                text
                @click="snackbar = false"
            >
                Close
            </v-btn>
        </v-snackbar>
    </div>
</template>

<script>
    import { eventBus } from '../app';

    export default {
        name: "ErrorMessage",
        data(){
            return{
                error: '',
                snackbar: false,
            }
        },
        created(){
            eventBus.$on('errorMessage', error => {
                this.error = error;
                this.snackbar= true;
            });
        }
    }
</script>

<style scoped>

</style>
