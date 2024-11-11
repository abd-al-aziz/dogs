@php
$content = getContent('features.content', true);
$categories = getContent('features.element', false, 4);
@endphp

<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Feature
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<section class="feature-section ptb-120">
    <div class="container">
        <div class="row justify-content-center mb-30-none">
            <div class="col-xl-6 col-lg-6 mb-30 align-items-center d-flex">
                <div class="section-header mb-0">
                    <span class="section-sub-title">{{__($content->data_values->tag)}}</span>
                    <h2 class="section-title">{{__($content->data_values->heading)}}</h2>
                    <img src="{{asset($activeTemplateTrue.'images/shape-blue.png')}}" alt="shape"
                        class="section-header-shpae">
                    <p>{{__($content->data_values->description)}}</p>
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 mb-30">
                <div class="feature-item-area">
                    <div class="row justify-content-center mb-30-none">
                        @foreach($categories as $item)
                        <div class="col-xl-6 col-lg-6 mb-30">
                            <div class="feature-item">
                                <div class="thumb">
                                    <div class="feature-icon text--primary">
                                        @php echo $item->data_values->icon; @endphp
                                    </div>
                                </div>
                                <div class="content">
                                    <h3 class="title">{{__($item->data_values->title)}}</h3>
                                    <p>{{__($item->data_values->description)}}</p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End Feature
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
