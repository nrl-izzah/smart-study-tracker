<!DOCTYPE html>
<html>
<body>

<h2>⏰ StudyFlow Reminder</h2>

<p>Hello {{ $task->user->name }},</p>

<p>This is a reminder that you have a task due tomorrow.</p>

<p><b>Task:</b> {{ $task->title }}</p>
<p><b>Deadline:</b> {{ $task->deadline }}</p>

<p>Stay focused and good luck! 💪</p>

<p>— StudyFlow</p>

</body>
</html>
