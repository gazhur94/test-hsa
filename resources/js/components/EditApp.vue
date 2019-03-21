<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="button-block">
                    <button class="btn btn-success" @click="document.name !== '' ? saveChanges() : alertError()">Save</button>
                    <button class="btn btn-danger" @click="$router.back()">Cancel</button>
                </div>
                <div class="card">
                    <div class="card-header">Edit/Watch</div>

                    <div class="card-body">
                        <input v-model="document.name" required type="text" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default">

                        <hr>
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" :style="{ width: fileProgress + '%' }">
                                {{ fileCurrent }}%
                            </div>
                        </div>
                        <hr>
                        <input type="file" id="file-input" multiple="multiple" name="files" @change="fileInputChange"/>
                        <hr>
                        <div class="row">
                            <div class="col-sm-6">
                                <h3 class="text-center">Files in queue {{filesOrder.length}}</h3>
                                <ul class="list-group">
                                    <li class="list-group-item" v-for="file in filesOrder">
                                        {{ file.name }}
                                    </li>
                                </ul>
                            </div>
                            <div class="col-sm-6">
                                <h3 class="text-center">Uploaded files {{ filesFinish.length }}</h3>
                                <ul class="list-group">
                                    <li class="list-group-item" v-for="file in filesFinish">
                                        {{ file.item.name }}
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {

        created: function() {
            if (this.$route.params.id != 0) {
                this.getDocument()
            } else {
                this.document.id = 0;
                this.document.name = '';
                console.log(this.document);
            }

        },
        data: function() {
            return {
                document: {},
                filesOrder: [],
                filesFinish: [],
                fileProgress: 0,
                fileCurrent: ''
            }
        },
        methods: {
            async getDocument() {
                await axios.post('/get-document', { id: this.$route.params.id }).then((response) => {
                    this.document = response.data
                });
            },
            async fileInputChange() {
                let files = Array.from(event.target.files);
                for (let item of files) {
                    if (item.type === 'application/pdf') {
                        this.filesOrder.push(item);
                    } else {
                        alert('Only pdf files allowed')
                    }

                }
                for (let item of files) {
                    if (item.type === 'application/pdf') {
                        await this.uploadFile(item);
                    }

                }
            },
            async uploadFile(item) {
                let form = new FormData();
                form.append('file', item);

                await axios.post('/upload', form, {
                    onUploadProgress: (itemUpload) => {
                        this.fileProgress = Math.round( itemUpload.loaded / itemUpload.total * 100 );
                        this.fileCurrent = item.name + '' + this.fileProgress;
                    }
                })
                .then(responce => {
                    this.fileProgress = 0;
                    this.fileCurrent = '';
                    this.filesFinish.push({item, path: responce.data.path});
                    this.filesOrder.splice(item, 1);
                })
                .catch(error => {
                    console.log(error)
                })
            },

            async saveChanges() {
                let files = [];
                for (let file of this.filesFinish) {
                    files.push({
                        name: file.item.name,
                        path: file.path
                    });
                }

                await axios.post('/save-changes', {filesPdf: files, id: this.document.id, name: this.document.name }).then((response) => {
                    console.log(response);
                })
                .then(responce => {
                       this.$router.back()
                    })
                .catch(error => {
                        console.log(error)
                    });
            },

            alertError() {
                alert('Name is reqiured');
            }

        }
    }
</script>

<style scoped>
    #file-input {
        margin-top: 10px;
    }

    .button-block {
        text-align: center;
        margin-bottom: 20px;
    }

</style>
