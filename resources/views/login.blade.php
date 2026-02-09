<!doctype html>
<html lang="th">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <style>
    :root {
      --primary: #2f66ff;
      --primary2: #2457e8;
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
      max-width: 560px;
      background: #fff;
      border-radius: 14px;
      box-shadow: 0 18px 35px rgba(0, 0, 0, .18);
      border: 1px solid var(--border);
      overflow: hidden;
    }

    .card-body {
      padding: 28px 26px 22px;
    }

    h1 {
      margin: 0 0 6px;
      text-align: center;
      color: #111;
      font-weight: 900;
      font-size: 22px;
    }

    .sub {
      text-align: center;
      margin-bottom: 14px;
      color: var(--muted);
      font-size: 13px;
    }

    .radio-wrap {
      display: flex;
      gap: 10px;
      justify-content: center;
      margin: 10px 0 16px;
    }

    .radio-pill {
      display: flex;
      align-items: center;
      gap: 8px;
      border: 1px solid rgba(0, 0, 0, .18);
      padding: 10px 12px;
      border-radius: 10px;
      cursor: pointer;
      user-select: none;
      font-weight: 800;
      font-size: 13px;
      background: #fff;
    }

    .radio-pill input {
      accent-color: var(--primary);
    }

    .row {
      margin-bottom: 10px;
    }

    .input {
      width: 100%;
      height: 44px;
      border-radius: 8px;
      border: 1px solid rgba(0, 0, 0, .18);
      padding: 0 12px;
      font-size: 14px;
      outline: none;
      box-sizing: border-box;
    }

    .btn {
      width: 100%;
      height: 44px;
      border-radius: 8px;
      border: none;
      cursor: pointer;
      font-weight: 900;
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
      background: #fff;
      border: 1px solid rgba(0, 0, 0, .28);
      color: #222;
      margin-top: 8px;
    }

    .alert {
      display: none;
      padding: 10px 12px;
      border-radius: 10px;
      margin-bottom: 12px;
      font-size: 14px;
    }

    .alert-danger {
      background: #ffecec;
      border: 1px solid #ffc2c2;
      color: #a40000;
    }
  </style>
</head>

<body>
  <div class="card">
    <div class="card-body">

      <h1>ยินดีต้อนรับระบบประเมินการสอน</h1>
      <div class="sub">กรุณาเข้าสู่ระบบ</div>

      <div id="alertError" class="alert alert-danger"></div>

      <form id="loginForm" method="POST" action="{{ secure_url('/login') }}">
        @csrf

        {{-- เลือก role --}}
        <div class="radio-wrap">
          <label class="radio-pill">
            <input type="radio" name="role" value="student" checked>
            นักเรียน
          </label>
          <label class="radio-pill">
            <input type="radio" name="role" value="teacher">
            ครู/อาจารย์
          </label>
        </div>

        <div class="row">
          <input class="input" type="text" name="username" placeholder="Username">
        </div>

        <div class="row" style="position:relative;">
          <input class="input"
            type="password"
            name="password"
            id="passwordInput"
            placeholder="Password">

          <span id="togglePassword" style="
      position:absolute;
      right:12px;
      top:50%;
      transform:translateY(-50%);
      cursor:pointer;
      font-size:18px;
      color:#666;">
            👁
          </span>
        </div>


        <button class="btn btn-primary" type="submit" id="submitBtn">เข้าสู่ระบบ</button>

        <a class="btn btn-outline" href="{{ url('/register') }}" style="display:flex;align-items:center;justify-content:center;text-decoration:none;">
          สมัครสมาชิก
        </a>
      </form>

    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script>
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    const toggle = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('passwordInput');

    toggle.addEventListener('click', function() {
      const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
      passwordInput.setAttribute('type', type);
      this.textContent = type === 'password' ? '👁' : '🙈';
    });

    function showError(msg) {
      const $el = $('#alertError');
      $el.text(msg || 'เกิดข้อผิดพลาด');
      $el.show(); // เพราะ .alert ของคุณตั้ง display:none ไว้
    }

    function clearError() {
      $('#alertError').hide().text('');
    }

    $('#loginForm').on('submit', function(e) {
      e.preventDefault();
      clearError();

      const role = $('input[name="role"]:checked').val();
      const url = (role === 'teacher') ?
        "{{ secure_url('/backend/auth/login/teacher') }}" :
        "{{ secure_url('/backend/auth/login/student') }}";

      $.post(url, $(this).serialize())
        .done(function(res) {
          // รองรับทั้งกรณี success=true และกรณี data.redirect มีจริง
          const redirect = res?.data?.redirect || res?.redirect;
          if (redirect) return window.location.href = redirect;

          // ถ้า server ส่ง success:false กลับมาทาง 200 ก็โชว์ message
          if (res?.success === false) return showError(res?.message);

          showError(res?.message || 'เข้าสู่ระบบไม่สำเร็จ');
        })
        .fail(function(xhr) {
          // พยายามดึงข้อความ error ให้ครอบคลุมหลายรูปแบบ
          const json = xhr.responseJSON || {};
          let msg = '';

          if (xhr.status === 422 && json.errors) {
            msg = Object.values(json.errors)?.[0]?.[0] || 'ข้อมูลไม่ถูกต้อง';
          } else {
            msg = json.message || json.error || xhr.statusText || 'เกิดข้อผิดพลาด';
          }

          showError(msg);
        });
    });
  </script>

</body>

</html>