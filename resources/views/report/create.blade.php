@extends('layouts.app')
@section('title', " Viewing: $property->title")
@section('content')
<!-----dashboard start here----->
@push('style_top')
<style>
  body {
    background-color: whitesmoke;
  }

  a:link {
    color: black;
    text-decoration: none;
  }

  a:visited {
    color: black;
    background-color: whitesmoke;
  }

  a:active {
    color: blue;
    background-color: whitesmoke;
  }

  .dashboard-nav {
    font-size: 0.7em;
    padding-left: 20px;
  }

  .dashboard-tips {
    font-size: 0.9em;
    padding-left: 20px;
  }

  .dashboard-link {
    padding-left: 20px;
  }

  .dashboard-main {
    width: 70%;
    margin-top: 8%;
  }

  .dashboard-main2 {
    width: 50%;
  }

  .my-line {
    margin-top: -75px;
  }

  .tab-button {
    font-size: 0.7em;
    background-color: #9966cc;
    color: white;
    text-transform: capitalize;
    font-weight: bold;
    padding: 1px;
    margin: -100px;
    width: 100px;
  }

  .my-button-padding {
    padding: 2px;
  }

  /* .formatForButton{
    background-color:#adf802;
} */
  /* span {
    display: none;
  } */

  @media (max-width: 740px) {
    .dashboard-main {
      width: 100%;
      margin-top: 25%;
    }

    .dashboard-main2 {
      width: 100%;
    }

    .my-margin {
      margin-top: 2%;
    }

    .my-container {
      padding-left: 30px !important;
    }

    .tab-button {
      font-size: 0.7em;
      background-color: #9966cc;
      color: white;
      text-transform: capitalize;
      font-weight: bold;
      padding: 5px;
      margin: -30px;

    }

    .my-button-padding-small {
      padding-left: 30px;
    }
  }


  body {
    background-color: whitesmoke;
  }

  ul {
    list-style-type: none;
  }

  a:link {
    color: black;
    text-decoration: none;
  }

  a:visited {
    color: black;
    background-color: whitesmoke;
  }

  a:active {
    color: blue;
    background-color: whitesmoke;
  }

  .dashboard-nav {
    font-size: 0.7em;
    padding-left: 20px;
  }

  .dashboard-tips {
    font-size: 0.9em;
    padding-left: 20px;
  }

  .dashboard-link {
    padding-left: 20px;
  }

  .dashboard-main {
    width: 70%;
    margin-top: 8%;
  }

  .dashboard-main2 {
    width: 50%;
  }

  .my-line {
    margin-top: -75px;
  }

  .tab-button {
    font-size: 0.7em;
    background-color: #9966cc;
    color: white;
    text-transform: capitalize;
    font-weight: bold;
    padding: 1px;
    margin: -100px;
    width: 100px;
  }

  .my-button-padding {
    padding: 2px;
  }

  /* .formatForButton{
    background-color:#adf802;
} */
  /* span {
    display: none;
  } */

  @media (max-width: 740px) {
    .dashboard-main {
      width: 100%;
      margin-top: 25%;
    }

    .dashboard-main2 {
      width: 100%;
    }

    .my-margin {
      margin-top: 2%;
    }

    .my-container {
      padding-left: 30px !important;
    }

    .tab-button {
      font-size: 0.7em;
      background-color: #9966cc;
      color: white;
      text-transform: capitalize;
      font-weight: bold;
      padding: 5px;
      margin: -30px;

    }

    .my-button-padding-small {
      padding-left: 30px;
    }
  }

  .profile_image {
    width: 150px;
    height: 150px;
    object-fit: cover;
  }
</style>
@endpush
<div class="uk-grid-collapse" uk-grid>
  <div class="uk-visible@m uk-width-1-4 uk-padding-small">
    @include('layouts.user_profile_card')
  </div>
  <!-----nav links for desktop end here----->

  <!-----poast ads start here----->
  <div class="uk-width-1-1 uk-width-3-4@m uk-padding-small">
    <div class="uk-grid-collapse uk-flex-center" uk-grid>
      <div class="uk-width-1-1@s uk-padding-remove  view-ad-page">
        <div class="uk-card uk-card-default uk-border-rounded">
          <div class="uk-card-header">
            <h3 class=" uk-margin-remove-bottom"><b>File a Report against Property: {{$property->title}}</b></h3>
          </div>
          <div>
            <form action="{{route('file_property_report',['property_id'=>$property->id])}}" method="post">
              @csrf
              <div class="uk-card-body uk-padding-small">
                <div class="uk-grid-small uk-flex-bottom uk-flex uk-flex-center" uk-grid>
                  <div class=" uk-width-1-1">
                    <label for="title" class="uk-form-label form-label">
                      A title of your Report or Complaint *
                    </label>
                    <div class="uk-form-control">
                      <div class="uk-inline uk-width-1-1">
                        <span class="uk-form-icon" uk-icon="icon: info" style="color: #3D9FB9;"></span>
                        <input class="uk-input uk-border-rounded uk-width-1-1 @error('title') uk-form-danger @enderror"
                          id="title" name="title" type="text" value="{{ old('title') }}" required autofocus>
                      </div>
                      @error('title')
                      <span class="uk-text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>
                  <div class="uk-width-1-1">
                    <label for="message" class="uk-form-label form-label">
                      Message *
                    </label>
                    <div class="uk-form-control">
                      <div class="uk-inline uk-width-1-1">
                        <textarea rows="10"
                          class="uk-textarea uk-border-rounded uk-width-1-1 @error('featured_price') uk-form-danger @enderror"
                          id="message" name="message" type="number" required>{{ old('message') }}</textarea>
                      </div>
                      @error('message')
                      <span class="uk-text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>
                  <div class=" uk-width-1-3">
                    <div class="uk-form-control">
                      <button type="submit" class="uk-button uk-button-default uk-width-1-1 uk-border-rounded"
                        style="background-color: #87ceeb; color:white;  text-transform: capitalize;">
                        File Report
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
    <!-----post ads end here----->
  </div>


</div>

<!-----userdashboard end here----->
@endsection
