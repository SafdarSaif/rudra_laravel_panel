@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('loggedin') }}">
                        @csrf
                        <div class="dz-separator-outer m-b5">
                            <div class="dz-separator bg-primary style-liner"></div>
                        </div>
                        <!-- <p>Enter your e-mail address and your password. </p> -->
                        <div class="form-group mb-3">
                            <input type="email" name="email" class="form-control" placeholder="Enter your email" value="{{old('email')}}">
                            @if ($errors->has('email'))
                            <span class="error text-danger">{{ $errors->first('email') }}</span>
                            @endif
                        </div>
                        <div class="form-group mb-3">
                            <input type="password" name="password" placeholder="Enter your password" class="form-control" value="{{old('password')}}">
                            @if ($errors->has('password'))
                            <span class="error text-danger">{{ $errors->first('password') }}</span>
                            @endif
                        </div>
                        <div class="form-group text-left mb-5 forget-main">
                            <span class="form-check d-inline-block">
                                <input type="checkbox" class="form-check-input" id="check1" name="example1">
                                <label class="form-check-label" for="check1">Remember me</label>
                            </span>
                        </div>
                        <div class="form-group text-center mb-5 forget-main ">
                            <button type="submit" class="btn btn-primary">Sign Me In</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
