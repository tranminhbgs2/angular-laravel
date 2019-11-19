<?php

namespace App\Http\Controllers;

use App\Http\Resources\Tickets\Ticket_detailConllection;
use App\Http\Resources\Tickets\Ticket_detailResource;
use App\Model\Ticket_detail;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TicketDetailController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['index', 'show',
            'update']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Ticket_detailConllection::collection(Ticket_detail::all());
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
     * @param  \App\Model\Ticket_detail  $ticket_detail
     * @return \Illuminate\Http\Response
     */
    public function show(Ticket_detail $ticket_detail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Ticket_detail  $ticket_detail
     * @return \Illuminate\Http\Response
     */
    public function edit(Ticket_detail $ticket_detail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Ticket_detail  $ticket_detail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $tickets_id)
    {
        $ticket_detail = Ticket_detail::where('tickets_id', $tickets_id)->first();
        $ticket_detail->status = $request->status;
        $ticket_detail->update();
        return $ticket_detail;
        return response([
            'data' => 'Tạo phiếu mượn thành công'
        ],Response::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Ticket_detail  $ticket_detail
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ticket_detail $ticket_detail)
    {
        //
    }
}
