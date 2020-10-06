@extends('layouts.admin')
@section('title', "Property Settings")
@section('content')

<div class="" uk-grid>
  <div class="uk-width-1-1">
    <div class="uk-card uk-card-default uk-border-rounded">
      <div class="uk-card-header uk-padding-small">
        <h3>Property Settings</h3>
      </div>
      <div class="uk-card-body uk-padding-small">
        <form action="{{route('admin_update_property_settings')}}" enctype="multipart/form-data" method="POST">
          @csrf
          <div class="uk-grid-small uk-flex-bottom" uk-grid>
            <div class=" uk-width-1-3">
              <label for="free_span" class="uk-form-label form-label">
                Free Duration (Days)
              </label>
              <div class="uk-form-control">
                <div class="uk-inline uk-width-1-1">
                  <span class="uk-form-icon" uk-icon="icon: grid" style="color: #3D9FB9;"></span>
                  <input class="uk-input uk-border-rounded uk-width-1-1 @error('free_span') uk-form-danger @enderror"
                    id="free_span" name="free_span" type="number" value="{{ old('free_span')?:$span->free }}" required
                    autofocus>
                </div>
                @error('free_span')
                <span class="uk-text-danger">{{ $message }}</span>
                @enderror
              </div>
            </div>
            <div class=" uk-width-1-3">
              <label for="vip_span" class="uk-form-label form-label">
                Vip Duration (Days)
              </label>
              <div class="uk-form-control">
                <div class="uk-inline uk-width-1-1">
                  <span class="uk-form-icon" uk-icon="icon: grid" style="color: #3D9FB9;"></span>
                  <input class="uk-input uk-border-rounded uk-width-1-1 @error('vip_span') uk-form-danger @enderror"
                    id="vip_span" name="vip_span" type="number" value="{{ old('vip_span')?:$span->vip }}" required>
                </div>
                @error('vip_span')
                <span class="uk-text-danger">{{ $message }}</span>
                @enderror
              </div>
            </div>
            <div class=" uk-width-1-3">
              <label for="premium_span" class="uk-form-label form-label">
                Premium Duration (Days)
              </label>
              <div class="uk-form-control">
                <div class="uk-inline uk-width-1-1">
                  <span class="uk-form-icon" uk-icon="icon: grid" style="color: #3D9FB9;"></span>
                  <input class="uk-input uk-border-rounded uk-width-1-1 @error('premium_span') uk-form-danger @enderror"
                    id="premium_span" name="premium_span" type="number"
                    value="{{ old('premium_span')?:$span->premium }}" required>
                </div>
                @error('premium_span')
                <span class="uk-text-danger">{{ $message }}</span>
                @enderror
              </div>
            </div>
            <div class=" uk-width-1-3">
              <label for="featured_span" class="uk-form-label form-label">
                Featured Duration (Days)
              </label>
              <div class="uk-form-control">
                <div class="uk-inline uk-width-1-1">
                  <span class="uk-form-icon" uk-icon="icon: grid" style="color: #3D9FB9;"></span>
                  <input
                    class="uk-input uk-border-rounded uk-width-1-1 @error('featured_span') uk-form-danger @enderror"
                    id="featured_span" name="featured_span" type="number"
                    value="{{ old('featured_span')?:$span->featured }}" required>
                </div>
                @error('featured_span')
                <span class="uk-text-danger">{{ $message }}</span>
                @enderror
              </div>
            </div>
            <div class=" uk-width-1-3">
              <label for="vip_price" class="uk-form-label form-label">
                Vip price(N)
              </label>
              <div class="uk-form-control">
                <div class="uk-inline uk-width-1-1">
                  <span class="uk-form-icon" uk-icon="icon: grid" style="color: #3D9FB9;"></span>
                  <input class="uk-input uk-border-rounded uk-width-1-1 @error('vip_price') uk-form-danger @enderror"
                    id="vip_price" name="vip_price" type="number" value="{{ old('vip_price')?:$fee->vip }}"
                    required>
                </div>
                @error('vip_price')
                <span class="uk-text-danger">{{ $message }}</span>
                @enderror
              </div>
            </div>
            <div class=" uk-width-1-3">
              <label for="premium_price" class="uk-form-label form-label">
                Premium price(N)
              </label>
              <div class="uk-form-control">
                <div class="uk-inline uk-width-1-1">
                  <span class="uk-form-icon" uk-icon="icon: grid" style="color: #3D9FB9;"></span>
                  <input
                    class="uk-input uk-border-rounded uk-width-1-1 @error('premium_price') uk-form-danger @enderror"
                    id="premium_price" name="premium_price" type="number"
                    value="{{ old('premium_price')?:$fee->premium }}" required>
                </div>
                @error('premium_price')
                <span class="uk-text-danger">{{ $message }}</span>
                @enderror
              </div>
            </div>
            <div class=" uk-width-1-3">
              <label for="vip_span" class="uk-form-label form-label">
                Featured Price(N)
              </label>
              <div class="uk-form-control">
                <div class="uk-inline uk-width-1-1">
                  <span class="uk-form-icon" uk-icon="icon: grid" style="color: #3D9FB9;"></span>
                  <input
                    class="uk-input uk-border-rounded uk-width-1-1 @error('featured_price') uk-form-danger @enderror"
                    id="featured_price" name="featured_price" type="number"
                    value="{{ old('featured_price')?:$fee->featured }}" required>
                </div>
                @error('featured_price')
                <span class="uk-text-danger">{{ $message }}</span>
                @enderror
              </div>
            </div>
            <div class=" uk-width-1-3">
              <label for="max_media" class="uk-form-label form-label">
                Max Property Image
              </label>
              <div class="uk-form-control">
                <div class="uk-inline uk-width-1-1">
                  <span class="uk-form-icon" uk-icon="icon: grid" style="color: #3D9FB9;"></span>
                  <input class="uk-input uk-border-rounded uk-width-1-1 @error('max_media') uk-form-danger @enderror"
                    id="max_media" name="max_media" type="number" value="{{ old('max_media')?:$max_media }}" required>
                </div>
                @error('max_media')
                <span class="uk-text-danger">{{ $message }}</span>
                @enderror
              </div>
            </div>
            <div class=" uk-width-1-3">
              <div class="uk-form-control">
                <button type="submit" class="uk-button uk-button-default uk-width-1-1 uk-border-rounded"
                  style="background-color: #87ceeb; color:white;  text-transform: capitalize;">
                  Save
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
