<div class="modal-header">
    <h5 class="modal-title" id="exampleModalCenterTitle">Add {{ $student->name}} Acadmics Details</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<form action="/store_acadmics" method="post" id="add_acadmics" enctype="multipart/form-data">
    @csrf
    <div class="modal-body">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group row">
                    <div class="col-md-6">
                        <label for="basicInput">Father Name</label>
                        <input type="hidden" value="{{ $student->id }}" name="student_id" id="student_id">
                        @if($acadmics)
                        <input type="hidden" value="{{ $acadmics->id }}" name="ledger_id" id="ledger_id">
                        <input type="text" value="{{$acadmics->father_name}}" class="form-control mb-2" placeholder="Enter Father name" name="father_name" id="father_name" required>
                        @else
                        <input type="text" class="form-control mb-2" placeholder="Enter Father name" name="father_name" id="father_name" required>
                        @endif
                    </div>

                    <div class="col-md-6">
                        <label for="basicInput">Mother Name</label>
                        @if($acadmics)
                        <input type="text" value="{{$acadmics->mother_name}}" class="form-control mb-2" placeholder="Enter Mother name" name="mother_name" id="mother_name" required>
                        @else
                        <input type="text" class="form-control mb-2" placeholder="Enter Mother name" name="mother_name" id="mother_name" required>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <label for="basicInput">Gender</label>
                        <select name="gender" id="gender" class="form-control mb-2" required>
                            @if($acadmics)
                            <option value="{{$acadmics->gender}}">{{$acadmics->gender}}</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>
                            @else
                            <option value="">Choose</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>
                            @endif

                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="basicInput">Category</label>
                        <select name="category" id="category" class="form-control mb-2" required>
                            @if($acadmics)
                            <option value="{{$acadmics->category}}">{{$acadmics->category}}</option>
                            <option value="General">General</option>
                            <option value="OBC">OBC</option>
                            <option value="SC">SC</option>
                            <option value="ST">ST</option>
                            @else
                            <option value="">Choose</option> 
                            <option value="General">General</option>
                            <option value="OBC">OBC</option>
                            <option value="SC">SC</option>
                            <option value="ST">ST</option>
                            @endif

                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="basicInput">Employment Status</label>
                        <select name="emp_tatus" id="emp_tatus" class="form-control mb-2" required>
                            @if($acadmics)
                                <option value="{{$acadmics->employment_status}}">{{$acadmics->employment_status}}</option> 
                                <option value="Employed">Employed</option>
                                <option value="Unemployed">Unemployed</option>
                            @else
                                <option value="">Choose</option> 
                                <option value="Employed">Employed</option>
                                <option value="Unemployed">Unemployed</option>
                            @endif
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="basicInput">Adhar Number</label>
                        @if($acadmics)
                        <input type="text" class="form-control mb-2 card_number" minlength="14" maxlength="14" value="{{$acadmics->adhar_number}}" placeholder="Adhar number" name="adhar_number" id="adhar_number" required>
                        @else
                        <input type="text" class="form-control mb-2 card_number" minlength="14" maxlength="14" placeholder="Adhar number" name="adhar_number" id="adhar_number" required>
                        @endif
    
                    </div>
                    <div class="col-md-6">
                        <label for="basicInput">Nationality</label>
                        <select name="nationality" id="nationality" class="form-control mb-2" required>
                            @if($acadmics)
                                <option value="{{$acadmics->employment_status}}">{{$acadmics->nationality}}</option> 
                                <option value="Indian">Indian</option>
                                <option value="Other">Other</option>
                            @else
                                <option value="">Choose</option> 
                                <option value="Indian">Indian</option>
                                <option value="Other">Other</option>
                            @endif
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="basicInput">Pincode</label>
                        @if($acadmics)
                        <input type="text" value="{{$acadmics->pincode}}" class="form-control mb-2" placeholder="Enter pincode" name="pincode" id="pincode" onchange="get_add(this.value);" required>
                        @else
                        <input type="text" class="form-control mb-2" placeholder="Enter pincode" name="pincode" id="pincode" onchange="get_add(this.value);" required>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <label for="basicInput">City</label>
                        @if($acadmics)
                            <select name="city" id="city" class="form-control mb-2" required>
                                <option value="{{$acadmics->city}}">{{$acadmics->city}}</option> 
                            </select>
                        @else
                        <select name="city" id="city" class="form-control mb-2" required>
                            <option value="">Choose</option> 
                        </select>
                        @endif
                    </div>

                    <div class="col-md-6">
                        <label for="basicInput">District</label>
                        @if($acadmics)
                        <input type="text" value="{{$acadmics->distric}}" class="form-control mb-2" value="" name="district" id="district" readonly>
                        @else
                        <input type="text" class="form-control mb-2" value="" name="district" id="district" readonly>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <label for="basicInput">State</label>
                        @if($acadmics)
                        <input type="text" value="{{$acadmics->state}}" class="form-control mb-2" value="" name="state" id="state" readonly>
                        @else
                        <input type="text" class="form-control mb-2" value="" name="state" id="state" readonly>
                        @endif
                    </div>

                    <div class="col-md-6">
                        <label for="basicInput">Photo</label>
                        @if($acadmics)
                        <input type="file" name="signature" placeholder="select file" class="form-control">
                            <span><img src="/admin/student_photo/{{$acadmics->photo}}" style="width:60px"></span>
                        @else
                        <input type="file" name="photo" placeholder="select file" class="form-control" value="" required>
                        @endif
                        
                    </div>
                    <div class="col-md-6">
                        <label for="basicInput">Signature</label>
                        @if($acadmics)
                            <input type="file" name="signature" placeholder="select file" class="form-control">
                            <span><img src="/admin/student_signature/{{$acadmics->signature}}" style="width:60px"></span>
                        @else
                            <input type="file" name="signature" placeholder="select file" class="form-control" value="" required>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
        @if($acadmics)
        <button type="submit" class="btn btn-primary">Update</button>
        @else
        <button type="submit" class="btn btn-primary">Save</button>
        @endif
    </div>
