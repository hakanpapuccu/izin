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
                                                <th>İşlemler</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($vacations as $vacation)
                                            <tr>
                                                <td><img class="rounded-circle" width="35" src="images/profile/small/pic1.jpg" alt=""></td>
                                                <td>{{$vacation->getUser->name}}</td>
                                                <td>{{$vacation->vacation_date}}</td>
                                                <td>{{$vacation->vacation_start}}</td>
                                                <td>{{$vacation->vacation_end}}</td>
                                                <td><strong>{{$vacation->vacation_why}}</strong></td>
                                                
                                                <td>
                                                    <div class="d-flex">
                                                       <a href="{{route('vacations.verify', $vacation->id)}}" class="btn btn-success shadow btn-xs  me-1">Onayla</i></a>
                                                       <a href="{{route('vacations.reject', $vacation->id)}}" class="btn btn-danger shadow btn-xs ">Reddet</a>
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

                <!-- Last vacations -->

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Geçmiş İzinler</h4>
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
                                                <th>İşlem Yapan</th>
                                                <th>İşlemler</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($lastvacations as $lastvacation)
                                            <tr>
                                                <td><img class="rounded-circle" width="35" src="images/profile/small/pic1.jpg" alt=""></td>
                                                <td>{{$lastvacation->getUser->name}}</td>
                                                <td>{{$lastvacation->vacation_date}}</td>
                                                <td>{{$lastvacation->vacation_start}}</td>
                                                <td>{{$lastvacation->vacation_end}}</td>
                                                <td><strong>{{$lastvacation->vacation_why}}</strong></td>
                                                <td><strong> 
                                                    @if($lastvacation->getVerifier->name == 3)
                                                    {{' '}}
                                                    @else
                                                    {{$lastvacation->getVerifier->name}}
                                                    @endif
                                                
                                                </strong></td>
                                                
                                                <td>
                                                    @if($lastvacation->is_verified==1)
                                                    <span class="badge light badge-success">
														<i class="fa fa-check text-success me-1"></i>
														Onaylandı
													</span>	
                                                    @elseif($lastvacation->is_verified==2)	
                                                    <span class="badge light badge-warning">
														<i class="fa fa-circle text-warning me-1"></i>
														Onay Bekliyor
													</span>	
                                                    @elseif($lastvacation->is_verified==3)
                                                    <span class="badge light badge-danger">
														<i class="fa fa-ban text-danger me-1"></i>
														Reddedildi
													</span>	
                                                    @else()
                                                    @endif
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

                <!-- Last vavations -->
				
            </div>

        @endif
        </div>
@endsection