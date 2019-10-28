<template>
    <div class="form">
        <form @submit.prevent="store">
            <div class="form-group">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" v-model="user.name" v-validate="'required'" id="name" name="name" class="form-control" :class="{ 'is-invalid': submitted && errors.has('name') }" />
                    <div v-if="submitted && errors.has('name')" class="invalid-feedback">{{ errors.first('name') }}</div>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" v-model="user.email" v-validate="'required|email'" id="email" name="email" class="form-control" />
                    <div v-if="submitted && errors.has('email')" class="invalid-feedback">{{ errors.first('email') }}</div>
                </div>
                <div class="form-group">
                    <label for="phone">Phone</label>
                    <input type="text" v-model="user.phone" v-validate="{required:true,regex: /^\(?\d{3}\)?[\- ]?\d{3}[\d\- ]{5}$/}" id="phone" name="phone" class="form-control" />
                    <div v-if="submitted && errors.has('phone')" class="invalid-feedback">{{ errors.first('phone') }}</div>
                </div>
                <div class="form-group">
                    <label for="name">Address</label>
                    <input type="text" v-model="user.address" v-validate id="address" name="address" class="form-control"/>
                    <div v-if="submitted && errors.has('address')" class="invalid-feedback">{{ errors.first('address') }}</div>
                </div>

                <div class="form-group">
                    <label for="name">Zip</label>
                    <input type="text" v-model="user.zip"
                           v-validate="{ regex: /^[0-9]+$/ }" id="zip"
                           name="zip"
                           class="form-control"/>
                    <div v-if="submitted && errors.has('zip')"
                         class="invalid-feedback">{{ errors.first('zip') }}</div>
                </div>

                <img class="img-thumbnail" v-if="photoPrev" v-bind:src="photoPrev" alt="">

                <div class="form-group">
                    <div class="custom-file">
                        <input accept="image/x-png,image/gif,image/jpeg"
                               @change="changePhoto($event)"
                               type="file" class="custom-file-input" id="photo">
                        <label class="custom-file-label" for="photo">Choose photo</label>
                    </div>
                    <div v-if="submitted && errors.has('photo')"
                         class="invalid-feedback">{{ errors.first('photo') }}</div>
                </div>
                <div class="form-group">
                    <div class="custom-file">
                        <input :value="files.file"
                               @change="changeFile($event)"
                               type="file"
                               class="custom-file-input" id="file">
                        <label class="custom-file-label" for="file">Choose file</label>
                    </div>
                    <div v-if="submitted && errors.has('file')"
                         class="invalid-feedback">{{ errors.first('file') }}</div>
                </div>

                <div class="form-group">
                    <button class="btn btn-primary">Register</button>
                </div>
            </div>
        </form>

    </div>
</template>

<script>
    export default {
        data () {
            return {
                user: {
                    name:   '',
                    email:  '',
                    phone:  '',
                    address:'',
                    zip:    '',
                },
                files:{
                    photo:  null,
                    file:   null
                },
                photoPrev:  null,
                submitted:  false
            }
        },
        methods:{
            changeFile(e){
                if (e.target.files[0]){
                    this.files.file = e.target.files[0];
                }
            },
            changePhoto(e){
                if (e.target.files[0]){
                    this.files.photo = e.target.files[0];
                    let reader  = new FileReader();
                    reader.addEventListener("load", function () {
                        this.photoPrev = reader.result;
                    }.bind(this), false);
                    reader.readAsDataURL(this.files.photo);
                }
            },
            store(e){
                this.submitted = true;
                this.$validator.validate().then(valid => {
                    if (valid) {
                        let data = new FormData();
                        for (let key in this.user) {
                            data.set(key,this.user[key])
                        }
                        for (let key in this.files) {
                            data.append(key,this.files[key])
                        }
                        axios.post('',data).then(res=>{
                            alert('Success');
                        }).catch(err => {
                            this.$setLaravelValidationErrorsFromResponse(err.response.data);
                        })
                    }
                });
            }
        }
    };
</script>
