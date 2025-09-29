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
@if ($errors->any())
    <div class="alert alert-danger">
        <strong>Whoops!</strong> There were some problems with your input.<br><br>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<div class="container">
    <h3>{{ isset($rate) ? 'Edit Daily Rate' : 'Add New Daily Rate' }}</h3>

    <form action="{{ isset($rate) ? route('rates.update', $rate->id) : route('rates.store') }}" method="POST">
        @csrf
        @if(isset($rate))
            @method('PUT')
        @endif


        <table class="table table-bordered text-center">

            <thead>
                <tr>
                    <th rowspan="3"></th>
                    <th colspan="2" >HR</th>
                    <th colspan="2" >CR</th>
                    <th colspan="2" >SS</th>
                </tr>

                <tr>
                    <th>GOL</th>
                    <th>SQUARE</th>
                    <th>SQUARE BELOW 2"</th>
                    <th>SQUARE ABOVE 2"</th>
                    <th>GOL</th>
                    <th>SQUARE</th>
                </tr>

                <tr>
                    <th>Rate / KG</th>
                    <th>%AGE</th>
                    <th>%AGE</th>
                    <th>%AGE</th>
                    <th>Rate / KG</th>
                    <th>Rate / KG</th>
                </tr>
            </thead>

            <tbody>

               <tr>
                <th>Marketing (Other Customers)</th>
                <td>
                <input type="number" step="any" name="hr_gol_marketing" class="form-control" value="{{ $rate->hr_gol_marketing ?? old('hr_gol_marketing') }}" required>
                @error('hr_gol_marketing')
                <small class="text-danger">{{ $message }}</small>
                 @enderror
                </td>
                <td>
                <input type="number" step="any" name="hr_sqr_marketing" class="form-control" value="{{ $rate->hr_sqr_marketing ?? old('hr_sqr_marketing') }}" required>
                @error('hr_sqr_marketing')
                <small class="text-danger">{{ $message }}</small>
                 @enderror
                </td>
                <td>
                    <input type="number" step="any" name="cr_marketing1" class="form-control" value="{{ $rate->cr_marketing1 ?? old('cr_marketing1') }}" required>
                @error('cr_marketing1')
                <small class="text-danger">{{ $message }}</small>
                 @enderror
                </td>
                <td>
                    <input type="number" step="any" name="cr_marketing2" class="form-control" value="{{ $rate->cr_marketing2 ?? old('cr_marketing2') }}" required>
                @error('cr_marketing2')
                <small class="text-danger">{{ $message }}</small>
                 @enderror
                </td>
                <td>
                    <input type="number" step="any" name="ss_gol_marketing" class="form-control" value="{{ $rate->ss_gol_marketing ?? old('ss_gol_marketing') }}" required>
                @error('ss_gol_marketing')
                <small class="text-danger">{{ $message }}</small>
                 @enderror
                </td>
                <td>
                    <input type="number" step="any" name="ss_sqr_marketing" class="form-control" value="{{ $rate->ss_sqr_marketing ?? old('ss_sqr_marketing') }}" required>
                @error('ss_sqr_marketing')
                <small class="text-danger">{{ $message }}</small>
                 @enderror
                </td>
               </tr>


               <tr>
                <th>For All (Customers)</th>
                <td>
                <input type="number" step="any" name="hr_gol_all" class="form-control" value="{{ $rate->hr_gol_all ?? old('hr_gol_all') }}" required>
                @error('hr_gol_all')
                <small class="text-danger">{{ $message }}</small>
                 @enderror
                </td>
                <td>
                <input type="number" step="any" name="hr_sqr_all" class="form-control" value="{{ $rate->hr_sqr_all ?? old('hr_sqr_all') }}" required>
                @error('hr_sqr_all')
                <small class="text-danger">{{ $message }}</small>
                 @enderror
                </td>
                <td>
                    <input type="number" step="any" name="cr_all1" class="form-control" value="{{ $rate->cr_all1 ?? old('cr_all1') }}" required>
                @error('cr_all1')
                <small class="text-danger">{{ $message }}</small>
                 @enderror
                </td>
                <td>
                    <input type="number" step="any" name="cr_all2" class="form-control" value="{{ $rate->cr_all2 ?? old('cr_all2') }}" required>
                @error('cr_all2')
                <small class="text-danger">{{ $message }}</small>
                 @enderror
                </td>
                <td>
                    <input type="number" step="any" name="ss_gol_all" class="form-control" value="{{ $rate->ss_gol_all ?? old('ss_gol_all') }}" required>
                @error('ss_gol_all')
                <small class="text-danger">{{ $message }}</small>
                 @enderror
                </td>
                <td>
                    <input type="number" step="any" name="ss_sqr_all" class="form-control" value="{{ $rate->ss_sqr_all ?? old('ss_sqr_all') }}" required>
                @error('ss_sqr_all')
                <small class="text-danger">{{ $message }}</small>
                 @enderror
                </td>
               </tr>


               <tr>
                <th>Special (MST Credit)</th>
                <td>
                <input type="number" step="any" name="hr_gol_special" class="form-control" value="{{ $rate->hr_gol_special ?? old('hr_gol_special') }}" required>
                @error('hr_gol_special')
                <small class="text-danger">{{ $message }}</small>
                 @enderror
                </td>
                <td>
                <input type="number" step="any" name="hr_sqr_special" class="form-control" value="{{ $rate->hr_sqr_special ?? old('hr_sqr_special') }}" required>
                @error('hr_sqr_special')
                <small class="text-danger">{{ $message }}</small>
                 @enderror
                </td>
                <td>
                    <input type="number" step="any" name="cr_special1" class="form-control" value="{{ $rate->cr_special1 ?? old('cr_special1') }}" required>
                @error('cr_special1')
                <small class="text-danger">{{ $message }}</small>
                 @enderror
                </td>
                <td>
                    <input type="number" step="any" name="cr_special2" class="form-control" value="{{ $rate->cr_special2 ?? old('cr_special2') }}" required>
                @error('cr_special2')
                <small class="text-danger">{{ $message }}</small>
                 @enderror
                </td>
                <td>
                    <input type="number" step="any" name="ss_gol_special" class="form-control" value="{{ $rate->ss_gol_special ?? old('ss_gol_special') }}" required>
                @error('ss_gol_special')
                <small class="text-danger">{{ $message }}</small>
                 @enderror
                </td>
                <td>
                    <input type="number" step="any" name="ss_sqr_special" class="form-control" value="{{ $rate->ss_sqr_special ?? old('ss_sqr_special') }}" required>
                @error('ss_sqr_special')
                <small class="text-danger">{{ $message }}</small>
                 @enderror
                </td>
               </tr>

            </tbody>

        </table>

       

       

        <button type="submit" class="btn btn-{{ isset($rate) ? 'primary' : 'success' }}">
            {{ isset($rate) ? 'Update Rate' : 'Save Rate' }}
        </button>
    </form>
