@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>{{ __('Category Details') }}</span>
                    <a href="{{ route('categories.index') }}" class="btn btn-secondary btn-sm">Back to Categories</a>
                </div>

                <div class="card-body">
                    <p><strong>Name:</strong> {{ $category->name }}</p>
                    <p><strong>Description:</strong> {{ $category->description }}</p>

                    <div class="mt-4">
                        <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-warning">Edit Category</a>
                        <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this category? This will also delete all associated expenses.')">Delete Category</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
