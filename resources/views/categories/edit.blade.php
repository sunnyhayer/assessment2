@extends('layouts.app')

@section('title', 'Edit Category')

@section('content')
    <h1>Edit Category</h1>

    <form action="{{ route('categories.save', $category->id) }}" method="POST">
        
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Category Name</label>
            <input type="text" name="name" id="name" 
                   value="{{ old('name', $category->name) }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="content" class="form-label">Category Content</label>
            <textarea name="content" id="content" rows="4" class="form-control" required>{{ old('content', $category->content) }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Update Category</button>
        <a href="{{ route('categories.all') }}" class="btn btn-secondary">Cancel</a>
    </form>
@endsection
