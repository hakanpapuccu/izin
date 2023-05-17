@extends('dashboard.index')
@section('content')
<div class="content-body">
            <!-- row -->
			<div class="container-fluid">
                <!-- Not verified vacations list -->

                <div class="row">

                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">İzin Talebi Oluştur</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 col-xl-3 col-xxl-6 mb-3">
                                        <label class="form-label">İzin Tarihi</label>
                                        <div class="input-group">
                                            <input type="date" class="form-control" value="01.01.2023"><span class="input-group-text"><i class="far fa-calendar"></i></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-xl-3 col-xxl-6 mb-3">
                                        <label class="form-label">İzin İsteme Sebebi</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" value="">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-xl-3 col-xxl-6 mb-3">
                                        <label class="form-label">İzin Başlangıç Saati</label>
                                        <div class="input-group clockpicker" data-placement="bottom" data-align="top" data-autobtn-close="true">
                                            <input type="text" class="form-control" value="13:14"> 
											<span class="input-group-text"><i class="far fa-clock"></i></span>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6 col-xl-3 col-xxl-6">
                                        <label class="form-label">İzin Bitiş Saati</label>
                                        <div class="input-group clockpicker" data-placement="bottom" data-align="top" data-autobtn-close="true">
                                            <input type="text" class="form-control" value="13:14"> 
											<span class="input-group-text"><i class="far fa-clock"></i></span>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-xl-3 col-xxl-6">
                     
                                    <button class="btn btn-success ">Kaydet</button>
                    
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">İzin Geçmişi</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="example3" class="display" style="min-width: 845px">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>Adı Soyadı</th>
                                                <th>Tarih</th>
                                                <th>İzin Başlangıç Saati</th>
                                                <th>İzin Bitiş Saati</th>
                                                <th>İzin İsteme Sebebi</th>
                                                <th>Durum</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td></td>
                                                <td>Tiger Nixon</td>
                                                <td>Architect</td>
                                                <td>Male</td>
                                                <td>M.COM., P.H.D.</td>
                                                <td><a href="javascript:void(0);"><strong>123 456 7890</strong></a></td>
                                                
                                                <td>
                                                    <span class="badge light badge-success">
														<i class="fa fa-check text-success me-1"></i>
														Onaylandı
													</span>											
                                                </td>												
                                            </tr>

                                            <tr>
                                                <td></td>
                                                <td>Tiger Nixon</td>
                                                <td>Architect</td>
                                                <td>Male</td>
                                                <td>M.COM., P.H.D.</td>
                                                <td><a href="javascript:void(0);"><strong>123 456 7890</strong></a></td>
                                                
                                                <td>
                                                    <span class="badge light badge-warning">
														<i class="fa fa-circle text-warning me-1"></i>
														Onay Bekliyor
													</span>											
                                                </td>												
                                            </tr>

                                            <tr>
                                                <td></td>
                                                <td>Tiger Nixon</td>
                                                <td>Architect</td>
                                                <td>Male</td>
                                                <td>M.COM., P.H.D.</td>
                                                <td><a href="javascript:void(0);"><strong>123 456 7890</strong></a></td>
                                                
                                                <td>
                                                    <span class="badge light badge-danger">
														<i class="fa fa-ban text-danger me-1"></i>
														Reddedildi
													</span>											
                                                </td>												
                                            </tr>
                                         
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Not verified vacations list -->
				
            </div>
        </div>
@endsection