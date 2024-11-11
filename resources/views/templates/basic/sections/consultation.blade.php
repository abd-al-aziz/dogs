@php
$content = getContent('consultation.content', true);
$services = getContent('services.element');
@endphp

<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Get-in-toch
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<section class="get-in-touch-section pt-120">
    <div class="container">
        <div class="row justify-content-center align-items-center mb-30">
            <div class="col-xl-6 col-lg-6 mb-30">
                <div class="section-header">
                    <span class="section-sub-title">{{__($content->data_values->tag)}}</span>
                    <h2 class="section-title">{{__($content->data_values->heading)}}</h2>
                    <p>{{__($content->data_values->subheading)}}</p>
                    <img src="{{asset($activeTemplateTrue.'images/shape-blue.png')}}" alt="shape"
                        class="section-header-shpae">
                </div>
                <form class="get-in-touch-form" action="{{ route('book.consultation') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <select class="form--control" name="service_name" required>
                            <option value="">@lang('Select service')</option>
                            @foreach($services as $item)
                            <option value="{{ $item->data_values->title }}">{{__($item->data_values->title) }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="date" class="form--control" name="time" required>
                    </div>
                    <div class="form-group">
                        <input type="email" name="email" class="form--control"
                            placeholder="@lang('Enter your email')..." required>
                    </div>
                    <div class="form-group">
                        <textarea name="message" class="form--control"
                            placeholder="@lang('Enter your message')..."></textarea>
                    </div>
                    <x-captcha></x-captcha>
                    <div class="form-group">
                        <button type="submit" class="btn--base">@lang('Book Now')</button>
                    </div>
                </form>
            </div>
            <div class="col-xl-6 col-lg-6 mb-30">
                <div class="get-in-touch-thumb">
                    <img src="{{getImage(getFilePath('frontend').'/consultation/'.$content->data_values->image)}}"
                        alt="contact">
                </div>
            </div>
        </div>
    </div>
</section>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End Get-in-touch
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
