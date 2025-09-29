 
@extends('layout.master')
@section('title', 'Ticket Process')
@section('header-css')


<!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/katex@0.10.0-rc.1/dist/katex.min.css" integrity="sha384-D+9gmBxUQogRLqvARvNLmA9hS2x//eK1FhVb9PiU86gmcrBrJAQT8okdJ4LMp2uv" crossorigin="anonymous"> -->

<link rel="stylesheet" href="{{url('public/own/formula/katex.min.css')}}" integrity="sha384-D+9gmBxUQogRLqvARvNLmA9hS2x//eK1FhVb9PiU86gmcrBrJAQT8okdJ4LMp2uv" crossorigin="anonymous">

    <!-- The loading of KaTeX is deferred to speed up page rendering -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/katex@0.10.0-rc.1/dist/katex.min.js" integrity="sha384-483A6DwYfKeDa0Q52fJmxFXkcPCFfnXMoXblOkJ4JcA8zATN6Tm78UNL72AKk+0O" crossorigin="anonymous"></script> -->

    <script src="{{url('public/own/formula/katex.min.js')}}" integrity="sha384-483A6DwYfKeDa0Q52fJmxFXkcPCFfnXMoXblOkJ4JcA8zATN6Tm78UNL72AKk+0O" crossorigin="anonymous"></script>

    <!-- To automatically render math in text elements, include the auto-render extension: -->
    <!-- <script defer src="https://cdn.jsdelivr.net/npm/katex@0.10.0-rc.1/dist/contrib/auto-render.min.js" integrity="sha384-yACMu8JWxKzSp/C1YV86pzGiQ/l1YUfE8oPuahJQxzehAjEt2GiQuy/BIvl9KyeF" crossorigin="anonymous"
        onload="renderMathInElement(document.body);"></script> -->

        <script defer src="{{url('public/own/formula/auto-render.min.js')}}" integrity="sha384-yACMu8JWxKzSp/C1YV86pzGiQ/l1YUfE8oPuahJQxzehAjEt2GiQuy/BIvl9KyeF" crossorigin="anonymous"
        onload="renderMathInElement(document.body);"></script>

  
@endsection
@section('content-header')
    <!-- Content Header (Page header) -->
<form role="form" id="ticket_form" method="post" action="{{url('ticket/stage/save')}}">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="display: inline;">{{$ticket_process['process']['process_name']}}</h1>
            <button type="submit" style="border: none;background-color: transparent;"><span class="fas fa-save">&nbsp</span>Save</button>
            <button type="reset" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>Clear</button>
            <a class="btn" href="#" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>New</a>
              <div class="btn-group">
                  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" >
                      <i class="fa fa-print"></i>&nbsp;Print<i class="caret"></i>
                    </button>
                    <ul class="dropdown-menu">
                      <li><a href="{{url('plan-ticket/stage/report/'.$ticket_process['ticket_id'].'/'.$ticket_process['process_id'].'/'.$ticket_process['process']['identity'])}}" class="dropdown-item">Print</a></li>
                      <!-- <li><a href="{{url('plan-ticket/stage/report/'.$ticket_process['ticket_id'].'/'.$ticket_process['process_id'].'/'.$ticket_process['identity'])}}" class="dropdown-item">Granulation1</a></li>
                      <li><a href="{{url('plan-ticket/stage/report/'.$ticket_process['ticket_id'].'/'.$ticket_process['process_id'].'/'.$ticket_process['identity'])}}" class="dropdown-item">Sachet</a></li> -->
                    </ul>
                  </div>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Ticket</a></li>
              <li class="breadcrumb-item active">Process</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
  @endsection

