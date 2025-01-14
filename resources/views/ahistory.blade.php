@extends((Auth::user()->role == "1") ? 'layouts.admin.layout' : 'layouts.engineer.elayout')
	@section('content')
		<div class="content-wrapper">
			<section class="content-header" >
				<a href="{{url('absen')}}">
					<img src="img/labelaogy.png" width="120" height="40">
				</a>
				<ol class="breadcrumb" style="font-size: 15px;">
					<li><a href="{{url('ahistory')}}">
						<i class="fa fa-book"></i>My Attendance</a>
					</li>
					@if(Auth::user()->role == "1")
						<li>
							<a href="{{url('ateamhistory')}}">
								<i class="fa fa-users"></i>
								Team Attendance
							</a>
						</li>
						<li>
							<a href="{{url('areport')}}">
							<i class="fa fa-users"></i>
							Reporting
						</a>
						</li>
					@endif
				</ol>
			</section>
			<section class="content">
				<div class="box" id="panel_simple">
					<div class="box-header with-border">
						<h3 class="box-title">My Attendance	on {{date('F')}}</h3>			
					</div>
					<div class="col-md-4">
						<div class="box box-solid">
							<div class="box-body">
								<div class="row">
									<div class="col-md-8">
										<div class="chart-responsive">
											<div class="progress vertical">
												<div class="progress-bar progress-bar-green" role="progressbar" aria-valuenow="{{$persen[2]}}" aria-valuemin="0" aria-valuemax="100" style="height: {{$persen[2]}}%">
													<span class="sr-only">{{$persen[2]}}%</span>
												</div>
											</div>
											<div class="progress vertical">
												<div class="progress-bar progress-bar-yellow" role="progressbar" aria-valuenow="{{$persen[1]}}" aria-valuemin="0" aria-valuemax="100" style="height: {{$persen[1]}}%">
													<span class="sr-only">{{$persen[1]}}%</span>
												</div>
											</div>
											<div class="progress vertical">
												<div class="progress-bar progress-bar-red" role="progressbar" aria-valuenow="{{$persen[0]}}" aria-valuemin="0" aria-valuemax="100" style="height: {{$persen[0]}}%">
													<span class="sr-only">{{$persen[0]}}%</span>
												</div>
											</div>
											<div class="progress vertical">
												<div class="progress-bar progress-bar-blue" role="progressbar" aria-valuenow="{{$absen}}" aria-valuemin="0" aria-valuemax="100" style="height: {{$absen}}%">
													<span class="sr-only">{{$absen}}%</span>
												</div>
											</div>
										</div>
									</div>
									<div class="col-md-4">
										<ul class="chart-legend clearfix">
											<li><i class="fa fa-circle-o text-green"></i> Ontime</li>
											<li><i class="fa fa-circle-o text-yellow"></i> Injury</li>
											<li><i class="fa fa-circle-o text-red"></i> Late</li>
											<li><i class="fa fa-circle-o text-blue"></i> Absent</li>
										</ul>
									</div>
								</div>
								<div class="box-footer no-padding">
									<ul class="nav nav-pills nav-stacked">
									<li><a href="#">Ontime ({{$count[2]}})
											<span class="pull-right text-green">+{{$persen[2]}}%</span></a>
										</li>
										<li><a href="#">Injury Time ({{$count[1]}})
											<span class="pull-right text-yellow">+{{$persen[1]}}%</span></a>
										</li>
										<li><a href="#">Late ({{$count[0]}})
											<span class="pull-right text-red">+{{$persen[0]}}%</span></a>
										</li>
										<li><a href="#">Absent ({{$count[4]}})
											<span class="pull-right text-blue">-{{$persen[3]}}%</span></a>
										</li>
										<li><a href="#"><b>Attendance ({{$count[3]}})</b>
											<span class="pull-right ">{{$persen[4]}}%</span></a>
										</li>
									</ul>
								</div>
							</div>
						</div>
					</div>
					<div class="box-body col-md-8">
						<table class="table table-bordered" id="table">
							<tbody>
								<tr>
									<th>My Schedule</th>
									<th>My Present Time</th>
									<th>Date</th>
									<th>Where</th>
									<th style="width: 40px">Status</th>
								</tr>
								@foreach($datas as $key =>$data)
									<tr>
										<td>{{$kehadiran[$key]->hadir}}</td>
										<td>{{$data->jam}}</td>
										<td>{{date("d/m/Y", strtotime($data->tanggal))}}</td>
										<td>{{$data->location}}</td>
										@if($data->late == "On-Time")
											<td style="vertical-align: middle;">
												<span class="label label-success" >{{$data->late}}</span>
											</td>
										@elseif($data->late == "Injury-Time")
											<td style="vertical-align: ;">
												<span class="label label-warning" >{{$data->late}}</span>
											</td>
										@elseif($data->late == "Late")
											<td style="vertical-align: ;">
												<span class="label label-danger" >{{$data->late}}</span>
											</td>
										@else
											<td style="vertical-align: ;">
												<span class="label label-info" >{{$data->late}}</span>
											</td>
										@endif
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>
					<div class="box-footer clearfix">
						<a href="{{url('downloadPDF',Auth::user()->id)}}">
							<button type="button" class="btn btn-primary pull-right" style="margin-right: 5px;">
								<i class="fa fa-download"></i> Download Report
							</button>
						</a>
						<p class="text-center">
							For more other history information. Click <b id="detail" style="cursor:pointer">here</b>
						</p>
						<br>
					</div>
				</div>

				<div class="box" id="panel_detail" style="display: none;">
					<div class="box-header with-border">
						<h3 class="box-title">My Attendance	</h3>			
					</div>
					<div class="box-body">
						<table class="table table-bordered" id="detail_table">
							<thead>
								<tr>
									<th>ID</th>
									<th>My Schedule</th>
									<th>My Present Time</th>
									<th>Date</th>
									<th>Where</th>
									<th style="width: 40px">Status</th>
								</tr>
							</thead>
							<tbody>
								@foreach($datas as $key =>$data)
								<tr>
									<td>{{$kehadiran[$key]->id}}</td>
									<td>{{$kehadiran[$key]->hadir}}</td>
									<td>{{$data->jam}}</td>
									<td>{{date("d/m/Y", strtotime($data->tanggal))}}</td>
									<td>{{$data->location}}</td>
									@if($data->late == "On-Time")
										<td style="vertical-align: middle;">
											<span class="label label-success" >{{$data->late}}</span>
										</td>
									@elseif($data->late == "Injury-Time")
										<td style="vertical-align: ;">
											<span class="label label-warning" >{{$data->late}}</span>
										</td>
									@elseif($data->late == "Absen")
										<td style="vertical-align: ;">
											<span class="label label-info" >{{$data->late}}</span>
										</td>
									@elseif($data->late == "Late")
										<td style="vertical-align: ;">
											<span class="label label-danger" >{{$data->late}}</span>
										</td>
									@endif
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
					<div class="box-footer clearfix">
						<p class="pull-right">For more other history information. Click <b id="simple" style="cursor:pointer">here</b></p>
					</div>
				</div>
			</section>
		</div>
	@endsection
	@section('script')
	<script src="https://cdn.datatables.net/1.10.4/js/jquery.dataTables.min.js"></script>
	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.4/css/jquery.dataTables.min.css">
	<script>
		$(document).ready(function(){
			console.log('asdfasdf');

			// Click to Detail
			$("#detail").click(function () {
				console.log('asdfasdf');
				$("#panel_simple").fadeOut(function () {
					$("#panel_detail").fadeIn();
				});
			});

			//Click to Simple
			$("#simple").click(function () {
				console.log('asdfasdf');
				$("#panel_detail").fadeOut(function () {
					$("#panel_simple").fadeIn();
				});
			});
		});
		$('#detail_table').dataTable();
		$('#table').dataTable();
	</script>
	@endsection