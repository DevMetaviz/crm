   
@extends('layout.master')
@section('title', 'Initiate Process')
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
<form role="form" id="ticket_form" method="post" action="{{url('initiate/batch/stage/save')}}">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="display: inline;">{{$process['process_name']}}</h1>
            <button type="submit" style="border: none;background-color: transparent;"><span class="fas fa-save">&nbsp</span>Save</button>
            <button type="reset" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>Clear</button>
            <a class="btn" href="#" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>New</a>
              <!-- <div class="btn-group">
                  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" >
                      <i class="fa fa-print"></i>&nbsp;Print<i class="caret"></i>
                    </button>
                    <ul class="dropdown-menu">
                      <li><a href="{{url('plan-ticket/stage/report/'.$process['ticket_id'].'/'.$process['process_id'].'/'.$process['identity'])}}" class="dropdown-item">Print</a></li>
                      <li><a href="{{url('plan-ticket/stage/report/'.$process['ticket_id'].'/'.$process['process_id'].'/'.$process['identity'])}}" class="dropdown-item">Granulation1</a></li>
                      <li><a href="{{url('plan-ticket/stage/report/'.$process['ticket_id'].'/'.$process['process_id'].'/'.$process['identity'])}}" class="dropdown-item">Sachet</a></li>
                    </ul>
                  </div> -->
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Batch</a></li>
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
                <h3 class="card-title">{{'Ticket #: '.$ticket['ticket_no'].' Batch #: '.$ticket['batch_no']}}</h3>
              
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
              
                <input type="hidden" form="ticket_form" value="{{$ticket['id']}}" name="ticket_id"/>
                <input type="hidden" form="ticket_form" value="{{$process['id']}}" name="process_id"/>
                <?php
                  $std_id=$ticket['plan']->products->where('id',$ticket['inventory_id'])->first()->pivot->std_id;
                ?>
                <div class="form-row">

                  <div class="col-sm-4">
                <div class="form-group row">
                  <label class="col-sm-4">Plan No.</label>
                  <input type="text" form="ticket_form" name="plan_no" class="form-control select2 col-sm-8" value="{{$ticket['plan']['plan_no']}}" readonly required style="width: 100%;">
                  </div>
                 </div>

                <div class="col-sm-4">
                <div class="form-group row">
                  <label class="col-sm-4">Ticket No.</label>
                  <input type="text" form="ticket_form" name="ticket_no" class="form-control select2 col-sm-8" value="{{$ticket['ticket_no']}}" readonly required style="width: 100%;">
                  </div>
                 </div>

                 <div class="col-sm-4">
                <div class="form-group row">
                  <label class="col-sm-4">Process Name</label>
                  <input type="text" form="ticket_form" name="process_name" class="form-control select2 col-sm-8" value="{{$process['process_name']}}" readonly required style="width: 100%;">
                  </div>
                 </div>

                 

                 @foreach($process['parameters'] as $prmtr)

                 <?php 

                 $value=$prmtr->default_value($std_id,$process['id'],0);   
                 $type=$prmtr['type'];

                  ?>
                  
                  @if($type=='text' || $type=='time' || $type=='date')
                  <div class="col-sm-4">
                <div class="form-group row">
                  <label class="col-sm-4">{{$prmtr['name']}}</label>
                  <input type="{{$type}}" form="ticket_form" name="{{'parameter_'.$prmtr['id']}}" class="form-control select2 col-sm-8" value="{{$value}}"  style="width: 100%;">
                  </div>
                 </div>
                 @elseif($type=='number')
                 <div class="col-sm-4">
                <div class="form-group row">
                  <label class="col-sm-4">{{$prmtr['name']}}</label>
                  <input type="number" step="any" form="ticket_form" name="{{'parameter_'.$prmtr['id']}}" class="form-control select2 col-sm-8" value="{{$value}}"  style="width: 100%;">
                  </div>
                 </div>
                 @elseif($type=='long_text')
                  <div class="col-sm-4">
                <div class="form-group row">
                  <label class="col-sm-4">{{$prmtr['name']}}</label>
                  <textarea form="ticket_form" name="{{'parameter_'.$prmtr['id']}}" class="form-control select2 col-sm-8" style="width: 100%;">{{$value}}</textarea>
                  </div>
                 </div>
                 @elseif($type=='formula_text')
                 <div class="col-sm-4">
                <div class="form-group row">
                  <label class="col-sm-4">{{$prmtr['name']}}</label>
                  <input type="text" form="ticket_form" name="{{'parameter_'.$prmtr['id']}}" class="form-control select2 col-sm-8" value="{{$value}}"  style="width: 100%;" readonly>
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
                    $pr1=$process['parameters']->where('identity',$formula[0])->first();
                  $first=$pr1['name'];
                 
                 //$value1=$pr1['value'];
                 $value1=$pr1->default_value($std_id,$process['id'],0); 
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
                                      $let=$process['parameters']->where('identity',$formula[$i+1])->first();


                                      if($let!='')
                                       {
                                        $sec=$let['name']; 
                                      
                                        //$value2=$let['value'];
                                        $value2=$let->default_value($std_id,$process['id'],0); 
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

                    <input type="hidden" form="ticket_form" name="{{'parameter_'.$prmtr['id']}}"   > 
              
                      </fieldset>
                  </div>
                 @else
                   <div class="col-sm-4">
                <div class="form-group row">
                  <label class="col-sm-4">{{$prmtr['name']}}</label>
                  <input type="text" form="ticket_form" name="{{'parameter_'.$prmtr['id']}}" class="form-control select2 col-sm-8" value="{{$value}}"  style="width: 100%;">
                  </div>
                 </div> 
                 @endif

                 @endforeach

                 <div class="col-sm-2">
                <div class="form-group row">
                  <label class="col-sm-12"><input type="checkbox" form="ticket_form" name="{{'perform_'.$process['id']}}" value="1">&nbsp;Performed</label>
                  </div>
                 </div>

               </div><!--end parameter row-->

               @foreach($process['tables'] as $tab)
                         <?php $count=count($tab['columns']);
                            $row_count=$tab->default_row_count($std_id,$process['id']);
                          ?>
                        <table class="table table-bordered table-hover">
                             <tr>
                                @for($i=0;$i<$count;$i++)
                                  <th>{{$tab['columns'][$i]['heading']}}</th>
                                @endfor
                                <!-- <th></th> -->
                             </tr>
                            

                           <tbody>
                            
                            @for($j=1;$j<=$row_count;$j++)
                             <tr>
                               @for($i=0;$i<$count;$i++)

                                  <?php 

                                  $type=$tab['columns'][$i]['type'];
                                        $head=$tab['columns'][$i]['heading'];
                                         $value=$tab['columns'][$i]->default_row_value($tab['id'],$std_id,$process['id'],$j); 

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
                                              if($cl['footer_type']=='sum')
                                              {
                                          $sum=$cl->default_col_sum($std_id,$process['id']);
                                              }
                                         ?>
                               <th>
                                @if($cl['footer_type']=='sum')
                               {{$sum}}
                               @else
                               {{$cl['footer_text']}}
                               @endif
                             </th>
                                @endforeach
                               <!--  <th></th> -->
                             </tr>
                        </table>
                        <!-- <div class="col-sm-12"><button class="float-sm-right"><span class="fa fa-plus-circle text-info"></span>&nbsp;Add Row</button></div> -->
                    
                  @endforeach<!--end table loop-->

            

             <?php $subs=$process->sub_processes(); ?>
             @foreach($subs as $prs)
                  
                  <div class="bg-info p-1 m-1">
                        <h3>{{$prs['process_name']}}</h3>
                    </div>

              <div class="row">

               @foreach($prs['parameters'] as $prmtr)

                 


                 <?php 
                  
                  
                 $value=$prmtr->default_value($std_id,$prs['id'],$process['id']);
               
                 $type=$prmtr['type'];

                  ?>
                  
                  @if($type=='text' || $type=='time' || $type=='date')
                  <div class="col-sm-4">
                <div class="form-group row">
                  <label class="col-sm-4">{{$prmtr['name']}}</label>
                  <input type="{{$type}}" form="ticket_form" name="{{'parameter_'.$prmtr['id']}}" class="form-control select2 col-sm-8" value="{{$value}}"  style="width: 100%;">
                  </div>
                 </div>
                 @elseif($type=='number')
                 <div class="col-sm-4">
                <div class="form-group row">
                  <label class="col-sm-4">{{$prmtr['name']}}</label>
                  <input type="number" step="any" form="ticket_form" name="{{'parameter_'.$prmtr['id']}}" class="form-control select2 col-sm-8" value="{{$value}}"  style="width: 100%;">
                  </div>
                 </div>
                 @elseif($type=='checkbox')
                      <?php $opts=explode(',', $prmtr['formula']);  ?>
                                   
                    
                 <div class="col-sm-12">
                  <div class="form-group row">
                      <label class="col-sm-2">{{$prmtr['name']}}</label>
                       <div class="col-sm-10">
                         @foreach($opts as $opt)
                            <?php 

                                 $check='';
                                 if($value==$opt)
                                  $check='checked';
                                else
                                  $check='';
                              ?>
                          
                            <label class=""><input type="radio" form="ticket_form" name="{{'parameter_'.$prmtr['id']}}" value="{{$opt}}"  class="" {{$check}} >&nbsp&nbsp{{$opt}}</label>
                          @endforeach
                          
                       </div>
                  </div>
                </div>
                 @elseif($type=='long_text')
                  <div class="col-sm-4">
                <div class="form-group row">
                  <label class="col-sm-4">{{$prmtr['name']}}</label>
                  <textarea form="ticket_form" name="{{'parameter_'.$prmtr['id']}}" class="form-control select2 col-sm-8" style="width: 100%;">{{$value}}</textarea>
                  </div>
                 </div>
                 @elseif($type=='formula_text')
                 <div class="col-sm-4">
                <div class="form-group row">
                  <label class="col-sm-4">{{$prmtr['name']}}</label>
                  <input type="text"  form="ticket_form" name="{{'parameter_'.$prmtr['id']}}" class="form-control select2 col-sm-8" value="{{$value}}"  style="width: 100%;" readonly>
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
                      else{  //print_r(json_encode($prs['parameters']));die;
                    $pr1=$prs['parameters']->where('identity',$formula[0])->first();

                   
                  $first=$pr1['name'];
              
                  //$value1=$pr1['value'];
                    $value1=$pr1->default_value($std_id,$prs['id'],$process['id']);
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
                                      $let=$prs['parameters']->where('identity',$formula[$i+1])->first();


                                      if($let!='')
                                       {
                                        $sec=$let['name']; 
                                      //$value2=$let['value'];
                                      $value2=$let->default_value($std_id,$prs['id'],$process['id']);
                                        
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
                     

                      <input type="hidden" form="ticket_form" name="{{'parameter_'.$prmtr['id']}}"  value=""  > 
              
                      </fieldset>
                  </div>
                 @else
                   <div class="col-sm-4">
                <div class="form-group row">
                  <label class="col-sm-4">{{$prmtr['name']}}</label>
                  <input type="text" form="ticket_form" name="{{'parameter_'.$prmtr['id']}}" class="form-control select2 col-sm-8" value="{{$value}}"  style="width: 100%;">
                  </div>
                 </div> 
                 @endif



                 @endforeach<!--end parameter-->
                 </div><!--end parameter row-->

                 <div class="col-sm-2">
                <div class="form-group row">
                  <label class="col-sm-12"><input type="checkbox" form="ticket_form" name="{{'perform_'.$prs['id']}}" value="1">&nbsp;Performed</label>
                  </div>
                 </div>


                  @foreach($prs['tables'] as $tab)
                         <?php $count=count($tab['columns']);
                            $row_count=$tab->default_row_count($std_id,$process['id']);
                          ?>
                        <table class="table table-bordered table-hover">
                             <tr>
                                @for($i=0;$i<$count;$i++)
                                  <th>{{$tab['columns'][$i]['heading']}}</th>
                                @endfor
                                <!-- <th></th> -->
                             </tr>
                            

                           <tbody>
                            
                            @for($j=1;$j<=$row_count;$j++)
                             <tr>
                               @for($i=0;$i<$count;$i++)

                                  <?php 

                                  $type=$tab['columns'][$i]['type'];
                                       // $head=$tab['columns'][$i]['heading'];
                                         $value=$tab['columns'][$i]->default_row_value($tab['id'],$std_id,$process['id'],$j); 

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
                                              if($cl['footer_type']=='sum')
                                              {
                                          $sum=$cl->default_col_sum($std_id,$process['id']);
                                              }
                                         ?>
                               <th>
                                @if($cl['footer_type']=='sum')
                               {{$sum}}
                               @else
                               {{$cl['footer_text']}}
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
  