<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Dotenv\Validator;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use function Psr\Log\alert;

class UserController extends Controller
{
    public function index()
    {
        return view('register');
    }
    public function register(Request $request)
    {

        $validated = $request->validate([
            'fname' => 'required|max:255',
            'lname' => 'required',
            'email' => 'required|email:rfc,dns',
            'pass' => 'required',
            'cpass' => 'required',
        ],
        [
            'fname.required' => 'First Name is required field!',
            'email.required' => 'Email is required field!',
            'lname.required' => 'Last Name is required field!',
            'pass.required' => 'Password is required field!',
            'cpass.required' => 'Confirm Password is required field!',
        ]);

        $fname = $request->input('fname');
        $lname = $request->input('lname');
        $email = $request->input('email');
        $pass = $request->input('pass');
        $cpass = $request->input('cpass');

        if($pass==$cpass){
            $dataInserted = DB::insert('insert into users (fname, lname, email, pass) values (?, ?, ?, ?)', [$fname, $lname,$email,$pass]);

            if($dataInserted){
//                echo "data inserted";
                return redirect('login');
            }
        }


    }
    public function changePasword(Request $request)
    {


        $validated = $request->validate([
            'pass' => 'required',
            'npass' => 'required',
            'cpass' => 'required',
        ],
            [
                'pass.required' => 'Password is required field!',
                'npass.required' => 'Password is required field!',
                'cpass.required' => 'Confirm Password is required field!',
            ]);

        $id = $request->input('id');
        $pass = $request->input('pass');
        $npass = $request->input('npass');
        $cpass = $request->input('cpass');

        $users = DB::table('users')
            ->select('*')
            ->where('pass', $pass)
            ->get();
        if($npass==$cpass){

            $updateData = [
                'pass' => $npass
            ];


            if (count($users)){
                $updateQuery = DB::table('users')
                    ->where('user_id', $id)
                    ->update($updateData);

                if($updateQuery){
//                echo "data inserted";

                    return redirect()->route('changePass', ['id' => $id])->with('status', 'Changed!');
                }else{
                    return redirect()->route('changePass', ['id' => $id])->with('status', 'Not Changed!');
                }
            }else{
                return redirect()->route('changePass', ['id' => $id])->with('status', 'This is not your old password!');
            }

        }else{
            return redirect()->route('changePass', ['id' => $id])->with('status', 'Please enter same password!');
        }


    }
    public function updateUserDate(Request $request)
    {
        $data= [];

        $validated = $request->validate([
            'fname' => 'required',
            'lname' => 'required',
            'email' => 'required|email:rfc,dns',
        ],
        [
            'fname.required' => 'First Name is required field!',
            'email.required' => 'Email is required field!',
            'lname.required' => 'Last Name is required field!',
        ]);

        $id = $request->input('id');
        $fname = $request->input('fname');
        $lname = $request->input('lname');
        $email = $request->input('email');

            $updateData = [
                'fname' => $fname,
                'lname' => $lname,
                'email' => $email
                ];

            $updateQuery = DB::table('users')
            ->where('user_id', $id)
            ->update($updateData);

            if($updateQuery){
//                echo "data inserted";
                return redirect()->route('profile', ['id' => $id])->with('status', 'Updated!');
            }else{
                return redirect()->route('profile', ['id' => $id])->with('status', 'Not Updated!');
            }

    }
    public function login()
    {
        return view('welcome');
    }
    public function loginCheck(Request $request)
    {

        $data = [];
        $email = $request->input('email');
        $pass = $request->input('pass');


        $users = DB::table('users')
            ->select('email','fname','user_id')
            ->where('email', $email)
            ->where('pass', $pass)
            ->where('user_status', 1)
            ->get();

//        $request->session()->put('users', $users);

        /*
        if($request->session()->has('users'))
        {
            echo "yes";
        }else{
          echo 'no';
        }
        */



//        $data['users'] = $users;



        if(count($users) > 0 ){

            session(['users'=> $users]);

//            var_dump(session('users'));
//            exit;
//            return view('dashboard', $users)->with('status', $users[0]->email);
            return view('dashboard');
        }
        else{
            return redirect('login')->with('status', 'Email or Password not matching!');;
        }


    }
    public function dashboard()
    {
        return view('dashboard');
    }
    public function changePass($id)
    {
        $data['id'] = $id;
        return view('changePass',$data);
    }
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
    public function profile($id)
    {
        $data['user']= DB::table('users')->select('*')->where('user_id','=',$id)->get();
//        var_dump($data); exit;
       return view('profile',$data);
    }
    public function users()
    {
        $data['user']= DB::table('users')->select('*')->orderBy('user_id', 'desc')->get();
       return view('users',$data);
    }
    public function projects()
    {
        $data['projects']= DB::table('projects')
            ->join('users', 'users.user_id', '=', 'projects.users_id')
            ->select('*')
            ->orderBy('updated_at', 'desc')
            ->get();
        $data['users'] = DB::table('users')
            ->select('*')
            ->get();
       return view('projects',$data);
    }
    public function tasks()
    {
        $data['tasks']= DB::table('tasks')
            ->join('users', 'users.user_id', '=', 'tasks.users_id')
            ->select('*')
            ->orderBy('updated_at', 'desc')
            ->get();
        $data['users'] = DB::table('users')
            ->select('*')
            ->get();
//        var_dump($data['tasks']);exit;
       return view('tasks',$data);
    }
    public function delete($id)
    {
        DB::table('users')->where('user_id', $id)->delete();
        return redirect('users');
    }
    public function deleteProject($id)
    {
        DB::table('projects')->where('project_id', $id)->delete();
        return redirect('projects');
    }
    public function deleteTask($id)
    {
        DB::table('tasks')->where('tasks_id', $id)->delete();
        return redirect('tasks');
    }
    public function statusUpdate($id,$status)
    {
        if ($status==1){
            DB::table('users')
                ->where('user_id', $id)
                ->update(['user_status' => 0]);
            return redirect('users');
        }else{
            DB::table('users')
                ->where('user_id', $id)
                ->update(['user_status' => 1]);
            return redirect('users');
        }
    }
    public function projectStatusUpdate($id,$status)
    {
        if ($status==1){
            DB::table('projects')
                ->where('project_id', $id)
                ->update(['project_status' => 0]);
            return redirect('projects');
        }else{
            DB::table('projects')
                ->where('project_id', $id)
                ->update(['project_status' => 1]);
            return redirect('projects');
        }
    }
    public function taskStatusUpdate($id,$status)
    {
        if ($status==1){
            DB::table('tasks')
                ->where('tasks_id', $id)
                ->update(['task_status' => 0]);
            return redirect('tasks');
        }else{
            DB::table('tasks')
                ->where('tasks_id', $id)
                ->update(['task_status' => 1]);
            return redirect('tasks');
        }
    }
    public function store(Request $request)
    {
        $validator = Validator($request->all(), [
            'fname' => 'required',
            'lname' => 'required',
            'email' => 'required|email:rfc,dns',
            'desi' => 'required',
            'pass' => 'required',
            'cpass' => 'required|same:pass',
        ],
            [
                'fname.required' => 'First Name is required field!',
                'email.required' => 'Email is required field!',
                'lname.required' => 'Last Name is required field!',
                'desi.required' => 'Please select designation!',
                'pass.required' => 'Password is required field!',
                'cpass.required' => 'Confirm password is required field!',
                'cpass.same' => 'Password & confirm password must match!'
            ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->all()
            ]);
        }

//        $request
        $fname = $request->input('fname');
        $lname = $request->input('lname');
        $email = $request->input('email');
        $pass = $request->input('pass');
        $cpass = $request->input('cpass');

