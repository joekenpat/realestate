@extends('layouts.admin')
@section('title', "All Categories")
@section('content')

<div class="" uk-grid>
  <div class="uk-width-1-1">
    <div class="uk-card uk-card-default uk-border-rounded">
      <div class="uk-card-header uk-padding-small">
        <h3>All Categories</h3>
      </div>
      <div class="uk-card-body uk-padding-remove">
        <table class="uk-table uk-table-small uk-table-divider uk-table-middle">
          <thead>
            <tr>
              <th>Image</th>
              <th>Name</th>
              <th>Subcategories</th>
              <th>Ad Count</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($categories as $category)
            <tr>
              <td>
                <img
                  src="{{$category->image != null?URL::to(sprintf("images/categories/%s",$category->image)):asset("images/misc/default_avatar.png") }}"
                  class="uk-border-circle" style="height:40px;width:40px;object-fit:cover;"
                  alt="{{$category->name}} profile  image">
              </td>
              <td>{{$category->name}}</td>
              <td>{{$category->subcategories()->count()}}</td>
              <td>{{$category->properties()->count()}}</td>
              <td>
                <div>
                  <a onclick="confirm_action(event, this)" href="{{route('admin_edit_category',['category_id'=> $category->id])}}" style="color:yellow" uk-tooltip="Edit Category"
                    class="uk-icon-link uk-margin-small-right" uk-icon="icon:file-edit; ratio:1"></span></a>
                  <a onclick="confirm_action(event, this)" href="#" style="color:red" uk-tooltip="Delete Category"
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
