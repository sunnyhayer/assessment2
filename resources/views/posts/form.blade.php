@extends('layouts.app')
@section('title', isset($post) ? 'Edit Post' : 'Create Post')

@section('content')
    <h2>{{ isset($post) ? 'Edit Post' : 'Create Post' }}</h2>

    <form action="{{ route('posts.save') }}" method="POST">
        @csrf
        <input type="hidden" name="id" value="{{ $post->id ?? '' }}">

        <div class="mb-3">
            <label>Title</label>
            <input type="text" name="title" class="form-control" value="{{ old('title', $post->title ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label>Content</label>
            <textarea name="content" class="form-control" rows="5">{{ old('content', $post->content ?? '') }}</textarea>
        </div>

        <div class="mb-3">
            <label>Category</label>
            <select name="category_id" class="form-control">
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" 
                        {{ (isset($post) && $post->category_id == $category->id) ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Active</label>
            <select name="is_active" class="form-control">
                <option value="Yes" {{ (isset($post) && $post->is_active == 'Yes') ? 'selected' : '' }}>Yes</option>
                <option value="No" {{ (isset($post) && $post->is_active == 'No') ? 'selected' : '' }}>No</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">{{ isset($post) ? 'Update' : 'Save' }}</button>
    </form>
@endsection
