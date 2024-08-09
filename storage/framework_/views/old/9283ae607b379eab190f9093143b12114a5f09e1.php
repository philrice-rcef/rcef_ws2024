<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo e($title); ?></title>

    <style>

        /* set PDF margins to 0 */
        @page  { margin: 10px; }
        /* set PDF margins to 0 */

        table {
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid black;
        }

        td{
            padding: 2px;
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
     <?php 
     $w_data_col = 22;
     $wo_data_col = 25;
    $version_with_data = "7.1";
    $version_no_data = "7.2B";
    
    $td_height = "25px";
     
     $row_param = 15;
     $page_count = ceil(count($list) /  $row_param)?>
	  
    <?php $totalFarmer = count($list); ?>
    <?php $array_index = 1?>
    <?php $cnt = 0;
		  $itm = 1;

      
	?>
    
    <?php
        $brgy = $list[0]["brgy"];

        foreach ($list as $key => $value) {
           if($list[$key]["brgy"]!=$brgy){
            $brgy = $list[$key]["brgy"];
            $page_count++;
           }
        }
         $brgy = $list[0]["brgy"];
	
		 $addBlankPage =1;
        
       // $page_count = 1;
    ?>

<div class="row">
   

 
    

        <table style="border-style: none;">
            <thead>
                <tr>
                </td>
                <img src="<?php echo e(public_path('images/da_philrice.jpg')); ?>" 
                style="width: auto; height: 110px; margin-top:0px;margin-left: 25%; z-index: -50; position: absolute; top:10px;">
               
                <div style="margin-top:10px;">
                    <center><span style="font-size: 20px; font-weight:bold;"> <br>Farmer  Acknowledgement  Receipt <br> (Pre-populated & Blank) <br> Description Guide</span></center>
                </div>
                <img src="<?php echo e(public_path('images/rcef_seed_program.jpg')); ?>" 
                style="width: auto; height: 100px; margin-top:15px;margin-left: 70%; z-index: -50; position: absolute; top:10px;">
                    <td style="border-style: none;">
                </tr>
         
            </thead>
        </table>
    </div>
       

        <div class="row" style="margin-top: 30px; margin-left:10%; width:80%;">

    <table style="font-size: 18px; border-style:solid ">

        <tbody>
            <tr>   <td style="vertical-align: top;">  <strong> RSBSA No.
                (FFRS System
                Generated)</strong> </td>
                <td>Unique code assigned to each farmer contained in the RSBSA stub/ RCEF ID/ DA Interventions Monitoring Card, which will be presented upon seed claim</td>
            </tr>

            <tr> 
                <td style="vertical-align: top;">
                    <strong> Registered Municipal Rice Area</strong>
                </td>
                <td >
                    Maximum/Total Physical Rice Area located in the city/municipality
                </td>
            </tr>

            <tr> 
                <td style="vertical-align: top;">
                    <strong> Total Parcel Count</strong>
                </td>
                <td>
                   Total number of parcels in different barangays within the same city/municipality
                </td>
            </tr>



            <tr> 
                <td style="vertical-align: top;">
                    <strong>Area to be planted (ha)</strong>
                </td>
                <td >
                    Intended area for planting for the <strong> 2024 Wet Season</strong>
                </td>
            </tr>


            <tr> 
                <td style="vertical-align: top;">
                    <strong>Number of bags (20kg/bag)</strong>
                </td>
                <td >
                    Number of bags received per variety (2024 Wet Season)
                </td>
            </tr>

            <tr> 
                <td style="vertical-align: top;">
                    <strong>Rice Variety Received</strong>
                </td>
                <td >
                    Name of rice variety received.
                </td>
            </tr>

            <tr> 
                <td style="vertical-align: top;">
                    <strong> Crop Estab.</strong>
                </td>
                <td >
                    Crop Establishment that will be employed for the <strong>2024 Wet Season</strong> [<strong>D</strong>-Direct Seeding | <strong>T</strong>-Transplanted]
                </td>
            </tr>

            <tr> 
                <td style="vertical-align: top;">
                    <strong> Expected Sowing Date</strong>
                </td>
                <td >
                    [Month / Week]-Format: &nbsp;  &nbsp;<strong>1 - 12 </strong> (Jan. - Dec.)/<strong>1 - 4</strong> (1st - 4th week) (e.g. 9/3 = Sept. 3rd week)
                </td>
            </tr>

            <tr> 
                <td style="vertical-align: top;">
                    <strong> Data Sharing Consent</strong>
                </td>
                <td >
                    Sumasang-ayon ka ba na ang lahat ng impormasyon na inyong ibabahagi ay maaring gamitin ng PhilRice at ng Department of Agriculture sa iba pang programa nito?  Lagyan ng "<img src="<?php echo e(public_path('images/far_check.jpg')); ?>" style="height: 12px; width: auto;">" kung ikaw ay sumasang-ayon  at "<img src="<?php echo e(public_path('images/far_cross.jpg')); ?>" style="height: 12px; width: auto;">" kung hindi.
                </td>
            </tr>

          



            <tr> 
                <td style="vertical-align: top;">
                    <strong> Seed Class</strong>
                </td>
                <td >
                    [ <strong>CS</strong> = Certified Seeds | <strong>H</strong> = Hybrid | <strong>F</strong>= Farmer Seed ]
                </td>
            </tr>

            <tr> 
                <td style="vertical-align: top;">
                    <strong>Planted Variety</strong>
                </td>
                <td >
                    Variety planted during the<strong> previous season (2024 Dry season)</strong>
                </td>
            </tr>

            <tr> 
                <td style="vertical-align: top;">
                    <strong>Area harvested (ha)</strong>
                </td>
                <td >
                    Total area harvested during the<strong> previous season (2024 Dry Season)</strong> within the city/municipality
                </td>
            </tr>



            <tr> 
                <td style="vertical-align: top;">
                    <strong>Total harvest (bag)</strong>
                </td>
                <td >
                    Total number of bags from the thresher/harvester during the previous season, including shares of harvesters, machine/s, owner (if land is leased/rented)
                </td>
            </tr>

            <tr> 
                <td style="vertical-align: top;">
                    <strong>Harvest weight per bag (kg)</strong>
                </td>
                <td >
                    Harvest weight per bag in <strong>kilograms</strong> of palay harvested during the <strong>previous season (2024 Dry Season)</strong>
                </td>
            </tr>

            <tr> 
                <td style="vertical-align: top;">
                    <strong>No. of KP Kits Received</strong>
                </td>
                <td >
                    Knowledge products received during distribution.
                </td>
            </tr>
     
            <tr> 
                <td style="vertical-align: top;">
                    <strong>Name of Authorized Representative</strong>
                </td>
                <td >
                    Full name of the farmer's authorized representative as applicable, <i> (formatted as Last name, First name Middle Initial) </i>
                </td>
            </tr>
     
            <tr> 
                <td style="vertical-align: top;">
                    <strong>Date Received</strong>
                </td>
                <td >
                    Date of receipt of seed allocation in mm/dd/yy format (e.g., 09/13/23)
                </td>
            </tr>

            <tr> 
                <td style="vertical-align: top;">
                    <strong>Signature of Claimant</strong>
                </td>
                <td >
                    Signature of the farmer/authorized representative who received/claimed the seeds
                </td>
            </tr>
     
          
        </tbody>

    </table>
 </div>


</div>

<div style="position: absolute; bottom:7px; left:135px; border-style:dashed; width:78%; font-size:18px; padding:5px;">
    <strong>NOTE: </strong> Documentary requirements (e.g., authorization letters, C/MAO certification, etc.) presented during seed distribution shall be collected by DA-PhilRice alongside the accomplished FAR upon the completion of seed distribution.
</div>

</div>



<div class="page-break"></div>



    <?php for($i = 1; $i <= $page_count; $i++): ?>
		  <?php  
			$cntIdentifier = 0;
			$breaker =0;
			
			 if(empty($list[$cnt])){
             
                    continue;
               
                $brgy = "________";
                $itm = 1;
				$wData = 0;
				
				if($addBlankPage == 1){
				$blankPage = $page_count - $i; //Get remaining pages
					$page_count -= $blankPage;
					$page_count +=2;
					$addBlankPage = 0;
					//echo $page_count . "<br>".$i;	
				}			
            }else{
				$wData = 1;
			}

			?>

 

		<table style="width:100%; margin-right: 10px; margin-top: 12px; border-style:ridge">
            <thead>
                <tr>
                    <div style="position:fixed; left:52%; top:30px;; border-style:dashed; width:430px; height:90px; z-index: -50; padding-left:10; padding-right:10; padding-bottom:10; padding-top:0;  ">
                        <p style="">
                            <b> Important Notice</b> <br>
                           
                            Pursuant to DA Memorandum No. 30 s. 2023, only farmers cultivating <strong>at least 1,000 m&sup2; (0.1 ha)</strong> are eligible to receive seeds from the program. Those who are cultivating more than 5 ha are only allowed to receive seed support equivalent to a <strong>maximum of 5 ha.</strong> Farmers who are part of farm clusters will still receive their full allocation.


                        </p>
                    </div>

                    <?php if($wData == 1): ?>
                        <th colspan="<?php echo e($w_data_col); ?>" style="page-break-after: always;">
                    <?php else: ?>
                        <th colspan="<?php echo e($wo_data_col); ?>" style="page-break-after: always;">
                    <?php endif; ?>
                        
                            <img src="<?php echo e(public_path('images/da_philrice.jpg')); ?>" 
                            style="width: auto; height: 110px; margin-top:0px;margin-left: 1%; z-index: -50; position: absolute; top:10px;">
                           
                            <div style="margin-top:10px; margin-left: 11%;">
                                <left><span style="font-size: 20px;"> <br>Farmer  Acknowledgement  Receipt  </span></left>
                                <left><span style="font-size: 20px;"></span></left>
                            </div>

                            

                            <img src="<?php echo e(public_path('images/rcef_seed_program.jpg')); ?>" 
                            style="width: auto; height: 120px; margin-top:15px;margin-left: 88%; z-index: -50; position: absolute; top:0px;">

                     
                        
                        <?php /* <div style="margin-top:10px; border: 1px dotted black; width: 20%; margin-left: 260px;">
                             <span style="font-size: 14px;">*Importance of Active Mobile Number *</span>
                            <hr style="margin-top: 0px;">   
                             <table style="border: 0; margin-left: 10px; margin-top: 0px;" width="100%">
                                 <tr> 
                                    <td  style="border-style: none;"> 
                                     Farmers with active & updated mobile numbers will have a chance to participate in the "Binhi e-Padala" Program.
                               </td>
                            
                                </tr>
                            </table>

                        </div> */ ?>



                       
                        <div style="position: fixed; text-align: left; margin-right: 10px;  top:0px;right:0px;">Privacy Notice: All collected information will be handled by DA-PhilRice in accordance with Republic Act No. 10173 (Data Privacy Act of 2012).</div>
                        <?php if($wData == 1): ?>
                        <div style="position: fixed; text-align: right; margin-right: 10px;  top:0px;right:0px;"> FAR V<?php echo e($version_with_data); ?></div>
                        <?php else: ?>
                        <div style="position: fixed; text-align: right; margin-right: 10px;  top:0px;right:0px;"> FAR V<?php echo e($version_no_data); ?></div>
                        <?php endif; ?>


                        <?php if($mark == "empty"): ?>

                        <div style="margin-top: 15px;margin-left: 11%; margin-bottom:25px;">
                            <span>Year/Season: _______________</span><br>
                            <span>Drop-off Point (City/Municipality, Province) _______________________________</span><br>
                            <span>RSBSA Code: Region:____, Province:____, Municipality:____</u>
							_, Barangay:_____
							
							</span>
                        </div>
                        <?php else: ?>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <div style="position: fixed; top:60px ; margin-top: 15px;margin-left: 11%; margin-bottom:25px; width:40%; height:10%;">
                            <span>Year/Season: __<u>2024 Wet Season</u>__</span><br>
                            <span>Drop-off Point (City/Municipality, Province) __<u><?php echo e(strtoupper($municipality)); ?>, <?php echo e(strtoupper($province)); ?></u>__</span><br>
                            <span>RSBSA Code: Region:_<u><?php echo e($region_code); ?></u>_, Province:_<u><?php echo e($province_code); ?></u>_, Municipality:_<u><?php echo e($municipality_code); ?></u>
							_, Barangay:_<u><?php echo e($brgy); ?></u>_
							
							</span>
                        </div> 
                        <?php endif; ?>
                        

                        
                    </th>

                </tr>
				
				<?php if($wData == 1): ?>
				<tr>
                    <th rowspan="2" style="">No.</th>
                    <th style="" colspan="3"><center>FARMER NAME</center></th> 
                    <th style="width: 110px;" rowspan="2" align="center">RSBSA No. <br> (FFRS System Generated) </th>

                    <th  style="width: 20px; font-size:10px;" rowspan="2" align="center">Registered <br> Municipal Rice <br> Area </th>
                    <th  style="width: 20px; font-size:10px;" rowspan="2" align="center">Total <br>Parcel <br> Count</th>
                    
                    <th  align="center" style="width: 20px; font-size:10px;" rowspan="2">Area to be planted (ha)</th>
                    <th style="width: 30px; font-size:10px;" rowspan="2" align="center"> Number of bags <br> (20kg/bag)</th>
                    <th style="width: 70px;" rowspan="2" align="center">Rice Variety Received</th>
                  
                    <?php /* <th rowspan="2" style="width: 25px;"><center>Sex<br>(M/F)</center></th> */ ?>
                    <th  style="width:20px; font-size: 10px;" align="center" rowspan="2">Crop Estab. <br> [D/T] </th>

                

                    <th  style="width:40px; font-size: 10px;" align="center" rowspan="2">Expected Sowing Date <br> [Month/Week] </th>


                    <th style="font-size: 10px;" style="width:20px;" rowspan="2"><center> Data Sharing Consent <br> (<img src="<?php echo e(public_path('images/far_check.jpg')); ?>" style="height: 12px; width: auto;">/ X)</center></th>
                    <th style="" colspan="5"><center>2024 DS YIELD <br> Major Seed and Variety Planted</center></th> 



                    <th style="width:40px;" rowspan="2"><center> No. of <br> KP Kits <br> Received</center></th> 

                    <th style="font-size: 10px; width: 90px;"><center>Name of Authorized Representative </center></th>
                    <th rowspan="2" align="center" style="width: 20px;">Date Received <br> <i style="font-weight: 1px; font-size: 10px;" > (mm/dd/yr) </i></th>
                    <th rowspan="2" style=" font-size: 10px; width: 60px;" align="center">Signature of Claimant</th>
                 
                  
				</tr>
                <tr>
                    <th colspan="3" align="center" style="font-weight: 1px; font-style: italic; font-size: 9px; height: 22px; ">(Last Name, First Name, Middle Name)</th>
                    <?php /* <th align="center" style="font-size: 10px; font-style: italic;">(must be equal or less than Reg. Area)</th> */ ?>
                    <th  style="width:30px; font-size: 10px;" align="center">Seed Class <br> (CS/H/F) </th>
                    <th  style="width:60px; font-size: 10px;" align="center">Planted Variety </th>
                    <th  style="width:20px; font-size: 9px;" align="center">Area harvested <br> (ha)</th>
                    <th  style="width:20px; font-size: 9px;" align="center">Total harvest <br> (bag)</th>
                    <th  style="width:40px; font-size: 9px;" align="center">Harvest <br> weight <br> per bag <br> (kg)</th>
                    
                    
                    
                    
                



                    <th align="center" style="font-weight: 1px; font-style: italic; font-size: 10px;">(Last Name, First Name, Middle Initial)</th>
                </tr>



                <?php /* NO DATA */ ?>
				<?php else: ?>
				

                

				<?php endif; ?>
				
				
				
				
            </thead>
       
			  <?php for($x = $cnt; $x < $totalFarmer; $x++): ?>
                <?php if(!empty($list[$cnt])): ?>
					 <?php
                    if($brgy!=$list[$cnt]["brgy"]){
                           // $i++;
                            $brgy = $list[$cnt]["brgy"];
							if($cntIdentifier <  $row_param){
                                $r =  $row_param - $cntIdentifier ;
                                for($e=0;$e<$r;$e++){
                                    ?>
                                    <!-- EMPTY ROW -->
                                    <tr>
									    <td style="width: 10px; height: <?php echo e($td_height); ?>;">
                                            <?php if($mark == "empty"): ?>    
                                         
                                            <?php else: ?>
                                            <?php echo e($itm); ?>

                                            <?php endif; ?>
                                        </td>
                                            <td colspan="3" style="width:180px;  font-size: 10px;"> </td>

                                            <td><center> </center></td>
                                            <!--AGE -->
                                            <td align="center" style="font-size: 11px; width: 40px;"> </td>
                                            <td> </td>
                                            <td></td>
                                            <td></td>
                                            <!-- CONTACT -->
                                            <td></td>
                                            <!--YIELD-->         
                                            <td></td>
                                            <td></td>

                                            <td></td>
                                            <td></td>
                                            <!--SBSA Registered Area-->
                                            <td></td>
                                            <td > </td>
                                            <td > </td>
                                            <td></td>

                                            <td></td>
                                            

                                            <td style="width: 20px; font-size: 11px;"> </td>
                                            <!-- REPRESENTATIVE -->
                                            <td> </td>


                                            <td > </td>
                               
									</tr>


                                    <?php
									$itm++;
                                }
                            }
							$itm = 1;
							$breaker =1;
                            $cntIdentifier = 0;
                            break;
                        }

                    if($cntIdentifier ==  $row_param){
                       $breaker =1;
                        break;
                    }
                    ?>
				
				<tr>
					<td style="width: 10px; height: <?php echo e($td_height); ?>;">
                       
                        <?php if($mark == "empty"): ?>    
                      
                        <?php echo e($itm); ?>

                        <?php else: ?>
                        <?php echo e($itm); ?>

                        <?php endif; ?>
                        
                         </td>
					<td colspan="3" style="width:260px; font-size: 11px;">
                    
                    <?php if($mark == "mark"): ?>
                        <?php if($list[$cnt]["is_ebinhi"] == "0"): ?>
                        <b> <?php if(isset($tag_val)): ?>
                            *<?php echo e(strtoupper($list[$cnt]["lastName"])); ?>, <?php echo e(strtoupper($list[$cnt]["firstName"])); ?> <?php echo e(strtoupper($list[$cnt]["midName"])); ?>

                            <?php else: ?>
                            <?php echo e(strtoupper($list[$cnt]["lastName"])); ?>, <?php echo e(strtoupper($list[$cnt]["firstName"])); ?> <?php echo e(strtoupper($list[$cnt]["midName"])); ?>

                            <?php endif; ?>
                        </b>
                        <?php else: ?>
                        <b> <?php if(isset($tag_val)): ?>
                            *<?php echo e(strtoupper($list[$cnt]["lastName"])); ?>, <?php echo e(strtoupper($list[$cnt]["firstName"])); ?> <?php echo e(strtoupper($list[$cnt]["midName"])); ?>

                            <?php else: ?>
                            <?php echo e(strtoupper($list[$cnt]["lastName"])); ?>, <?php echo e(strtoupper($list[$cnt]["firstName"])); ?> <?php echo e(strtoupper($list[$cnt]["midName"])); ?>

                            <?php endif; ?> *</b>
                        <?php endif; ?> 
                    <?php elseif($mark == "empty"): ?>
                        



                    <?php else: ?>
                    <b>  <?php if(isset($tag_val)): ?>
                        *<?php echo e(strtoupper($list[$cnt]["lastName"])); ?>, <?php echo e(strtoupper($list[$cnt]["firstName"])); ?> <?php echo e(strtoupper($list[$cnt]["midName"])); ?>

                        <?php else: ?>
                        <?php echo e(strtoupper($list[$cnt]["lastName"])); ?>, <?php echo e(strtoupper($list[$cnt]["firstName"])); ?> <?php echo e(strtoupper($list[$cnt]["midName"])); ?>

                        <?php endif; ?> </b>
                    <?php endif; ?>
                    
                    
                    
                    </td>

                    <?php if($mark == "empty"): ?>
                    <td></td>
                    <td></td>
                    <td></td>
                    <?php else: ?>
					<td style="width: 60px; font-size: 11px;" align="center"><?php echo e($list[$cnt]["rsbsa_control_no"]); ?></td>
                    <td align="center">
                        <?php echo e(number_format($list[$cnt]["final_area"], 2)); ?>

                    </td>
                        <?php if($list[$cnt]["no_of_parcels"] <= 0): ?>
                            <td align="center">1</td>
                        <?php else: ?>
                            <td align="center"><?php echo e($list[$cnt]["no_of_parcels"]); ?></td>
                        <?php endif; ?>

                    <?php endif; ?>
                    <!-- CONTACT -->

                    <?php if(isset($list[$cnt]["is_prereg"])): ?>
                    <td align="center"> <?php echo e($list[$cnt]["final_area"]); ?></td>
                    <?php else: ?>
                    <td></td>
                    <?php endif; ?>



                    <?php if(isset($list[$cnt]["is_prereg"])): ?>
                    <td align="center"><?php echo e($list[$cnt]["no_of_bags"]); ?></td>
                    <?php else: ?>
                    <td> </td>
                    <?php endif; ?>

                    

                    <?php /* VARIETY */ ?>
                    <td></td> 

                    
                    <?php if(isset($list[$cnt]["is_prereg"])): ?>
                    <td align="center"><?php echo e($list[$cnt]["crop_est"]); ?></td>
                    <?php else: ?>
                    <td></td>
                    <?php endif; ?>

                    

                 
             

                    <?php if(isset($list[$cnt]["is_prereg"])): ?>
                  

                    <td align="center"><?php echo e($list[$cnt]["sowing_date"]); ?>   </td>
                    <?php else: ?>
                    <td style="width: 40px;" align="center"></td>
                    <?php endif; ?>
                    <td style="width: 40px;" align="center"></td>
                  
                 
                  



					
                    <?php if(isset($list[$cnt]["is_prereg"])): ?>
                        <td align="center" style="width: 20px;">I</td>
                    <?php else: ?>
                        <td style="width: 20px;"> </td>
                    <?php endif; ?>
                    <!-- REPRESENTATIVE -->
<?php /*  */ ?>
             
                    <!-- <td style="width: 50px;" align="center"> </td> -->

                        <td style="width: 50px;" align="center"> </td>

                    

                    <?php if(isset($list[$cnt]["is_prereg"])): ?>
                        <td style="width: 40px;" align="center"><?php echo e($list[$cnt]["yield_area"]); ?></td>
                    <?php else: ?>
                        <td style="width: 40px;" align="center"> </td>
                    <?php endif; ?>

                    <!--SBSA Registered Area-->
                    

                    <?php if(isset($list[$cnt]["is_prereg"])): ?>
                    <td style="width: 40px;" align="center"><?php echo e($list[$cnt]["yield_no_bags"]); ?></td>
                    <?php else: ?>
                    <td style="width: 40px;" align="center"></td>
                    <?php endif; ?>

                    <!--MAX BAG-->
                    <?php if(isset($list[$cnt]["is_prereg"])): ?>
                    <td style="width: 40px;" align="center"><?php echo e($list[$cnt]["yield_weight_bags"]); ?></td>
                    <?php else: ?>
                    <td style="width: 40px;" align="center"></td>
                    <?php endif; ?>


                   
                    
                    <td style="width: 40px;"> </td>


                    <td style="width: 135px;"> </td>
                  
                    <td style="width: 20px; font-size: 11px;"> </td>
                    <td style="width: 80px;"> </td>
				</tr>
					  <?php echo e($cntIdentifier++); ?>

						  <?php echo e($itm++); ?>

                <?php else: ?>
                <tr>
                    <td style="width: 10px; height: <?php echo e($td_height); ?>;">
                    
                        <?php if($mark == "empty"): ?>    
                       
                        <?php else: ?>
                        <?php echo e($itm); ?>

                        <?php endif; ?>
                    </td>
                    <td colspan="3" style="width:230px; font-size: 13px;"> </td>
                    <?php /* <td style="width: 60px; font-size: 11px;"> </td> SEX */ ?>
                    <td style="width: 60px; font-size: 11px;"> </td>
                    <td><center> </center></td>
                    <!-- Y/N -->
                
                    <td></td>
                    
                    <!-- CONTACT -->
                    <td></td>
                    <!--YIELD-->         
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                   
                    <td></td>
                      
                    <td style="width: 30px;"></td>    
                    <td></td>
                    <td style="width: 20px; font-size: 11px;"></td>    
                    <td></td>
                    <!--SBSA Registered Area-->
                    <td style="width: 60px;"></td>
                    <!-- NO OF BAGS -->
                    <td style="width: 80px;"></td>
                    <td style="width: 40px;"></td>     
                    <!-- REPRESENTATIVE -->
                    <td style="width: 20px;"></td>
                  
                    <td></td>
                    <td style="width: 10px;"></td>
                </tr>
                <?php endif; ?>
                   
                <?php echo e($cnt++); ?>

            <?php endfor; ?>
					  <?php 
				 if($breaker != 1){
					 if($cntIdentifier <  $row_param){
								 $r =  $row_param - $cntIdentifier ;
								 for($e=0;$e<$r;$e++){
									 ?>
									 <!-- EMPTY ROW -->
                                      <?php if($wData == 1): ?>
                                         <tr>
                                            <td style="width: 10px; height: <?php echo e($td_height); ?>;">                                            
                                                <?php if($mark == "empty"): ?>    
                                                <?php echo e($itm); ?>

                                                <?php else: ?>
                                                <?php echo e($itm); ?>

                                                <?php endif; ?>
                                            </td>
                                            <td colspan="3" style="width:230px; font-size: 13px;"> </td>
                                            <?php /* <td style="width: 60px; font-size: 11px;"> </td> SEX  */ ?>
                                            
                                            <td><center> </center></td>
                                            <!-- Y/N -->
                                    
                                            <td></td>
                                            
                                            <!-- CONTACT -->
                                            <td></td>
                                            <!--YIELD-->         
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <!--SBSA Registered Area-->
                                            <td ></td>
                                            <td ></td>
                                            <td ></td>
                                           
                                            <td></td>
                                            <td ></td>
                                            <!-- REPRESENTATIVE -->
                                            <td ></td>
                                          
                                            <td></td>
                                            <td></td>
                                         </tr>
                                      <?php else: ?>
                                         <tr>
                                            <td style="width: 10px; height: <?php echo e($td_height); ?>;">
                                                <?php if($mark == "empty"): ?>    
                                             
                                                <?php else: ?>
                                                <?php echo e($itm); ?>

                                                <?php endif; ?>
                                            
                                            </td>
                                            <td colspan="3" style="width:200px;  font-size: 10px;"> </td>
                                            <?php /* <td style="width: 60px; font-size: 11px;"> </td> SEX  */ ?>
                                            <td><center> </center></td>
                                            <!--AGE -->
                                            <td align="center" style="font-size: 11px; width: 30px;"> </td>
                                            <td> </td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <!-- CONTACT -->
                                            <td></td>
                                            <!--YIELD-->         
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <!--SBSA Registered Area-->
                                            <td style="width: 60px;"></td>
                                            <td style="width: 50px;"></td>
                                            <td style="width: 80px;"> </td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td style="width: 20px; font-size: 11px;"> </td>
                                            <!-- REPRESENTATIVE -->
                                            <td style="width: 20px;"> </td>
                                            <td></td>
                                            <td style="width: 30px;"> </td>
                                        </tr>
                                      <?php endif; ?>

								
									 <?php
								$itm++;
								 }
							 }
				 }
					?>
            <!--footer-->
            <tr>
                    <?php if($wData == 1): ?>
                        <th colspan="<?php echo e($w_data_col); ?>">
                    <?php else: ?>
                         <th colspan="<?php echo e($wo_data_col); ?>">
                    <?php endif; ?>
                   
                    <div style="margin-top:10px;margin-left: 10px; width:500px; height:70px; margin-bottom:10px;">
                        <span>Issued By: </span>
                      
                    </div>

                    <div style="position: fixed; bottom:90px; margin-top:10px;margin-left: 30px; width:500px; margin-bottom:10px;">
                        <div style="margin-left: 50px;">
                            <span>_______________________________________________</span><br>
                            <span style="margin-left: 5%; font-size: 10px;">Name and Signature of Authorized LGU Representative </span><br><br>
                            <span>_______________________________________________</span><br>
                            <span style="margin-left: 20%; font-size: 10px;">Position/Designation </span>
                        </div>
                    </div>



                    <div style="position: fixed; right:-80; bottom:70; width:500px;">
                        <span>Noted By: </span>
                    
                    </div>


                    <div style="position: fixed; right:-90; bottom:70; width:500px;">
                        <div style="margin-left: 50px;">
                            <span>_______________________________________________</span><br>
                            <span style="margin-left: 20%; font-size: 10px;">Name and Signature</span><br><br>
                        
                            <span style="margin-left: 30px; font-size: 12px;">RCEF Seed Regional/Provincial Coordinator </span>
                        </div>
                    </div>


                    <div style="position: fixed; left:30%; bottom:75; width:850px;">
                            <span>Variety 1: ______________ <small> Total Farmers: __________  Total Area: __________  Total Bags: __________ </small> </span><br>
                            <span>Variety 2: ______________ <small> Total Farmers: __________  Total Area: __________  Total Bags: __________ </small> </span><br>
                            <span>Variety 3: ______________ <small> Total Farmers: __________  Total Area: __________  Total Bags: __________ </small> </span><br>
                            <span>Variety 4: ______________ <small> Total Farmers: __________  Total Area: __________  Total Bags: __________ </small> </span><br>
                            <span>Variety 5: ______________ <small> Total Farmers: __________  Total Area: __________  Total Bags: __________ </small> </span><br>
                    
                    </div>


                    <div style="position: fixed; text-align: right; margin-right: 8px;  bottom:110px;right:5px;">
                        <?php /* <img src="<?php echo e(public_path('images/iso.jpg')); ?>" 
                            style="width: auto; height: 75px;"> */ ?>
                    </div>
                        <div style="position: fixed; text-align: right; margin-right: 10px;  bottom:15px;right:0px;">
                              <?php if($wData == 1): ?>
                               PhilRice RCEF FAR V<?php echo e($version_with_data); ?> Rev 04 Effectivity Date: 07 Aug 2023
                            <?php else: ?>
                               PhilRice RCEF FAR V<?php echo e($version_no_data); ?> Rev 04 Effectivity Date: 07 Aug 2023
                            <?php endif; ?>

                         </div>
                </th>
            </tr>


            </table>

            
        
        <div class="page-break"></div>
    <?php endfor; ?>
    

   

</body>
</html>
    