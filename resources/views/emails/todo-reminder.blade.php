<!DOCTYPE html>
<html>
<head>
    <title>Todo Reminder</title>
</head>
<body>
    <h2>Todo Reminder</h2>
    
    <p>This is a friendly reminder about your upcoming todo:</p>
    
    <div style="background-color: #f8f9fa; padding: 20px; border-radius: 5px; margin: 20px 0;">
        <h3>{{ $todo->title }}</h3>
        <p><strong>Description:</strong> {{ $todo->description }}</p>
        <p><strong>Due Date:</strong> {{ $todo->due_date->format('M d, Y \a\t H:i') }}</p>
    </div>
    
    <p>Please find the attached CSV file with additional information.</p>
    
    <p>Best regards,<br>Todo App Team</p>
</body>
</html>