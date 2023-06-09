<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Staff;
use App\Models\User;
use DataTables;
use Illuminate\Validation\Rule;
class StaffController extends Controller
{
	public function index()
	{
	return view('admin.staff.index');
	}

  	public function filter_staff(Request $request)
    {
        if($request->ajax()){
          $data = Staff::select('staff.*');
          if($request->has('name') && !empty($request->name))
          {
            $data=$data->where('name','like','%'.$request->name.'%');
          }
          if($request->has('mobile') && !empty($request->mobile))
          {
            $data=$data->where('mobile','like','%'.$request->mobile.'%');
          }
         
         
          $data=$data->get();  
          return Datatables::of($data)

                ->addIndexColumn()
                ->addColumn('name', function($data) { return ucfirst($data->name); })
                ->addColumn('email', function($data) { return $data->email; })
                ->addColumn('mobile', function($data) { return $data->mobile; })
                ->addColumn('action',function($data){
                    $edit=url('staff/'.$data->id.'/edit');
                    return '<button class="btn bg-primary btn-sm text-white rounded-circle staffViewBtn" type="button" value="'.$data->id.'" data-toggle="modal" data-target="#exampleModalLive" ><i class="fa fa-eye"></i></button>
                            <a href="'.$edit.'" class="btn bg-secondary btn-sm text-white rounded-circle"><i class="fa fa-pencil"></i></a>

                            <button class="btn bg-danger btn-sm text-white rounded-circle deleteBtn" type="button" value="'.$data->id.'"><i class="fa fa-trash"></i></button>';
                         
                })
                ->setRowId(function ($data) {
                     return "row_".$data->id;
               })
                ->make(true);

            
        }
    }
	public function create()
	{
	return view('admin.staff.create');
	}
	public function store(Request $request)
	{
		$request->validate([
		'name'=>'required',
		'email'=>'required|unique:users',
		'mobile'=>'required',
		'address'=>'required',
		'password'=>'required|min:8'
		]);

		$user =new User();
		$user->name=$request->name;
		$user->email=$request->email;
		$user->password=bcrypt($request->password);
		$user->user_type='staff';
		if($user->save())
		{
			$data= new Staff();
			$data->name=$request->name;
			$data->user_id=$user->id;
			$data->email=$request->email;
			$data->mobile=$request->mobile;
			$data->alt_mobile=$request->alt_mobile;
			$data->address=$request->address;
			$data->created_by=\Auth::user()->id;
			$data->updated_by=\Auth::user()->id;
			$data->created_at=date('Y-m-d H:i:s');
			$data->updated_at=date('Y-m-d H:i:s');
			$path=public_path().'/images/staff';

			if($files=$request->file('photo'))
			{
				$name=time().$files->getClientOriginalName();
				$files->move($path,$name);
				$data->photo=$name;
			}
			$data->save();
			echo "Created Successfully";
		}
	}

	public function edit($id)
	{
		$data= Staff::find($id);
		return view('admin.staff.update',[
		'data'=>$data
		]);
	}

	public function update(Request $request)
	{
		$data= Staff::find($request->id);
		$request->validate([
		'name'=>'required',
		'email'=>['required',Rule::unique('users')->ignore($data->user_id)],
		'mobile'=>'required',
		'address'=>'required'
		]);

		$data= Staff::find($request->id);
		$data->name=$request->name;
		$data->email=$request->email;
		$data->mobile=$request->mobile;
		$data->alt_mobile=$request->alt_mobile;
		$data->address=$request->address;
		$data->updated_by=\Auth::user()->id;
		$data->updated_at=date('Y-m-d H:i:s');
		$path=public_path().'/images/staff';
		if($files=$request->file('photo'))
		{
		$name=time().$files->getClientOriginalName();
		$files->move($path,$name);
		$data->photo=$name;
		}
		if($data->save())
		{
			$user=User::find($data->user_id);
			$user->name=$data->name;
			$user->email=$data->email;
			if($request->has('new_password') && $request->new_password !='')
			{
				$user->password=bcrypt($request->new_password);
			}
			$user->save();
			echo "Updated Successfully";
		}
		
	}


    public function staffView(Request $request)
    {
      $data= Staff::find($request->id);
      $view=view('admin.staff.view',[ 'data'=>$data]);
      echo $view;
    }
    public function destroy(Request $request)
    {
        $data=Staff::find($request->id);
        if($data)
        {
        	$userdata=User::find($data->user_id)->delete();
        	$delete_data=Staff::find($request->id)->delete();
        	echo 1;
        
        }
       
       
    }

}