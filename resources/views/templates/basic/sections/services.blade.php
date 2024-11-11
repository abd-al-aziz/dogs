@php
$content = getContent('services.content', true);
$services = getContent('services.element', false, 4);
@endphp

<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Service
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<section class="service-section ptb-120">
    <img src="{{asset($activeTemplateTrue.'images/service-bg.png')}}" alt="shape" class="service-shape-bg">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-6 text-center">
                <div class="section-header">
                    <span class="section-sub-title">@lang('Services')</span>
                    <h2 class="section-title">{{ __($content->data_values->heading) }}</h2>
                    <p>{{ __($content->data_values->description) }}</p>
                    <img src="{{asset($activeTemplateTrue.'images/shape-blue.png')}}" alt="shape"
                        class="section-header-shpae">
                </div>
            </div>
        </div>
        <div class="row justify-content-center mb-30-none">
            @foreach($services as $item)
            <div class="col-xl-3 col-lg-4 col-md-6 mb-30">
                <div class="service-item">
                    <div class="service-thumb">
                        <div class="service-shape"></div>
                        <a
                            href="{{route('service.details', ['slug' => slug($item->data_values->title), 'id' => $item->id])}}"><img
                                src="{{getImage(getFilePath('frontend').'/services/'.$item->data_values->image)}}"
                                alt="service-image"></a>
                    </div>
                    <div class="service-content">
                        <h3 class="title"><a
                                href="{{route('service.details', ['slug' => slug($item->data_values->title), 'id' => $item->id])}}">{{__($item->data_values->title)}}</a>
                        </h3>
                        <p> {{ __(strip_tags(substr($item->data_values->description, 0, 100))) }} </p>
                        <div class="service-btn">
                            <a
                                href="{{route('service.details', ['slug' => slug($item->data_values->title), 'id' => $item->id])}}">@lang('Learn
                                more')</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End Service
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
