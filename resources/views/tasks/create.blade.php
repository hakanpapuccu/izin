@extends('dashboard.index')

@section('content')
<div class="content-body">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Yeni Görev Oluştur</h4>
                    </div>
                    <div class="card-body">
                        <div class="basic-form">
                            <form action="{{ route('tasks.store') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">Başlık</label>
                                        <input type="text" name="title" class="form-control" placeholder="Görev Başlığı" required>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">Öncelik</label>
                                        <select name="priority" class="form-control default-select form-control-wide">
                                            <option value="low">Düşük</option>
                                            <option value="medium" selected>Orta</option>
                                            <option value="high">Yüksek</option>
                                        </select>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">Atanacak Kişi</label>
                                        <select name="assigned_to_id" class="form-control default-select form-control-wide">
                                            @foreach($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">Son Tarih</label>
                                        <input type="datetime-local" name="deadline" class="form-control">
                                    </div>
                                    <div class="mb-3 col-md-12">
                                        <label class="form-label">Açıklama</label>
                                        <textarea name="description" id="ckeditor" class="form-control" rows="4"></textarea>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Oluştur</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.ckeditor.com/4.21.0/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('ckeditor');
</script>
@endsection