        $qry = DB::insert('insert into users (fname, lname, email, pass) values (?, ?, ?, ?)', [$fname, $lname,$email,$pass]);
        if ($qry){
            return response()->json(['success' => 'Post created successfully.']);

        }else{
            return response()->json(['error' => 'Please enter same password.']);
        }
    }
    public function storeProject(Request $request)
    {
        $validator = Validator($request->all(), [
            'projects_name' => 'required',
            'projects_start' => 'required',
            'projects_end' => 'required',
            'user_name' => 'required',
        ],
            [
                'projects_name.required' => 'Project Name is required field!',
                'projects_start.required' => 'Start Date is required field!',
                'projects_end.required' => 'End Date is required field!',
                'user_name.required' => 'Please select User!',
            ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->all()
            ]);
        }

//        $request
        $projects_name = $request->input('projects_name');
        $projects_start = $request->input('projects_start');
        $projects_end = $request->input('projects_end');
        $user_name = $request->input('user_name');

        $qry = DB::insert('insert into projects (projects_name, project_start, project_end, users_id) values (?, ?, ?, ?)', [$projects_name, $projects_start, $projects_end, $user_name]);
        if ($qry){
            return response()->json(['success' => 'Post created successfully.']);

        }else{
            return response()->json(['error' => 'Please enter same password.']);
        }
    }
    public function storeTask(Request $request)
    {
        $validator = Validator($request->all(), [
            'tasks_name' => 'required',
            'tasks_start' => 'required',
            'tasks_end' => 'required',
            'users_name' => 'required',
            'tasks_remark' => 'required',
        ],
            [
                'tasks_name.required' => 'Task Name is required field!',
                'tasks_start.required' => 'Start Date is required field!',
                'tasks_end.required' => 'End Date is required field!',
                'users_name.required' => 'Please select User!',
                'tasks_remark.required' => 'Task Remark required!',
            ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->all()
            ]);
        }

//        $request
        $tasks_name = $request->input('tasks_name');
        $tasks_start = $request->input('tasks_start');
        $tasks_end = $request->input('tasks_end');
        $users_name = $request->input('users_name');
        $tasks_remark = $request->input('tasks_remark');

        $qry = DB::insert('insert into tasks (tasks_name, tasks_start, tasks_end, users_id, tasks_remark) values (?, ?, ?, ?,?)', [$tasks_name, $tasks_start, $tasks_end, $users_name, $tasks_remark]);
        if ($qry){
            return response()->json(['success' => 'Post created successfully.']);

        }else{
            return response()->json(['error' => 'Please enter same password.']);
        }
    }
}
