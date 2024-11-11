@php
$content = getContent('blog.content', true);
$blogs = getContent('blog.element', false, 3);
@endphp

<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Blog
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<section class="blog-section pt-120">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-6 text-center">
                <div class="section-header">
                    <span class="section-sub-title">{{__($content->data_values->tag)}}</span>
                    <h2 class="section-title">{{__($content->data_values->heading)}}</h2>
                    <p>{{__($content->data_values->subheading)}}</p>
                    <img src="{{asset($activeTemplateTrue.'images/shape-blue.png')}}" alt="shape"
                        class="section-header-shpae">
                </div>
            </div>
        </div>
        <div class="row justify-content-center mb-30-none">
            @foreach($blogs as $item)
            <div class="col-xl-4 col-lg-4 col-md-6 mb-30">
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
        <div class="browse-more-btn text-center mt-4">
            <a href="{{ route('blogs') }}" class="btn--base">@lang('Browse more')</a>
        </div>
    </div>
</section>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End Blog
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
