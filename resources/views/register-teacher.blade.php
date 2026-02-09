<!doctype html>
<html lang="th">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>สมัครอาจารย์</title>

  <meta name="csrf-token" content="{{ csrf_token() }}">

  <style>
    :root {
      --primary: #2f66ff;
      --primary2: #2457e8;
      --card: #ffffff;
      --muted: rgba(0, 0, 0, .55);
      --border: rgba(0, 0, 0, .10);
      --danger: #ff6b6b;
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
      letter-spacing: .2px;
      font-weight: 900;
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
      background: #fff;
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
      font-weight: 900;
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
      border-color: var(--danger) !important;
      box-shadow: 0 0 0 3px rgba(255, 107, 107, .15);
    }

    .small-error {
      color: #d40000;
      font-size: 12px;
      margin-top: 6px;
    }

    .section-title {
      margin: 14px 0 10px;
      font-weight: 900;
      font-size: 14px;
      color: #222;
    }

    .subjects {
      border: 1px solid rgba(0, 0, 0, .10);
      border-radius: 12px;
      overflow: hidden;
      background: #fff;
    }

    .subject-row {
      display: grid;
      grid-template-columns: 1fr 170px 120px 86px;
      gap: 10px;
      padding: 12px;
      border-bottom: 1px solid rgba(0, 0, 0, .08);
      align-items: start;
    }

    .subject-row:last-child {
      border-bottom: none;
    }

    .mini-btn {
      height: 44px;
      border-radius: 8px;
      border: none;
      cursor: pointer;
      font-weight: 900;
      padding: 0 10px;
      font-size: 13px;
      white-space: nowrap;
    }

    .mini-btn-danger {
      background: #ffd9de;
      color: #8b0a1a;
      border: 1px solid #ffb2bc;
    }

    .mini-btn-danger:hover {
      filter: brightness(.98);
    }

    .add-area {
      margin-top: 10px;
    }

    .add-btn {
      width: 100%;
      height: 40px;
      border-radius: 8px;
      border: 1px solid rgba(0, 0, 0, .25);
      background: #fff;
      font-weight: 900;
      cursor: pointer;
    }

    .add-btn:hover {
      background: rgba(255, 255, 255, .7);
    }

    @media (max-width: 720px) {
      .subject-row {
        grid-template-columns: 1fr;
      }

      .mini-btn {
        width: 100%;
      }
    }
  </style>
</head>

