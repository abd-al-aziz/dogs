@php
$content = getContent('testimonial.content', true);
$testimonials = getContent('testimonial.element', false, 4);
@endphp

<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Testimonial
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
{{-- data-background="{{getImage(getFilePath('shapes').'/client-bg.png')}}" --}}
<section class="testimonial-section bg_img" >
    <div class="testimonial-top-shape">
        <img src="{{asset($activeTemplateTrue.'images/shape.png')}}" alt="shape">
    </div>
    <div class="testimonial-bottom-shape">
        <img src="{{asset($activeTemplateTrue.'images/shape.png')}}" alt="shape">
    </div>
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
        <div class="testimonial-area">
            <div class="testimonial-slider">
                <div class="swiper-wrapper">
                    @foreach($testimonials as $item)
                    <div class="swiper-slide">
                        <div class="testimonial-wrapper">
                            <div class="thumb profile-photo">
                                <img src="{{getImage(getFilePath('frontend').'/testimonial/'.$item->data_values->profile_photo)}}"
                                    alt="client">
                            </div>
                            <div class="content">
                                <h3 class="title">{{__($item->data_values->name)}}</h3>
                                <span class="sub-title">{{__($item->data_values->designation)}}</span>
                                <p>{{__($item->data_values->comment)}}</p>
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
    End Testimonial
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
