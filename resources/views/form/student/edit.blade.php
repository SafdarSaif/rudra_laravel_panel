<div class="modal-header">
    <h5 class="modal-title" id="exampleModalCenterTitle">Add Student</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<form action="/update_student/{{$student->id}}" method="post" id="add_data" enctype="multipart/form-data">
    @csrf
<div class="modal-body">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group row">
                <div class="col-md-12">
                    <label for="basicInput">Student Name</label>
                    <input type="text" class="form-control mb-2" value="{{$student->name}}" placeholder="Enter Student Name" name="name" id="name" required>
                </div>

                <div class="col-md-6">
                    <label for="basicInput">Student Email</label>
                    <input type="text" class="form-control mb-2" value="{{$student->email}}" placeholder="Enter Email" name="email" id="email" required>
                </div>

                <div class="col-md-6">
                    <label for="basicInput">Student Phone</label>
                    <input type="text" class="form-control mb-2" value="{{$student->phone}}" placeholder="Enter Phone" name="phone" id="phone" required>
                </div>

                <div class="col-md-12">
                    <label for="basicInput">Select University</label>
                    <select name="university_id" class="form-control mb-2">
                        <option value="">Choose</option>
                        @foreach ($unis as $uni)
                        <option value="{{$uni->id}}" {{ $uni->id ==$student->university_id ? 'selected' : '' }}> {{$uni->name}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label for="basicInput">Select Course</label>
                    <select name="course_id" class="form-control mb-2">
                        <option value="">Choose</option>
                        @foreach ($courses as $course)
                        <option value="{{$course->id}}" {{ $course->id==$student->course_id ? 'selected' : '' }}> {{$course->name}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label for="basicInput">Sub Course (Optional)</label>
                    <input type="text" class="form-control mb-2" value="{{$student->sub_course}}" placeholder="EnterSub Course" name="sub_course" id="sub_course" >
                </div>

                <div class="col-md-6">
                    <label for="basicInput">session</label>
                    <input type="text" class="form-control mb-2" value="{{$student->session}}" placeholder="Enter session" name="session" id="session" required>
                </div>

                <div class="col-md-6">
                    <label for="basicInput">DOB</label>
                    <input type="date" class="form-control mb-2" value="{{$student->dob}}" placeholder="Enter University Name" name="dob" id="dob" required>
                </div>

                <div class="col-md-12">
                    <label for="basicInput">Total Fee</label>
                    <input type="text" class="form-control mb-2" value="{{$student->total_fee}}" placeholder="Total Fee of course" name="total_fee" id="total_fee" required>
                </div>
                <div class="col-md-12">
                    <label for="basicInput">Registration fee</label>
                    <input type="text" class="form-control mb-2" value="{{$student->registration_fee}}" placeholder="Enter Recived amount at time of registaion" name="registration_fee" id="registration_fee" required>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
    <button type="submit" class="btn btn-primary">Save</button>
</div>
</form>


 <script>
    $(function(){
    $("#add_data").on("submit", function(e){
      e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url: this.action,
            type: 'post',
            data: formData,
            cache:false,
            contentType: false,
            processData: false,
            success: function(data) {
                if(data.status=='200'){
                    $('.modal').modal('hide');
                    toastr.success(data.msg);
                    setTimeout(() => {
                        window.location.reload();
                    }, 2000);
                }else{
                    toastr.error(data.errors);
                }
            }
        });
    });
});
</script>
