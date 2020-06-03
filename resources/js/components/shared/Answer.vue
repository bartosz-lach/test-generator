<template>
    <div class="main">
        <v-row align="center" justify="space-between">
            <v-col cols="11">
        <v-list-item
            color="green"
            :class="borderColor"
            margin=""
            :link="!editForm"
            :inactive="editForm"
        >

            <v-list-item-content  @click ="showForm" v-if="!editForm">
                <v-list-item-action-text class="body-1">{{ answer.content }}</v-list-item-action-text>
            </v-list-item-content>
            <v-list-item-content v-else>

                <div class="d-flex">

                    <v-btn icon left @click="answer.is_true = !answer.is_true" class="mr-2">
                        <v-icon
                            :color="answer.is_true ? 'green' : 'grey' "
                            large
                        >
                            {{ answer.is_true ? 'mdi-check-circle' : 'mdi-check-circle-outline' }}
                        </v-icon>
                    </v-btn>
                    <v-textarea
                        outlined
                        auto-grow
                        clearable
                        rows="1"
                        :success="Boolean(answer.is_true)"
                        label="Answer"
                        v-model="answer.content"
                    ></v-textarea>
                    <v-btn
                        @click="save()"
                        icon
                        class="ml-2"
                    >
                        <v-icon x-large>mdi-plus</v-icon>
                    </v-btn>

                </div>

            </v-list-item-content>
            <v-btn icon @click="deleteAnswer()" v-if="!editForm">
                <v-icon color="red">mdi-delete-outline</v-icon>
            </v-btn>
        </v-list-item>
            </v-col>

        </v-row>
    </div>

</template>

<script>
    import { eventBus } from '../../app'

    export default {
        name: "Answer",
        props:{
            answer:{
                id: Number,
                content: String,
                is_true: Boolean
            },
            editable: true,
            questionId: Number,

        },
        data(){
            return{
                editForm: false,
                link: true
            }
        },
        methods:{
            save(){
                // window.console.log('Question: ', this.question)

                if (this.answer.id){
                    axios.put(`/api/answers/${this.answer.id}`, this.answer)
                        .then(res => window.console.log(res.data))
                        .catch(error => {
                            eventBus.$emit('errorMessage', error.response.data.message);
                            window.console.log(error.response.data)
                        })
                }
                else {
                    axios.post(`/api/questions/${this.questionId}/answers`, this.answer)
                        .then(res => {
                            this.answer.id = res.data.data.id;
                            window.console.log('PostAnswer', {qid: this.questionId, data: res.data})

                        })
                        .catch(error =>{
                            eventBus.$emit('errorMessage', error.response.data.message);
                            window.console.log('PostAnswer', {error: error.response})
                        })
                }
                this.editForm = false;
            },
            deleteAnswer(index){
                axios.delete(`/api/answers/${this.answer.id}`)
                    .then(res => {
                        window.console.log('Answer Delete',res.data, this.answer.id)
                        eventBus.$emit('deleteAnswer', this.answer.id);
                    })
                    .catch(error => {
                        eventBus.$emit('errorMessage', error.response.data.message);
                        window.console.log(error.response.data)
                    })
            },
            showForm(){
                if(this.editForm == false)
                    this.editForm=true
            }
        },
        computed:{
            borderColor(){
                if(this.answer.is_true && !this.editForm){
                    return 'border-success'
                }
                else if(this.editForm){
                    return ''
                }
                else{
                    return 'border-normal'
                }
            }
        }
    }
</script>

<style scoped>
    .main{
        margin-left: 40px;
        display: flex;
    }
    .list-input{
        display: flex;
        margin-top: 5px;
    }
</style>

<style>
    .border-primary{
        border: solid #227BD4 2px;
        margin-left: 12px;
        /*border-bottom-right-radius: 7px;*/
        border-radius: 7px;

    }

    .border-success{
        border: solid #4CAF50 2px;
        border-radius: 7px;
    }

    .border-purple{
        border: solid #A438B6 2px;
        border-radius: 7px;
    }

    .border-normal{
        border : solid darkgray 1px;
        border-radius: 7px;
    }
</style>

