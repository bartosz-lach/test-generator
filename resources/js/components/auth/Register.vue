<template>
    <div>

        <!--        <form @submit.prevent="register()">-->

        <!--            <div class="form-group">-->
        <!--                <label for="name-input">Name</label>-->
        <!--                <input type="text" class="form-control" id="name-input" v-model.lazy="form.name">-->
        <!--                <small class="text-danger" v-if="error.name">{{ error.name[0] }}</small>-->
        <!--            </div>-->
        <!--            <div class="form-group">-->
        <!--                <label for="email-input">Email</label>-->
        <!--                <input type="email" class="form-control" id="email-input" v-model.lazy="form.email">-->
        <!--                <small class="text-danger" v-if="error.email">{{ error.email[0] }}</small>-->

        <!--            </div>-->
        <!--            <div class="form-group">-->
        <!--                <label for="password-input">Password</label>-->
        <!--                <input type="password" class="form-control" id="password-input" v-model="form.password">-->
        <!--                <small class="text-danger" v-if="error.password">{{ error.password[0] }}</small>-->

        <!--            </div>-->
        <!--            <div class="form-group">-->
        <!--                <label for="re-password-input">Repeat Password</label>-->
        <!--                <input type="password" class="form-control" id="re-password-input" v-model="form.repeated_password">-->
        <!--                <small class="text-danger" v-if="error.repeated_password">{{ error.repeated_password[0] }}</small>-->

        <!--            </div>-->
        <!--            <button type="submit" class="btn btn-primary" :disabled="!passwordMatch">Register</button>-->
        <!--        </form>-->

        <v-card width="400" class="mx-auto mt-5">
            <v-card-title>
                <h1 class="display-1">Register</h1>
            </v-card-title>
            <v-card-text>
                <v-form lazy-validation v-model="valid" ref="form">
                    <v-text-field
                        v-model = "form.name"
                        :rules="nameRules"
                        outlined
                        type="text"
                        label="Name"
                        prepend-icon="mdi-account-circle"
                    />
                    <v-text-field
                        v-model = "form.email"
                        :rules="emailRules"
                        :error-messages="errorMessages.email"
                        outlined
                        type="email"
                        label="Email"
                        prepend-icon="mdi-email"
                    />
                    <v-text-field
                        v-model="form.password"
                        :rules="passwordRules"
                        outlined
                        :type="showPassword ? 'text' : 'password' "
                        label="Password"
                        prepend-icon="mdi-lock"
                        :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
                        @click:append="showPassword = !showPassword"
                    />
                    <v-text-field
                        v-model="form.repeated_password"
                        :rules="repeatedPasswordRules"
                        :type="showPassword ? 'text' : 'password' "
                        outlined
                        label="Repeat Password"
                        prepend-icon="mdi-lock"
                        :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
                        @click:append="showPassword = !showPassword"
                    />
                </v-form>
                <v-card-actions>
                    <p style="padding-top: 14px">Do you have account? <router-link :to="{name: 'login'}">Log In</router-link>.</p>
                    <v-spacer></v-spacer>
                    <v-btn large color="primary" @click="register()" >Register</v-btn>

                </v-card-actions>
            </v-card-text>
        </v-card>


    </div>
</template>

<script>
    import AppStorage from "../../AppStorage";
    import { eventBus } from '../../app';
    export default {
        name: "register",
        data(){
            return {
                form:{
                    name: '',
                    email: '',
                    password: '',
                    repeated_password: '',
                },
                errorMessages: '',
                showPassword: false,
                valid: false,
                nameRules: [
                    v => !!v || 'Name is required',
                    // v => (v && v.length <= 10) || 'Name must be less than 10 characters',
                ],
                passwordRules: [
                    v => !!v || 'Password is required',
                    v => (v && v.length >= 8) || 'Name must be great than 8 characters',
                ],
                repeatedPasswordRules: [
                    v => !!v || 'Repeated Password is required',
                    v => (v && v.length >= 8) || 'Password must be great than 8 characters',
                    v => v === this.form.password || 'Password must be the same'
                ],
                emailRules: [
                    v => !!v || 'E-mail is required',
                    v => /.+@.+\..+/.test(v) || 'E-mail must be valid',
                ],

            }

        },

        methods: {
            register(){
                if(this.$refs.form.validate()){
                    axios.post('/api/register', this.form)
                        .then(response => {
                            AppStorage.store(response.data.data.userName, response.data.data.token);
                            eventBus.$emit('userInfo', {
                                name: response.data.data.userName,
                                isLogin: true
                            });
                            window.console.log('data:', response.data);
                            this.$router.push({name: 'tests'});
                        })
                        .catch(error => {
                            this.error = error.response.data.message;
                            window.console.log('error:', this.error);

                        });

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
