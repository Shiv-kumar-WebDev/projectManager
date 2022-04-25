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
            ->orderBy('project_id', 'desc')
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
            ->orderBy('tasks_id', 'desc')
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
            'email' => 'required',
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
        $user_id = $request->input('user_id');
        $insert_data = [
            'fname' => $request->input('fname'),
            'lname' => $request->input('lname'),
            'email' => $request->input('email'),
            'pass' => $request->input('pass'),
            'designation' => $request->input('desi')
        ];

        if($user_id == '' )
        {
            //  for insert

            if (DB::table('users')->insert($insert_data)){
                return response()->json(['success' => 'Post created successfully.']);

            }else{
                return response()->json(['error' => 'Connection error!']);
            }
        }else{
//  for update

            if (DB::table('users')->where('user_id', $user_id)->update($insert_data)){
                return response()->json(['success' => 'User updated successfully.']);

            }else{
                return response()->json(['error' => 'Connection error!.']);
            }
        }


    }
    public function storeEdit(Request $request)
    {
        $validator = Validator($request->all(), [
            'fname' => 'required',
            'lname' => 'required',
            'email' => 'required|email:rfc,dns',
            'desi' => 'required',
//            'pass' => 'required',
//            'cpass' => 'required|same:pass',
        ],
            [
                'fname.required' => 'First Name is required field!',
                'email.required' => 'Email is required field!',
                'lname.required' => 'Last Name is required field!',
                'desi.required' => 'Please select designation!',
                'pass.required' => 'Password is required field!',
//                'cpass.required' => 'Confirm password is required field!',
//                'cpass.same' => 'Password & confirm password must match!'
            ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->all()
            ]);
        }

//        $request
        $fname = $request->input('fname');
        $fname = $request->input('fname');
        $lname = $request->input('lname');
        $email = $request->input('email');
        $pass = $request->input('pass');
        $cpass = $request->input('cpass');
        $desi = $request->input('desi');
        $user_id = $request->input('user_id');

        $qry = DB::insert('insert into users (fname, lname, email, pass,designation) values (?, ?, ?, ?,?)', [$fname, $lname,$email,$pass,$desi]);

        $qry = DB::table('users')
            ->where('id', 1)
            ->update(['votes' => 1]);
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
            'project_status' => 'required',
        ],
            [
                'projects_name.required' => 'Project Name is required field!',
                'projects_start.required' => 'Start Date is required field!',
                'projects_end.required' => 'End Date is required field!',
                'user_name.required' => 'Please select User!',
                'project_status.required' => 'Please select Project!',
            ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->all()
            ]);
        }

//        $request
        $project_id = $request->input('project_id');
        $insert_data=[
            'projects_name'=>$request->input('projects_name'),
            'project_start'=>$request->input('projects_start'),
            'project_end'=>$request->input('projects_end'),
            'users_id'=>$request->input('user_name'),
            'project_status'=>$request->input('project_status')
        ];

        if($project_id == '' )
        {
            //  for insert

            if (DB::table('projects')->insert($insert_data)){
                return response()->json(['success' => 'Post created successfully.']);

            }else{
                return response()->json(['error' => 'Connection error!']);
            }
        }else{
//  for update

            if (DB::table('projects')->where('project_id', $project_id)->update($insert_data)){
                return response()->json(['success' => 'User updated successfully.']);

            }else{
                return response()->json(['error' => 'Connection error!.']);
            }
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
        $task_id = $request->input('task_id');
        $insert_data=[
            'tasks_name'=>$request->input('tasks_name'),
            'tasks_start'=>$request->input('tasks_start'),
            'tasks_end'=>$request->input('tasks_end'),
            'users_id'=>$request->input('users_name'),
            'task_status'=>$request->input('task_status'),
            'tasks_remark'=>$request->input('tasks_remark')
        ];

        if($task_id == '' )
        {
            //  for insert

            if (DB::table('tasks')->insert($insert_data)){
                return response()->json(['success' => 'Post created successfully.']);

            }else{
                return response()->json(['error' => 'Connection error!']);
            }
        }else{
//  for update

            if (DB::table('tasks')->where('tasks_id', $task_id)->update($insert_data)){
                return response()->json(['success' => 'User updated successfully.']);

            }else{
                return response()->json(['error' => 'Connection error!.']);
            }
        }
    }
    public function UserDetails(Request $request)
    {
        $id = $request->input('id');

        $users = DB::table('users')
            ->select('*')
            ->where('user_id', $id)
            ->get();

        if(count($users) >0)
        {
            return response()->json(['type'=> 'success', 'users'=>$users]);
        }else{
            return response()->json(['type'=> 'error', 'msg'=> 'DB Connection Error!']);
        }

    }
    public function projectDetails(Request $request)
    {
        $id = $request->input('id');

        $projects = DB::table('projects')
            ->join('users', 'users.user_id', '=', 'projects.users_id')
            ->select('*')
            ->where('project_id', $id)
            ->get();

        if(count($projects) >0)
        {
            return response()->json(['type'=> 'success', 'projects'=>$projects]);
        }else{
            return response()->json(['type'=> 'error', 'msg'=> 'DB Connection Error!']);
        }

    }
    public function taskDetails(Request $request)
    {
        $id = $request->input('id');

        $tasks = DB::table('tasks')
            ->join('users', 'users.user_id', '=', 'tasks.users_id')
            ->select('*')
            ->where('tasks_id', $id)
            ->get();

        if(count($tasks) >0)
        {
            return response()->json(['type'=> 'success', 'tasks'=>$tasks]);
        }else{
            return response()->json(['type'=> 'error', 'msg'=> 'DB Connection Error!']);
        }

    }
}
