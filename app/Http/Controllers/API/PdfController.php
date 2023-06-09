<?php
namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\AdditionalImages;
use App\Models\Colors;
use App\Models\Observations;
use App\Models\PoDetail;
use App\Models\Style;
use App\Models\PackImages;
use App\Models\Trim;
use PDF;
//use Illuminate\Support\Facades\Log;

class PdfController extends BaseController
{
    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function uploadTextileData1(Request $request)
    {
       // echo date('Y-m-d H:i:s'); exit;

         $styleModel=Style::with(['PoDetails','Observation','AdditionalImage'])->orderBy('id','desc')->first();
         $defect_ids=[];
         foreach($styleModel->Observation as $defect)
         {
             $defect_ids[]=$defect->id;
         }
         $colors=Colors::whereIn('defect_id',$defect_ids)->get()->toArray();
         $styleModel=array_merge($styleModel->toArray(),['colors'=>$colors]);
         $pdf = PDF::loadView('pdf', compact('styleModel'));
         return $pdf->stream('download.pdf');
         //return view('pdf',compact('styleModel'));

    }
    public function uploadTextileData(Request $request)
    {

        \Log::info($request->all());
        $styleModel;
        $style=Style::where('InspectionNo',$request->InspectionNo)->first();

        if(isset($style) && $style != null)
        {
           $styleModel=Style::find($style->id);
        }else{
            $styleModel = new Style();
            $styleModel->created_at = date('Y-m-d H:i:s');
            $styleModel->created_by = 1;
        }
        $styleModel->updated_at = date('Y-m-d H:i:s');
        $styleModel->updated_by = 1;

        if($request->has('step_id') && $request->step_id == 1)
        {
            $inspectionDate = date('Y-m-d', strtotime($request->InspectionDate));
            $styleModel->InspectionDate = $inspectionDate;
            $styleModel->InspectionNo = $request->InspectionNo;
            $styleModel->TimeIn = date('H:i:s',strtotime($request->TimeIn));
            $styleModel->Buyer =$request->Buyer;
            $styleModel->Brand =$request->Brand;
            $styleModel->last_step=1;
            if($styleModel->save())
            {
                array_walk_recursive($styleModel,'Self::replacer');
                return $this->sendResponse(['style_model'=>$styleModel], '');
                exit;
            }else{
                return $this->sendError('Failed', '');
                exit;
            }

        }

        if($request->has('step_id') && $request->step_id == 2)
        {
            $styleModel->styleNo = $request->input('StyleDescription');
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
                $po=PoDetail::where('style_id',$styleModel->id)->get();
                if(count($po) == 0)
                {
                    array_walk_recursive($styleModel,'Self::replacer');
                    return $this->sendResponse(['style_model'=>$styleModel], '');
                    exit;
                }else{
                    array_walk_recursive($po,'Self::replacer');
                    array_walk_recursive($styleModel,'Self::replacer');
                    return $this->sendResponse(['style_model'=>$styleModel,'po_table'=>$po], '');
                    exit;
                }


            }else{
                return $this->sendError('Failed', '');
                exit;
            }

        }

