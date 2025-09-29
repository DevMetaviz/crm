
@extends('layout.master')
@section('title', 'Daily Rates')
@section('header-css')


  
@endsection
@section('content-header')
    <!-- Content Header (Page header) -->

      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="display: inline;">Daily Rates</h1>
           
           

          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Configuration</a></li>
              <li class="breadcrumb-item active">Daily Rates</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
  @endsection

@section('content')
    <!-- Main content -->

    
     
@if(session()->has('success'))
  <div class="alert alert-success alert-dismissible">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
      {{ session()->get('success') }}
  </div>
           @endif

           
                      @if ($errors->has('error'))
                                  
                    <div class="alert alert-danger alert-dismissible alert-inline">
                                  <button type="button" class="close" data-dismiss="alert" style="">&times;</button>
                                     {{ $errors->first('error') }}
                                        </div>  
                              @endif
   


    <div class="container-fluid">


        
    



     


    <!--<h3>Cheques List</h3>-->

    <div class="text-right" >
    <a href="{{ route('rates.create') }}" class="btn btn-primary mb-3">Add Rate</a>
    </div>


<div class="table-responsive">

    <table class="table table-bordered text-center">
        <thead class="table-primary" >
            <tr>
                    
                    <th rowspan="3">#</th>
                    <th rowspan="3">Date</th>

                    <th colspan="6" >HR</th>
                    <th colspan="6" >CR</th>
                    <th colspan="6" >SS</th>

                    <th rowspan="3">Action</th>
                </tr>

                <tr>
                    <th colspan="2">For All<br>(Customers)</th>
                    <th colspan="2">Marketing<br>(Other Customers)</th>
                    <th colspan="2">Special<br>(MST Credit)</th>

                    <th colspan="2">For All<br>(Customers)</th>
                    <th colspan="2">Marketing<br>(Other Customers)</th>
                    <th colspan="2">Special<br>(MST Credit)</th>

                    <th colspan="2">For All<br>(Customers)</th>
                    <th colspan="2">Marketing<br>(Other Customers)</th>
                    <th colspan="2">Special<br>(MST Credit)</th>
                    
                </tr>

                <tr>
                    

                    <th>GOL<br>Rate / KG</th>
                    <th>SQUARE<br>%AGE</th>

                    <th>GOL<br>Rate / KG</th>
                    <th>SQUARE<br>%AGE</th>

                    <th>GOL<br>Rate / KG</th>
                    <th>SQUARE<br>%AGE</th>

                    <th>SQUARE BELOW 2"<br>%AGE</th>
                    <th>SQUARE ABOVE 2"<br>%AGE</th>
                    <th>SQUARE BELOW 2"<br>%AGE</th>
                    <th>SQUARE ABOVE 2"<br>%AGE</th>
                    <th>SQUARE BELOW 2"<br>%AGE</th>
                    <th>SQUARE ABOVE 2"<br>%AGE</th>

                    <th>GOL<br>Rate / KG</th>
                    <th>SQUARE<br>Rate / KG</th>
                    <th>GOL<br>Rate / KG</th>
                    <th>SQUARE<br>Rate / KG</th>
                    <th>GOL<br>Rate / KG</th>
                    <th>SQUARE<br>Rate / KG</th>

                </tr>
        </thead>
        <tbody>
            @foreach($rates as $chq)
                <tr>
                    
                    <td></td>
                    <td>{{ date("Y-m-d" , strtotime($chq['created_at']) ) }}</td>
                    
                     <td>{{ number_format($chq->hr_gol_all, 2) }}</td>
                     <td>{{ number_format($chq->hr_sqr_all, 2) }}</td>
                     <td>{{ number_format($chq->hr_gol_marketing, 2) }}</td>
                     <td>{{ number_format($chq->hr_sqr_marketing, 2) }}</td>
                     <td>{{ number_format($chq->hr_gol_special, 2) }}</td>
                     <td>{{ number_format($chq->hr_sqr_special, 2) }}</td>


                      <td>{{ number_format($chq->cr_all1, 2) }}</td>
                     <td>{{ number_format($chq->cr_all2, 2) }}</td>
                     <td>{{ number_format($chq->cr_marketing1, 2) }}</td>
                     <td>{{ number_format($chq->cr_marketing2, 2) }}</td>
                     <td>{{ number_format($chq->cr_special1, 2) }}</td>
                     <td>{{ number_format($chq->cr_special2, 2) }}</td>


                      <td>{{ number_format($chq->ss_gol_all, 2) }}</td>
                     <td>{{ number_format($chq->ss_sqr_all, 2) }}</td>
                     <td>{{ number_format($chq->ss_gol_marketing, 2) }}</td>
                     <td>{{ number_format($chq->ss_sqr_marketing, 2) }}</td>
                     <td>{{ number_format($chq->ss_gol_special, 2) }}</td>
                     <td>{{ number_format($chq->ss_sqr_special, 2) }}</td>

                     

                    <td>
                        <a href="{{ route('rates.edit', $chq) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('rates.destroy', $chq) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Delete Rate?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>

        

    </table>
</div>


  </div>

   <!-- /.content -->

    {{ $rates->links() }}
   
@endsection

@section('jquery-code')

<script>

$(document).ready(function(){


$('.select2').select2(); 

});

</script>


@endsection  
  