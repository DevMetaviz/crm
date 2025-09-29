
@extends('layout.master')
@section('title', 'test')

@section('header-css')


    <link rel='stylesheet' href='https://cdn.form.io/formiojs/formio.full.min.css'>
    <script src='https://cdn.form.io/formiojs/formio.full.min.js'></script>
    <script type='text/javascript'>
      window.onload = function() {
        //Formio.createForm(document.getElementById('formio'), 'https://examples.form.io/example');
      };
    </script>

    <link rel='stylesheet' href='https://cdn.form.io/formiojs/formio.full.min.css'>
    <script src='https://cdn.form.io/formiojs/formio.full.min.js'></script>
    <script type='text/javascript'>
      window.onload = function() {
        Formio.builder(document.getElementById('builder'), {}, {});
      };
    </script>



@endsection

@section('content-header')


    <!-- Content Header (Page header) -->
    
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>test</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
              <li class="breadcrumb-item active">test</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
  @endsection

@section('content')
    <!-- Main content -->
    
      <div class="container-fluid">

        <div class="container-fluid">
  <div class="row">
  <div class="col-sm-8">
    <h3 class="text-center text-muted">The <a href="https://github.com/formio/formio.js" target="_blank">Form Builder</a> allows you to build a <select class="form-control" id="form-select" style="display: inline-block; width: 150px;"><option value="form">Form</option><option value="wizard">Wizard</option><option value="pdf">PDF</option></select></h3>
    <div id="builder"></div>
  </div>
  <div class="col-sm-4">
    <h3 class="text-center text-muted">as JSON Schema</h3>
    <div class="card card-body bg-light jsonviewer">
      <pre id="json"></pre>
    </div>
  </div>
</div>


        <div class="row">
          <div class="col-12">
            <button onclick="set()">Click</button>
            <!-- Default box -->
                <div id='builder1'></div>

                <div id='formio'></div>
            <!-- /.card -->
          </div>
        </div>
      </div>
    
    <!-- /.content -->
@endsection

@section('jquery-code')

<script type="text/javascript">


$(document).ready(function(){


  form.on("change", function(e){
    console.log("Something changed on the form builder");
    var jsonSchema = JSON.stringify(builder.instance.schema, null, 4);

    alert(jsonSchema);
    console.log(jsonSchema);
});

});


  function set()
 {

  var as=$('.formarea ').html();
   alert(as);
}

  </script>

@endsection  