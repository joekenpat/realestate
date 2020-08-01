@extends('layouts.admin')
@section('title', "Active Properties")
@section('content')

<admin-list-property property_status="active" />
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
