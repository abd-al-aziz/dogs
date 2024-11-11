@php
$content = getContent('faq.content', true);
$faqs = getContent('faq.element', false, 4);
@endphp

<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Faq
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<section class="faq-section ptb-120">
    <img src="{{asset($activeTemplateTrue.'images/service-bg.png')}}" alt="shape" class="service-shape-bg">
    <div class="container">
        <div class="row justify-content-center align-items-center mb-30-none flex-wrap-reverse">
            <div class="col-xl-6 col-lg-6 mb-30">
                <div class="faq-thumb">
                    <img src="{{getImage(getFilePath('frontend').'/faq/'.$content->data_values->image)}}" alt="faq">
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 mb-30">
                <div class="section-header">
                    <span class="section-sub-title">{{__($content->data_values->tag)}}</span>
                    <h2 class="section-title">{{__($content->data_values->heading)}}</h2>
                    <p>{{__($content->data_values->subheading)}}</p>
                    <img src="{{asset($activeTemplateTrue.'images/shape-blue.png')}}" alt="shape"
                        class="section-header-shpae">
                </div>
                <div class="faq-wrapper">
                    @foreach($faqs as $item)
                    <div class="faq-item {{ $loop->index == 0 ? 'active open' : null }}">
                        <h3 class="faq-title"><span class="title">{{ __($item->data_values->question) }}</span><span
                                class="right-icon"></span></h3>
                        <div class="faq-content">
                            @php echo __($item->data_values->answer) @endphp
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End Faq
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
