@extends('layouts.main')
@if(Auth::guard('webadmin')->user()->roles == 'Admin' || Auth::guard('webadmin')->user()->roles == 'Manager')
@section('content')
 <div class="content-body">
    <div class="container-fluid">
       <div class="row">
          <div class="col-xl-12 col-xxl-12 bst-seller">
             <div class="card">
                <div class="card-body p-0">
                   <div class="table-responsive active-projects style-1 ItemsCheckboxSec shorting ">
                      <div class="tbl-caption">
                         <h4 class="heading mb-0">Courses</h4>
                         <div>
                            <a class="btn btn-primary btn-sm me-2"  href="javascript:void(0);" onclick="add_course();" role="button">+ Add Course</a>
                         </div>
                      </div>
                      <div class="table-responsive">
                        <table id="example3" class="display table" style="min-width: 845px">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($courses ?? '' as $index => $course)
                            <tr>
                                <td>{{$index+1}}</td>
                                <td>{{$course->name}}</td>
                                <td>
                                    <a href="javascript:void(0);" onclick="edit_course('{{ $course->id }}');"  class="btn btn-primary shadow btn-xs sharp me-1"><i class="fas fa-pencil-alt"></i></a>
                                    <a href="javascript:void(0);" onclick="deletecourse({{$course->id}});" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></a>
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

    function add_course(){
    $.ajax({
            url:'/create_course',
            success: function(data){
                $('#add_modal_content').html(data);
                $('#add_modal').modal('show');
            }
        })
    }

    function edit_course(id){
    $.ajax({
            url:'/edit_course/'+id,
            success: function(data){
                $('#add_modal_content').html(data);
                $('#add_modal').modal('show');
            }
        })
    }

    </script>
 <script>
    function deletecourse(id){
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
                url:'/deletecourse/'+id,
                success: function(data){
                  if(data.status==200){
                    Swal.fire(
                      'Deleted!',
                      'Your file has been deleted.',
                      'success'
                    )
                    setTimeout(() => {
                          window.location.reload();
                      }, 1000);
                  }else{
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