</form>
 <script>
    $(function(){
    $("#add_acadmics").on("submit", function(e){
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
    function get_add(pincode) {
        console.log(pincode, 'sandip');
        $.ajax({
            url: "https://api.postalpincode.in/pincode/" + pincode,
            cache: false,
            dataType: "json",
            type: "GET",
            data: "zip=" + pincode,
            success: function(result) {
            console.log(result);
            var cityhtml = "";
            var districthtml = '';
            var statehtml ='';
                jQuery.each(result, function( index, value ) {
                    // console.log( "index", index, "value", value );
                    jQuery.each(value.PostOffice, function( key, value11 ) {
                        console.log( "key", index, "value11", value11.Name );
                        var cityvalue = value11.Name.replace(/\s+/g, '_');
                        console.log(cityvalue);
                        cityhtml += '<option value='+cityvalue+' selected>'+value11.Name+'</option>';
                        districthtml = value11.District;
                        statehtml = value11.State;
                    });  
                });

            $("#city").html(cityhtml); /* Fill the data */
            $("#district").val(districthtml);
            $("#state").val(statehtml);
        
            $(".zip-error").hide(); /* In case they failed once before */
        
            $("#address-line-1").focus(); /* Put cursor where they need it */ 
            },
            error: function(result, success) {
        
            $(".zip-error").show(); /* Ruh row */
        
            }
        
        });
        // alert("The input value has changed. The new value is: " + val);
    }
</script>
<script>
    adhar_number.addEventListener('keyup',function (e) {
        if (e.keyCode !== 8) {
            if (this.value.length === 4 || this.value.length === 9) {
                this.value = this.value += '-';
            }
        }
    });
</script>
