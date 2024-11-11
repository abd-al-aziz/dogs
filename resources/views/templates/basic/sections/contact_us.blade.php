@php
$content = getContent('contact_us.content', true);
@endphp




<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Contact
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<section class="contact-section pt-80">
    <div class="container">
        <div class="row justify-content-center mb-30-none">
            <div class="col-xl-5 col-lg-5 mb-30">
                <div class="contact-widget">
                    <div class="contact-form-header">
                        <h2 class="title">{{ __($content->data_values->title) }}</h2>
                        <p>{{ __($content->data_values->short_details) }}</p>
                    </div>
                    <ul class="contact-item-list">
                        <li>
                            <div class="d-flex">
                                <div class="contact-item-icon">
                                    <i class="las la-map"></i>
                                </div>
                                <div class="contact-item-content">
                                    <h5 class="title">@lang('Our Location')</h5>
                                    <span class="sub-title">{{$content->data_values->address}}</span>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="d-flex">
                                <div class="contact-item-icon">
                                    <i class="las la-phone-volume"></i>
                                </div>
                                <div class="contact-item-content">
                                    <h5 class="title">{{$content->data_values->contact_number}}</h5>
                                    <span class="sub-title">{{$content->data_values->office_hour}}</span>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="d-flex">
                                <div class="contact-item-icon">
                                    <i class="las la-envelope"></i>
                                </div>
                                <div class="contact-item-content">
                                    <h5 class="title">@lang('Email Us Directly')</h5>
                                    <span class="sub-title">{{$content->data_values->email_address}}</span>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-xl-7 col-lg-7 mb-30">
                <div class="map-area">
                    <iframe
                        src="https://maps.google.com/maps?q={{$content->data_values->latitude}},{{$content->data_values->longitude}}&z=15&output=embed"></iframe>
                </div>
            </div>
        </div>
    </div>
</section>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End Contact
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->