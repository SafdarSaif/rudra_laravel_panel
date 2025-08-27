@extends('layouts.main')

@if(Auth::guard('webadmin')->user()->roles == 'Admin')
@section('content')
<div class="content-body">
  <div class="container-fluid">
    <div class="row">
      <div class="col-xl-12 col-xxl-12 bst-seller">
        <div class="card">
          <div class="card-body p-0">
            <div class="table-responsive active-projects style-1 ItemsCheckboxSec shorting ">
              <div class="tbl-caption">
                <h4 class="heading mb-0">Users</h4>
                <div>
                  <a class="btn btn-primary btn-sm me-2" href="javascript:void(0);" onclick="add_user();" role="button">+ Add user</a>
                </div>
              </div>
              <div class="table-responsive">
                <table id="example3" class="display table" style="min-width: 845px">
                  <thead>
                    <tr>
                      <th>S.No</th>
                      <th>Name</th>
                      <th>email</th>
                      <th>Role</th>
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($users ?? '' as $index => $user)
                    <tr>
                      <td>{{$index+1}}</td>
                      <td>{{$user->name}}</td>
                      <td>{{$user->email}}</td>
                      <td>{{$user->roles}}</td>
                      <td>@if($user->status ==1)
                        <a href="javascript:void(0);" type="button" onclick="changestatus('active','{{ $user->id}}', 'user')" class="btn btn-success btn-sm mr-1" style="margin-right:5px;">Active</a>
                        @else
                        <a href="javascript:void(0);" type="button" onclick="changestatus('inactive', '{{ $user->id}}', 'user')" class="btn btn-danger btn-sm mr-1" style="margin-right:5px;">Inactive</a>
                        @endif
                      </td>

                      <td>
                        <a href="javascript:void(0);" onclick="edit_user('{{ $user->id }}');" class="btn btn-primary shadow btn-xs sharp me-1"><i class="fas fa-pencil-alt"></i></a>
                        <a href="javascript:void(0);" onclick="deleteuser('{{$user->id}}');" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></a>
                      </td>
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
</div>
@endsection
@section('scripts')
<script>
  function add_user() {
    $.ajax({
      url: '/create_user',
      success: function(data) {
        $('#add_modal_content').html(data);
        $('#add_modal').modal('show');
      }
    })
  }

  function edit_user(id) {
    $.ajax({
      url: '/edit_user/' + id,
      success: function(data) {
        $('#add_modal_content').html(data);
        $('#add_modal').modal('show');
      }
    })
  }
</script>
<script>
  function deleteuser(id) {
    Swal.fire({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: '/deleteuser/' + id,
          success: function(data) {
            if (data.status == 200) {
              Swal.fire(
                'Deleted!',
                'Your file has been deleted.',
                'success'
              )
              setTimeout(() => {
                window.location.reload();
              }, 1000);
            } else {
              Swal.fire(
                'Oops!',
                'Something went wrong.',
                'error'
              )
            }
          }
        })

      }
    })
  }
</script>
@endsection
@else
@php
Session::flush();
Auth::logout();
header("Location:/"); exit;
@endphp
<script>
  window.location.href = "/login";
</script>
@endif