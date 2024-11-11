@php
$content = getContent('pet_categories.content', true);
$categories = getContent('pet_categories.element', false, 6);
@endphp
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Category
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<section class="category-section bg--gray ptb-120">
    <div class="category-top-shape">
        <img src="{{asset($activeTemplateTrue.'images/shape.png')}}" alt="shape">
    </div>
    <div class="category-bottom-shape">
        <img src="{{asset($activeTemplateTrue.'images/shape.png')}}" alt="shape">
    </div>
    {{-- <div class="category-element">
        <img src="{{getImage(getFilePath('shapes').'/cat.png')}}" alt="cat">
    </div> --}}
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
        <div class="category-slider-wrapper">
            <div class="category-slider">
                <div class="swiper-wrapper">
                    @foreach($categories as $item)
                    <div class="swiper-slide">
                        <div class="category-item">
                            <div class="category-thumb">
                                <div class="round-top"></div>
                                <div class="round-bottom"></div>
                                <img src="{{getImage(getFilePath('frontend').'/pet_categories/'.$item->data_values->image)}}"
                                    alt="category">
                            </div>
                            <div class="category-content">
                                <h3 class="title">{{__($item->data_values->title)}}</h3>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End Category
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
