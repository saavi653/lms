@include('layout.main')
@include('flash')
<div class="dashboard">
    <div>
        <img src="https://static.wixstatic.com/media/9e41e2_fb90fd7e41414c548936b423387b0554~mv2.png/v1/fill/w_538,h_108,al_c,q_85,usm_0.66_1.00_0.01,enc_auto/SC%20Top%20Logo1.png" alt="loding">
    </div>
    <div class="d1" >
        <a href="{{ route('dashboard') }}">OVERVIEW </a>
    </div>
    <div class="d1" id="{{ Request::url() == route('users.index')?'highlight':''}}">
        <a href="{{ route('users.index') }}">USERS</a>
    </div>
    <div class="d1">
        <a href="">COURSES</a>
    </div>
    <div class="d1">
        <a href="">REPORTS</a>
    </div>
    @if(!Auth::user()->is_trainer)
    <div class="d1" id="{{ Request::url() == route('categories.index')?'highlight':''}}">
        <a href="{{ route('categories.index') }}">CATEGORIES</a>
        @endif
    </div>
</div>