@section('content')
    <!-- Main content -->

    
      <div class="container-fluid" style="margin-top: 10px;">

          

         <div class="card">
              <div class="card-header">
                <h3 class="card-title">{{'Ticket #: '.$ticket_process['ticket']['ticket_no'].' Batch #: '.$ticket_process['ticket']['batch_no']}}</h3>
              
              </div>
              <!-- /.card-header -->
              <div class="card-body">

                @if(session()->has('success'))
    <div class="alert alert-success alert-dismissible col-md-3">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
        {{ session()->get('success') }}
    </div>
             @endif

                <input type="hidden" form="ticket_form" value="{{csrf_token()}}" name="_token"/>
                <input type="hidden" form="ticket_form" value="{{$ticket_process['process_id']}}" name="process_id"/>
                <input type="hidden" form="ticket_form" value="{{$ticket_process['ticket_id']}}" name="ticket_id"/>
                <input type="hidden" form="ticket_form" value="{{$ticket_process['id']}}" name="ticket_process_id"/>

                <div class="form-row">

                  <div class="col-sm-4">
                <div class="form-group row">
                  <label class="col-sm-4">Plan No.</label>
                  <input type="text" form="ticket_form" name="plan_no" class="form-control select2 col-sm-8" value="{{$ticket_process['ticket']['plan']['plan_no']}}" readonly required style="width: 100%;">
                  </div>
                 </div>

                <div class="col-sm-4">
                <div class="form-group row">
                  <label class="col-sm-4">Ticket No.</label>
                  <input type="text" form="ticket_form" name="ticket_no" class="form-control select2 col-sm-8" value="{{$ticket_process['ticket']['ticket_no']}}" readonly required style="width: 100%;">
                  </div>
                 </div>

                 <div class="col-sm-4">
                <div class="form-group row">
                  <label class="col-sm-4">Process Name</label>
                  <input type="text" form="ticket_form" name="process_name" class="form-control select2 col-sm-8" value="{{$ticket_process['process']['process_name']}}" readonly required style="width: 100%;">
                  </div>
                 </div>

                 @foreach($ticket_process['ticket_parameters'] as $pt)

                 <?php 

                   $value=$pt['value'];
                
                    $prmtr=$pt['parameter'];
                     $type=$prmtr['type'];
                  ?>
                  
                  @if($type=='text' || $type=='time' || $type=='date' || $type=='datetime-local')
                  <div class="col-sm-4">
                <div class="form-group row">
                  <label class="col-sm-4">{{$prmtr['name']}}</label>
                  <input type="{{$type}}" form="ticket_form" name="{{'parameter_'.$pt['id']}}" class="form-control select2 col-sm-8" value="{{$value}}"  style="width: 100%;">
                  </div>
                 </div>
                 @elseif($type=='number')
                 <div class="col-sm-4">
                <div class="form-group row">
                  <label class="col-sm-4">{{$prmtr['name']}}</label>
                  <input type="number" step="any" form="ticket_form" name="{{'parameter_'.$pt['id']}}" class="form-control select2 col-sm-8" value="{{$value}}"  style="width: 100%;">
                  </div>
                 </div>
                 @elseif($type=='long_text')
                  <div class="col-sm-4">
                <div class="form-group row">
                  <label class="col-sm-4">{{$prmtr['name']}}</label>
                  <textarea form="ticket_form" name="{{'parameter_'.$pt['id']}}" class="form-control select2 col-sm-8" style="width: 100%;">{{$value}}</textarea>
                  </div>
                 </div>
                 @elseif($type=='formula_text')
                 <?php $value=$pt->formula_result(); ?>
                  <div class="col-sm-4">
                <div class="form-group row">
                  <label class="col-sm-4">{{$prmtr['name']}}</label>
                  <input type="text" form="ticket_form" name="{{'parameter_'.$pt['id']}}" class="form-control select2 col-sm-8" value="{{$value}}"  style="width: 100%;" readonly>
                  </div>
                 </div>

                 @elseif($type=='formula_show')
                 <div class="col-sm-12">
                      <fieldset class="border p-4">
                         <legend class="w-auto">Calculation</legend>
                            
                           <?php 

                           $formula=explode(',',$prmtr['formula']);
                            
                           if(is_numeric($formula[0])==1)
                                    {
                                      $first=$formula[0];
                 
                                       $value1=$formula[0];
                                    }
                      else{
                    $pr1=$ticket_process['process']['parameters']->where('identity',$formula[0])->first();
                  $first=$pr1['name'];
                 
                 $value1=$pr1['value'];
               }

                        if($value1=='')
                          $value1=0;

                        $result=$value1;

                        $first=str_replace(" ","\ ",$first);
                            $term=''; $term1=''; 
                                for ($i=1;$i< count($formula)-1; $i++ ) {
                                  
                                  
                            $sec='';
                                   if(is_numeric($formula[$i+1])==1)
                                    {
                                      $sec=$formula[$i+1];
                                      $value2=$formula[$i+1];
                                    }
                              
                                     else
                                    { 
                                      $let=$ticket_process['process']['parameters']->where('identity',$formula[$i+1])->first();


                                      if($let!='')
                                       {
                                        $sec=$let['name']; 
                                      
                                        $value2=$let['value'];
                                        if($value2=='')
                                          $value2=0;
                                      }
                                     else
                                      {$sec=''; $value2=0;}

                                   

                                    $sec=str_replace(" ","\ ",$sec);
                                        }
                                 
                                      
                               if($formula[$i]=='+' || $formula[$i]=='-' || $formula[$i]=='*' )
                                {   
                                  $term='{' .$first.$formula[$i].$sec.' }';
                                  $term1='{' .$value1.$formula[$i].$value2.' }';
                                  if($formula[$i]=='+')
                                  $result=$result + $value2 ;
                                  if($formula[$i]=='-')
                                  $result=$result - $value2 ;
                                if($formula[$i]=='*')
                                  $result=$result * $value2 ;
                                 }
                               elseif($formula[$i]=='/')
                                 {
                                  $term='\frac {' .$first.'}'.'{'.$sec.' }';
                                  $term1='\frac {' .$value1.'}'.'{'.$value2.' }';

                                  if($value2==0)
                                    $result=0;
                                  else
                                  $result=$result / $value2 ;
                                    }
                                
                                $first=$term;
                                $value1=$term1;
                                 
                                }

                                $result=round($result);

                                $name=str_replace(' ', '\ ', $prmtr['name'] );
                                $name=str_replace('%', '\%', $prmtr['name'] );
                                $term=str_replace('%', '\%', $term );
                            ?>


                       <p>\( {{ $name.' = '.$term}} \)</p>

                       <p>\( {{$name.'  = '.$term1}} \)</p>
                        
                        <p>\( {{$name.'  = '.$result }} \)</p>

                       <!-- <input type="hidden" form="ticket_form" name="{{'parameter_'.$prmtr['id']}}"  value="{{$result}}"  > -->
              
                      </fieldset>
                  </div>
                 @else
                   <div class="col-sm-4">
                <div class="form-group row">
                  <label class="col-sm-4">{{$prmtr['name']}}</label>
                  <input type="text" form="ticket_form" name="{{'parameter_'.$pt['id']}}" class="form-control select2 col-sm-8" value="{{$value}}"  style="width: 100%;">
                  </div>
                 </div> 
                 @endif

                 @endforeach

                 <div class="col-sm-2">
                <div class="form-group row">
                  <?php $checked=''; 
                        if($ticket_process['is_performed']==1)
                        $checked='checked';
                    ?>
                  <label class="col-sm-12"><input type="checkbox" form="ticket_form" name="{{'perform_'.$ticket_process['id']}}" value="1" {{$checked}} >&nbsp;Performed</label>
                  </div>
                 </div>

               </div><!--end parameter row-->

               @foreach($ticket_process['tables'] as $tab)
                         <?php $count=count($tab['columns']);
                                 $row=$tab->default_row_count();
                          ?>
                        <table class="table table-bordered table-hover">

                          <tr>
                            <th colspan="{{$count}}">{{$tab['table']['name']}}
                                    <a href="{{url('ticket/stage/table/'.$ticket_process['ticket']['id'].'/'.$ticket_process['id'].'/'.$tab['id'])}}" class="btn btn-info">Edit</a>
                                    </th>
                          </tr>
                          
                             <tr>
                                @for($i=0;$i<$count;$i++)
                                  <th>{{$tab['columns'][$i]['column']['heading']}}</th>
                                @endfor
                                <!-- <th></th> -->
                             </tr>
                            

                           <tbody>
                            
                            @for($j=1;$j<=$row;$j++)
                             <tr>
                               @for($i=0;$i<$count;$i++)

                                  <?php 

                                  $type=$tab['columns'][$i]['type'];
                                        $head=$tab['columns'][$i]['heading'];
                                         $value=$tab['columns'][$i]->row_value($tab['id'],$tab['columns'][$i]['id'],$j); 

                                         ?>
                              <td>

                                <?php 

                                $tbls='tbls_'.$tab['id'].'_'.$tab['columns'][$i]['id'].'[]';
                                $cols='cols_'.$tab['id'].'_'.$tab['columns'][$i]['id'].'[]';
                                $sorts='sorts_'.$tab['id'].'_'.$tab['columns'][$i]['id'].'[]';
                                $values='values_'.$tab['id'].'_'.$tab['columns'][$i]['id'].'[]';
                                  ?>

                              <input type="hidden" name="{{$tbls}}" value="{{$tab['id']}}">
                              <input type="hidden" name="{{$cols}}" value="{{$tab['columns'][$i]['id']}}">
                              <input type="hidden" name="{{$sorts}}" value="{{$j}}">

                               <input type="{{$type}}" @if($type='number')step="any"@endif name="{{$values}}" value="{{$value}}">

                               </td>

                               
                                @endfor
                               <!--  <td><button class="btn" onclick="delete_tbl_row('','')"><span class="fa fa-minus-circle text-danger"></span></button></td> -->
                             </tr>
                        
                             @endfor
                             </tbody>



                             <tr>
                               @foreach($tab['columns'] as $cl)
                                        <?php 
                                              if($cl['column']['footer_type']=='sum')
                                              {
                                          $sum=$cl->col_sum($tab['id']);
                                              }
                                         ?>
                               <th>
                                @if($cl['column']['footer_type']=='sum')
                               {{$sum}}
                               @else
                               {{$cl['column']['footer_text']}}
                               @endif
                             </th>
                                @endforeach
                               <!--  <th></th> -->
                             </tr>
                        </table>
                        <!-- <div class="col-sm-12"><button class="float-sm-right"><span class="fa fa-plus-circle text-info"></span>&nbsp;Add Row</button></div> -->
                    
                  @endforeach<!--end table loop-->

                    @if($ticket_process['process']['identity']=='dispensing')
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                   <th style="">SR #</th>
                   <th style="">MATERIAL NAME</th>
                   <th style="">ASSAY ADJUSTMENT (IF ANY)</th>
                   <th style="">QUANTITY (KG)</th>
                   <th style="">GRN #</th>
                   <th style="">QC #</th>
                   <th style="">WEIGHED BY</th>
                   <th style="">CHECKED BY (QA)</th>
                   
               </tr>
                    </thead>

                    <tbody>
                       <?php $items=$ticket_process['ticket']['estimated_material']->where('department_id','2'); ?>
            @foreach($items as $it)
             <tr>
                   <td ></td>
                   <td >
                    {{$it['item_name']}}

                   </td>
                   <td ></td>
                   <td >{{$it['pivot']['quantity']}}</td>
                   <td ></td>
                   <td ></td>
                   <td ></td>
                   <td ></td>
               </tr>

              
            @endforeach
                    </tbody>
                    
                  </table>
                  @endif

             <?php $subs=$ticket_process->sub_processes; ?>
             @foreach($subs as $prs)
                  
                  <div class="bg-info p-1 m-1">
                        <h3>{{$prs['process']['identity']}}</h3>
                    </div>

              <div class="row">

               
               @foreach($prs['ticket_parameters'] as $pt)
                 

                 <?php 

                   $value=$pt['value'];
                
                    $prmtr=$pt['parameter'];
                     $type=$prmtr['type'];
                  ?>
                  
                  @if($type=='text' || $type=='time' || $type=='date' || $type=='datetime-local')
                  <div class="col-sm-4">
                <div class="form-group row">
                  <label class="col-sm-4">{{$prmtr['name']}}</label>
                  <input type="{{$type}}" form="ticket_form" name="{{'parameter_'.$pt['id']}}" class="form-control select2 col-sm-8" value="{{$value}}"  style="width: 100%;">
                  </div>
                 </div>
                 @elseif($type=='number')
                 <div class="col-sm-4">
                <div class="form-group row">
                  <label class="col-sm-4">{{$prmtr['name']}}</label>
                  <input type="number" step="any" form="ticket_form" name="{{'parameter_'.$pt['id']}}" class="form-control select2 col-sm-8" value="{{$value}}"  style="width: 100%;">
                  </div>
                 </div>
                 @elseif($type=='long_text')
                  <div class="col-sm-4">
                <div class="form-group row">
                  <label class="col-sm-4">{{$prmtr['name']}}</label>
                  <textarea form="ticket_form" name="{{'parameter_'.$pt['id']}}" class="form-control select2 col-sm-8" style="width: 100%;">{{$value}}</textarea>
                  </div>
                 </div>
                 @elseif($type=='formula_text')
                 <?php $value=$pt->formula_result(); ?>
                 <div class="col-sm-4">
                <div class="form-group row">
                  <label class="col-sm-4">{{$prmtr['name']}}</label>
                  <input type="text" form="ticket_form" name="{{'parameter_'.$pt['id']}}" class="form-control select2 col-sm-8" value="{{$value}}"  style="width: 100%;" readonly>
                  </div>
                 </div>
                 @elseif($type=='formula_show')
                 <div class="col-sm-12">
                      <fieldset class="border p-4">
                         <legend class="w-auto">Calculation</legend>
                            
                           <?php 

                           $formula=explode(',',$prmtr['formula']);
                            
                            if(is_numeric($formula[0])==1)
                                    {
                                      $first=$formula[0];
                 
                                       $value1=$formula[0];
                                    }
                      else{
                    $pr1=$prs['ticket_parameters']->where('parameter.identity',$formula[0])->first();
                  $first=$pr1['parameter']['name'];
                 
                 $value1=$pr1['value'];
                      if($pr1['parameter']['type']=='formula_show')
                        $value1=$pr1->formula_result();

                     }

                        if($value1=='')
                          $value1=0;

                        $result=$value1;

                        $first=str_replace(" ","\ ",$first);
                            $term=''; $term1=''; 
                                for ($i=1;$i< count($formula)-1; $i++ ) {
                                  
                                  
                            $sec='';
                                   if(is_numeric($formula[$i+1])==1)
                                    {
                                      $sec=$formula[$i+1];
                                      $value2=$formula[$i+1];
                                    }
                              
                                     else
                                    { 
                                      $let=$prs['ticket_parameters']->where('parameter.identity',$formula[$i+1])->first();


                                      if($let!='')
                                       {
                                        $sec=$let['parameter']['name']; 
                                      
                                        $value2=$let['value'];
                                        if($let['parameter']['type']=='formula_show')
                                           $value2=$let->formula_result();
                                        if($value2=='')
                                          $value2=0;
                                      }
                                     else
                                      {$sec=''; $value2=0;}

                                   

                                    $sec=str_replace(" ","\ ",$sec);
                                        }
                                 
                                      
                               if($formula[$i]=='+' || $formula[$i]=='-' || $formula[$i]=='*' )
                                {   
                                  $term='{' .$first.$formula[$i].$sec.' }';
                                  $term1='{' .$value1.$formula[$i].$value2.' }';
                                  if($formula[$i]=='+')
                                  $result=$result + $value2 ;
                                  if($formula[$i]=='-')
                                  $result=$result - $value2 ;
                                if($formula[$i]=='*')
                                  $result=$result * $value2 ;
                                 }
                               elseif($formula[$i]=='/')
                                 {
                                  $term='\frac {' .$first.'}'.'{'.$sec.' }';
                                  $term1='\frac {' .$value1.'}'.'{'.$value2.' }';

                                  if($value2==0)
                                    $result=0;
                                  else
                                  $result=round( (float)$result / $value2 , 4 );
                                    }
                                
                                $first=$term;
                                $value1=$term1;
                                 
                                }

                                //$result=round($result);

                                $name=str_replace(' ', '\ ', $prmtr['name'] );
                                $name=str_replace('%', '\%', $prmtr['name'] );
                                $term=str_replace('%', '\%', $term );
                            ?>


                       <p>\( {{ $name.' = '.$term}} \)</p>

                       <p>\( {{$name.'  = '.$term1}} \)</p>
                        
                        <p>\( {{$name.'  = '.$result }} \)</p>
                     

                      <input type="hidden" form="ticket_form" name="{{'parameter_'.$pt['id']}}"  value=""  >
              
                      </fieldset>
                  </div>
                 @else
                   <div class="col-sm-4">
                <div class="form-group row">
                  <label class="col-sm-4">{{$prmtr['name']}}</label>
                  <input type="text" form="ticket_form" name="{{'parameter_'.$pt['id']}}" class="form-control select2 col-sm-8" value="{{$value}}"  style="width: 100%;">
                  </div>
                 </div> 
                 @endif

                 @endforeach<!--end parameter-->

                 <div class="col-sm-2">
                <div class="form-group row">
                  <?php $checked=''; 
                        if($prs['is_performed']==1)
                        $checked='checked';
                    ?>
                  <label class="col-sm-12"><input type="checkbox" form="ticket_form" name="{{'perform_'.$prs['id']}}" value="1" {{$checked}} >&nbsp;Performed</label>
                  </div>
                 </div>


                 </div><!--end parameter row-->
                        
                 @foreach($prs['tables'] as $tab)
                         <?php $count=count($tab['columns']);
                                $row=$tab->default_row_count();
                          ?>
                          
                        <table class="table table-bordered table-hover">

                          <tr>
                            <th colspan="{{$count}}">{{$tab['table']['name']}}
                                    <a href="{{url('ticket/stage/table/'.$ticket_process['ticket']['id'].'/'.$ticket_process['id'].'/'.$tab['id'])}}" class="btn btn-info">Edit</a>
                                    </th>
                          </tr>

                             <tr>
                                @for($i=0;$i<$count;$i++)
                                  <th>{{$tab['columns'][$i]['column']['heading']}}</th>
                                @endfor
                                <!-- <th></th> -->
                             </tr>
                            

                           <tbody>
                            
                            @for($j=1;$j<=$row;$j++)
                             <tr>
                               @for($i=0;$i<$count;$i++)

                                  <?php 

                                  $type=$tab['columns'][$i]['column']['type'];
                                        $head=$tab['columns'][$i]['column']['heading'];
                                         $value=$tab['columns'][$i]->row_value($tab['id'],$tab['columns'][$i]['id'],$j); 

                                         ?>
                              <td>

                                <?php 

                              
                                $values='values_'.$tab['id'].'_'.$tab['columns'][$i]['id'].'[]';
                                  ?>

                              
                              

                               <input type="{{$type}}" @if($type='number')step="any"@endif name="{{$values}}" value="{{$value}}">

                               </td>

                               
                                @endfor
                               <!--  <td><button class="btn" onclick="delete_tbl_row('','')"><span class="fa fa-minus-circle text-danger"></span></button></td> -->
                             </tr>
                        
                             @endfor
                             </tbody>



                             <tr>
                               @foreach($tab['columns'] as $cl)
                                        <?php 
                                              if($cl['column']['footer_type']=='sum')
                                              {
                                          $sum=$cl->col_sum($tab['id']);
                                              }
                                         ?>
                               <th>
                                @if($cl['column']['footer_type']=='sum')
                               {{$sum}}
                               @else
                               {{$cl['column']['footer_text']}}
                               @endif
                             </th>
                                @endforeach
                               <!--  <th></th> -->
                             </tr>
                        </table>
                        <!-- <div class="col-sm-12"><button class="float-sm-right"><span class="fa fa-plus-circle text-info"></span>&nbsp;Add Row</button></div> -->
                    
                  @endforeach<!--end table loop-->


              @endforeach<!--end sub stages-->
                 

                



              
                  
                  
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            </form>        



        
      </div>

    <!-- /.content -->
   
@endsection

@section('jquery-code')







@endsection  
  