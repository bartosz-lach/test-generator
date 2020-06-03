<template>
    <v-card class="mt-4">
            <v-card-text>
            <v-row justify="space-between" align="center">
                    <v-col >
                        <h3>{{ version.name }}</h3>

                    </v-col>
                    <v-col >
                        <div style="display: flex; float: right">
                            <v-btn outlined class="ml-2" color="primary" @click="download('test')">Test</v-btn>
                            <v-btn outlined class="ml-2" color="primary" @click="download('questions-sheet')">Question Sheet</v-btn>
                            <v-btn outlined class="ml-2" color="primary" @click="download('check-sheet')">Check Sheet</v-btn>
                            <v-btn outlined class="ml-2" color="red" dark @click="deleteVersion()">
                                <v-icon>mdi-delete</v-icon>
                            </v-btn>

                        </div>
                    </v-col>

                </v-row>
            </v-card-text>
    </v-card>
</template>

<script>
    import { eventBus } from '../../app';

    export default {
        name: "versionListElement",
        props: {
            version: {},
            testName: String,
        },
        methods: {
            deleteVersion(){
              axios.delete(`/api/test-versions/${this.version.id}`)
                  .then(res => {
                      window.console.log(res.data.data);
                      eventBus.$emit(('deleteVersion'), this.version.id)
                  })
                  .catch(err => {
                      eventBus.$emit('errorMessage', error.response.data.message);
                      window.console.log('delete version: ', err.response.data)
                  })
            },
            download(docType){
                window.console.log('tesVersion: ', this.version);

                // axios.get(`/api/test-versions/${version.id}/pdf/`)
                axios.get(`/api/test-versions/${this.version.id}/pdf/${docType}`, {responseType: 'arraybuffer'})
                    .then(response => {
                        // window.console.log('PDF: ', this.testName);
                        let blob = new Blob([response.data], { type: 'application/pdf' })
                        let link = document.createElement('a');
                        link.href = window.URL.createObjectURL(blob);
                        // link.setAttribute('download', 'file.pdf');
                        link.download = `${this.version.test_name} (${docType.replace(/-/g, " ")}) - ${this.version.name}.pdf`;
                        link.click()
                    })
                    .catch(error => eventBus.$emit('errorMessage', error.response.data));

            },



        }
    }
</script>

<style scoped>
    .buttons{
        margin-left: 30%;
        display:flex;
    }
</style>
