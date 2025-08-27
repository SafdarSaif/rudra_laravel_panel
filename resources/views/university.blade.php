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
                         <h4 class="heading mb-0">Universities</h4>
                         <div>
                            <a class="btn btn-primary btn-sm me-2"  href="javascript:void(0);" onclick="add_university();" role="button">+ Add University</a>
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
                            @foreach ($unis ?? '' as $index => $uni)
                            <tr>
                                <td>{{$index+1}}</td>
                                <td>{{$uni->name}}</td>
                                <td>
                                    <a href="javascript:void(0);" onclick="edit_university('{{ $uni->id }}');"  class="btn btn-primary shadow btn-xs sharp me-1"><i class="fas fa-pencil-alt"></i></a>
                                    <a href="javascript:void(0);" onclick="deleteuniversity({{$uni->id}});" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></a>
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

    function add_university(){
    $.ajax({
            url:'/create_university',
            success: function(data){
                $('#add_modal_content').html(data);
                $('#add_modal').modal('show');
            }
        })
    }

    function edit_university(id){
    $.ajax({
            url:'/edit_university/'+id,
            success: function(data){
                $('#add_modal_content').html(data);
                $('#add_modal').modal('show');
            }
        })
    }

    </script>
 <script>
    function deleteuniversity(id){
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
                url:'/deleteuniversity/'+id,
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
