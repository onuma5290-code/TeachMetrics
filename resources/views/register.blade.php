 <!doctype html>
<html lang="th">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>สมัครสมาชิก</title>

    <style>
        :root {
            --primary: #2f66ff;
            --primary2: #2457e8;
            --border: rgba(0, 0, 0, .10);
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
            max-width: 520px;
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 18px 35px rgba(0, 0, 0, .18);
            border: 1px solid var(--border);
            overflow: hidden;
        }

        .card-body {
            padding: 28px 26px 22px;
        }

        .center {
            text-align: center;
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
            margin: 10px 0 16px;
            font-size: 22px;
            color: var(--primary2);
            font-weight: 800;
            letter-spacing: .2px;
        }

        .btn {
            width: 100%;
            height: 44px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 700;
            border: none;
            font-size: 14px;
        }

        .btn-primary {
            background: var(--primary);
            color: #fff;
        }

        .btn-primary:hover {
            background: var(--primary2);
        }

        .btn-outline {
            margin-top: 10px;
            background: #fff;
            border: 1px solid rgba(0, 0, 0, .28);
            color: #222;
        }

        .btn-outline:hover {
            background: rgba(0, 0, 0, .02);
        }

        .back {
            display: block;
            margin-top: 14px;
            text-align: center;
            font-size: 14px;
            color: #3a3a3a;
            text-decoration: none;
        }

        .back:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="card">
        <div class="card-body">
            <div class="center">
                <!-- <img class="logo" src="https://upload.wikimedia.org/wikipedia/commons/7/7e/Emblem_of_Thailand.svg" alt="logo"> -->
                <h1>สมัครสมาชิก</h1>
            </div>

            <button class="btn btn-primary" type="button" onclick="goTeacher()">สมัครอาจารย์</button>
            <button class="btn btn-outline" type="button" onclick="goStudent()">สมัครนักเรียน</button>

            <a class="back" href="{{ url('/login') }}">ย้อนกลับหน้า Login</a>
        </div>
    </div>

    <script>
        function goTeacher() {
            // route ลงทะเบียนครูที่เราทำไว้ก่อนหน้า
            window.location.href = "{{ url('/register_teacher') }}";
        }

        function goStudent() {
            // route ลงทะเบียนนักเรียนที่เราทำไว้ก่อนหน้า
            window.location.href = "{{ url('/register_student') }}";
        }
    </script>
</body>

</html>