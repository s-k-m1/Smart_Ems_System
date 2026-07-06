@extends('CoreSystem.layouts.base')

@section('content')

<div class="max-w-6xl mx-auto" >

<!-- Page Header -->
 <div class="flex justify-between items-center mb-8">
    <div>
        <h1 class="text-3xl font-bold text-gray-800">
            Generate Payroll
        </h1>
        <p class="text-gray-500 mt-1">
            Generate monthly salary for an employee.
        </p>
    </div>
    <a href="/payroll" class="px-5 py-3 bg-gray-200 rounded-lg hover:bg-gray-300 font-medium">
         ← Payroll Dashboard
    </a>
 </div>
 <!-- Card -->
  <div class="bg-white rounded-2xl shadow-lg p-10">
    <form action="/payroll" method="POST">
        @csrf
        <div class="grid gird-cols-2 gap-8">
            <!-- Employee -->
             <div>
                <label class="block mb-2 font-semibold text-gray-700">
                    Employee

                </label>
                <select name="employee_id" class="w-full rounded-xl border-gray-300 px-4 py-3 focus:ring-emerald-500">
                    @foreach($employees as $employee)
                    <option value="{{$employee->id}}">
                        {{$employee->name}}
                    </option>
                    @endforeach
                </select>
             </div>
             <!-- Month -->
              <div>
                <label class="block mb-2 font-semibold text-gray-700">
                    Month
                </label>
                <select name="month" class="w-full rounded-xl border border-gray-300 px-4 py-3">
                     <option>January</option>
                        <option>February</option>
                        <option>March</option>
                        <option>April</option>
                        <option>May</option>
                        <option>June</option>
                        <option>July</option>
                        <option>August</option>
                        <option>September</option>
                        <option>October</option>
                        <option>November</option>
                        <option>December</option>
                </select>
              </div>
              <!-- year -->
               <div>
                <label class="block mb-2 font-semibold text-gray-700">
                    Year
                </label>
                <input type="number" name="year" value="" class="w-full rounded-xl border border-gray-300 px-4 py-3">                
               </div>
               <!-- Bonus -->
                <div>
                    <label class="block mb-2 font-semibold text-gray-700">
                        Bonus
                </label>
                <input type="number" name="bonus" value="000" class="w-full rounded-xl border-gray-300 px-4 py-3">
                </div>
                <!-- Leave -->
                 <div>
                    <label class="block mb-2 font-semibold text-gray-700">
                        Unpaid Leave Days
                    </label>
                    <input type="number" name="unpaid_leave_days" value="0" class="w-full rounded-xl border-gray-300 px-4 py-3">

                 </div>
        </div>
        <div class="border-t mt-10 pt-8 flex justify-end gap-4">
            <a href="/payroll" class="px-6 py-3 rounded-xl bg-gray-300 hover:bg-gray-400">
                Cancel

            </a>
            <button type="submit" class="px-8 py-3 rounded-xl bg-emerald-600 text-white hover:bg-emerald-700 font-semibold">
                Generate Payroll 
            </button>
        </div>
    </form>
  </div>
</div>

@endsection