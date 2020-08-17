@extends('layouts.admin')
@section('title', "Reported User")
@section('content')

<div class="" uk-grid>
  <div class="uk-width-1-1">
    <div class="uk-card uk-card-default uk-border-rounded">
      <div class="uk-card-header uk-padding-small">
        <h3>Reported Users</h3>
      </div>
      <div class="uk-card-body uk-padding-remove">
        <table class="uk-table uk-table-small uk-table-divider uk-table-middle">
          <thead>
            <tr>
              <th>Image</th>
              <th>Name</th>
              <th>Role</th>
              <th>Email</th>
              <th>Phone</th>
              <th>Ad Count</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($users as $user)
            <tr>
              <td>
                <img
                  src="{{$user->avatar != null?URL::to(sprintf("images/users/profile/%s/%s",$user->id,$user->avatar)):asset("images/misc/default_avatar.png") }}"
                  class="uk-border-circle" style="height:40px;width:40px;object-fit:cover;"
                  alt="{{$user->get_full_name()}} profile  image">
              </td>
              <td>{{$user->get_full_name()}}</td>
              <td>{{$user->role}}</td>
              <td>{{$user->email}}</td>
              <td>{{$user->phone}}</td>
              <td>{{$user->properties()->count()}}</td>
              <td>
                <div>
                  <a onclick="confirm_action(event, this)" href="#" style="color:blue" uk-tooltip="View User"
                    class="uk-icon-link uk-margin-small-right" uk-icon="icon:user; ratio:1"></span></a>
                  <a onclick="confirm_action(event, this)" href="#" style="color:yellow" uk-tooltip="Edit User"
                    class="uk-icon-link uk-margin-small-right" uk-icon="icon:file-edit; ratio:1"></span></a>
                  <a onclick="confirm_action(event, this)" href="#" style="color:green" uk-tooltip="Unblock User"
                    class="uk-icon-link uk-margin-small-right" uk-icon="icon:check; ratio:1"></span></a>
                  <a onclick="confirm_action(event, this)" href="#" style="color:red" uk-tooltip="Delete User"
                    class="uk-icon-link uk-margin-small-right" uk-icon="icon:trash; ratio:1"></span></a>
                </div>
              </td>
            </tr>
            @endforeach
          </tbody>

        </table>
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
