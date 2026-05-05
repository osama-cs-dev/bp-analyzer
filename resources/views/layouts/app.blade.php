<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Blood Pressure Analyzer')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --cream:    #f7f3ee;
            --ink:      #1a1210;
            --muted:    #7a6f6a;
            --red:      #c0392b;
            --red-pale: #fce8e6;
            --green:    #1e7d51;
            --green-pale:#e6f4ed;
            --amber:    #c07b00;
            --amber-pale:#fef3d8;
            --blue:     #1a5276;
            --blue-pale:#d6eaf8;
            --border:   #e0d8d0;
            --card:     #ffffff;
            --radius:   14px;
            --shadow:   0 4px 24px rgba(26,18,16,.08);
        }
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--cream);
            color: var(--ink);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        nav {
            background: var(--ink);
            padding: 1rem 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .nav-brand {
            font-family: 'DM Serif Display', serif;
            font-size: 1.25rem;
            color: var(--cream);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: .5rem;
        }
        .nav-brand svg { width: 24px; height: 24px; fill: #e74c3c; }
        .nav-links a {
            color: #bbb;
            text-decoration: none;
            font-size: .875rem;
            font-weight: 500;
            margin-left: 1.5rem;
            transition: color .2s;
        }
        .nav-links a:hover { color: var(--cream); }
        main {
            flex: 1;
            padding: 3rem 1.5rem;
            max-width: 900px;
            width: 100%;
            margin: 0 auto;
        }
        .card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 2.5rem;
            box-shadow: var(--shadow);
        }
        h1, h2, h3 { font-family: 'DM Serif Display', serif; line-height: 1.2; }
        h1 { font-size: 2rem; }
        h2 { font-size: 1.5rem; }
        .subtitle { color: var(--muted); margin-top: .4rem; font-size: .95rem; }
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.25rem;
            margin-top: 2rem;
        }
        .form-group { display: flex; flex-direction: column; gap: .4rem; }
        .form-group.full-width { grid-column: 1 / -1; }
        label {
            font-size: .8rem;
            font-weight: 600;
            letter-spacing: .06em;
            text-transform: uppercase;
            color: var(--muted);
        }
        input {
            border: 1.5px solid var(--border);
            border-radius: 8px;
            padding: .7rem 1rem;
            font-size: 1rem;
            font-family: inherit;
            background: var(--cream);
            color: var(--ink);
            transition: border-color .2s, box-shadow .2s;
            outline: none;
        }
        input:focus { border-color: var(--red); box-shadow: 0 0 0 3px var(--red-pale); }
        input.error { border-color: var(--red); }
        .error-msg { font-size: .78rem; color: var(--red); margin-top: .2rem; }
        .btn {
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            padding: .85rem 2rem;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-family: inherit;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: transform .15s, box-shadow .15s;
        }
        .btn:hover { transform: translateY(-1px); box-shadow: 0 6px 18px rgba(0,0,0,.12); }
        .btn-primary { background: var(--ink); color: var(--cream); margin-top: 1.75rem; }
        .btn-outline {
            background: transparent;
            color: var(--ink);
            border: 1.5px solid var(--border);
            padding: .65rem 1.25rem;
            font-size: .875rem;
        }
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            padding: .35rem .9rem;
            border-radius: 100px;
            font-size: .82rem;
            font-weight: 600;
        }
        .status-normal   { background: var(--green-pale); color: var(--green); }
        .status-elevated { background: var(--amber-pale); color: var(--amber); }
        .status-high     { background: var(--red-pale);   color: var(--red); }
        .status-low      { background: var(--blue-pale);  color: var(--blue); }
        .result-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
            gap: 1rem;
            margin: 1.5rem 0;
        }
        .metric-card {
            background: var(--cream);
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 1.1rem 1.25rem;
        }
        .metric-label {
            font-size: .75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .07em;
            color: var(--muted);
            margin-bottom: .3rem;
        }
        .metric-value { font-family: 'DM Serif Display', serif; font-size: 1.5rem; color: var(--ink); }
        .metric-unit { font-size: .8rem; color: var(--muted); font-family: 'DM Sans', sans-serif; }
        .bp-range { display: flex; align-items: center; gap: 1.5rem; flex-wrap: wrap; margin: 1.5rem 0; }
        .bp-box {
            flex: 1;
            min-width: 140px;
            background: var(--ink);
            color: var(--cream);
            border-radius: 12px;
            padding: 1.5rem;
            text-align: center;
        }
        .bp-box-label { font-size: .75rem; letter-spacing: .08em; text-transform: uppercase; opacity: .6; }
        .bp-box-value { font-family: 'DM Serif Display', serif; font-size: 2.2rem; margin: .2rem 0; }
        .bp-box-unit { font-size: .75rem; opacity: .5; }
        .recommendation {
            background: var(--cream);
            border-left: 4px solid var(--red);
            border-radius: 0 10px 10px 0;
            padding: 1.1rem 1.5rem;
            font-size: .93rem;
            line-height: 1.6;
            margin-top: 1.5rem;
        }
        .table-wrap { overflow-x: auto; margin-top: 1.5rem; }
        table { width: 100%; border-collapse: collapse; font-size: .875rem; }
        thead th {
            text-align: left;
            font-size: .72rem;
            font-weight: 700;
            letter-spacing: .08em;
            text-transform: uppercase;
            color: var(--muted);
            padding: .6rem 1rem;
            border-bottom: 2px solid var(--border);
        }
        tbody td { padding: .8rem 1rem; border-bottom: 1px solid var(--border); }
        tbody tr:hover { background: var(--cream); }
        tbody tr:last-child td { border-bottom: none; }
        .section-head {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin: 2rem 0 1rem;
        }
        .section-head h2 { flex-shrink: 0; }
        .section-head::after { content: ''; flex: 1; height: 1px; background: var(--border); }
        footer {
            text-align: center;
            padding: 1.5rem;
            font-size: .8rem;
            color: var(--muted);
            border-top: 1px solid var(--border);
        }
        @media (max-width: 600px) {
            .form-grid { grid-template-columns: 1fr; }
            main { padding: 1.5rem 1rem; }
            .card { padding: 1.5rem; }
            h1 { font-size: 1.6rem; }
        }
    </style>
</head>
<body>
<nav>
    <a href="{{ route('health.form') }}" class="nav-brand">
        <svg viewBox="0 0 24 24"><path d="M12 21.593c-5.63-5.539-11-10.297-11-14.402 0-3.791 3.068-5.191 5.281-5.191 1.312 0 4.151.501 5.719 4.457 1.59-3.968 4.464-4.447 5.726-4.447 2.54 0 5.274 1.621 5.274 5.181 0 4.069-5.136 8.625-11 14.402z"/></svg>
        BP Analyzer
    </a>
    <div class="nav-links">
        <a href="{{ route('health.form') }}">Analyze</a>
        <a href="{{ route('health.admin') }}">Admin</a>
    </div>
</nav>
<main>
    @yield('content')
</main>
<footer>
    Blood Pressure Level Analyzer &mdash; For educational purposes only. Always consult a medical professional.
</footer>
</body>
</html>
