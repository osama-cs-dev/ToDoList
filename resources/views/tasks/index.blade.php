<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>To-Do List</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --bg: #f5f4f0;
            --sidebar: #ffffff;
            --main: #f5f4f0;
            --card: #ffffff;
            --border: #e8e6e1;
            --accent: #4f46e5;
            --accent-light: #eef2ff;
            --accent-hover: #4338ca;
            --text: #1a1a2e;
            --muted: #9896a4;
            --success: #16a34a;
            --success-bg: #f0fdf4;
            --danger: #dc2626;
            --danger-bg: #fef2f2;
            --warning: #d97706;
            --timer-bg: #fafaf9;
            --radius: 12px;
            --shadow: 0 1px 3px rgba(0, 0, 0, 0.06), 0 1px 2px rgba(0, 0, 0, 0.04);
            --shadow-md: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        body {
            background: var(--bg);
            color: var(--text);
            font-family: 'Plus Jakarta Sans', sans-serif;
            height: 100vh;
            display: flex;
            overflow: hidden;
        }

        /* ───── SIDEBAR ───── */
        .sidebar {
            width: 280px;
            min-width: 280px;
            background: var(--sidebar);
            border-right: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            height: 100vh;
            overflow: hidden;
        }

        .sidebar-header {
            padding: 28px 24px 20px;
            border-bottom: 1px solid var(--border);
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
        }

        .logo-icon {
            width: 32px;
            height: 32px;
            background: var(--accent);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 15px;
        }

        .logo h1 {
            font-size: 1rem;
            font-weight: 700;
            letter-spacing: -0.3px;
            color: var(--text);
        }

        .stats-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
        }

        .stat-box {
            background: var(--bg);
            border-radius: 10px;
            padding: 10px 12px;
            text-align: center;
        }

        .stat-box .num {
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--accent);
            line-height: 1;
        }

        .stat-box .lbl {
            font-size: 0.7rem;
            color: var(--muted);
            margin-top: 3px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .sidebar-nav {
            flex: 1;
            overflow-y: auto;
            padding: 16px 12px;
        }

        .nav-label {
            font-size: 0.68rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--muted);
            padding: 0 12px;
            margin-bottom: 8px;
            margin-top: 16px;
        }

        .nav-label:first-child {
            margin-top: 0;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 12px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 0.875rem;
            color: var(--muted);
            transition: all 0.15s;
            text-decoration: none;
        }

        .nav-item:hover {
            background: var(--bg);
            color: var(--text);
        }

        .nav-item.active {
            background: var(--accent-light);
            color: var(--accent);
            font-weight: 600;
        }

        .nav-item .dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: currentColor;
            opacity: 0.5;
            flex-shrink: 0;
        }

        .nav-item.active .dot {
            opacity: 1;
        }

        .nav-count {
            margin-left: auto;
            background: var(--bg);
            border-radius: 99px;
            padding: 1px 8px;
            font-size: 0.72rem;
            font-weight: 600;
        }

        .nav-item.active .nav-count {
            background: var(--accent);
            color: white;
        }

        .sidebar-footer {
            padding: 16px 12px;
            border-top: 1px solid var(--border);
        }

        .btn-new-task {
            width: 100%;
            background: var(--accent);
            color: white;
            border: none;
            border-radius: 10px;
            padding: 11px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 0.875rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.15s, transform 0.1s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
        }

        .btn-new-task:hover {
            background: var(--accent-hover);
        }

        .btn-new-task:active {
            transform: scale(0.98);
        }

        /* ───── MAIN ───── */
        .main {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .topbar {
            background: var(--sidebar);
            border-bottom: 1px solid var(--border);
            padding: 18px 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-shrink: 0;
        }

        .topbar-title {
            font-size: 1.1rem;
            font-weight: 700;
            letter-spacing: -0.3px;
        }

        .topbar-subtitle {
            font-size: 0.8rem;
            color: var(--muted);
            margin-top: 1px;
        }

        .topbar-actions {
            display: flex;
            gap: 8px;
        }

        .filter-btn {
            background: var(--bg);
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 7px 14px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 0.8rem;
            font-weight: 500;
            color: var(--muted);
            cursor: pointer;
            transition: all 0.15s;
        }

        .filter-btn:hover,
        .filter-btn.active {
            background: var(--accent-light);
            border-color: var(--accent);
            color: var(--accent);
        }

        .tasks-scroll {
            flex: 1;
            overflow-y: auto;
            padding: 24px 32px;
        }

        /* ───── TASK CARD ───── */
        .task-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            margin-bottom: 12px;
            box-shadow: var(--shadow);
            transition: box-shadow 0.2s, border-color 0.2s;
            overflow: hidden;
        }

        .task-card:hover {
            box-shadow: var(--shadow-md);
            border-color: #d5d2cb;
        }

        .task-card.is-done {
            opacity: 0.6;
        }

        .task-card.is-done .task-title {
            text-decoration: line-through;
            color: var(--muted);
        }

        .task-main {
            display: flex;
            align-items: stretch;
            gap: 0;
        }

        .task-check-col {
            display: flex;
            align-items: flex-start;
            padding: 18px 16px 18px 20px;
        }

        .check-btn {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            border: 2px solid var(--border);
            background: white;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.15s;
            flex-shrink: 0;
            margin-top: 2px;
        }

        .check-btn:hover {
            border-color: var(--accent);
        }

        .check-btn.checked {
            background: var(--success);
            border-color: var(--success);
        }

        .check-btn.checked::after {
            content: '';
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: white;
        }

        .task-content {
            flex: 1;
            padding: 16px 16px 16px 0;
            min-width: 0;
        }

        .task-top-row {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            margin-bottom: 6px;
        }

        .task-title {
            font-size: 0.9rem;
            font-weight: 600;
            line-height: 1.4;
            flex: 1;
        }

        .task-image-thumb {
            width: 48px;
            height: 48px;
            border-radius: 8px;
            object-fit: cover;
            border: 1px solid var(--border);
            flex-shrink: 0;
        }

        .task-desc {
            font-size: 0.8rem;
            color: var(--muted);
            line-height: 1.5;
            margin-bottom: 12px;
        }

        .task-footer {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }

        /* ───── TIMER ───── */
        .timer-wrap {
            display: flex;
            align-items: center;
            gap: 6px;
            background: var(--timer-bg);
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 5px 10px;
        }

        .timer-icon {
            font-size: 12px;
        }

        .timer-val {
            font-size: 0.8rem;
            font-weight: 700;
            font-variant-numeric: tabular-nums;
            letter-spacing: 0.5px;
            color: var(--text);
            min-width: 70px;
        }

        .timer-val.running {
            color: var(--accent);
        }

        .timer-val.done {
            color: var(--success);
        }

        .timer-val.overtime {
            color: var(--danger);
        }

        .timer-progress {
            height: 3px;
            background: var(--border);
            border-radius: 99px;
            overflow: hidden;
            width: 60px;
        }

        .timer-progress-bar {
            height: 100%;
            background: var(--accent);
            border-radius: 99px;
            transition: width 1s linear;
        }

        /* ───── ACTION BUTTONS ───── */
        .action-btn {
            background: none;
            border: 1px solid var(--border);
            border-radius: 7px;
            padding: 4px 10px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 0.75rem;
            font-weight: 500;
            color: var(--muted);
            cursor: pointer;
            transition: all 0.15s;
            white-space: nowrap;
        }

        .action-btn:hover {
            background: var(--bg);
            color: var(--text);
            border-color: #ccc;
        }

        .action-btn.primary {
            color: var(--accent);
            border-color: #c7d2fe;
            background: var(--accent-light);
        }

        .action-btn.primary:hover {
            background: #e0e7ff;
        }

        .action-btn.danger:hover {
            color: var(--danger);
            border-color: #fca5a5;
            background: var(--danger-bg);
        }

        .action-btn.success-btn {
            color: var(--success);
            border-color: #86efac;
            background: var(--success-bg);
        }

        .action-spacer {
            flex: 1;
        }

        /* ───── PRIORITY BADGE ───── */
        .priority {
            font-size: 0.7rem;
            font-weight: 600;
            padding: 2px 8px;
            border-radius: 99px;
            letter-spacing: 0.3px;
        }

        .priority.high {
            background: #fef2f2;
            color: #dc2626;
        }

        .priority.medium {
            background: #fffbeb;
            color: #d97706;
        }

        .priority.normal {
            background: var(--accent-light);
            color: var(--accent);
        }

        /* ───── EMPTY STATE ───── */
        .empty {
            text-align: center;
            padding: 80px 20px;
            color: var(--muted);
        }

        .empty-icon {
            font-size: 2.5rem;
            margin-bottom: 12px;
        }

        .empty h3 {
            font-size: 1rem;
            font-weight: 600;
            color: var(--text);
            margin-bottom: 6px;
        }

        .empty p {
            font-size: 0.85rem;
        }

        /* ───── FLASH ───── */
        .flash {
            background: var(--success-bg);
            border: 1px solid #86efac;
            color: var(--success);
            border-radius: 10px;
            padding: 10px 16px;
            margin-bottom: 16px;
            font-size: 0.85rem;
            font-weight: 500;
        }

        /* ───── MODAL ───── */
        .modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(15, 15, 30, 0.35);
            backdrop-filter: blur(4px);
            z-index: 200;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .modal-overlay.open {
            display: flex;
        }

        .modal {
            background: white;
            border-radius: 16px;
            padding: 28px;
            width: 100%;
            max-width: 480px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
            max-height: 90vh;
            overflow-y: auto;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 22px;
        }

        .modal-header h2 {
            font-size: 1rem;
            font-weight: 700;
        }

        .close-btn {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            border: 1px solid var(--border);
            background: var(--bg);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.85rem;
            color: var(--muted);
            transition: all 0.15s;
        }

        .close-btn:hover {
            background: var(--danger-bg);
            color: var(--danger);
        }

        .field {
            margin-bottom: 16px;
        }

        .field label {
            display: block;
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 6px;
        }

        input[type=text],
        textarea,
        input[type=number],
        input[type=file] {
            width: 100%;
            background: var(--bg);
            border: 1px solid var(--border);
            border-radius: 9px;
            color: var(--text);
            padding: 10px 13px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 0.875rem;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        input:focus,
        textarea:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.08);
            background: white;
        }

        textarea {
            resize: vertical;
            min-height: 80px;
        }

        .upload-zone {
            border: 2px dashed var(--border);
            border-radius: 10px;
            padding: 24px;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s;
            position: relative;
            background: var(--bg);
        }

        .upload-zone:hover {
            border-color: var(--accent);
            background: var(--accent-light);
        }

        .upload-zone input {
            position: absolute;
            inset: 0;
            opacity: 0;
            cursor: pointer;
            width: 100%;
            height: 100%;
        }

        .upload-zone p {
            font-size: 0.8rem;
            color: var(--muted);
            margin-top: 4px;
        }

        .btn-submit {
            width: 100%;
            background: var(--accent);
            color: white;
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            margin-top: 8px;
            transition: background 0.15s;
        }

        .btn-submit:hover {
            background: var(--accent-hover);
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        #imgPreview {
            width: 100%;
            border-radius: 8px;
            margin-top: 8px;
            display: none;
            max-height: 140px;
            object-fit: cover;
        }

        ::-webkit-scrollbar {
            width: 5px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: var(--border);
            border-radius: 99px;
        }
    </style>
</head>

<body>

    <!-- ═══ SIDEBAR ═══ -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <div class="logo">
                <div class="logo-icon">✓</div>
                <h1>Todo List</h1>
            </div>
            <div class="stats-row">
                <div class="stat-box">
                    <div class="num">{{ $tasks->count() }}</div>
                    <div class="lbl">Total</div>
                </div>
                <div class="stat-box">
                    <div class="num">{{ $tasks->where('completed', false)->count() }}</div>
                    <div class="lbl">Pending</div>
                </div>
            </div>
        </div>

        <nav class="sidebar-nav">
            <div class="nav-label">Views</div>
            <a class="nav-item active" href="#">
                <div class="dot"></div>
                All Tasks
                <span class="nav-count">{{ $tasks->count() }}</span>
            </a>
            <a class="nav-item" href="#" onclick="filterTasks('active'); return false;">
                <div class="dot"></div>
                Active
                <span class="nav-count">{{ $tasks->where('completed', false)->count() }}</span>
            </a>
            <a class="nav-item" href="#" onclick="filterTasks('done'); return false;">
                <div class="dot"></div>
                Completed
                <span class="nav-count">{{ $tasks->where('completed', true)->count() }}</span>
            </a>

            <div class="nav-label" style="margin-top:20px">Recent Tasks</div>
            @foreach ($tasks->take(5) as $task)
                <div class="nav-item" onclick="scrollToTask({{ $task->id }})">
                    <div class="dot"
                        style="{{ $task->completed ? 'background:#16a34a' : 'background:var(--accent)' }}"></div>
                    <span
                        style="overflow:hidden;text-overflow:ellipsis;white-space:nowrap;font-size:0.82rem">{{ $task->title }}</span>
                </div>
            @endforeach
        </nav>

        <div class="sidebar-footer">
            <button class="btn-new-task" onclick="openAdd()">
                <span style="font-size:1.1rem;line-height:1">+</span>
                New Task
            </button>
        </div>
    </aside>

    <!-- ═══ MAIN AREA ═══ -->
    <main class="main">
        <div class="topbar">
            <div>
                <div class="topbar-title">All Tasks</div>
                <div class="topbar-subtitle">{{ now()->format('l, F j') }}</div>
            </div>
            <div class="topbar-actions">
                <button class="filter-btn active" onclick="filterTasks('all', this)">All</button>
                <button class="filter-btn" onclick="filterTasks('active', this)">Active</button>
                <button class="filter-btn" onclick="filterTasks('done', this)">Done</button>
            </div>
        </div>

        <div class="tasks-scroll" id="tasksScroll">

            @if (session('success'))
                <div class="flash">✓ {{ session('success') }}</div>
            @endif

            @forelse($tasks as $task)
                <div class="task-card {{ $task->completed ? 'is-done' : '' }}" id="card-{{ $task->id }}"
                    data-status="{{ $task->completed ? 'done' : 'active' }}">
                    <div class="task-main">
                        <div class="task-check-col">
                            <div class="check-btn {{ $task->completed ? 'checked' : '' }}"
                                onclick="toggleTask({{ $task->id }}, this)">
                            </div>
                        </div>

                        <div class="task-content">
                            <div class="task-top-row">
                                <div class="task-title">{{ $task->title }}</div>
                                @if ($task->image)
                                    <img src="{{ Storage::url($task->image) }}" class="task-image-thumb"
                                        alt="">
                                @endif
                            </div>

                            @if ($task->description)
                                <div class="task-desc">{{ $task->description }}</div>
                            @endif

                            <div class="task-footer">
                                <div class="timer-wrap">
                                    <span class="timer-icon">⏱</span>
                                    <span class="timer-val" id="timerVal-{{ $task->id }}">00:00:00</span>
                                    @if ($task->timer_seconds > 0)
                                        <div class="timer-progress">
                                            <div class="timer-progress-bar" id="timerBar-{{ $task->id }}"
                                                style="width:0%"></div>
                                        </div>
                                    @endif
                                </div>

                                <button class="action-btn primary" id="startBtn-{{ $task->id }}"
                                    onclick="startTimer({{ $task->id }}, {{ $task->timer_seconds }}, {{ $task->elapsed_seconds }})">
                                    ▶ Start
                                </button>

                                <button class="action-btn" id="pauseBtn-{{ $task->id }}" style="display:none"
                                    onclick="pauseTimer({{ $task->id }})">
                                    ⏸ Pause
                                </button>

                                <button class="action-btn"
                                    onclick="resetTimer({{ $task->id }}, {{ $task->timer_seconds }})">
                                    ↺ Reset
                                </button>

                                <div class="action-spacer"></div>

                                <button class="action-btn"
                                    onclick="openEdit({{ $task->id }}, '{{ addslashes($task->title) }}', '{{ addslashes($task->description ?? '') }}', {{ $task->timer_seconds }})">
                                    ✎ Edit
                                </button>

                                <form action="{{ route('tasks.destroy', $task) }}" method="POST"
                                    style="display:inline" onsubmit="return confirm('Delete this task?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="action-btn danger">✕</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="empty">
                    <div class="empty-icon">📋</div>
                    <h3>No tasks yet</h3>
                    <p>Click "New Task" to get started</p>
                </div>
            @endforelse

        </div>
    </main>

    <div class="modal-overlay" id="addModal">
        <div class="modal">
            <div class="modal-header">
                <h2>Add New Task</h2>
                <button class="close-btn" onclick="closeAdd()">✕</button>
            </div>
            <form action="{{ route('tasks.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="field">
                    <label>Title</label>
                    <input type="text" name="title" placeholder="What needs to be done?" required>
                </div>
                <div class="field">
                    <label>Description</label>
                    <textarea name="description" placeholder="Optional details..."></textarea>
                </div>
                <div class="form-row">
                    <div class="field">
                        <label>Timer Duration</label>
                        <div style="display:flex;gap:8px;align-items:center;">
                            <input type="number" name="timer_hours" placeholder="0" min="0" max="23"
                                style="width:70px;text-align:center;" id="addHours">
                            <span style="color:var(--muted);font-size:0.85rem">hr</span>
                            <input type="number" name="timer_minutes" placeholder="0" min="0"
                                max="59" style="width:70px;text-align:center;" id="addMinutes">
                            <span style="color:var(--muted);font-size:0.85rem">min</span>
                        </div>
                        <input type="hidden" name="timer_seconds" id="addTimerSeconds">
                    </div>
                    <div class="field">
                        <label>Image</label>
                        <div class="upload-zone">
                            <input type="file" name="image" accept="image/*"
                                onchange="previewImg(this, 'addPreview')">
                            <div>📎</div>
                            <p>Upload image</p>
                        </div>
                        <img id="addPreview" src=""
                            style="width:100%;border-radius:8px;margin-top:8px;display:none;max-height:100px;object-fit:cover;">
                    </div>
                </div>
                <button type="submit" class="btn-submit">Add Task</button>
            </form>
        </div>
    </div>

    <!-- ═══ EDIT MODAL ═══ -->
    <div class="modal-overlay" id="editModal">
        <div class="modal">
            <div class="modal-header">
                <h2>Edit Task</h2>
                <button class="close-btn" onclick="closeEdit()">✕</button>
            </div>
            <form id="editForm" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')
                <div class="field">
                    <label>Title</label>
                    <input type="text" name="title" id="editTitle" required>
                </div>
                <div class="field">
                    <label>Description</label>
                    <textarea name="description" id="editDesc"></textarea>
                </div>
                <div class="form-row">
                    <div class="field">
                        <label>Timer Duration</label>
                        <div style="display:flex;gap:8px;align-items:center;">
                            <input type="number" name="timer_hours" placeholder="0" min="0" max="23"
                                style="width:70px;text-align:center;" id="editHours">
                            <span style="color:var(--muted);font-size:0.85rem">hr</span>
                            <input type="number" name="timer_minutes" placeholder="0" min="0"
                                max="59" style="width:70px;text-align:center;" id="editMinutes">
                            <span style="color:var(--muted);font-size:0.85rem">min</span>
                        </div>
                        <input type="hidden" name="timer_seconds" id="editTimerSeconds">
                    </div>
                    <div class="field">
                        <label>Replace Image</label>
                        <input type="file" name="image" accept="image/*">
                    </div>
                </div>
                <button type="submit" class="btn-submit">Save Changes</button>
            </form>
        </div>
    </div>


    <script>
