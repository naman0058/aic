<?php

namespace App\Http\Controllers\API;
use Intervention\Image\ImageManagerStatic as Image;
use App\Http\Controllers\API\BaseController;
use Illuminate\Http\Request;
use App\User;
use App\Models\AdditionalImages;
use App\Models\Colors;
use App\Models\Observations;
use App\Models\PoDetail;
use App\Models\Style;
use App\Models\PackImages;
use App\Models\Trim;
class ApiController extends BaseController
{
    public function storeInspection(Request $request)
	{
		//\Log::info($request->all()); 
        $styleModel;
        $style=Style::where('InspectionNo',$request->InspectionNo)->first();
         
        if(isset($style) && $style != null)
        {
           $styleModel=Style::find($style->id); 
        }else{
            $styleModel = new Style();
            $styleModel->created_at = date('Y-m-d H:i:s');
            $styleModel->created_by = \Auth::user()->id;
        }
		$styleModel->user_id = \Auth::user()->id;
        $styleModel->updated_at = date('Y-m-d H:i:s');
        $styleModel->updated_by = \Auth::user()->id;
        //step_id=1
        if($request->has('step_id') && $request->step_id == 1)
        {
            $inspectionDate = date('Y-m-d', strtotime($request->inspectionDate));
            $styleModel->InspectionDate = $inspectionDate;
            $styleModel->InspectionNo = $request->InspectionNo;
            $styleModel->TimeIn = date('H:i:s',strtotime($request->TimeIn));
            $styleModel->Buyer =$request->Buyer;
            $styleModel->Brand =$request->Brand;
            $styleModel->last_step=1;
            if($styleModel->save())
            {
                 return $this->sendSuccess([], 'Saved Successfully');
            }else{
                return $this->sendError('Failed', '');
                 
            }
            
        }
		//step_id=2
		if($request->has('step_id') && $request->step_id == 2)
        {
			$styleModel->styleNo = $request->styleNo;
            $styleModel->StyleDescription = $request->StyleDescription;
            $styleModel->PONo = $request->PONo;
            $styleModel->Vendor = $request->Vendor;
            $styleModel->OrderQty = $request->OrderQty;
            $styleModel->Factory = $request->Factory;
            $styleModel->ShippedQty = $request->ShippedQty;
            $delDate = date('Y-m-d', strtotime($request->DelDate));
            $styleModel->DelDate =  $delDate;
            $styleModel->ShippedPercent = $request->ShippedPercent;
            $styleModel->Division = $request->Division;
            $styleModel->GoldSealPP = $request->GoldSealPP;
            $styleModel->AQL = $request->AQL;
            $styleModel->Level = $request->Level;
            $styleModel->last_step=2;
			if($styleModel->save())
            {
                 return $this->sendSuccess([], 'Saved Successfully');
            }else{
                return $this->sendError('Failed', '');
                 
            }
		}
		//step_id=3
		if($request->has('step_id') && $request->step_id == 3)
		{
			if($request->id != null || $request->id != '')
			{
				$poModel = PoDetail::where('id',$request->id)->where('style_id',$styleModel->id)->first();
			}else{
				$poModel = new PoDetail();
			}
			
			$poModel->Po =$request->Po;
			$poModel->OrderQty = $request->OrderQty;
			$poModel->Colour = $request->Colour; 
			//$poModel->Stitch = isset($data[$i]['stitch']) ? str_replace('"','',$data[$i]['stitch']) : ''; 
			$poModel->Pack = $request->Pack; 
			$poModel->AQLSampleSize =$request->AQLSampleSize; 
			$poModel->style_id = $styleModel->id;
			if($request->hasFile('po_photo'))
			{
				$old_po_photo=$poModel->po_photo;
				//try unlink old photo
				if($old_po_photo != null && $old_po_photo != '' && file_exists(public_path('uploads/po/'.$old_po_photo)))
				{
					unlink(public_path('uploads/po/'.$old_po_photo));
					unlink(public_path('uploads/po/compressed/'.$old_po_photo));
				}
				 
				$file=$request->file('po_photo');
				$path=public_path().'/uploads/po';
				$name=time().str_replace(' ','',$file->getClientOriginalName());
				if($file->move($path,$name)){
					$poModel->po_photo = $name;
					$image = Image::make($path.'/'.$name);
					$image->save($path.'/compressed/'.$name, 60);
				}
			}
			$poModel->save();
			$styleModel->last_step=3;
			if($styleModel->save())
            {
                 return $this->sendSuccess([], 'Saved Successfully');
            }else{
                return $this->sendError('Failed', '');
                 
            }
		}
		//step_id=4
		if($request->has('step_id') && $request->step_id == 4)
		{
			$styleModel->SHADE_DYELOTS = $request->SHADE_DYELOTS;
            $styleModel->CONTENT_LABEL = $request->CONTENT_LABEL;
            $styleModel->GARMENT_BALANCE = $request->GARMENT_BALANCE;
            $styleModel->CARTON_MARKING = $request->CARTON_MARKING;
            $styleModel->W_CARE = $request->W_CARE;
            $styleModel->RETAIL_PRICE = $request->RETAIL_PRICE;
            $styleModel->HAND_FEEL = $request->HAND_FEEL;
            $styleModel->EMBROIDERY = $request->EMBROIDERY;
            $styleModel->IRON = $request->IRON;
            $styleModel->WASH_TEST = $request->WASH_TEST;
            $styleModel->FOB = $request->FOB;
            $styleModel->WASH_ABRASION = $request->WASH_ABRASION;
            $styleModel->PRINT = $request->PRINT;
            $styleModel->FOLD = $request->FOLD;
            $styleModel->SAMPLE = $request->SAMPLE;
            $styleModel->ODOUR = $request->ODOUR;
            $styleModel->SEQUINS_H_WORK = $request->SEQUINS_H_WORK;
            $styleModel->POLYBAG= $request->POLYBAG;
            $styleModel->FPT_GPT = $request->FPT_GPT;
            $styleModel->SHIP_MODE = $request->SHIP_MODE;
            $styleModel->MAIN_LABEL = $request->MAIN_LABEL;
            $styleModel->BUTTON_SIZE_COL = $request->BUTTON_SIZE_COL;
            $styleModel->SHIPMENT_SAMPLE = $request->SHIPMENT_SAMPLE;
            $styleModel->STITCH_QUALITY = $request->STITCH_QUALITY;
            $styleModel->PACKING = $request->PACKING; 
            $styleModel->TAGS_EXTRA_TRIMS = $request->TAGS_EXTRA_TRIMS;
			$styleModel->last_step=4;
			if($styleModel->save())
			{
				 return $this->sendSuccess([], 'Saved Successfully');
			}else{
				return $this->sendError('Failed', '');
				 
			}
		}
		//step_id=5
		if($request->has('step_id') && $request->step_id == 5)
		{
			if($request->hasFile('trim_image'))
			{
				$file=$request->file('trim_image');
				$path=public_path().'/uploads/trim';
				$name=time().str_replace(' ','',$file->getClientOriginalName());
				if($file->move($path,$name)){
					$image = Image::make($path.'/'.$name);
					$image->save($path.'/compressed/'.$name, 60);
					if($request->has('id') && $request->id != null && $request->id != '')
					{
						$pack=Trim::where('style_id',$styleModel->id)->where('id',$request->id)->first();
						$old_trim_image=$pack->trim_image;
						//try unlink old photo
						if($old_trim_image != null && $old_trim_image != '' && file_exists(public_path('uploads/trim/'.$old_trim_image)))
						{
							unlink(public_path('uploads/trim/'.$old_trim_image));
							unlink(public_path('uploads/trim/compressed/'.$old_trim_image));
						}
					}else{
						$pack=new Trim();
					}
					
					$pack->style_id = $styleModel->id;
					$pack->trim_image = $name;
					$pack->save();

					$styleModel->last_step=5;
					if($styleModel->save())
					{
						return $this->sendSuccess([], 'Saved Successfully');
					}else{
						return $this->sendError('Failed', '');
					}
				}
				return $this->sendError('Failed', '');
			}
		}
		//step_id=6
		if($request->has('step_id') && $request->step_id == 6)
		{
			if($request->hasFile('packimage'))
			{
				$file=$request->file('packimage');
				$path=public_path().'/uploads/packimage';
				$name=time().str_replace(' ','',$file->getClientOriginalName());
				if($file->move($path,$name)){
					$image = Image::make($path.'/'.$name);
					$image->save($path.'/compressed/'.$name, 60);

					if($request->has('id') && $request->id != null && $request->id != '')
					{
						$pack=PackImages::where('style_id',$styleModel->id)->where('id',$request->id)->first();
						$old_packimage=$pack->packimage;
						//try unlink old photo
						if($old_packimage != null && $old_packimage != '' && file_exists(public_path('uploads/packimage/'.$old_packimage)))
						{
							unlink(public_path('uploads/packimage/'.$old_packimage));
							unlink(public_path('uploads/packimage/compressed/'.$old_packimage));
						}
					}else{
						$pack=new PackImages();
					}
					
					$pack->style_id = $styleModel->id;
					$pack->packimage = $name;
					$pack->save();

					$styleModel->last_step=6;
					if($styleModel->save())
					{
						return $this->sendSuccess([], 'Saved Successfully');
					}else{
						return $this->sendError('Failed', '');
					}
				}
				return $this->sendError('Failed', '');
			}
		}
		//step_id=7
		if($request->has('step_id') && $request->step_id == 7)
		{
			//\Log::info($request->toArray());exit;
			if($request->has('defect'))
			{
				if($request->has('id') && $request->id != null && $request->id != '')
				{
					$defectModel=Observations::find($request->id);
				}else{
					$defectModel=new Observations();
				}
				$defectModel->style_id = $styleModel->id;
				$defectModel->defects = $request->defect;
				if($defectModel->save())
				{
					if($request->has('colors') && count($request->colors))
					{
						foreach($request->colors as $color)
						{
							if(isset($color['id']) && $color['id'] != null && $color['id'] != '')
							{
								$defectColorModel=Colors::find($color['id']);
							}else{
								$defectColorModel=new Colors();
							}
							$defectColorModel->defect_id = $defectModel->id;
							$defectColorModel->style_id = $styleModel->id;
							$defectColorModel->color = $color['color'];
							$defectColorModel->major = $color['major'];
							$defectColorModel->minor = $color['minor'];
							if(isset($color['photo']) && $color['photo'] != null && $color['photo'] != '')
							{
								$oldPhoto=$defectColorModel->photo;
								
								$file=$color['photo'];
								$path=public_path().'/uploads/defect';
								$name=time().str_replace(' ','',$file->getClientOriginalName());
								if($file->move($path,$name)){
									$defectColorModel->photo = $name;
									$image = Image::make($path.'/'.$name);
									$image->save($path.'/compressed/'.$name, 60);
								}
								if($oldPhoto != null && $oldPhoto != '' && file_exists(public_path().'/uploads/defect/'.$oldPhoto))
								{
									unlink(public_path().'/uploads/defect/'.$oldPhoto);
									unlink(public_path().'/uploads/defect/compressed/'.$oldPhoto);
								}
							}
							$defectColorModel->save();
						}
					}
				}
				$styleModel->last_step=7;
				if($styleModel->save())
				{
					return $this->sendSuccess([], 'Saved Successfully');
				}else{
					return $this->sendError('Failed', '');
				}
			}
		}
		//step_id=8
		if($request->has('step_id') && $request->step_id == 8)
		{
			$styleModel->last_step=8;
			$styleModel->Remarks = $request->Remarks;
            $styleModel->Measurement_Summary = $request->Measurement_Summary;
            $styleModel->finalResult = $request->finalResult;
			$styleModel->save();
			return $this->sendSuccess([], 'Saved Successfully');
		}
		//step_id=9
		if($request->has('step_id') && $request->step_id == 9)
		{
			$styleModel->last_step=9;
			$styleModel->FactoryInspectionReport= strtoupper($request->FactoryInspectionReport);
            $styleModel->BPTReport= strtoupper($request->BPTReport);
            $styleModel->MetalDetectionReport= strtoupper($request->MetalDetectionReport);
            $styleModel->PackingList=  strtoupper($request->PackingList);
            $styleModel->Others= strtoupper($request->Others);
			$styleModel->save();
			return $this->sendSuccess([], 'Saved Successfully');
		}
		//step_id=10
		if($request->has('step_id') && $request->step_id == 10)
		{
			$styleModel->last_step=10;
			$styleModel->aicmanagername =  $request->aicmanagername;
            $styleModel->factoryrepname =  $request->factoryrepname;
			if($request->hasFile('factoryRepresentativeImage'))
            {
				
				if($styleModel->factoryRepresentativeImage != null && $styleModel->factoryRepresentativeImage != '' && file_exists(public_path().'/uploads/fri/'.$styleModel->factoryRepresentativeImage))
				{
					unlink(public_path().'/uploads/fri/'.$styleModel->factoryRepresentativeImage);
					unlink(public_path().'/uploads/fri/compressed/'.$styleModel->factoryRepresentativeImage);
				}
                $file=$request->file('factoryRepresentativeImage');
                $path=public_path().'/uploads/fri';
                $name=time().str_replace(' ','',$file->getClientOriginalName());
                if($file->move($path,$name)){
                  $styleModel->factoryRepresentativeImage = $name;
				  $image = Image::make($path.'/'.$name);
				  $image->save($path.'/compressed/'.$name, 60);
                }
            }
            if($request->hasFile('aicQaImageUrl'))
            {
				if($styleModel->aicQaImage != null && $styleModel->aicQaImage != '' && file_exists(public_path().'/uploads/aqi/'.$styleModel->aicQaImage))
				{
					unlink(public_path().'/uploads/aqi/'.$styleModel->aicQaImage);
					unlink(public_path().'/uploads/aqi/compressed/'.$styleModel->aicQaImage);
				}
                $file=$request->file('aicQaImageUrl');
                $path=public_path().'/uploads/aqi';
                $name=time().str_replace(' ','',$file->getClientOriginalName());
                if($file->move($path,$name)){
                  $styleModel->aicQaImage = $name;
				  $image = Image::make($path.'/'.$name);
				  $image->save($path.'/compressed/'.$name, 60);
                }
            }
			if($request->hasFile('additional_images'))
			{
				$file=$request->file('additional_images');
				$path=public_path().'/uploads/additional';
				$photoname=time().'_'.str_replace(' ','',$file->getClientOriginalName());
				if($file->move($path,$photoname))
				{

					$image = Image::make($path.'/'.$name);
				    $image->save($path.'/compressed/'.$name, 60);
					if($request->has('additional_image_id') && $request->additional_image_id != null && $request->additional_image_id != '')
					{
						$add=AdditionalImages::find($request->additional_image_id);
						$oldAdditionalImage=$add->additional_image;
						if($oldAdditionalImage != null && $oldAdditionalImage != '' && file_exists(public_path().'/uploads/additional/'.$oldAdditionalImage))
						{
							unlink(public_path().'/uploads/additional/'.$oldAdditionalImage);
							unlink(public_path().'/uploads/additional/compressed/'.$oldAdditionalImage);
						}
					}else{
						$add=new AdditionalImages();
					}
					$add->additional_image = $photoname;
					$add->style_id = $styleModel->id;
					$add->save();
				}
			}
			$styleModel->save();
			return $this->sendSuccess([], 'Saved Successfully');
		}
	}
	public function getInspection(Request $request)
	{
		if($request->has('step_id') && $request->step_id == 1)
		{
			$style = Style::select('inspectionDate','inspectionNo','TimeIn','Buyer','Brand')
			->where('InspectionNo',$request->InspectionNo)
			->first();
			if(!isset($style))
			{
				$style = new Style();
				$style->InspectionNo = $request->InspectionNo;
				$style->created_at = date('Y-m-d H:i:s');
				$style->created_by = \Auth::user()->id;
				$style->user_id = \Auth::user()->id;
				$style->save();
				$style = Style::select('inspectionDate','inspectionNo','TimeIn','Buyer','Brand')
				->where('InspectionNo',$request->InspectionNo)
				->first();
				 
			}
			if(isset($style) && $style != null)
			{
				return $this->sendSuccess($style, '');
			}else{
				return $this->sendError('Failed', '');
			}
		}
		//step_id=2
		if($request->has('step_id') && $request->step_id == 2)
		{
			$style = Style::select('styleNo','StyleDescription','PONo','Vendor','OrderQty','Factory','ShippedQty','DelDate','ShippedPercent','Division','GoldSealPP','AQL','Level')
			->where('InspectionNo',$request->InspectionNo)
			->first();
			if(isset($style) && $style != null)
			{
				return $this->sendSuccess($style, '');
			}else{
				return $this->sendError('Failed', '');
			}
		}
		//step_id=3
		if($request->has('step_id') && $request->step_id == 3)
		{
			$style = Style::where('InspectionNo',$request->InspectionNo)
			->first();
			$po = PoDetail::where('style_id',$style->id)
			->get();
			if(isset($po) && $po != null)
			{
				return $this->sendSuccess($po, '');
			}else{
				return $this->sendError('Failed', '');
			}
		}
		//step_id=4
		if($request->has('step_id') && $request->step_id == 4)
		{
			$style = Style::select('id','InspectionNo','SHADE_DYELOTS','CONTENT_LABEL','GARMENT_BALANCE','CARTON_MARKING','W_CARE','RETAIL_PRICE',
			'HAND_FEEL','EMBROIDERY','IRON','WASH_TEST','FOB','WASH_ABRASION','PRINT','FOLD','SAMPLE','ODOUR','SEQUINS_H_WORK','POLYBAG',
			'FPT_GPT','SHIP_MODE','MAIN_LABEL','BUTTON_SIZE_COL','SHIPMENT_SAMPLE','STITCH_QUALITY','PACKING','TAGS_EXTRA_TRIMS')
			->where('InspectionNo',$request->InspectionNo)
			->first();
			
			if(isset($style) && $style != null)
			{
				return $this->sendSuccess($style, '');
			}else{
				return $this->sendError('Failed', '');
			}
		}
		//step_id=5
		if($request->has('step_id') && $request->step_id == 5)
		{
			$style = Style::where('InspectionNo',$request->InspectionNo)->first();
			$trim=Trim::where('style_id',$style->id)->get();
			return $this->sendSuccess($trim,'');
		}
		//step_id=6
		if($request->has('step_id') && $request->step_id == 6)
		{
			$style = Style::where('InspectionNo',$request->InspectionNo)->first();
			$packImages=PackImages::where('style_id',$style->id)->get();
			return $this->sendSuccess($packImages,'');
		}
		//step_id=7
		if($request->has('step_id') && $request->step_id == 7)
		{
			$style = Style::where('InspectionNo',$request->InspectionNo)->first();
			$defects=Observations::with('colors')->where('style_id',$style->id)->get();
			return $this->sendSuccess($defects,'');
		}
		//step_id=8
		if($request->has('step_id') && $request->step_id == 8)
		{
			$style = Style::select('Remarks','Measurement_Summary','finalResult')
			->where('InspectionNo',$request->InspectionNo)->first();
			return $this->sendSuccess($style,'');
		}
		//step_id=9
		if($request->has('step_id') && $request->step_id == 9)
		{
			$style = Style::select('FactoryInspectionReport','BPTReport','MetalDetectionReport','PackingList','Others')
			->where('InspectionNo',$request->InspectionNo)->first();
			return $this->sendSuccess($style,'');
		}
		//step_id=10
		if($request->has('step_id') && $request->step_id == 10)
		{
			$style = Style::with('additional_images')
			->select('id','InspectionNo','aicmanagername','factoryrepname','aicQaImage','factoryRepresentativeImage')
			->where('InspectionNo',$request->InspectionNo)
			->get();
			if(isset($style) && $style != null)
			{
				return $this->sendSuccess($style, '');
			}else{
				return $this->sendError('Failed', '');
			}
		}

	}
	public function deletePo(Request $request)
	{
		$po = PoDetail::findOrFail($request->id);
		$old_po_photo=$po->po_photo;
		if($po->delete())
		{
			if($old_po_photo != null && $old_po_photo != '' && file_exists(public_path('uploads/po/'.$old_po_photo)))
			{
				unlink(public_path('uploads/po/'.$old_po_photo));
				unlink(public_path('uploads/po/compressed/'.$old_po_photo));
			}
			return $this->sendSuccess([], 'Deleted Successfully');
		}else{
			return $this->sendError('Failed', '');
		}
	}
	public function deletePoImage(Request $request)
	{
		$po = PoDetail::findOrFail($request->id);
		if(isset($po) && $po != null)
		{
			if(file_exists(public_path('uploads/po/'.$po->po_photo)))
			{
				unlink(public_path('uploads/po/'.$po->po_photo));
				unlink(public_path('uploads/po/compressed/'.$po->po_photo));
			}
			$po->po_photo = '';
			$po->save();
			return $this->sendSuccess([], 'Deleted Successfully');
		}else{
			return $this->sendError('Failed', '');
		}
	}
	public function deleteTrim(Request $request)
	{
		$trim = Trim::findOrFail($request->id);
		if(isset($trim) && $trim != null)
		{
			if(file_exists(public_path('uploads/trim/'.$trim->trim_image)))
			{
				unlink(public_path('uploads/trim/'.$trim->trim_image));
				unlink(public_path('uploads/trim/compressed/'.$trim->trim_image));
			}
			if($trim->delete())
			{
				return $this->sendSuccess([], 'Deleted Successfully');
			}else{
				return $this->sendError('Failed', '');
			}
		}else{
			return $this->sendError('Failed', '');
		}
	}
	public function deletePackImage(Request $request)
	{
		$packImage = PackImages::findOrFail($request->id);
		if(isset($packImage) && $packImage != null)
		{
			if(file_exists(public_path('uploads/packimage/'.$packImage->packimage)))
			{
				unlink(public_path('uploads/packimage/'.$packImage->packimage));
				unlink(public_path('uploads/packimage/compressed/'.$packImage->packimage));
			}
			if($packImage->delete())
			{
				return $this->sendSuccess([], 'Deleted Successfully');
			}else{
				return $this->sendError('Failed', '');
			}
		}else{
			return $this->sendError('Failed', '');
		}
	}
	public function deleteAdditionalImage(Request $request)
	{
		$add =AdditionalImages::findOrFail($request->id);
		if(isset($add) && $add != null)
		{
			if(file_exists(public_path('uploads/additional/'.$add->additional_image)))
			{
				unlink(public_path('uploads/additional/'.$add->additional_image));
				unlink(public_path('uploads/additional/compressed/'.$add->additional_image));
			}
			if($add->delete())
			{
				return $this->sendSuccess([], 'Deleted Successfully');
			}else{
				return $this->sendError('Failed', '');
			}
		}else{
			return $this->sendError('Failed', '');
		}
	} 
   public function getHistory()
   {
        $style=Style::where('user_id',\Auth::user()->id)->orderBy('id','desc')->get();
        return $this->sendSuccess($style, ' ');
   }
   public function deleteDefect(Request $request)
   {
        $defect=Observations::findOrFail($request->defect_id);
		if(isset($defect) && $defect != null)
		{
		    $defect->delete();
		    $colors=Colors::where('defect_id',$request->defect_id)->get();
		    foreach( $colors as $item)
		    {
		        $color=Colors::findOrFail($item->id);
		        if(file_exists(public_path('uploads/defect/'.$color->photo)))
    			{
    				unlink(public_path('uploads/defect/'.$color->photo));
    				unlink(public_path('uploads/defect/compressed/'.$color->photo));
    			} 
    			$color->delete();
		    }
			
			if($defect->delete())
			{
				return $this->sendSuccess([], 'Deleted Successfully');
			}else{
				return $this->sendError('Failed', '');
			}
		}else{
			return $this->sendError('Failed', '');
		}  
   }
   public function downloadInspection($id)
   {
		 //$id = decrypt($id);
		 $styleModel=Style::with(['PoDetails','Observation','AdditionalImage'])->where('id',$id)->first();
         $colors=Colors::where('style_id', '=', $id)->get()->toArray();
         $styleModel=array_merge($styleModel->toArray(),['colors'=>$colors]);
         $pack=PackImages::where('style_id',$id)->get();
         $styleModel=array_merge($styleModel,['packimages'=>$pack->toArray()]);
         $trim=Trim::where('style_id',$id)->get();
         $styleModel=array_merge($styleModel,['trim'=>$trim->toArray()]);
		 $pdf = \PDF::loadView('admin.style.pdf',compact('styleModel'));
		 return $pdf->stream('aic-inspection-report-'.$styleModel['InspectionNo'].'.pdf');
   }
}
