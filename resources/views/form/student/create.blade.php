<div class="modal-header">
    <h5 class="modal-title" id="exampleModalCenterTitle">Add Student</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
@php
$unis=DB::select("select * from universities order by id asc");
$users = DB::select("select * from users order by id asc");
$courses=DB::select("select * from courses order by id asc");
@endphp

<form action="/add_student" method="post" id="add_data" enctype="multipart/form-data">
    @csrf
<div class="modal-body">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group row">
                <div class="col-md-6">
                    <label for="basicInput">Student Name</label>
                    <input type="text" class="form-control mb-2" placeholder="Enter Student Name" name="name" id="name" required>
                </div>

                <div class="col-md-6">
                    <label for="basicInput">Student Email</label>
                    <input type="text" class="form-control mb-2" placeholder="Enter Email" name="email" id="email" required>
                </div>

                <div class="col-md-6">
                    <label for="basicInput">Student Phone</label>
                    <input type="text" class="form-control mb-2" placeholder="Enter Phone" name="phone" id="phone" required>
                </div>

                <div class="col-md-6">
                    <label for="basicInput">Select Owner</label>
                    <select name="owner_id" class="form-control mb-2" required>
                        <option value="">Choose</option>
                        @foreach ($users as $user)
                        <option value="{{$user->id}}">{{$user->name}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label for="basicInput">Sem/Year</label>
                    <select name="sem_year" class="form-control mb-2" required>
                        <option value="">Choose</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="basicInput">Select University</label>
                    <select name="university_id" class="form-control mb-2" required>
                        <option value="">Choose</option>
                        @foreach ($unis as $uni)
                        <option value="{{$uni->id}}">{{$uni->name}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label for="basicInput">Select Course</label>
                    <select name="course_id" class="form-control mb-2" required>
                        <option value="">Choose</option>
                        @foreach ($courses as $course)
                        <option value="{{$course->id}}">{{$course->name}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label for="basicInput">Sub Course (Optional)</label>
                    <input type="text" class="form-control mb-2" placeholder="EnterSub Course" name="sub_course" id="sub_course" >
                </div>

                <div class="col-md-6">
                    <label for="basicInput">session</label>
                    <input type="text" class="form-control mb-2" placeholder="Enter session" name="session" id="session" required>
                </div>

                <div class="col-md-6">
                    <label for="basicInput">DOB</label>
                    <input type="date" class="form-control mb-2" placeholder="Enter University Name" name="dob" id="dob" required>
                </div>
                 <div class="col-md-6">
                    <label for="basicInput">Payment Mode</label>
                    <select class="form-control mb-2" name="mode" id="mode" required>
                        <option value="online">Online</option>
                        <option value="cash">Cash</option>
                    </select>
                </div> 

                <div class="col-md-6">
                    <label for="basicInput">Total Fee</label>
                    <input type="text" class="form-control mb-2" placeholder="Total Fee of course" name="total_fee" id="total_fee" required>
                </div>
                <div class="col-md-6">
                    <label for="basicInput">Registration fee</label>
                    <input type="text" class="form-control mb-2" placeholder="Enter Recived amount at time of registaion" name="registration_fee" id="registration_fee" required>
                </div>
                <div class="col-md-4">
                    <label for="basicInput">Attach(Optional)</label>
                    <input type="file" name="attachment" placeholder="select file" class="form-control" value="">
                </div>
                <div class="col-md-4">
                    <label for="basicInput">FAVOUR (Optional)</label>
                    <input type="text" class="form-control mb-2" value="" placeholder="Favour to" name="favour" id="favour">
                </div>
                <div class="col-md-4">
                    <label for="basicInput">Tran.. ID(Optional)</label>
                    <input type="text" class="form-control mb-2" value="" placeholder="Enter Recived amount at time of registaion" name="provided_transaction_id" id="provided_transaction_id">
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
