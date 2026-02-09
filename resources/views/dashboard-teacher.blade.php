<!doctype html>
<html lang="th">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard ครู</title>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

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
            max-width: 1000px;
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 18px 35px rgba(0, 0, 0, .18);
            border: 1px solid var(--border);
            overflow: hidden;
        }

        .card-body {
            padding: 28px;
        }

        .top {
            text-align: center;
            margin-bottom: 12px;
        }

        h1 {
            margin: 0;
            font-size: 22px;
            font-weight: 900;
            color: #1f4fd8;
        }

        .sub {
            margin-top: 4px;
            font-size: 13px;
            color: var(--muted);
            font-weight: 700;
        }

        .divider {
            height: 1px;
            background: rgba(0, 0, 0, .12);
            margin: 16px 0;
        }

        .kpi {
            border: 1px solid rgba(0, 0, 0, .10);
            border-radius: 12px;
            padding: 14px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .kpi-title {
            font-weight: 900;
            font-size: 14px;
        }

        .kpi-value {
            font-weight: 1000;
            font-size: 28px;
        }

        .panel {
            border: 1px solid rgba(0, 0, 0, .10);
            border-radius: 12px;
            margin-top: 16px;
        }

        .panel-header {
            padding: 12px 14px;
            border-bottom: 1px solid rgba(0, 0, 0, .08);
            font-weight: 900;
            font-size: 14px;
        }

        .panel-body {
            padding: 14px;
        }

        .chart-box {
            height: 520px;
        }

        .bottom {
            margin-top: 16px;
        }

        .btn-danger {
            width: 100%;
            height: 42px;
            background: #c63a4a;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-weight: 900;
            cursor: pointer;
            font-size: 14px;
        }

        .btn-danger:hover {
            background: #b12f3f;
        }

        canvas {
            width: 100% !important;
            height: 100% !important;
        }
    </style>
</head>

<body>
    <div class="card">
        <div class="card-body">

            <div class="top">
                <h1>ผลประเมินการสอน</h1>
                <div class="sub">อาจารย์: {{ $teacher->fullname ?? '-' }}</div>
            </div>

            <div class="kpi">
                <div class="kpi-title">จำนวนผู้ประเมิน</div>
                <div class="kpi-value">
                    {{ $score_lists['count'] ?? 0 }}
                </div>
            </div>

            <div class="divider"></div>

            <div class="panel">
                <div class="panel-header">
                    คะแนนเฉลี่ย 15 หัวข้อ (เต็ม 5)
                </div>
                <div class="panel-body">
                    <div class="chart-box">
                        <canvas id="chart15"></canvas>
                    </div>
                </div>
            </div>
            <div class="bottom">
                <form method="POST" action="{{ url('/backend/auth/logout') }}">
                    @csrf
                    <button type="submit" class="btn-danger">
                        ออกจากระบบ
                    </button>
                </form>
            </div>

        </div>
    </div>

    <script>
        const scoreData = @json($score_lists['items'] ?? []);

        const labels = scoreData.map(item => item.q);
        const values = scoreData.map(item => item.avg);

        new Chart(document.getElementById('chart15'), {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'คะแนนเฉลี่ย',
                    data: values,
                    borderWidth: 1,
                    borderRadius: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                indexAxis: 'y',
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    x: {
                        min: 1,
                        max: 5,
                        ticks: {
                            color: 'rgba(0,0,0,.6)',
                            font: {
                                weight: '700'
                            }
                        },
                        grid: {
                            color: 'rgba(0,0,0,.08)'
                        }
                    },
                    y: {
                        ticks: {
                            color: '#222',
                            font: {
                                weight: '800'
                            }
                        },
                        grid: {
                            color: 'rgba(0,0,0,.05)'
                        }
                    }
                }
            }
        });
    </script>

</body>

</html>