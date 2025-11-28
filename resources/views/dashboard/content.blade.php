@extends('dashboard.index')

@section('title', 'Anasayfa')

@section('content')
<div class="content-body">
    <div class="container-fluid">
        
        <!-- Row 1: Statistics -->
        <div class="row">
            <!-- Vacation Stats -->
            <div class="col-xl-12">
                <div class="row">
                    <div class="col-xl-3 col-lg-3 col-sm-6">
                        <div class="widget-stat card bg-primary">
                            <div class="card-body  p-4">
                                <div class="media">
                                    <span class="me-3">
                                        <i class="fas fa-plane-departure"></i>
                                    </span>
                                    <div class="media-body text-white text-end">
                                        <p class="mb-1">Toplam İzin</p>
                                        <h3 class="text-white">{{ $totalVacationsCount }}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-sm-6">
                        <div class="widget-stat card bg-warning">
                            <div class="card-body p-4">
                                <div class="media">
                                    <span class="me-3">
                                        <i class="fas fa-hourglass-half"></i>
                                    </span>
                                    <div class="media-body text-white text-end">
                                        <p class="mb-1">Onay Bekleyen</p>
                                        <h3 class="text-white">{{ $pendingVacationsCount }}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-sm-6">
                        <div class="widget-stat card bg-success">
                            <div class="card-body p-4">
                                <div class="media">
                                    <span class="me-3">
                                        <i class="fas fa-check-circle"></i>
                                    </span>
                                    <div class="media-body text-white text-end">
                                        <p class="mb-1">Onaylanan</p>
                                        <h3 class="text-white">{{ $approvedVacationsCount }}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-sm-6">
                        <div class="widget-stat card bg-danger">
                            <div class="card-body p-4">
                                <div class="media">
                                    <span class="me-3">
                                        <i class="fas fa-times-circle"></i>
                                    </span>
                                    <div class="media-body text-white text-end">
                                        <p class="mb-1">Reddedilen</p>
                                        <h3 class="text-white">{{ $rejectedVacationsCount }}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Task Stats -->
            <div class="col-xl-12 col-xxl-12">
                <div class="card">
                    <div class="card-header border-0 pb-0">
                        <h4 class="fs-20 font-w700 mb-0">Görev Durumu</h4>
                    </div>
                    <div class="card-body pb-0">
                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <div class="d-flex">
                                <div class="ms-3">
                                    <h4 class="fs-24 font-w700 ">{{ $totalTasksCount }}</h4>
                                    <span class="fs-16 font-w400 d-block">Toplam Görev</span>
                                </div>
                            </div>
                            <div class="d-flex">
                                <div class="d-flex me-5">
                                    <div class="mt-2">
                                        <svg width="13" height="13" viewBox="0 0 13 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <circle cx="6.5" cy="6.5" r="6.5" fill="#FFCF6D"/>
                                        </svg>
                                    </div>
                                    <div class="ms-3">
                                        <h4 class="fs-24 font-w700 ">{{ $inProgressTasksCount }}</h4>
                                        <span class="fs-16 font-w400 d-block">Devam Eden</span>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <div class="mt-2">
                                        <svg width="13" height="13" viewBox="0 0 13 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <circle cx="6.5" cy="6.5" r="6.5" fill="#09BD3C"/>
                                        </svg>
                                    </div>
                                    <div class="ms-3">
                                        <h4 class="fs-24 font-w700 ">{{ $completedTasksCount }}</h4>
                                        <span class="fs-16 font-w400 d-block">Tamamlanan</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="progress default-progress mt-4 mb-4">
                            @php
                                $percent = $totalTasksCount > 0 ? ($completedTasksCount / $totalTasksCount) * 100 : 0;
                            @endphp
                            <div class="progress-bar bg-gradient1 progress-animated" style="width: {{ $percent }}%; height:10px;" role="progressbar">
                                <span class="sr-only">{{ number_format($percent, 0) }}% Complete</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Row 2: Pending Approvals (Admin Only) -->
        @if(Auth::user()->is_admin && $pendingVacations->count() > 0)
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header border-0">
                        <h4 class="fs-20 font-w700">Onay Bekleyen İzinler</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-responsive-sm">
                                <thead>
                                    <tr>
                                        <th>Ad Soyad</th>
                                        <th>Tarih</th>
                                        <th>Saat Aralığı</th>
                                        <th>Sebep</th>
                                        <th>İşlem</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pendingVacations as $vacation)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="profile-k me-3">
                                                    <span class="bg-warning text-white">{{ substr($vacation->user->name ?? 'U', 0, 1) }}</span>
                                                </div>
                                                <span class="w-space-no">{{ $vacation->user->name ?? 'Bilinmiyor' }}</span>
                                            </div>
                                        </td>
                                        <td>{{ $vacation->vacation_date ? $vacation->vacation_date->format('d.m.Y') : '-' }}</td>
                                        <td>{{ $vacation->vacation_start ? $vacation->vacation_start->format('H:i') : '-' }} - {{ $vacation->vacation_end ? $vacation->vacation_end->format('H:i') : '-' }}</td>
                                        <td>{{ $vacation->vacation_reason }}</td>
                                        <td>
                                            <div class="d-flex">
                                                <a href="{{ route('vacations.verify', $vacation->id) }}" class="btn btn-success shadow btn-xs sharp me-1"><i class="fa fa-check"></i></a>
                                                <a href="{{ route('vacations.reject', $vacation->id) }}" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-times"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Row 3: Recent Lists -->
        <div class="row">
            <!-- Recent Vacations -->
            <div class="col-xl-6 col-lg-12">
                <div class="card">
                    <div class="card-header border-0">
                        <div>
                            <h4 class="fs-20 font-w700">Son İzin Hareketleri</h4>
                        </div>
                        <div>
                            @if(Auth::user()->is_admin)
                            <a href="{{ route('vacations') }}" class="btn btn-outline-primary btn-rounded fs-18">Tümünü Gör</a>
                            @endif
                        </div>
                    </div>
                    <div class="card-body px-0">
                        @foreach($vacations as $vacation)
                        <div class="d-flex justify-content-between recent-emails mb-4 border-bottom pb-3">
                            <div class="d-flex">
                                <div class="profile-k">
                                    <span class="bg-primary">{{ substr($vacation->user->name ?? 'U', 0, 1) }}</span>
                                </div>
                                <div class="ms-3">
                                    <h4 class="fs-18 font-w500">{{ $vacation->user->name ?? 'Bilinmiyor' }}</h4>
                                    <span class="font-w400 d-block">{{ $vacation->vacation_reason }}</span>
                                    <div class="final-badge mt-2">
                                        <x-vacation-status-badge :status="$vacation->is_verified" />
                                        <span class="badge text-black border ms-2">
                                            <i class="far fa-calendar me-2"></i>
                                            {{ $vacation->vacation_date ? $vacation->vacation_date->format('d.m.Y') : '-' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Recent Tasks -->
            <div class="col-xl-6 col-lg-12">
                <div class="card">
                    <div class="card-header border-0">
                        <div>
                            <h4 class="fs-20 font-w700">Son Görevler</h4>
                        </div>
                        <div>
                            @if(Auth::user()->is_admin)
                            <a href="{{ route('tasks.create') }}" class="btn btn-primary btn-rounded">+ Yeni Görev</a>
                            @endif
                        </div>
                    </div>
                    <div class="card-body px-0">
                        @foreach($tasks as $task)
                        <div class="msg-bx d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
                            <div class="msg d-flex align-items-center w-100">
                                <div class="image-box active">
                                    <span class="btn-icon-start text-primary"><i class="fas fa-tasks fa-2x"></i></span>
                                </div>
                                <div class="ms-3 w-100">
                                    <a href="{{ route('tasks.edit', $task->id) }}">
                                        <h4 class="fs-18 font-w600">{{ $task->title }}</h4>
                                    </a>
                                    <div class="d-flex justify-content-between mt-2">
                                        <span class="me-auto badge badge-xs light badge-{{ $task->priority == 'high' ? 'danger' : ($task->priority == 'medium' ? 'warning' : 'success') }}">
                                            {{ $task->priority == 'high' ? 'Yüksek' : ($task->priority == 'medium' ? 'Orta' : 'Düşük') }}
                                        </span>
                                        <span class="me-4 fs-12">{{ $task->deadline ? $task->deadline->diffForHumans() : '' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Row 4: Calendar and Chat Widget -->
        <div class="row">
            <!-- Calendar -->
            <div class="col-xl-6">
                <div class="card">
                    <div class="card-header border-0">
                        <h4 class="fs-20 font-w700">İş Takvimi</h4>
                    </div>
                    <div class="card-body">
                        <div id='dashboard-calendar'></div>
                    </div>
                </div>
            </div>

            <!-- General Chat -->
            <div class="col-xl-6">
                <div class="card">
                    <div class="card-header border-0">
                        <h4 class="fs-20 font-w700">Genel Sohbet</h4>
                    </div>
                    <div class="card-body">
                        <div id="dashboard-general-messages" style="height: 400px; overflow-y: auto; background: #f8f9fa; padding: 15px; border-radius: 10px; margin-bottom: 15px;">
                            <!-- Messages will be loaded here -->
                        </div>
                        <form id="dashboard-chat-form">
                            <div class="input-group">
                                <input type="text" class="form-control" id="dashboard-chat-input" placeholder="Mesajınızı yazın..." required>
                                <button class="btn btn-primary" type="submit">
                                    <i class="fa fa-paper-plane"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @push('scripts')
        <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Calendar Initialization
                var calendarEl = document.getElementById('dashboard-calendar');
                var calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    locale: 'tr',
                    headerToolbar: {
                        left: 'prev,next',
                        center: 'title',
                        right: ''
                    },
                    height: 500,
                    events: '{{ route("calendar.events") }}'
                });
                calendar.render();

                // Chat Initialization
                loadDashboardMessages();
                setInterval(loadDashboardMessages, 3000);

                // Chat Form Submit
                document.getElementById('dashboard-chat-form').addEventListener('submit', function(e) {
                    e.preventDefault();
                    const input = document.getElementById('dashboard-chat-input');
                    const message = input.value.trim();
                    
                    if (!message) return;

                    fetch('/chat/send', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            message: message,
                            is_general: true
                        })
                    })
                    .then(response => response.json())
                    .then(() => {
                        input.value = '';
                        loadDashboardMessages();
                    })
                    .catch(error => console.error('Error:', error));
                });
            });

            function loadDashboardMessages() {
                const container = document.getElementById('dashboard-general-messages');
                const currentUserId = {{ auth()->id() }};

                fetch('/chat/general')
                    .then(response => response.json())
                    .then(messages => {
                        container.innerHTML = '';
                        messages.forEach(message => {
                            const isSender = message.sender_id === currentUserId;
                            const messageDiv = document.createElement('div');
                            messageDiv.className = `d-flex justify-content-${isSender ? 'end' : 'start'} mb-2`;
                            
                            const senderName = message.sender ? message.sender.name : 'Bilinmeyen';
                            
                            messageDiv.innerHTML = `
                                <div class="${isSender ? 'bg-primary text-white' : 'bg-white text-dark'}" style="max-width: 80%; padding: 8px 12px; border-radius: 15px; box-shadow: 0 1px 2px rgba(0,0,0,0.1);">
                                    ${!isSender ? `<small class="fw-bold d-block mb-1" style="font-size: 0.7rem;">${senderName}</small>` : ''}
                                    <p class="mb-0" style="font-size: 0.9rem;">${escapeHtml(message.message)}</p>
                                    <small class="${isSender ? 'text-white-50' : 'text-muted'} d-block text-end mt-1" style="font-size: 0.65rem;">
                                        ${formatTime(message.created_at)}
                                    </small>
                                </div>
                            `;
                            container.appendChild(messageDiv);
                        });
                        container.scrollTop = container.scrollHeight;
                    })
                    .catch(error => console.error('Error:', error));
            }

            function formatTime(timestamp) {
                const date = new Date(timestamp);
                return date.toLocaleTimeString('tr-TR', {hour: '2-digit', minute: '2-digit'});
            }

            function escapeHtml(text) {
                const div = document.createElement('div');
                div.textContent = text;
                return div.innerHTML;
            }
        </script>
        @endpush

    </div>
</div>
@endsection