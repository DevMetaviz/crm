<html>
    <head>
        <title>{{$salary_doc['doc_no']}}</title>
        <style>
            /** 
                Set the margins of the page to 0, so the footer and the header
                can be of the full height and width !
             **/
            @page {
                margin: 0cm 0cm;
            }

            /** Define now the real margins of every page in the PDF **/
            body {
                margin-top: 3cm;
                margin-left: 0.3cm;
                margin-right: 0.3cm;
                margin-bottom: 2cm;
                font-family: Arial, Helvetica, sans-serif;
                font-size: 10px;
            }

            /** Define the header rules **/
            header {
                position: fixed;
                top: 0cm;
                left: 0cm;
                right: 0cm;
                height: 3cm;

                /** Extra personal styles **/
                /*background-color: #03a9f4;*/
                /*color: white;*/
                /*text-align: center;*/
                /*line-height: 1.5cm;*/
            }

            /** Define the footer rules **/
            footer {
                position: fixed; 
                bottom: 0cm; 
                left: 0cm; 
                right: 0cm;
                height: 2cm;

                /** Extra personal styles **/
                /*background-color: #03a9f4;
                color: white;
                text-align: center;
                line-height: 1.5cm;*/
                    }

                    
                    

                    .center-text{ text-align: center; }

                    
             
                    .page_num:after { content: counter(page); }

            .pages:after { content:  counter(pages); }

            .item-table{
             
            width: 100%;
             }

             .item-table tbody tr td,.item-table tbody tr th,.item-table tfoot tr th {
             
                border: 1px solid black;
                    min-height: 80px;
             }

             .emp-sign{
                        width: 8%;
                        
                    }


             .item-table tr td b {
             
                font-size: 12;

             }


           .col{
             
            padding: 5px;
            text-align: center;
            border-bottom: 1px solid black;
             }

             .col1{
             
            padding: 7px;
            text-align: center;
             }

             
             

             .sign{
              
              border-top: 1px solid black !important;
              
              padding : 10px ;

            }


             
             .cap{
                text-transform: capitalize;
             }
             
             
            
        </style>
    </head>
    <body>
        <!-- Define header and footer blocks before your content -->
        <header>
               <table width="100%" style="padding: 10px;" cellspacing="0">
        <tr>
            <td align="" style="width: 100%;">
                 <?php 
                 
         $m=date_create($salary_doc['month'].'-01' );
           $m=date_format($m,"M Y");

          ?>
                 <h1 class="center-text"><u>{{$name}}</u></h1>
                <h2 class="center-text"><i>Salary Sheet - {{$m}} </i></h2>

            </td>
            <td align="right"  style="width: 30%;">

               <img src="{{url('public/images/logo.jpg')}}" alt="Logo Image" height="80" width="180">
                
            </td>
        </tr>

       

        

    </table>
        </header>

       <script type="text/php">
    if (isset($pdf)) {
    echo $PAGE_COUNT;
        $x =  $pdf->get_width() - 90;
        $y =  $pdf->get_height() - 50;
        $text = "page {PAGE_NUM} of {PAGE_COUNT}";
        $font = null;
        $size = 10;
        $color = array(0,0,0);
        $word_space = 0.0;  //  default
        $char_space = 0.0;  //  default
        $angle = 0.0;   //  default
        $pdf->page_text($x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle);


    }
