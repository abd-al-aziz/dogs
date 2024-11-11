@php
$content = getContent('call_out.content', true);
@endphp
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Call-to-action
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<section class="call-to-action-section pt-120">
    <div class="container">
        <div class="call-to-action-thumb">
            <img src="{{getImage(getFilePath('frontend').'/call_out/'.$content->data_values->background_image)}}"
                alt="call-to-action">
            <div class="call-to-action-wrapper">
                <div class="content">
                    <h2 class="title">{{__($content->data_values->heading)}}</h2>
                </div>
                <div class="btn-wrapper">
                    <a class="btn--base"
                        href="{{ route('home').$content->data_values->button_url }}">{{__($content->data_values->button_text)}}</a>
                </div>
            </div>
        </div>
    </div>
</section>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End Call-to-action
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->