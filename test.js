
            document.addEventListener('DOMContentLoaded', function() {
                // Data anak & perkembangan dari Laravel dijadikan object JS
                const childrenArray = [];
                const childrenMap = {};
                childrenArray.forEach(function(c) {
                    childrenMap[String(c.id)] = c;
                });

                const selectDropdown = document.getElementById('chart_child_id');
                const emptyState = document.getElementById('chart-empty-state');
                const noDataState = document.getElementById('chart-no-data-state');
                const chartContainer = document.getElementById('chart-container');
                const latestNoteText = document.getElementById('latest-note');
                const latestNoteDate = document.getElementById('latest-note-date');

                let myChart = null;
                let radarChartInst = null;
                let barChartInst = null;
                let lineChartPBTInst = null;

                selectDropdown.addEventListener('change', function() {
                    const childId = String(this.value);
                    const child = childrenMap[childId];

                    if (!child) return;

                    // Info anak
                    document.getElementById('student-class').textContent = child.swimming_class ?
                        `${child.swimming_class.name} (${child.swimming_class.category.name})` :
                        'Belum Ditentukan';
                    document.getElementById('student-coach').textContent = child.coach ? child.coach.name :
                        'Belum Ditugaskan';

                    let locText = child.location ? child.location.name : 'Belum Dipilih';
                    if (child.secondary_location) {
                        locText += ` & ${child.secondary_location.name}`;
                    }
                    document.getElementById('student-location').textContent = locText;
                    document.getElementById('student-quota').textContent = `${child.quota_left} sesi`;

                    // Update schedules
                    const schedulesContainer = document.getElementById('student-schedule-container');
                    const schedulesDiv = document.getElementById('student-schedules');
                    schedulesDiv.innerHTML = '';

                    if (child.schedules && child.schedules.length > 0) {
                        schedulesContainer.classList.remove('hidden');
                        const days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
                        child.schedules.forEach(sched => {
                            const dayName = days[sched.day_of_week] || 'Hari Tidak Valid';
                            const timeRange = `${sched.start_time.substring(0, 5)} - ${sched.end_time.substring(0, 5)}`;
                            const locName = sched.location ? sched.location.name : 'Lokasi tidak diketahui';
                            const type = sched.session_type === 'dryland' ? 'Dryland' : 'Berenang';

                            const div = document.createElement('div');
                            div.className = 'bg-white border border-gray-100 rounded p-1.5 text-[11px] font-semibold text-gray-700 shadow-sm flex flex-col gap-0.5';
                            div.innerHTML = `
                                <div class="flex justify-between items-center">
                                    <span class="text-blue-700 font-bold">${dayName}, ${timeRange}</span>
                                    <span class="px-1 py-0.2 text-[9px] bg-blue-50 text-blue-600 rounded">${type}</span>
                                </div>
                                <div class="text-[10px] text-gray-500 flex items-center gap-1">
                                    <i class="fa-solid fa-location-dot"></i> ${locName}
                                </div>
                            `;
                            schedulesDiv.appendChild(div);
                        });
                    } else {
                        schedulesContainer.classList.add('hidden');
                    }

                    // Update pending schedule-change-request info
                    const pendingBox       = document.getElementById('student-pending-schedule-request');
                    const pendingListDiv   = document.getElementById('pending-schedules-list');
                    const pendingDateEl    = document.getElementById('pending-request-date');
                    const changeWrapper    = document.getElementById('student-schedule-change-wrapper');

                    // Cari request pending dari anak yang dipilih
                    const pendingReq = child.schedule_change_requests && child.schedule_change_requests.find(r => r.status === 'pending');

                    if (pendingReq) {
                        pendingBox.classList.remove('hidden');
                        changeWrapper.classList.add('hidden'); // Sembunyikan tombol saat ada pending
                        pendingListDiv.innerHTML = '';

                        const newIds = pendingReq.new_schedule_ids || [];
                        const allSchedules = [];
                        const days = ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'];

                        newIds.forEach(sid => {
                            const s = allSchedules.find(x => x.id == sid);
                            if (s) {
                                const dayName  = days[s.day_of_week] || 'Hari ?';
                                const timeRange = `${s.start_time.substring(0,5)} - ${s.end_time.substring(0,5)}`;
                                const locName  = s.location ? s.location.name : 'Lokasi ?';
                                const type     = s.session_type === 'dryland' ? 'Dryland' : 'Berenang';
                                const el = document.createElement('div');
                                el.className = 'bg-white border border-amber-100 rounded p-1.5 text-[11px] font-semibold text-gray-700 shadow-sm flex flex-col gap-0.5';
                                el.innerHTML = `<div class="flex justify-between items-center"><span class="text-amber-700 font-bold">${dayName}, ${timeRange}</span><span class="px-1 py-0.2 text-[9px] bg-amber-50 text-amber-600 rounded">${type}</span></div><div class="text-[10px] text-gray-500 flex items-center gap-1"><i class="fa-solid fa-location-dot"></i> ${locName}</div>`;
                                pendingListDiv.appendChild(el);
                            }
                        });

                        const reqDate = new Date(pendingReq.created_at);
                        pendingDateEl.textContent = `Diajukan: ${reqDate.toLocaleDateString('id-ID', { day:'numeric', month:'long', year:'numeric' })}`;
                    } else {
                        pendingBox.classList.add('hidden');
                        changeWrapper.classList.remove('hidden');
                    }

                    // Simpan child id aktif untuk modal
                    window.activeChildId = childId;

                    const reports = child.progress_reports || [];
                    const freetextContainer = document.getElementById('freetext-container');
                    const prestasiContainer = document.getElementById('prestasi-charts-container');

                    // Hancurkan chart lama jika ada
                    if (radarChartInst) radarChartInst.destroy();
                    if (barChartInst) barChartInst.destroy();
                    if (lineChartPBTInst) lineChartPBTInst.destroy();

                    // Cek apakah data ini adalah kelas Prestasi (memiliki Kondisi Fisik)
                    // Kita cek dari report terakhir
                    const latestReport = reports.length > 0 ? reports[reports.length - 1] : null;
                    const isPrestasi = latestReport && latestReport.metrics && ('Kondisi Fisik' in latestReport.metrics);

                    if (isPrestasi) {
                        if (freetextContainer) freetextContainer.classList.add('hidden');
                        if (prestasiContainer) prestasiContainer.classList.remove('hidden');
                        prestasiContainer.style.display = 'flex';

                        // --- 1. Siapkan Data ---
                        const labels = [];
                        const radarData = { Endurance: [], Fleksibilitas: [], Strength: [], Speed: [], Agility: [] };
                        const barData = { Aerobic: [], Anaerobic: [] };
                        const pbtData = { TestPerBulan: [], PbtEvent: [] };

                        // Fungsi helper ubah "01:25.50" jadi detik "85.5"
                        function parseTimeToSeconds(timeStr) {
                            if (!timeStr) return null;
                            const match = timeStr.match(/(?:(\d+):)?(\d+)[.,:](\d+)/);
                            if (match) {
                                const m = parseInt(match[1] || 0);
                                const s = parseInt(match[2] || 0);
                                const ms = parseInt(match[3] || 0);
                                // ms bisa 2 digit (50 = 500ms)
                                const msVal = ms < 100 ? ms * 10 : ms; 
                                return m * 60 + s + (msVal / 1000);
                            }
                            return null;
                        }

                        // Fungsi format balik dari detik ke "MM:SS.ms"
                        function formatSecondsToTime(totalSeconds) {
                            if (totalSeconds == null) return "-";
                            const m = Math.floor(totalSeconds / 60);
                            const s = Math.floor(totalSeconds % 60);
                            const ms = Math.round((totalSeconds - Math.floor(totalSeconds)) * 100);
                            return `${m.toString().padStart(2, '0')}:${s.toString().padStart(2, '0')}.${ms.toString().padStart(2, '0')}`;
                        }

                        reports.forEach(report => {
                            const d = new Date(report.date);
                            labels.push(d.toLocaleDateString('id-ID', { month: 'short', year: '2-digit' }));

                            if (report.metrics) {
                                // Radar (Kondisi Fisik)
                                const kf = report.metrics['Kondisi Fisik'] || {};
                                radarData.Endurance.push(kf['Endurance'] || 0);
                                radarData.Fleksibilitas.push(kf['Fleksibilitas'] || 0);
                                radarData.Strength.push(kf['Strength'] || 0);
                                radarData.Speed.push(kf['Speed'] || 0);
                                radarData.Agility.push(kf['Agility'] || 0);

                                // Bar (Sistem Energi)
                                const se = report.metrics['Sistem Energi'] || {};
                                barData.Aerobic.push(se['Aerobic'] || 0);
                                barData.Anaerobic.push(se['Anaerobic'] || 0);

                                // Line (Personal Best Time)
                                const pbt = report.metrics['Personal Best Time'] || {};
                                pbtData.TestPerBulan.push(parseTimeToSeconds(pbt['Test per Bulan']));
                                pbtData.PbtEvent.push({
                                    val: parseTimeToSeconds(pbt['PBT Event']),
                                    raw: pbt['PBT Event'] // Simpan teks aslinya (misal ada tambahan "Kejurda")
                                });
                            }
                        });

                        // Ambil 2 bulan terakhir untuk komparasi Radar
                        const len = labels.length;
                        const latestLabels = ['Endurance', 'Fleksibilitas', 'Strength', 'Speed', 'Agility'];
                        const latestData = len > 0 ? [
                            radarData.Endurance[len-1], radarData.Fleksibilitas[len-1], 
                            radarData.Strength[len-1], radarData.Speed[len-1], radarData.Agility[len-1]
                        ] : [];
                        const prevData = len > 1 ? [
                            radarData.Endurance[len-2], radarData.Fleksibilitas[len-2], 
                            radarData.Strength[len-2], radarData.Speed[len-2], radarData.Agility[len-2]
                        ] : [];

                        // --- 2. Render Radar Chart (Kondisi Fisik) ---
                        const ctxRadar = document.getElementById('radarChart').getContext('2d');
                        const radarDatasets = [{
                            label: labels[len-1] || 'Bulan Ini',
                            data: latestData,
                            backgroundColor: 'rgba(37, 99, 235, 0.2)',
                            borderColor: 'rgb(37, 99, 235)',
                            borderWidth: 2,
                            pointBackgroundColor: 'rgb(37, 99, 235)'
                        }];
                        if (len > 1) {
                            radarDatasets.push({
                                label: labels[len-2] || 'Bulan Lalu',
                                data: prevData,
                                backgroundColor: 'rgba(156, 163, 175, 0.2)',
                                borderColor: 'rgb(156, 163, 175)',
                                borderWidth: 2,
                                pointBackgroundColor: 'rgb(156, 163, 175)'
                            });
                        }
                        radarChartInst = new Chart(ctxRadar, {
                            type: 'radar',
                            data: { labels: latestLabels, datasets: radarDatasets },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                scales: { r: { min: 0, max: 100 } },
                                plugins: { legend: { position: 'bottom' } }
                            }
                        });

                        // --- 3. Render Bar Chart (Sistem Energi) ---
                        const ctxBar = document.getElementById('barChart').getContext('2d');
                        barChartInst = new Chart(ctxBar, {
                            type: 'bar',
                            data: {
                                labels: labels,
                                datasets: [
                                    { label: 'Aerobic', data: barData.Aerobic, backgroundColor: 'rgba(16, 185, 129, 0.7)' },
                                    { label: 'Anaerobic', data: barData.Anaerobic, backgroundColor: 'rgba(239, 68, 68, 0.7)' }
                                ]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: { legend: { position: 'bottom' } },
                                scales: { y: { beginAtZero: true, max: 100 } }
                            }
                        });

                        // --- 4. Render Line Chart (Personal Best Time) ---
                        const ctxLine = document.getElementById('lineChartPBT').getContext('2d');
                        
                        // Menyiapkan dataset
                        const pbtDatasets = [
                            {
                                label: 'Test per Bulan',
                                data: pbtData.TestPerBulan,
                                borderColor: 'rgb(147, 51, 234)',
                                backgroundColor: 'rgba(147, 51, 234, 0.1)',
                                tension: 0.3,
                                fill: true
                            },
                            {
                                label: 'PBT Event',
                                data: pbtData.PbtEvent.map(e => e.val), // Hanya nilainya
                                type: 'scatter',
                                pointBackgroundColor: 'rgb(245, 158, 11)',
                                pointBorderColor: 'rgb(255, 255, 255)',
                                pointRadius: 6,
                                pointHoverRadius: 8
                            }
                        ];

                        lineChartPBTInst = new Chart(ctxLine, {
                            type: 'line',
                            data: { labels: labels, datasets: pbtDatasets },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: { position: 'bottom' },
                                    tooltip: {
                                        callbacks: {
                                            label: function(context) {
                                                if (context.dataset.label === 'PBT Event') {
                                                    const rawText = pbtData.PbtEvent[context.dataIndex].raw;
                                                    return `Event: ${rawText || formatSecondsToTime(context.raw)}`;
                                                }
                                                return `Test: ${formatSecondsToTime(context.raw)}`;
                                            }
                                        }
                                    }
                                },
                                scales: {
                                    y: {
                                        reverse: true, // Waktu tercepat (terkecil) ada di ATAS!
                                        ticks: {
                                            callback: function(value) { return formatSecondsToTime(value); }
                                        },
                                        title: { display: true, text: 'Waktu (MM:SS.ms)' }
                                    }
                                }
                            }
                        });

                    } else {
                        // KELAS BELAJAR (TIMELINE TEXT)
                        if (prestasiContainer) prestasiContainer.classList.add('hidden');
                        if (prestasiContainer) prestasiContainer.style.display = 'none';

                        if (freetextContainer) {
                            freetextContainer.classList.remove('hidden');
                            freetextContainer.innerHTML = '';

                            const sortedReports = [...reports].reverse();
                            sortedReports.forEach(report => {
                                const d = new Date(report.date);
                                const dateStr = d.toLocaleDateString('id-ID', { month: 'long', year: 'numeric' });
                                
                                let metricsHtml = '';
                                if (report.metrics) {
                                    for (const [category, items] of Object.entries(report.metrics)) {
                                        metricsHtml += `<div class="mb-3"><h5 class="text-sm font-bold text-slate-800 border-b pb-1 mb-2">${category}</h5><div class="grid grid-cols-1 sm:grid-cols-2 gap-2">`;
                                        for (const [key, val] of Object.entries(items)) {
                                            let badgeColor = 'bg-slate-100 text-slate-700';
                                            if (val === 'Sangat Mahir' || val === 'Lulus Tahap Ini' || val === 'Sudah Lancar') badgeColor = 'bg-green-100 text-green-700';
                                            else if (val === 'Berkembang Baik' || val === 'Mulai Bisa') badgeColor = 'bg-blue-100 text-blue-700';
                                            else if (val === 'Mulai Terlihat') badgeColor = 'bg-amber-100 text-amber-700';
                                            else if (val === 'Belum Berkembang' || val === 'Belum Bisa' || val === 'Belum Memulai') badgeColor = 'bg-red-100 text-red-700';

                                            metricsHtml += `<div class="text-xs flex justify-between items-center p-2 bg-slate-50 rounded border border-slate-100">
                                                <span class="font-medium text-slate-600">${key}</span>
                                                <span class="px-2 py-0.5 rounded-full font-bold ${badgeColor}">${val}</span>
                                            </div>`;
                                        }
                                        metricsHtml += `</div></div>`;
                                    }
                                }

                                const item = document.createElement('div');
                                item.className = 'relative pl-6 pb-6 border-l-2 border-indigo-100 last:pb-0 last:border-l-0';
                                item.innerHTML = `
                                    <span class="absolute -left-[7px] top-1.5 flex h-3.5 w-3.5 items-center justify-center rounded-full bg-indigo-500 ring-4 ring-white"></span>
                                    <div class="bg-white border border-slate-200 rounded-lg p-5 shadow-sm">
                                        <div class="flex justify-between items-center mb-4">
                                            <span class="text-sm font-bold text-indigo-700">
                                                <i class="fa-regular fa-calendar-days mr-1"></i> Bulan: ${dateStr}
                                            </span>
                                        </div>
                                        <div class="mb-4">
                                            ${metricsHtml}
                                        </div>
                                        ${report.notes ? `
                                        <div class="bg-indigo-50 border border-indigo-100 p-3 rounded-md">
                                            <p class="text-xs font-bold text-indigo-800 mb-1"><i class="fa-solid fa-comment-dots"></i> Catatan Pelatih:</p>
                                            <p class="text-sm text-slate-700 italic">${report.notes}</p>
                                        </div>` : ''}
                                    </div>
                                `;
                                freetextContainer.appendChild(item);
                            });
                        }
                    }
                    });

                // Auto-select anak pertama jika ada
                // 
                    selectDropdown.value = "{{ $children->first()->id }}";
                    selectDropdown.dispatchEvent(new Event('change'));
                //
            });
        