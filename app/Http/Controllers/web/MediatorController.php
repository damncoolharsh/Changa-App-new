<?php

namespace App\Http\Controllers\web;

use Exception;
use Mail;
use Session;
use App\Helpers\ChangaAppHelper;
use App\Http\Controllers\Controller;
use App\Mail\UserRegisterMail;
use App\Models\MediatorCategory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class MediatorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $users = User::where('user_type', config('userTypes.mediator'))->paginate(env('PAGINATE'));
            return view('admin.mediator.list')->with('users',$users);
            }catch(\Throwable $e){
            return  view('admin.mediator.list');
            }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $mediator_categories = MediatorCategory::get();
        return view('admin.mediator.edit', compact('mediator_categories'));
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        return view('admin.mediator.view', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try{
            $mediator_categories = MediatorCategory::get();
            $user = User::where('id',$id)->first();
            return view('admin.mediator.edit', compact('user', 'mediator_categories'));
        } catch(\Throwable $e){
            return view('admin.mediator.edit')->with('error',$e);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        try {
            $validations = [];
            $valid = false;
            // $error = $redirect = "";
            $validator = Validator::make($request->all(), self::validationForStore($request));
            if ($validator->fails()) {
                $validations = $validator->errors();
                throw new \Exception("Please correct all the validations.");
            }
            
            $fileName = NULL;
            if($request->file('profile_pic')) {
                $profile = $request->file('profile_pic');
                $path = "profile_pic";
                $fileName = ChangaAppHelper::uploadfile($profile, $path);
            }

            $password = ChangaAppHelper::generate_random_number();

            $user = User::updateOrCreate(['id' => $request->id],
                [
                    'customer_id' => $request->customer_id,
                    'first_name' => $request->name,
                    'phone' => $request->phone,
                    'email' => $request->email,
                    'username' => $request->username,
                    'password' => Hash::make($password),
                    'user_type' =>  config('userTypes.mediator'),
                    'mediator_category_id' => $request->category,
                    'profile_pic' => $fileName,
                    'active' => '0'
                ]
            );

            $mailData['name'] = $request->name;
            $mailData['password'] = $password;
            $mailData['mail_type'] = 'create';
            $mailData['email'] = $request->email;
            $mailData['verify_url'] = route('verifyAccount', $user->id);

            $valid = true;
            $message = "Facilitator created successfully";
            if($request->id) {
                $message = "Facilitator updated successfully";
            } else {
                Mail::to($request->email)->send(new UserRegisterMail($mailData));
            }
            $redirect = route('mediators');

        } catch (\Exception $ex) {
            $valid = false;
            $message = $ex;
            $redirect = '';
        }
        return ChangaAppHelper::sendAjaxResponse($valid, $message, $redirect, '', $validations);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        try {

            if (!$id) {
                throw new Exception('not found', Config('HttpCodes.fail'));
            }

            $result['status'] = 1;
            User::where('id', $id)->delete();
            Session::flash('success', 'Deleted Successfully.');
            return response()->json($result, 200);

        } catch (Exception $ex) {
            $result['status'] = 1;
            Session::flash('success', $ex->getMessage());

        }
        return response()->json($result, 200);
    }

    public function status($id, $status)
    {
        $userstatus = User::find($id);

        if ($userstatus) {
            $userstatus->active = ($status == '0') ? '1' : '0';
            $userstatus->save();

            $result['status'] = '1';
            return response()->json($result, 200);
        } else {
            $result['status'] = '0';
            return response()->json($result, 200);
        }
    }

    public function validationForStore($request)
    {
        return [
            'name' => 'required',
            'phone' => 'required|numeric|unique:users,phone,'. $request->id,
            'email' => 'required|email|unique:users,email,'. $request->id,
            'username' => 'required|unique:users,username,'. $request->id,
            'category' => 'required',
            // 'profile_pic' => 'required',
        ];
    }
}
