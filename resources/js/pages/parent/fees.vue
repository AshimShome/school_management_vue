<template>
    <div>
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <h2 class="page-title">{{ $route.meta.title }}</h2>
                    <h2 class="page-pretitle">{{ $t('fee') }}</h2>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <div class="d-flex">
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-12 mt-3">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title">{{ $t('fees') }}</h2>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr class="text-center">
                                    <th>{{ $t('student') }}</th>
                                    <th>{{ $t('fee_type') }}</th>
                                    <th>{{ $t('amount') }}</th>
                                    <th>{{ $t('status') }}</th>
                                    <th>{{ $t('due_date') }}</th>
                                    <th>{{ $t('paid_date') }}</th>
                                    <th width="15%">{{ $t('action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="fee in fees" :key="fee.id">
                                    <td class="text-center">
                                        <a href="#">{{ fee.student_name }}</a>
                                        <p class="mt-0 pt-0">
                                            <b>{{ $t('class') }}:</b> {{ fee.class_name }} <br>
                                            <b>{{ $t('section') }}:</b> {{ fee.section_name }}
                                        </p>
                                    </td>
                                    <td class="text-center">{{ fee.fee_type }}</td>
                                    <td class="text-center">{{ appCurrency(fee.amount) }}</td>
                                    <td class="text-center">
                                        <span class="badge bg-success" v-if="fee.status">{{ $t('paid') }}</span>
                                        <span class="badge bg-danger" v-else>{{ $t('unpaid') }}</span>
                                    </td>
                                    <td class="text-center">{{ formateDate(fee.due_date) }}</td>
                                    <td class="text-center">{{ fee.pay_date ? formateDate(fee.pay_date):'-' }}</td>
                                    <td class="text-center">
                                        <a href="#" class="btn btn-success" v-if="fee.status">Paid</a>
                                        <a :href="`/payment/${fee.id}/fee`" class="btn btn-primary" v-else>{{ $t('pay_now') }}</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- <div v-else class="d-flex justify-content-center py-3">
                <NotFound word="class routine" />
            </div> -->
        </div>
    </div>
</template>

<script>
import dayjs from "dayjs";
import NotFound from "../../components/NotFound.vue";
import ButtonLoading from "../../components/ButtonLoading.vue";
import { mapGetters } from "vuex";
export default {
    components: {
        NotFound,
        ButtonLoading
    },
    computed: {
        ...mapGetters({
            user: "auth/user",
            childs: "parent/getChilds"
        })
    },
    data() {
        return {
            fees: []
        };
    },
    async created() {
        if (this.userRole != "Guardian") {
            this.redirect("401");
        }
        let response = await axios.get("/api/parent/fees");
        this.fees = response.data.data;
    }
};
</script>
