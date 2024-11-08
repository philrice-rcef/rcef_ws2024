@extends('layouts.index')

@section('styles')
  <link rel="stylesheet" href="{{ asset('public/css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('public/assets/iCheck/skins/flat/green.css') }}">
  <link rel="stylesheet" href="{{ asset('public/css/daterangepicker.css') }}">
  <style>
    .tab_link_active {
        color: #fff;
        background-color: #337ab7;
        border-color: #2e6da4;
        text-align: center;
    } 
    .tab_link_active .x_content div span{
        border-bottom: 2px solid white;
    }
    span {
        cursor: pointer;
    }
    .coop-link:hover{
        color: blue;
        text-decoration: underline;
    }

    .tile_count .tile_stats_count:before {
        content: "";
        position: absolute;
        left: 0;
        height: 65px;
        border-left: 0;
        margin-top: 10px;
    }
  </style>
@endsection

@section('content')

    <div class="clearfix"></div>

    @include('layouts.message')

    <div class="col-md-12 col-sm-12 col-xs-12">
	
		<!-- <div class="row">
            <div class="col-md-12" style="margin-bottom: -10px;">
                <div class="alert alert-warning alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <strong><i class="fa fa-info-circle"></i> Reminder:</strong> The system is displaying the latest update as of: <strong><u>{{$latest_mirror_delivery_date}}</u></strong>
                </div>
            </div>
        </div> -->
        <div class="row">
            <div class="col-md-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Dropoff Points</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content form-horizontal form-label-left">
                        <!-- <img src="{{asset('public/images/load_chart.gif')}}" alt="" id="loading_gif" style="display: block;margin: auto;height: 300px;padding-top: 25px;"> -->
                        <!-- <div id="container" style="width:100%; height:400px;" style="display:none"></div> -->
                        <table class="table table-bordered table-striped" id="coop_dop">
                            <thead>
                                <tr>
                                    <th rowspan="2">REGION</th>                               
                                    <th rowspan="2">Province</th>
                                    <th rowspan="2">Municipality</th>
                                    <th colspan="{{ count($varieties) }}" style="text-align: center">Confirmed Deliveries</th>
                                    <th rowspan="2">Total Confirmed</th>
                                    <th rowspan="2">Action</th>
                                </tr> 
                                <tr>
                                @foreach ($varieties as $v)
                                    <th>{{ $v->seed_variety }}</th>
                                @endforeach
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div id="dop_di_modal" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Confirmed vs Inspected deliveries</h4>
                    </div>
                    <div class="modal-body form-horizontal form-label-left">
                        <!-- <input type="hidden" class="form-control" id="member_id" name="member_id"> -->
                        <div id="dop_modal_container"></div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2 style="margin-top: 10px;">Confirmed Deliveries</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content form-horizontal form-label-left">
                        <!--<table class="table table-bordered table-striped" id="delivery_tbl">
                            <thead>
                                <th style="">Seed's Variety</th>
                                <th style="">Delivery Date</th>
                                <th style="">Province</th>
                                <th style="">Municipality</th>
                                <th style="width:150px !important">Drop off Points</th>
                                <th style="">Confirmed</th>
                                <th style="">Inspected</th>
                                <th style="">Status</th>
                                <th>Action</th>
                            </thead>
                        </table>-->
                        @foreach ($provinces as $row)
                            <div class="card">
                                <div class="card-header" id="headingOne">
                                    <h5 class="mb-0" style="margin:0">
                                        <button style="color: #7387a8;text-decoration:none;" class="btn btn-link">
                                            {{$row->region}} < {{$row->province}}
                                        </button>
                                        <a href="#" data-toggle="modal" data-target="#show_region_sched" data-region="{{$row->region}}" data-province="{{$row->province}}" class="btn btn-warning btn-xs pull-right" style="margin-top: 9px;margin-right: 10px;"><i class="fa fa-eye"></i> View Deliveries</a>
                                    </h5>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- SHOW DELIVERY MODAL -->
        <div id="show_region_sched" class="modal fade" role="dialog" style="padding-right:0;">
            <div class="modal-dialog modal-lg" style="width: 1300px; margin: auto; position: relative; top: 7%;">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title" id="region_sched_title">
                            {PROVINCE}
                        </h4>
                        <!--<span id="coop_accreditation_title">{COOP_ACCREDITATION}</span>-->
                    </div>
                    <div class="modal-body" style="max-height: 500px;overflow: auto;">
                        <input type="hidden" id="province_fld" value="">
                        <input type="hidden" id="region_fld" value="">

                        <div class="row">
                            <div class="col-md-4">
                                <div class="x_panel">
                                    <div class="x_title">
                                        <h2>Target Commitment (20kg/bag)</h2>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="x_content form-horizontal form-label-left">
                                        <div class="row tile_count" style="margin: 0">
                                            <div class="col-md-12 col-sm-12 col-xs-12 tile_stats_count" style="padding-bottom: 0;padding-left: 0;">
                                                <div class="count" id="total_commitment">--</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="x_panel">
                                    <div class="x_title">
                                        <h2>Confirmed Deliveries (20kg/bag)</h2>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="x_content form-horizontal form-label-left">
                                        <div class="row tile_count" style="margin: 0">
                                            <div class="col-md-12 col-sm-12 col-xs-12 tile_stats_count" style="padding-bottom: 0;padding-left: 0;">
                                                <div class="count" id="total_confirmed">--</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="x_panel">
                                    <div class="x_title">
                                        <h2>Accepted Seeds (20kg/bag)</h2>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="x_content form-horizontal form-label-left">
                                        <div class="row tile_count" style="margin: 0">
                                            <div class="col-md-12 col-sm-12 col-xs-12 tile_stats_count" style="padding-bottom: 0;padding-left: 0;">
                                                <div class="count" id="total_delivered">--</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-9">
                                <div class="x_panel">
                                    <div class="x_title">
                                        <h2>DELIVERY SUMMARY</h2>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="x_content form-horizontal form-label-left">
                                        <img src="{{asset('public/images/load_chart.gif')}}" alt="" id="loading_gif" style="display: block;margin: auto;height: 300px;padding-top: 25px;">
                                        <div id="container" style="width:100%; height:300px;" style="display:none"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="x_panel" style="text-align: center;" id="pending_tab">
                                    <div class="x_content" style="padding: 0;float: left;clear: both;margin-top: 0;">
                                        <div style="padding:10px">
                                            <span style="font-size: 15px;font-weight: 600;">PENDING</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="x_panel" style="text-align: center;" id="transit_tab">
                                    <div class="x_content" style="padding: 0;float: left;clear: both;margin-top: 0;">
                                        <div style="padding:10px">
                                            <span style="font-size: 15px;font-weight: 600;">IN TRANSIT</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="x_panel" style="text-align: center;" id="confirmed_tab">
                                    <div class="x_content" style="padding: 0;float: left;clear: both;margin-top: 0;">
                                        <div style="padding:10px">
                                            <span style="font-size: 15px;font-weight: 600;">ACCEPTED</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="x_panel" style="text-align: center;" id="rejected_tab">
                                    <div class="x_content" style="padding: 0;float: left;clear: both;margin-top: 0;">
                                        <div style="padding:10px">
                                            <span style="font-size: 15px;font-weight: 600;">REJECTED</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="x_panel" style="text-align: center;" id="cancelled_tab">
                                    <div class="x_content" style="padding: 0;float: left;clear: both;margin-top: 0;">
                                        <div style="padding:10px">
                                            <span style="font-size: 15px;font-weight: 600;">CANCELLED</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- SHOW DELIVERY MODAL -->

        <!-- CANCEL DELIVERY VERIFICATION MODAL -->
        <div id="cancel_verification_modal" class="modal fade " role="dialog">
            <div class="modal-dialog" style="width:70%;">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Cancel Delivery <span id="batch_id_modalTitle">{BATCH_TICKET_NUMBER}</span></h4>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="{{route('coop_operator.cancel_delivery')}}">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <p><strong>Please state your reason, why do you want to cancel this seed delivery? (max of 255 characters.)</strong></p>
                                <textarea name="reason" id="reason" rows="5" class="form-control" required></textarea>
                                <input type="hidden" id="batch_number_update" name="batch_number_update" required>
                            </div>
                            <div class="form-group">
                                <input class="btn btn-danger" type="submit" value="CANCEL DELIVERY">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- CANCEL DELIVERY VERIFICATION MODAL -->

        <!-- TAB MODAL -->
        <div id="tab_details_modal" class="modal fade " role="dialog">
            <div class="modal-dialog" style="width:70%;">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title" id="table_title">{DELIVERY STATUS}</h4>
                    </div>
                    <div class="modal-body">
                        <table class="table table-bordered table-striped" id="delivery_sched_tbl">
                            <thead>
                                <th>Province</th>
                                <th>Municipality</th>
                                <th>Dropoff Point</th>
                                <th>Expected</th>
                                <th>Accepted</th>
                                <th>Date of delivery</th>
                                <th>Action</th>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- TAB MODAL -->

    </div>

