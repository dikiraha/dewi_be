@extends('website.layouts.main', ['title' => 'Edit User'])

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="d-flex justify-content-between">
                        <h5 class="card-header">Edit User</h5>
                        <a href="{{ route('website.user.list') }}" class="btn btn-primary" style="margin: 1.25rem;">List</a>
                    </div>
                    <div class="card-body demo-vertical-spacing demo-only-element">
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Ooops..</strong>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                        <form method="post" action="{{ route('website.user.update', $user->uuid) }}" id="myForm"
                            class="needs-validation" novalidate>
                            @csrf

                            <div class="form-floating form-floating-outline mb-4">
                                <input type="text" class="form-control" id="nik" name="nik"
                                    value="{{ old('nik', $user->nik) }}" placeholder="000000" required autofocus
                                    maxlength="6" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                                <label for="nik">NIK <span class="text-danger">*</span></label>
                                <div class="invalid-feedback">Harap isi NIK</div>
                            </div>

                            <div class="form-floating form-floating-outline mb-4">
                                <input type="text" class="form-control" id="name" name="name"
                                    value="{{ old('name', $user->name) }}" placeholder="Nama Lengkap"
                                    onkeyup="formatFullName(this)" required>
                                <label for="name">Name <span class="text-danger">*</span></label>
                                <div class="invalid-feedback">Harap isi Name</div>
                            </div>

                            <div class="form-floating form-floating-outline mb-4">
                                <input type="email" class="form-control" id="email" name="email"
                                    value="{{ old('email', $user->email) }}" placeholder="email@mail.com" required>
                                <label for="email">Email <span class="text-danger">*</span></label>
                                <div class="invalid-feedback">Harap isi Email</div>
                            </div>

                            <div class="form-floating form-floating-outline mb-4">
                                <input type="text" class="form-control" id="phone" name="phone"
                                    value="{{ old('phone', $user->phone) }}" placeholder="081234567890" required
                                    maxlength="15" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                                <label for="phone">Phone Number <span class="text-danger">*</span></label>
                                <div class="invalid-feedback">Harap isi Phone Number</div>
                            </div>

                            <div class="form-floating form-floating-outline mb-4">
                                <select class="form-select form-control" id="department" name="department[]"
                                    aria-label="Select" required multiple>
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->id }}"
                                            {{ collect(old('department', $user->departments->pluck('id')))->contains($department->id) ? 'selected' : '' }}>
                                            {{ $department->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <label for="department">Department <span class="text-danger">*</span></label>
                                <div class="invalid-feedback">Harap isi Department</div>
                            </div>

                            <div class="form-floating form-floating-outline mb-4">
                                <select class="form-select form-control" id="role" name="role" aria-label="Select"
                                    required>
                                    <option value="">-- Select --</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}"
                                            {{ old('role', $user->roles->first()->id ?? '') == $role->id ? 'selected' : '' }}>
                                            {{ $role->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <label for="role">Role <span class="text-danger">*</span></label>
                                <div class="invalid-feedback">Harap isi Role</div>
                            </div>

                            <div class="form-floating form-floating-outline mb-4">
                                <input type="password" class="form-control" id="password" name="password"
                                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;">
                                <label for="password">Password</label>
                                <div class="invalid-feedback">Harap isi Password jika ingin mengganti</div>
                                <small class="text-muted">Kosongkan jika tidak ingin mengubah password</small>
                            </div>

                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-success" id="submitButton">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link href="{{ asset('vendor/select2/select2.min.css') }}" rel="stylesheet" />
@endpush

@push('scripts')
    <script src="{{ asset('vendor/select2/select2.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#department').select2({
                // maximumSelectionLength: 3,
                // placeholder: '-- Select --',
                allowClear: true,
                // theme: 'bootstrap5'
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var form = document.getElementById('myForm');
            var submitButton = document.getElementById('submitButton');

            form.addEventListener('submit', function(event) {
                if (!form.checkValidity()) {
                    form.classList.add('was-validated');
                    event.preventDefault();
                } else {
                    submitButton.setAttribute('disabled', 'true');
                    submitButton.innerHTML = 'Submitting...';
                }
            });

            form.addEventListener('input', function() {
                if (form.checkValidity()) {
                    submitButton.removeAttribute('disabled');
                    submitButton.innerHTML = 'Submit';
                }
            });
        });
    </script>
    <script>
        function formatFullName(element) {
            let words = element.value.toLowerCase().split(" ");
            for (let i = 0; i < words.length; i++) {
                words[i] = words[i].charAt(0).toUpperCase() + words[i].slice(1);
            }
            element.value = words.join(" ");
        }
    </script>
@endpush
