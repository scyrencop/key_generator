<div class="form-group">
    <router-link to="/" class="btn btn-default">Back</router-link>
</div>

<div class="panel panel-default">
    <div class="panel-heading">Create new faq</div>
    <div class="panel-body">
        <form v-on:submit="saveForm()">
            <div class="row">
                <div class="col-xs-12 form-group">
                    <label class="control-label">Company name</label>
                    <input type="text" v-model="faq.name" class="form-control">
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    <label class="control-label">Company address</label>
                    <input type="text" v-model="faq.address" class="form-control">
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    <label class="control-label">Company website</label>
                    <input type="text" v-model="faq.website" class="form-control">
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    <label class="control-label">Company email</label>
                    <input type="text" v-model="faq.email" class="form-control">
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    <button class="btn btn-success">Create</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    export default {
        data: function () {
            return {
                faq: {
                    name: '',
                    address: '',
                    website: '',
                    email: '',
                }
            }
        },
        methods: {
            saveForm() {
                event.preventDefault();
                var app = this;
                var newCompany = app.faq;
                axios.post('/api/v1/faqs', newCompany)
                    .then(function (resp) {
                        app.$router.push({path: '/'});
                    })
                    .catch(function (resp) {
                        console.log(resp);
                        alert("Could not create your faq");
                    });
            }
        }
    }
</script>