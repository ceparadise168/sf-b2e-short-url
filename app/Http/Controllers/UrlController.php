<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class UrlController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirect($shortUrl)
    {
        $urlInfo = Redis::hGetAll('url_info:'.$shortUrl);

        if (count($urlInfo) !== 0) {
            return response()->redirectTo($urlInfo['url']);
        }

        return response()->json([]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $keys = Redis::keys('url_info:*');

        $keys = array_map(function ($key) {
            return str_replace(config('database.redis.options.prefix'), '', $key);
        }, $keys);

        $result = array_map(function ($key) { return Redis::hGetAll($key); }, $keys);

        return response()->json($result);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $url = $request->url;

        if (!$url) {
            return response()->json(['error']);
        }

        $urlSequence = $this->generateUrlSequence();

        while (count(Redis::hGetAll('url_info:'.$urlSequence)) !== 0) {
            $urlSequence = $this->generateUrlSequence();
        }

        Redis::hmset(
            'url_info:'.$urlSequence,
            [
                'urlSequence' => $urlSequence,
                'url' => $url,
                'date' => 'date',
                'creator' => 'john'
            ]
        );

        $result = Redis::hGetAll('url_info:'.$urlSequence);

        return response()->json($result);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function generateUrlSequence()
    {
        $urlSequence = Redis::get('url-sequence');

        if (!$urlSequence) {
            Redis::set('url-sequence', 0);
        }

        Redis::incr('url-sequence');

        $urlSequence = Redis::get('url-sequence');

        return $urlSequence;
    }
}
