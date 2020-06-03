<template>
    <div>

        <v-card class="mb-9">
<!--            <v-card-title v-if="testName">{{ versions[0].testName }} Versions</v-card-title>-->
<!--            <div v-else>-->
                <v-card-title >Generate Version</v-card-title>
<!--                <v-card-subtitle>Not Find any Version of test. </v-card-subtitle>-->
<!--            </div>-->

            <v-card-text style="display: flex">
                <v-text-field
                    label="Version Name"
                    outlined
                    dense
                    v-model="versionName"
                ></v-text-field>
                <v-btn class="ml-2" color="primary" height="40" @click="generate()">Generate</v-btn>
            </v-card-text>

        </v-card>
                <div v-for="version in versions" :key="version.id">
                        <version-list-element :version="version"></version-list-element>
                </div>
    </div>
</template>

<script>
    import VersionListElement from './VersionListElement';
    import { eventBus } from '../../app';

    export default {
        components:{
            VersionListElement,
        },
        props:{
        },
        data(){
            return{
                versions: [],
                versionName: '',
                test_name: ''

            }
        },

        methods:{
            generate(){
                axios.post(`/api/tests/${this.$route.params.id}/generate`, { name: this.versionName })
                    .then(res => {
                        window.console.log('testversion: ', res.data);
                        // this.test_name = this.versions[0].test_name;
                        this.versions.unshift(res.data.data);

                    })
                    .catch(error => {
                        window.console.log('testversionError: ', error);
                        // this.error = err.response.data.message
                        eventBus.$emit('errorMessage', error.response)

                    })
            }
        },
        created(){
            axios.get(`/api/tests/${this.$route.params.id}/test-versions`)
                .then(res => {
                    this.versions = res.data.data;
                    this.testName = this.versions[0].test_name;
                    window.console.log('testversion: ', this.versions)

                })
                .catch(error => {
                    window.console.log('testversion: ', error.response.data);
                    eventBus.$emit('errorMessage', error.response.data.message[0])

                });

                eventBus.$on('deleteVersion', (id)=> {
                    let i = this.versions.map(item => item.id).indexOf(id);
                    this.versions.splice(i, 1);
                });

        }
    }
</script>

<style scoped>

</style>
