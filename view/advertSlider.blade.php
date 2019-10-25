<div class="swiper-container swiper-slider swiper-slider-1 swiper-container-horizontal swiper-container-fade" data-loop="true" data-slide-effect="fade" data-autoplay="4000" data-simulate-touch="false">
    <div class="swiper-wrapper" style="transition-duration: 0ms;">
        @foreach($adverts as $advert)
            <div class="swiper-slide" data-slide-bg="{{ $advert->getFirstMediaUrl() }}" data-pagination-text="02" style="background-image: url({{ $advert->getFirstMediaUrl() }}); background-size: cover; width: 1515px; transform: translate3d(-3030px, 0px, 0px); opacity: 1; transition-duration: 0ms; cursor:pointer;" onclick="document.location='{{ $advert->getURL() }}'">
                <article class="tour-1-2 context-dark">
                </article>
            </div>
        @endforeach
    </div>
</div>
