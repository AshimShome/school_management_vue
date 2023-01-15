<template>
    <div class="row">
        <div class="col-12 col-md-4 mb-3">
            <div class="card">
                <div class="card-body p-4 text-center" v-if="userData">
                    <span class="avatar avatar-xl mb-3 avatar-rounded"
                        :style="{ backgroundImage: `url(${userData.image_url})` }"></span>
                    <h2 class="m-0 mb-1">
                        <a href="#">{{ userData.name }}</a>
                    </h2>
                    <h3 class="m-0 mb-1">
                        <a href="#">{{ userData.email }}</a>
                    </h3>
                    <div class="badge badge-primary">
                        {{ formateDate(userData.created_at) }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ $t("profile_settings") }}</h3>
                </div>
                <div class="card-body">
                    <form @submit.prevent="profileUpdate">
                        <div class="form-group mb-3 row">
                            <label class="form-label col-3 col-form-label">{{
                $t("name")
              }}</label>
                            <div class="col">
                                <input v-model="profileForm.name" type="text"
                                    :class="{ 'is-invalid': profileForm.errors.has('name') }" class="form-control"
                                    :placeholder="$t('enter_name')" />
                                <has-error :form="profileForm" field="name"></has-error>
                            </div>
                        </div>
                        <div class="form-group mb-3 row">
                            <label class="form-label col-3 col-form-label">{{
                $t("email")
              }}</label>
                            <div class="col">
                                <input v-model="profileForm.email" type="email"
                                    :class="{ 'is-invalid': profileForm.errors.has('email') }" class="form-control"
                                    :placeholder="$t('enter_email')" />
                                <has-error :form="profileForm" field="email"></has-error>
                            </div>
                        </div>
                        <div class="form-group mb-3 row">
                            <label class="form-label col-3 col-form-label">{{
                $t("image")
              }}</label>
                            <div class="col">
                                <input @change="onImageChange"
                                    :class="{ 'is-invalid': profileForm.errors.has('image') }" type="file"
                                    class="form-control" accept="image/png, image/jpeg, image/jpg" />
                            </div>
                        </div>
                        <div class="form-footer">
                            <button :disabled="profileForm.busy" type="submit" class="btn btn-primary">
                                {{ $t("update_profile") }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <ChangePassword />
        </div>
    </div>
</template>

<script>
import ChangePassword from "./ChangePassword.vue";
import { serialize } from "object-to-formdata";

export default {
    components: {
        ChangePassword
    },
    data() {
        return {
            profileForm: new Form({
                name: "",
                email: "",
                image: ""
            }),
            userData: {}
        };
    },
    methods: {
        async profileUpdate() {
            const response = await this.profileForm.post(
                `/api/user/profile/update`,
                {
                    transformRequest: [
                        function(data) {
                            return serialize(data);
                        }
                    ]
                }
            );

            if (this.profileForm.image) {
                window.location.reload();
            } else {
                await this.loadData();
            }

            this.toastSuccess(response.message);
        },
        onImageChange(e) {
            // this.profileForm.image = e.target.files[0];

            var file = e.target.files[0];
            var reader = new FileReader();
            reader.onload = () => {
                this.profileForm.image = reader.result;
                console.log(reader.result);
            };
            reader.readAsDataURL(file);
        },
        async loadData() {
            let response = await axios.get("/api/users/authuser-details");
            this.userData = response.data;
        }
    },
    async mounted() {
        await this.loadData();
        this.profileForm.name = this.userData.name;
        this.profileForm.email = this.userData.email;
    }
};
</script>
