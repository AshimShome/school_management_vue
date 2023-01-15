<template>
    <div class="tab-pane active show" id="website">
        <div class="row justify-content-center">
            <div class="col-xl-6 mb-3">
                <form @submit.prevent="saveSetting('paypal')">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                                <h3>{{ $t("paypal_setting") }}</h3>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form-group mb-3 row">
                                <label for="name" class="form-label col-md-3 col-form-label">
                                    {{ $t("live_mode") }}</label>
                                <div class="col-md-9">
                                    <label class="form-check form-switch">
                                        <input class="form-check-input h-20 w-40" type="checkbox"
                                            v-model="form.paypal_mode"/>
                                    </label>
                                </div>
                            </div>
                            <div class="form-group mb-3 row">
                                <label for="name" class="form-label col-md-3 col-form-label">{{ $t("publisher_key") }}</label>
                                <div class="col-md-9">
                                    <base-input :form="form" field="paypal_key" v-model="form.paypal_key">
                                    </base-input>
                                </div>
                            </div>
                            <div class="form-group mb-3 row">
                                <label for="name" class="form-label col-md-3 col-form-label">{{ $t("secret_key") }}</label>
                                <div class="col-md-9">
                                    <base-input :form="form" field="paypal_secret" v-model="form.paypal_secret">
                                    </base-input>
                                </div>
                            </div>
                            <div class="form-group mb-3 row">
                                <div class="col offset-3">
                                    <button type="submit" class="btn btn-primary">
                                        {{ $t("save") }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-xl-6 mb-3">
                <form @submit.prevent="saveSetting('stripe')">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                                <h3>{{ $t("stripe_setting") }}</h3>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form-group mb-3 row">
                                <label for="name" class="form-label col-md-3 col-form-label">{{ $t("publisher_key") }}</label>
                                <div class="col-md-9">
                                    <base-input :form="form" field="stripe_key" v-model="form.stripe_key">
                                    </base-input>
                                </div>
                            </div>
                            <div class="form-group mb-3 row">
                                <label for="name" class="form-label col-md-3 col-form-label">{{ $t("secret_key") }}</label>
                                <div class="col-md-9">
                                    <base-input :form="form" field="stripe_secret" v-model="form.stripe_secret">
                                    </base-input>
                                </div>
                            </div>
                            <div class="form-group mb-3 row">
                                <div class="col offset-3">
                                    <button type="submit" class="btn btn-primary">
                                        {{ $t("save") }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-xl-6 mb-3">
                <form @submit.prevent="saveSetting('razorpay')">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                                <h3>{{ $t("razorpay_setting") }}</h3>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form-group mb-3 row">
                                <label for="name" class="form-label col-md-3 col-form-label">{{ $t("publisher_key") }}</label>
                                <div class="col-md-9">
                                    <base-input :form="form" field="razorpay_key" v-model="form.razorpay_key">
                                    </base-input>
                                </div>
                            </div>
                            <div class="form-group mb-3 row">
                                <label for="name" class="form-label col-md-3 col-form-label">{{ $t("secret_key") }}</label>
                                <div class="col-md-9">
                                    <base-input :form="form" field="razorpay_secret"
                                        v-model="form.razorpay_secret">
                                    </base-input>
                                </div>
                            </div>
                            <div class="form-group mb-3 row">
                                <div class="col offset-3">
                                    <button type="submit" class="btn btn-primary">
                                        {{ $t("save") }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-xl-6 mb-3">
                <form @submit.prevent="saveSetting('paystack')">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                                <h3>{{ $t("paystack_setting") }}</h3>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form-group mb-3 row">
                                <label for="name" class="form-label col-md-3 col-form-label">{{ $t("publisher_key") }}</label>
                                <div class="col-md-9">
                                    <base-input :form="form" field="paystack_key" v-model="form.paystack_key">
                                    </base-input>
                                </div>
                            </div>
                            <div class="form-group mb-3 row">
                                <label for="name" class="form-label col-md-3 col-form-label">{{ $t("secret_key") }}</label>
                                <div class="col-md-9">
                                    <base-input :form="form" field="paystack_secret"
                                        v-model="form.paystack_secret">
                                    </base-input>
                                </div>
                            </div>
                            <div class="form-group mb-3 row">
                                <label for="name" class="form-label col-md-3 col-form-label">{{ $t("merchant_email") }}</label>
                                <div class="col-md-9">
                                    <base-input :form="form" field="paystack_email"
                                        v-model="form.paystack_email">
                                    </base-input>
                                </div>
                            </div>
                            <div class="form-group mb-3 row">
                                <div class="col offset-3">
                                    <button type="submit" class="btn btn-primary">
                                        {{ $t("save") }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            form: new Form({
                paypal_mode: "",
                paypal_key: "",
                paypal_secret: "",

                stripe_key: "",
                stripe_secret: "",

                razorpay_key: "",
                razorpay_secret: "",

                paystack_key: "",
                paystack_secret: "",
                paystack_email: ""
            })
        };
    },
    async created() {
        this.loadData();
    },
    methods: {
        async saveSetting(provider) {
            try {
                let response = await this.form.put(
                    `/api/setting/payment/${provider}`
                );

                // success message
                this.toastSuccess(response.message);
            } catch (err) {
                this.toastError();
            }
        },
        async loadData() {
            try {
                let { data } = await axios.get("/api/setting/payment");

                this.form.fill(data);
                if (data.paypal_mode == "sandbox") {
                    this.form.paypal_mode = false;
                } else {
                    this.form.paypal_mode = true;
                }
            } catch (err) {
                this.toastError();
            }
        },
        async reset() {
            this.loadData();
        }
    }
};
</script>
