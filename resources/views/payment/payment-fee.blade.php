<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ asset('/css/tabler.min.css') }}">
    <title>{{ __('sms.payment') }}</title>
</head>

<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                @if (session()->has('error'))
                    <div class="alert alert-danger">
                        {{ session()->get('error') }}
                    </div>
                @endif
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="card-title">
                            <h2>
                                {{ __('sms.fee_details') }}
                            </h2>
                        </div>
                        <a href="{{ url()->previous() }}" class="btn btn-primary">{{ __('sms.back') }}</a>
                    </div>
                    <div class="card-body">
                        <h1>{{ $fee->student->user->name }}</h1>
                        <h4>
                            <b>{{ __('sms.class') }} :</b> {{ $fee->class->name }} <br>
                            <b>{{ __('sms.section') }} :</b> {{ $fee->section->name }} <br>
                            <b>{{ __('sms.fee_type') }}:</b> {{ $fee->type->name }} <br>
                            <b>{{ __('sms.amount') }}:</b> {{ $fee->amount }} <br>
                            <b>{{ __('sms.due_date') }}:</b>
                            {{ Carbon\Carbon::parse($fee->due_date)->format('d M, Y') }} <br>
                            <b>{{ __('sms.status') }}:</b> <span>{{ $fee->status ? 'Paid' : 'Unpaid' }}</span>
                            <br>
                            @if ($fee->description)
                                <b>{{ __('sms.description') }}:</b> {{ $fee->description }}
                            @endif
                        </h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            @php
                $paypal_mode = env('PAYPAL_MODE') == 'sandbox' ? 0 : 1;
                $paypal_active = $paypal_mode ? env('PAYPAL_LIVE_CLIENT_ID') && env('PAYPAL_LIVE_CLIENT_SECRET') : env('PAYPAL_SANDBOX_CLIENT_ID') && env('PAYPAL_SANDBOX_CLIENT_SECRET');
                $stripe_active = env('STRIPE_KEY') && env('STRIPE_SECRET');
                $razorpay_active = env('RAZORPAY_KEY') && env('RAZORPAY_SECRET');
                $paystack_active = env('PAYSTACK_PUBLIC_KEY') && env('PAYSTACK_SECRET_KEY') && env('PAYSTACK_PAYMENT_URL');
            @endphp
            {{-- Paypal Payment --}}

            @if ($paypal_active)
                <div class="col-md-6 my-3">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">{{ __('sms.paypal') }}</div>
                        </div>
                        <div class="card-body">
                            <p class="card-text">{{ __('sms.paypal_description') }}</p>
                            <button onclick="pay('paypal')" class="btn btn-primary">Pay Now</button>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Stripe Payment --}}
            @if ($stripe_active)
                <div class="col-md-6 my-3">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">{{ __('sms.stripe') }}</div>
                        </div>
                        <div class="card-body">
                            <p class="card-text">{{ __('sms.stripe_description') }}</p>
                            <button onclick="pay('stripe')" class="btn btn-primary">Pay Now</button>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Razorpay Payment --}}
            @if ($razorpay_active)
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">{{ __('sms.razorpay') }}</div>
                        </div>
                        <div class="card-body">
                            <p class="card-text">{{ __('sms.razorpay_description') }}</p>
                            <button onclick="pay('razorpay')" class="btn btn-primary">Pay Now</button>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Paystack Payment --}}
            @if ($paystack_active)
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">{{ __('sms.paystack') }}</div>
                        </div>
                        <div class="card-body">
                            <p class="card-text">{{ __('sms.paystack_description') }}</p>
                            <button onclick="pay('paystack')" class="btn btn-primary">Pay Now</button>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>


    {{-- Paypal Form --}}
    <form action="{{ route('paypal.post') }}" method="POST" class="d-none" id="paypal-form">
        @csrf
        <input type="hidden" name="amount" value="{{ $fee->amount }}">
        <input type="hidden" name="fee_id" value="{{ $fee->id }}">
    </form>

    {{-- Stripe Form --}}
    <form action="{{ route('stripe.post') }}" method="POST" class="d-none">
        @csrf
        <input type="hidden" name="amount" value="{{ $fee->amount }}">
        <input type="hidden" name="fee_id" value="{{ $fee->id }}">

        <script id="stripe_script" src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                data-key="{{ env('STRIPE_KEY') }}" data-amount="{{ $fee->amount * 100 }}"
                data-name="{{ env('APP_NAME') }}" data-description="Money pay with stripe" data-locale="auto"
                data-currency="usd">
        </script>
    </form>

    {{-- Razorpay Form --}}
    <form action="{{ route('razorpay.post') }}" method="POST" class="d-none">
        @csrf
        <input type="hidden" name="amount" value="{{ $fee->amount }}">
        <input type="hidden" name="fee_id" value="{{ $fee->id }}">

        <script id="razor_script" src="https://checkout.razorpay.com/v1/checkout.js" data-key="{{ env('RAZORPAY_KEY') }}"
                data-amount="{{ $fee->amount * 100 }}" data-buttontext="Pay with Razorpay"
                data-name="{{ env('APP_NAME') }}" data-description="Money pay with rozerpay"
                data-prefill.name="{{ auth()->user()->name }}" data-prefill.email="{{ auth()->user()->email }}"
                data-theme.color="#2980b9" data-currency="USD">
        </script>
    </form>

    {{-- paystack_btn Form --}}
    <form action="{{ route('paystack.post') }}" method="POST" class="d-none" id="paystack-form">
        @csrf
        <input type="hidden" name="amount" value="{{ $fee->amount }}">
        <input type="hidden" name="fee_id" value="{{ $fee->id }}">
    </form>

    <script src="{{ asset('/js/bootstrap.bundle.min.js') }}"></script>
    <script>
        function pay(method) {
            switch (method) {
                case 'paypal':
                    document.getElementById("paypal-form").submit();
                    break;
                case 'stripe':
                    document.querySelector('.stripe-button-el').click();
                    break;
                case 'razorpay':
                    document.querySelector(".razorpay-payment-button").click();
                    break;
                case 'paystack':
                    document.getElementById("paystack-form").submit();
                    break;
            }
        }
    </script>
</body>

</html>
