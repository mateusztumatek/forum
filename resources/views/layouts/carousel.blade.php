@php
    $carousel = \App\Services\LayoutService::getCarousel();
@endphp
@if($carousel->count() > 0)
<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
    <div class="carousel-inner">
        @foreach($carousel as $index => $item)
        <div class="carousel-item @if($index == 0) active @endif">
            <div class="content">
                <div class="container">
                    <div class=" @if($item->alignment)content-{{$item->alignment}}@endif">
                        <div class="my-header">
                            <h4>{{$item->name}}</h4>
                            <span>{!! $item->content !!}</span>
                        </div>
                        @if($item->data && property_exists($item->data, 'links'))
                            <div class="row">
                                @foreach($item->data->links as $link)
                                    <div class="col-auto">
                                        <a href="{{$link->url}}"><v-btn tile color="black" outlined style="min-height: 50px" elevation="0">{{$link->text}}</v-btn></a>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <img class="d-block w-100" src="{{url('/storage/'.$item->images)}}" alt="First slide">
        </div>
            @endforeach
    </div>
    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>
    @else
<div style="padding-top: 64px"></div>
@endif