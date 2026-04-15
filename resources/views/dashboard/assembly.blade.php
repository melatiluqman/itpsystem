@extends('layouts.app')
@section('title', 'Inspeksi - ' . $subblok->nama_subblok)

@section('content')
<div class="topbar">
    <div>
        <h1>{{ $subblok->nama_subblok }}</h1>
        <div class="breadcrumb">
            <a href="/dashboard">Dashboard</a> /
            <a href="{{ route('blok.index', $subblok->blok->modul->id_modul) }}">{{ $subblok->blok->modul->nama_modul }}</a> /
            <a href="{{ route('subblok.index', $subblok->blok->id_blok) }}">{{ $subblok->blok->nama_blok }}</a> /
            {{ $subblok->nama_subblok }}
        </div>
    </div>
    <a href="{{ route('subblok.index', $subblok->blok->id_blok) }}" class="btn btn-outline btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
</div>

<!-- WORKSHOP / SHIP Tab -->
<div class="tab-container">
    <a href="{{ route('assembly.index', ['id' => $subblok->id_subblok, 'context' => 'WORKSHOP']) }}"
       class="tab-btn {{ $workContext === 'WORKSHOP' ? 'active' : '' }}" style="text-decoration:none;">
        <i class="fas fa-warehouse"></i> Workshop
    </a>
    <a href="{{ route('assembly.index', ['id' => $subblok->id_subblok, 'context' => 'SHIP']) }}"
       class="tab-btn {{ $workContext === 'SHIP' ? 'active' : '' }}" style="text-decoration:none;">
        <i class="fas fa-ship"></i> Ship
    </a>
</div>

@if(empty($assemblyInspections))
<div class="card">
    <div class="empty-state">
        <i class="fas fa-clipboard-check"></i>
        <p>Tidak ada kode inspeksi untuk role Anda di context {{ $workContext }}.</p>
    </div>
</div>
@else
@foreach($assemblyInspections as $ai)
<div class="accordion-item">
    <div class="accordion-header" onclick="this.parentElement.classList.toggle('open')">
        <div>
            <div class="title" style="color: var(--accent-cyan);">{{ $ai['assembly_code'] }}</div>
            <div class="subtitle">{{ $ai['keterangan'] }}</div>
        </div>
        <div style="display:flex;align-items:center;gap:12px;">
            <span class="badge badge-blue">{{ count($ai['inspections']) }} kode</span>
            <i class="fas fa-chevron-down chevron"></i>
        </div>
    </div>
    <div class="accordion-body">
        <div class="accordion-content">
            @foreach($ai['inspections'] as $insp)
            <div class="inspection-row">
                <div style="flex:1;">
                    <div class="code">
                        {{ $insp['kode'] }}
                        @if($insp['mark'] === 'W')
                            <span class="badge badge-orange" style="margin-left:6px;font-size:10px;">W</span>
                        @else
                            <span class="badge badge-blue" style="margin-left:6px;font-size:10px;">RV</span>
                        @endif
                    </div>
                    <div class="desc">{{ $insp['deskripsi'] }}</div>
                </div>
                <div style="display:flex;align-items:center;gap:8px;">
                    @if($insp['itp_data'])
                        @php
                            $statusClass = match($insp['itp_data']->status_itp_data) {
                                'pending' => 'status-pending',
                                'on progress' => 'status-progress',
                                'approve' => 'status-approve',
                                'rejected' => 'status-rejected',
                                default => 'status-pending',
                            };
                        @endphp
                        <span class="badge {{ $statusClass }}">{{ $insp['itp_data']->status_itp_data }}</span>
                    @endif
                    <button class="btn btn-primary btn-sm"
                            onclick="openItpModal({{ $insp['itp_data'] ? $insp['itp_data']->id_itp_data : 'null' }}, '{{ $insp['kode'] }}', '{{ $insp['deskripsi'] }}', '{{ $insp['mark'] }}', '{{ $ai['assembly_code'] }}')">
                        <i class="fas fa-file-alt"></i> ITP
                    </button>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endforeach
@endif