<body>
  <div class="card">
    <div class="card-body">

      <div class="center">
        <h1>สมัครอาจารย์</h1>
      </div>

      <div id="alertSuccess" class="alert alert-success"></div>
      <div id="alertError" class="alert alert-danger"></div>

      <form id="teacherForm" method="POST" action="{{ url('/backend/create/teacher') }}" novalidate>
        @csrf

        <div class="form-group">
          <input class="input" type="text" name="teacher_code" placeholder="รหัสอาจารย์">
          <div class="small-error" data-error="teacher_code"></div>
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

        <div class="section-title">รายวิชาที่สอน</div>

        <div id="subjectsBox" class="subjects">
          {{-- แถวเริ่มต้น 1 แถว --}}
          <div class="subject-row" data-index="0">
            <div>
              <input class="input" type="text" name="subjects[0][subject_name]" placeholder="ชื่อรายวิชา">
              <div class="small-error" data-error="subjects.0.subject_name"></div>
            </div>

            <div>
              <select class="select" name="subjects[0][department]">
                <option value="">สาขา</option>
                <option value="เทคโนโลยีสารสนเทศ (ทส.)">เทคโนโลยีสารสนเทศ (ทส.)</option>
                <option value="คอมพิวเตอร์ธุรกิจ">คอมพิวเตอร์ธุรกิจ</option>
                <option value="ช่างไฟฟ้า">ช่างไฟฟ้า</option>
              </select>
              <div class="small-error" data-error="subjects.0.department"></div>
            </div>

            <div>
              <select class="select" name="subjects[0][classroom]">
                <option value="">ชั้น</option>
                <option value="ปวช.1/1">ปวช.1/1</option>
                <option value="ปวช.2/1">ปวช.2/1</option>
                <option value="ปวช.3/1">ปวช.3/1</option>
                <option value="ปวส.1/1">ปวส.1/1</option>
              </select>
              <div class="small-error" data-error="subjects.0.classroom"></div>
            </div>

            <div>
              <button class="mini-btn mini-btn-danger btn-remove" type="button" disabled>ลบ</button>
            </div>
          </div>
        </div>

        <div class="add-area">
          <button id="addSubjectBtn" class="add-btn" type="button">+ เพิ่มรายวิชา</button>
        </div>

        <button class="btn btn-primary" type="submit" id="submitBtn" style="margin-top:14px;">
          สมัครอาจารย์
        </button>
        <button class="btn btn-outline" type="button" onclick="history.back()">ย้อนกลับ</button>
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

    function clearErrors() {
      $('#alertError').hide().text('');
      $('#alertSuccess').hide().text('');
      $('[data-error]').text('');
      $('.input, .select').removeClass('field-error');
    }

    function setFieldError(field, message) {
      // field อาจมาเป็น subjects.0.subject_name
      const nameSelector =
        field.startsWith('subjects.') ?
        null :
        `[name="${field}"]`;

      if (nameSelector) $(nameSelector).addClass('field-error');

      // หา error box ที่ data-error ตรง
      $(`[data-error="${field}"]`).text(message);

      // ไฮไลท์ input/select ของ subjects ด้วย
      if (field.startsWith('subjects.')) {
        const parts = field.split('.');
        // subjects, index, key
        const idx = parts[1];
        const key = parts[2];
        $(`[name="subjects[${idx}][${key}]"]`).addClass('field-error');
      }
    }

    function refreshRemoveButtons() {
      const count = $('#subjectsBox .subject-row').length;
      $('#subjectsBox .btn-remove').prop('disabled', count <= 1);
    }

    // เพิ่มแถววิชา
    $('#addSubjectBtn').on('click', function() {
      const $rows = $('#subjectsBox .subject-row');
      const nextIndex = $rows.length;

      const rowHtml = `
        <div class="subject-row" data-index="${nextIndex}">
          <div>
            <input class="input" type="text" name="subjects[${nextIndex}][subject_name]" placeholder="ชื่อรายวิชา">
            <div class="small-error" data-error="subjects.${nextIndex}.subject_name"></div>
          </div>

          <div>
            <select class="select" name="subjects[${nextIndex}][department]">
              <option value="">สาขา</option>
              <option value="เทคโนโลยีสารสนเทศ (ทส.)">เทคโนโลยีสารสนเทศ (ทส.)</option>
              <option value="คอมพิวเตอร์ธุรกิจ">คอมพิวเตอร์ธุรกิจ</option>
              <option value="ช่างไฟฟ้า">ช่างไฟฟ้า</option>
            </select>
            <div class="small-error" data-error="subjects.${nextIndex}.department"></div>
          </div>

          <div>
            <select class="select" name="subjects[${nextIndex}][classroom]">
              <option value="">ชั้น</option>
              <option value="ปวช.1/1">ปวช.1/1</option>
              <option value="ปวช.2/1">ปวช.2/1</option>
              <option value="ปวช.3/1">ปวช.3/1</option>
              <option value="ปวส.1/1">ปวส.1/1</option>
            </select>
            <div class="small-error" data-error="subjects.${nextIndex}.classroom"></div>
          </div>

          <div>
            <button class="mini-btn mini-btn-danger btn-remove" type="button">ลบ</button>
          </div>
        </div>
      `;

      $('#subjectsBox').append(rowHtml);
      refreshRemoveButtons();
    });

    // ลบแถววิชา
    $(document).on('click', '.btn-remove', function() {
      if ($(this).prop('disabled')) return;
      $(this).closest('.subject-row').remove();

      // re-index ชื่อ fields หลังลบ เพื่อให้ validate กลับมาเป็น subjects.0,1,2...
      const $rows = $('#subjectsBox .subject-row');
      $rows.each(function(i) {
        $(this).attr('data-index', i);

        $(this).find('[name^="subjects["]').each(function() {
          const name = $(this).attr('name'); // subjects[2][subject_name]
          const newName = name.replace(/subjects\[\d+\]/, `subjects[${i}]`);
          $(this).attr('name', newName);
        });

        // error box ก็ต้องเปลี่ยน index ด้วย
        $(this).find('[data-error^="subjects."]').each(function() {
          const key = $(this).attr('data-error').split('.').pop(); // subject_name / department / classroom
          $(this).attr('data-error', `subjects.${i}.${key}`).text('');
        });
      });

      refreshRemoveButtons();
    });

    // submit ajax
    $('#teacherForm').on('submit', function(e) {
      e.preventDefault();
      clearErrors();

      const $btn = $('#submitBtn');
      $btn.prop('disabled', true).text('กำลังสมัคร...');

      $.ajax({
        url: $(this).attr('action'),
        method: 'POST',
        data: $(this).serialize(),
        dataType: 'json',
        success: function(res) {
          // บังคับเช็ค success ก่อน
          if (res && res.success === false) {
            $('#alertError').text(res.message || 'เกิดข้อผิดพลาด').show();
            return;
          }

          $('#alertSuccess').text(res.message || 'บันทึกสำเร็จ').show();
          $('#teacherForm')[0].reset();

          // เคลียร์เหลือแถวเดียว
          $('#subjectsBox .subject-row').not(':first').remove();
          refreshRemoveButtons();
        },
        error: function(xhr) {
          // validation error
          if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
            const errors = xhr.responseJSON.errors;
            Object.keys(errors).forEach((field) => {
              setFieldError(field, errors[field][0]);
            });
            $('#alertError').text('กรุณาตรวจสอบข้อมูลให้ถูกต้อง').show();
          } else {
            const msg = (xhr.responseJSON && (xhr.responseJSON.message || xhr.responseJSON.error)) ?
              (xhr.responseJSON.message || xhr.responseJSON.error) :
              'เกิดข้อผิดพลาด กรุณาลองใหม่';
            $('#alertError').text(msg).show();
          }
        },
        complete: function() {
          $btn.prop('disabled', false).text('สมัครอาจารย์');
        }
      });
    });

    refreshRemoveButtons();
  </script>
</body>

</html>