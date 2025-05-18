@extends('website.layouts.main', ['title' => 'Edit Department'])

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="d-flex justify-content-between">
                        <h5 class="card-header">Edit Department</h5>
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
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        <form method="post"
                            action="{{ route('website.department.update', ['uuid' => $department->uuid]) }}"
                            class="needs-validation" id="myForm" novalidate>
                            @csrf
                            <div class="form-floating form-floating-outline mb-4">
                                <input type="text" class="form-control" id="code" name="code"
                                    value="{{ old('code', $department->code) }}" placeholder="ITD" maxlength="10" required
                                    autofocus>
                                <label for="code">Code <span class="text-danger">*</span></label>
                                <div class="invalid-feedback">Harap isi Code</div>
                            </div>
                            <div class="form-floating form-floating-outline mb-4">
                                <input type="text" class="form-control" id="name" name="name"
                                    value="{{ old('name', $department->name) }}"
                                    placeholder="Information Technology Development" required>
                                <label for="name">Name <span class="text-danger">*</span></label>
                                <div class="invalid-feedback">Harap isi Name</div>
                            </div>
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('website.department.list') }}" class="btn btn-secondary">Back</a>
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
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const codeInput = document.getElementById('code');

            codeInput.addEventListener('input', function() {
                this.value = this.value.toUpperCase();
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
@endpush
