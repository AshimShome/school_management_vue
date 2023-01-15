<template>
    <div>
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col-12">
                    <h2 class="page-title">{{ $route.meta.title }}</h2>
                    <h2 class="page-pretitle">{{ $t('homework') }}</h2>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="row justify-content-center">
                    <div class="col-lg-2 col-sm-3 col-6">
                        <date-picker :value="searchForm.date" maximum-view="year" format="dd MMMM, yyyy"
                            @input="setDate($event)" input-class="form-control text-center" :placeholder="$t('select_date')" />
                        <has-error :form="searchForm" field="date" class="d-block"></has-error>
                    </div>
                    <div class="col-6 col-sm-3 col-lg-2">
                        <button :disabled="searchButtonDisabled" @click="getHomeworks"
                            class="btn btn-primary btn-outline">
                            {{ $t('get_homework') }}
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-12 mt-3">
                <div class="card" v-if="homeworks && homeworks.length">
                    <div class="card-header">
                        <h3 class="card-title">{{ $t('homework') }}</h3>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>{{ $t('teacher') }}</th>
                                    <th>{{ $t('subject') }}</th>
                                    <th>{{ $t('date') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="homework in homeworks" :key="homework.id">
                                    <td v-if="homework.teacher">
                                        {{ homework.teacher.user.name }}
                                    </td>
                                    <td>{{ homework.subject.name }}</td>
                                    <td>
                                        {{ formateDate(homework.start_date) }} -
                                        {{ formateDate(homework.end_date) }}
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

<script>
import dayjs from "dayjs";

export default {
    components: {
        NotFound: () => import("../../components/NotFound.vue")
    },
    computed: {
        searchButtonDisabled() {
            return this.searchForm.date == "";
        }
    },
    data() {
        return {
            searchForm: {
                date: ""
            },

            homeworks: []
        };
    },
    methods: {
        setDate(event) {
            let date = dayjs(event).format("YYYY-MM-DD");
            this.searchForm.date = date;
        },
        async getHomeworks() {
            try {
                const response = await axios.get(`/api/student/homeworks`, {
                    params: {
                        date: this.searchForm.date
                    }
                });

                this.homeworks = response.data;
            } catch (error) {
                this.toastError(error.response.data.message);
                console.log(error);
            }
        }
    },
    created() {
        if (this.userRole != "Student") {
            this.redirect("401");
        }
        this.searchForm.date = dayjs(new Date()).format("YYYY-MM-DD");
        this.getHomeworks();
    }
};
</script>
