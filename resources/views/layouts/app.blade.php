<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>

<!-- ================= THEME SYSTEM ================= -->
<style>

/* ============================= */
/* LIGHT THEME (PASTEL BLUE) */
/* ============================= */

body{
background:#f2f7ff;
color:#1f2937;
}

.min-h-screen{
background:#f2f7ff !important;
}

/* Cards */
.bg-white{
background:#ffffff !important;
border:1px solid #dbeafe;
border-radius:12px;
box-shadow:0 4px 10px rgba(0,0,0,0.04);
}

/* Headings */
h1,h2,h3,h4{
color:#1e3a8a;
}

/* Text */
p,span,label{
color:#475569;
}

/* Inputs */
input,select,textarea{
background:#ffffff;
border:1px solid #bfdbfe;
border-radius:8px;
}

input:focus{
outline:none;
border-color:#60a5fa;
box-shadow:0 0 0 2px #bfdbfe;
}

/* Buttons */
button{
background:#3b82f6;
color:white;
border-radius:8px;
}

button:hover{
background:#2563eb;
}

/* Calendar */
.calendar-day{
border:1px solid #bfdbfe;
border-radius:10px;
padding:8px;
}

.calendar-day:hover{
background:#eff6ff;
}

/* ============================= */
/* DARK MODE */
/* ============================= */

.dark{
background:#0f172a;
color:#e5e7eb;
}

.dark body,
.dark .min-h-screen{
background:#0f172a !important;
}

.dark .bg-white{
background:#1e293b !important;
border:1px solid #64748b !important;
color:#e5e7eb;
}

.dark input,
.dark textarea,
.dark select{
background:#020617 !important;
border:1px solid #94a3b8 !important;
color:#f9fafb;
}

/* Dark buttons */
.dark button{
background:#2563eb;
}

.dark button:hover{
background:#1d4ed8;
}
/* ============================= */
/* DARK MODE TEXT VISIBILITY FIX */
/* ============================= */

.dark .bg-white *{
color:#e5e7eb !important;
}

.dark .bg-white h1,
.dark .bg-white h2,
.dark .bg-white h3,
.dark .bg-white h4{
color:#f9fafb !important;
}

.dark .bg-white p,
.dark .bg-white span{
color:#cbd5f5 !important;
}
/* ============================= */
/* DARK MODE CALENDAR TEXT FIX */
/* ============================= */

.dark .calendar-day{
color:#f9fafb !important;              /* white text */
}

.dark .calendar-day span{
color:#f9fafb !important;
}

.dark .calendar-header,
.dark .calendar-header *{
color:#f9fafb !important;
}

/* ============================= */
/* DARK MODE TABLE HEADER FIX */
/* ============================= */

.dark thead,
.dark th{
background:#1e293b !important;
color:#f9fafb !important;
}

.dark th{
border-bottom:1px solid #64748b !important;
}

/* ============================= */
/* TABLE ROW TEXT */
/* ============================= */

.dark td{
color:#e5e7eb !important;
}
/* ============================= */
/* CALENDAR TASK LABELS */
/* ============================= */

.dark .calendar-day small,
.dark .calendar-day div,
.dark .calendar-day p{
color:#e5e7eb !important;   /* brighter light gray */
}

/* When day has task (white background boxes) */
.dark .calendar-day.bg-white,
.dark .calendar-day.task-day{
background:#1e293b !important;
color:#f9fafb !important;
}

.dark .calendar-day.bg-white *,
.dark .calendar-day.task-day *{
color:#f9fafb !important;
}
/* Ensure calendar numbers always visible */
.calendar-day{
color:#1f2937;
}

.dark .calendar-day{
color:#f9fafb !important;
}


/* ============================= */
/* STREAK TEXT */
/* ============================= */

.dark .streak,
.dark .streak *,
.dark .current-streak{
color:#f9fafb !important;
}

/* Glow for task days */
.dark .calendar-day.task-day{
box-shadow:0 0 0 2px #60a5fa;
}
/* ============================= */
/* FORCE TASKS CALENDAR VISIBILITY */
/* ============================= */

#taskCalendar .calendar-day,
#taskCalendar .calendar-day *{
color:#ffffff !important;
opacity:1 !important;
}

.dark #taskCalendar .calendar-day,
.dark #taskCalendar .calendar-day *{
color:#ffffff !important;
}

/* Strong border so boxes visible */
#taskCalendar .calendar-day{
border:1px solid #cbd5f5 !important;
background:#1e293b !important;
}

/* Light mode */
body:not(.dark) #taskCalendar .calendar-day{
color:#1f2937 !important;
background:#ffffff !important;
border:1px solid #bfdbfe !important;
}



</style>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>{{ config('app.name', 'StudyFlow') }}</title>

<!-- Fonts -->
<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

<!-- Scripts -->
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
@vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="font-sans antialiased {{ auth()->check() && auth()->user()->theme=='dark' ? 'dark' : '' }}">

<div class="min-h-screen">

@include('layouts.navigation')

@isset($header)
<header class="shadow">
<div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
{{ $header }}
</div>
</header>
@endisset

<main>
{{ $slot }}
</main>

</div>

</body>
</html>
