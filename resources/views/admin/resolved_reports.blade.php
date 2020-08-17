@extends('layouts.admin')
@section('title', "Resolved Reports")
@section('content')

<div class="" uk-grid>
  <div class="uk-width-1-1">
    <div class="uk-card uk-card-default uk-border-rounded">
      <div class="uk-card-header uk-padding-small">
        <h3>Resolved Reports</h3>
      </div>
      <div class="uk-card-body uk-padding-remove">
        <ul uk-accordion="active: 0">
          @foreach ($reports as $report)
          <li>
            <a class="uk-accordion-title" href="#">{{$report->title}}</a>
            <div class="uk-accordion-content">
              <p>{{$report->message}}</p>
              <div>
                <a onclick="confirm_action(event, this)" href="#" style="color:blue" uk-tooltip="View Reporter"
                  class="uk-icon-link uk-margin-small-right" uk-icon="icon:user; ratio:1"></span>Reporter</a>
                <a onclick="confirm_action(event, this)" href="#" style="color:yellow" uk-tooltip="Block Reporter"
                  class="uk-icon-link uk-margin-small-right" uk-icon="icon:user; ratio:1"></span>Reporter</a>
                <a onclick="confirm_action(event, this)" href="#" style="color:green" uk-tooltip="View Property"
                  class="uk-icon-link uk-margin-small-right" uk-icon="icon:home; ratio:1"></span></a>
                <a onclick="confirm_action(event, this)" href="#" style="color:home" uk-tooltip="Disable Property"
                  class="uk-icon-link uk-margin-small-right" uk-icon="icon:ban; ratio:1"></span></a>
                <a onclick="confirm_action(event, this)" href="#" style="color:red" uk-tooltip="Delete Property"
                  class="uk-icon-link uk-margin-small-right" uk-icon="icon:trash; ratio:1"></span></a>
                <a onclick="confirm_action(event, this)" href="#" style="color:blue" uk-tooltip="View Property Owner"
                  class="uk-icon-link uk-margin-small-right" uk-icon="icon:user; ratio:1"></span>Property Owner</a>
                <a onclick="confirm_action(event, this)" href="#" style="color:yellow" uk-tooltip="Block Property Owner"
                  class="uk-icon-link uk-margin-small-right" uk-icon="icon:user; ratio:1"></span>Property Owner</a>
                <a onclick="confirm_action(event, this)" href="#" style="color:red" uk-tooltip="Resolve Report"
                  class="uk-icon-link uk-margin-small-right" uk-icon="icon:check; ratio:1"></span></a>
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
