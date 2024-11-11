@php
$content = getContent('about.content', true);
$blogs = getContent('blog.element', false, 4);
@endphp
<section class="service-section ptb-120">
    <div class="container">
        <div class="row justify-content-center mb-30-none gx-5 flex-wrap-reverse">
            <div class="col-xl-6 col-lg-6 mb-30">
                <div class="row justify-content-center mb-30-none">
                    <div class="col-xl-12 mb-30">
                        <div class="service-item single">
                            <div class="service-thumb">
                                <img src="{{getImage(getFilePath('frontend').'/about/'.$content->data_values->image)}}"
                                    alt="service">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 mb-30">
                <div class="row justify-content-center mb-30-none">
                    <div class="wyg">
                        <h2 class="title">{{__($content->data_values->heading)}}</h2>
                        @php echo __($content->data_values->description) @endphp
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</section>