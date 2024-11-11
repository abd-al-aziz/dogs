@extends($activeTemplate.'layouts.frontend')
@section('content')
<section class="service-section ptb-120">
    <div class="container">
        <div class="row justify-content-center mb-30-none">
            <div class="col-xl-8 col-lg-8 mb-30">
                <div class="row justify-content-center mb-30-none">
                    @foreach($blogs as $item)
                    <div class="col-md-6 mb-30">
                        <div class="blog-item">
                            <div class="blog-thumb">
                                <a
                                    href="{{ route('blog.details', ['slug' => slug($item->data_values->title), 'id' => $item->id])}}"><img
                                        src="{{getImage(getFilePath('frontend').'/blog/'.$item->data_values->image)}}"
                                        alt="blog"></a>
                            </div>
                            <div class="blog-content">
                                <div class="blog-date">
                                    <h6 class="title">{{__($item->data_values->date_month)}}</h6>
                                    <span class="sub-title">{{__($item->data_values->year)}}</span>
                                </div>
                                <span class="category">@lang('Latest News')</span>
                                <h4 class="title"><a
                                        href="{{ route('blog.details', ['slug' => slug($item->data_values->title), 'id' => $item->id])}}">{{__($item->data_values->title)
                                        }}</a></h4>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="col-xl-4 col-lg-4 mb-30">
                <div class="sidebar">
                    <div class="widget-box mb-30">
                        <h4 class="widget-title">@lang('Services')</h4>
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
@endsection