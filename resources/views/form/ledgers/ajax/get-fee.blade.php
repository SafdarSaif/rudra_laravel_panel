<div class="modal-header">
    <h5 class="modal-title" id="exampleModalCenterTitle">Add Fee</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<form action="/update_ledgers" method="post" id="add_data" enctype="multipart/form-data">
    @csrf
<div class="modal-body">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group row">
                <div class="col-md-12">
                    <label for="basicInput">Student Name</label>
                    <input type="hidden" value="{{$ledgers->id}}" name="id" id="id">
                    <input type="text" class="form-control mb-2" value="{{$ledgers->name}}" placeholder="Enter ledgers Name" name="name" id="name" readonly>
                </div>
                <div class="col-md-6">
                    <label for="basicInput">Due Fee</label>
                    <input type="text" class="form-control mb-2" value="{{$ledgers->due_ammount}}" placeholder="Total Fee of course" name="due_fee" id="due_fee" readonly>
                </div>
                <div class="col-md-6">
                    <label for="basicInput">Received amount</label>
                    <input type="text" class="form-control mb-2" value="" placeholder="Received Fee.." onchange="receiveFee('{{ $ledgers->student_id }}');" name="received_fee" id="received_fee" require>
                </div>
                <div class="col-md-6">
                    <label for="image">Attachments</label>
                    <input type="file" name="image" placeholder="select file" class="form-control" value="">
                </div>
                <div class="col-md-6">
                    <label for="basicInput">Transaction ID</label>
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
<script>
    function receiveFee(id){
        var recieved = $('#received_fee').val();
        var due = $('#due_fee').val();
        var rem_amt = due - recieved;
        if(rem_amt < 0){
            $('#received_fee').val('');
            alert('you can not add grater than due ammount');
        }
    }
</script>
