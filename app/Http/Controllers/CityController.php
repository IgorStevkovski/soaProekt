<?php

namespace App\Http\Controllers;

use App\Post;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class CityController extends Controller
{
    protected $rules=[
        'comment'=>'required',
        'photoToUpload'=>'image|mimes:jpg,jpeg,png,gif'
    ];

//    protected $rules2=[
//        'comment2'=>'required',
//    ];

    public function __construct(){
        $this->middleware('auth');
    }
    public function belgrade()
    {
        //$grad=$city;
        //echo $grad;

        //ZA RESTORANI PODATOCI
        $urlRestaurants = "https://maps.googleapis.com/maps/api/place/nearbysearch/json?location=44.7841234,20.493831&radius=5000&type=restaurant&key=AIzaSyBS-8fBOylCzgawf5QHJ15tafvGY-LbRB8";

        $client = curl_init();
        curl_setopt($client, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($client, CURLOPT_URL, $urlRestaurants);

        $response = curl_exec($client);
        curl_close($client);

        $result=json_decode($response, true);
        //echo $response;
        //print_r($result);

        //ZA TEMPERATURA PODATOCI
        //$urlWeather = "http://api.openweathermap.org/data/2.5/weather?id=3194360&units=metric&APPID=e6f9fdc2ec532ace998cc13a286b5d37";
        $urlWeather ="http://api.openweathermap.org/data/2.5/weather?id=792680&units=metric&APPID=e6f9fdc2ec532ace998cc13a286b5d37";

        $client2 = curl_init();
        curl_setopt($client2, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($client2, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($client2, CURLOPT_URL, $urlWeather);

        $response2 = curl_exec($client2);
        curl_close($client2);

        $result2 = json_decode($response2, true);

        $weather = $result2['weather'];
        $main = $weather[0]['main'];
        $description = $weather[0]['description'];
        $temp = $result2['main']['temp'];
        $icon = $weather[0]['icon'];


        //Listanje na site Belgrade Postovi
        $posts = \App\Post::where('city','belgrade')->get();
        //print_r($posts);
        $user = \Auth::user()->name;
        return view('belgrade',compact('result','main','temp','description','icon','posts','user'));
        //return view('belgrade',compact('result','posts','user'));
    }

    public function belgradeCreatePost(Request $request)
    {
        $this->validate($request,$this->rules);

        $file=$request->file('photoToUpload');


        if($file != null)
        {
            $destination_path='postsPhotos/';
            $filename=$file->getClientOriginalName();
            $file->move($destination_path,$filename);
        }

        $comment = new \App\Post;
        $comment->user_id = \Auth::user()->id;
        $comment->body=$request['comment'];
        $comment->active=1;
        $comment->city="belgrade";
        $comment->likesNumber=0;
        if($file != null)
        {
            $destination_path='postsPhotos/';
            $filename=$file->getClientOriginalName();
            $comment->photo = $destination_path.$filename;
        }
        else
            $comment->photo = "";

        $comment->published_at = Carbon::now();

        $comment->save();

        return redirect('city/belgrade');
    }

    public function belgradeShowComment()
    {
        echo 'radi';
    }

    public function belgradeCreateComment(Request $request)
    {
        //$this->validate($request,$this->rules2);

        $textAreaBroj = "inputForPost".$request['brojPost'];
        //return $request[$textAreaBroj];
        $komentar = $request[$textAreaBroj];

        //print_r($komentar);
        $comment = new \App\Comment;
        $comment->post_id = $request['brojPost'];
        $comment->user_id = \Auth::user()->id;
        $comment->body = $komentar;
        $comment->likesNumber = 0;
        $comment->published_at = Carbon::now();

        $comment->save();

        return redirect('city/belgrade');
        //return "uspesno";
    }

    public function belgradeInsertLike(Request $request)
    {
        $idPost = $request['brojPost'];
        $post = Post::where('id',$idPost)->first();
        //echo $post->likesNumber;
        $post->likesNumber+=1;
        $post->update();

        return redirect('city/belgrade');
    }
}
