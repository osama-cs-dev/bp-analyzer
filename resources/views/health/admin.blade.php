@extends('layouts.app')

@section('title', 'Admin — All Submissions')

@section('content')

<div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:1rem;margin-bottom:1.5rem">
    <div>
        <h1>Admin Dashboard</h1>
        <p class="subtitle">All {{ $records->total() }} submission{{ $records->total() !== 1 ? 's' : '' }} — most recent first.</p>
    </div>
    <a href="{{ route('health.form') }}" class="btn btn-outline">← New Analysis</a>
</div>

<div class="card">
    @if($records->isEmpty())
        <p style="color:var(--muted);text-align:center;padding:2rem 0">No submissions yet.</p>
    @else
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Age</th>
                        <th>Weight</th>
                        <th>Height</th>
                        <th>BMI</th>
                        <th>Systolic</th>
                        <th>Diastolic</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($records as $r)
                    <tr>
                        <td style="color:var(--muted)">{{ $r->id }}</td>
                        <td><strong>{{ $r->name }}</strong></td>
                        <td>{{ $r->age }}</td>
                        <td>{{ $r->weight }} kg</td>
                        <td>{{ $r->height }} cm</td>
                        <td>
                            {{ $r->bmi }}
                            <span style="font-size:.75rem;color:var(--muted)">{{ $r->bmi_category }}</span>
                        </td>
                        <td>{{ $r->systolic_min }}–{{ $r->systolic_max }}</td>
                        <td>{{ $r->diastolic_min }}–{{ $r->diastolic_max }}</td>
                        <td>
                            <span class="status-badge status-{{ strtolower($r->status) }}">
                                {{ $r->status }}
                            </span>
                        </td>
                        <td style="white-space:nowrap;color:var(--muted)">
                            {{ $r->created_at->format('d M Y') }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if($records->hasPages())
        <div style="display:flex;gap:.5rem;justify-content:center;margin-top:2rem;flex-wrap:wrap">
            @if($records->onFirstPage())
                <span style="opacity:.4;padding:.5rem .75rem;border:1px solid var(--border);border-radius:8px">&laquo;</span>
            @else
                <a href="{{ $records->previousPageUrl() }}" style="padding:.5rem .75rem;border:1px solid var(--border);border-radius:8px;text-decoration:none;color:var(--ink)">&laquo;</a>
            @endif

            @foreach($records->getUrlRange(1, $records->lastPage()) as $page => $url)
                @if($page == $records->currentPage())
                    <span style="padding:.5rem .75rem;border:1px solid var(--ink);border-radius:8px;background:var(--ink);color:var(--cream)">{{ $page }}</span>
                @else
                    <a href="{{ $url }}" style="padding:.5rem .75rem;border:1px solid var(--border);border-radius:8px;text-decoration:none;color:var(--ink)">{{ $page }}</a>
                @endif
            @endforeach

            @if($records->hasMorePages())
                <a href="{{ $records->nextPageUrl() }}" style="padding:.5rem .75rem;border:1px solid var(--border);border-radius:8px;text-decoration:none;color:var(--ink)">&raquo;</a>
            @else
                <span style="opacity:.4;padding:.5rem .75rem;border:1px solid var(--border);border-radius:8px">&raquo;</span>
            @endif
        </div>
        @endif
    @endif
</div>

@if(!$records->isEmpty())
<div class="result-grid" style="margin-top:1.5rem">
    @php $counts = \App\Models\UserHealthData::all()->groupBy('status')->map->count(); @endphp
    @foreach(['Normal'=>'normal','Elevated'=>'elevated','High'=>'high','Low'=>'low'] as $label => $cls)
    <div class="metric-card">
        <div class="metric-label">{{ $label }}</div>
        <div class="metric-value">{{ $counts[$label] ?? 0 }}</div>
        <span class="status-badge status-{{ $cls }}" style="margin-top:.4rem;font-size:.72rem">{{ $label }}</span>
    </div>
    @endforeach
</div>
@endif

@endsection
