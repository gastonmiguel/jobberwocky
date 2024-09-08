<?php

namespace App\Http\Controllers;

use App\Mail\JobPostedNotification;
use App\Models\Job;
use App\Models\Subscription;
use App\Services\ExternalJobService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class JobController extends Controller
{

    protected $externalJobService;

    public function __construct(ExternalJobService $externalJobService)
    {
        $this->externalJobService = $externalJobService;
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'company' => 'required|string|max:255',
            'skills' => 'nullable|array',
            'skills.*' => 'string',
            'country' => 'nullable|string|max:255',
            'salary' => 'nullable|numeric|min:0',
        ]);

        $job = Job::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'company' => $validated['company'],
            'skills' => json_encode($validated['skills'] ?? []),
            'country' => $validated['country'],
            'salary' => $validated['salary'] ?? null,
        ]);

        $subscriptions = Subscription::all();

        foreach ($subscriptions as $subscription) {
            if (!$subscription->search_pattern ||
                stripos($job->title, $subscription->search_pattern) !== false ||
                ($subscription->search_pattern && $this->matchJobWithPattern($job, $subscription->search_pattern))
            ) {
                Mail::to($subscription->email)->send(new JobPostedNotification($job));
            }
        }

        return response()->json($job, 201);
    }

    private function matchJobWithPattern($job, $pattern)
    {
        return stripos($job->skills, $pattern) !== false ||
            stripos($job->description, $pattern) !== false ||
            stripos($job->company, $pattern) !== false ||
            stripos($job->country, $pattern) !== false;
    }

    public function index()
    {
        $internalJobs = Job::all();
        $externalJobs = $this->externalJobService->fetchExternalJobs();

        $allJobs = $internalJobs->toArray();
        $allJobs = array_merge($allJobs, $externalJobs);

        return response()->json($allJobs);
    }


    public function search(Request $request)
    {
        $query = Job::query();

        if ($request->has('title')) {
            $query->where('title', 'like', '%' . $request->input('title') . '%');
        }

        if ($request->has('company')) {
            $query->where('company', 'like', '%' . $request->input('company') . '%');
        }

        if ($request->has('salary_min')) {
            $query->where('salary', '>=', $request->input('salary_min'));
        }

        if ($request->has('salary_max')) {
            $query->where('salary', '<=', $request->input('salary_max'));
        }

        if ($request->has('country')) {
            $query->where('country', $request->input('country'));
        }

        $internalJobs = $query->get();

        $externalParams = array_filter([
            'name' => $request->input('title'),
            'salary_min' => $request->input('salary_min'),
            'salary_max' => $request->input('salary_max'),
            'country' => $request->input('country')
        ]);

        $externalJobs = $this->externalJobService->fetchExternalJobs($externalParams);

        $allJobs = array_merge($internalJobs->toArray(), $externalJobs);

        return response()->json($allJobs);
    }

}

