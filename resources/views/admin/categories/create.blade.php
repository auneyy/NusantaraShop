
@extends('admin.layout.app')

@section('page-title', 'Tambah Kategori')

@section('content')
    <div class="container-fluid">

            <!-- Main content -->
                <div class="container-fluid">
    <div class="d-flex justify-content-between mb-4">
        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.categories.store') }}" method="POST">
                            @csrf
                            
                            <div class="mb-3">
                                <label for="name" class="form-label">Category Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                    id="name" name="name" value="{{ old('name') }}" required  
                                    oninput="updateSlug(this.value)">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
    <label for="slug" class="form-label">Slug</label>
    <input type="text" 
           class="form-control @error('slug') is-invalid @enderror" 
           id="slug" name="slug" 
           value="{{ old('slug') }}" readonly>
    @error('slug')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
                            
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" {{ old('is_active') ? 'checked' : 'checked' }}>
                                <label class="form-check-label" for="is_active">Active</label>
                            </div>
                            
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    function updateSlug(name) {
        let slugInput = document.getElementById("slug");
        
        // Generate slug from name
        let slug = name
            .toLowerCase()
            .replace(/[^a-z0-9\s-]/g, '') // Remove special characters
            .replace(/\s+/g, '-') // Replace spaces with hyphens
            .replace(/-+/g, '-') // Replace multiple hyphens with single hyphen
            .trim('-');
        
        slugInput.value = slug;
    }

    // Initialize slug on page load
    document.addEventListener("DOMContentLoaded", function() {
        let nameInput = document.getElementById("name");
        if (nameInput.value) {
            updateSlug(nameInput.value);
        }
    });
    </script>
    @endsection