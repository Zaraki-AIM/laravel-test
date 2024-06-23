<!DOCTYPE html>
<html>

<head>
    <title>Create Content</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        .container {
            margin-top: 20px;
        }

        label {
            margin-right: 10px;
        }

        .btn-primary,
        .btn-secondary {
            margin: 5px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Add New Content</h2>

        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <strong>Success!</strong> {{ $message }}
            </div>
        @endif

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

        <form action="{{ route('contents.store') }}" method="POST" enctype="multipart/form-data" class="mb-3">
            @csrf
            <div class="form-group">
                <label><strong>Title:</strong></label>
                <input type="text" class="form-control" name="title" value="{{ old('title') }}">
            </div>
            <div class="form-group">
                <label><strong>Status:</strong></label>
                <input type="number" class="form-control" name="status" value="{{ old('status', 0) }}">
            </div>
            <div class="form-group">
                <label><strong>Grade:</strong></label>
                <div>
                    <label><input type="checkbox" name="grade[]" value="Grade1"> Grade1</label>
                    <label><input type="checkbox" name="grade[]" value="Grade2"> Grade2</label>
                    <label><input type="checkbox" name="grade[]" value="Grade3"> Grade3</label>
                </div>
            </div>
            <div class="form-group">
                <label><strong>Image:</strong></label>
                <input type="file" class="form-control-file" name="image" id="image"
                    onchange="previewImage(event)">
                <br>
                <img id="preview" src="" alt="Image Preview" style="max-width: 200px; margin-top: 10px;">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>

        <a href="{{ route('contents.index') }}" class="btn btn-secondary">一覧に戻る</a>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script>
        function previewImage(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var output = document.getElementById('preview');
                output.src = reader.result;
            }
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
</body>

</html>
