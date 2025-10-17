@extends('layouts.app')

@section('title', 'Add Manufacturer')

@section('content')
<div class="container mt-4">
    <h1 class="text-primary text-center">Add a Manufacturer</h1>
    <div class="card shadow-sm mt-3">
        <div class="card-body">
            <form action="{{ route('manufacturers.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Manufacturer Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="contact_email" class="form-label">Contact Email</label>
                    <input type="email" name="contact_email" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="website" class="form-label">Website</label>
                    <input type="url" name="website" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="address" class="form-label">Address</label>
                    <textarea name="address" class="form-control" rows="2"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Save Manufacturer</button>
                <a href="{{ route('manufacturers.index') }}" class="btn btn-secondary ms-2">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection