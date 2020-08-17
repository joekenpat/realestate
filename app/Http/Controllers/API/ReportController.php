<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Property;
use App\Report;
use App\User;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ReportController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    try {
      if ($request->has('status')) {
        $status = $request->status;
        $item_status_map = [
          'active',
          'resolved',
          'all',
        ];
        if (in_array($status, $item_status_map)) {
          if ($status == 'all') {
            $item_status  = [
              'active',
              'resolved',
            ];
          } else {
            $item_status  = [$status];
          }
        } else {
          $item_status = ["active"];
        }
      } else {
        $item_status = false;
      }

      if ($request->has('sort_type')) {
        $sort_type =  $request->sort_type;
        $sort_type_map = ["asc", 'desc'];
        if (in_array($sort_type, $sort_type_map)) {
          $item_sort_type =  $sort_type;
        } else {
          $item_sort_type =  $sort_type_map[1];
        }
      } else {
        $item_sort_type = 'asc';
      }

      if ($request->has('result_count')) {
        $result_count =  $request->result_count;
        if (in_array($result_count, [9, 18, 36, 72, 90, 108])) {
          $item_result_count =  $result_count;
        } else {
          $item_result_count =  9;
        }
      } else {
        $item_result_count =  9;
      }

      $reports = Report::with(['reporter','reporter.city','reporter.state', 'property','property.amenities','property.specifications','property.tags','property.user','property.user.city','property.user.state','property.state','property.city','property.category','property.subcategory' ])
        ->when($item_status, function ($query) use ($item_status) {
          return $query->whereIn('status', $item_status);
        })
        ->orderBy('created_at', $item_sort_type)
        ->paginate($item_result_count)->appends(request()->query());
      return response()->json($reports, Response::HTTP_OK);
    } catch (ModelNotFoundException $mnt) {
      return response()->json([
        'error' => 'No Item Found',
      ], Response::HTTP_NOT_FOUND);
    } catch (\Exception $e) {
      return response()->json([
        'error' => $e->getMessage(),
      ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
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
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Report  $report
   * @return \Illuminate\Http\Response
   */
  public function show()
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Report  $report
   * @return \Illuminate\Http\Response
   */
  public function edit()
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Report  $report
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Report  $report
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
  }
}
