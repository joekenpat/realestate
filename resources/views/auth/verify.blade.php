@extends('layouts.app')
@section('title', "Verify Your Email")
@section('content')
<div class="uk-section uk-section-small uk-section-muted uk-flex uk-flex-center">
  <div class="uk-card uk-card-default my-card uk-card-body uk-width-large">
    <h2 class="uk-card-title" style="color:#3D9FB9;">{{ __('Verify Your Email Address') }}</h2>
    @if (session('resent'))
    <div class="uk-alert-success" uk-alert>
      <a class="uk-alert-close" uk-close></a>
      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt.</p>
    </div>
    @endif
    <p class=>
      {{ __('Before proceeding, please check your email for a verification link.') }}
      {{ __('If you did not receive the email') }},
      <form class="d-uk-form-stacked" method="POST" action="{{ route('verification.resend') }}">
        @csrf
        <div class="uk-margin">
          <div class="uk-form-control">
            <button type="submit" class="uk-button uk-width-1-1 white-text" style="background-color:#3D9FB9;">
              Resend Another Now
            </button>
          </div>
        </div>
      </form>
    </p>
  </div>
</div>
</div>
</div>
</div>
@endsection
