<h3> Hi! On our site appeared new ads! </h3>
<div class="container">
    <div class="row">
        @foreach ($ads as $ad) {
        <div class="col-4 content">
            <div class="card">
                <img src="{{ $ad->image_url }}" class="card-img-top" alt="ad image">
                <div class="card-body">
                    <a class="card-title" href="{{route('ads.show', $ad->id)}}">{{ $ad->title }} </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
<p> for see more asd please click <a href="{{ route('ads.index')}}">here</a>!</p>


