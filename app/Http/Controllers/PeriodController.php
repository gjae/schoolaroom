<?php

namespace App\Http\Controllers;

use App\Models\Period;
use App\Models\Degree;
use App\Models\Pensum;
use Illuminate\Http\Request;
use App\Repositories\PeriodRepository;

class PeriodController extends Controller
{

    private PeriodRepository $periodRepository;

    public function __construct(PeriodRepository $periodRepository)
    {
        $this->periodRepository = $periodRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return inertia(
            'Periods/Index',
            [
                'periods' => $this->periodRepository->all()->map(function (Period $period) {
                    return [
                        'id' => $period->id,
                        'opened' => $period->is_opened,
                        'description' => $period->period_description,
                        'special' => $period->is_special,
                        'opened_at' => $period->period_opened_at->format('M Y'),
                        'closed_at' => $period->period_closed_at ? $period->period_closed_at->format('M Y'): '??'
                    ];
                })
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return inertia(
            'Periods/Create',
            [
                'degrees' => Degree::all()->map(fn($degree) => [
                    'id' => $degree->id,
                    'mode' => $degree->mode,
                    'degree' => $degree->degree
                ]),
                'pensums' => Pensum::all()->map(fn($pensum) => [
                    'id' => $pensum->id,
                    'code' => $pensum->code,
                    'degree' => $pensum->degree->degree
                ])
            ]
        );
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
     * @param  \App\Models\Period  $period
     * @return \Illuminate\Http\Response
     */
    public function show(Period $period)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Period  $period
     * @return \Illuminate\Http\Response
     */
    public function edit(Period $period)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Period  $period
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Period $period)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Period  $period
     * @return \Illuminate\Http\Response
     */
    public function destroy(Period $period)
    {
        //
    }
}