@endsection()

@push('scripts')
    <script src=" {{ asset('public/js/jquery.inputmask.bundle.js') }} "></script>
    <script src=" {{ asset('public/js/select2.min.js') }} "></script>
    <script src=" {{ asset('public/js/parsely.js') }} "></script>
    <script src=" {{ asset('public/assets/iCheck/icheck.min.js') }} "></script>
    <script src=" {{ asset('public/js/daterangepicker.js') }} "></script>
    <script src=" {{ asset('public/js/highcharts.js') }} "></script>

    <script>

        function load_table(province, region, delivery_status){
            $("#delivery_sched_tbl").DataTable({
                "bDestroy": true,
                "autoWidth": false,
                "searchHighlight": true,
                "processing": true,
                "serverSide": true,
                "orderMulti": true,
                "order": [],
                "ajax": {
                    "url": "{{ route('coop_operator.delivery_list_province') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data":{
                        "_token": "{{ csrf_token() }}",
                        "coop_accre": "{{$coop_accre}}",
                        region: region,
                        province: province,
                        delivery_status: delivery_status
                    }
                },
                "columns":[
                    {data: 'province'},
                    {data: 'municipality'},
                    {data: 'dropOffPoint'},
                    {data: 'expected_delivery_volume'},
                    {data: 'actual_delivery_volume'},
                    {data: 'delivery_date'},
                    {data: 'action'},
                ]
            });
        }

        //pending data
        $("#pending_tab").on("click", function(e){
            $("#pending_tab").addClass('tab_link_active');
            $("#transit_tab").removeClass('tab_link_active');
            $("#confirmed_tab").removeClass('tab_link_active');
            $("#rejected_tab").removeClass('tab_link_active');
            $("#cancelled_tab").removeClass('tab_link_active');

            var province = $("#province_fld").val();
            var region = $("#region_fld").val();
            
            $("#table_title").empty().html("Pending Deliveries");
            $("#tab_details_modal").modal("show");
            load_table(province,region,0);
        });

        //in transit data
        $("#transit_tab").on("click", function(e){
            $("#transit_tab").addClass('tab_link_active');
            $("#pending_tab").removeClass('tab_link_active');
            $("#confirmed_tab").removeClass('tab_link_active');
            $("#rejected_tab").removeClass('tab_link_active');
            $("#cancelled_tab").removeClass('tab_link_active');

            var province = $("#province_fld").val();
            var region = $("#region_fld").val();

            $("#table_title").empty().html("In Transit Deliveries");
            $("#tab_details_modal").modal("show");
            load_table(province,region,3);
        });

        //confirmed data
        $("#confirmed_tab").on("click", function(e){
            $("#confirmed_tab").addClass('tab_link_active');
            $("#pending_tab").removeClass('tab_link_active');
            $("#transit_tab").removeClass('tab_link_active');
            $("#rejected_tab").removeClass('tab_link_active');
            $("#cancelled_tab").removeClass('tab_link_active');

            var province = $("#province_fld").val();
            var region = $("#region_fld").val();

            $("#table_title").empty().html("Accepted Deliveries");
            $("#tab_details_modal").modal("show");
            load_table(province,region,1);
        });

        //rejected data
        $("#rejected_tab").on("click", function(e){
            $("#rejected_tab").addClass('tab_link_active');
            $("#pending_tab").removeClass('tab_link_active');
            $("#transit_tab").removeClass('tab_link_active');
            $("#confirmed_tab").removeClass('tab_link_active');
            $("#cancelled_tab").removeClass('tab_link_active');

            var province = $("#province_fld").val();
            var region = $("#region_fld").val();

            $("#table_title").empty().html("Rejected Deliveries");
            $("#tab_details_modal").modal("show");
            load_table(province,region,2);
        });

        //cancelled data
        $("#cancelled_tab").on("click", function(e){
            $("#cancelled_tab").addClass('tab_link_active');
            $("#pending_tab").removeClass('tab_link_active');
            $("#transit_tab").removeClass('tab_link_active');
            $("#confirmed_tab").removeClass('tab_link_active');
            $("#rejected_tab").removeClass('tab_link_active');

            var province = $("#province_fld").val();
            var region = $("#region_fld").val();

            $("#table_title").empty().html("Cancelled Deliveries");
            $("#tab_details_modal").modal("show");
            load_table(province,region,4);
        });

        $("#delivery_tbl").DataTable({
            "bDestroy": true,
            "autoWidth": false,
            "searchHighlight": true,
            "processing": true,
            "serverSide": true,
            "orderMulti": true,
            "order": [],
            "ajax": {
                "url": "{{ route('coop_operator.delivery_list') }}",
                "dataType": "json",
                "type": "POST",
                "data":{
                    "_token": "{{ csrf_token() }}",
                    "coop_accre": "{{$coop_accre}}"
                }
            },
            "columns":[
                {"data": "seedVariety"},
                {"data": "deliveryDate"},
                {"data": "province"},
                {"data": "municipality"},
                {"data": "dropOffPoint"},
                {"data": "confirmed"},
                {"data": "inspected"},
                {"data": "batch_status"},
                {"data": "action"}
            ]
        });

        $('#cancel_verification_modal').on('show.bs.modal', function (e) {
            var batch_number = $(e.relatedTarget).data('batch');
            $("#batch_id_modalTitle").empty().html("("+batch_number+")");
            $("#batch_number_update").val(batch_number);
        });


        $("#delivery_sched_tbl").DataTable();
        $('#show_region_sched').on('show.bs.modal', function (e) {
            var province = $(e.relatedTarget).data('province');
            var region = $(e.relatedTarget).data('region');

            $("#province_fld").val(province);
            $("#region_fld").val(region);


            $("#region_sched_title").empty().html("Seed Deliveries for the province of: ("+province+")");
            $("#total_commitment").empty().html("loading...");
            $("#total_delivered").empty().html("loading...");
            $("#total_confirmed").empty().html("loading...");

            $.ajax({
                type: 'POST',
                url: "{{ route('load.coop_operator.total_values_province') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    coop_accre: "{{$coop_accre}}",
                    region: region,
                    province: province
                },
                success: function(data){
                    $("#total_commitment").empty().html(data["total_commitment"]);
                    $("#total_delivered").empty().html(data["total_delivered"]);
                    $("#total_confirmed").empty().html(data["total_confirmed"]);
               
                    populateChart(data['variety_list'], data['commitment_list'], data['delivered_list'], data['confirmed_list']);
                    $("#loading_gif").css("display", "none");
                    $("#container").css("display", "inline-block");
                }
            });
        });


        Highcharts.setOptions({
            lang: {
                decimalPoint: '.',
                thousandsSep: ','
            },

            tooltip: {
                yDecimals: 2 // If you want to add 2 decimals
            }
        });

        function populateChart(varieties, commitment, delivered, confirmed){
            $('#container').highcharts({
                chart: {
                    type: 'bar'
                },
                title:{
                    text:''
                },
                xAxis: {
                    categories: varieties
                },
                yAxis: {
                    title: {
                        text: ''
                    }
                },
                legend: {
                        layout: 'vertical',
                        align: 'right',
                        verticalAlign: 'top',
                        floating: true,
                        backgroundColor: '#FFFFFF',
                        borderWidth: 1,
                        y: 50,
                        opacity: 0.5
                    },
                series: [{
                        name: 'Target Commitment (20kg/bag)',
                        data: commitment
                    }, {
                        name: 'Confirmed Deliveries (20kg/bag)',
                        data: confirmed
                    }, {
                        name: 'Accepted Deliveries (20kg/bag)',
                        data: delivered
                    }]
            });
        }

        var varieties_count = "{{ $varieties_count }}";
        var delivery_data = [
            {"data": "region"},
            {"data": "province"},
            {"data": "municipality"}
        ];

        for (let index = 1; index <= varieties_count; index++) {
            const data = 'variety_col_no_' + index;
            delivery_data.push({'data' : data, "searchable": false});
        }
        delivery_data.push({'data' : "total_confirmed", "searchable": false});
        delivery_data.push({'data' : "action", "searchable": false});
        // $("#coop_commitment_summary").DataTable();
        $("#coop_dop").DataTable({
            "bDestroy": true,
            "autoWidth": false,
            "searchHighlight": true,
            "processing": true,
            "serverSide": true,
            "orderMulti": true,
            "order": [],
            "ajax": {
                "url": "{{ route('table.coop_operator.coop_dop_delivery') }}",
                "dataType": "json",
                "type": "POST",
                "data":{
                    _token: "{{ csrf_token() }}",
                }
            },
            "columns": delivery_data
        });

        $('#coop_dop tbody').on('click', 'td #view_dop',function (e) {
            e.preventDefault();
           var prv = $(this).data('prv');
            console.log(prv);
           $.ajax({
                type: "POST",
                url: "{{ route('table.coop_operator.delivery_dop_html') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    prv: prv
                },
                dataType: "HTML",
                success: function (response) {
                    $("#dop_modal_container").html(response);
                    get_dop_confirm_table(prv);
                }
           });
        });

        function get_dop_confirm_table(prv){
            $("#confirm_dop_summary").DataTable().clear();
            $("#confirm_dop_summary").DataTable({
                "bDestroy": true,
                "autoWidth": false,
                "searchHighlight": true,
                "processing": true,
                "serverSide": true,
                "orderMulti": true,
                "order": [],
                "ajax": {
                    "url": "{{ route('table.coop_operator.delivery_dop_table') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data": {
                        _token: "{{ csrf_token() }}",
                        prv: prv
                    }
                },
                "columns": [{
                        data: "dropOffPoint", 
                    },
                    {
                        data: "confirmed", "searchable": false
                    },
                    {
                        data: "inspected", "searchable": false
                    },
                    {
                        data: "percentage", "searchable": false
                    }
                ]
            });
        }

        $('#coop_dop tbody').on('click', 'td #view_batch',function (e) {
            e.preventDefault();
           var prv = $(this).data('prv');
            console.log(prv);
           $.ajax({
                type: "POST",
                url: "{{ route('table.coop_operator.delivery_batch_html') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    prv: prv
                },
                dataType: "HTML",
                success: function (response) {
                    $("#dop_modal_container").html(response);
                    get_batch_confirm_table(prv);
                }
           });
        });

        function get_batch_confirm_table(prv){
            $("#confirm_batch_summary").DataTable().clear();
            $("#confirm_batch_summary").DataTable({
                "bDestroy": true,
                "autoWidth": false,
                "searchHighlight": true,
                "processing": true,
                "serverSide": true,
                "orderMulti": true,
                "order": [],
                "ajax": {
                    "url": "{{ route('table.coop_operator.delivery_batch_table') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data": {
                        _token: "{{ csrf_token() }}",
                        prv: prv
                    }
                },
                "columns": [
                    {
                        data: "batchTicketNumber", 
                    },
                    {
                        data: "dropOffPoint", 
                    },
                    {
                        data: "confirmed", "searchable": false
                    },
                    {
                        data: "inspected", "searchable": false
                    },
                    {
                        data: "percentage", "searchable": false
                    }
                ]
            });
        }

    </script>
@endpush
