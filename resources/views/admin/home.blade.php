@extends('layouts.admin')
@section('content')
<div class="card">
    <div class="card-header">{{ __('Dashboard') }}</div>
    <div class="card-body">
        {{ __('You are logged in!') }}
        <div class="row row-cards">
          <div class="col-6 col-sm-4 col-lg-2">
            <div class="card">
              <div class="card-body p-3 text-center">
                <div class="text-right text-green">
                </div>
                <div class="h3 m-0">{{ (isset($totalUsers) && !empty($totalUsers)) ? $totalUsers : 0 }}</div>
                <div class="text-muted mb-4">Total Users</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-sm-4 col-lg-2">
        <div class="card">
          <div class="card-body p-3 text-center">
            <div class="text-right text-red">
            </div>
            <div class="h3 m-0">{{ (isset($technicians) && !empty($technicians)) ? $technicians : 0 }}</div>
            <div class="text-muted mb-4">Total Technicians</div>
        </div>
    </div>
</div>
<div class="col-6 col-sm-4 col-lg-2">
    <div class="card">
      <div class="card-body p-3 text-center">
        <div class="text-right text-green">
        </div>
        <div class="h3 m-0"><?php echo (isset($totalAdminIncome) && !empty($totalAdminIncome)) ? $totalAdminIncome : 0; ?></div>
        <div class="text-muted mb-4">Total Income</div>
    </div>
</div>
</div>

<div class="col-6 col-sm-4 col-lg-2">
    <div class="card">
      <div class="card-body p-3 text-center">
        <div class="text-right text-green">
        </div>
        <div class="h3 m-0"><?php echo (isset($todayIncome) && !empty($todayIncome)) ? $todayIncome : 0; ?></div>
        <div class="text-muted mb-4">Today Income</div>
    </div>
</div>
</div>

<div class="col-6 col-sm-4 col-lg-2">
    <div class="card">
      <div class="card-body p-3 text-center">
        <div class="text-right text-green">

        </div>
        <div class="h3 m-0"><?php echo (isset($totalTransaction) && !empty($totalTransaction)) ? $totalTransaction : 0; ?></div>
        <div class="text-muted mb-4">Total Orders</div>
    </div>
</div>
</div>
<div class="col-6 col-sm-4 col-lg-2">
    <div class="card">
      <div class="card-body p-3 text-center">
        <div class="text-right text-red">
        </div>
        <div class="h3 m-0"><?php echo (isset($todayTransaction) && !empty($todayTransaction)) ? $todayTransaction : 0; ?></div>
        <div class="text-muted mb-4">Today Orders</div>
    </div>
</div>
</div>
<div class="col-6 col-sm-4 col-lg-2">
    <div class="card">
      <div class="card-body p-3 text-center">
        <div class="text-right text-red">
        </div>
        <div class="h3 m-0"><?php echo isset($totalAdminCommission) ? number_format($totalAdminCommission, 2, '.', '') : 0; ?></div>
        <div class="text-muted mb-4">Total Commission</div>
    </div>
</div>
</div>
</div>
</div>
@endsection