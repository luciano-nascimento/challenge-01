<!DOCTYPE html>

<html>
<head>
    <title>Invillia</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
</head>
<body>
<div class="container">
    <div class="panel panel-primary">
      <div class="py-5 text-center">
        <h2>XML Data Processor</h2>
        <p class="lead">Choose a xml file and upload it, also is possible to choose if the file will be processed asynchronously, clicking in checkbox below.</p>
      </div>
      <div class="panel-body">
        @if (Session::get('success') && Session::get('file'))
        <div class="alert alert-success alert-block">
            <strong>{{ Session::get('success') }}</strong>
            <strong>{{ 'File saved as: ' . Session::get('file') }}</strong>
        </div>
        @endif
        @if (Session::get('failed'))
        <div class="alert alert-success alert-block">
            <strong>{{ Session::get('failed') }}</strong>
        </div>
        @endif
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <strong>Hey!</strong> Somethng went wrong. :(
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('file.upload') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class='col-md-10'>
                    <div class="custom-file mb-3">
                        <input type="file" name="xmlfile" class="custom-file-input" id="customFile" >
                        <label class="custom-file-label" for="customFile">Choose file</label>
                    </div>
                </div>
                <div class='col-md-2'>
                    <div class="custom-control custom-checkbox pt-1">
                        <input type="checkbox" class="custom-control-input" name="async" id="async-box">
                        <label class="custom-control-label" for="async-box">save async</label>
                    </div>
                </div>   
            </div>
            <button type="submit" class="btn btn-primary btn-lg pl-5 pr-5">upload</button>
        </form>
      </div>
    </div>
</div>
</body>

  

</html>