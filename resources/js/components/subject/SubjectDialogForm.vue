<template>
    <v-dialog v-model="dialog" persistent max-width="500px">
        <template v-slot:activator="{ on }">
            <v-btn outlined height="40" class="mt-2" :color="color" v-on="on">Add Subject</v-btn>
        </template>
        <v-card>
            <v-card-title>
                <span class="headline">Add new subject</span>
            </v-card-title>
            <v-card-text>
                <v-text-field outlined label="Subject" :color="color" v-model="subject" required></v-text-field>
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn :color="color" text @click="dialog = false">Close</v-btn>
                <v-btn :color="color" :disabled="subject==''" text @click="addSubject">Save</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
    import { eventBus } from '../../app';

    export default {
        props: {

            color: String
        },
        data(){
            return{
                subject: '',
                dialog: false

            }
        },
        // computed:{
        //   isSubject(){
        //       return if
        //   }
        // },
        methods: {
            addSubject() {
                this.dialog = false;
                if (this.subject !== '') {
                    eventBus.$emit('subjectDialog', this.subject);
                    const subject = {name: this.subject};
                    axios.post('/api/subjects', subject)
                    // .then(res => this.requestResponse = res.data)
                        .then(res => window.console.log(res.data))
                        .catch(error => window.console.log(error.response.data))
                }
            }
        }
    }
</script>

<style scoped>

</style>