<!-- ITP Modal -->
<div class="modal-overlay" id="itpModal">
    <div class="modal">
        <div class="modal-header">
            <h3 id="modalTitle">ITP Data</h3>
            <button class="modal-close" onclick="closeItpModal()"><i class="fas fa-times"></i></button>
        </div>

        <div id="modalLoading" style="text-align:center;padding:30px;">
            <i class="fas fa-spinner fa-spin" style="font-size:24px;color:var(--accent-blue);"></i>
            <p style="margin-top:10px;color:var(--text-muted);">Memuat data...</p>
        </div>

        <div id="modalContent" style="display:none;">
            <!-- Info -->
            <div style="margin-bottom:16px;">
                <div style="display:flex;gap:8px;margin-bottom:8px;">
                    <span class="badge badge-cyan" id="modalKode"></span>
                    <span class="badge" id="modalMark"></span>
                </div>
                <p style="font-size:13px;color:var(--text-secondary);" id="modalDesc"></p>
                <p style="font-size:12px;color:var(--text-muted);margin-top:4px;" id="modalAssembly"></p>
            </div>

            <!-- Current Photo -->
            <div id="currentPhotoSection" style="margin-bottom:16px;display:none;">
                <label style="font-size:13px;font-weight:600;color:var(--text-secondary);margin-bottom:6px;display:block;">Foto Saat Ini</label>
                <img id="currentPhoto" class="photo-preview" src="" alt="Foto inspeksi">
            </div>

            <!-- Current Status & Note (view only for class/os/stat) -->
            <div id="viewOnlySection" style="display:none;">
                <div class="form-group">
                    <label>Status</label>
                    <div id="viewStatus" class="badge" style="font-size:14px;padding:8px 14px;"></div>
                </div>
                <div class="form-group">
                    <label>Catatan</label>
                    <p id="viewNote" style="font-size:14px;color:var(--text-secondary);padding:10px 14px;background:var(--bg-primary);border-radius:10px;border:1px solid var(--glass-border);"></p>
                </div>
                <div class="form-group">
                    <label>Tanggal Inspeksi</label>
                    <p id="viewDate" style="font-size:14px;color:var(--text-secondary);padding:10px 14px;background:var(--bg-primary);border-radius:10px;border:1px solid var(--glass-border);"></p>
                </div>
            </div>

            <!-- Edit form (yard only) -->
            <form id="itpForm" style="display:none;" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="formWorkContext" name="work_context" value="{{ $workContext }}">

                <div class="form-group">
                    <label for="formStatus">Status</label>
                    <select id="formStatus" name="status_itp_data" class="form-control">
                        <option value="pending">Pending</option>
                        <option value="on progress">On Progress</option>
                        <option value="approve">Approve</option>
                        <option value="rejected">Rejected</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="formFoto">
                        Foto Inspeksi
                        <span id="fotoRequired" style="color:var(--accent-red);display:none;">* Wajib (Mark: W)</span>
                    </label>
                    <input type="file" id="formFoto" name="foto" class="form-control" accept="image/*">
                    <img id="fotoPreview" class="photo-preview" style="display:none;" src="" alt="Preview">
                </div>

                <div class="form-group">
                    <label for="formNote">Catatan</label>
                    <textarea id="formNote" name="note" class="form-control" rows="3" placeholder="Tambahkan catatan inspeksi..."></textarea>
                </div>

                <div id="formError" class="alert alert-error" style="display:none;"></div>

                <div style="display:flex;gap:10px;margin-top:20px;">
                    <button type="submit" class="btn btn-success" id="submitBtn">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-outline" onclick="closeItpModal()">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const isYard = {{ auth()->user()->isYard() ? 'true' : 'false' }};
    let currentItpId = null;

    function openItpModal(itpId, kode, deskripsi, mark, assemblyCode) {
        document.getElementById('itpModal').classList.add('active');
        document.getElementById('modalLoading').style.display = 'block';
        document.getElementById('modalContent').style.display = 'none';

        document.getElementById('modalTitle').textContent = 'ITP Data — ' + kode;
        document.getElementById('modalKode').textContent = kode;
        document.getElementById('modalDesc').textContent = deskripsi;
        document.getElementById('modalAssembly').textContent = 'Assembly: ' + assemblyCode;

        const markEl = document.getElementById('modalMark');
        markEl.textContent = mark;
        markEl.className = mark === 'W' ? 'badge badge-orange' : 'badge badge-blue';

        currentItpId = itpId;

        if (itpId) {
            fetch('/itp-data/' + itpId, {
                headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(r => r.json())
            .then(data => {
                showModalData(data, mark);
            })
            .catch(() => {
                showEmptyModal(mark);
            });
        } else {
            showEmptyModal(mark);
        }
    }

    function showModalData(data, mark) {
        document.getElementById('modalLoading').style.display = 'none';
        document.getElementById('modalContent').style.display = 'block';

        // Show photo if exists
        const photoSection = document.getElementById('currentPhotoSection');
        if (data.foto) {
            document.getElementById('currentPhoto').src = '/storage/itp-photos/' + data.foto;
            photoSection.style.display = 'block';
        } else {
            photoSection.style.display = 'none';
        }

        if (isYard) {
            document.getElementById('itpForm').style.display = 'block';
            document.getElementById('viewOnlySection').style.display = 'none';

            document.getElementById('formStatus').value = data.status_itp_data || 'pending';
            document.getElementById('formNote').value = data.note || '';

            const fotoReq = document.getElementById('fotoRequired');
            fotoReq.style.display = (mark === 'W' && !data.foto) ? 'inline' : 'none';
        } else {
            document.getElementById('itpForm').style.display = 'none';
            document.getElementById('viewOnlySection').style.display = 'block';

            const statusMap = {
                'pending': 'status-pending',
                'on progress': 'status-progress',
                'approve': 'status-approve',
                'rejected': 'status-rejected'
            };

            const viewStatus = document.getElementById('viewStatus');
            viewStatus.textContent = data.status_itp_data || 'pending';
            viewStatus.className = 'badge ' + (statusMap[data.status_itp_data] || 'status-pending');

            document.getElementById('viewNote').textContent = data.note || 'Belum ada catatan';
            document.getElementById('viewDate').textContent = data.tanggal_inspeksi || '-';
        }
    }

    function showEmptyModal(mark) {
        document.getElementById('modalLoading').style.display = 'none';
        document.getElementById('modalContent').style.display = 'block';
        document.getElementById('currentPhotoSection').style.display = 'none';

        if (isYard) {
            document.getElementById('itpForm').style.display = 'block';
            document.getElementById('viewOnlySection').style.display = 'none';
            document.getElementById('formStatus').value = 'pending';
            document.getElementById('formNote').value = '';
            document.getElementById('fotoRequired').style.display = mark === 'W' ? 'inline' : 'none';
        } else {
            document.getElementById('itpForm').style.display = 'none';
            document.getElementById('viewOnlySection').style.display = 'block';
            document.getElementById('viewStatus').textContent = 'pending';
            document.getElementById('viewStatus').className = 'badge status-pending';
            document.getElementById('viewNote').textContent = 'Belum ada data';
            document.getElementById('viewDate').textContent = '-';
        }
    }

    function closeItpModal() {
        document.getElementById('itpModal').classList.remove('active');
        document.getElementById('fotoPreview').style.display = 'none';
        document.getElementById('formError').style.display = 'none';
    }

    // Photo preview
    document.getElementById('formFoto')?.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(ev) {
                const preview = document.getElementById('fotoPreview');
                preview.src = ev.target.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        }
    });

    // Form submit
    document.getElementById('itpForm')?.addEventListener('submit', function(e) {
        e.preventDefault();
        if (!currentItpId) return;

        const formData = new FormData(this);
        const submitBtn = document.getElementById('submitBtn');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';

        fetch('/itp-data/' + currentItpId, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: formData
        })
        .then(r => r.json())
        .then(data => {
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="fas fa-save"></i> Simpan';

            if (data.success) {
                closeItpModal();
                location.reload();
            } else if (data.errors) {
                const errDiv = document.getElementById('formError');
                errDiv.style.display = 'flex';
                errDiv.innerHTML = '<i class="fas fa-exclamation-circle"></i> ' +
                    Object.values(data.errors).flat().join('<br>');
            }
        })
        .catch(err => {
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="fas fa-save"></i> Simpan';
            const errDiv = document.getElementById('formError');
            errDiv.style.display = 'flex';
            errDiv.textContent = 'Terjadi kesalahan. Silakan coba lagi.';
        });
    });

    // Close modal on overlay click
    document.getElementById('itpModal').addEventListener('click', function(e) {
        if (e.target === this) closeItpModal();
    });
</script>
@endsection
