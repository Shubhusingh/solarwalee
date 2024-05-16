@extends('admin.layouts.app')

@section('panel')
    <div class="row">

        <div class="col-xl-12">
            <div class="card">
                <form action="{{ route('admin.subscriber.send.email.submit') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label>@lang('Subject')</label>
                                <input type="text" class="form-control" name="subject" required value="{{ old('subject') }}" />
                            </div>
                            <div class="form-group col-md-12">
                                <label>@lang('Body')</label>
                                <textarea name="body" rows="10" class="form-control nicEdit">{{ old('body') }}</textarea>
                            </div>
                        </div>
                    </div>
                    @can('admin.subscriber.send.email.submit')
                        <div class="card-footer">
                            <button type="submit" class="btn btn--primary w-100 h-45">@lang('Submit')</button>
                        </div>
                    @endcan
                </form>
            </div>
        </div>
    </div>
@endsection

@can('admin.subscriber.index')
    @push('breadcrumb-plugins')
        <x-back route="{{ route('admin.subscriber.index') }}" />
    @endpush
@endcan