const timers = {};
const elapsed = {};

function fmt(s) {
    const h = Math.floor(s / 3600);
    const m = Math.floor((s % 3600) / 60);
    const sec = s % 60;
    return [h, m, sec].map(v => String(v).padStart(2, '0')).join(':');
}

function updateDisplay(id, remaining, total) {
    const el = document.getElementById('timerVal-' + id);
    const bar = document.getElementById('timerBar-' + id);
    el.textContent = fmt(Math.max(remaining, 0));
    if (bar && total > 0) {
        bar.style.width = Math.min((remaining / total) * 100, 100) + '%';
    }
}

document.addEventListener('DOMContentLoaded', () => {
    @foreach($tasks as $task)
    elapsed[{{ $task->id }}] = {{ $task->elapsed_seconds }};
    updateDisplay({{ $task->id }}, {{ $task->timer_seconds }} - {{ $task->elapsed_seconds }}, {{ $task->timer_seconds }});
    @endforeach

    document.getElementById('addHours').addEventListener('input', calcAddSeconds);
    document.getElementById('addMinutes').addEventListener('input', calcAddSeconds);
    document.getElementById('editHours').addEventListener('input', calcEditSeconds);
    document.getElementById('editMinutes').addEventListener('input', calcEditSeconds);
});

function calcAddSeconds() {
    const h = parseInt(document.getElementById('addHours').value) || 0;
    const m = parseInt(document.getElementById('addMinutes').value) || 0;
    document.getElementById('addTimerSeconds').value = (h * 3600) + (m * 60);
}

