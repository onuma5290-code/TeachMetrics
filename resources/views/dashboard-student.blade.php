<!doctype html>
<html lang="th">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard นักเรียน</title>

    <style>
        :root {
            --primary: #2f66ff;
            --primary2: #2457e8;
            --danger: #c63a4a;
            --danger2: #b12f3f;
            --border: rgba(0, 0, 0, .10);
            --muted: rgba(0, 0, 0, .55);
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Noto Sans Thai", sans-serif;
            background: radial-gradient(circle at 30% 20%, #b7cdfc 0%, #6e93ff 35%, #4c7df3 60%, #3b67dd 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }

        .card {
            width: 100%;
            max-width: 720px;
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 18px 35px rgba(0, 0, 0, .18);
            border: 1px solid var(--border);
            overflow: hidden;
        }

        .card-body {
            padding: 28px 28px 22px;
        }

        .top {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            margin-bottom: 14px;
        }

        .logo {
            width: 54px;
            height: 54px;
            border-radius: 50%;
            object-fit: cover;
            border: 1px solid rgba(0, 0, 0, .08);
            background: #fff;
        }

        h1 {
            margin: 10px 0 2px;
            font-size: 22px;
            font-weight: 900;
            color: #1f4fd8;
            letter-spacing: .2px;
        }

        .info {
            width: 100%;
            margin-top: 10px;
            display: grid;
            grid-template-columns: 1fr;
            gap: 6px;
            font-size: 14px;
            color: #222;
        }

        .info b {
            font-weight: 900;
        }

        .divider {
            height: 1px;
            background: rgba(0, 0, 0, .12);
            margin: 16px 0;
        }

        .section-title {
            font-weight: 900;
            font-size: 14px;
            color: #222;
            margin-bottom: 10px;
        }

        .list {
            border: 1px solid rgba(0, 0, 0, .10);
            border-radius: 12px;
            overflow: hidden;
            background: #fff;
        }

        .row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 14px;
            padding: 12px 14px;
            border-bottom: 1px solid rgba(0, 0, 0, .08);
        }

        .row:last-child {
            border-bottom: none;
        }

        .meta {
            line-height: 1.25;
        }

        .subject {
            font-weight: 900;
            font-size: 14px;
            color: #222;
            margin-bottom: 4px;
        }

        .teacher {
            font-size: 13px;
            color: var(--muted);
        }

        .btn {
            border: none;
            border-radius: 8px;
            height: 34px;
            padding: 0 14px;
            font-weight: 900;
            cursor: pointer;
            font-size: 13px;
            white-space: nowrap;
        }

        .btn-primary {
            background: var(--primary);
            color: #fff;
        }

        .btn-primary:hover:not(:disabled) {
            background: var(--primary2);
        }

        .btn-primary:disabled,
        .btn-primary.disabled {
            background: #ccc;
            color: #666;
            cursor: not-allowed;
            opacity: 0.7;
        }

        .bottom {
            margin-top: 14px;
        }

        .btn-danger {
            width: 100%;
            height: 42px;
            background: var(--danger);
            color: #fff;
            border: none;
            border-radius: 8px;
            font-weight: 900;
            cursor: pointer;
            font-size: 14px;
        }

        .btn-danger:hover {
            background: var(--danger2);
        }

        .empty {
            padding: 16px;
            font-size: 14px;
            color: var(--muted);
        }

        .alert {
            border-radius: 10px;
            padding: 10px 12px;
            margin-bottom: 12px;
            font-size: 14px;
            display: none;
        }

        .alert-danger {
            background: #ffecec;
            border: 1px solid #ffc2c2;
            color: #a40000;
        }

        .alert-success {
            background: #eafff0;
            border: 1px solid #b9f3c9;
            color: #0b6b2a;
        }
    </style>
</head>

<body>
    <div class="card">
        <div class="card-body">

            <div class="top">
                <!-- <img class="logo" src="https://upload.wikimedia.org/wikipedia/commons/7/7e/Emblem_of_Thailand.svg" alt="logo"> -->
                <h1>ประเมินการสอน</h1>
            </div>

            @if ($message = Session::get('error'))
                <div class="alert alert-danger" style="display: block;">{{ $message }}</div>
            @endif

            @if ($message = Session::get('success'))
                <div class="alert alert-success" style="display: block;">{{ $message }}</div>
            @endif

            <div class="info">
                <div><b>ชื่อ:</b> {{ $student->fullname }}</div>
                <div><b>สาขา:</b> {{ $student->department }}</div>
                <div><b>ชั้น:</b> {{ $student->classroom }}</div>
            </div>

            <div class="divider"></div>

            <div class="section-title">เลือกประเมินรายวิชา</div>

            <div class="list">
                @if($teacher_lists->count() === 0)
                <div class="empty">ยังไม่มีรายวิชาที่เปิดให้ประเมินในสาขา/ชั้นนี้</div>
                @else
                @foreach($teacher_lists as $teacher)
                @foreach($teacher->subjects as $subject)
                <div class="row">
                    <div class="meta">
                        <div class="subject">{{ $subject->subject_name }}</div>
                        <div class="teacher">อาจารย์: {{ $teacher->fullname }}</div>
                    </div>

                    @php
                        $isEvaluated = in_array($subject->subject_id, $evaluated_subjects);
                    @endphp

                    @if($isEvaluated)
                        <button class="btn btn-primary" disabled title="ประเมินแล้ว">
                            ✓ ประเมินแล้ว
                        </button>
                    @else
                        <button class="btn btn-primary"
                            onclick="goEvaluate({{ $subject->subject_id }})">
                            ประเมิน
                        </button>
                    @endif
                </div>
                @endforeach
                @endforeach
                @endif
            </div>

            <div class="bottom">
                <form method="POST" action="{{ url('/backend/auth/logout') }}">
                    @csrf
                    <button class="btn-danger" type="submit">ออกจากระบบ</button>
                </form>
            </div>

        </div>
    </div>

    <script>
        function goEvaluate(subjectId) {
            window.location.href = '/evaluate/' + subjectId;
        }
    </script>
</body>

</html>