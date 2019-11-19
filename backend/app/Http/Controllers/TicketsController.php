<?php

namespace App\Http\Controllers;

use App\Http\Resources\Tickets\TicketConllection;
use App\Http\Resources\Tickets\TicketResource;
use App\Model\Ticket_detail;
use App\Model\Tickets;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class TicketsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['index', 'show', 'store','update', 'destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return TicketConllection::collection(Tickets::all());
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
        Carbon::setLocale('vi');
        $time = Carbon::now('Asia/Ho_Chi_Minh');
        $time_back = Carbon::now('Asia/Ho_Chi_Minh');
        $ticket = new Tickets;
        $ticket->customer_id = $request->user_id;
        $ticket->code = Str::random(3);
        $ticket->date_active = $time;
        $ticket->date_back = $time_back->addDays(7);
        $ticket->save();
        $ticket_detail = new Ticket_detail;
        $ticket_detail->tickets_id = $ticket->id;
        $ticket_detail->product_id = $request->product_id;
        $ticket_detail->save();
        return response()->json(['success' => 'Tạo phiếu mượn thành công'], 200);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Tickets  $tickets
     * @return \Illuminate\Http\Response
     */
    public function show($code)
    {
        $data = Tickets::where('code', $code)->first();
        if($data) {
            return new TicketResource($data);
        }
        else {
            return response()->json(['error' => 'Không có dữ liệu'], Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Tickets  $tickets
     * @return \Illuminate\Http\Response
     */
    public function edit(Tickets $tickets)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Tickets  $tickets
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tickets $tickets)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Tickets  $tickets
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tickets $tickets)
    {
        //
    }
}
