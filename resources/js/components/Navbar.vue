<template>
    <nav >
        <v-toolbar>

                <v-toolbar-title>Test Generator</v-toolbar-title>


            <v-spacer></v-spacer>

            <v-toolbar-items >
                <v-btn text :to="{ name: 'tests'}" v-if="userInfo.isLogin">Tests</v-btn>
                <v-btn text color="purple" :to="{ name: 'testAdd'}" v-if="userInfo.isLogin"><v-icon left>mdi-file-document-box-check-outline</v-icon>Create Test</v-btn>
                <v-btn text @click="logout()" v-if="userInfo.isLogin"><v-icon left>mdi-logout-variant</v-icon>Log out</v-btn>
                <v-btn text :to="{ name: 'register'}" v-if="!userInfo.isLogin">Register</v-btn>
                <v-btn text :to="{ name: 'login'}" v-if="!userInfo.isLogin"><v-icon left>mdi-login-variant</v-icon>Log in</v-btn>

            </v-toolbar-items>

        </v-toolbar>
    </nav>

</template>

<script>
    import AppStorage from "../AppStorage";
    import { eventBus } from '../app';
    import { mdiLogoutVariant } from '@mdi/js';
    import { mdiAccountPlusOutline } from '@mdi/js';

    export default {
        name: "navbar",

        data(){
            return{
                User: User,
                userInfo: {
                    name: '',
                    isLogin: false
                }
            }
        },
        methods:{
            logout(){
                AppStorage.clear();
                this.userInfo = {};
                this.$router.push({name: 'login'});
            }
        },

        created(){

            eventBus.$on('userInfo', (userInfo)=>{
                this.userInfo = userInfo;
                window.console.log('userInfo: ', this.userInfo)
            });

            if (User.isLogin())
                this.userInfo = {
                    name: User.name(),
                    isLogin: true
                };

        }
    }
</script>

<style scoped>

</style>
