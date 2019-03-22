<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="button-block">
                    <button class="btn btn-success" @click="$router.push('/edit/0')">Add new document</button>
                </div>
                <div class="card">
                    <div class="card-header">Documents</div>

                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th scope="col">Name</th>
                                <th scope="col"></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="document in documents">
                                <td class="links">
                                    <router-link :to="{path: '/edit/' + document.id}">
                                        {{document.name}}
                                    </router-link>
                                    <!--<a target="_blank" :href="'/document/' + document.id">{{document.name}}</a>-->
                                </td>
                                <td class="icons">
                                    <i class="fas fa-clone" @click="copyDocument(document.id)"></i>
                                    <router-link :to="{path: '/edit/' + document.id}">
                                        <i class="fas fa-edit"></i>
                                    </router-link>

                                    <i class="fas fa-trash" @click="deleteDocument(document.id)"></i>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted: function() {
            this.getDocuments()
        },
        data: function() {
            return {
                documents: []
            }
        },
        methods: {
            getDocuments: function() {
                axios.get('/get-documents').then((response) => {
                    this.documents = response.data.documents
                })
            },

            copyDocument: function(id) {
                axios.post('/copy-document' , {id: id}).then((response) => {
                    for (let doc of this.documents) {
                        if (doc.id == id) {
                            this.documents.push(doc);
                            return;
                        }
                    }
                })
            },

            deleteDocument: function(id) {
                axios.delete('/delete-document' , { data: {id: id}}).then((response) => {
                    for (let doc of this.documents) {
                        if (doc.id == id) {
                            let index = this.documents.indexOf(doc);
                            this.documents.splice(index, 1);
                            return;
                        }
                    }
                })
            }
        }
    }
</script>

<style scoped>
    .button-block {
        text-align: center;
        margin-bottom: 20px;
    }

    .icons {
        text-align: right;
    }

    .icons  a:link {
         color: black;
    }

    .icons  a:visited {
        color: black;
    }

    .fas {
        margin-left: 10px;
        cursor: pointer
    }

    .links > a {
        color: black!important;
        font-size: 13px;
        font-weight: 600;
        letter-spacing: .1rem;
        text-decoration: none;
    }

</style>
