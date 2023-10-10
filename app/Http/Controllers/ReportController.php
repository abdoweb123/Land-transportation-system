<?php

namespace App\Http\Controllers;

use App\Models\Les;
use App\Models\Office;
use App\Models\ReservationBookingRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{

    /*** page of search tickets by date && office ***/
    public function get_search_tickets_page()
    {
        $offices = Office::where('active',1)->select('id','name')->get();
        return view('pages.Reports.searchTicketsByDateAndOffice',compact('offices'));
    }



    /*** search tickets by date && office ***/
    public function search_tickets_by_date_office(Request $request)
    {
        $offices = Office::where('active',1)->select('id','name')->get();
        $tickets = ReservationBookingRequest::whereBetween('created_at',[$request->date_from,$request->date_to])->where('office_id',$request->office_id)->paginate(50);
        return view('pages.Reports.searchTicketsByDateAndOffice',compact('tickets','offices','request'));
    }



    /*** page of search les by date && office ***/
    public function get_search_les_page()
    {
        $offices = Office::where('active',1)->select('id','name')->get();
        return view('pages.Reports.searchLesByDateAndOffice',compact('offices'));
    }



    /*** search tickets by date && office ***/
    public function search_les_by_date_office(Request $request)
    {
        $offices = Office::where('active',1)->select('id','name')->get();
        $les = Les::whereBetween('created_at',[$request->date_from,$request->date_to])->where('office_id',$request->office_id)->paginate(50);
        $les_imports = Les::where('type',1)->whereBetween('created_at',[$request->date_from,$request->date_to])->where('office_id',$request->office_id)->sum('amount');
        $les_exports = Les::where('type',2)->whereBetween('created_at',[$request->date_from,$request->date_to])->where('office_id',$request->office_id)->sum('amount');
        return view('pages.Reports.searchLesByDateAndOffice',compact('les','offices','request','les_imports','les_exports'));
    }



    /*** page of search all tickets by date && office ***/
    public function get_search_all_tickets_page()
    {
        $offices = Office::where('active',1)->select('id','name')->get();
        return view('pages.Reports.searchAllTickets',compact('offices'));
    }


} //end of class
