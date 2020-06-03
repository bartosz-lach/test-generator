<template>
    <div class="main">
        <v-card raised>
            <v-card-text>
                <v-row>
                    <v-col>
                        <div class="question">
                        <v-chip
                            color="primary"
                            label
                            large
                        >
                            <span class="display-1" >{{index+1}}</span>
                        </v-chip>
                        <v-list-item
                            :link="!editForm"
                            :inactive="editForm"
                            color="primary"
                            :class="editForm ? '' : 'border-primary'"
                        >
                                <v-list-item-content  @click ="editForm=true" v-if="!editForm">
                                    <v-list-item-action-text class="body-1">
                                        {{question.content}}

                                    </v-list-item-action-text>

                                </v-list-item-content>
                                <v-list-item-content v-else>
                                    <div class="list-input">
                                        <v-textarea
                                            outlined
                                            rows="1"
                                            clearable
                                            auto-grow
                                            label="Question"
                                            v-model="question.content"
                                        ></v-textarea>
                                        <v-btn
                                            @click="save()"
                                            icon
                                        >
                                            <v-icon x-large>mdi-plus</v-icon>
                                        </v-btn>

                                    </div>
                                </v-list-item-content>

                        </v-list-item>
                        </div>
                        <div class="answer-container">
                            <v-list >
                            <div  v-if="question.id" class="answer" v-for="answer in question.answers">
                                <answer  :questionId="question.id"  :editable="true"  :answer="answer"></answer>
                            </div>

                            </v-list>
                            <v-row justify="center" >
                            <v-btn @click="addAnswer()" :disabled="!question.id" class="answer-btn"><v-icon left>mdi-plus</v-icon> Add Answer</v-btn>

                            </v-row >
                            <v-card-actions>
                                <v-spacer></v-spacer>

                                <v-btn icon @click="deleteQuestion()" color="red" dark>
                                    <v-icon >mdi-delete</v-icon>

                                </v-btn  >
                            </v-card-actions>
                        </div>

                    </v-col>

                </v-row>


            </v-card-text>

        </v-card>

    </div>

</template>

<script>
    import Answer from './Answer'
    import { eventBus } from '../../app';

    export default {
        name: "Question",
        components:{
            Answer
        },
        data(){
            return{
                editForm: false,
                answerEditForm: false
            }
        },
        props:{
            testId: Number,
            index: Number,
            editable: true,
            question:{
                id: Number,
                content: String,
                answers: [
                    {
                        id: Number,
                        content: String,
                        is_true: Boolean
                    }
                ]
            }
        },
        methods: {
            addQuestion(){
                this.editForm = false;
              eventBus.$emit(('addQuestion'), {
                  content:'',
                  answers: [{
                      content: '',
                      is_true: false
                  }]})
            },
            deleteQuestion(){
                axios.delete(`/api/questions/${this.question.id}`)
                    .catch(err => {
                        eventBus.$emit('errorMessage', err.response.data.message)
                    })
                eventBus.$emit('deleteQuestion', this.question.id);
            },
            save() {
                this.editForm = false;
                this.question.id ? this.putQuestion() : this.postQuestion();
            },
            postQuestion(){
                axios.post(`/api/tests/${this.testId}/questions`, this.question)
                    .then(res => {
                        this.question.id = res.data.data.id;
                        this.$forceUpdate();
                    })
                    .catch(error => {
                        eventBus.$emit('errorMessage', error.response.data.message);
                    })
            },
            putQuestion(){
                axios.put(`/api/questions/${this.question.id}`, this.question)
                    .then(res => window.console.log('putQuestion',res.data))
                    .catch(error => {
                        eventBus.$emit('errorMessage', error.response.data.message);
                    })
            },
            addAnswer(){
                this.question.answers.push({content: '', is_true:false});
                this.answerEditForm = true;
            },
            deleteAnswer(id){
                window.console.log('delete Answer Function: ', this.question.answers.map(item => item.id).indexOf(id))
                let i = this.question.answers.map(item => item.id).indexOf(id);
                this.question.answers.splice(i, 1);
            },
        },
        created(){
            eventBus.$on('deleteAnswer', (id)=>{
                this.deleteAnswer(id)
                // window.console.log('userInfo: ', this.userInfo)
            });
        }
    }
</script>

<style scoped>
    .main{
        margin: 20px;
    }
    .question{
        display: flex;
        font-size: large;
    }
    .list-input{
        display: flex;
    }
    .answer-container{
        margin-left: 60px;
    }
    .answer-btn{
        text-align: center;
    }
</style>
