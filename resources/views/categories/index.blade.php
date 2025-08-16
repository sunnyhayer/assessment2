@extends('layouts.app')
@section('title', 'All Categories')

@section('content')
    <div class="d-flex justify-content-between mb-3">
        <h2>All Categories</h2>
        <a href="{{ route('categories.create') }}" class="btn btn-primary">Create New Category</a>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Content</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        @forelse($categories as $category)
            <tr>
                <td>{{ $category->id }}</td>
                <td>{{ $category->name }}</td>
                <td>{{ $category->content }}</td>
                <td>
                    <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <a href="{{ route('categories.delete', $category->id) }}" class="btn btn-danger btn-sm"
                       onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
        @empty
            <tr><td colspan="4" class="text-center">No categories found.</td></tr>
        @endforelse
        </tbody>
    </table>
@endsection
