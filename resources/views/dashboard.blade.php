@extends('layouts.main')

@section('content')


 <div class="content-body">
    <div class="container-fluid">
       <div class="row">
        <div class="col-xl-6">
            <div class="card overflow-hidden">
                <div class="card-body">
                    <div class="any-card">
                        <div class="c-con">
                            <h4 class="heading mb-0">Congratulations <strong>Hanu!!</strong><img src="images/crm/party-popper.png" alt=""></h4>
                            <span>Good luck</span>
                            <p class="mt-3">lets achive this Month milestone together😎 </p>

                            <a href="#" class="btn btn-primary btn-sm">View Profile</a>
                        </div>
                        <img src="images/analytics/developer_male.png" class="harry-img" alt="">

                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-md-6">
            <div class="card bg-primary">
                <div class="card-header border-0">
                    <h4 class="heading mb-0 text-white">Overview Of Sales 😎</h4>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div class="sales-bx">
                            <img src="images/analytics/sales.png" alt="">
                            <h4>{{$total_ammount}}</h4>
                            <span>Total Sales</span>
                        </div>
                        <div class="sales-bx">
                            <img src="images/analytics/shopping.png" alt="">
                            <h4>{{$total_received_ammount}}</h4>
                            <span>Total Received Fee</span>
                        </div>
                        <div class="sales-bx">
                            <img src="images/analytics/sales.png" alt="">
                            <h4>{{$total_due}}</h4>
                            <span>Total Due</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
       </div>
    </div>
 </div>




@endsection
