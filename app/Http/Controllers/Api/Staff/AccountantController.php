<?php

namespace App\Http\Controllers\Api\Staff;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Staff;
use App\Models\Student;
use App\Models\Calendar;
use App\Traits\UploadAble;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendLoginCredentialMail;
use App\Http\Resources\Staff\StaffResource;
use App\Http\Requests\CreateAccountantRequest;
use App\Http\Requests\UpdateAccountantRequest;

class AccountantController extends Controller
{
    use UploadAble;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->has('search') && request()->search != null) {
            $search = request('search');
            $staffs = Staff::where(['designation' => 'accountant'])->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'LIKE', "%$search%");
            })
                ->paginate(10);
        } else {
            $staffs = Staff::with('user')->where(['designation' => 'accountant'])->paginate(12);
        }

        return StaffResource::collection($staffs);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateAccountantRequest $request)
    {
        // User info
        $user_data = $request->only('name', 'email', 'password');
        $user_data['role'] = 'staff';
        $user_data['password'] = bcrypt($user_data['password']);
        $user = User::create($user_data);
        $user->assignRole('Accountant');

        // Accountant info
        $accountant_data = $request->only('joining_date', 'phone', 'gender');
        $accountant_data['user_id'] = $user->id;
        $accountant_data['session_id'] = currentSession();
        $accountant_data['designation'] = 'accountant';

        if ($request->hasFile('joining_letter')) {
            $accountant_data['joining_letter'] = $this->uploadOne($request->file('joining_letter'), 'joining_letters');
        }
        if ($request->hasFile('resume')) {
            $accountant_data['resume'] = $this->uploadOne($request->file('resume'), 'resumes');
        }

        $accountant = Staff::create($accountant_data);

        // Mail Send
        checkSetup() ? Mail::to($user->email)->send(new SendLoginCredentialMail($user, $request->password)) : '';

        return responseSuccess('accountant', $accountant, 'Accountant create successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function show(Staff $accountant)
    {
        //Need Improvements
        return new StaffResource($accountant->load('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAccountantRequest $request, Staff $accountant)
    {
        // User info
        $user = $accountant->user;
        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->password) {
            $user->password = bcrypt($request->password);
        }
        $user->save();

        // Teacher info
        $accountant_data = $request->only('joining_date', 'phone', 'gender');

        if ($request->hasFile('joining_letter')) {
            $old_file = $accountant->joining_letter;
            $data['joining_letter'] = $this->uploadOne($request->file('joining_letter'), 'joining_letters');
            $this->deleteOne($old_file);
        }
        if ($request->hasFile('resume')) {
            $old_file = $accountant->resume;
            $data['resume'] = $this->uploadOne($request->file('resume'), 'resumes');
            $this->deleteOne($old_file);
        }

        $accountant->update($accountant_data);

        // Mail Send
        if ($request->password) {
            checkSetup() ? Mail::to($user->email)->send(new SendLoginCredentialMail($user, $request->password)) : '';
        }

        return responseSuccess('accountant', $accountant, 'Accountant update successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function destroy(Staff $teacher)
    {
        //Need Improvements
        $this->deleteOne($teacher->joining_letter);
        $this->deleteOne($teacher->resumes);

        $teacher->user()->delete();
        $teacher->delete();

        return responseSuccess('staff', null, 'Teacher delete successfully!');
    }

    public function getDashboardOverview()
    {
        $total_student = Student::whereSessionId(currentSession())->count();
        $total_event = Calendar::count();
        $transactions = Transaction::all();

        $data = [
            'total_students' => $total_student,
            'total_events' => $total_event,
            'total_income' => $transactions->where('type', 'income')->sum('amount'),
            'total_expenses' => $transactions->where('type', 'expense')->sum('amount'),
        ];

        return response()->json($data);
    }

    public function getIncomeExpense()
    {
        $transactions = Transaction::whereSessionId(currentSession())
            ->latest()
            ->get(['id', 'income_type', 'expense_type', 'payment_type', 'amount', 'type']);
        $incomes = $transactions->where('type', 'income')->take(10);
        $expenses = $transactions->where('type', 'expense')->take(10);

        return response()->json([
            'incomes' => $incomes,
            'expenses' => $expenses,
        ]);
    }

    public function getAccountOverview(Request $request)
    {
        $filter =  $request->filter;

        switch ($filter) {
            case 'today':
                $data = Transaction::currentSession()->whereDate('created_at', Carbon::today())->get();
                break;
            case 'yesterday':
                $data = Transaction::currentSession()->whereDate('created_at', Carbon::yesterday())->get();
                break;
            case 'this_week':
                $data = Transaction::currentSession()->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->get();
                break;
            case 'last_week':
                $data = Transaction::currentSession()->whereBetween('created_at', [Carbon::now()->subWeek()->startOfWeek(), Carbon::now()->subWeek()->endOfWeek()])->get();
                break;
            case 'this_month':
                $data = Transaction::currentSession()->whereMonth('created_at', Carbon::now()->month)->get();
                break;
            case 'last_month':
                $data = Transaction::currentSession()->whereBetween('created_at', [Carbon::now()->subMonth()->startOfMonth(), Carbon::now()->subMonth()->endOfMonth()])->get();
                break;
            case 'last_6_month':
                $data = Transaction::currentSession()->whereBetween('created_at', [Carbon::now()->subMonth(6), Carbon::now()])->get();
                break;
            case 'this_year':
                $data = Transaction::currentSession()->whereBetween('created_at', [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()])->get();
                break;
            case 'last_year':
                $data = Transaction::currentSession()->whereDate('created_at', '>', now()->subYear())->get();
                break;
            default:
                return  $filter;
                break;
        }

        $total_amount =  $data->sum('amount');
        $total_income =  $data->where('type', 'income')->sum('amount');
        $total_expense =  $data->where('type', 'expense')->sum('amount');
        $income_percentage = $total_income && $total_amount != 0 ? round(($total_income / $total_amount) * 100) : 1;
        $expense_percentage =  $total_expense && $total_amount && $income_percentage ? 100 - $income_percentage : 0;

        return [
            'total_amount' => $total_amount,
            'total_income' => $total_income,
            'total_expense' => $total_expense,
            'income_percentage' => $income_percentage,
            'expense_percentage' => $expense_percentage,
        ];
    }
}
