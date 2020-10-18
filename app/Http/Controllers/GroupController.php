<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\StudentGroup;
use App\Repositories\PeriodRepository;
use App\Repositories\GroupRepository;
use App\Http\Requests\CreateGroupRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;

class GroupController extends Controller
{

    private $periodRepository;

    private ?GroupRepository $groupRepository = null;

    public function __construct(
        PeriodRepository $periodRepository,
        GroupRepository $groupRepository
    ) {
        $this->periodRepository = $periodRepository;
        $this->groupRepository = $groupRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(string $period)
    {
        $this->periodRepository->findById($period);

        return inertia(
            'Groups/Create',
            [
                'period' => fn () => $this->periodRepository->getModel()->toArray(),
                'pensum' => fn () => $this->periodRepository->pensum->toArray(),
                'matters' => function () {
                    return $this
                        ->periodRepository
                        ->pensum
                        ->matters
                        ->map(function ($matter) {
                            return $matter->assignable->toArray();
                        });
                }
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\CreateGroupRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateGroupRequest $request)
    {

        DB::transaction(function () use ($request) {

            $this
                ->groupRepository
                ->newGroup(
                    $request->group,
                    $request->pensum_id,
                    $request->max_quotas,
                    $request->period_id
                );

            collect($request->horary)->each(
                fn ($horary) => $this->groupRepository->schedule(
                    $horary['curricular_unit_id'],
                    $horary['init_time']['hour'],
                    $horary['finish_time']['hour'],
                    $horary['init_time']['day']
                )
            );

        });


        return Redirect::route('periods.edit', ['period' => $request->period_id], 303);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\StudentGroup  $studentGroup
     * @return \Illuminate\Http\Response
     */
    public function show(StudentGroup $studentGroup)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\StudentGroup  $studentGroup
     * @return \Illuminate\Http\Response
     */
    public function edit(StudentGroup $studentGroup)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\StudentGroup  $studentGroup
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StudentGroup $studentGroup)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\StudentGroup  $studentGroup
     * @return \Illuminate\Http\Response
     */
    public function destroy(StudentGroup $studentGroup)
    {
        //
    }
}
