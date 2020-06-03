<template>
    <div class="element">
<!--        <router-link class="c"-->
<!--                :to="{ name: 'showTest', params: {id: test.id }}">-->
<!--            {{ test.subject }} - {{ test.name }}-->
<!--        </router-link>-->
<!--        <div class="float-right">-->
<!--            <button class="btn mr-3 btn-outline-success">Generate Version</button>-->
<!--            <router-link tag="button" class="btn mr-3 btn-outline-info" :to="{name: 'testVersions', params: {id: test.id}}">Test Versions</router-link>-->
<!--            <router-link tag="button" class="btn mr-3 btn-outline-primary" :to="{name: 'editTest', params: {id: test.id}}">Edit</router-link>-->
<!--            <button class="btn btn-outline-danger">Delete</button>-->
<!--        </div>-->

<!--        /////////////////////////////////////////////////////////////////-->


        <v-card
            class="mx-auto"
        >
            <v-row justify="space-between" >
                <v-col class="">
                    <v-card-title>
                        {{ test.name }}
                        <!--                    <v-spacer></v-spacer>-->
                        <!--                    <v-btn right class="buttons">Show</v-btn>-->
                    </v-card-title>
                    <v-card-subtitle>
                        {{ test.subject }}
                    </v-card-subtitle>
                </v-col>
                                    <v-spacer></v-spacer>

                <v-col cols="3" >
<!--                    <small>Questions: 34 | Versions: 2</small>-->
                    <v-card-actions>
                        <v-tooltip bottom>
                            <template v-slot:activator="{ on }">
                                <v-btn :to="{ name: 'test', params: { id: test.id }}" large icon color="primary" dark v-on="on">
                                    <v-icon>mdi-eye</v-icon>
                                </v-btn>
                            </template>
                            <span>Show</span>
                        </v-tooltip>

                        <v-tooltip bottom>
                            <template v-slot:activator="{ on }">
                                <v-btn :to="{ name: 'test', params: { id: test.id }}" large icon color="teal" dark v-on="on">
                                    <v-icon>mdi-pencil</v-icon>
                                </v-btn>
                            </template>
                            <span>Edit</span>
                        </v-tooltip>
                        <v-tooltip bottom>
                            <template v-slot:activator="{ on }">
                                <v-btn @click="deleteTest()" large icon color="red" dark v-on="on">
                                    <v-icon>mdi-delete</v-icon>
                                </v-btn>
                            </template>
                            <span>Delete</span>
                        </v-tooltip>

                        <v-tooltip bottom>
                            <template v-slot:activator="{ on }">
                                <v-btn :to="{ name: 'testVersions', params:{ id: test.id }}" large icon color="success" v-on="on" >
                                    <v-icon dark>mdi-content-copy</v-icon>
                                </v-btn>
                            </template>
                            <span>Create Test Version</span>
                        </v-tooltip>

<!--                        <v-btn large icon color="teal">-->
<!--                            <v-icon>mdi-pencil</v-icon>-->
<!--                        </v-btn>-->
<!--                        <v-btn large icon color="red">-->
<!--                            <v-icon>mdi-delete</v-icon>-->
<!--                        </v-btn>-->
<!--                        <v-btn large fab dark color="green" >-->
<!--                            <v-icon dark>mdi-content-copy</v-icon>-->
<!--                        </v-btn>-->
                    </v-card-actions>


                </v-col>
<!--            <v-row align="center"-->
<!--                   justify="end">-->
<!--               -->
<!--            </v-row>-->
            </v-row>
        </v-card>

    </div>
</template>

<script>
    import { eventBus } from '../../app';

    export default {
        name: "TestListElement",
        props: ['test'],
        methods: {
            deleteTest(){
                axios.delete(`/api/tests/${this.test.id}`)
                // .then(res => this.requestResponse = res.data)
                    .then(res => {
                        window.console.log(res.data)
                        eventBus.$emit('deleteTest', this.test.id);
                    })
                    .catch(error => {
                        eventBus.$emit('errorMessage', error.response.data.message);
                        window.console.log(error.response.data)
                    })


            }
        }
    }
</script>

<style scoped>
    .element{
        margin: 20px;
    }
    .buttons{
    }

</style>
