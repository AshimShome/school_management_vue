<template>
    <div class="col-xl-4 col-lg-6 col-md-6 mb-3">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{ $t("about_me") }}</h3>
            </div>
            <div class="card-body p-4 text-center border-bottom py-3 table-responsive">
                <Loader v-if="loading"/>
                <template v-else>
                    <span class="avatar avatar-xl mb-3 avatar-rounded"
                        :style="{ backgroundImage: `url(${userdetails.image_url})` }"></span>
                    <table class="table table-vcenter">
                        <tbody>
                            <tr v-if="userdetails.student">
                                <th width="20%">{{ $t("name") }}</th>
                                <td width="80%">{{ userdetails.name }}</td>
                            </tr>
                            <tr v-if="userdetails.student">
                                <th width="20%">{{ $t("email") }}</th>
                                <td width="80%">{{ userdetails.email }}</td>
                            </tr>
                            <tr v-if="userdetails.student">
                                <th width="20%">{{ $t("class") }}</th>
                                <td width="80%">{{ userdetails.student.classs.name }}</td>
                            </tr>
                            <tr v-if="userdetails.student">
                                <th width="20%">{{ $t("section") }}</th>
                                <td width="80%">{{ userdetails.student.section.name }}</td>
                            </tr>
                            <tr v-if="userdetails.student">
                                <th width="20%">{{ $t("roll_no") }}</th>
                                <td width="80%">{{ userdetails.student.roll_no }}</td>
                            </tr>
                            <tr v-if="userdetails.student">
                                <th width="20%">{{ $t("parent") }}</th>
                                <td width="80%">{{ userdetails.student.guardian.user.name }}</td>
                            </tr>
                            <tr v-if="userdetails.student">
                                <th width="20%">{{ $t("occupation") }}</th>
                                <td width="80%">{{ userdetails.student.guardian.occupation }}</td>
                            </tr>
                            <tr v-if="userdetails.student">
                                <th width="20%">{{ $t("blood") }}</th>
                                <td width="80%">{{ userdetails.student.blood_group }}</td>
                            </tr>
                            <tr v-if="userdetails.student">
                                <th width="20%">{{ $t("admitted") }}</th>
                                <td width="80%">{{ userdetails.student.admission_date ? userdetails.student.admission_date : "N/A" }}</td>
                            </tr>
                            <tr v-if="userdetails.student">
                                <th width="20%">{{ $t("gender") }}</th>
                                <td width="80%">{{ userdetails.student.gender ? userdetails.student.gender : "N/A" }}</td>
                            </tr>
                        </tbody>
                    </table>
                </template>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                userdetails: "",
                loading: false,
            };
        },
        async mounted() {
            this.loading = true;
            let response = await axios.get("/api/users/details");
            this.userdetails = response.data;
            console.log(this.userdetails)
            this.loading = false;
        },
    };
</script>
