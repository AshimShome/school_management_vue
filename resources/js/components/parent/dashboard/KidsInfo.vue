<template>
    <div class="col-md-6 col-lg-6 col-xl-4">
        <div class="card mb-2">
            <div class="card-header d-flex justify-content-between">
                <div class="card-title">
                    <h3>{{ $t("my_kids") }}</h3>
                </div>
            </div>
            <div class="card-body card-body-scrollable card-body-scrollable-shadow">
                 <Loader v-if="loading"/>
                 <template v-else>
                    <div class="card mb-3" v-for="kid in kidsInfo" :key="kid.id">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div class="info">
                                    <h3 class="text-primary">{{ kid.name }}</h3>
                                    <p>{{ kid.email }}</p>
                                </div>
                                <div class="ms-auto">
                                    <img width="100px" :src="kid.image" alt="" />
                                </div>
                            </div>
                            <hr />
                            <div class="info-body">
                                <div class="d-flex justify-content-between flex-md-column flex-row mb--15">
                                    <table>
                                        <tr>
                                            <th width="20%">{{ $t("roll_no") }}:</th>
                                            <td>{{ kid.roll_no }}</td>
                                        </tr>
                                        <tr>
                                            <th width="20%">{{ $t("section") }}:</th>
                                            <td>{{ kid.section }}</td>
                                        </tr>
                                        <tr>
                                            <th width="20%">{{ $t("class") }}:</th>
                                            <td>{{ kid.class }}</td>
                                        </tr>
                                    </table>
                                    <table>
                                        <tr>
                                            <th width="20%">{{ $t("admitted") }}:</th>
                                            <td>
                                                {{
                            kid.admission_date
                            ? formateDate(kid.admission_date)
                            : "N/A"
                        }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th width="20%">{{ $t("gender") }}:</th>
                                            <td>{{ kid.gender ? kid.gender : "N/A" }}</td>
                                        </tr>
                                        <tr>
                                            <th width="20%">{{ $t("blood") }}:</th>
                                            <td>{{ kid.blood_group ? kid.blood_group : "N/A" }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                 </template>
            </div>
        </div>
    </div>
</template>

<style scoped>
.mb--15 {
    margin-botttom: -15px
}
</style>

<script>
    export default {
        data() {
            return {
                kidsInfo: [],
                loading: false,
            };
        },
        async created() {
            this.loading = true;
            let response = await axios.get("/api/parent/students/details");
            this.kidsInfo = response.data.data;
            this.loading = false;
        },
    };
</script>
