
    <div>
        <div class="form-group">
            <router-link :to="{name: 'createCompany'}" class="btn btn-success">Create new faq</router-link>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">Companies list</div>
            <div class="panel-body">
                <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Website</th>
                    <th>Email</th>
                    <th width="100"> </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="faq, index in faqs">
                        <td>{{ faq.name }}</td>
                        <td>{{ faq.address }}</td>
                        <td>{{ faq.website }}</td>
                        <td>{{ faq.email }}</td>
                        <td>
                            <router-link :to="{name: 'editCompany', params: {id: faq.id}}" class="btn btn-xs btn-default">
                                Edit
                            </router-link>
                            <a href="#" class="btn btn-xs btn-danger" v-on:click="deleteEntry(faq.id, index)">
                                Delete
                            </a>
                        </td>
                    </tr>
                </tbody>
                </table>
            </div>
        </div>
    </div>

<script>
    export default {
        data: function () {
            return {
                faqs: []
            }
        },
        mounted() {
            var app = this;
            axios.get('/api/faqs')
                .then(function (resp) {
                    app.faqs = resp.data;
                })
                .catch(function (resp) {
                    console.log(resp);
                    alert("Could not load faqs");
                });
        },
        methods: {
            deleteEntry(id, index) {
                if (confirm("Do you really want to delete it?")) {
                    var app = this;
                    axios.delete('/api/faqs/' + id)
                        .then(function (resp) {
                            app.faqs.splice(index, 1);
                        })
                        .catch(function (resp) {
                            alert("Could not delete faq");
                        });
                }
            }
        }
    }
</script>