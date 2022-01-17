@extends('layouts.app')

@section('scripts')

@endsection

@section('styles')

    <style>

        .card-header{
            background-color: #4b922d;
            color: white;
        }

    </style>

@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-md-12">
            <div class="card">
                <div class="card-header body-text">{{ __('Koop Hardware Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}" id="register_form">
                        @csrf

                        <div class="form-group row">

                            <div class="col-md-5">
                                <label for="first_name" class="text-md-right body-text-thick">{{ __('First Name') }}</label>

                                <input id="first_name" type="text" class="form-control body-text @error('first_name') is-invalid @enderror" placeholder="First Name" name="first_name" value="{{ old('first_name') }}" required autocomplete="name" autofocus>

                                @error('first_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-md-5">
                                <label for="last_name" class="text-md-right body-text-thick">{{ __('Last Name') }}</label>
                                <input id="last_name" type="text" class="form-control body-text @error('last_name') is-invalid @enderror" placeholder="Last Name" name="last_name" value="{{ old('last_name') }}" required autocomplete="name" autofocus>

                                @error('last_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-md-2">
                                <label for="middle_initial" class="text-md-right body-text-thick">{{ __('Middle Initial') }}</label>
                                <input id="middle_initial" type="text" class="form-control body-text @error('middle_initial') is-invalid @enderror" placeholder="Middle Initial" name="middle_initial" value="{{ old('middle_initial') }}" required autocomplete="name" autofocus>

                                    @error('middle_initial')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6">
                                <label for="email" class="text-md-right body-text-thick">{{ __('E-Mail Address') }}</label>
                                <input id="email" type="email" class="form-control body-text @error('email') is-invalid @enderror" placeholder="Email Address" name="email" value="{{ old('email') }}" required autocomplete="email">

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="mobile" class="text-md-right body-text-thick">{{ __('Mobile Number') }}</label>
                                <input id="mobile" type="text" class="form-control body-text @error('mobile') is-invalid @enderror" placeholder="Mobile Number" name="mobile" value="{{ old('mobile') }}" required autocomplete="name" autofocus>

                                @error('mobile')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">

                            <div class="col-md-2">
                                <label for="sex" class="text-md-right body-text-thick">{{ __('Sex') }}</label>
                                <select id="sex" name="sex" class="form-control body-text  @error('sex') is-invalid @enderror" value="{{ old('sex') }}" required autocomplete="name" autofocus aria-label="">
                                        <option value=""></option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                    @error('sex')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                            </div>

                            <div class="col-md-3">
                                <label for="city" class="text-md-right body-text-thick">{{ __('City') }}</label>
                                <select id="city" name="city" class="form-control body-text  @error('city') is-invalid @enderror" value="{{ old('city') }}" required autocomplete="name" autofocus aria-label="">
                                        <option value=""></option>
                                        <option value="Batangas">Batangas</option>
                                    </select>
                                    @error('city')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                            </div>

                            <div class="col-md-3">
                                <label for="barangay_code" class="text-md-right body-text-thick">{{ __('Barangay') }}</label>
                                <select id="barangay_code" name="barangay_code" class="form-control body-text  @error('barangay_code') is-invalid @enderror" value="{{ old('barangay_code') }}" required autocomplete="name" autofocus aria-label="">

                                    </select>
                                    <input name="barangay" id="barangay" type="hidden" value="">
                                    @error('barangay_code')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="address_notes" class="text-md-right body-text-thick">{{ __('Address Notes') }}</label>
                                    <input id="address_notes" type="text" name="address_notes" class="form-control body-text  @error('address_notes') is-invalid @enderror" placeholder="Address Notes / Landmark" value="{{ old('address_notes') }}"  autocomplete="name" autofocus aria-label="">

                                    @error('address_notes')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row justify-content-center">

                            <div class="col-12 col-md-4">
                                <label for="membership_code" class="text-md-right body-text-thick">{{ __('Membership Code') }}</label>
                                <input id="membership_code" type="text" class="form-control body-text" name="membership_code" placeholder="Membership Code (Blank if none)">
                            </div>

                            <div class="col-12 col-md-4">
                                <label for="password" class="text-md-right body-text-thick">{{ __('Password') }}</label>
                                <input id="password" type="password" class="form-control body-text @error('password') is-invalid @enderror" placeholder="Password" name="password" required autocomplete="new-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                            </div>
                            
                            <div class="col-12 col-md-4">
                                <label for="password-confirm" class="text-md-right body-text-thick">{{ __('Confirm Password') }}</label>
                                <input id="password-confirm" type="password" class="form-control body-text" name="password_confirmation" placeholder="Password" required autocomplete="new-password">
                            </div>

                        </div>

                        <div class="form-group row justify-content-center">
                            <div class="col-12 text-center body-text">
                                <input type="checkbox" id="agree"><span> By registering an account, I agree to Koop Hardware's <a style="text-decoration: none;" href="#">Data Privacy Policy</a></span> 
                            </div>
                        </div>

                        <div class="form-group row mb-0 justify-content-center">
                            <div class="col-6 text-right">
                                <button type="submit" class="btn page-btn ml-auto body-text" id="register_acc_btn" disabled>
                                    {{ __('Register') }}
                                </button>
                            </div>
                            <div class="col-6 text-left">
                                <a href="{{ url()->previous() }}" class="btn page-btn mr-auto body-text">
                                    Cancel
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('post-scripts')
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.0/jquery.js" defer></script>
        <script type="text/javascript" src="{{ asset('js/jquery.ph-locations-v1.0.0.js') }}" defer></script>

        <script type="text/javascript">

            function agree_checkbox()
            {
                $('#agree').click(function () {
                    if ($(this).is(':checked')) {
                        $('#register_acc_btn').removeAttr('disabled');
                    } else {
                        $('#register_acc_btn').attr('disabled', 'disabled');
                    }
                });
            }

            function load_barangay()
            {
                $('#barangay_code').ph_locations({'location_type': 'barangays'});

                $('#city').on('change', function() {
                    if(this.value != '')
                    {
                        $('#barangay_code').ph_locations('fetch_list', [{"city_code": "041005"}]);
                    }
                    else
                    {
                        $('#barangay_code')
                        .find('option')
                        .remove()
                        .end()
                        .append('<option value=""></option>')
                        .val(''); 
                    }
                });
            }

            function set_barangay_value()
            {
                $('#register_form').submit(function(){
                    var barangay = $("#barangay_code option:selected").text();
                    document.getElementById('barangay').value = barangay;
                });
            }

            function disable_period()
            {
                $('#middle_initial').keydown(function(e) {
                    if (e.keyCode === 190 || e.keyCode === 110) {
                        e.preventDefault();
                    }
                });
            }

            $(document).ready(function(){
                agree_checkbox();
                disable_period();
                load_barangay();
                set_barangay_value();
            });
        </script>
@endsection