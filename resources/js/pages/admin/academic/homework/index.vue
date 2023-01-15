<template>
    <div>
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <h2 class="page-title">{{ $t("homework") }}</h2>
                    <h2 class="page-pretitle">{{ $t("academic") }}</h2>
                </div>
                <div class="col-auto ms-auto d-print-none" v-if="checkPermission('homework-create')">
                    <div class="d-flex">
                        <router-link :to="{ name: 'academic-homework-create' }" class="btn btn-primary btn-outline">
                            <icon-plus></icon-plus>
                            {{ $t("create") }}
                        </router-link>
                    </div>
                </div>
            </div>
        </div>
        <div class="row row-cards mt-2">
            <div class="col-12">
                <div class="row justify-content-center">
                    <div class="col-md-3">
                        <select v-model="searchForm.class_id" class="form-control" @change="loadSections">
                            <option value="" class="d-none">{{ $t("select_class") }}</option>
                            <option v-for="singleClass in classes" :key="singleClass.id" :value="singleClass.id">
                                {{ singleClass.name }}
                            </option>
                        </select>
                    </div>
                    <div class="col-md-3" v-if="searchForm.class_id">
                        <select v-model="searchForm.section_id" class="form-control">
                            <option value="" class="d-none">
                                {{ $t("select_section") }}
                            </option>
                            <option v-for="section in sections" :key="section.id" :value="section.id">
                                {{ section.name }}
                            </option>
                        </select>
                    </div>
                    <div class="col-md-3" v-if="searchForm.class_id && searchForm.section_id">
                        <button :disabled="searchButtonDisabled" @click="getHomework"
                            class="btn btn-primary btn-outline">
                            {{ $t("get_homework") }}
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-xl-12">
                <div class="card" v-if="homeworks && homeworks.length">
                    <div class="card-header">
                        <h3 class="card-title">{{ $t("homework") }}</h3>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-vcenter">
                            <thead>
                                <tr>
                                    <th colspan="3">{{ $t("teacher") }}</th>
                                    <th colspan="2">{{ $t("subject") }}</th>
                                    <th colspan="4">{{ $t("date") }}</th>
                                    <th colspan="3">{{ $t("action") }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="homework in homeworks" :key="homework.id">
                                    <td colspan="3" v-if="homework.teacher">
                                        {{ homework.teacher.user.name }}
                                    </td>
                                    <td colspan="2">
                                        {{ homework.subject.name }}
                                        </td>
                                    <td colspan="4">
                                        {{ formateDate(homework.start_date) }} -
                                        {{ formateDate(homework.end_date) }}
                                    </td>
                                    <td colspan="3">
                                        <router-link :to="{ name: 'academic-homework-edit', params: { id: homework.id } }" class="btn btn-primary">
                                            {{ $t('edit') }}
                                        </router-link>
                                        <DeleteButton :id="homework.id" @delete-data="deleteHomework" />
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div v-else class="d-flex justify-content-center py-3">
                    <NotFound word="homework" />
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
table tbody tr td {
    white-space: nowrap;
}
</style>

<script>
import { mapGetters } from "vuex";

export default {
    components: {
        DeleteButton: () =>
            import("../../../../components/DeleteConfirmation.vue")
    },
    data() {
        return {
            searchForm: {
                class_id: "",
                section_id: ""
            },

            sections: [],
            homeworks: []
        };
    },
    methods: {
        async loadSections() {
            try {
                const response = await axios.get(
                    `/api/classes/${this.searchForm.class_id}/sections`
                );
                this.sections = response.data.sections;
            } catch (error) {
                this.toastError(error.response.data.message);
                console.log(error);
            }
        },
        async loadHomeworks() {
            await this.$store.dispatch("homework/fetchHomeworks");
        },
        async getHomework() {
            try {
                const response = await axios.get(`/api/homeworks`, {
                    params: {
                        class_id: this.searchForm.class_id,
                        section_id: this.searchForm.section_id
                    }
                });

                this.homeworks = response.data;
            } catch (error) {
                this.toastError(error.response.data.message);
                console.log(error);
            }
        },
        async deleteHomework(id) {
            try {
                const response = await axios.delete(`/api/homeworks/${id}`);
                this.toastSuccess(response.data.message);
                this.homeworks = this.homeworks.filter(
                    homework => homework.id != id
                );
            } catch (error) {
                this.toastError(error.response.data.message);
                console.log(error);
            }
        }
    },
    computed: {
        ...mapGetters({
            classes: "classs/classes"
        }),
        homeworks() {
            return this.$store.state.homework.homeworks;
        },
        searchButtonDisabled() {
            return (
                this.searchForm.class_id == "" ||
                this.searchForm.section_id == ""
            );
        }
    },
    created() {
        this.hasPermisssion("homework-list");
        this.loadHomeworks();
        this.$store.dispatch("classs/fetchClasses");
    }
};
</script>