        if($request->has('step_id') && $request->step_id == 3)
        {

            $data = $request->contributors;
            if($request->has('contributors'))
            {
            for($i=0; $i < count($data); $i++)
            {
                $val = str_replace('"','',$data[$i]['po_id']);
                if($val != '')
                {
                    //echo "edit";exit;
                    $poModel =PoDetail::find($val);
                    if($poModel)
                    {
                        $poModel->Po = isset($data[$i]['po']) ?  str_replace('"','',$data[$i]['po']) : '';
                        $poModel->OrderQty = isset($data[$i]['orderquantity']) ?  str_replace('"','',$data[$i]['orderquantity']) : '';
                        $poModel->Colour = isset($data[$i]['colour']) ? str_replace('"','',$data[$i]['colour']) : '';
                        //$poModel->Stitch = isset($data[$i]['stitch']) ? str_replace('"','',$data[$i]['stitch']) : '';
                        $poModel->Pack = isset($data[$i]['pack']) ? str_replace('"','',$data[$i]['pack']) : '';
                        $poModel->AQLSampleSize = isset($data[$i]['aqlsamplesize']) ? str_replace('"','',$data[$i]['aqlsamplesize']) : '';
                        $poModel->style_id = $styleModel->id;
                        if($request->has('tableimage'.$i))
                        {
                            $file=$request->file('tableimage'.$i);
                            $path=public_path().'/uploads/po';
                            $name=time().$file->getClientOriginalName();
                            if($file->move($path,$name)){
                              $poModel->po_photo = $name;
                            }
                        } else{
                            $poModel->po_photo = ' ';
                        }
                        $poModel->save();
                    }

                }else{
                    //echo "new";exit;

                    if(isset($data[$i]['po']) && $data[$i]['po'] != '""')
                    {
                        $poModel = new PoDetail();
                        $poModel->Po =isset($data[$i]['po']) ?  str_replace('"','',$data[$i]['po']) : '';
                        $poModel->OrderQty = isset($data[$i]['orderquantity']) ?  str_replace('"','',$data[$i]['orderquantity']) : '';
                        $poModel->Colour = isset($data[$i]['colour']) ? str_replace('"','',$data[$i]['colour']) : '';
                        //$poModel->Stitch = isset($data[$i]['stitch']) ? str_replace('"','',$data[$i]['stitch']) : '';
                        $poModel->Pack = isset($data[$i]['pack']) ? str_replace('"','',$data[$i]['pack']) : '';
                        $poModel->AQLSampleSize = isset($data[$i]['aqlsamplesize']) ? str_replace('"','',$data[$i]['aqlsamplesize']) : '';
                        $poModel->style_id = $styleModel->id;
                        if($request->has('tableimage'.$i))
                        {
                            $file=$request->file('tableimage'.$i);
                            $path=public_path().'/uploads/po';
                            $name=time().$file->getClientOriginalName();
                            if($file->move($path,$name)){
                              $poModel->po_photo = $name;
                            }
                        }else{
                            $poModel->po_photo = ' ';
                        }
                        $poModel->save();
                    }

                }

            }
            }
            $styleModel->last_step=3;
            if($styleModel->save())
            {

                $po=PoDetail::where('style_id',$styleModel->id)->get();

                array_walk_recursive($styleModel,'Self::replacer');
                array_walk_recursive($po,'Self::replacer');

                return $this->sendResponse(['po_table'=>$po], 'success');
                exit;
            }else{
                return $this->sendError('Failed', '');
                exit;
            }

        }


        if($request->has('step_id') && $request->step_id == 4   )
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
                array_walk_recursive($styleModel,'Self::replacer');

