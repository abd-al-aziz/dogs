@extends($activeTemplate.'layouts.frontend')
@section('content')
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Blog
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<section class="service-section ptb-120">
	<div class="container">
		<div class="row justify-content-center mb-30-none">
			<div class="col-xl-8 col-lg-8 mb-30">
				<div class="row justify-content-center mb-30-none">
					<div class="col-xl-12 mb-30">
						<div class="service-item single">
							<div class="service-thumb">
								<img src="{{getImage(getFilePath('frontend').'/blog/'.$blog->data_values->image)}}"
									alt="service">
								<div class="blog-date">
									<h6 class="title">{{__($blog->data_values->date_month)}}</h6>
									<span class="sub-title">{{__($blog->data_values->year)}}</span>
								</div>
							</div>
							<div class="service-content wyg">
								<h2 class="title">{{__($blog->data_values->title)}}</h2>
								@php echo __($blog->data_values->description) @endphp
								<div id="share">

									<a class="facebook"
										href="https://www.facebook.com/share.php?u={{ Request::url() }}&title={{slug($blog->data_values->title)}}"
										target="_blank"><i class="lab la-facebook-f"></i></a>

									<a class="twitter"
										href="https://twitter.com/intent/tweet?status={{slug($blog->data_values->title)}}+{{ Request::url() }}"
										target="_blank"><i class="lab la-twitter"></i></a>

									<a class="linkedin"
										href="https://www.linkedin.com/shareArticle?mini=true&url={{ Request::url() }}&title={{slug($blog->data_values->title)}}&source=playpaws"
										target="_blank"><i class="lab la-linkedin-in"></i></a>

									<a class="pinterest"
										href="https://pinterest.com/pin/create/bookmarklet/?media={{getImage(getFilePath('frontend').'/blog/'.$blog->data_values->image)}}&url={{ Request::url() }}&is_video=false&description={{slug($blog->data_values->title)}}"
										target="_blank"><i class="lab la-pinterest-p"></i></a>

								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xl-4 col-lg-4 mb-30">
				<div class="sidebar">
					<div class="widget-box mb-30">
						<h4 class="widget-title">@lang('Other Blogs')</h4>
						<div class="category-widget-box">
							<ul class="category-list">
								@foreach($blogs as $item)
								<li><a
										href="{{ route('blog.details', ['slug' => slug($item->data_values->title), 'id' => $item->id])}}">{{__($item->data_values->title)}}</a>
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
    End Blog
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
@endsection
@push('style')
<style>
	/* container */

	#share {
		width: 100%;
		margin: 100px auto;
		text-align: center;
	}

	/* buttons */

	#share a {
		width: 50px;
		height: 50px;
		display: inline-block;
		margin: 8px;
		border-radius: 50%;
		font-size: 24px;
		color: #fff;
		opacity: 0.75;
		transition: opacity 0.15s linear;
	}

	#share a:hover {
		opacity: 1;
	}

	/* icons */

	#share i {
		position: relative;
		top: 50%;
		transform: translateY(-50%);
	}

	/* colors */

	.facebook {
		background: #1778f2;
	}

	.twitter {
		background: #1da1f2;
	}

	.linkedin {
		background: #0e76a8;
	}

	.pinterest {
		background: #cb2027;
	}
</style>
@endpush