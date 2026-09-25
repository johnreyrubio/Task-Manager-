<!DOCTYPE html>
<html>

<head>
    <title>My Task Manager</title>

    <link rel="stylesheet" href="/css/style.css?v=3">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>

<div class="container">

    <!-- HEADER -->
    <div class="header">
        <div>
            <h1>TASK <span>MANAGER</span></h1>

            <p>
                Manage your tasks, stay focused,<br>
                and make progress one step at a time.
            </p>
        </div>
    </div>


    <!-- ADD TASK -->
    <div class="add-task-box">

        <form action="/tasks" method="POST">

            @csrf

            <div class="add-task-form">

                <div class="task-input">
                    <span class="plus">+</span>

                    <input
                        type="text"
                        name="task_name"
                        placeholder="Add a new task..."
                        required
                    >
                </div>

                <button
                    type="submit"
                    class="add-task-button"
                >
                    Add Task →
                </button>

            </div>


            <!-- HIDDEN SIMPLE FIELDS -->
            <div class="extra-fields">

                <input
                    type="text"
                    name="description"
                    placeholder="Description"
                >

                <select name="status">

                    <option value="Pending">
                        Pending
                    </option>

                    <option value="Ongoing">
                        Ongoing
                    </option>

                    <option value="Completed">
                        Completed
                    </option>

                </select>

                <input
                    type="date"
                    name="due_date"
                >

            </div>

        </form>

    </div>


    <!-- TASKS -->
    <div class="tasks-container">

        <div class="tasks-header">

            <div class="tasks-title">
                <span class="list-icon">☑</span>

                <h2>My Tasks</h2>

                <span class="task-count">
                    {{ $tasks->count() }}
                </span>
            </div>

        </div>


        <!-- TASK LIST -->
        @foreach ($tasks as $task)

            @php
                $status = strtolower($task->status);
            @endphp

            <div class="task">

                <!-- CHECK CIRCLE -->
                <div class="check-circle
                    @if($status == 'completed')
                        completed
                    @endif
                ">

                    @if($status == 'completed')
                        ✓
                    @endif

                </div>


                <!-- COLOR LINE -->
                <div class="task-line
                    @if($status == 'pending')
                        pending-line
                    @elseif($status == 'ongoing')
                        ongoing-line
                    @elseif($status == 'completed')
                        completed-line
                    @endif
                ">
                </div>


                <!-- TASK INFORMATION -->
                <div class="task-information">

                    <h3
                        @if($status == 'completed')
                            class="completed-text"
                        @endif
                    >
                        {{ $task->task_name }}
                    </h3>

                    @if($task->due_date)

                        <p class="due-date">
                            📅
                            {{ \Carbon\Carbon::parse($task->due_date)->format('M d') }}
                        </p>

                    @endif

                </div>


                <!-- ACTION BUTTONS -->
                <div class="actions">

                    <a
                        href="/tasks/{{ $task->id }}/edit"
                        class="edit-button"
                    >
                        ✎
                    </a>


                    <form
                        action="/tasks/{{ $task->id }}"
                        method="POST"
                    >

                        @csrf

                        @method('DELETE')

                        <button
                            type="submit"
                            class="delete-button"
                            onclick="return confirm('Are you sure you want to delete this task?')"
                        >
                            🗑
                        </button>

                    </form>

                </div>

            </div>

        @endforeach


        <!-- NO TASKS -->
        @if($tasks->count() == 0)

            <div class="no-tasks">

                <h3>No tasks yet!</h3>

                <p>
                    Add your first task above.
                </p>

            </div>

        @endif

    </div>

</div>

</body>
</html>