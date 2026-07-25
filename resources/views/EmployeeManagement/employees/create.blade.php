@extends('CoreSystem.layouts.base')
@section('content')
<div class="max-w-5xl mx-auto">

    <!-- Header -->
     <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Add New Employee</h1>
        <p class="text-gray-500 mt-2">
            Fill in the employee details below to register a new employee.
        </p>
     </div>
     <!-- Success Message -->
      @if(session('success'))
        <div class="mb-6 rounded-lg border border-green-200 bg-green-100 px-4 py-3 text-green-700">
            {{session('success')}}
        </div>
      @endif
      
      <!-- Validation Errors -->
       @if($errors->any())
        <div class="mb-6 rounded-lg border border-red-200 bg-red-100 px-4 py-3">
            <ul class="list-disc list-inside text-red-700">
                @foreach($errors->all() as $error)
                  <li>{{$error}}</li>
                  @endforeach
            </ul>
        </div>
        @endif

        <!-- Card -->
         <div class="bg-white rounded-2xl shadow-lg p-8">
            <form action="/employees" method="POST">
                @csrf
                <div class="grid grid-cols-2 gap-6">
                    <!-- Name -->
                     <div>
                        <label class="block mb-2 font-semibold text-gray-700">
                            Full Name <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="text"
                            name="name"
                            value="{{old('name')}}"
                            id="name"
                            placeholder="Enter employee name"
                            class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-emerald-500">

                     </div>
                     <!-- Email -->
                      <div>
                        <label class="block mb-2 font-semibold text-gray-700">
                            Email Address <span class="text-red-500">*</span>
                        </label>
                        <input
                         type="email" 
                         name="email" 
                         value="{{old('email')}}"
                         placeholder="example@email.com"
                         class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                      </div>
                      <!-- Department -->
                <div>
                    <label class="block mb-2 font-semibold text-gray-700">
                        Department
                    </label>

                    <input
                        type="text"
                        name="department"
                        value="{{ old('department') }}"
                        id="department"
                        placeholder="Human Resource"
                        class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                </div>

                <!-- Position -->
                <div>
                    <label class="block mb-2 font-semibold text-gray-700">
                        Position
                    </label>

                    <input
                        type="text"
                        name="position"
                        value="{{ old('position') }}"
                        id="position"
                        placeholder="Software Engineer"
                        class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                </div>

                <!-- Salary -->
                <div>
                    <label class="block mb-2 font-semibold text-gray-700">
                        Basic Salary
                    </label>

                    <input
                        type="number"
                        name="basic_salary"
                        value="{{ old('basic_salary') }}"
                        placeholder="30000"
                        min="0"
                        class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                </div>

            </div>

            <div class="mt-8 flex justify-end gap-4">

                <button
                    type="reset"
                    class="px-6 py-3 rounded-xl bg-gray-200 hover:bg-gray-300 font-medium">

                    Reset

                </button>

                <button
                    type="submit"
                    class="px-8 py-3 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-semibold">

                    Save Employee

                </button>
                </div>
            </form>
         </div>
</div>
@endsection