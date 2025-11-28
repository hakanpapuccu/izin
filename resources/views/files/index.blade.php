@extends('dashboard.index')

@section('title', 'Dosya Paylaşımı')

@section('content')
<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Dosya Paylaşımı</a></li>
            </ol>
        </div>
        
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Dosyalar</h4>
                        <a href="{{ route('files.create') }}" class="btn btn-primary">Yeni Dosya Yükle</a>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show">
                                <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="me-2"><polyline points="9 11 12 14 22 4"></polyline><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path></svg>
                                <strong>Başarılı!</strong> {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"></button>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show">
                                <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="me-2"><polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2"></polygon><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                                <strong>Hata!</strong> {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"></button>
                            </div>
                        @endif

                        <div class="table-responsive">
                            <table class="table table-responsive-md">
                                <thead>
                                    <tr>
                                        <th><strong>BAŞLIK</strong></th>
                                        <th><strong>AÇIKLAMA</strong></th>
                                        <th><strong>YÜKLEYEN</strong></th>
                                        <th><strong>TARİH</strong></th>
                                        <th><strong>İŞLEMLER</strong></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($files as $file)
                                        <tr>
                                            <td>{{ $file->title }}</td>
                                            <td>{{ Str::limit($file->description, 50) }}</td>
                                            <td>{{ $file->user->name }}</td>
                                            <td>{{ $file->created_at->format('d.m.Y H:i') }}</td>
                                            <td>
                                                <a href="{{ route('files.download', $file->id) }}" class="btn btn-primary shadow btn-xs sharp">
                                                    <i class="fa fa-download"></i>
                                                </a>
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
    </div>
</div>
@endsection
