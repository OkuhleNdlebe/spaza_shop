@extends('layouts.app')

@section('title', 'Add New Store')

@section('content')
<div class="container mt-4">
    <h1 class="text-primary text-center">Add a New Spaza Store</h1>

    <div class="card shadow-sm mt-3">
        <div class="card-body">
            <form action="{{ route('stores.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Store Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="location" class="form-label">Location</label>
                    <input type="text" name="location" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="owner_name" class="form-label">Owner Name</label>
                    <input type="text" name="owner_name" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="contact_number" class="form-label">Contact Number</label>
                    <input type="text" name="contact_number" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-success">Save Store</button>
            </form>
        </div>
    </div>
</div>
@endsection
