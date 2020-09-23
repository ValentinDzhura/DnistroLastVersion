<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Arrival\BulkDestroyArrival;
use App\Http\Requests\Admin\Arrival\DestroyArrival;
use App\Http\Requests\Admin\Arrival\IndexArrival;
use App\Http\Requests\Admin\Arrival\StoreArrival;
use App\Http\Requests\Admin\Arrival\UpdateArrival;
use App\Models\Arrival;
use App\Models\Take;
use App\Models\Tour;
use Brackets\AdminListing\Facades\AdminListing;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ArrivalController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexArrival $request
     * @return array|Factory|View
     */
    public function index(IndexArrival $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(Arrival::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'name', 'begin', 'end', 'tour_name',],

            // set columns to searchIn
            ['id', 'name', 'begin', 'end', 'tour_name',]
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.arrival.index', ['data' => $data]);
            
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.arrival.create');
        $take = new Take();
        return view('admin.arrival.create');
                
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreArrival $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreArrival $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the Arrival
        $arrival = Arrival::create($request->all());
        
        //  $take = Take::create([
        //      'documents'=>$request->documents,
        //      'health'=>$request->health,
        //      'dishes'=>$request->dishes,
        //      'meal'=>$request->meal,
        //      'equipment'=>$request->equipment,
        //      'defence'=>$request->defence,
        //      'arrival_id'=>$arrival->id,
        //  ]);
        
        $docs = $request->input('documents');
// dd($request->input('documents'));
    foreach($docs as $value){

        return Take::create([

            'arrival_id'=>999,

            'documents'=>$value->documents,
        ]);

    };
        if ($request->ajax()) {
            return ['redirect' => url('admin/arrivals'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }
        
         return redirect('admin/arrivals');
    }

    /**
     * Display the specified resource.
     *
     * @param Arrival $arrival
     * @throws AuthorizationException
     * @return void
     */
    public function show(Arrival $arrival)
    {
        $this->authorize('admin.arrival.show', $arrival);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Arrival $arrival
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(Arrival $arrival)
    {
        $this->authorize('admin.arrival.edit', $arrival);

        
        return view('admin.arrival.edit', [
            'arrival' => $arrival,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateArrival $request
     * @param Arrival $arrival
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateArrival $request, Arrival $arrival)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values Arrival
        $arrival->update($sanitized);
        $take=$arrival->take;
        $take->update(
        ['documents'=>$request->documents,
        'health'=>$request->health,
        'dishes'=>$request->dishes,
        'meal'=>$request->meal,
        'equipment'=>$request->equipment,
        'defence'=>$request->defence,
        ]);
        if ($request->ajax()) {
            return [
                'redirect' => url('admin/arrivals'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/arrivals');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyArrival $request
     * @param Arrival $arrival
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyArrival $request, Arrival $arrival)
    {
        $arrival->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyArrival $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyArrival $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    Arrival::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
