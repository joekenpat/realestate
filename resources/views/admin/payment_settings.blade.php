@extends('layouts.admin')
@section('title', "Payment Settings")
@section('content')

<div class="" uk-grid>
  <div class="uk-width-1-1">
    <div class="uk-card uk-card-default uk-border-rounded">
      <div class="uk-card-header uk-padding-small">
        <h3>Edit Paystack</h3>
      </div>
      <div class="uk-card-body uk-padding-small">
        <form action="{{route('admin_update_payment_settings')}}" enctype="multipart/form-data" method="POST">
          @csrf
          <div class="uk-grid-small uk-flex-bottom" uk-grid>
            <div class=" uk-width-2-5">
              <label for="public_key" class="uk-form-label form-label">
                Public Key *
              </label>
              <div class="uk-form-control">
                <div class="uk-inline uk-width-1-1">
                  <span class="uk-form-icon" uk-icon="icon: grid" style="color: #3D9FB9;"></span>
                  <input class="uk-input uk-border-rounded uk-width-1-1 @error('public_key') uk-form-danger @enderror"
                    id="public_key" name="public_key" type="text"
                    value="{{ old('public_key')?:$paystack_keys->public }}" required autofocus>
                </div>
                @error('public_key')
                <span class="uk-text-danger">{{ $message }}</span>
                @enderror
              </div>
            </div>
            <div class=" uk-width-2-5">
              <label for="secret_key" class="uk-form-label form-label">
                Secret Key *
              </label>
              <div class="uk-form-control">
                <div class="uk-inline uk-width-1-1">
                  <span class="uk-form-icon" uk-icon="icon: grid" style="color: #3D9FB9;"></span>
                  <input class="uk-input uk-border-rounded uk-width-1-1 @error('secret_key') uk-form-danger @enderror"
                    id="secret_key" name="secret_key" type="text"
                    value="{{ old('secret_key')?:$paystack_keys->secret }}" required>
                </div>
                @error('secret_key')
                <span class="uk-text-danger">{{ $message }}</span>
                @enderror
              </div>
            </div>
            <div class=" uk-width-1-5">
              <div class="uk-form-control">
                <button type="submit" class="uk-button uk-button-default uk-width-1-1 uk-border-rounded"
                  style="background-color: #87ceeb; color:white;  text-transform: capitalize;">
                  Update Keys
                </button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
@push('bottom_scripts')
<script>
  function confirm_action(e,t){
  e.preventDefault();
  e.target.blur();
  var self_link = t.getAttribute('href')
  var self_action = t.getAttribute('uk-tooltip')
  UIkit.modal.confirm(`Do you want to ${self_action}!`).then(function () {
      e.isDefaultPrevented = function(){ return false; }
    // retrigger with the exactly same event data
    location.href = self_link
  }, function () {
  });
  }
</script>
