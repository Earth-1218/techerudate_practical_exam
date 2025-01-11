@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">{{ __('OTP Verification') }}</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('verify.otp') }}">
                            @csrf

                            <input type="hidden" name="email" value="{{ session('email') }}">

                            <div class="form-group">
                                <label for="otp">{{ __('Enter OTP') }}</label>
                                <input type="text" name="otp" id="otp"
                                    class="form-control @error('otp') is-invalid @enderror" required>
                                @error('otp')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="d-flex">
                                <div class="mt-3">
                                    <button type="submit" class="btn btn-primary">{{ __('Verify OTP') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
