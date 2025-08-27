<div class="modal fade" id="add_modal">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" id="add_modal_content">


        </div>
    </div>
</div>



 {{-- <div class="text-left modal fade" id="add_modal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel18" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" id="add_modal_content1">

        </div>
    </div>
</div> --}}

<div class="text-left modal fade" id="edit_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel18" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" id="edit_modal_content">

        </div>
    </div>
</div>

 <!-- Vertically centered modal -->
 <!--**********************************
    Content body end
    ***********************************-->
 <!--**********************************
    Footer start
    ***********************************-->
 <div class="footer">
    <div class="copyright">
       <p>Copyright © Developed by <a href="#" target="_blank">primusvidya</a> 2023</p>
    </div>
 </div>

 <script src="/admin/vendor/global/global.min.js"></script>
 <!-- Dashboard 1 -->
 {{-- <script src="/admin/js/dashboard/dashboard-2.js"></script> --}}
 <!-- tagify -->
 <script src="/admin/vendor/datatables/js/jquery.dataTables.min.js"></script>
 <script src="/admin/vendor/datatables/js/dataTables.buttons.min.js"></script>
 <script src="/admin/vendor/datatables/js/buttons.html5.min.js"></script>
 <script src="/admin/vendor/datatables/js/jszip.min.js"></script>
 <script src="/admin/js/plugins-init/datatables.init.js"></script>
 <!-- Apex Chart -->
 <!-- Vectormap -->
 <script src="/admin/js/custom.js"></script>
 <script src="/admin/js/deznav-init.js"></script>
 {{-- <script src="/admin/js/demo.js"></script> --}}
 <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function changestatus(status, id, module){
        // $.ajax({
        //     url: 'changestatus-'.module,
        //     type: 'POST',
        //     data: {"id":id, 'status':status},
        //     success: function(data) {
        //         if(data.status=='200'){
        //             $('.modal').modal('hide');
        //             toastr.success(data.msg);
        //             setTimeout(() => {
        //                 window.location.reload();
        //             }, 2000);
        //         }else{
        //             toastr.error(data.errors);
        //         }
        //     }
        // })

        $.ajax({
            url: 'changestatus-user',
            type: 'POST',
            data: {
                "_token": "{{ csrf_token() }}",
                "id": id,
                'status':status
                },
            dataType: 'JSON',
            success: function (data) {
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
    }
</script>
