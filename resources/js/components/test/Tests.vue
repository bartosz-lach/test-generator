<template>
    <div >
        <v-card>
            <v-card-actions>

                <v-select
                    v-model="selectedSubject"
                    :items="subjectsList"
                    label="Filter by subjects"
                    hint="Filter by subject"
                    persistent-hint
                    outlined
                    dense
                    color="blue"
                    single-line
                    @change="testsBySubject"
                >
                </v-select>
<!--                <v-btn @click="testsBySubject" dark color="blue">Filter</v-btn>-->
            </v-card-actions>
        </v-card>

            <div class="list-element" v-for="test in tests" :key="test.id">
                <app-test-list-element :test="test"></app-test-list-element>
            </div>


    </div>

</template>

<script>
    import TestListElement from "./TestListElement";
    import { eventBus } from '../../app';


    export default {
        name: "tests",
        components: {
          appTestListElement: TestListElement
        },

        data: function () {
            return {
                tests: [],
                testsCopy: [],
                error: false,
                subjectsList: [],
                selectedSubject: 'ALL',
            }
        },

        methods: {
            testsBySubject(){
                this.tests = this.testsCopy
                window.console.log("filtering", this.selectedSubject);
                if(this.selectedSubject === 'ALL')
                    return
                this.tests = this.tests.filter(t => t.subject === this.selectedSubject);
            },
            goToAddTest(){
                this.$router.push({name:'testAdd'});
            },
            deleteTest(id){
                window.console.log('delete test Function: ', this.tests.map(item => item.id).indexOf(id))
                let i = this.tests.map(item => item.id).indexOf(id);
                this.tests.splice(i, 1);
            },
        },

        created(){
            axios.defaults.headers.common['Authorization'] = `Bearer ${localStorage.getItem('token')}`;

            axios.get('/api/subjects', this.subjectsList)
                .then(res => {

                    this.subjectsList = res.data;
                    this.subjectsList.unshift('ALL');
                    this.editForm=true
                })
                .catch(error => {
                    eventBus.$emit('errorMessage', error.response.data.message);
                    window.console.log(error.response.data)
                })

            axios.get('/api/tests')
                .then(response => {
                    this.tests = response.data.data;
                    this.testsCopy = response.data.data;
                })
                .catch(error => {
                    eventBus.$emit('errorMessage', error.response.data.message)

                    this.error = error.response.data.message
                });

                eventBus.$on('deleteTest', (id)=> {
                    window.console.log('Id form Event',id);
                    this.deleteTest(id)
                })
        }


    }
</script>

<style scoped>
    .header{
        margin: 30px 0;
    }
    .list-element{
        list-style-type: none;
    }
</style>
