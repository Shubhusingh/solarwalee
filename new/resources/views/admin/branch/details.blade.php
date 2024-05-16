@extends('admin.layouts.app')
@section('panel')
    <div class="row gy-4">
        <div class="col-xxl-3 col-sm-6">
            <x-widget style="3" bg="success" color="white" icon="la la-wallet" title="Total Deposited" value="{{ $general->cur_sym }}{{ showAmount($widget['total_deposited']) }}" link="admin.deposit.list" query_string="branch={{ $branch->id }}" />
        </div>

        <div class="col-xxl-3 col-sm-6">
            <x-widget style="3" bg="danger" color="white" icon="la la-hand-holding-usd" title="Total Withdrawn" value="{{ $general->cur_sym }}{{ showAmount($widget['total_withdrawals']) }}" link="admin.withdraw.log" query_string="branch={{ $branch->id }}" />
        </div>

        <div class="col-xxl-3 col-sm-6">
            <x-widget style="3" bg="info" color="white" icon="la la-wallet" title="Total Account" value="{{ getAmount($widget['total_account']) }}" link="admin.users.all" query_string="branch={{ @$branch->id }}" />
        </div>

        <div class="col-xxl-3 col-sm-6">
            <x-widget style="3" bg="17" color="white" icon="la la-wallet" title="Total Staff" value="{{ getAmount($widget['total_staff']) }}" link="admin.branch.staff.index" query_string="branch={{ @$branch->id }}" />
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            @include('admin.branch.form')
        </div>
    </div>
@endsection

@can('admin.branch.index')
    @push('breadcrumb-plugins')
        <x-back route="{{ route('admin.branch.index') }}" />
    @endpush
@endcan
