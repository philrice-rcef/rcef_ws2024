<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>DBP Payment Form</title>
<style>
#emp, th, td {
  border: 1px solid black;
  border-collapse: collapse;
}
#emp, td, #emp th{
  padding: 1px;
  text-align :center;
}
@page { margin-top: 10px; margin-bottom: 0px; }
body { margin-top: 0px; margin-bottom: 0px;}

td{
  border: none;
  margin: 0;
  padding: 0;
  height: 1.065rem;
  /* outline: solid 1px #000; */
}

.coops{
  font-size: 0.4rem;
  position: absolute;
  left: 5.8%;
  top: 48.0%;
  /* border: solid 1px #000; */
  width: 355px;
  box-sizing: border-box;
}

tr{
  margin: 0;
  padding: 0;
}

.coops tr td{
  /* outline: 1px solid #000; */
}

.coops tr td:nth-of-type(1){
  font-size: 1.2rem;
  width: 20%;
}
.coops tr td:nth-of-type(2){
  font-size: 1rem;
  width: 40%;
}
.coops tr td:nth-of-type(3){
  font-size: 1.2rem;
  width: 20%;
}
.coops tr td:nth-of-type(4){
  font-size: 1.2rem;
  width: 20%;
}

.signatories{
  position: absolute;
  bottom: 36.7%;
  width: 100%;
  font-size: 0.7rem;
}

.payee{
  width: 100%;
}

.payee tr td{
  /* outline: 1px solid #000; */
  height: 0.93rem;
}

.payee tr td:nth-of-type(1){
  width: 19.2%;
}
.payee tr td:nth-of-type(2){
  width: 38.4%;
}
.payee tr td:nth-of-type(3){
  width: 24.9%;
}
.payee tr td:nth-of-type(4){
  /* width: 21.2%; */
}

.coops_total, .coops_total_word{
  font-size: 0.4rem;
  position: absolute;
  left: 5.8%;
  top: 56.7%;
  /* border: solid 1px #000; */
  width: 355px;
  box-sizing: border-box;
}

.coops_total tr td:nth-of-type(1){
  font-size: 0.9rem;
  width: 20%;
}
.coops_total tr td:nth-of-type(2){
  font-size: 1rem;
  width: 40%;
}
.coops_total tr td:nth-of-type(3){
  font-size: 1rem;
  width: 20%;
}
.coops_total tr td:nth-of-type(4){
  font-size: 1.2rem;
  width: 20%;
}

.location{
  position: absolute;
  top: 12.25%;
  left: 44%;
  font-size: 0.6rem;
}

.time{
  position: absolute;
  top: 10.20%;
  right: 8%;
  font-size: 0.6rem;
}

.page-break {
            page-break-after: always;
        }

</style>

