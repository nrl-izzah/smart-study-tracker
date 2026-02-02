<x-app-layout>

<!-- ================= CALENDAR SCRIPT ================= -->
<script>
document.addEventListener("DOMContentLoaded", function(){

const monthNames = [
"January","February","March","April","May","June",
"July","August","September","October","November","December"
];

let currentDate = new Date();
const today = new Date();

function renderCalendar(){

const year = currentDate.getFullYear();
const month = currentDate.getMonth();

document.getElementById("calendarHeader").innerText =
monthNames[month] + " " + year;

const firstDay = new Date(year, month, 1).getDay();
const daysInMonth = new Date(year, month+1, 0).getDate();

const calendar = document.getElementById("calendarDays");
calendar.innerHTML = "";

for(let i=0;i<firstDay;i++){
calendar.innerHTML += "<div></div>";
}

for(let d=1; d<=daysInMonth; d++){

if(
d === today.getDate() &&
month === today.getMonth() &&
year === today.getFullYear()
){
calendar.innerHTML +=
`<div style="background:#2563eb;color:white;border-radius:999px;padding:8px;font-weight:bold">
${d}
</div>`;
}else{
calendar.innerHTML +=
`<div style="border:1px solid #ccc;border-radius:6px;padding:8px">
${d}
</div>`;
}

}

}

window.prevMonth = function(){
currentDate.setMonth(currentDate.getMonth()-1);
renderCalendar();
}

window.nextMonth = function(){
currentDate.setMonth(currentDate.getMonth()+1);
renderCalendar();
}

renderCalendar();

});
</script>

<!-- ================= PAGE ================= -->
<div class="py-12 bg-gray-50 min-h-screen">
<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

<!-- HEADER -->
<div class="mb-10">
<h2 class="text-3xl font-bold text-gray-800">
Welcome back, {{ Auth::user()->name ?? Auth::user()->email }} 👋
</h2>
<p class="text-gray-500 mt-1">Let’s continue building your study momentum</p>
</div>

<!-- STATS -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">

<div class="bg-white p-6 rounded-xl shadow border-l-4 border-blue-500">
<p class="text-sm text-gray-500">Total Tasks</p>
<p class="text-3xl font-bold text-gray-800">{{ $stats['total'] }}</p>
</div>

<div class="bg-white p-6 rounded-xl shadow border-l-4 border-green-500">
<p class="text-sm text-gray-500">Completed</p>
<p class="text-3xl font-bold text-gray-800">{{ $stats['completed'] }}</p>
</div>

<div class="bg-white p-6 rounded-xl shadow border-l-4 border-yellow-500">
<p class="text-sm text-gray-500">Pending</p>
<p class="text-3xl font-bold text-gray-800">{{ $stats['pending'] }}</p>
</div>

</div>

<!-- PROGRESS -->
@php
$percent = $stats['total'] > 0
? round(($stats['completed']/$stats['total'])*100)
: 0;
@endphp

<div class="bg-white p-6 rounded-xl shadow mb-10">
<p class="font-semibold mb-2">Overall Progress</p>
<div class="w-full bg-gray-200 rounded-full h-4">
<div class="bg-green-500 h-4 rounded-full" style="width: {{ $percent }}%"></div>
</div>
<p class="text-sm text-gray-500 mt-1">{{ $percent }}% completed</p>
</div>

<!-- ================= MAIN GRID ================= -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

<!-- LEFT : CALENDAR -->
<div class="bg-white p-6 rounded-xl shadow">

<h3 class="text-lg font-bold mb-4">Calendar</h3>

<div class="flex justify-between items-center mb-3">
<button onclick="prevMonth()" class="px-3 py-1 border rounded">◀</button>
<div id="calendarHeader" class="font-semibold"></div>
<button onclick="nextMonth()" class="px-3 py-1 border rounded">▶</button>
</div>

<div class="grid grid-cols-7 gap-2 text-center text-sm font-semibold mb-2">
<div>Sun</div><div>Mon</div><div>Tue</div>
<div>Wed</div><div>Thu</div><div>Fri</div><div>Sat</div>
</div>

<div id="calendarDays" class="grid grid-cols-7 gap-2 text-center"></div>

</div>

<!-- RIGHT : TASKS -->
<div class="space-y-8">

<!-- UPCOMING -->
<div class="bg-white p-6 rounded-xl shadow">

<h3 class="text-lg font-bold mb-1">Upcoming Tasks</h3>
<p class="text-sm text-gray-500 mb-6">Your next 5 study items</p>

@if($upcomingTasks->isEmpty())
<p class="text-center text-gray-400 italic py-10">
You’re all caught up 🎉
</p>
@else

<div class="space-y-4">
@foreach($upcomingTasks as $task)

<div class="flex justify-between items-center p-4 border rounded-lg hover:bg-gray-50">

<div>
<p class="font-semibold text-gray-800">{{ $task->title }}</p>
<p class="text-xs text-gray-500">Due {{ $task->deadline }}</p>
</div>

<div class="flex items-center gap-3">

@if($task->status == 'completed')
<span class="px-3 py-1 text-xs rounded-full bg-green-100 text-green-700">Completed</span>
@else
<span class="px-3 py-1 text-xs rounded-full bg-yellow-100 text-yellow-700">Pending</span>
@endif

<a href="{{ route('tasks.edit',$task->id) }}"
class="text-blue-600 text-sm font-medium hover:underline">
View
</a>

</div>

</div>

@endforeach
</div>

@endif

</div>

<!-- QUICK ADD -->
<div class="bg-white p-6 rounded-xl shadow">

<h4 class="font-bold mb-4">Quick Add Task</h4>

<form action="{{ route('tasks.store') }}" method="POST" class="space-y-4">
@csrf

<input
type="text"
name="title"
placeholder="What do you want to study?"
class="w-full rounded-lg border-gray-300 focus:ring-blue-500"
required>

<input
type="date"
name="deadline"
class="w-full rounded-lg border-gray-300 focus:ring-blue-500">

<button
type="submit"
class="w-full bg-blue-600 text-white py-2 rounded-lg font-bold hover:bg-blue-700 transition">
Add Task
</button>

</form>

</div>

</div>

</div>

</div>
</div>

</x-app-layout>
