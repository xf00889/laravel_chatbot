<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="icon" type="image/jpeg" href="{{ asset('images/opengen.jpg') }}">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .avatar-preview {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            overflow: hidden;
            margin: 0 auto 20px;
            border: 3px solid #007bff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .avatar-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }
        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card">
                    <div class="card-body p-4">
                        <h2 class="text-center mb-4">
                            <i class="fas fa-user-edit text-primary me-2"></i>Edit Profile
                        </h2>

                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="text-center mb-4">
                                <div class="avatar-preview">
                                    <img src="{{ auth()->user()->avatar 
                                        ? '/images/' . auth()->user()->avatar 
                                        : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) }}" 
                                         id="avatar-preview-img" 
                                         alt="Profile Picture">
                                </div>
                                <div class="mb-3">
                                    <label for="avatar" class="form-label">
                                        <i class="fas fa-camera me-2"></i>Choose Profile Picture
                                    </label>
                                    <input type="file" 
                                           class="form-control @error('avatar') is-invalid @enderror" 
                                           id="avatar" 
                                           name="avatar" 
                                           accept="image/*"
                                           onchange="validateFileSize(this); previewImage(this);">
                                    @error('avatar')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <small class="text-muted">Maximum file size: 2MB</small>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="name" class="form-label">
                                    <i class="fas fa-user me-2"></i>Name
                                </label>
                                <input type="text" 
                                       class="form-control" 
                                       id="name" 
                                       name="name" 
                                       value="{{ auth()->user()->name }}" 
                                       required>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Update Profile
                                </button>
                                <a href="{{ route('chat.index') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-arrow-left me-2"></i>Back to Chat
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function previewImage(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('avatar-preview-img').src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        function validateFileSize(input) {
            if (input.files && input.files[0]) {
                const maxSize = 2 * 1024 * 1024; // 2MB in bytes
                if (input.files[0].size > maxSize) {
                    alert('Error: File size exceeds 2MB limit');
                    input.value = ''; // Clear the input
                    return false;
                }
            }
            return true;
        }
    </script>
</body>
</html> 