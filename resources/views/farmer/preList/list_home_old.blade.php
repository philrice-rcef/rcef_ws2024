<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <style>
        /* set PDF margins to 0 */
        @page { margin: 10px; }
        /* set PDF margins to 0 */

        table {
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid black;
        }

        td{
            padding: 1px;
        }

        body{
            font-size: 12px;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <?php $page_count = ceil(count($list) / 15)?>
    <?php $array_index = 1?>
    <?php $cnt = 0?>
    
    @for ($i = 1; $i <= $page_count; $i++)
        <table style="width:100%">
            <thead>
                <tr>
                    <th colspan="17" style="page-break-after: always;">
                        <img src="{{ public_path('images/philrice_logo_box.png')}}" 
                            style="height: 80px;width: 200px;margin-top:25px;margin-left: 10px;">

                            <img src="{{ public_path('images/Socotec-Logo.png')}}" 
                            style="height: 70px;width: 165px;margin-top:15px;margin-left: 850px;">

                        <div style="margin-top:-60px;">
                            <center><span style="font-size: 20px;">Farmer Leaflet Acknowledgement Receipt</span></center>
                            <center><span style="font-size: 20px;">RCEF Seed Program</span></center><br><br>
                        </div><br>

                        <div style="margin-top:15px;margin-left: 10px;">
                            <span>Season Year: __<u>DRY SEASON 2021</u>___</span><br>
                            <span>Drop-off Point (Municipality, Province): _______________________</span><br>
                            <span>RSBSA Code: Region_<u>{{$region_code}}</u>_, Province:_<u>{{$province_code}}</u>_, Municipality:_<u>{{$municipality_code}}</u>_</span>
                        </div>
                        
                        <br><br>
                    </th>
                </tr>
                <tr>
                    <th colspan="4"><center>FARMER NANME <br>(Last Name, First Name, Middle Name</center></th>
                    <th style="width:100px;">Farmer Code</th>
                    <th><center>Sex</center></th>
                    <th>Birthday</th>
                    <th colspan="3"><center>Mother's Maiden Name <br>(Last Name, First Name, Middle Name)</center></th>
                    <th style="width:65px;">Contact #</th>
                    <th style="width:30px;">Area Planted</th>
                    <th>Variety</th>
                    <th>No. of bags</th>
                    <th>QR Code</th>
                    <th>Name of Authorized Representative</th>
                    <th>Signature of Claimant</th>
                </tr>
            </thead>
       

            @for ($x = $cnt; $x < ($i * 15); $x++)

                @if(!empty($list[$cnt]))
                    <tr>
                        <td style="width: 20px;">{{$cnt + 1}}). </td>
                        <td>{{strtoupper($list[$cnt]["fp_lastName"])}}</td>
                        <td>{{strtoupper($list[$cnt]["fp_firstName"])}}</td>
                        <td>{{strtoupper($list[$cnt]["fp_midName"])}}</td>
                        <td>{{strtoupper($list[$cnt]["fp_rsbsa_control_no"])}}</td>
                        <td><center>{{strtoupper($list[$cnt]["fp_sex"] == "Femal" ? "F" : "M")}}</center></td>
                        <td>{{$list[$cnt]["oi_birthdate"] == "0000-00-00" ? "" : $list[$cnt]["oi_birthdate"]}}</td>
                        <td>{{strtoupper($list[$cnt]["oi_mother_lname"])}}</td>
                        <td>{{strtoupper($list[$cnt]["oi_mother_fname"])}}</td>
                        <td>{{strtoupper($list[$cnt]["oi_mother_mname"])}}</td>
                        <td>{{$list[$cnt]["oi_phone"]}}</td>
                        <td>{{$list[$cnt]["fp_area"]}}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                @else
                <tr>
                    <td style="width: 20px;">{{$cnt + 1}}). </td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                @endif
                    

                {{$cnt++}}
            @endfor

            <!--footer-->
            <tr>
                <th colspan="17">
                    <div style="margin-top:15px;margin-left: 10px;">
                        <span>Issued By: </span><br><br>
                        <div style="margin-left: 50px;">
                            <span>____________________________________________</span><br>
                            <span style="margin-left:15px">Signature above printed name of PC/RC</span><br><br><br><br>
                            <span>FORM 4</span>
                        </div>
                    </div>

                    <div style="margin-left: 450px;margin-top:-115px;">
                        <span>Certified By: </span><br><br>
                        <div style="margin-left: 50px;">
                            <span>____________________________________________</span><br>
                            <span style="margin-left:15px">Signature above printed name of PDO</span><br><br><br><br>
                            <span>PHILRICE RCEF Seed FLSAR Rev 00 Effectivity Date: 23 March 2020</span>
                        </div>
                    </div>
                    <br><br>
                </th>
            </tr>


            </table>
        
        <div class="page-break"></div>
    @endfor
    

   

</body>
</html>