@extends($activeTemplate . 'layouts.master')
@section('content')
    <!-- ==================== Card Start Here ==================== -->
    <div class="py-5 ">
        <div class="container">
            <div class="row gy-4 justify-content-center">
                <h4>{{__($pageTitle)}}</h4>
                    <div class="card-wrap pb-30">
                        <table class="table table--responsive--lg">
                            <thead>
                                <tr>
                                    <th>@lang('Service Name')</th>
                                    <th>@lang('Email')</th>
                                    <th>@lang('Time')</th>
                                    <th>@lang('Message')</th>
                                    <th>@lang('Status')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($consultations as $consultation)
                                <tr>
                                    <td data-label="Service Name">{{__($consultation->service_name)}}</td>
                                    <td data-label="Email" class="fw-bold">{{__($consultation->email)}}</td>
                                    <td data-label="Time">{{showDateTime(($consultation->created_at))}} </td>
                                    <td data-label="Message">{{__($consultation->message)}}</td>
                                    <td data-label="Status">
                                       @if($consultation->status == 0)
                                       <span class="badge badge--warning">@lang('Pending')</span>
                                       @else
                                       <span class="badge badge--success">@lang('Completed')</span>
                                       @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td class="text-muted text-center" colspan="100%" data-label="Consultaion Table">{{ __($emptyMessage) }}</td>
                                </tr>
                                @endforelse

                            </tbody>
                        </table>
                    </div>
                </div>
                @if ($consultations->hasPages())
                <div class="d-flex justify-content-end">
                    {{ paginateLinks($consultations) }}
                </div>
                @endif
            </div>
        </div>
    </div>
    <!-- ==================== Card End Here ==================== -->
@endsection