                $trim=Trim::where('style_id',$styleModel->id)->get();
                array_walk_recursive($trim,'Self::replacer');
                return $this->sendResponse(['style_model'=>$styleModel,'trim'=>$trim], '');
                exit;
            }else{
                return $this->sendError('Failed', '');
                exit;
            }

        }
        if($request->has('step_id') && $request->step_id == 5)
        {
            \Log::info($request->all());

            if($request->has('trim_count') && $request->trim_count != 0)
            {
                for($i=0;$i < $request->trim_count;$i++ )
                {
                    if($request->hasFile('trim_images_'.$i))
					{
                        $file=$request->file('trim_images_'.$i);
                        $path=public_path().'/uploads/trim';
                        $name=time().$file->getClientOriginalName();
                        if($file->move($path,$name)){
                          $pack=new Trim();
                          $pack->style_id = $styleModel->id;
                          $pack->trim_image = $name;
                          $pack->save();
                        }
                    }

                }

            }
            $styleModel->last_step=5;
            if($styleModel->save())
            {
                array_walk_recursive($styleModel,'Self::replacer');

                $pack=PackImages::where('style_id',$styleModel->id)->get();
                array_walk_recursive($pack,'Self::replacer');
                $trim=Trim::where('style_id',$styleModel->id)->get();
                array_walk_recursive($trim,'Self::replacer');
                return $this->sendResponse(['style_model'=>$styleModel,'packimages'=>$pack,'trim'=>$trim], 'Success');
                exit;
            }else{
                return $this->sendError('Failed', '');
                exit;
            }
        }
        if($request->has('step_id') && $request->step_id == 6)
        {
            \Log::info($request->all());
            if($request->has('packed_count') && $request->packed_count != 0)
            {
                for($i=0;$i < $request->packed_count;$i++ )
                {
                    $file=$request->file('packed_images_'.$i);
                    $path=public_path().'/uploads/packimage';
                    $name=time().$file->getClientOriginalName();
                    if($file->move($path,$name)){
                      $pack=new PackImages();
                      $pack->style_id = $styleModel->id;
                      $pack->packimage = $name;
                      $pack->save();
                    }
                }

            }
            $styleModel->last_step=6;
            if($styleModel->save())
            {
                array_walk_recursive($styleModel,'Self::replacer');
                $defects=Observations::with(['Color'])->where('style_id', '=', $styleModel->id)->get()->toArray();
                array_walk_recursive($defects,'Self::replacer');
                //
                $pack=PackImages::where('style_id',$styleModel->id)->get();
                array_walk_recursive($pack,'Self::replacer');
                return $this->sendResponse(['style_model'=>$styleModel,'defects'=>$defects,'packimages'=>$pack], 'Success');
                exit;
            }else{
                return $this->sendError('Failed', '');
                exit;
            }
        }
        if($request->has('step_id') && $request->step_id == 7)
        {

            $defectsArray= json_decode($request->defects, true);
            //$defectsArray=$defectsArray->defects;
            //$defectsArray = $request->all() ;
            //echo "<pre>";print_r($request->defects));exit;
            $notDeleteArray = [];
            for($i=0; $i < count($defectsArray); $i++)
            {
                if(isset($defectsArray[$i.'description_id']) && $defectsArray[$i.'description_id'] != '')
                {
                    $notDeleteArray[] = $defectsArray[$i.'description_id'];
                }
            }
            for($i=0; $i < count($defectsArray); $i++)
            {

                if(isset($defectsArray[$i.'description_id']) && $defectsArray[$i.'description_id'] != '')
                {

                    $defectModel =Observations::find($defectsArray[$i.'description_id']);
                    $defectModel->defects = $defectsArray[$i.'Description'];
                    $defectModel->style_id = $styleModel->id;
                    $defectModel->save();
                    unset($defectsArray[$i.'Description']);
                    unset($defectsArray[$i.'description_id']);
                    for($j=0; $j < count($defectsArray[$i]); $j++)
                    {
                        if(isset($defectsArray[$i][$i.'_'.$j]['colour_id']) && $defectsArray[$i][$i.'_'.$j]['colour_id'] != '')
                        {
                            $colorModel = Colors::find($defectsArray[$i][$i.'_'.$j]['colour_id']);
                            $colorModel->defect_id = $defectModel->id;
                            $colorModel->style_id = $defectModel->style_id;
                            $colorModel->color = $defectsArray[$i][$i.'_'.$j]['colourvalue'];
                            $colorModel->major = $defectsArray[$i][$i.'_'.$j]['major'];
                            $colorModel->minor = $defectsArray[$i][$i.'_'.$j]['minor'];
                            if($request->has('defect_images'.$i.'_'.$j))
                            {
                                $file=$request->file('defect_images'.$i.'_'.$j);
                                $path=public_path().'/uploads/defects';
                                $photoname=$styleModel->id.'_'.$file->getClientOriginalName();
                                if($file->move($path,$photoname))
                                {
                                  $colorModel->photo = $photoname;
                                }

                            }
                            $colorModel->save();
                        }else{
                            if($request->has('defect_images'.$i.'_'.$j))
                            {
                            $colorModel = new Colors();
                            $colorModel->defect_id = $defectModel->id;
                            $colorModel->style_id = $defectModel->style_id;
                            $colorModel->color = $defectsArray[$i][$i.'_'.$j]['colourvalue'];
                            $colorModel->major = $defectsArray[$i][$i.'_'.$j]['major'];
                            $colorModel->minor = $defectsArray[$i][$i.'_'.$j]['minor'];

                                $file=$request->file('defect_images'.$i.'_'.$j);
                                $path=public_path().'/uploads/defects';
                                $photoname=$styleModel->id.'_'.$file->getClientOriginalName();
                                if($file->move($path,$photoname))
                                {
                                  $colorModel->photo = $photoname;
                                }


                            $colorModel->save();
                            }
                        }


                    }
                }else{

                    $deleteObservation = Observations::where('style_id', '=', $styleModel->id)->whereNotIn('id', $notDeleteArray)->delete();
                    $deleteObservation = Colors::where('style_id', '=', $styleModel->id)->whereNotIn('defect_id', $notDeleteArray)->delete();

                    $defectModel = new Observations();
                    $defectModel->defects = $defectsArray[$i.'Description'];
                    $defectModel->style_id = $styleModel->id;
                    $defectModel->save();
                    unset($defectsArray[$i.'Description']);
                    unset($defectsArray[$i.'description_id']);
                    //echo "<pre>";print_r($defectsArray->defects[0]); exit;
                    for($j=0; $j < count($defectsArray[$i]); $j++)
                    {

                        $colorModel = new Colors();
                        $colorModel->defect_id = $defectModel->id;
                        $colorModel->style_id = $defectModel->style_id;
                        $colorModel->color = $defectsArray[$i][$i.'_'.$j]['colourvalue'];
                        $colorModel->major = $defectsArray[$i][$i.'_'.$j]['major'];
                        $colorModel->minor = $defectsArray[$i][$i.'_'.$j]['minor'];
                        if($request->has('defect_images'.$i.'_'.$j) )
                        {
                            $file=$request->file('defect_images'.$i.'_'.$j);
                            $path=public_path().'/uploads/defects';
                            $photoname=$styleModel->id.'_'.$file->getClientOriginalName();
                            if($file->move($path,$photoname))
                            {
                              $colorModel->photo = $photoname;
                            }

                        } else if($defectsArray[$i][$i.'_'.$j]['photourl'] != '') {
                            $colorModel->photo = $defectsArray[$i][$i.'_'.$j]['photourl'];
                        }
                        $colorModel->save();
                        $notDeleteArray[] = $defectModel->id;
                    }
                }

            }
            $styleModel->last_step=7;
            if($styleModel->save())
            {
                array_walk_recursive($styleModel,'Self::replacer');
                $defects=Observations::with(['Color'])->where('style_id', '=', $styleModel->id)->get()->toArray();
                array_walk_recursive($defects,'Self::replacer');
                return $this->sendResponse(['defects'=>$defects], 'Success');
                exit;
            }else{
                return $this->sendError('Failed', '');
                exit;
            }

        }
        if($request->has('step_id') && $request->step_id == 8)
        {
            $styleModel->Remarks = $request->Remarks;
            $styleModel->Measurement_Summary = $request->Measurement_Summary;
            $styleModel->finalResult = $request->finalResult;
            $styleModel->last_step=8;
            if($styleModel->save())
            {
                array_walk_recursive($styleModel,'Self::replacer');

                return $this->sendResponse(['style_model'=>$styleModel], 'Success');
                exit;
            }else{
                return $this->sendError('Failed', '');
                exit;
            }
        }

        if($request->has('step_id') && $request->step_id == 9)
        {
            \Log::info($request->all());
            $styleModel->FactoryInspectionReport= strtoupper($request->FactoryInspectionReport);
            $styleModel->BPTReport= strtoupper($request->BPTReport);
            $styleModel->MetalDetectionReport= strtoupper($request->MetalDetectionReport);
            $styleModel->PackingList=  strtoupper($request->PackingList);
            $styleModel->Others= strtoupper($request->Others);

            $styleModel->last_step=9;
            if($styleModel->save())
            {
                array_walk_recursive($styleModel,'Self::replacer');
                $additional_image=AdditionalImages::where('style_id',$styleModel->id)->get();
                /*$pack=PackImages::where('style_id',$styleModel->id)->get();
                array_walk_recursive($pack,'Self::replacer');*/
                if(count($additional_image) == 0)
                {
                  return $this->sendResponse(['style_model'=>$styleModel], 'Success');
                  exit;
                }

                return $this->sendResponse(['style_model'=>$styleModel,'additional_image'=>$additional_image], 'Success');
                exit;
            }else{
                return $this->sendError('Failed', '');
                exit;
            }
        }

        if($request->has('step_id') && $request->step_id == 10)
        {
            $styleModel->aicmanagername =  $request->aicmanagername;
            $styleModel->factoryrepname =  $request->factoryrepname;

            if($request->has('factory_rep_image'))
            {
                $file=$request->file('factory_rep_image');
                $path=public_path().'/uploads/fri';
                $name=time().$file->getClientOriginalName();
                if($file->move($path,$name)){
                  $styleModel->factoryRepresentativeImage = $name;
                }
            }
            if($request->has('aic_rep_image'))
            {
                $file=$request->file('aic_rep_image');
                $path=public_path().'/uploads/aqi';
                $name=time().$file->getClientOriginalName();
                if($file->move($path,$name)){
                  $styleModel->aicQaImage = $name;
                }
            }
            if($request->has('additional_image') && $request->additional_image != 0)
            {
                for($i=0;$i < $request->additional_image ;$i++)
                {
                    if($request->has('image_files_id'.$i))
                    {
                            if($file=$request->file('image_files'.$i))
                            {
                                $path=public_path().'/uploads/additional';
                                $photoname=time().'_'.$file->getClientOriginalName();
                                if($file->move($path,$photoname))
                                {
                                  $add=AdditionalImages::find($request->has('image_files_id'.$i));
                                  $add->additional_image = $photoname;
                                  $add->style_id = $styleModel->id;
                                  $add->save();
                                }
                            }

                    }
                    else{
                      if($request->has('image_files'.$i))
                        {
                            $file=$request->file('image_files'.$i);
                            $path=public_path().'/uploads/additional';
                            $photoname=time().'_'.$file->getClientOriginalName();
                            if($file->move($path,$photoname))
                            {
                              $add=new AdditionalImages();
                              $add->additional_image = $photoname;
                              $add->style_id = $styleModel->id;
                              $add->save();
                            }

                        }
                    }

                }
            }
            //echo "<pre>";print_r($request->all());exit();
            $styleModel->TimeOut = date('H:i:s');
            $styleModel->last_step=10;
            if($styleModel->save())
            {
                 $styleModel=Style::with(['PoDetails','Observation','AdditionalImage'])->where('id',$styleModel->id)->first();
                 $defect_ids=[];
                 foreach($styleModel->Observation as $defect)
                 {
                     $defect_ids[]=$defect->id;
                 }
                 $colors=Colors::whereIn('defect_id',$defect_ids)->get()->toArray();
                 $styleModel=array_merge($styleModel->toArray(),['colors'=>$colors]);
                 $pack=PackImages::where('style_id',$styleModel['id'])->get();

                 $trim=Trim::where('style_id',$styleModel['id'])->get();

                 $styleModel=array_merge($styleModel,['packimages'=>$pack->toArray()]);
                 $styleModel=array_merge($styleModel,['trim'=>$trim->toArray()]);
                 $pdf = PDF::loadView('pdf', compact('styleModel'));
                 return $pdf->stream('download.pdf',['Attachment'=>false]);
            }else{
                return $this->sendError('Failed', '');
                exit;
            }
        }

        //$styleModel->Result = $request->Result;




    }
    public function aicHistory()
    {
        $datas = Style::select('id','InspectionNo')->orderBy('id', 'DESC')->paginate(10);

        //return Response::json(['result'=> true,'message'=>'success','data'=>$data]);
        $success['success'] =  true;
        $success['history'] =  $datas;

        return $this->sendResponse($success, '');
    }


    public function historyPdf($id)
    {
        $styleModel=Style::with(['PoDetails','Observation','AdditionalImage'])->where('id',$id)->first();
         $colors=Colors::where('style_id', '=', $id)->get()->toArray();
         $styleModel=array_merge($styleModel->toArray(),['colors'=>$colors]);
         $pack=PackImages::where('style_id',$id)->get();
         $styleModel=array_merge($styleModel,['packimages'=>$pack->toArray()]);
         $trim=Trim::where('style_id',$id)->get();
         $styleModel=array_merge($styleModel,['trim'=>$trim->toArray()]);
         $pdf = PDF::loadView('pdf', compact('styleModel'));
         return $pdf->stream('download.pdf',['Attachment'=>false]);
    }

    public function editHistory($id)
    {
        //Log::info($id);
        $styleModel=Style::with(['PoDetails','Observation','AdditionalImage'])->where('id',$id)->first();
        $styleModel->InspectionDate = date('m/d/Y', strtotime($styleModel->InspectionDate));
        //$styleModel->DelDate = date('m/d/Y', strtotime($styleModel->DelDate));
         $colors=Observations::with(['Color'])->where('style_id', '=', $id)->get()->toArray();
         $styleModel=array_merge($styleModel->toArray(),['colors'=>$colors]);
         $pack=PackImages::where('style_id',$id)->get();
         $styleModel=array_merge($styleModel,['packimages'=>$pack->toArray()]);
         $trim=Trim::where('style_id',$id)->get();
         $styleModel=array_merge($styleModel,['trim'=>$trim->toArray()]);
         $success['success'] =  true;
         $success['editdata'] =  $styleModel;

         array_walk_recursive($success,'Self::replacer');
         return $this->sendResponse($success, '');

         $pdf = PDF::loadView('pdf', compact('styleModel'));
         return $pdf->stream('download.pdf',['Attachment'=>false]);
    }

    public function replacer(& $item,$key)
    {
        if($item === null)
        {
            $item = ' ';
        }
    }

     public function updateTextileData(Request $request)
    {


        /*$validator = Validator::make($request->all(), [
            'mobile' => 'required|string|max:255',
            'password' => 'required',

        ]);

        if($validator->fails()){
            return $this->sendError($validator->errors(), '');
        }*/

        //echo "<pre>"; print_r($request->contributors); exit;
        //echo "<pre>"; print_r($request->all()); exit;

        $styleModel = Style::find($request->id);
        $styleModel->InspectionDate = date('Y-m-d',strtotime($request->InspectionDate));
        $styleModel->InspectionNo = date('Ymd').$request->InspectionNo;
        $styleModel->TimeIn = date('H:i:s',strtotime($request->TimeIn));
        $styleModel->TimeOut = date('H:i:s');
        $styleModel->StyleDescription = $request->StyleDescription;
        $styleModel->Buyer =$request->Buyer;
        $styleModel->Brand =$request->Brand;
        $styleModel->styleNo = $request->input('StyleDescription');
        $styleModel->PONo = $request->PONo;
        $styleModel->Vendor = $request->Vendor;
        $styleModel->OrderQty = $request->OrderQty;
        $styleModel->Factory = $request->Factory;
        $styleModel->ShippedQty = $request->ShippedQty;
        $styleModel->DelDate =  date('Y-m-d',strtotime($request->DelDate));
        $styleModel->ShippedPercent = $request->ShippedPercent;
        $styleModel->Division = $request->Division;
        $styleModel->GoldSealPP = $request->GoldSealPP;
        $styleModel->AQL = $request->AQL;
        $styleModel->Level = $request->Level;
        $styleModel->Result = $request->Result;
        $styleModel->SHADE_DYELOTS = $request->SHADE_DYELOTS;
        $styleModel->CONTENT_LABEL = $request->CONTENT_LABEL;
        $styleModel->GARMENT_BALANCE = $request->GARMENT_BALANCE;
        $styleModel->CARTON_MARKING = $request->CARTON_MARKING;
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
        $styleModel->TAGS_EXTRA_TRIMS = $request->TAGS_EXTRA_TRIMS;
        $styleModel->SHIPMENT_SAMPLE = $request->SHIPMENT_SAMPLE;
        $styleModel->W_CARE = $request->W_CARE;
        $styleModel->STITCH_QUALITY = $request->STITCH_QUALITY;
        $styleModel->PACKING = $request->PACKING;
        $styleModel->Remarks = $request->Remarks;
        $styleModel->Measurement_Summary = $request->Measurement_Summary;
        $styleModel->finalResult = $request->finalResult;
        $styleModel->StockInspectionReport= $request->StockInspectionReport;
        $styleModel->FactoryInspectionReport= $request->FactoryInspectionReport;
        $styleModel->BPTReport= $request->BPTReport;
        $styleModel->MetalDetectionReport= $request->MetalDetectionReport;
        $styleModel->PackingList=  $request->PackingList;
        $styleModel->aicmanagername =  $request->aicmanagername;
        $styleModel->factoryrepname =  $request->factoryrepname;
        $styleModel->Others= $request->Others;
        if($request->has('factory_rep_image'))
        {
            $file=$request->file('factory_rep_image');
            $path=public_path().'/uploads/fri';
            $name=time().$file->getClientOriginalName();
            if($file->move($path,$name)){
              $styleModel->factoryRepresentativeImage = $name;
            }
        }
        if($request->has('aic_rep_image'))
        {
            $file=$request->file('aic_rep_image');
            $path=public_path().'/uploads/aqi';
            $name=time().$file->getClientOriginalName();
            if($file->move($path,$name)){
              $styleModel->aicQaImage = $name;
            }
        }
        if($request->has('packimage'))
        {
            $file=$request->file('packimage');
            $path=public_path().'/uploads/packimage';
            $name=time().$file->getClientOriginalName();
            if($file->move($path,$name)){
              $styleModel->packimage = $name;
            }
        }



        //$styleModel->created_at = date('Y-m-d H:i:s');
        $styleModel->updated_at = date('Y-m-d H:i:s');
        //$styleModel->created_at = 1;
        $styleModel->updated_at = 1;
        $styleModel->save();

         if($request->has('additional_image') && $request->additional_image != 0)
            {
                for($i=0;$i < $request->additional_image ;$i++)
                {
                    if($request->has('image_files'.$i))
                    {
                        $file=$request->file('image_files'.$i);
                        $path=public_path().'/uploads/additional';
                        $photoname=time().'_'.$file->getClientOriginalName();
                        if($file->move($path,$photoname))
                        {
                          $add=new AdditionalImages();
                          $add->additional_image = $photoname;
                          $add->style_id = $styleModel->id;
                          $add->save();
                        }

                    }
                }
            }

        return $this->sendResponse('updated', '');

         $styleModel=Style::with(['PoDetails','Observation','AdditionalImage'])->where('id',$styleModel->id)->first();
         $defect_ids=[];
         foreach($styleModel->Observation as $defect)
         {
             $defect_ids[]=$defect->id;
         }
         $colors=Colors::whereIn('defect_id',$defect_ids)->get()->toArray();
         $styleModel=array_merge($styleModel->toArray(),['colors'=>$colors]);
         $pdf = PDF::loadView('pdf', compact('styleModel'));
         return $pdf->stream('download.pdf',['Attachment'=>false]);
    }
    public function deletePackImage(Request $request)
    {
        $model=PackImages::find($request->id);
        if($model->delete())
        {
            return $this->sendResponse('Deleted', '');
        }else{
            $this->sendError('Failed', '');
        }
    }
    public function contactUs()
    {
        $data['mobile1'] = '1234567890';
        $data['mobile2'] = '1234567891';
        $data['email'] = 'test@aicindia.com';
        $data['address'] = 'test@aicindia.com';
        $data['developedby'] = 'startup14';
        $data['developedemail'] = 'startup14@gmail.com';
        return $this->sendResponse($data, '');

    }


}




