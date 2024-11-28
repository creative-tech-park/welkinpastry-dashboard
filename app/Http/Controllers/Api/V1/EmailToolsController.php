<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Jobs\EmailQueueJob;
use App\Mail\SendEmail;
use App\Models\GetItTach;
use App\Models\Question;
use App\Models\Review;
use App\Models\User;
use Illuminate\Bus\BatchRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class EmailToolsController extends Controller
{
    public $batches;
    public function __construct(BatchRepository $repository)
    {
        $this->batches = $repository;
    }


    public function index()
    {
        $userEmails = User::query()->where('role', 'customer')->pluck('email');
        $reviewEmails = Review::query()->pluck('email');
        $questionEmails = Question::query()->pluck('email');

        return response()->json([
            'data' => [...$userEmails, ...$reviewEmails, ...$questionEmails]
        ]);
    }

    public function sendEmails(Request $request)
    {

        $request->validate([
           'campaign' => 'required',
           'subject' => 'required',
           'message' => 'required'
        ]);


        $chunk = array_chunk($request->input('emails'), 50);
        $batch = Bus::batch([])->name($request->input('campaign'))->dispatch();

        foreach ($chunk as $emails) {
            foreach ($emails as $email) {
                $batch->add(new EmailQueueJob($email, $request->input('subject'), $request->input('message')));

                // mail queue system
                // Mail::to($email)->send(new SupportController($request->input('subject'), $request->input('message')));
                // job system
                // EmailQueueJob::dispatch($email, $request->input('subject'), $request->input('message'));//->delay(3);
            }
        }


//        dispatch(new EmailQueueJob($emails, $request->input('subject'), $request->input('message')));

        return $batch;
    }

    public function getCampaign()
    {
        return $this->batches->get();
    }

    public function deleteCampaign($id)
    {
        Bus::findBatch($id)->delete();
    }

    public function getAllLeads()
    {
        return GetItTach::all();
    }
    public function deleteLead($id)
    {
        GetItTach::findOrFail($id)->delete();
    }



}
