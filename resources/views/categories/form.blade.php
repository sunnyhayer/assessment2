@extends('layouts.app')
@section('title', isset($category) ? 'Edit Category' : 'Create Category')

@section('content')
    <h2>{{ isset($category) ? 'Edit Category' : 'Create Category' }}</h2>

    <form action="{{ route('categories.save') }}" method="POST">
        @csrf
        <input type="hidden" name="id" value="{{ $category->id ?? '' }}">

        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" 
                   value="{{ old('name', $category->name ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label>Content</label>
            <textarea name="content" class="form-control" rows="5">{{ old('content', $category->content ?? '') }}</textarea>
        </div>

        <button type="submit" class="btn btn-success">{{ isset($category) ? 'Update' : 'Save' }}</button>
    </form>
@endsection
