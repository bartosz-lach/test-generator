<template>
    <div>

<!--        <div class="alert alert-danger m-3" role="alert" v-if="loginResponse.success === false">-->
<!--            {{ loginResponse.message.main[0] }}-->
<!--        </div>-->
<!--        <form @submit.prevent="submit()">-->
<!--            <div class="form-group">-->
<!--                <label for="email-input">Email</label>-->
<!--                <input type="email" class="form-control" id="email-input" v-model.lazy="form.email">-->
<!--            </div>-->
<!--            <div class="form-group">-->
<!--                <label for="password-input">Password</label>-->
<!--                <input type="password" class="form-control" id="password-input" v-model="form.password">-->
<!--            </div>-->
<!--            <button type="submit" class="btn btn-secondary">Login</button>-->
<!--        </form>-->
<!--        <p>Don't have account? <router-link :to="{name: 'register'}">Register here</router-link>.</p>-->

        <v-snackbar
            v-model="snackbar"
            color="success"
        >
            Login Successful
        </v-snackbar>


        <v-card width="400" class="mx-auto mt-5">
            <v-card-title>
                <h1 class="display-1">Login</h1>
            </v-card-title>
            <v-card-text >
                <v-alert type="error" v-if="alert">
                    Email or Password is Invalid
                </v-alert>

                <div @click="resetError()">
                    <v-form lazy-validation v-model="valid" ref="form">
                        <v-text-field
                            v-model = "form.email"
                            :error="error"
                            outlined
                            required
                            type="email"
                            label="Email"
                            prepend-icon="mdi-email"
                        />
                        <v-text-field
                            v-model="form.password"
                            :error="error"
                            outlined
                            :type="showPassword ? 'text' : 'password' "
                            label="Password"
                            prepend-icon="mdi-lock"
                            :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
                            @click:append="showPassword = !showPassword"
                        />
                    </v-form>
                </div>

                <v-card-actions >

                    <p style="padding-top: 14px">Don't have account? <router-link :to="{name: 'register'}">Register here</router-link>.</p>
                    <v-spacer></v-spacer>
                    <v-btn large color="primary" @click="login()" >Log In</v-btn>
                </v-card-actions>
            </v-card-text>
        </v-card>
    </div>
</template>

<script>
    import AppStorage from "../../AppStorage";
    import { eventBus } from '../../app';
    // import { mdiEmail } from '@mdi/js';

    export default {
        name: "Login",
        // props: {
        //     isLogin: Boolean
        // },
        data(){
            return {
                form: {
                    email: '',
                    password: ''
                },
                // loginResponse: {},
                showPassword: false,
                snackbar: false,
                errorMessages: '',
                alert: false,
                error: false,
                valid: false
            }
        },
        // computed:{
        //     loginResponse() {
        //         return loginResponse.message.main[0]
        //     },
        // },
        methods: {


            login() {
                if (this.$refs.form.validate()) {
                    axios.post('/api/login', this.form)
                        .then(response => {
                            AppStorage.store(response.data.data.userName, response.data.data.token);
                            this.loginResponse = response.data;
                            this.snackbar = true;
                            eventBus.$emit('userInfo', {
                                name: response.data.data.userName,
                                isLogin: true
                            });
                            this.$router.push({name: 'tests'});
                            // return response.data;
                            // window.console.log('Response Login: ', response.data);
                            // loginResponse = response.data;
                        })
                        .catch(error => {
                            this.loginResponse = error.response.data;
                            this.errorMessage = error.response.data.message.main[0];
                            this.error = true;
                            this.alert = true;
                            window.console.log(this.errorMessage)


                            // return error.response.data

                            // return loginResponse;
                            // loginResponse = error.response.data;
                        });
                }
            },

            resetError() {
                if(this.error == true){
                    this.error = false;
                }
            }
        },
        created() {
            if (User.isLogin()){
                this.$router.push('tests');
            }
        }
    }
</script>

<style scoped>

</style>
