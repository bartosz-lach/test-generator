<template>
    <div>
        <v-app>
            <error-box></error-box>
            <navbar></navbar>
            <v-content>
                <v-container>
                    <router-view></router-view>

                </v-container>
            </v-content>

        </v-app>
    </div>


</template>

<script>

    import Navbar from "./components/Navbar";
    import ErrorBox from "./components/ErrorBox"
    export default {
        name: "app",
        components: {
            Navbar,
            ErrorBox,
        }
    }
</script>

<style>
    body{
        font-family: "Roboto", sans-serif;
    }
</style>
