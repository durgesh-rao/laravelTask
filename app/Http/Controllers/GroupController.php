<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;
use DB;
class GroupController extends Controller
{

    public function index()
    {
        $groups =Group::all();
        return view('groups/index', compact('groups'));
    }

    public function create(Request $request)
    {
        return view('groups.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
        ]);
        if($validatedData)
        {  
            try
            {
                $data = [
                    'label'=>$request->label,
                ];
                $group = Group::create($data);
                if($group)
                {
                    return response([
                        'status'=>1,
                        'massege'=>'Group Succesfully Added'
                    ]);
                }
            } 
            catch(Exception $e){
                return redirect()->back()->withFailed('Exception:' . $e->getMessage());
            }
        }
        
    }

    public function edit($id)
    {
        if($id)
        {
            $group = Group::where('id',$id)->first();
            if($group)
            {
                return view('groups.form', compact('group'));
            }
            return redirect()->back()->withFailed('Group Not Found');
        }
        return redirect()->back()->withFailed('Group Not Found');
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'label'=>'required'
        ];
        $this->validate($request, $rules);

        try {
            $group = Group::where('id',$id)->first();
            if($group){
                $group->label = $request->label;

                if($group->save())
                {
                    return response(['status' => true, 'message' => 'Group Updated Successfully', 200]);
                }
                return response(['status' => false, 'message'=>'Group Not Updated']);
            }
            return response(['status' => false, 'message'=>'Group Not Updated']);
        }
        catch(Exception $e){
            return redirect()->back()->withFailed('Exception:' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if($id)
        {
            $group = Group::findOrFail($id);
            if ($group->users()->exists()) {
                return redirect()->back()->withFailed('Cannot delete group. It is associated with one or more users.');
            }
            else
            {
                $group->delete();
                return redirect()->back()->withSuccess('Group Successfully Deleted');
            }

        }
        return redirect()->back()->withFailed('Group Not Found');
    }

    public function trash(){

        $groups = Group::onlyTrashed()->get();
        $data = compact('groups');
        return view('groups.trashData')->with($data);
    }

    public function restore($id)
    {
        if($id)
        {
            $group = Group::withTrashed()->find($id);
            if($group)
            {
                $group->restore();
                return redirect('/group')->withSuccess('Group Successfully restore');
            }

        }
        return redirect()->back()->withFailed('Group Not Restore');
    }
}
