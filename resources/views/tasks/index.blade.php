<x-app-layout>

<div class="py-12 bg-gray-50 min-h-screen">
<div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

<!-- HEADER -->
<div class="flex justify-between items-center mb-6">
<h2 class="text-2xl font-bold">My Tasks</h2>

<a href="{{ route('dashboard') }}"
class="text-blue-600 hover:underline">
← Dashboard
</a>
</div>

<!-- STREAK -->
<div class="mb-6 bg-white shadow rounded-xl p-5 flex items-center gap-4">
    <div class="mb-10 bg-white shadow rounded-xl p-6">

<h3 class="font-bold mb-4">Task Calendar</h3>

@php
$year = now()->year;
$month = now()->month;
$daysInMonth = now()->daysInMonth;
$startDay = now()->startOfMonth()->dayOfWeek;
$weekDays = ['Sun','Mon','Tue','Wed','Thu','Fri','Sat'];
@endphp

<!-- WEEK DAYS -->
<div class="grid grid-cols-7 gap-2 mb-2 text-center text-sm font-semibold">
@foreach($weekDays as $day)
<div>{{ $day }}</div>
@endforeach
</div>

<!-- EMPTY CELLS -->
<div class="grid grid-cols-7 gap-2 text-center">

@for($i=0;$i<$startDay;$i++)
<div></div>
@endfor

@for($day=1;$day<=$daysInMonth;$day++)
@php
$date = sprintf("%04d-%02d-%02d",$year,$month,$day);
@endphp

<div class="border rounded-lg p-2 min-h-[80px]
@if(isset($calendarTasks[$date]))
bg-blue-50
@endif
">

<div class="font-bold text-sm">{{ $day }}</div>

@if(isset($calendarTasks[$date]))
@foreach($calendarTasks[$date] as $t)
<p class="text-xs truncate">• {{ $t->title }}</p>
@endforeach
@endif

</div>

@endfor

</div>

</div>

<div class="text-4xl">🔥</div>
<div>
<p class="text-sm text-gray-500">Current Study Streak</p>
<p class="text-2xl font-bold">{{ $streak }} Days</p>
</div>
</div>

<!-- SEARCH -->
<input
type="text"
id="searchInput"
placeholder="Search task..."
class="mb-4 w-full md:w-1/3 rounded-lg border-gray-300">

<!-- TASK LIST -->
<div class="bg-white shadow rounded-xl overflow-hidden">

<table class="w-full">
<tr class="bg-gray-100 text-left">
<th class="p-3">Title</th>
<th class="p-3">Deadline</th>
<th class="p-3">Status</th>
<th class="p-3">Action</th>
</tr>

@foreach($tasks as $task)
<tr class="border-t hover:bg-gray-50">

<td class="p-3">{{ $task->title }}</td>

<td class="p-3">
{{ $task->deadline ?? 'No deadline' }}
</td>

<td class="p-3">
@if($task->status == 'completed')
<span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs">
Completed
</span>
@else
<span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs">
Pending
</span>
@endif
</td>

<td class="p-3 flex gap-2">

@if($task->status == 'pending')
<form method="POST" action="{{ route('tasks.complete',$task->id) }}">
@csrf
@method('PATCH')
<button class="text-green-600">Complete</button>
</form>
@endif

<a href="{{ route('tasks.edit',$task->id) }}"
class="text-blue-600">Edit</a>

<form method="POST" action="{{ route('tasks.destroy',$task->id) }}">
@csrf
@method('DELETE')
<button class="text-red-600">Delete</button>
</form>

</td>

</tr>
@endforeach

</table>

</div>

</div>
</div>

<!-- SEARCH SCRIPT -->
<script>
document.getElementById("searchInput").addEventListener("keyup", function(){
let value=this.value.toLowerCase();
document.querySelectorAll("table tr").forEach((row,index)=>{
if(index===0) return;
row.style.display = row.innerText.toLowerCase().includes(value)
? "" : "none";
});
});
</script>

</x-app-layout>
