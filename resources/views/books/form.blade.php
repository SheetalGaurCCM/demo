
<form action="{{ $formAction }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if(isset($book))
        @method('PUT')
    @endif
    <label for="image">Image</label>
    @error('image')
    <div class="text-danger">{{ $message }}</div>
    @enderror
    <input type="file" name="image" id="image">
    <br>
    <label for="title">Title</label>
    <input type="text" name="title" id="title" value="{{ old('title', isset($book) ? $book->title : '') }}" >
    @error('title')
    <div class="text-danger">{{ $message }}</div>
    @enderror
    <br>
    <label for="author_name">Author</label>
    <input type="text" name="author_name" id="author_name" value="{{ old('author_name', isset($book) ? $book->author_name : '') }}" >
    @error('author_name')
    <div class="text-danger">{{ $message }}</div>
    @enderror
    <br>
    <label for="description">Description</label>
    
    <textarea name="description" id="description" required>{{ old('description', isset($book) ? $book->description : '') }}</textarea>
    @error('description')
    <div class="text-danger">{{ $message }}</div>
    @enderror
    <br>
    <label for="price">Price</label>
    <input type="number" name="price" id="price" value="{{ old('price', isset($book) ? $book->price : '') }}" >
    @error('price')
    <div class="text-danger">{{ $message }}</div>
    @enderror
    <br>
    <label for="category_name">Category</label>
    <select name="category_name[]" id="category_name" multiple >
        @foreach ($categories as $category)
            <option value="{{ $category->id }}"{{ in_array($category->id, old('category_name', isset($book) ? $book->categories->pluck('id')->toArray() : [])) ? ' selected' : '' }}>
            {{ $category->name }}
            </option>
        @endforeach
    </select>
    @error('category_name')
    <div class="text-danger">{{ $message }}</div>
    @enderror
            <br>
            <button type="submit" class="btn" style="background-color:green; color:white">
            {{ isset($book) ? 'Update' : 'Create' }} Book
        </button>
</form>
