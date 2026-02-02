<!DOCTYPE html>
<html>
<head>
    <title>New Task Created</title>
</head>
<body style="font-family: Arial">

<h2>📚 New Study Task Added</h2>

<p>Hello {{ $task->user->name }},</p>

<p>You have successfully created a new study task.</p>

<hr>

<p><strong>Title:</strong> {{ $task->title }}</p>
<p><strong>Deadline:</strong> {{ $task->deadline }}</p>
<p><strong>Status:</strong> {{ ucfirst($task->status) }}</p>

<hr>

<p>Stay consistent and keep going! 🔥</p>

<p>— StudyFlow</p>

</body>
</html>
