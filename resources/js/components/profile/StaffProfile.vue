<template>
    <div class="row">
        <div class="col-12 col-md-4 mb-3">
            <div class="card">
                <div class="card-body p-4 text-center" v-if="userData.user">
                    <span class="avatar avatar-xl mb-3 avatar-rounded"
                        :style="{ backgroundImage: `url(${userData.user.image_url})` }"></span>
                    <h2 class="m-0 mb-1">
                        <a href="#">{{ userData.user.name }}</a>
                    </h2>
                    <h3 class="m-0 mb-1">
                        <a href="#">{{ userData.user.email }}</a>
                    </h3>

                    <table class="table">
                        <tbody>
                            <tr v-if="userData.department">
                                <th>{{ $t("department") }}</th>
                                <td>
                                    {{
                    userData.department.name ? userData.department.name : "-"
                  }}
                                </td>
                            </tr>
                            <tr>
                                <th>{{ $t("phone") }}</th>
                                <td>{{ userData.phone ? userData.phone : "-" }}</td>
                            </tr>
                            <tr>
                                <th>{{ $t("religion") }}</th>
                                <td>{{ userData.religion ? userData.religion : "-" }}</td>
                            </tr>
                            <tr>
                                <th>{{ $t("gender") }}</th>
                                <td>{{ userData.gender ? userData.gender : "-" }}</td>
                            </tr>
                            <tr>
                                <th>{{ $t("joining_date") }}</th>
                                <td>{{ formateDate(userData.joining_date) }}</td>
                            </tr>
                        </tbody>
                    </table>
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
                        <div class="form-group mb-3 row">
                            <label class="form-label col-3 col-form-label">{{
                $t("phone")
              }}</label>
                            <div class="col">
                                <base-input :form="profileForm" field="phone" v-model="profileForm.phone" />
                            </div>
                        </div>
                        <div class="form-group mb-3 row">
                            <label class="form-label col-3 col-form-label">{{
                $t("religion")
              }}</label>
                            <div class="col">
                                <base-select :form="profileForm" field="religion" v-model="profileForm.religion">
                                    <option :selected="profileForm.religion == 'muslim'" value="muslim">
                                        {{ $t("muslim") }}
                                    </option>
                                    <option :selected="profileForm.religion == 'hindu'" value="hindu">
                                        {{ $t("hindu") }}
                                    </option>
                                    <option :selected="profileForm.religion == 'buddha'" value="buddha">
                                        {{ $t("buddha") }}
                                    </option>
                                    <option :selected="profileForm.religion == 'christian'" value="christian">
                                        {{ $t("christian") }}
                                    </option>
                                </base-select>
                            </div>
                        </div>
                        <div class="form-group mb-3 row">
                            <label class="form-label col-3 col-form-label">{{
                $t("bio")
              }}</label>
                            <div class="col">
                                <base-textarea :rows="5" :form="profileForm" field="bio" v-model="profileForm.bio" />
                            </div>
                        </div>
                        <div class="form-group mb-3 row">
                            <label class="form-label col-3 col-form-label">{{
                $t("present_address")
              }}</label>
                            <div class="col">
                                <base-textarea :rows="5" :form="profileForm" field="present_address"
                                    v-model="profileForm.present_address" />
                            </div>
                        </div>
                        <div class="form-group mb-3 row">
                            <label class="form-label col-3 col-form-label">{{
                $t("permanent_address")
              }}</label>
                            <div class="col">
                                <base-textarea :rows="5" :form="profileForm" field="permanent_address"
                                    v-model="profileForm.permanent_address" />
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
    import {
        serialize
    } from "object-to-formdata";

    export default {
        components: {
            ChangePassword,
        },
        data() {
            return {
                userData: {},
                profileForm: new Form({
                    name: "",
                    email: "",
                    image: "",
                    religion: "",
                    phone: "",
                    bio: "",
                    gender: "",
                    present_address: "",
                    permanent_address: "",
                }),
            };
        },
        methods: {
            async profileUpdate() {
                const response = await this.profileForm.post(`/api/user/profile/update`, {
                    transformRequest: [
                        function (data) {
                            return serialize(data);
                        },
                    ],
                });

                if (this.profileForm.image) {
                    window.location.reload();
                } else {
                    await this.loadData();
                }

                this.toastSuccess(response.message);
            },
            onImageChange(e) {
                this.profileForm.image = e.target.files[0];
            },
            async loadData() {
                let response = await axios.get("/api/users/authuser-details");
                this.userData = response.data;
            },
        },
        async mounted() {
            await this.loadData();
            this.profileForm.fill(this.userData);
            this.profileForm.name = this.userData.user.name;
            this.profileForm.email = this.userData.user.email;
        },
    };
</script>
