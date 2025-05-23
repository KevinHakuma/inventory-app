<form action="{{ route('laptops.import') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="file" name="file_excel" required>
    <button type="submit">Import</button>
</form>

@if(session('success'))
    <div>{{ session('success') }}</div>
@endif