function calcEditSeconds() {
    const h = parseInt(document.getElementById('editHours').value) || 0;
    const m = parseInt(document.getElementById('editMinutes').value) || 0;
    document.getElementById('editTimerSeconds').value = (h * 3600) + (m * 60);
}

function startTimer(id, total, startElapsed) {
    if (timers[id]) return;
    if (total <= 0) return;

    elapsed[id] = startElapsed;

    const startBtn = document.getElementById('startBtn-' + id);
    const pauseBtn = document.getElementById('pauseBtn-' + id);
    const valEl    = document.getElementById('timerVal-' + id);

    startBtn.style.display = 'none';
    pauseBtn.style.display = '';
    valEl.classList.remove('done');
    valEl.classList.add('running');

    timers[id] = setInterval(() => {
        elapsed[id]++;
        const remaining = total - elapsed[id];
        updateDisplay(id, remaining, total);

        if (remaining <= 0) {
            clearInterval(timers[id]);
            delete timers[id];
            valEl.classList.remove('running');
            valEl.classList.add('done');
            startBtn.style.display = '';
            pauseBtn.style.display = 'none';
            saveTimer(id, elapsed[id]);
            return;
        }

        if (elapsed[id] % 5 === 0) saveTimer(id, elapsed[id]);
    }, 1000);
}