</head>
  <body>
    <div>
      <img src="{{ public_path('images/dbp_new2.jpg')}}" style="width:100%; height:100%; position:absolute;">
    </div>
    <div class="time">
      {{date('F d, Y',strtotime($date3))}}
    </div>
    <div class="location">
      CABANATUAN
    </div>
    <div style="font-size: 0.6rem; position: absolute; top: 16.4%; margin: 0 6.3% 0 5.7%;">
      <table class="payee">
        <tr>
          <td>CURRENT</td>
          <td>PHILRICE RCEF</td>
          <td>00-0-01611-530-4</td>
          <td>{{$total_arrs["net_format"]}}</td>
        </tr>
        <tr>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <td style="height: 0.6rem;"></td>
          <td style="height: 0.6rem;"></td>
          <td style="height: 0.6rem;"></td>
          <td style="height: 0.6rem; font-size: 0.8rem;">{{$total_arrs["net_format"]}}</td>
        </tr>
      </table>
      <table style="width: 100%; transform: translateY(-10%)">
        <tr>
          <td style="width: 20%; height: 1.6rem;"></td>
          <td style="width: 80%; height: 1.6rem; text-align: left; vertical-align: top; font-size: 0.8rem; line-height: 140%;">{{$total_arrs["net_words"]}}</td>
        </tr>
      </table>
    </div>

    <div>
        
      <table class="coops">
        @foreach($coop_data as $row)
            @php
            $net_amount = $row["amount_float"] - ($row["amount_float"] * 0.01);
            @endphp
                <tr>
            @foreach($row["details"] as $details)
            
                @if (preg_match('/^00-5/', $details->account_no))
                  <td>SAVINGS</td>
                @else
                  <td>CURRENT</td>
                @endif
                <td>{{$details->coop_name}}</td>
                <td>{{$details->account_no}}</td>
                <td>{{number_format($net_amount,2)}}</td>
             
            @endforeach
        </tr>
        @endforeach
      </table>
      <table class="coops_total">
        <tr>
          <td></td>
          <td></td>
          <td></td>
          <td>{{$total_arrs["net_format"]}}</td>
        </tr>
      </table>
      <table class="coops_total_word" style="transform: translateY(1rem); height: 1.6rem; font-size: 1rem; line-height: 80%">
        <tr>
          <td style="width: 34%;"></td>
          <td style="padding: 0; font-size: 0.4rem; text-align: start; vertical-align:top;+">{{$total_arrs["net_words"]}} </td>
        </tr>
      </table>
    </div>

    <div>
      <table class="signatories">
        
        <tr>
          <td style="width: 50%;">{{$signatory2->full_name}}</td>
          <td style="width: 50%;">{{$signatory3->full_name}}</td>
        </tr>
      </table>
    </div>



    <div class="page-break"></div>



    <table  style ="border:none; text-align:left; font-size: 12pt" width="100%" id="emp" > 
        <tr> 
          <td style ="border:none; text-align:left;" ><br><br></td>
        </tr>   
        <tr> 
          <td style ="border:none; text-align:left;" >eBinhi Padala 2024 DS</td>
        </tr>
        <tr>
          <td style ="border:none; text-align:left;">Payment Summary with DBP Account</td>   
        </tr>
        <tr> 
          <td style ="border:none; text-align:left;">{{date('F d, Y',strtotime($date3))}}</td>
        </tr>              
    </table>
    <br><br>
    <table style="border:none; font-size: 10pt" width="100%" align="center"> 
      <thead>
        <tr style =" border:none; vertical-align:top">
          <td  style ="border:none; text-align:center; font-size: 10pt" >Name of Coop</td>
          <td  style ="border:none; text-align:center;" ># of bags</td>
          <td  style ="border:none; text-align:center; " >Amount</td>
          <td  style ="border:none; text-align:center;" >1% retention</td> 
          <td  style ="border:none; text-align:center;" >Net Amount Due</td>   
        </tr>
      </thead>
        
      <tbody id='databody'>
        @foreach ($coop_data as $row)
            @php
            $net_amount = $row["amount"];
            @endphp

            @foreach($row["details"] as $details)
                <tr style =" border:none; vertical-align:top">
                <td  style ="border:none; text-align:center; font-size: 10pt" >{{$details->coop_name}}</td>
                <td  style ="border:none; text-align:center;" >{{$row["bags"]}}</td>
                <td  style ="border:none; text-align:center;" >{{$row["amount"]}}</td>
                <td  style ="border:none; text-align:center; " >{{ number_format(( floatval($row["amount_float"]) * 0.01),2 ) }}</td>
                <td  style ="border:none; text-align:center;" >{{number_format( $row["amount_float"]- ($row["amount_float"] * 0.01),2 )}}</td>  
            </tr>

            @endforeach
        @endforeach
  
        <tr style =" border:none; vertical-align:top">
          <th  style ="border:none; border-bottom:1px solid black; text-align:center;" >GRAND TOTAL</th>
          <th  style ="border:none; border-bottom:1px solid black;text-align:center;" >{{$total_arrs["total_bags"]}}</th>
          <th  style ="border:none; border-bottom:1px solid black;text-align:center;" >{{$total_arrs["total_sales"]}}</th>
          <th  style ="border:none; border-bottom:1px solid black; text-align:center; " >{{number_format(($total_arrs["total_sales_float"] * 0.01),2)}}</th>
          <th  style ="border:none; border-bottom:1px solid black; text-align:center;" >{{number_format($total_arrs["total_sales_float"]-($total_arrs["total_sales_float"] * 0.01),2)}}</th>  
        </tr>
      </tbody>  
      
  </table>
  
  <br>
  <p>Prepared by:</p><br>
  
  
  <p><strong>{{$signatory1->full_name}}</strong><br>
    {{$signatory1->designation}}
  </p>
  <br>
  
  <p>Noted by:</p><br>
  </p>
  
  <p><strong>{{$signatory2->full_name}}</strong><br>
    {{$signatory2->designation}}<br>
  </p>
  
  <br>
  <p>Approved by:</p><br>
  </p>
  
  <p> <strong>{{$signatory3->full_name}}</strong><br>
    {{$signatory3->designation}}<br>
  </p>
  


</body>
</html>