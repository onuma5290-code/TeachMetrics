<!doctype html>
<html lang="th">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>แบบประเมินการสอน</title>

  <style>
    :root {
      --primary: #2f66ff;
      --primary2: #2457e8;
      --card: #ffffff;
      --muted: rgba(0, 0, 0, .55);
      --border: rgba(0, 0, 0, .10);
      --ring: rgba(47, 102, 255, .18);
    }

    body {
      margin: 0;
      min-height: 100vh;
      font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Noto Sans Thai", sans-serif;
      background: radial-gradient(circle at 30% 20%, #b7cdfc 0%, #6e93ff 35%, #4c7df3 60%, #3b67dd 100%);
      display: flex;
      align-items: flex-start;
      justify-content: center;
      padding: 28px 18px;
    }

    .card {
      width: 100%;
      max-width: 880px;
      background: var(--card);
      border-radius: 14px;
      box-shadow: 0 18px 35px rgba(0, 0, 0, .18);
      border: 1px solid var(--border);
      overflow: hidden;
    }

    .card-body {
      padding: 26px 26px 22px;
    }

    .center {
      text-align: center;
    }

    h1 {
      margin: 10px 0 6px;
      font-size: 22px;
      color: var(--primary2);
      letter-spacing: .2px;
      font-weight: 900;
    }

    .sub {
      margin: 0 0 16px;
      color: var(--muted);
      font-size: 13px;
    }

    .meta {
      margin: 10px 0 18px;
      padding: 12px 14px;
      border: 1px solid rgba(0, 0, 0, .08);
      border-radius: 12px;
      background: #fff;
      font-size: 14px;
      color: #222;
    }

    .meta b {
      color: #111;
    }

    .alert {
      border-radius: 10px;
      padding: 10px 12px;
      margin: 0 0 12px;
      font-size: 14px;
    }

    .alert-danger {
      background: #ffecec;
      border: 1px solid #ffc2c2;
      color: #a40000;
    }

    .q {
      padding: 12px 0 14px;
      border-top: 1px solid rgba(0, 0, 0, .06);
    }

    .q:first-of-type {
      border-top: none;
      padding-top: 6px;
    }

    .q-title {
      font-size: 15px;
      font-weight: 800;
      color: #222;
      margin-bottom: 10px;
      line-height: 1.35;
    }

    .scale {
      display: flex;
      gap: 10px;
      flex-wrap: wrap;
      align-items: center;
      position: relative;
    }

    /* ✅ สำคัญ: ห้าม display:none เพราะ required จะ focus ไม่ได้
       ใช้วิธีซ่อนแบบยังโฟกัสได้แทน */
    .scale input {
      position: absolute;
      opacity: 0;
      width: 1px;
      height: 1px;
      margin: 0;
      padding: 0;
      pointer-events: none;
    }

    .bubble {
      width: 34px;
      height: 34px;
      border-radius: 50%;
      border: 2px solid var(--primary);
      display: inline-flex;
      align-items: center;
      justify-content: center;
      font-weight: 900;
      font-size: 13px;
      color: var(--primary);
      cursor: pointer;
      user-select: none;
      transition: all .12s ease;
    }

    .bubble:hover {
      box-shadow: 0 0 0 4px var(--ring);
      transform: translateY(-1px);
    }

    .scale input:checked+.bubble {
      background: var(--primary);
      color: #fff;
      box-shadow: 0 0 0 4px var(--ring);
    }

    textarea {
      width: 100%;
      min-height: 90px;
      border-radius: 12px;
      border: 1px solid rgba(0, 0, 0, .18);
      padding: 10px 12px;
      font-size: 14px;
      box-sizing: border-box;
      outline: none;
      resize: vertical;
    }

    .actions {
      margin-top: 18px;
      display: flex;
      gap: 10px;
      flex-direction: column;
    }

    .btn {
      width: 100%;
      height: 44px;
      border-radius: 10px;
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
    }

    .btn-outline:hover {
      background: rgba(255, 255, 255, .75);
    }

    @media (max-width:520px) {
      .card-body {
        padding: 20px 16px 18px;
      }

      .bubble {
        width: 32px;
        height: 32px;
      }
    }
  </style>
</head>

<body>
  <div class="card">
    <div class="card-body">

      <div class="center">
        <h1>แบบประเมินการสอน</h1>
        <p class="sub">กรุณาเลือกคะแนน 1–5 ให้ครบทุกข้อ</p>
      </div>

      <div class="meta">
        <div><b>รายวิชา:</b> {{ $subject->subject_name }}</div>
        <div><b>อาจารย์:</b> {{ $subject->teacher->fullname ?? '-' }}</div>
        <div style="margin-top:6px;color:rgba(0,0,0,.6);font-size:13px;">
          ผู้ประเมิน: {{ $student->fullname ?? '-' }} ({{ $student->classroom ?? '-' }})
        </div>
      </div>

      @if ($errors->any())
      <div class="alert alert-danger">
        <ul style="margin:0; padding-left:18px;">
          @foreach ($errors->all() as $err)
          <li>{{ $err }}</li>
          @endforeach
        </ul>
      </div>
      @endif

      <form method="POST" action="{{ url('/evaluate/' . $subject->subject_id) }}" id="evaluateForm" novalidate>
        @csrf

        @php
        $questions = [
        1 => 'อาจารย์เตรียมการสอนมาเป็นอย่างดี',
        2 => 'อาจารย์อธิบายเนื้อหาได้ชัดเจนและเข้าใจง่าย',
        3 => 'อาจารย์สอนตรงตามแผนการสอนที่กำหนดไว้',
        4 => 'เนื้อหาที่สอนมีความเหมาะสมกับระดับผู้เรียน',
        5 => 'เนื้อหามีความทันสมัยและสอดคล้องกับสถานการณ์ปัจจุบัน',
        6 => 'อาจารย์เชื่อมโยงเนื้อหากับการนำไปใช้งานจริงได้ดี',
        7 => 'อาจารย์ใช้สื่อการสอนได้อย่างเหมาะสม',
        8 => 'สื่อการสอนช่วยให้นักเรียนเข้าใจบทเรียนได้ดียิ่งขึ้น',
        9 => 'อาจารย์กระตุ้นให้นักเรียนมีส่วนร่วมในการเรียนการสอน',
        10 => 'อาจารย์เปิดโอกาสให้นักเรียนซักถามและแสดงความคิดเห็น',
        11 => 'บรรยากาศในการเรียนการสอนเป็นกันเองและน่าเรียน',
        12 => 'อาจารย์ตรงต่อเวลาในการสอน',
        13 => 'อาจารย์มีความรับผิดชอบต่อหน้าที่การสอน',
        14 => 'อาจารย์ปฏิบัติต่อนักเรียนอย่างเป็นธรรมและให้เกียรติ',
        15 => 'ความพึงพอใจโดยรวมต่อการเรียนการสอนของอาจารย์',
        ];
        @endphp

        @foreach($questions as $no => $text)
        <div class="q">
          <div class="q-title">{{ $no }}. {{ $text }}</div>

          <div class="scale" role="radiogroup" aria-label="question-{{ $no }}">
            @for($score=1; $score<=5; $score++)
              @php
              $name="question_{$no}" ;
              $id="question_{$no}_{$score}" ;
              @endphp

              <input
              type="radio"
              name="{{ $name }}"
              id="{{ $id }}"
              value="{{ $score }}"
              {{-- ✅ required ใส่แค่ตัวแรกของกลุ่มพอ --}}
              @if($score===1) required @endif
              @checked(old($name)==(string)$score)>
              <label class="bubble" for="{{ $id }}">{{ $score }}</label>
              @endfor
          </div>
        </div>
        @endforeach

        <div class="q">
          <div class="q-title">หมายเหตุเพิ่มเติม (ถ้ามี)</div>
          <textarea name="evaluation_note" maxlength="255" placeholder="พิมพ์ข้อเสนอแนะ...">{{ old('evaluation_note') }}</textarea>
          <div style="margin-top:6px;color:rgba(0,0,0,.55);font-size:12px;">ไม่เกิน 255 ตัวอักษร</div>
        </div>

        <div class="actions">
          <button type="submit" class="btn btn-primary" id="submitBtn">ส่งแบบประเมิน</button>
          <button type="button" class="btn btn-outline" onclick="history.back()">ย้อนกลับ</button>
        </div>
      </form>

    </div>
  </div>

  <script>
    const form = document.getElementById('evaluateForm');
    const btn = document.getElementById('submitBtn');

    form.addEventListener('submit', (e) => {
      // ใช้ checkValidity ได้ เพราะ input ไม่ถูก display:none แล้ว
      if (!form.checkValidity()) {
        e.preventDefault();
        alert('กรุณาเลือกคะแนนให้ครบทุกข้อ');
        return;
      }
      btn.disabled = true;
      btn.textContent = 'กำลังส่ง...';
    });
  </script>
</body>

</html> 