</div>
@endsection
@section('jquery-code')

<script>

$(document).ready(function(){


$('.select2').select2(); 

});

 $(document).on('input change', 'input[name="hr_gol_marketing"]', function () {
    let val = $(this).val();
     $('input[name="hr_gol_all"]').val(val);
     $('input[name="hr_gol_special"]').val(val);
});

 $(document).on('input change', 'input[name="hr_sqr_marketing"]', function () {
    let val = $(this).val();
     $('input[name="hr_sqr_all"]').val(val);
     $('input[name="hr_sqr_special"]').val(val);
});

 $(document).on('input change', 'input[name="cr_marketing1"]', function () {
    let val = $(this).val();
     $('input[name="cr_all1"]').val(val);
     $('input[name="cr_special1"]').val(val);
});

 $(document).on('input change', 'input[name="cr_marketing2"]', function () {
    let val = $(this).val();
     $('input[name="cr_all2"]').val(val);
     $('input[name="cr_special2"]').val(val);
});

 $(document).on('input change', 'input[name="ss_gol_marketing"]', function () {
    let val = $(this).val();
     $('input[name="ss_gol_all"]').val(val);
     $('input[name="ss_gol_special"]').val(val);
});

 $(document).on('input change', 'input[name="ss_sqr_marketing"]', function () {
    let val = $(this).val();
     $('input[name="ss_sqr_all"]').val(val);
     $('input[name="ss_sqr_special"]').val(val);
});

</script>


@endsection  


