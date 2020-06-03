<template>
    <div>
        <div class="sticky">
            <v-card v-if="!editForm">
                <v-row>

                </v-row>
                <v-card-title>
                    <h3 class="display-1">
                        {{ test.name }}
                    </h3>
                    <v-btn icon @click ="showTestForm()" >
                        <v-icon>mdi-pencil</v-icon>
                    </v-btn>
                    <v-spacer></v-spacer>
                    <v-btn @click="addQuestion()" color="primary">
                        <v-icon>mdi-plus</v-icon>
                        Add Question
                    </v-btn  >
                    <v-btn
                        :to="{name: 'testVersions', params: {id: test.id}}"
                        color="green"
                        dark
                        class="ml-2"
                    >
                        <v-icon dark>mdi-content-copy</v-icon>
                        Versions
                    </v-btn>
                </v-card-title>

            </v-card>
            <v-card v-if="editForm">
                <v-card-actions>
                    <v-row no-gutters justify="center" class="pt-3" >
                        <v-col x-lg="4" lg="4" md="4">
                            <v-text-field
                                class="pa-2"
                                v-model="test.name"
                                outlined
                                dense
                                color="purple"
                                label="Test Name"
                            ></v-text-field>
                        </v-col>
                        <v-col x-lg="4" lg="6" md="8">
                            <div class="d-flex">
                                <v-select
                                    v-model="test.subject"
                                    :items="subjectsList"
                                    label="Subjects"
                                    hint="If you want add new subject press Add Subject"
                                    class="pa-2 select-input"
                                    persistent-hint
                                    outlined
                                    dense
                                    color="purple"
                                    single-line
                                >
                                </v-select>
                                <subject-dialog-form color="purple"></subject-dialog-form>
                                <v-btn class="ma-2"large dark color="purple" height="40"
                                       @click="save()">
                                    <v-icon left >mdi-content-save</v-icon>
                                    {{ test.id ? 'Update' : 'Save' }}
                                </v-btn>
                            </div>
                        </v-col>
                    </v-row>
                </v-card-actions>

            </v-card>
        </div>

        <div v-if="test.id">
            <div v-for="(question, index) in test.questions" :key="question.id">

                <question  :testId="test.id" :question="question" :index="index"></question>
            </div>
        </div>

    </div>
</template>

<script>
    import SubjectDialogForm from '../subject/SubjectDialogForm'
    import { eventBus } from '../../app';
    import Question from './Question'
    export default {
        name: "Test",
        components:{
            Question,
            SubjectDialogForm,
        },
        props: {
            test: {},
            creatable: false,
            editForm: false,
            subjectsList: Array,


        },

        methods:{
            addQuestion(){
                this.test.questions.unshift({content:'',
                    answers: [{
                        content: '',
                        is_true: false
                    }]})
            },

            save(){
                this.editForm = false;
                this.test.id ?  this.putTest() : this.postTest()

            },
            postTest(){
                axios.post('/api/tests', { name: this.test.name, subject: this.test.subject })
                    .then(res => {
                        this.test.id = res.data.data.id;
                        window.console.log(res.data);
                        this.$forceUpdate()})
                    .catch(error => {
                        eventBus.$emit('errorMessage', error.response.data.message);
                        window.console.log(error.response.data)
                    })
            },
            putTest(){
                axios.put(`/api/tests/${this.test.id}`, { name: this.test.name, subject: this.test.subject })
                    .then(res => {
                        window.console.log(res.data)})
                    .catch(error => {
                        eventBus.$emit('errorMessage', error.response.data.message);
                        window.console.log(error.response.data)
                    })
            },

            showTestForm(){
                this.getSubjects()

            },
            getSubjects(){
                axios.get('/api/subjects', this.subjectsList)
                    .then(res => {
                        this.subjectsList = res.data;
                        this.editForm=true
                    })
                    .catch(error => {
                        eventBus.$emit('errorMessage', error.response.data.message);
                        window.console.log(error.response.data)
                    })
            }
        },
        created(){
            eventBus
                .$on('subjectDialog', (subject)=>{
                this.subjectsList.unshift(subject);})
                .$on('addQuestion', question=> this.test.questions.push(question))
                .$on('deleteQuestion', (id)=>{
                    let i = this.test.questions.map(item => item.id).indexOf(id);
                    this.test.questions.splice(i,1);
                });
        }
    }
</script>

<style scoped>
    .sticky{
        position: -webkit-sticky;
        position: sticky;
        top: 0;
        z-index: 10;
    }
</style>
