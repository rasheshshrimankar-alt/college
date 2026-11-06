@extends('layouts.public')
@section('title','Facilities')
@section('content')
<section style="padding:6rem 0 4rem;background:var(--gradient-hero);color:white;text-align:center">
<div class="container-xl"><h1 style="font-size:clamp(2rem,4vw,3rem);font-weight:900">Campus Facilities</h1><p style="opacity:.8;margin-top:.5rem">World-class infrastructure for holistic development</p></div>
</section>
<section style="padding:5rem 0">
<div class="container-xl">
<div class="row g-4">
@foreach([
['bi-pc-display','Computer Labs','12 advanced computer labs with 500+ high-performance workstations, GPU clusters, and 24/7 internet access.','var(--primary)'],
['bi-journals','Central Library','200,000+ books, journals, e-resources, and digital databases. Wi-Fi enabled reading rooms open 6 AM to 10 PM.','var(--secondary)'],
['bi-house-door','Student Hostels','Separate hostels for boys and girls with 2000+ capacity, mess, gym, and Wi-Fi. Fully air-conditioned.','var(--success)'],
['bi-trophy','Sports Complex','Olympic-size swimming pool, cricket ground, football field, basketball, badminton, and indoor sports arena.','var(--warning)'],
['bi-bandaid','Medical Center','24-hour health center with qualified doctors, nurses, and ambulance. Mental health counseling available.','var(--danger)'],
['bi-bus-front','Transport','100+ buses covering 50+ routes across the city. GPS-tracked, air-conditioned student transport.','var(--accent)'],
['bi-cup-hot','Cafeteria','Multi-cuisine food courts, canteens, and cafeterias. Hygienic kitchens with nutritious meals at subsidized rates.','var(--primary)'],
['bi-wifi','Wi-Fi Campus','1 Gbps campus-wide Wi-Fi network covering all buildings, hostels, and outdoor areas.','var(--secondary)'],
['bi-camera-video','Auditorium','3000-seat main auditorium and multiple seminar halls equipped with modern AV systems.','var(--success)'],
] as [$icon,$title,$desc,$color])
<div class="col-md-6 col-lg-4">
<div class="sc-card" style="padding:2rem;height:100%;transition:all .3s" onmouseover="this.style.transform='translateY(-6px)';this.style.boxShadow='var(--shadow-lg)'" onmouseout="this.style.transform='translateY(0)';this.style.boxShadow=''">
<div style="width:60px;height:60px;background:{{ $color }}15;border-radius:16px;display:flex;align-items:center;justify-content:center;font-size:1.6rem;color:{{ $color }};margin-bottom:1.25rem"><i class="bi {{ $icon }}"></i></div>
<h5 style="font-weight:700;margin-bottom:.75rem">{{ $title }}</h5>
<p style="font-size:.85rem;color:var(--text-muted);line-height:1.7;margin:0">{{ $desc }}</p>
</div>
</div>
@endforeach
</div>
</div>
</section>
@endsection
