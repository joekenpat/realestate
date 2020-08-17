@extends('layouts.admin')
@section('title', "Pending Reports")
@section('content')

<div class="" uk-grid>
  <div class="uk-width-1-1">
    <div class="uk-card uk-card-default uk-border-rounded">
      <div class="uk-card-header uk-padding-small">
        <h3>Pending Reports</h3>
      </div>
      <div class="uk-card-body uk-padding-small">
        <ul uk-accordion="active: 0">
          @foreach ($reports as $report)
          <li class="@if($report->status =='pending')"orange lighten-3" @else "green lighten-3" @endif">
            <a class="uk-accordion-title" href="#">#{{$loop->iteration * $reports->currentPage()}}. {{$report->title}}</a>
            <div class="uk-accordion-content">
              <p>{{$report->message}}</p>
              <div class="uk-padding-small uk-width-1-1">
                <div class="uk-grid uk-grid-small">
                  <div class="uk-margin-small-bottom"><a class="uk-border-rounded uk-button uk-button-small blue white-text" onclick="confirm_action(event, this)"
                      href="#" style="color:blue" uk-tooltip="View Reporter">
                      <span class="uk-icon-link uk-margin-small-right white-text"
                        uk-icon="icon:user; ratio:1"></span>View
                      Reporter</a></div>
                  <div class="uk-margin-small-bottom"><a class="uk-border-rounded uk-button uk-button-small  yellow white-text" onclick="confirm_action(event, this)"
                      href="#" uk-tooltip="Block Reporter">
                      <span class="uk-icon-link uk-margin-small-right white-text"
                        uk-icon="icon:user; ratio:1"></span>Block
                      Reporter</a></div>
                  <div class="uk-margin-small-bottom"><a class="uk-border-rounded uk-button uk-button-small  blue white-text" onclick="confirm_action(event, this)"
                      href="#" uk-tooltip="View Property">
                      <span class="uk-icon-link uk-margin-small-right white-text"
                        uk-icon="icon:home; ratio:1"></span>View
                      Property</a></div>
                  <div class="uk-margin-small-bottom"><a class="uk-border-rounded uk-button uk-button-small  red white-text" onclick="confirm_action(event, this)"
                      href="#" style="color:home" uk-tooltip="Disable Property">
                      <span class="uk-icon-link uk-margin-small-right white-text"
                        uk-icon="icon:ban; ratio:1"></span>Disable
                      Property</a></div>
                  <div class="uk-margin-small-bottom"><a class="uk-border-rounded uk-button uk-button-small  red white-text" onclick="confirm_action(event, this)"
                      href="#" uk-tooltip="Delete Property">
                      <span class="uk-icon-link uk-margin-small-right white-text"
                        uk-icon="icon:trash; ratio:1"></span>Delete Property
                    </a></div>
                  <div class="uk-margin-small-bottom"><a class="uk-border-rounded uk-button uk-button-small  blue white-text" onclick="confirm_action(event, this)"
                      href="#" uk-tooltip="View Property Owner">
                      <span class="uk-icon-link uk-margin-small-right white-text"
                        uk-icon="icon:user; ratio:1"></span>View
                      Property
                      Owner</a></div>
                  <div class="uk-margin-small-bottom"><a class="uk-border-rounded uk-button uk-button-small red white-text" onclick="confirm_action(event, this)"
                      href="#" uk-tooltip="Block Property Owner">
                      <span class="uk-icon-link uk-margin-small-right white-text"
                        uk-icon="icon:user; ratio:1"></span>Block
                      Property
                      Owner</a></div>
                  <div class="uk-margin-small-bottom"><a class="uk-border-rounded uk-button uk-button-small  green white-text" onclick="confirm_action(event, this)"
                      href="#" uk-tooltip="Resolve Report">
                      <span class="uk-icon-link uk-margin-small-right white-text"
                        uk-icon="icon:check; ratio:1"></span>Resolve Report
                    </a></div>








                </div>
              </div>

            </div>
          </li>
          @endforeach
        </ul>
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
