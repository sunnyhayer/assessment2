@extends('layouts.app')
@section('title', 'All Posts')

@section('content')
    <div class="d-flex justify-content-between mb-3">
        <h2>All Posts</h2>
        <a href="{{ route('posts.create') }}" class="btn btn-primary">Create New Post</a>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Category</th>
                <th>Active</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        @forelse($posts as $post)
            <tr>
                <td>{{ $post->id }}</td>
                <td>{{ $post->title }}</td>
                <td>{{ $post->category->name ?? 'No Category' }}</td>
                <td>{{ $post->is_active }}</td>
                <td>
                    <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <a href="{{ route('posts.delete', $post->id) }}" class="btn btn-danger btn-sm"
                       onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
        @empty
            <tr><td colspan="5" class="text-center">No posts found.</td></tr>
        @endforelse
        </tbody>
    </table>
@endsection
