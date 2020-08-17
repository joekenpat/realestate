@extends('layouts.admin')
@section('title', "Create new Subcategory")
@section('content')

<div class="" uk-grid>
  <div class="uk-width-1-1">
    <div class="uk-card uk-card-default uk-border-rounded">
      <div class="uk-card-header uk-padding-small">
        <h3>Create Subcategory</h3>
      </div>
      <div class="uk-card-body uk-padding-small">
        <form action="{{route('admin_store_subcategory')}}" enctype="multipart/form-data" method="POST">
          @csrf
          <div class="uk-grid-small uk-flex-bottom" uk-grid>
            <div class=" uk-width-2-5">
              <label for="last_name" class="uk-form-label form-label">
                Name *
              </label>
              <div class="uk-form-control">
                <div class="uk-inline uk-width-1-1">
                  <span class="uk-form-icon" uk-icon="icon: file-edit" style="color: #3D9FB9;"></span>
                  <input class="uk-input uk-border-rounded uk-width-1-1 @error('name') uk-form-danger @enderror"
                    id="name" name="name" type="text" value="{{ old('name') }}" required autocomplete="family-name"
                    autofocus>
                </div>
                @error('name')
                <span class="uk-text-danger">{{ $message }}</span>
                @enderror
              </div>
            </div>
            <div class=" uk-width-1-5">
              <label for="last_name" class="uk-form-label form-label">
                Category *
              </label>
              <div class="uk-form-control">
                <div class="uk-inline uk-width-1-1">
                  <span class="uk-form-icon" uk-icon="icon: list" style="color: #3D9FB9;"></span>
                  <select class="uk-input uk-width-1-1 uk-border-rounded @error('category_id') uk-form-danger @enderror"
                    id="category_id" name="category_id" value="{{ old('category_id') }}" required>
                    <option value="">Select Category --</option>
                    @foreach ($categories as $cat)
                    <option value="{{$cat->id}}">{{$cat->name}}</option>
                    @endforeach
                  </select>
                </div>
                @error('category_id')
                <span class="uk-text-danger">{{ $message }}</span>
                @enderror
              </div>
            </div>
            <div class=" uk-width-1-5">
              <label for="last_name" class="uk-form-label form-label">
                Icon *
              </label>
              <div class="uk-form-control">
                <div class="uk-inline uk-width-1-1" uk-form-custom="target: true">
                  <input type="file" accept=".jpeg,.gif,.jpg,.png" id="image" name="image" />
                  <input class="uk-input uk-width-1-1 uk-border-rounded @error('image') uk-form-danger @enderror"
                    type="text" placeholder="Select Subcategory icon" accept=".jpeg,.gif,.jpg,.png" disabled />
                </div>
              </div>
              @error('image')
              <span class="uk-text-danger">{{ $message }}</span>
              @enderror
            </div>
            <div class="uk-width-1-5">
              <div class="uk-form-control">
                <button type="submit" class="uk-button uk-button-default uk-width-1-1 uk-border-rounded"
                  style="background-color: #87ceeb; color:white;  text-transform: capitalize;">
                  Create
                </button>
              </div>
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
