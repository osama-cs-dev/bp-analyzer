@extends('layouts.app')

@section('title', 'Your Blood Pressure Analysis')

@section('content')

@php
    $r = $userHealthData;
    $statusColor = [
        'Normal'   => '#1e7d51',
        'Elevated' => '#c07b00',
        'High'     => '#c0392b',
        'Low'      => '#1a5276',
    ][$r->status] ?? '#1a1210';

    $statusIcon = [
        'Normal'   => '✓',
        'Elevated' => '▲',
        'High'     => '⚠',
        'Low'      => '▼',
    ][$r->status] ?? '•';
@endphp

<div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:1rem;margin-bottom:1.5rem">
    <div>
        <h1>Hello, {{ $r->name }}</h1>
        <p class="subtitle">Here are your personalised blood pressure insights.</p>
    </div>
    <a href="{{ route('health.form') }}" class="btn btn-outline">← New Analysis</a>
</div>

<div class="card" style="border-top: 4px solid {{ $statusColor }};margin-bottom:1.5rem">
    <div style="display:flex;align-items:center;gap:1rem;flex-wrap:wrap">
        <div style="font-size:3rem;line-height:1">{{ $statusIcon }}</div>
        <div>
            <div style="font-size:.75rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:var(--muted)">Overall Status</div>
            <div style="font-family:'DM Serif Display',serif;font-size:2.2rem;color:{{ $statusColor }}">{{ $r->status }}</div>
        </div>
        <span class="status-badge status-{{ strtolower($r->status) }}" style="margin-left:auto">
            {{ $statusIcon }} {{ $r->status }}
        </span>
    </div>
</div>

<div class="section-head"><h2>Your Profile</h2></div>
<div class="result-grid">
    <div class="metric-card">
        <div class="metric-label">Age</div>
        <div class="metric-value">{{ $r->age }} <span class="metric-unit">yrs</span></div>
    </div>
    <div class="metric-card">
        <div class="metric-label">Weight</div>
        <div class="metric-value">{{ $r->weight }} <span class="metric-unit">kg</span></div>
    </div>
    <div class="metric-card">
        <div class="metric-label">Height</div>
        <div class="metric-value">{{ $r->height }} <span class="metric-unit">cm</span></div>
    </div>
    <div class="metric-card">
        <div class="metric-label">BMI</div>
        <div class="metric-value">{{ $r->bmi }}</div>
        <div style="font-size:.78rem;color:var(--muted);margin-top:.2rem">{{ $r->bmi_category }}</div>
    </div>
</div>

<div class="section-head"><h2>Recommended BP Range</h2></div>
<div class="bp-range">
    <div class="bp-box">
        <div class="bp-box-label">Systolic</div>
        <div class="bp-box-value">{{ $r->systolic_min }}–{{ $r->systolic_max }}</div>
        <div class="bp-box-unit">mmHg</div>
    </div>
    <div style="font-size:2rem;color:var(--muted);font-family:'DM Serif Display',serif">/</div>
    <div class="bp-box">
        <div class="bp-box-label">Diastolic</div>
        <div class="bp-box-value">{{ $r->diastolic_min }}–{{ $r->diastolic_max }}</div>
        <div class="bp-box-unit">mmHg</div>
    </div>
</div>

<div class="section-head"><h2>Recommendation</h2></div>
<div class="recommendation">
    {{ $recommendation }}
</div>

<div style="margin-top:2rem;text-align:center;font-size:.8rem;color:var(--muted)">
    Analyzed on {{ $r->created_at->format('F j, Y \a\t g:i A') }}
</div>

@endsection