</script>

        <footer style="">
    <div>
        <!-- <p>Page <span class="page_num"></span> of <span class="pages"></span> -->
            <div style=""><br><p><span style="margin-left:60px;"></span><span style="margin-left:60px;"></span></p></div>
    </div>
    <div style="height:30px;background-color: #03a9f4;"></div>
  </footer>
        <!-- Wrap the content of your PDF inside a main tag -->
        <main style="width: 100%;">

            <table class="item-table " cellspacing="0" style="margin-top: 5px;">

     <thead style="background-color:#03a9f4;color: white;">
             <?php $a=count($allowances); $d=2+count($deductions); ?>
        

        
            <tr>
                    <th rowspan="2" >#</th>
                    <th rowspan="2">Name</th>
                    <th rowspan="2">Designation</th>
                    <th rowspan="2">Current Salary</th>
                     <th rowspan="2">ATT Days</th>
                    <th rowspan="2">Lates</th>
                    <th rowspan="2">Late Fine</th>
                    <th rowspan="2">OT (Hrs.)</th>
                    <th rowspan="2">OT Amount</th>
                    <th rowspan="2">Earned Salary</th>
                    
                    <th colspan="{{$a}}">Allowances</th>

                        
                     <th rowspan="2">Gross Salary</th>

                      <th colspan="{{$d}}">Deductions</th>  
                    
                    <th rowspan="2">Net Salary</th>
                    <th rowspan="2">Loan Deduction</th>
                    
                    <th rowspan="2">Payable Salary</th>
                    <th rowspan="2" class="min-width">Signature</th>
                    
                  </tr>

                  <tr>
            @foreach($allowances as $all)
                          <th>{{$all['text']}}</th>
                        @endforeach

            @foreach($deductions as $all)
                          <th>{{$all['text']}}</th>
                        @endforeach
                        <th>PNLTY</th>
                      <th>I.Tax</th>

            
             </tr>

        
        </thead>
        <tbody>
        <?php  $sr=1;
            $net_current=0; $net_late_fine=0; $net_overtime_amount=0; $net_earned=0; $net_gross=0; $net_penality=0; $net_tax=0; $net_net=0; $net_loan=0; $net_payable=0;

            $n_t_all=[]; $n_d_all=[];

            foreach($allowances as $all)
                   {
                    $index='all_'.$all['id'];
                      $t = [ $index=>0 ];    
                       $n_t_all=array_merge($n_t_all,$t);
                   }

                   foreach($deductions as $all)
                   {
                    $index='ded_'.$all['id'];
                      $t = [ $index=>0 ];    
                       $n_d_all=array_merge($n_d_all,$t);
                   }

           ?>
     @foreach($departments as $depart)
        
        <?php  $c=17+ count($deductions)+ count($allowances);  ?>

     <tr><td colspan="{{$c}}"><center><b>@if($depart['department']==''){{'No Departrment'}}@else {{$depart['department']['name']}} @endif</b></center>
                               
                              </td></tr>
             <?php  

             $current=0; $late_fine=0; $overtime_amount=0; $earned=0; $gross=0; $penality=0; $tax=0; $net=0; $loan=0; $payable=0;
              
              $t_all=[]; $d_all=[];
             foreach($allowances as $all)
                   {
                    $index='all_'.$all['id'];
                      $t = [ $index=>0 ];    
                       $t_all=array_merge($t_all,$t);
                   }

                   foreach($deductions as $all)
                   {
                    $index='ded_'.$all['id'];
                      $t = [ $index=>0 ];    
                       $d_all=array_merge($d_all,$t);
                   }
            
                   
               ?>  
                               @foreach($depart['employees'] as $emp)
                                   <tr>

                        <?php 

                        $salary=$salary_doc->salary($emp['id']); 

                        $current+=$salary['current_salary']; 
                        $late_fine+=$salary['late_fine']; $overtime_amount+=$salary['overtime_amount']; $earned+=$salary['earned_salary'];
                         $gross+=$salary['gross_salary']; 
                         $penality+=$salary['penality_charges']; 
                         $tax+=$salary['tax']; 
                         $net+=$salary['net_salary'];
                          $loan+=$salary['loan_deduction']; 
                          $payable+=$salary['payable_salary'];

                        ?>
                   

                  <td>{{$sr}}</td>
                     <td class="cap">{{$emp['name']}}</td>
                     <td class="cap">@if($emp['designation']!=''){{$emp['designation']['name']}}@endif</td>

                     <td>@if($salary['current_salary']==0){{'-'}}@else{{number_format($salary['current_salary'])}}@endif</td>

                     <td>@if($salary['attendance_days']==0){{'-'}}@else{{$salary['attendance_days']}}@endif</td>

                     <td>@if($salary['late_coming_days']==0){{'-'}}@else{{$salary['late_coming_days']}}@endif</td>

                      <td>@if($salary['late_fine']==0){{'-'}}@else{{number_format($salary['late_fine'])}}@endif</td>
                    
                     <td>@if($salary['overtime']==0){{'-'}}@else{{$salary['overtime']}}@endif</td>

                     <td>@if($salary['overtime_amount']==0){{'-'}}@else{{number_format($salary['overtime_amount'])}}@endif</td>

                     <td>@if($salary['earned_salary']==0){{'-'}}@else{{number_format($salary['earned_salary'])}}@endif</td>

                     @foreach($allowances as $all)
                          <td>
                           <?php
                            $amount=''; 
                            if($salary['allowances'] !='' )
                             {
                             $let=$salary['allowances']->where('id',$all['id'])->first();
                                  if($let!='')
                                    $amount=$let['pivot']['amount'];

                                    $index='all_'.$all['id'];

                                    $t_all[$index] =intval( $t_all[$index] ) + intval( $amount );
                             }

                             ?>
                            
                            @if($amount=='' || $amount==0 ){{'-'}}@else{{number_format(intval($amount))}}@endif
                             
                            
                          </td>
                        @endforeach

                        <td>@if($salary['gross_salary']==0){{'-'}}@else{{number_format($salary['gross_salary'])}}@endif</td>

                        @foreach($deductions as $all)
                          <td>
                           <?php
                            $amount=''; 
                            if($salary['deductions'] !='' )
                             {
                                 $let=$salary['deductions']->where('id',$all['id'])->first();
                                  if($let!='')
                                    $amount=$let['pivot']['amount'];

                                    $index='ded_'.$all['id'];

                                    $d_all[$index] =intval( $d_all[$index] ) + intval( $amount );

                             }
                             ?>
                          
                             @if($amount=='' || $amount==0){{'-'}}@else{{number_format(intval($amount))}}@endif
                            
                          </td>
                        @endforeach
                     
                      <td>@if($salary['penality_charges']==0){{'-'}}@else{{number_format($salary['penality_charges'])}}@endif</td>

                      <td>@if($salary['tax']==0){{'-'}}@else{{number_format($salary['tax'])}}@endif</td>
                      <td>@if($salary['net_salary']==0){{'-'}}@else{{number_format($salary['net_salary'])}}@endif</td>
                      <td>@if($salary['loan_deduction']==0){{'-'}}@else{{number_format($salary['loan_deduction'])}}@endif</td>
                      
                      <td>@if($salary['payable_salary']==0){{'-'}}@else{{number_format($salary['payable_salary'])}}@endif</td>
                      <td class="emp-sign"><br><br><br></td>
                     </tr>
                     <?php $sr++; ?>
                               @endforeach

                               <tr>
                     <th></th>
                    <th></th>
                    <th></th>
                    <th>@if($current==0){{'-'}}@else{{number_format($current)}}@endif</th>
                    <th></th>
                    <th></th>
                    <th>@if($late_fine==0){{'-'}}@else{{number_format($late_fine)}}@endif</th>
                    <th></th>
                    <th>@if($overtime_amount==0){{'-'}}@else{{number_format($overtime_amount)}}@endif</th>
                    <th>@if($earned==0){{'-'}}@else{{number_format($earned)}}@endif</th>
                     @foreach($allowances as $all)
                     <?php $index='all_'.$all['id']; ?>
                          <th>@if($t_all[$index]==0){{'-'}}@else{{number_format($t_all[$index])}}@endif</th>
                        @endforeach
                     <th>@if($gross==0){{'-'}}@else{{number_format($gross)}}@endif</th>

                        @foreach($deductions as $all)
                        <?php $index='ded_'.$all['id']; ?>
                          <th>@if($d_all[$index]==0){{'-'}}@else{{number_format($d_all[$index])}}@endif</th>
                        @endforeach
                    <th>@if($penality==0){{'-'}}@else{{number_format($penality)}}@endif</th>                    
                    <th>@if($tax==0){{'-'}}@else{{number_format($tax)}}@endif</th>
                    <th>@if($net==0){{'-'}}@else{{number_format($net)}}@endif</th>                    
                    <th>@if($loan==0){{'-'}}@else{{number_format($loan)}}@endif</th>
                    <th>@if($payable==0){{'-'}}@else{{number_format($payable)}}@endif</th>
                     <th class="emp-sign"></th>
                  </tr>
     
       <?php
         
         $net_current+=$current; $net_late_fine+=$late_fine; $net_overtime_amount+=$overtime_amount; $net_earned+=$earned; $net_gross+=$gross; $net_penality+=$penality; $net_tax+=$tax; $net_net+=$net; $net_loan+=$loan; $net_payable+=$payable;

         foreach($allowances as $all)
         {
            $index='all_'.$all['id'];

            $n_t_all[$index] =intval( $n_t_all[$index] ) + intval( $t_all[$index] );
         }

         foreach($deductions as $all)
         {
            $index='ded_'.$all['id'];

            $n_d_all[$index] =intval( $n_d_all[$index] ) + intval( $d_all[$index] );
         }


        ?>
       
       @endforeach
       </tbody>
       <tfoot>
        <tr >
         <th></th>
                    <th></th>
                    <th></th>
                    <th>@if($net_current==0){{'-'}}@else{{number_format($net_current)}}@endif</th>
                    <th></th>
                    <th></th>
                    <th>@if($net_late_fine==0){{'-'}}@else{{number_format($net_late_fine)}}@endif</th>
                    <th></th>
                    <th>@if($net_overtime_amount==0){{'-'}}@else{{number_format($net_overtime_amount)}}@endif</th>
                    <th>@if($net_earned==0){{'-'}}@else{{number_format($net_earned)}}@endif</th>
                     @foreach($allowances as $all)
                     <?php
                         $index='all_'.$all['id'];
                         $amount=$n_t_all[$index];
                      ?>
                          <th>@if($amount==0){{'-'}}@else{{number_format($amount)}}@endif</th>
                        @endforeach
                     <th>@if($net_gross==0){{'-'}}@else{{number_format($net_gross)}}@endif</th>

                        @foreach($deductions as $all)
                        <?php
                            $index='ded_'.$all['id'];
                           $amount=$n_d_all[$index];
 
                         ?>
                          <th>@if($amount==0){{'-'}}@else{{number_format($amount)}}@endif</th>
                        @endforeach
                    <th>@if($net_penality==0){{'-'}}@else{{number_format($net_penality)}}@endif</th>                    
                    <th>@if($net_tax==0){{'-'}}@else{{number_format($net_tax)}}@endif</th>
                    <th>@if($net_net==0){{'-'}}@else{{number_format($net_net)}}@endif</th>                    
                    <th>@if($net_loan==0){{'-'}}@else{{number_format($net_loan)}}@endif</th>
                    <th>@if($net_payable==0){{'-'}}@else{{number_format($net_payable)}}@endif</th>
                     <th class="emp-sign"></th>

       </tr>
     </tfoot>

   </table>


        

   <table class="" style="border-spacing:50px; width: 100%;">
      <tr >
         <th class="sign"><span>Prepared & Checked By</span></th>
         <th class="sign"><span >Verified By</span></th>
         <!-- <th class="sign"><span >Received By</span></th> -->
         <th class="sign"><span>Approved By</span></th>
      </tr>
   </table>


        </main>


        
    </body>
</html>