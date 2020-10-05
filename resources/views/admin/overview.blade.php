@extends('layouts.admin')
@section('title', "Admin home")
@section('content')

<div class="" uk-grid>
  <div class="uk-width-1-1">
    <div class="uk-grid uk-grid-small uk-child-width-1-1 uk-child-width-1-2@s uk-child-width-1-4@m">
      <div>
        <div class="uk-card uk-card-default">
          <div class="uk-card-body uk-padding-remove">
            <span class="uk-padding-small uk-border-circle" uk-icon="icon:home; ratio:1.5"></span>
            <span class="uk-label uk-float-right">{{$total_properties}}</span>
            <line-chart :width="330" :height="120" :chartdata="{{ json_encode($pdata) }}"
              :options="{{ json_encode($options) }}" />
          </div>
        </div>
      </div>
      <div>
        <div class="uk-card uk-card-default">
          <div class="uk-card-body uk-padding-remove">
            <span class="uk-padding-small uk-border-circle" uk-icon="icon:users; ratio:1.5"></span>
            <span class="uk-label uk-float-right">{{$total_users}}</span>
            <line-chart :width="330" :height="120" :chartdata="{{ json_encode($udata) }}"
              :options="{{ json_encode($options) }}" />
          </div>
        </div>
      </div>
      <div>
        <div class="uk-card uk-card-default">
          <div class="uk-card-body uk-padding-remove">
            <span class="uk-padding-small uk-border-circle" uk-icon="icon:cart; ratio:1.5"></span>
            <span class="uk-label uk-float-right">{{$total_transactions}}</span>
            <line-chart :width="330" :height="120" :chartdata="{{ json_encode($tdata) }}"
              :options="{{ json_encode($options) }}" />
          </div>
        </div>
      </div>
      <div>
        <div class="uk-card uk-card-default">
          <div class="uk-card-body uk-padding-remove">
            <span class="uk-padding-small uk-border-circle" uk-icon="icon:album; ratio:1.5"></span>
            <span class="uk-label uk-float-right">{{$total_posts}}</span>
            <line-chart :width="330" :height="120" :chartdata="{{ json_encode($tdata) }}"
              :options="{{ json_encode($options) }}" />
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="uk-width-1-1">
    <div class="uk-grid-small" uk-grid>
      <div class="uk-width-1-1 uk-width-1-2@m">
        <div>
          <div class="uk-card uk-card-default uk-border-rounded">
            <div class="uk-card-header uk-padding-small">
              <h3>Recent Users</h3>
            </div>
            <div class="uk-card-body uk-padding-remove">
              <table class="uk-table uk-table-small uk-table-divider uk-table-middle">
                <thead>
                  <tr>
                    <th>Avatar</th>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Referer</th>
                    <th>Gender</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($latest_users as $user)
                  <tr>
                    <td class="uk-text-small">
                      <img
                        src="{{$user->avatar != null?URL::to(sprintf("images/users/profile/%s/%s",$user->id,$user->avatar)):asset("images/misc/default_avatar.png") }}"
                        class="uk-border-circle" style="height:40px;width:40px;object-fit:cover;"
                        alt="{{$user->get_full_name()}} profile image">
                    </td>
                    <td class="uk-text-small">{{$user->get_full_name()}}</td>
                    <td class="uk-text-small">{{$user->phone}}</td>
                    <td class="uk-text-small">{{$user->refererUsername?:'NONE'}}</td>
                    <td class="uk-text-small">{{ucwords($user->gender)}}</td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="uk-width-1-1 uk-width-1-2@m">
        <div>
          <div class="uk-card uk-card-default uk-border-rounded">
            <div class="uk-card-header uk-padding-small">
              <h3>Recent Properties</h3>
            </div>
            <div class="uk-card-body uk-padding-remove">
              <table class="uk-table uk-table-small uk-table-divider uk-table-middle">
                <thead>
                  <tr>
                    <th>Image</th>
                    <th>Title</th>
                    <th>Location</th>
                    <th>Price</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($latest_properties as $property)
                  <tr>
                    <td>
                      <img
                        src="{{$property->images != []?URL::to(sprintf("images/properties/%s/%s",$property->id,$property->images[0])):asset("images/misc/default_avatar.png") }}"
                        class="uk-border-circle" style="height:40px;width:40px;object-fit:cover;"
                        alt="{{$property->title}} first image">
                    </td>
                    <td>{{$property->title}}</td>
                    <td>{{$property->state->name}},{{$property->city->name}}</td>
                    <td>N{{$property->price}}</td>
                  </tr>
                  @endforeach
                </tbody>

              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>
@endsection
