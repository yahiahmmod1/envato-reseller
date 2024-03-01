@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>
                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">

                            <label style="    padding-right: 19px;" for="email" class="col-md-4 col-form-label text-md-end">{{ __('Whatsapp Number') }}
                                <span  class="" data-bs-toggle="popover" title="Why whatsapp ?"  data-bs-trigger="hover "
                                       data-bs-content="সম্মানিত ইউজার,
হরহামেশাই আইডি/পেইজ/হোয়াটসঅ্যাপ ডিজেবল জনিত ইস্যুস হয়ে থাকে, এই ধরণের যেকোনো সমস্যায় যেন আমরা আপনাকে খুব সহজেই খোঁজে পেতে পারি সেই লক্ষেই আপনার হোয়াটসঅ্যাপ নাম্বারটি নিয়ে রাখা। পাব্লিকলি শেয়ার করার উদ্দেশ্যে নয়। তাই নিচিন্তে আপনার হোয়াটসঅ্যাপ নাম্বারটি দিতে পারেন।

এছাড়াও নিচের দেয়া টেলিগ্রাম গ্রুপে জয়েন এবং আমাদের অফিসিয়াল হোয়াটসঅ্যাপ নাম্বারটিও রেখে দিতে পারেন। এই ক্ষেত্রে পাশে থাকা (?) চিহ্নটিতে ক্লিক করলেই নাম্বারটি কপি হয়ে যাবে।


☎ WhatsApp (Admin): 01882-658934
💠Telegram channel: https://t.me/digitaltoolsbd ">
                                    <img src="{{asset('images/red.png')}}" alt="whatsapp"

                                         style="     width: 24px;
    margin-left: 1px;
    margin-right: -10px;" onclick="myFunction()" />
                                </span>
                            </label>
                            <div class="col-md-6">
                                <input id="whatsapp" type="text" class="form-control @error('whatsapp') is-invalid @enderror" name="whatsapp" value="{{ old('whatsapp') }}" required autocomplete="whatsapp">
                                @error('whatsapp')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>
                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


    <script>
        function myFunction() {
            navigator.clipboard.writeText("01882658934");
            alert("Copied  01882-658934");
        }
    </script>


@endsection