function pauseTimer(id) {
    if (!timers[id]) return;

    clearInterval(timers[id]);
    delete timers[id];

    const startBtn = document.getElementById('startBtn-' + id);
    const pauseBtn = document.getElementById('pauseBtn-' + id);
    const valEl    = document.getElementById('timerVal-' + id);
    const total    = elapsed[id];

    valEl.classList.remove('running');
    startBtn.style.display = '';
    pauseBtn.style.display = 'none';

    saveTimer(id, elapsed[id]);

    startBtn.onclick = () => startTimer(id, total + (total - elapsed[id]), elapsed[id]);
}

function resetTimer(id, total) {
    if (timers[id]) {
        clearInterval(timers[id]);
        delete timers[id];
    }

    elapsed[id] = 0;

    const startBtn = document.getElementById('startBtn-' + id);
    const pauseBtn = document.getElementById('pauseBtn-' + id);
    const valEl    = document.getElementById('timerVal-' + id);

    valEl.classList.remove('running', 'done', 'overtime');
    startBtn.style.display = '';
    pauseBtn.style.display = 'none';
    startBtn.onclick = () => startTimer(id, total, 0);

    updateDisplay(id, total, total);
    saveTimer(id, 0);
}

function saveTimer(id, secs) {
    fetch('/tasks/' + id + '/timer', {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ elapsed_seconds: secs })
    });
}

