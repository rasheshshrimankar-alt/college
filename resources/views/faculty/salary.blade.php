@extends('layouts.dashboard')
@section('title','Salary Info')
@section('page_title','Salary Info')
@section('breadcrumb')<a href="{{ route('faculty.dashboard') }}">Dashboard</a><i class="bi bi-chevron-right"></i><span>Salary</span>@endsection
@section('sidebar')@include('faculty.partials.sidebar')@endsection
@section('content')
<div class="page-header animate-fade-down"><div><h1 class="page-title">Salary Information</h1></div></div>
<div class="row g-4">
    <div class="col-lg-4 animate-slide-up anim-delay-1">
        <div class="dashboard-card text-center">
            <div class="card-body-sc">
                <div style="width:80px;height:80px;background:var(--gradient-1);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 1rem;font-size:2rem;color:white"><i class="bi bi-currency-rupee"></i></div>
                <h2 style="font-size:2.5rem;font-weight:900;background:var(--gradient-1);-webkit-background-clip:text;-webkit-text-fill-color:transparent">₹{{ number_format($faculty->salary ?? 0) }}</h2>
                <div style="color:var(--text-muted);font-size:.875rem">Monthly Gross Salary</div>
                <hr style="border-color:var(--border);margin:1.5rem 0">
                <div class="row g-3">
                    @foreach([['Basic Pay','₹'.number_format(($faculty->salary??0)*0.6)],['HRA','₹'.number_format(($faculty->salary??0)*0.2)],['DA','₹'.number_format(($faculty->salary??0)*0.15)],['Other','₹'.number_format(($faculty->salary??0)*0.05)]] as [$label,$val])
                    <div class="col-6"><div style="background:var(--bg);border-radius:8px;padding:.75rem"><div style="font-size:.72rem;color:var(--text-muted)">{{ $label }}</div><div style="font-weight:700;font-size:.9rem">{{ $val }}</div></div></div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-8 animate-slide-up anim-delay-2">
        <div class="dashboard-card">
            <div class="card-header-sc"><h5><i class="bi bi-calendar3 me-2 text-primary-sc"></i>Salary Slip — {{ now()->format('F Y') }}</h5></div>
            <div class="card-body-sc">
                <div style="border:1px solid var(--border);border-radius:12px;padding:1.5rem">
                    <div class="d-flex justify-content-between mb-3"><div><strong>SMART CAMPUS College of Technology</strong><div style="font-size:.78rem;color:var(--text-muted)">Salary Slip for {{ now()->format('F Y') }}</div></div><span class="sc-badge badge-success">Paid</span></div>
                    <hr style="border-color:var(--border)">
                    <div class="row g-2 mb-3">
                        @foreach([['Employee Name',$faculty->user->name],['Faculty ID',$faculty->faculty_id],['Department',$faculty->department->name??'-'],['Designation',$faculty->designation],['Account No.','XXXX-XXXX-1234'],['PAN No.','XXXXX1234X']] as [$l,$v])
                        <div class="col-md-6"><div class="d-flex justify-content-between py-1" style="font-size:.83rem;border-bottom:1px dashed var(--border)"><span style="color:var(--text-muted)">{{ $l }}</span><span style="font-weight:600">{{ $v }}</span></div></div>
                        @endforeach
                    </div>
                    <div style="background:var(--gradient-1);border-radius:10px;padding:1rem;color:white;display:flex;justify-content:space-between;align-items:center">
                        <span style="font-size:.9rem">Net Salary Credited</span>
                        <strong style="font-size:1.3rem">₹{{ number_format(($faculty->salary??0)*0.9) }}</strong>
                    </div>
                    <div style="font-size:.72rem;color:var(--text-muted);margin-top:.75rem;text-align:center">This is a computer-generated salary slip. Contact HR for queries.</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
