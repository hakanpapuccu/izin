@extends('dashboard.index')

@section('title', 'İş Takvimi')

@section('content')
<div class="content-body">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">İş Takvimi</h4>
                        @if(auth()->user()->is_admin)
                        <button type="button" class="btn btn-primary" id="addEventBtn">
                            <i class="fas fa-plus me-2"></i>Etkinlik Ekle
                        </button>
                        @endif
                    </div>
                    <div class="card-body">
                        <div id='calendar'></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add/Edit Event Modal -->
<div class="modal fade" id="eventModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Etkinlik Ekle</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal">
                </button>
            </div>
            <div class="modal-body">
                <form id="eventForm">
                    <input type="hidden" id="eventId">
                    <div class="mb-3">
                        <label class="form-label">Başlık</label>
                        <input type="text" class="form-control" id="eventTitle" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Açıklama</label>
                        <textarea class="form-control" id="eventDescription" rows="3"></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Başlangıç</label>
                            <input type="datetime-local" class="form-control" id="eventStart" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Bitiş</label>
                            <input type="datetime-local" class="form-control" id="eventEnd" required>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">İptal</button>
                @if(auth()->user()->is_admin)
                <button type="button" class="btn btn-danger" id="deleteEventBtn" style="display: none;">Sil</button>
                <button type="button" class="btn btn-primary" id="saveEventBtn">Kaydet</button>
                @endif
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var modal = new bootstrap.Modal(document.getElementById('eventModal'));
        var deleteBtn = document.getElementById('deleteEventBtn');
        var saveBtn = document.getElementById('saveEventBtn');
        var addBtn = document.getElementById('addEventBtn');
        var form = document.getElementById('eventForm');

        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'tr',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            events: '{{ route("calendar.events") }}',
            selectable: {{ auth()->user()->is_admin ? 'true' : 'false' }},
            editable: {{ auth()->user()->is_admin ? 'true' : 'false' }},
            select: function(info) {
                @if(auth()->user()->is_admin)
                    resetForm();
                    document.getElementById('modalTitle').innerText = 'Yeni Etkinlik Ekle';
                    document.getElementById('eventStart').value = formatDateTime(info.startStr);
                    document.getElementById('eventEnd').value = formatDateTime(info.endStr);
                    deleteBtn.style.display = 'none';
                    modal.show();
                @endif
            },
            eventClick: function(info) {
                resetForm();
                document.getElementById('modalTitle').innerText = 'Etkinliği Düzenle';
                document.getElementById('eventId').value = info.event.id;
                document.getElementById('eventTitle').value = info.event.title;
                document.getElementById('eventDescription').value = info.event.extendedProps.description || '';
                document.getElementById('eventStart').value = formatDateTime(info.event.start);
                document.getElementById('eventEnd').value = info.event.end ? formatDateTime(info.event.end) : formatDateTime(info.event.start);
                
                @if(auth()->user()->is_admin)
                    deleteBtn.style.display = 'block';
                    saveBtn.innerText = 'Güncelle';
                @else
                    saveBtn.style.display = 'none';
                    deleteBtn.style.display = 'none';
                @endif
                
                modal.show();
            }
        });
        calendar.render();

        function formatDateTime(dateStr) {
            if (!dateStr) return '';
            let date = new Date(dateStr);
            if (isNaN(date.getTime())) {
                // If dateStr is just YYYY-MM-DD
                date = new Date(dateStr + 'T09:00:00');
            }
            
            const pad = (n) => n < 10 ? '0' + n : n;
            return date.getFullYear() + '-' + 
                   pad(date.getMonth() + 1) + '-' + 
                   pad(date.getDate()) + 'T' + 
                   pad(date.getHours()) + ':' + 
                   pad(date.getMinutes());
        }

        function resetForm() {
            form.reset();
            document.getElementById('eventId').value = '';
            saveBtn.innerText = 'Kaydet';
        }

        if(addBtn) {
            addBtn.addEventListener('click', function() {
                resetForm();
                document.getElementById('modalTitle').innerText = 'Yeni Etkinlik Ekle';
                
                // Set default start/end to today/now
                const now = new Date();
                const oneHourLater = new Date(now.getTime() + 60*60*1000);
                
                document.getElementById('eventStart').value = formatDateTime(now);
                document.getElementById('eventEnd').value = formatDateTime(oneHourLater);
                
                deleteBtn.style.display = 'none';
                modal.show();
            });
        }

        if(saveBtn) {
            saveBtn.addEventListener('click', async function() {
                const id = document.getElementById('eventId').value;
                const url = id ? `/calendar/events/${id}` : '/calendar/events';
                const method = id ? 'PUT' : 'POST';
                
                const data = {
                    title: document.getElementById('eventTitle').value,
                    description: document.getElementById('eventDescription').value,
                    start_date: document.getElementById('eventStart').value,
                    end_date: document.getElementById('eventEnd').value
                };

                try {
                    const response = await fetch(url, {
                        method: method,
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify(data)
                    });

                    if (response.ok) {
                        modal.hide();
                        calendar.refetchEvents();
                    } else {
                        const data = await response.json();
                        console.error('Error details:', data);
                        if (data.message) {
                            alert('Hata: ' + data.message);
                        } else if (data.errors) {
                            let errorMessage = 'Hata:\n';
                            for (const [key, value] of Object.entries(data.errors)) {
                                errorMessage += `${value}\n`;
                            }
                            alert(errorMessage);
                        } else {
                            alert('Bir hata oluştu.');
                        }
                    }
                } catch (error) {
                    console.error('Error:', error);
                    alert('Bir hata oluştu: ' + error.message);
                }
            });
        }

        if(deleteBtn) {
            deleteBtn.addEventListener('click', async function() {
                if (!confirm('Bu etkinliği silmek istediğinizden emin misiniz?')) return;
                
                const id = document.getElementById('eventId').value;
                try {
                    const response = await fetch(`/calendar/events/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    });

                    if (response.ok) {
                        modal.hide();
                        calendar.refetchEvents();
                    } else {
                        alert('Bir hata oluştu.');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    alert('Bir hata oluştu.');
                }
            });
        }
    });
</script>
@endpush
@endsection