function toggleTask(id, btn) {
    fetch('/tasks/' + id + '/toggle', {
        method: 'PATCH',
        headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
    })
    .then(r => r.json())
    .then(data => {
        const card = document.getElementById('card-' + id);
        card.classList.toggle('is-done', data.completed);
        card.dataset.status = data.completed ? 'done' : 'active';
        btn.classList.toggle('checked', data.completed);

        if (data.completed && timers[id]) {
            clearInterval(timers[id]);
            delete timers[id];

            const valEl    = document.getElementById('timerVal-' + id);
            const startBtn = document.getElementById('startBtn-' + id);
            const pauseBtn = document.getElementById('pauseBtn-' + id);

            valEl.classList.remove('running');
            startBtn.style.display = '';
            pauseBtn.style.display = 'none';

            saveTimer(id, elapsed[id]);
        }
    });
}

function filterTasks(type, btnEl) {
    document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
    if (btnEl) btnEl.classList.add('active');
    document.querySelectorAll('.task-card').forEach(card => {
        if (type === 'all') card.style.display = '';
        else card.style.display = card.dataset.status === type ? '' : 'none';
    });
}

function scrollToTask(id) {
    const el = document.getElementById('card-' + id);
    if (el) el.scrollIntoView({ behavior: 'smooth', block: 'center' });
}

function openAdd()   { document.getElementById('addModal').classList.add('open'); }
function closeAdd()  { document.getElementById('addModal').classList.remove('open'); }

function openEdit(id, title, desc, totalSeconds) {
    document.getElementById('editForm').action = '/tasks/' + id;
    document.getElementById('editTitle').value = title;
    document.getElementById('editDesc').value   = desc;

    const h = Math.floor(totalSeconds / 3600);
    const m = Math.floor((totalSeconds % 3600) / 60);
    document.getElementById('editHours').value         = h;
    document.getElementById('editMinutes').value       = m;
    document.getElementById('editTimerSeconds').value  = totalSeconds;

    document.getElementById('editModal').classList.add('open');
}

function closeEdit() { document.getElementById('editModal').classList.remove('open'); }

function previewImg(input, previewId) {
    const prev = document.getElementById(previewId);
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => { prev.src = e.target.result; prev.style.display = 'block'; };
        reader.readAsDataURL(input.files[0]);
    }
}

document.getElementById('addModal').addEventListener('click', function(e) { if (e.target === this) closeAdd(); });
document.getElementById('editModal').addEventListener('click', function(e) { if (e.target === this) closeEdit(); });
</script>
</body>

</html>
