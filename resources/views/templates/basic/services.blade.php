@extends($activeTemplate.'layouts.frontend')
@section('content')
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Service
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<section class="service-section ptb-120">
    <div class="container">
        <div class="row justify-content-center mb-30-none">
            <div class="col-xl-8 col-lg-8 mb-30">
                <div class="row justify-content-center mb-30-none">
                    @foreach($services as $item)
                    <div class="col-xl-4 col-lg-6 col-md-6 mb-30">
                        <div class="service-item">
                            <div class="service-thumb">
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
            <div class="col-xl-4 col-lg-4 mb-30">
                <div class="sidebar">
                    <div class="widget-box mb-30">
                        <h4 class="widget-title">@lang('Other
                            Services')</h4>
                        <div class="category-widget-box">
                            <ul class="category-list">
                                @foreach($services as $item)
                                <li><a
                                        href="{{route('service.details', ['slug' => slug($item->data_values->title), 'id' => $item->id])}}">{{__($item->data_values->title)}}</a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End Service
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
@endsection