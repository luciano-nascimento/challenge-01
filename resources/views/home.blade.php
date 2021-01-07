<!DOCTYPE html>

<html>
<head>
    <title>Invillia</title>
    <link rel="stylesheet" href="http://getbootstrap.com/dist/css/bootstrap.css">
</head>
<body>
<div class="container">
    <div class="panel panel-primary">
      <div class="panel-heading"><h2>XML data import</h2></div><hr>
      <div class="panel-body">
        @if (Session::get('success') && Session::get('file'))
        <div class="alert alert-success alert-block">
            {{-- <button type="button" class="close" data-dismiss="alert">×</button> --}}
            <strong>{{ Session::get('success') }}</strong>
            <strong>{{ 'File saved as: ' . Session::get('file') }}</strong>
        </div>
        {{-- <img src="uploads/{{ Session::get('file') }}"> --}}
        @endif
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <strong>Hey!</strong> Somethng went wrong.
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
                <div class="col-md-6">
                    <input type="file" name="xmlfile" class="form-control">
                </div>
                <div class="col-md-6">
                    <button type="submit" class="btn btn-success">upload</button>
                </div>
            </div>
        </form>
      </div>
    </div>
</div>
</body>

  

</html>