<x-app-layout>

<!-- ===================== STYLES ===================== -->
<style>
body{
background:#f3f4f6;
font-family:Segoe UI, sans-serif;
}

/* HEADER */
.topbar{
display:flex;
justify-content:space-between;
align-items:center;
margin-bottom:25px;
}

/* STAT CARDS */
.card-container{
display:grid;
grid-template-columns:repeat(4,1fr);
gap:20px;
margin-bottom:30px;
}

.card{
background:white;
padding:18px;
border-radius:8px;
box-shadow:0 1px 4px rgba(0,0,0,0.1);
border-left:4px solid #0f766e;
}

.card-title{
font-size:13px;
color:#6b7280;
}

.card-number{
font-size:22px;
font-weight:bold;
color:#0f766e;
}

/* SECTION TITLE */
h2{
margin:20px 0 10px;
font-size:16px;
color:#111827;
}

/* TABLE */
table{
width:100%;
border-collapse:collapse;
background:white;
border-radius:8px;
overflow:hidden;
box-shadow:0 1px 4px rgba(0,0,0,0.1);
margin-bottom:30px;
}

th{
background:#1f2933;
color:white;
padding:10px;
text-align:left;
font-size:13px;
}

td{
padding:10px;
font-size:13px;
border-bottom:1px solid #e5e7eb;
}

tr:last-child td{
border-bottom:none;
}

tr:hover{
background:#f9fafb;
}

/* BADGES */
.badge-active{
background:#dcfce7;
color:#166534;
padding:3px 10px;
border-radius:999px;
font-size:12px;
}

.badge-disabled{
background:#fee2e2;
color:#991b1b;
padding:3px 10px;
border-radius:999px;
font-size:12px;
}

.badge-complete{
background:#dcfce7;
color:#166534;
padding:3px 10px;
border-radius:999px;
font-size:12px;
}

.badge-pending{
background:#fef3c7;
color:#92400e;
padding:3px 10px;
border-radius:999px;
font-size:12px;
}

/* BUTTONS */
.btn{
padding:6px 14px;
border:none;
border-radius:6px;
font-size:12px;
cursor:pointer;
}

.btn-toggle{
background:#0f766e;
color:white;
}

.btn-toggle:hover{
background:#115e59;
}

.btn-delete{
background:#dc2626;
color:white;
}

.btn-delete:hover{
background:#b91c1c;
}

/* SEARCH */
.search-box{
width:260px;
padding:8px;
border-radius:6px;
border:1px solid #d1d5db;
margin-bottom:10px;
}

/* DARK MODE */
.dark-mode{
background:#111827;
color:#e5e7eb;
}

.dark-mode table{
background:#1f2933;
color:white;
}

.dark-mode th{
background:#374151;
}

.dark-mode .card{
background:#1f2933;
border-left:4px solid #22c55e;
}

.dark-mode .search-box{
background:#1f2933;
color:white;
border:1px solid #555;
}
</style>

<!-- ===================== HEADER ===================== -->
<div class="topbar">
<h1 style="font-size:22px;font-weight:bold;">Admin Control Panel</h1>

</div>

<!-- ===================== STATISTICS ===================== -->
<div class="card-container">

<div class="card">
<div class="card-title">TOTAL USERS</div>
<div class="card-number">{{ \App\Models\User::count() }}</div>
</div>

<div class="card">
<div class="card-title">TOTAL TASKS</div>
<div class="card-number">{{ \App\Models\StudyTask::count() }}</div>
</div>

<div class="card">
<div class="card-title">COMPLETED TASKS</div>
<div class="card-number">{{ \App\Models\StudyTask::where('status','completed')->count() }}</div>
</div>

<div class="card">
<div class="card-title">PENDING TASKS</div>
<div class="card-number">{{ \App\Models\StudyTask::where('status','pending')->count() }}</div>
</div>

</div>

<!-- ===================== USERS ===================== -->
<h2>User Management</h2>

<table>
<tr>
<th>ID</th>
<th>Name</th>
<th>Email</th>
<th>Status</th>
<th>Action</th>
</tr>

@foreach(\App\Models\User::all() as $user)
<tr>
<td>{{ $user->id }}</td>
<td>{{ $user->name }}</td>
<td>{{ $user->email }}</td>
<td>
@if($user->active)
<span class="badge-active">Active</span>
@else
<span class="badge-disabled">Disabled</span>
@endif
</td>
<td>
<form method="POST" action="{{ url('admin/toggle-user/'.$user->id) }}">
@csrf
<button type="submit" class="btn btn-toggle">
{{ $user->active ? 'Disable' : 'Enable' }}
</button>
</form>
</td>
</tr>
@endforeach

</table>

<!-- ===================== TASKS ===================== -->
<h2>All Study Tasks</h2>

<input type="text" id="searchInput" class="search-box" placeholder="Search task...">

<table id="taskTable">
<tr>
<th>User ID</th>
<th>Title</th>
<th>Status</th>
<th>Deadline</th>
<th>Action</th>
</tr>

@foreach(\App\Models\StudyTask::orderBy('deadline','asc')->get() as $task)
<tr>
<td>{{ $task->user_id }}</td>
<td>{{ $task->title }}</td>
<td>
@if($task->status == 'completed')
<span class="badge-complete">Completed</span>
@else
<span class="badge-pending">Pending</span>
@endif
</td>
<td>{{ $task->deadline }}</td>
<td>
<form method="POST" action="/admin/delete-task/{{ $task->id }}">
@csrf
@method('DELETE')
<button type="submit" class="btn btn-delete">Delete</button>
</form>
</td>
</tr>
@endforeach

</table>

<!-- ===================== SCRIPTS ===================== -->
<script>
function toggleDark(){
document.body.classList.toggle("dark-mode");
}

document.getElementById("searchInput").addEventListener("keyup", function(){
let value = this.value.toLowerCase();
document.querySelectorAll("#taskTable tr").forEach((row,index)=>{
if(index===0) return;
row.style.display = row.innerText.toLowerCase().includes(value)
? "" : "none";
});
});
</script>

</x-app-layout>
