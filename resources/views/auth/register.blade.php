@extends('layouts.app')
@section('title', 'Create an account')
@section('content')


<div class="uk-section uk-section-small uk-section-muted uk-padding-small uk-grid  uk-flex uk-flex-center">
      <div class="uk-card uk-card-default uk-card-body my-card uk-width-1-1 uk-width-5-6@s uk-width-3-4@m uk-width-1-2@l">
        <h2 class="uk-card-title" style="color:#3D9FB9;">Registration</h2>
        <form method="POST" action="{{ route('register')  }}" class="uk-form-stacked">
          @csrf
          <div class="uk-grid-small" uk-grid>
            <div class=" uk-width-1-2">
              <label for="last_name" class="uk-form-label form-label">
                {{ __('Last Name *') }}
              </label>
              <div class="uk-form-control">
                <div class="uk-inline uk-width-1-1">
                  <span class="uk-form-icon" uk-icon="icon: user" style="color: #3D9FB9;"></span>
                  <input class="uk-input uk-width-1-1 @error('last_name') uk-form-danger @enderror" id="last_name"
                    name="last_name" type="text" value="{{ old('last_name') }}" required autocomplete="family-name"
                    autofocus>
                </div>
                @error('last_name')
                <span class="uk-text-danger">{{ $message }}</span>
                @enderror
              </div>
            </div>
            <div class="uk-width-1-2">
              <label for="first_name" class="uk-form-label form-label">
                {{ __('First Name *') }}
              </label>
              <div class="uk-form-control">
                <div class="uk-inline uk-width-1-1">
                  <span class="uk-form-icon" uk-icon="icon: user" style="color: #3D9FB9;"></span>
                  <input class="uk-input uk-width-1-1 @error('first_name') uk-form-danger @enderror" id="first_name"
                    name="first_name" type="text" value="{{ old('first_name') }}" required autocomplete="given-name">
                </div>
                @error('first_name')
                <span class="uk-text-danger">{{ $message }}</span>
                @enderror
              </div>
            </div>
            <div class="uk-width-1-2">
              <label for="first_name" class="uk-form-label form-label">
                {{ __('Username *') }}
              </label>
              <div class="uk-form-control">
                <div class="uk-inline uk-width-1-1">
                  <span class="uk-form-icon" uk-icon="icon: user" style="color: #3D9FB9;"></span>
                  <input class="uk-input uk-width-1-1 @error('username') uk-form-danger @enderror" id="username"
                    name="username" type="text" value="{{ old('username') }}" required >
                </div>
                @error('username')
                <span class="uk-text-danger">{{ $message }}</span>
                @enderror
              </div>
            </div>
            <div class="uk-width-1-2">
              <label for="first_name" class="uk-form-label form-label">
                {{ __('Phone *') }}
              </label>
              <div class="uk-form-control">
                <div class="uk-inline uk-width-1-1">
                  <span class="uk-form-icon" uk-icon="icon: receiver" style="color: #3D9FB9;"></span>
                  <input class="uk-input uk-width-1-1 @error('phone') uk-form-danger @enderror" id="phone"
                    name="phone" type="tel" value="{{ old('phone') }}" required autocomplete="tel">
                </div>
                @error('phone')
                <span class="uk-text-danger">{{ $message }}</span>
                @enderror
              </div>
            </div>
            <div class="uk-width-1-1">
              <label for="email" class="uk-form-label form-label">
                {{ __('E-Mail Address *') }}
              </label>
              <div class="uk-form-control">
                <div class="uk-inline uk-width-1-1">
                  <span class="uk-form-icon" uk-icon="icon: mail" style="color: #3D9FB9;"></span>
                  <input class="uk-input uk-width-1-1 @error('email') uk-form-danger @enderror" id="email" name="email"
                    type="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                </div>
                @error('email')
                <span class="uk-text-danger">{{ $message }}</span>
                @enderror
              </div>
            </div>
            <div class="uk-width-1-1">
              <label for="password" class="uk-form-label form-label">
                {{ __('Password *') }}
              </label>
              <div class="uk-form-control">
                <div class="uk-inline uk-width-1-1">
                  <span class="uk-form-icon" uk-icon="icon: lock" style="color: #3D9FB9;"></span>
                  <input id="password" type="password"
                    class="uk-input uk-width-1-1 @error('password') uk-form-danger @enderror" name="password" required
                    autocomplete="new-password">
                </div>
                @error('password')
                <span class="uk-text-danger">{{ $message }}</span>
                @enderror
              </div>
            </div>
            <div class="uk-width-1-1">
              <div class="uk-form-control">
                <button type="submit" style="background-color:#3D9FB9;"
                  class="uk-button uk-button-primary uk-width-1-1">
                  {{ __('Register') }}
                </button>
              </div>
            </div>
          </div>
        </form>
      </div>
</div>

@endsection
