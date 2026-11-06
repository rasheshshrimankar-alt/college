@extends('layouts.dashboard')
@section('title','Upload Material')
@section('page_title','Upload Study Material')
@section('breadcrumb')<a href="{{ route('faculty.dashboard') }}">Dashboard</a><i class="bi bi-chevron-right"></i><a href="{{ route('faculty.materials.index') }}">Materials</a><i class="bi bi-chevron-right"></i><span>Upload</span>@endsection
@section('sidebar')@include('faculty.partials.sidebar')@endsection

@section('content')
<div class="page-header animate-fade-down">
    <div><h1 class="page-title">Upload Study Material</h1></div>
    <a href="{{ route('faculty.materials.index') }}" class="btn-outline-sc btn-sm-sc"><i class="bi bi-arrow-left"></i> Back</a>
</div>

<div class="row justify-content-center animate-slide-up">
    <div class="col-lg-8">
        <div class="dashboard-card">
            <div class="card-header-sc"><h5><i class="bi bi-cloud-upload me-2 text-primary-sc"></i>Upload Material</h5></div>
            <div class="card-body-sc">
                <form method="POST" action="{{ route('faculty.materials.store') }}" enctype="multipart/form-data" data-validate>
                    @csrf
                    <div class="row g-3">
                        <div class="col-12">
                            <div class="sc-form-group">
                                <label class="sc-label">Title <span class="text-danger">*</span></label>
                                <input type="text" name="title" class="sc-input" value="{{ old('title') }}" required placeholder="Enter material title">
                                @error('title')<div class="form-error">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="sc-form-group">
                                <label class="sc-label">Subject <span class="text-danger">*</span></label>
                                <select name="subject_id" class="sc-select" required>
                                    <option value="">Select Subject</option>
                                    @foreach($subjects as $s)<option value="{{ $s->id }}" {{ old('subject_id')==$s->id?'selected':'' }}>{{ $s->name }}</option>@endforeach
                                </select>
                                @error('subject_id')<div class="form-error">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="sc-form-group">
                                <label class="sc-label">Material Type <span class="text-danger">*</span></label>
                                <select name="type" class="sc-select" required id="materialType" onchange="toggleFileInput(this.value)">
                                    <option value="">Select Type</option>
                                    <option value="pdf">PDF Document</option>
                                    <option value="ppt">Presentation (PPT)</option>
                                    <option value="doc">Word Document</option>
                                    <option value="video">Video</option>
                                    <option value="link">External Link</option>
                                    <option value="other">Other File</option>
                                </select>
                                @error('type')<div class="form-error">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="sc-form-group">
                                <label class="sc-label">Course</label>
                                <select name="course_id" class="sc-select">
                                    <option value="">All Courses</option>
                                    @foreach($courses as $c)<option value="{{ $c->id }}" {{ old('course_id')==$c->id?'selected':'' }}>{{ $c->name }}</option>@endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="sc-form-group">
                                <label class="sc-label">Semester</label>
                                <select name="semester" class="sc-select">
                                    @for($i=1;$i<=8;$i++)<option value="{{ $i }}" {{ old('semester')==$i?'selected':'' }}>Semester {{ $i }}</option>@endfor
                                </select>
                            </div>
                        </div>
                        <div class="col-12" id="fileInput">
                            <div class="sc-form-group">
                                <label class="sc-label">Upload File</label>
                                <input type="file" name="file" class="sc-input" accept=".pdf,.ppt,.pptx,.doc,.docx,.mp4,.zip">
                                <div style="font-size:.75rem;color:var(--text-muted);margin-top:.3rem">Accepted: PDF, PPT, DOC, MP4, ZIP (max 50MB)</div>
                            </div>
                        </div>
                        <div class="col-12" id="linkInput" style="display:none">
                            <div class="sc-form-group">
                                <label class="sc-label">External URL</label>
                                <input type="url" name="file_url" class="sc-input" placeholder="https://..." value="{{ old('file_url') }}">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="sc-form-group">
                                <label class="sc-label">Description</label>
                                <textarea name="description" class="sc-input" rows="3" placeholder="Brief description of the material...">{{ old('description') }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 d-flex gap-2">
                        <button type="submit" class="btn-primary-sc"><i class="bi bi-cloud-upload me-2"></i>Upload Material</button>
                        <a href="{{ route('faculty.materials.index') }}" class="btn-outline-sc">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
function toggleFileInput(type) {
    document.getElementById('fileInput').style.display = type === 'link' ? 'none' : 'block';
    document.getElementById('linkInput').style.display = type === 'link' ? 'block' : 'none';
}
</script>
@endpush
@endsection
