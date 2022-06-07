<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Visitor;
use App\Models\Page;
use App\Models\User;

class HomeController extends Controller
{

    public function __construct(){
         $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $visitsCount = 0;
        $onlineCount = 0;
        $pagesCount = 0;
        $userCount = 0;
        $interval = intval($request->input('interval', 30));

        if($interval>120){
            $interval = 120;
        }

        $dateInterval = date('Y-m-d M:i:s', strtotime('-'.$interval.'days'));
        $visitsCount = Visitor::where('date_acess', '>=', $dateInterval)->count();

        $dateLimit = date('Y-m-d M:i:s', strtotime('-5 minutes'));
        $onlineList = Visitor::select('ip')->where('created_at', '>=', $dateLimit)->groupBy('ip')->get();
        $onlineCount = count($onlineList); 

        $pagesCount = Page::count();

        $userCount = User::count();

        $pagePie = [];
        $visitsAll = Visitor::selectRaw('page, count(page) as c')->where('date_acess', '>=', $dateInterval)->groupBy('page')->get();

        foreach($visitsAll as $visit){
            $pagePie[$visit['page']] = intval($visit['c']);
        }
        
        $pageLables =  json_encode( array_keys($pagePie));
        $pageValues =  json_encode( array_keys($pagePie));

        return view('admin.home', [
            'visitorsCount' => $visitsCount,
            'onlineCount'   => $onlineCount,
            'pagesCount'    => $pagesCount,
            'userCount'     => $userCount,
            'pageLables'    => $pageLables,
            'pageValues'    => $pageValues,
            'dateInterval'  => $dateInterval,
        ]);
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
        //
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
}
