
@extends('layout.master')
@section('title', 'Standard Table')
@section('header-css')


  
  
@endsection
@section('content-header')
    <!-- Content Header (Page header) -->
<form role="form" id="ticket_form" method="post" action="{{url('save/standard/stage/table/')}}">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="display: inline;">{{$table['process']['process_name']}}</h1>
            <button type="submit" style="border: none;background-color: transparent;"><span class="fas fa-save">&nbsp</span>Save</button>
            <button type="reset" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>Clear</button>
            <a class="btn" href="#" style="border: none;background-color: transparent;"><span class="fas fa-edit">&nbsp</span>New</a>
              <!-- <div class="btn-group">
                  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" >
                      <i class="fa fa-print"></i>&nbsp;Print<i class="caret"></i>
                    </button>
                    <ul class="dropdown-menu">
                      <li><a href="#" class="dropdown-item">Sachet</a></li>
                    </ul>
                  </div> -->
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Standard</a></li>
              <li class="breadcrumb-item active">Table</li>
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
                <h3 class="card-title">{{'Std #: '.$std['std_no'].' Product: '.$std['master_article']['item_name']}}</h3>
              
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
              <input type="hidden" form="ticket_form" value="{{$table['process']['id']}}" name="process_id"/>
                <input type="hidden" form="ticket_form" value="{{$std['id']}}" name="std_id"/>
                <input type="hidden" form="ticket_form" value="{{$super['id']}}" name="super_id"/>
                <input type="hidden" form="ticket_form" value="{{$table['id']}}" name="table_id"/>

                <div class="form-row">

                  <div class="col-sm-4">
                <div class="form-group row">
                  <label class="col-sm-4">Std No.</label>
                  <input type="text" form="ticket_form" name="std_no" class="form-control select2 col-sm-8" value="{{$std['std_no']}}" readonly required style="width: 100%;">
                  </div>
                 </div>

                <div class="col-sm-4">
                <div class="form-group row">
                  <label class="col-sm-4">Product</label>
                  <input type="text" form="ticket_form" name="product" class="form-control select2 col-sm-8" value="{{$std['master_article']['item_name']}}" readonly required style="width: 100%;">
                  </div>
                 </div>

                 <div class="col-sm-4">
                <div class="form-group row">
                  <label class="col-sm-4">Super Process</label>
                  <input type="text" form="ticket_form" name="process_name" class="form-control select2 col-sm-8" value="{{$super['process_name']}}" readonly required style="width: 100%;">
                  </div>
                 </div>


                 <div class="col-sm-4">
                <div class="form-group row">
                  <label class="col-sm-4">Process Name</label>
                  <input type="text" form="ticket_form" name="process_name" class="form-control select2 col-sm-8" value="{{$table['process']['process_name']}}" readonly required style="width: 100%;">
                  </div>
                 </div>

                

               </div> <!--end tr of parameter-->


               
                         <?php 

                         $count=count($table['columns']);

                         $row_count=$table->default_row_count($std['id'],$super['id']);

                          ?>
                        <table class="table table-bordered table-hover">

                          <thead>
                             <tr>
                              
                                @for($i=0;$i<$count;$i++)
                                  <th>{{$table['columns'][$i]['heading']}}</th>
                                @endfor
                                <th></th>
                             </tr>

                             </thead>
                            

                           <tbody id="table_body">
                            <?php $row=1; ?>
                            @for($j=1;$j<=$row_count;$j++)
                             <tr id="{{'row_'.$row}}">
                               @for($i=0;$i<$count;$i++)

                                  <?php 

                                  $type=$table['columns'][$i]['type'];
                                        $head=$table['columns'][$i]['heading'];
                                  $value=$table['columns'][$i]->default_row_value($table['id'],$std['id'],$super['id'],$j); 

                                         ?>
                              <td>

                                <?php 

                                
                                $col='col_'.$table['columns'][$i]['id'].'[]';
                                  ?>
                              
                               
                               @if($type=='long_text')
                               <textarea name="{{$col}}">{{$value}}</textarea>
                               @else
                               <input type="{{$type}}" @if($type='number')step="any"@endif name="{{$col}}" value="{{$value}}">
                               @endif

                               </td>

                               
                                @endfor
                                 

                                 <td>
                                <button class="btn" form="dellRow" onclick="dellRow('{{$row}}')"><span class="fa fa-minus-circle text-danger"></span></button> 
                                </td>

                             </tr>
                                <?php $row++; ?>

                             @endfor
                             </tbody>



                             <tr>
                               @foreach($table['columns'] as $cl)
                                        <?php 
                                              if($cl['footer_type']=='sum')
                                              {
                                              $sum=$cl->default_col_sum($std['id'],$super['id']);
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
                                 <th><button form="addRow" class="btn" onclick="addRow()"><span class="fa fa-plus-circle text-success"></span></button> </th> 
                             </tr>
                        </table>
                        <!-- <div class="col-sm-12"><button class="float-sm-right"><span class="fa fa-plus-circle text-info"></span>&nbsp;Add Row</button></div> -->
                    
                

          
           
                 

                



              
                  
                  
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            </form>        



        
      </div>

    <!-- /.content -->
   
@endsection

@section('jquery-code')


<script type="text/javascript">

  var row_num="{{$row}}";

  function getRowNum()
 {
  return this.row_num;
}

function setRowNum()
{
  this.row_num +=1;
}

   function dellRow(row)
  {

     $(`#row_${row}`).remove();
  }
  
  function addRow()
  {
    
   var row=getRowNum();

     var cols=`<?php echo json_encode($table['columns']); ?>`; 
   cols= JSON.parse( cols );
        
         txt=`<tr id="row_${row}">`;

     for (var i = 0; i < cols.length; i++) {

     var type=cols[i]['type'];
      var id=cols[i]['id'];
    
    var n='';
      if(type=='long_text')
            { n=`<textarea form="ticket_form" name="col_${id}[]"></textarea>`;}
        else
             { n=`<input form="ticket_form" type="${type}" step="any" name="col_${id}[]" value="">`;}
                              
       
       var l=`<td>${n}</td>`;

       txt  = txt + l ;
       //txt = txt.concat(l);
     }

     txt=txt + '<td><button class="btn" form="dellRow" onclick="dellRow('+row+')"><span class="fa fa-minus-circle text-danger"></span></button> </td></tr>';
      setRowNum();
       $('#table_body').append(txt);
  }

</script>




@endsection  
  