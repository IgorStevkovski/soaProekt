<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <link href="{{asset('css/belgrade.css')}}" rel="stylesheet" type="text/css">
    {{--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>--}}
    <script src="{{asset('js/jquery-3.1.0.min.js')}}"></script>
    <script src="{!! asset('js/belgrade.js') !!}" type="text/javascript"></script>

</head>
<body id="telo">

  <div id="container">
    <div id="gornoMeni">
        <div id="naslovMeni">
            YuConnect: {!! $user !!}
        </div>
        <div id="logoutLinkMeni">
            <a href="{!! action("Auth\\AuthController@getLogout")!!}">Log out</a>
        </div>
    </div>

      <div id="greski">
          @if($errors->any())
              <ul>
                  @foreach($errors->all() as $error)
                      <li>{!! $error !!}</li>
                  @endforeach
              </ul>
          @endif
      </div>


      <div id="kartaITemp">
    {{-- GoogleMaps - Karta na Beograd --}}
    <iframe id="mapaBeograd" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d181139.35491205094!2d20.282511716591962!3d44.81540328988179!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x475a7aa3d7b53fbd%3A0x1db8645cf2177ee4!2sBelgrade%2C+Serbia!5e0!3m2!1sen!2s!4v1473979161535" width="500" height="250" frameborder="0" style="border:0" allowfullscreen></iframe>

    {{--Za temperaturata--}}
    <div id="forecastDiv">
        <span id="bgdCity">Beograd, Srbija</span>
        {{--<span id="currentWeather">current weather:</span>--}}
        <div id="tempDiv">
            <div id="slikaTemperatura"><img  width="100px" height="70px" src="{!! asset("photosWeather/".$icon.".png") !!}"></div>
            <p id="temperatura">{!! $temp !!} &#x2103;</p>
        </div>
        <div id="description">
            <div id="weatherDesc"><span>Description: <big>{!! $main !!}</big></span></div>
            <div id="weatherDesc2"><p><i>{!! $description !!}</i></p></div>
        </div>
    </div>
    </div>


    {{--LISTA OD RESTORANITE--}}
      <div id="restorani">
          <input type="button" id="btnHoteli" value="Hotels&Restaurants">
          <div id="listaHoteli">
              @foreach($result['results'] as $item)
                  <h5 id="imeHotel">{!! $item['name'] !!}</h5>
                  {{--<h4>{{ $item['rating'] }} </h4>--}}
                  <span><small>{!! $item['vicinity'] !!}</small></span>
              @endforeach
          </div>
      </div>

      {{-- SITE POSTOVI SO SE FORMATA ZA VNASANJE POST--}}
    <div id="postoviDiv">
      {{-- Forma za vnasanje post  action="/laravelProektSOA/public/city/belgrade" --}}
      <div id="formEnterPostDiv">
        <form method="post" name="enterPost" action="{!! action("CityController@belgradeCreatePost") !!}" enctype="multipart/form-data" files="true">

            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <label>Tell the others!</label>
            <br>
            <textarea rows="4" cols="45" name="comment" placeholder="Write something here..."></textarea>
            <br>
            <label>Choose photo:</label>
            <br>
            <div>
                <input type="file" name="photoToUpload" id="photoToUpload">
                <input id="btnObjaviPost" type="submit" name="postiraj" value="Post">
            </div>
        </form>
      </div>

    {{-- Lista od site Belgrade Postovi --}}

        @foreach($posts as $post)
            <div id="eachPostDiv">
                <p id="imeUser">{!! $post->user->name !!}</p>
                <h3 id="komentarUser">{!! $post->body !!}</h3>
                @if($post->photo != "")
                    <div id="slikaID">
                        <img id="slikaInPost" src="{!! asset($post->photo) !!}" width="300" height="260">
                    </div>
                @endif
                <div id="likesDiv">

                    <form method="post" name="like{!! $post->id !!}" id="likeSubmit-{!! $post->id !!}" action="/city/belgrade/insertLike">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="brojPost" value="{!! $post->id !!}">
                        <button name="submitLike" id="like~{!! $post->id !!}">Like</button>
                    </form>

                    <span id="LikesPTag">Likes: {!! $post->likesNumber !!}</span>
                        {{--<a href="javascript:addLike();" id="like~{!! $post->id !!}">Like</a>--}}
                </div>

                <div id="komentariDiv">
                    <form method="post" name="post{!! $post->id !!}" id="postComment-{!! $post->id !!}" action="/city/belgrade/createComment">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="brojPost" value="{!! $post->id !!}">
                        <textarea rows="2" cols="40" name="inputForPost{!! $post->id !!}" id="inputForPost{!! $post->id !!}" placeholder="Write comment..."></textarea>
                        <br>
                        <button name="submitComment" id="submitComment~{!! $post->id !!}">Post comment!</button>
                    </form>
                    @if(count($post->comments) >= 0)
                        <button id="comments~{!! $post->id !!}" name="show_Comments">Show Comments</button>
                    @endif
                </div>
                <div id="komentari{!! $post->id !!}" hidden="true">
                    {{--{!! $comments=$post->comments !!}--}}
                    @foreach($post->comments as $comment)
                        <p id="komentarRecenica">{!! $comment->user->name !!}: {!! $comment->body !!}</p>
                    @endforeach
                </div>
            </div>
        @endforeach


    </div>

    <script>
        $(document).ready(function() {
            var br = 0;
            $("[id^=comments]").click(function (event) {

                var id = event.target.id;//id-to od elementot sto go predizvikal klikot u slucajov
                var values = id.split('~');
                var broj = values[1];
                var res = "#komentari"+broj;

                if (br == 0) {
                    $(res).hide();
                    br = 1;
                }
                else {
                    $(res).show();
                    br = 0;
                }
            });

            $("[id^=postComment]").submit(function(event){

                var id = event.target.id;//id-to od elementot sto go predizvikal klikot u slucajov
                var values = id.split('-');
                var broj = values[1];
                var res = "#postComment-"+broj;
                document.write(id);
                //var res2 = "#inputForPost"+broj;

//                $.ajaxSetup({
//                    headers: {
//                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//                    }
//                });

                $('res').submit(function(e){

                    $.ajax({
                        type: "POST",
                        url:"laravelProektSOA/public/city/belgrade/createComment",
                        //url:"CityController@belgradeCreateComment",
                        data: $(id).serialize(),

                        success: function(data){
                            alert(data);
                            //console.log(data);
                        }
                    });
                    e.preventDefault();


                    //document.write(res);

                });
            });

            $("[id^=likeSubmit]").submit(function(event){
                var id = event.target.id;//id-to od elementot sto go predizvikal klikot u slucajov
                var values = id.split('-');
                var broj = values[1];
                var res = "#likeSubmit-"+broj;
                $('res').submit(function(e){

                    $.ajax({
                        type: "POST",
                        url:"laravelProektSOA/public/city/belgrade/insertLike",
                        //url:"CityController@belgradeCreateComment",
                        data: $(id).serialize(),

                        success: function(data){
                            alert(data);
                            //console.log(data);
                        }
                    });
                    e.preventDefault();


                    //document.write(res);

                });

            });
//            $("[id^=like]").click(function(event){
//                var id = event.target.id;//id-to od elementot sto go predizvikal klikot u slucajov
//                var values = id.split('~');
//                var broj = values[1];
//                //document.write(id);
//
//                $.ajax({
//                    type:"POST",
//                    url:"laravelProektSOA/public/city/belgrade/insertLike",
//                    data:broj.serialize(),
//                    success:function(data){
//                        alert(data);
//                    }
//
//                });
//                e.preventDefault();
//            });

//            function addLike(event)
//            {
//                var id = event.target.id;//id-to od elementot sto go predizvikal klikot u slucajov
//                var values = id.split('~');
//                var broj = values[1];
//                $.ajaxSetup({
//                   headers: {
//                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//                    }
//                });
//                $.ajax({
//                    type: "POST",
//                    url: "laravelProektSOA/public/city/belgrade/insertLike",
//                    data: broj.serialize(),
//                    //dataType: "html",
//                });
//            }
        });

    </script>
    </div>
</body>
</html>
