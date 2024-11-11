@extends($activeTemplate.'layouts.'.$layout)
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card custom--card">
                <div class="d-flex justify-content-between p-3">
                    <h5 class="mt-0 text-primary">
                        @php echo $myTicket->statusBadge; @endphp
                        [@lang('Ticket')#{{ $myTicket->ticket }}] {{ $myTicket->subject }}
                    </h5>
                    @if($myTicket->status != 3 && $myTicket->user)
                    <button title="@lang('Close Ticket')"
                        class="btn btn--danger text-white btn-sm confirmationBtn rounded" type="button"
                        data-question="@lang('Are you sure to close this ticket?')"
                        data-action="{{ route('ticket.close', $myTicket->id) }}">@lang('Close Ticket')
                    </button>
                    @endif
                </div>
                <div class="card-body">
                    @if($myTicket->status != 4)
                    <form method="post" action="{{ route('ticket.reply', $myTicket->id) }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row justify-content-between">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <textarea name="message" class="form--control"
                                        rows="7">{{ old('message') }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">@lang('Attachments')</label>
                            <input type="file" name="attachments[]" class="form-control-file" />
                            <div id="fileUploadsContainer"></div>
                            <p class="my-2 ticket-attachments-message text-muted">
                                @lang('Allowed File Extensions'): .@lang('jpg'), .@lang('jpeg'), .@lang('png'),
                                .@lang('pdf'), .@lang('doc'), .@lang('docx')
                            </p>
                        </div>
                        <div class="mb-4">
                            <button type="button" class="btn btn--primary btn-sm addFile text-white rounded">
                                <i class="fa fa-plus"></i> @lang('Add New')
                            </button>
                        </div>
                        <div class="form-group text-end">
                            <button type="submit" class="btn btn--base"></i>
                                @lang('Reply')</button>
                        </div>
                    </form>
                    @endif
                </div>
            </div>
            <div class="card mt-4">
                <div class="card-body">
                    <h5>@lang('Replies')</h5>
                    @foreach($messages as $message)
                    @if($message->admin_id == 0)
                    <div class="row user-reply float-end pb-4">
                        <div class="col">
                            <p class="text-muted fw-bold my-3"><span class="text--primary">
                                    </span> @lang('You Replied on') {{ showDateTime($message->created_at, 'l, dS F Y @
                                H:i') }}
                            </p>
                            <p>{{ $message->message }}</p>
                            @if($message->attachments->count() > 0)
                            <div class="my-3">
                                @foreach($message->attachments as $k=> $image)
                                <a href="{{route('admin.ticket.download',encrypt($image->id))}}" class="me-2"><i
                                        class="fa fa-file"></i>
                                    @lang('Attachment') {{++$k}}</a>
                                @endforeach
                            </div>
                            @endif
                        </div>
                    </div>
                    @else
                    <div class="row admin-reply pb-4">
                        <div class="col">
                            <p class="text-muted fw-bold my-3">
                                <span class="text--primary">{{ @$message->admin->name }}</span> @lang('replied on')
                                {{showDateTime($message->created_at,'l, dS
                                F Y @ H:i') }}
                            </p>
                            <p>{{ $message->message }}</p>
                            @if($message->attachments->count() > 0)
                            <div class="my-3">
                                @foreach($message->attachments as $k=> $image)
                                <a href="{{route('admin.ticket.download',encrypt($image->id))}}" class="me-2"><i
                                        class="fa fa-file"></i>
                                    @lang('Attachment') {{++$k}} </a>
                                @endforeach
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif
                    @endforeach
                </div>
            </div>

        </div>
    </div>
</div>

<x-confirmation-modal></x-confirmation-modal>
@endsection
@push('style')
<style>
    .input-group-text:focus {
        box-shadow: none !important;
    }
</style>
@endpush
@push('script')
<script>
    (function ($) {
        "use strict";
        var fileAdded = 0;
        $('.addFile').on('click', function () {
            if (fileAdded >= 4) {
                notify('error', 'You\'ve added maximum number of file');
                return false;
            }
            fileAdded++;
            $("#fileUploadsContainer").append(`
                    <div class="input-group my-3">
                        <input type="file" name="attachments[]" class="form-control form--control" required />
                        <button class="input-group-text btn-danger remove-btn"><i class="las la-times"></i></button>
                    </div>
                `)
        });
        $(document).on('click', '.remove-btn', function () {
            fileAdded--;
            $(this).closest('.input-group').remove();
        });
    })(jQuery);

</script>
@endpush