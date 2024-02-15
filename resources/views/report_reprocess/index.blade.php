@extends('layouts.index')

@section('content')
    {{-- CSRF TOKEN --}}
    <input type="hidden" name="_token" value="{{ csrf_token() }}">

    <div>
        <div class="page-title">
            <div class="title_left">
              <h3>Report Reconcilation</h3>
            </div>
        </div>

            <div class="clearfix"></div>

        <div class="x_content form-horizontal form-label-left">

        <div class="row">
            <div class="alert alert-warning alert-dismissible fade in" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                <strong><i class="fa fa-info-circle"></i> Notice!</strong> Use this only when requested,  this script runs every midnight.
            </div>
        </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-3">Region</label>
                                <div class="col-md-9 col-sm-9 col-xs-9">
                                    <select name="utilRegion" id="utilRegion" class="form-control" data-parsley-min="1" style="width: 500px">
                                        <option value="0">Please select a Region</option>
                                      @foreach ($regional_list as $region)
                                                <option value="{{ $region->region }}">{{ $region->region}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-3">Province  </label>
                                <div class="col-md-9 col-sm-9 col-xs-9">
                                    <select name="utilProvince" id="utilProvince" class="form-control" data-parsley-min="1" style="width: 500px">
                                        <option value="0">Please select a province</option>
                                    </select>
                                </div>
                            </div>




                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-3">Municipality</label>
                                <div class="col-md-9 col-sm-9 col-xs-9">
                                    <select name="utilMunicipality" id="utilMunicipality" class="form-control" data-parsley-min="1" style="width: 500px">
                                        <option value="0">Please select a municipality</option>
                                    </select>
                
                                    <br>
                                   
                                </div>
                            </div>


                            <div class="form-group">
                                
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    
                                    <button type="button" name="utilProcess" id="utilProcess" class="btn btn-lg btn-primary" disabled=""><i class="fa fa-sign-in"></i> Report Reprocess </button>

                                     <button type="button" name="utilProvincialProcess" id="utilProvincialProcess" class="btn btn-lg btn-primary" disabled=""><i class="fa fa-bar-chart"></i> Excel Reprocess Provincial</button>

                                      <button type="button" name="utilStatProcess" id="utilStatProcess" class="btn btn-lg btn-primary" disabled=""><i class="fa fa-bar-chart"></i> Statistics Reprocess</button>
                                   
                                </div>
                            </div>

                                                            



        </div>
    </div>
@endsection
@push('scripts')

    <script type="text/javascript">
            $('select[name="utilRegion"]').on('change', function () {
                HoldOn.open(holdon_options);
                var region = $(this).val();
                document.getElementById("utilProcess").disabled = true;
                document.getElementById("utilStatProcess").disabled = true;
document.getElementById("utilProvincialProcess").disabled = true;


            $('select[name="utilProvince"]').empty();
            $('select[name="utilProvince"]').append('<option value=0>--Please Select a Province--</option>');
            $('select[name="utilMunicipality"]').empty();
            $('select[name="utilMunicipality"]').append('<option value=0>--Please Select a Municipality--</option>');

                $.ajax({
                    method: 'GET',
                    url: 'utility/getProvince/'+ region,
                    data: {
                        _token: _token,
                        region: region,
                    },
                    dataType: 'json',
                    success: function (source) {
                       
                        $('select[name="utilProvince"]').empty();
                        $('select[name="utilProvince"]').append('<option value=0>--Please Select a Province--</option>');
                            $.each(source, function (i, d) {
                                $('select[name="utilProvince"]').append('<option value="' + d.province + '">' + d.province + '</option>');
                        }); 
                    }
            }); //AJAX GET PROVINCE
            HoldOn.close();
        });  //END REGIONAL SELECT

            $('select[name="utilProvince"]').on('change', function () {
                HoldOn.open(holdon_options);
                var province = $(this).val();
                document.getElementById("utilProcess").disabled = true;
                document.getElementById("utilStatProcess").disabled = false;  
                document.getElementById("utilProvincialProcess").disabled = false;  
            $('select[name="utilMunicipality"]').empty();
            $('select[name="utilMunicipality"]').append('<option value=0>--Please Select a Municipality--</option>');

                $.ajax({
                    method: 'GET',
                    url: 'utility/getMunicipality/'+ province,
                    data: {
                        _token: _token,
                        province: province,
                    },
                    dataType: 'json',
                    success: function (source) {
                        $('select[name="utilMunicipality"]').empty();
                        $('select[name="utilMunicipality"]').append('<option value=0>--Please Select a Municipality--</option>');
                            $.each(source, function (i, d) {
                                $('select[name="utilMunicipality"]').append('<option value="' + d.prv + '">' + d.municipality + '</option>');
                        }); 
                    }
                 }); //AJAX GET PROVINCE
            HoldOn.close();
            });  //END PROVINCE SELECT


            $('select[name="utilMunicipality"]').on('change', function () {
                HoldOn.open(holdon_options);
                var municipality = $(this).val();
                if(municipality==0){
                    document.getElementById("utilProcess").disabled = true;    
                }else{
                    document.getElementById("utilProcess").disabled = false;
                }
            HoldOn.close();
            });  //END PROVINCE SELECT



            document.getElementById("utilProcess").addEventListener("click", function() {
                HoldOn.open(holdon_options);
                    var region = document.getElementById("utilRegion").value;
                    var province = document.getElementById("utilProvince").value;  
                    var prv = document.getElementById("utilMunicipality").value;
                    var municipalCode = document.getElementById("utilMunicipality");
                    var municipality = municipalCode.options[municipalCode.selectedIndex].text;

                    if(prv == 0){
                            alert('Please Select a Municipality');
                            HoldOn.close();
                            die();
                    }else{
                            $.ajax({
                            type: 'POST',
                            url: "{{ route('utility.process.report') }}",
                            data: {
                                _token: "{{ csrf_token() }}",
                                prv: prv,
                                region: region,
                                province: province,
                                municipality: municipality,
                            },
                            success: function(data){
                                       alert(data);
                                       HoldOn.close();
                            },
                            error: function(data){
                                alert("An error occured while processing your data, please try again.");
                                //alert(data);
                                HoldOn.close();
                            }
                            });
                    }


                
            });  



            document.getElementById("utilStatProcess").addEventListener("click", function() {
                HoldOn.open(holdon_options);
                    var region = document.getElementById("utilRegion").value;
                    var province = document.getElementById("utilProvince").value;  
                    //var prv = document.getElementById("utilMunicipality").value;
                    //var municipalCode = document.getElementById("utilMunicipality");
                    //var municipality = municipalCode.options[municipalCode.selectedIndex].text;

                    if(region == 0){
                            alert('Please Select a Region');
                            HoldOn.close();
                            die();
                    }else{

                       // alert(region);
                            $.ajax({
                            type: 'POST',
                            url: "{{ route('utility.process.statistics.report') }}",
                            data: {
                                _token: "{{ csrf_token() }}",
                                region: region,
                                province: province,
                            },
                            success: function(data){
                                       alert(data);
                                       HoldOn.close();
                            },
                            error: function(data){
                                alert("An error occured while processing your data, please try again.");
                                //alert(data);
                                HoldOn.close();
                            }
                            });
                    }


                
            });  


            document.getElementById("utilProvincialProcess").addEventListener("click", function() {
                HoldOn.open(holdon_options);
                    var region = document.getElementById("utilRegion").value;
                    var province = document.getElementById("utilProvince").value;  
                    //var prv = document.getElementById("utilMunicipality").value;
                    //var municipalCode = document.getElementById("utilMunicipality");
                    //var municipality = municipalCode.options[municipalCode.selectedIndex].text;

                    if(region == 0){
                            alert('Please Select a Region');
                            HoldOn.close();
                            die();
                    }else{

                       // alert(region);
                            $.ajax({
                            type: 'POST',
                            url: "{{ route('utility.process.provincial.report') }}",
                            data: {
                                _token: "{{ csrf_token() }}",
                                region: region,
                                province: province,
                            },
                            success: function(data){
                                       alert(data);
                                       HoldOn.close();
                            },
                            error: function(data){
                                alert("An error occured while processing your data, please try again.");
                                //alert(data);
                                HoldOn.close();
                            }
                            });
                    }


                
            });  




    </script>

@endpush