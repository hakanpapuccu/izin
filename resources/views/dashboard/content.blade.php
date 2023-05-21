@extends('dashboard.index')
@section('content')
<div class="content-body">
        @if(Auth::user()->is_admin==1) 
            <!-- row -->
			<div class="container-fluid">
                <!-- Not verified vacations list -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Onay Bekleyen İzinler</h4>
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
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($vacations as $vacation)
                                            <tr>
                                                <td><img class="rounded-circle" width="35" src="images/profile/small/pic1.jpg" alt=""></td>
                                                <td>Tiger Nixon</td>
                                                <td>Architect</td>
                                                <td>Male</td>
                                                <td>M.COM., P.H.D.</td>
                                                <td><a href="javascript:void(0);"><strong>123 456 7890</strong></a></td>
                                                
                                                <td>
                                                    <div class="d-flex">
                                                        <a href="#" class="btn btn-success shadow btn-xs  me-1">Onayla</i></a>
                                                        <a href="#" class="btn btn-danger shadow btn-xs ">Reddet</a>
                                                    </div>												
                                                </td>												
                                            </tr>

                                            @endforeach

                                          <!--  <tr>
                                                <td><img class="rounded-circle" width="35" src="images/profile/small/pic1.jpg" alt=""></td>
                                                <td>Tiger Nixon</td>
                                                <td>Architect</td>
                                                <td>Male</td>
                                                <td>M.COM., P.H.D.</td>
                                                <td><a href="javascript:void(0);"><strong>123 456 7890</strong></a></td>
                                                
                                                <td>
                                                    <div class="d-flex">
                                                        <a href="#" class="btn btn-success shadow btn-xs  me-1">Onayla</i></a>
                                                        <a href="#" class="btn btn-danger shadow btn-xs ">Reddet</a>
                                                    </div>												
                                                </td>												
                                            </tr>

                                            <tr>
                                                <td><img class="rounded-circle" width="35" src="images/profile/small/pic1.jpg" alt=""></td>
                                                <td>Tiger Nixon</td>
                                                <td>Architect</td>
                                                <td>Male</td>
                                                <td>M.COM., P.H.D.</td>
                                                <td><a href="javascript:void(0);"><strong>123 456 7890</strong></a></td>
                                                
                                                <td>
                                                    <div class="d-flex">
                                                        <a href="#" class="btn btn-success shadow btn-xs  me-1">Onayla</i></a>
                                                        <a href="#" class="btn btn-danger shadow btn-xs ">Reddet</a>
                                                    </div>												
                                                </td>												
                                            </tr> -->
                                         
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Not verified vacations list -->
				
            </div>

        @endif
        </div>
@endsection