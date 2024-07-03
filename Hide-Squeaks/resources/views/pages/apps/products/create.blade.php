<x-default-layout>

    @section('title')
       Audio Management
    @endsection
    @section('breadcrumbs')
        {{ Breadcrumbs::render('product.index') }}
    @endsection
 <style>
    

        h2 {
            color: #333;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #555;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        button {
            background-color: #2ecc71;
            color: #fff;
            border: none;
            padding: 10px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #27ae60;
        }

        a {
            text-decoration: none;
            color: #3498db;
            margin-top: 10px;
            display: inline-block;
        }

        a:hover {
            text-decoration: underline;
        }

        .error {
            color: #e74c3c;
            margin-top: 10px;
        }
    </style>
    <body>
    <h2>Upload Audio</h2>

    @if ($errors->any())
        <div class="error">
            <strong>Validation errors:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('audios.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <label for="title">Title:</label>
        <input type="text" name="title" required>
        <br>
        <label for="audio_file">Audio File:</label>
        <input type="file" name="audio_file" accept="audio/*" required>
        <br>
        <button type="submit">Upload</button>
    </form>

    <a href="{{ route('audios.index') }}">Back to Audio Files</a>
</body>
   
    </x-default-layout>
