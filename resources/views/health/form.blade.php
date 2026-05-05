@extends('layouts.app')

@section('title', 'Analyze Your Blood Pressure')

@section('content')
<div class="card">
    <h1>Blood Pressure<br><em style="color:#c0392b">Level Analyzer</em></h1>
    <p class="subtitle">Enter your details and we'll estimate your healthy blood pressure range.</p>

    <form action="{{ route('health.analyze') }}" method="POST" novalidate>
        @csrf

        <div class="form-grid">

            <div class="form-group full-width">
                <label for="name">Full Name</label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    placeholder="e.g. Jane Smith"
                    value="{{ old('name') }}"
                    class="{{ $errors->has('name') ? 'error' : '' }}"
                >
                @error('name')
                    <span class="error-msg">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="age">Age (years)</label>
                <input
                    type="number"
                    id="age"
                    name="age"
                    placeholder="e.g. 35"
                    value="{{ old('age') }}"
                    min="1" max="120"
                    class="{{ $errors->has('age') ? 'error' : '' }}"
                >
                @error('age')
                    <span class="error-msg">{{ $message }}</span>
                @enderror
            </div>

            <div></div>

            <div class="form-group">
                <label for="weight">Weight (kg)</label>
                <input
                    type="number"
                    id="weight"
                    name="weight"
                    placeholder="e.g. 70"
                    value="{{ old('weight') }}"
                    min="1" step="0.1"
                    class="{{ $errors->has('weight') ? 'error' : '' }}"
                >
                @error('weight')
                    <span class="error-msg">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="height">Height (cm)</label>
                <input
                    type="number"
                    id="height"
                    name="height"
                    placeholder="e.g. 170"
                    value="{{ old('height') }}"
                    min="1" step="0.1"
                    class="{{ $errors->has('height') ? 'error' : '' }}"
                >
                @error('height')
                    <span class="error-msg">{{ $message }}</span>
                @enderror
            </div>

        </div>

        <button type="submit" class="btn btn-primary">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
            Analyze Blood Pressure
        </button>

    </form>
</div>

<div style="margin-top:2rem;padding:1.25rem 1.5rem;background:#fff;border:1px solid var(--border);border-radius:var(--radius);font-size:.85rem;color:var(--muted);line-height:1.6">
    <strong style="color:var(--ink)">How it works:</strong>
    This tool uses your age and BMI to estimate the healthy blood pressure range typically
    recommended for someone with your profile, following American Heart Association guidelines.
    It does <em>not</em> measure your actual blood pressure — please use a medical device for that.
</div>
@endsection
