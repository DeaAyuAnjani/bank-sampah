<form action="{{ route('admin.jenis-sampah.update', $category->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="mb-4">
        <label class="block font-medium mb-1">Nama Sampah</label>
        <input type="text" name="name" value="{{ old('name', $category->name) }}"
               class="w-full border rounded p-2" required>
        @error('name')
            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div class="mb-4">
        <label class="block font-medium mb-1">Deskripsi</label>
        <textarea name="description" class="w-full border rounded p-2" rows="3">{{ old('description', $category->description) }}</textarea>
    </div>

    <div class="mb-4">
        <label class="block font-medium mb-1">Foto Jenis Sampah</label>
        @if($category->image)
            <img src="{{ Storage::url($category->image) }}" class="w-32 h-32 object-cover rounded mb-2">
        @endif
        <input type="file" name="image" accept="image/*" class="w-full border rounded p-2">
        @error('image')
            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div class="flex gap-2">
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Update
        </button>
        <a href="{{ route('admin.jenis-sampah.index') }}"
           class="bg-gray-300 px-4 py-2 rounded hover:bg-gray-400">
            Batal
        </a>
    </div>
</form>