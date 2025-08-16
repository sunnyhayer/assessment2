@extends('layouts.app')

@section('title', 'Create Post')

@section('content')
    <h1>Create Post</h1>

    <form action="{{ route('posts.save', $post->id ?? null) }}" method="POST">

        @csrf

        <div class="mb-3">
            <label for="title" class="form-label">Post Title</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}" required>
        </div>

        <div class="mb-3">
            <label for="content" class="form-label">Content</label>
            <textarea name="content" id="content" rows="5" class="form-control" required>{{ old('content') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="category_id" class="form-label">Category</label>
            <select name="category_id" id="category_id" class="form-select" required>
                <option value="">-- Select Category --</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Save Post</button>
        <a href="{{ route('posts.all') }}" class="btn btn-secondary">Cancel</a>
    </form>
@endsection
