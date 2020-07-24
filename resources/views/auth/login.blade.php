@extends('layouts.app')

@section('content')
<div class="uk-section uk-section-small uk-section-muted uk-flex uk-flex-center">
  <div class="uk-card uk-card-default uk-card-body uk-width-large">
    <h2 class="uk-card-title">Log In</h2>
    {{-- <Login form_action="{{route('login')}}" password_request_route="{{route('password.request')}}" /> --}}
    <form method="POST" action="{{ route('login') }}" class="uk-form-stacked">
      @csrf
      <div class="uk-margin">
        <label for="email" class="uk-form-label">
          {{ __('E-Mail Address') }}
        </label>
        <div class="uk-form-control">
          <div class="uk-inline uk-width-1-1">
            <span class="uk-form-icon" uk-icon="icon: mail"></span>
            <input class="uk-input @error('email') uk-form-danger @enderror" name="email" id="email" type="email"
              value="{{ old('email') }}" required autocomplete="email" autofocus>
            @error('email')
          </div>
          <span class="uk-text-danger">{{ $message }}</span>
          @enderror
        </div>
      </div>
      <div class="uk-margin">
        <label for="password" class="uk-form-label">
          {{ __('Password') }}
        </label>
        <div class="uk-form-control">
          <div class="uk-inline uk-width-1-1">
            <span class="uk-form-icon" uk-icon="icon: lock"></span>
            <input id="password" type="password" class="uk-input @error('password') uk-form-danger @enderror"
              name="password" required autocomplete="current-password">
            @error('password')
          </div>
          <span class="uk-text-danger">{{ $message }}</span>
          @enderror
        </div>
      </div>
      <div class="uk-margin">
        <div class="uk-form-control uk-text-center">
          <input class="uk-checkbox" type="checkbox" name="remember" id="remember"
            {{ old('remember') ? 'checked' : '' }}>
          <label for="remember">
            {{ __('Remember Me') }}
          </label>
        </div>
      </div>
      <div class="uk-margin">
        <div class="uk-form-control">
          <button type="submit" class="uk-button uk-width-1-1 uk-background-primary white-text">
            {{ __('Log In') }}
          </button>
        </div>
      </div>
      <div class="uk-margin">
        <div class="uk-form-control uk-text-center">
          @if (Route::has('password.request'))
          <a class="uk-button uk-button-link uk-margin-left" href="{{ route('password.request') }}">
            {{ __('Reset Password?') }}
          </a>
          @endif
        </div>
      </div>
    </form>
  </div>
</div>
@endsection
@push('bottom_scripts')
@endpush
