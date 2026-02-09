<!doctype html>
<html lang="th">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>สมัครนักเรียน</title>

  <style>
    :root {
      --primary: #2f66ff;
      --primary2: #2457e8;
      --card: #ffffff;
      --muted: rgba(0, 0, 0, .55);
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
      max-width: 560px;
      background: var(--card);
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

    h1 {
      margin: 10px 0 18px;
      font-size: 22px;
      color: var(--primary2);
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

    .form-group {
      margin-bottom: 10px;
    }

    .input,
    .select {
      width: 100%;
      height: 44px;
      border-radius: 8px;
      border: 1px solid rgba(0, 0, 0, .18);
      padding: 0 12px;
      outline: none;
      font-size: 14px;
      box-sizing: border-box;
    }

    .hint {
      font-size: 12px;
      color: var(--muted);
      margin-top: 6px;
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
      background: #fff;
      border: 1px solid rgba(0, 0, 0, .28);
      color: #222;
      margin-top: 8px;
    }

    .field-error {
      border-color: #ff6b6b !important;
      box-shadow: 0 0 0 3px rgba(255, 107, 107, .15);
    }

    .small-error {
      color: #d40000;
      font-size: 12px;
      margin-top: 6px;
    }
  </style>

  {{-- CSRF สำหรับ AJAX --}}
  <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
  <div class="card">
    <div class="card-body">
      <div class="center">
        <h1>สมัครนักเรียน</h1>
      </div>

      {{-- กล่องแจ้งผล --}}
      <div id="alertSuccess" class="alert alert-success"></div>
      <div id="alertError" class="alert alert-danger"></div>

      <form id="registerForm" method="POST" action="{{ secure_url('/backend/create/student') }}" novalidate>
        @csrf

        <div class="form-group">
          <input class="input" type="text" name="student_code" placeholder="รหัสนักศึกษา">
          <div class="small-error" data-error="student_code"></div>
        </div>

        <div class="form-group">
          <input class="input" type="password" name="password" placeholder="รหัสผ่าน">
          <div class="hint">อย่างน้อย 6 ตัวอักษร</div>
          <div class="small-error" data-error="password"></div>
        </div>

        <div class="form-group">
          <input class="input" type="text" name="fullname" placeholder="ชื่อ-สกุล">
          <div class="small-error" data-error="fullname"></div>
        </div>

        <div class="form-group">
          <select class="select" name="department">
            <option value="">สาขา : เลือกสาขา</option>
            <option value="เทคโนโลยีสารสนเทศ (ทส.)">สาขา : เทคโนโลยีสารสนเทศ (ทส.)</option>
            <option value="คอมพิวเตอร์ธุรกิจ">สาขา : คอมพิวเตอร์ธุรกิจ</option>
            <option value="ช่างไฟฟ้า">สาขา : ช่างไฟฟ้า</option>
          </select>
          <div class="small-error" data-error="department"></div>
        </div>

        <div class="form-group" style="margin-bottom:14px;">
          <select class="select" name="classroom">
            <option value="">ชั้น : เลือกชั้น</option>
            <option value="ปวช.1/1">ชั้น : ปวช.1/1</option>
            <option value="ปวช.2/1">ชั้น : ปวช.2/1</option>
            <option value="ปวช.3/1">ชั้น : ปวช.3/1</option>
            <option value="ปวส.1/1">ชั้น : ปวส.1/1</option>
          </select>
          <div class="small-error" data-error="classroom"></div>
        </div>

        <button class="btn btn-primary" type="submit" id="submitBtn">สมัครนักเรียน</button>
        <button class="btn btn-outline" type="button" onclick="history.back()">ย้อนกลับ</button>
      </form>
    </div>
  </div>

  {{-- jQuery --}}
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

  <script>
    // ตั้งค่า CSRF ให้ jQuery
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    function clearErrors() {
      $('#alertError').hide().text('');
      $('#alertSuccess').hide().text('');
      $('[data-error]').text('');
      $('.input, .select').removeClass('field-error');
    }

    function setFieldError(field, message) {
      $(`[name="${field}"]`).addClass('field-error');
      $(`[data-error="${field}"]`).text(message);
    }

    $('#registerForm').on('submit', function(e) {
      e.preventDefault();
      clearErrors();

      const $btn = $('#submitBtn');
      $btn.prop('disabled', true).text('กำลังสมัคร...');

      const url = $(this).attr('action');
      const data = $(this).serialize(); // ส่ง form data ทั้งหมด

      $.ajax({
        url: url,
        method: 'POST',
        data: data,
        dataType: 'json',
        success: function(res) {
          if (res && res.success === false) {
            $('#alertError').text('เกิดข้อผิดพลาด').show();
            return;
          }
          $('#alertSuccess').text(res.message || 'บันทึกสำเร็จ').show();
          $('#registerForm')[0].reset();
        },
        error: function(xhr) {
          // Laravel validation error = 422
          if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
            const errors = xhr.responseJSON.errors;
            Object.keys(errors).forEach((field) => {
              setFieldError(field, errors[field][0]);
            });
            $('#alertError').text('กรุณาตรวจสอบข้อมูลให้ถูกต้อง').show();
          } else {
            // กรณี backend ส่ง JsonResult::errors
            const msg = (xhr.responseJSON && (xhr.responseJSON.message || xhr.responseJSON.error)) ?
              (xhr.responseJSON.message || xhr.responseJSON.error) :
              'เกิดข้อผิดพลาด กรุณาลองใหม่';
            $('#alertError').text(msg).show();
          }
        },
        complete: function() {
          $btn.prop('disabled', false).text('สมัครนักเรียน');
        }
      });
    });
  </script>
</body>

</html>