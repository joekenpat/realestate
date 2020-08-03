@extends('layouts.admin')
@section('title', "Media Settings")
@section('content')

<div class="" uk-grid>
  {{-- <div class="uk-width-1-1">
    <div class="uk-card uk-card-default uk-border-rounded">
      <div class="uk-card-header uk-padding-small">
        <h3>Edit Logo</h3>
      </div>
      <div class="uk-card-body uk-padding-small">
        <form action="#" enctype="multipart/form-data" method="POST">
          @csrf
          <div class="uk-grid-small uk-flex-bottom" uk-grid>
            <div class="">
              <img
                src="{{$logo != null?URL::to(sprintf("images/misc/%s",$logo)):asset("images/misc/default_avatar.png") }}"
                class="uk-border-circle" style="height:40px;width:40px;object-fit:cover;" alt="Site logo ">
            </div>
            <div class="uk-width-2-5">
              <label for="image" class="uk-form-label form-label">
                Icon *
              </label>
              <div class="uk-form-control">
                <div class="uk-inline uk-width-1-1" uk-form-custom="target: true">
                  <input type="file" accept=".jpeg,.gif,.jpg,.png" id="image" name="image" />
                  <input class="uk-input uk-width-1-1 uk-border-rounded @error('image') uk-form-danger @enderror"
                    type="text" placeholder="Select Site logo" accept=".jpeg,.gif,.jpg,.png" disabled />
                </div>
              </div>
              @error('image')
              <span class="uk-text-danger">{{ $message }}</span>
              @enderror
            </div>
            <div class=" uk-width-1-5">

              <div class="uk-form-control">
                <button type="submit" class="uk-button uk-button-default uk-width-1-1 uk-border-rounded"
                  style="background-color: #87ceeb; color:white;  text-transform: capitalize;">
                  Update Logo
                </button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div> --}}

  <div class="uk-width-1-1">
    <div class="uk-card uk-card-default uk-border-rounded">
      <div class="uk-card-header uk-padding-small">
        <h3>Edit Home Slider</h3>
      </div>
      <div class="uk-card-body uk-padding-small">
        <div class="uk-grid-small uk-child-width-1-3 uk-flex-bottom uk-margin-small-bottom" uk-grid>
          @foreach ($home_slider as $image)
          <div class="">
            <img src="{{URL::to(sprintf("images/misc/%s",$image))}}" class=""
              style="height:200px;width:100%;object-fit:cover;" alt="Slider Image">
            <a href="{{route('admin_delete_home_slider_image',['image_name'=>$image])}}"
              class="uk-button uk-button-danger uk-width-1-1">
              Remove
            </a>
          </div>
          @endforeach
        </div>
        <form action="{{route('admin_store_home_slider_image')}}" enctype="multipart/form-data" method="POST">
          @csrf
          <div class="uk-grid-small uk-flex-bottom" uk-grid>
            <div class="uk-width-2-5">
              <label for="image" class="uk-form-label form-label">
                Slider image * maximum(5)
              </label>
              <div class="uk-form-control">
                <div class="uk-inline uk-width-1-1" uk-form-custom="target: true">
                  <input type="file" multiple accept=".jpeg,.gif,.jpg,.png" id="slider" name="slider[]" />
                  <input class="uk-input uk-width-1-1 uk-border-rounded @error('image') uk-form-danger @enderror"
                    type="text" placeholder="Select Site logo" accept=".jpeg,.gif,.jpg,.png" disabled />
                </div>
              </div>
              @error('slider')
              <span class="uk-text-danger">{{ $message }}</span>
              @enderror
            </div>
            <div class=" uk-width-1-5">

              <div class="uk-form-control">
                <button type="submit" class="uk-button uk-button-default uk-width-1-1 uk-border-rounded"
                  style="background-color: #87ceeb; color:white;  text-transform: capitalize;">
                  Add Slider Images
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
