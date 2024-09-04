<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PeriodController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CriteriaController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\GolonganController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\SubCriteriaController;
use App\Http\Controllers\SelectPeriodController;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::get('admin/dashboard', [HomeController::class, 'admin'])->middleware(['auth', 'admin'])->name('admin.dashboard');

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('admin/departments', [DepartmentController::class, 'index'])->name('admin.departments');
    Route::post('admin/departments', [DepartmentController::class, 'store'])->name('departments.store');
    Route::delete('admin/departments/{department}', [DepartmentController::class, 'destroy'])->name('departments.destroy');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('admin/positions', [PositionController::class, 'index'])->name('admin.positions');
    Route::post('admin/positions', [PositionController::class, 'store'])->name('positions.store');
    Route::delete('/positions/{position}', [PositionController::class, 'destroy'])->name('positions.destroy');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('admin/golongans', [GolonganController::class, 'index'])->name('admin.golongans');
    Route::post('admin/golongans', [GolonganController::class, 'store'])->name('golongan.store');
    Route::delete('admin/golongans/{golongan}', [GolonganController::class, 'destroy'])->name('golongan.destroy');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('admin/karyawan', [EmployeeController::class, 'index'])->name('admin.karyawan.employees');
    Route::get('admin/karyawan/create', [EmployeeController::class, 'create'])->name('admin.karyawan.create');
    Route::post('admin/karyawan', [EmployeeController::class, 'store'])->name('admin.karyawan.store');
    Route::get('admin/karyawan/{employee}/edit', [EmployeeController::class, 'edit'])->name('admin.karyawan.edit');
    Route::put('admin/karyawan/{employee}', [EmployeeController::class, 'update'])->name('admin.karyawan.update');
    Route::delete('admin/karyawan/{employee}', [EmployeeController::class, 'destroy'])->name('admin.karyawan.destroy');
    Route::get('admin/karyawan/{employee}', [EmployeeController::class, 'show'])->name('admin.karyawan.show');
    Route::get('admin/penilaian/periode/karyawan/{employee}/evaluate/{period}/subcriteria', [EmployeeController::class, 'showSubcriteriaEvaluation'])->name('employees.subcriteriaEvaluation');
    Route::post('admin/penilaian/periode/karyawan/{employee}/evaluate/{period}/subcriteria', [EmployeeController::class, 'storeSubcriteriaEvaluation'])->name('employees.storeSubcriteriaEvaluation');
    Route::get('admin/penilaian/periode/karyawan/{employee}/evaluate/{period}/subcriteria/edit', [EmployeeController::class, 'editScore'])->name('scores.edit');
    Route::put('admin/penilaian/periode/karyawan/{employee}/evaluate/{period}/subcriteria', [EmployeeController::class, 'updateScore'])->name('scores.update');
    Route::get('admin/penilaian/detail/{employee}/{period}', [EmployeeController::class, 'showDetail'])->name('scores.detail');

});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('admin/criterias', [CriteriaController::class, 'index'])->name('admin.penilaian.criterias');
    Route::post('admin/criterias', [CriteriaController::class, 'store'])->name('criterias.store');
    Route::delete('admin/criterias/{criteria}', [CriteriaController::class, 'destroy'])->name('criterias.destroy');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('admin/subcriterias', [SubCriteriaController::class, 'index'])->name('admin.penilaian.subcriterias');
    Route::post('admin/subcriterias', [SubCriteriaController::class, 'store'])->name('subcriteria.store');
    Route::delete('admin/subcriterias/{subcriteria}', [SubCriteriaController::class, 'destroy'])->name('subcriteria.destroy');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('admin/periods', [PeriodController::class, 'index'])->name('admin.penilaian.periods');
    Route::get('admin/periods/create', [PeriodController::class, 'create'])->name('admin.periods.create');
    Route::get('admin/penilaian/periods', [PeriodController::class, 'SelectIndex'])->name('admin.penilaian.select-periods');
    Route::get('admin/penilaian/periods/select', [PeriodController::class, 'showEmployee'])->name('periods.showEmployee');
    Route::post('admin/penilaian/periods/select', [PeriodController::class, 'showEmployee'])->name('periods.showEmployee');
    Route::delete('admin/penilaian/periods/select/{employeeId}/{periodId}', [PeriodController::class, 'deleteScore'])->name('scores.delete');
    Route::post('admin/periods', [PeriodController::class, 'store'])->name('admin.periods.store');
    Route::delete('admin/periods/{period}', [PeriodController::class, 'destroy'])->name('admin.periods.destroy');
});

Route::get('penilai/dashboard', [HomeController::class, 'penilai'])->middleware(['auth', 'penilai']);


