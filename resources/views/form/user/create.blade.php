<div class="modal-header">
    <h5 class="modal-title" id="exampleModalCenterTitle">Add User</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<form action="/add_user" method="post" id="add_data" enctype="multipart/form-data">
    @csrf
<div class="modal-body">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group row">
                <div class="col-md-12">
                    <label for="basicInput">Name</label>
                    <input type="text" class="form-control mb-2" placeholder="Enter Name" name="name" id="name" required>
                </div>

                <div class="col-md-12">
                    <label for="basicInput">Email</label>
                    <input type="text" class="form-control mb-2" placeholder="Enter email" name="email" id="email" required>
                </div>

                <div class="col-md-12">
                    <label for="basicInput">Role</label>
                    <select name="roles" id="roles" class="form-control mb-2" required>
                        <option value="">Select</option>
                        <option value="Counsellor">Counsellor</option>
                        <option value="Manager">Manager</option>
                    </select>
                </div>

                <div class="col-md-12">
                    <label for="basicInput">Password</label>
                    <input type="text" class="form-control mb-2" placeholder="enter password" name="password" id="password" required>
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
