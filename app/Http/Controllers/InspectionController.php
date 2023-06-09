<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DataTables;
use \App\Models\Style;
use App\Models\AdditionalImages;
use App\Models\Colors;
use App\Models\Observations;
use App\Models\PoDetail;
use App\Models\PackImages;
use App\Models\Trim;
class InspectionController extends Controller
{
    public function index()
	{
		return view('admin.style.index');
	}
	public function filter_inspection(Request $request)
	{
		$data = Style::select('*');
        $data=$data->orderBy('id','desc');
		return DataTables::of($data)
			->filter(function ($query) {
					//InspectionNo
                    if (request()->has('number') && request()->get('number') != '')
					{
                        $query->where('InspectionNo', 'like', "%" . request('number') . "%");
                    }
					//InspectionDate
                    if (request()->has('date') && request()->get('date') != '')
					{
						$query->whereDate('InspectionDate', request('date'));
					}
					//is_completed
					if(request()->has('is_completed') && request()->get('is_completed') != 'all')
					{
						if(request()->get('is_completed') == 'completed')
						{		
							$query->where('last_step','10');
						}else{
							$query->whereNull('last_step')
							->orWhere('last_step','!=','10');
						}
					}

            })
			->addIndexColumn()
			->addColumn('TimeIn', function($data){
				return date('h:i A', strtotime($data->TimeIn));
			})
			->addColumn('TimeOut', function($data){
				return date('h:i A', strtotime($data->TimeOut));
			})
			->addColumn('is_completed', function($data){
				if($data->last_step == '10')
				{
					return '<span class="label label-success">Completed</span>';
				}else{
					return '<span class="label label-warning">Ongoing</span>';
				}
			})
			->addColumn('action', function($data){
				return '<a href="#" class="btn btn-xs btn-primary downloadBtn" data-id="'.encrypt($data->id).'"><i class="fa fa-download"></i> Download</a>
				<a href="#" class="btn btn-xs btn-danger deleteBTn" data-id="'.$data->id.'"><i class="fa fa-trash"></i> Delete</a>';
			})
			->rawColumns(['action','is_completed'])
			->make(true);
	}
	public function destroy(Request $request,$id)
	{
		$style = Style::find($request->id);
		$style->delete();
		//other delete
		
		echo 1;
	}
	public function downloadInspection($id)
	{
		 $id = decrypt($id);
		 $styleModel=Style::with(['PoDetails','Observation','AdditionalImage'])->where('id',$id)->first();
         $colors=Colors::where('style_id', '=', $id)->get()->toArray();
         $styleModel=array_merge($styleModel->toArray(),['colors'=>$colors]);
         $pack=PackImages::where('style_id',$id)->get();
         $styleModel=array_merge($styleModel,['packimages'=>$pack->toArray()]);
         $trim=Trim::where('style_id',$id)->get();
         $styleModel=array_merge($styleModel,['trim'=>$trim->toArray()]);
          
         //return view('admin.style.pdf',compact('styleModel'));
		 $pdf = \PDF::loadView('admin.style.pdf',compact('styleModel'));
		 return $pdf->stream('aic-inspection-report-'.$styleModel['InspectionNo'].'.pdf');
	}
	
}
