<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PeriodController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CriteriaController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\GolonganController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\SubCriteriaController;
use App\Http\Controllers\BestEmployeeController;
use App\Http\Controllers\RankingCriteriaController;
use App\Http\Controllers\RankingSubcriteriaController;

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

Route::get('admin/dashboard', [HomeController::class, 'admin'])->middleware(['auth', 'admin_or_penilai'])->name('admin.dashboard');
Route::get('user/dashboard', [HomeController::class, 'user'])->middleware(['auth', 'user'])->name('user.dashboard');

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/comments', [CommentController::class, 'index'])->name('comments.index');
    Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::post('/comments/{comment}/like', [CommentController::class, 'like'])->name('comments.like');
    Route::delete('/comments', [CommentController::class, 'destroyAll'])->name('comments.destroyAll');
});

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

Route::middleware(['auth', 'admin_or_penilai'])->group(function () {
    Route::get('admin/karyawan', [EmployeeController::class, 'index'])->name('admin.karyawan.employees');
    Route::get('admin/karyawan/create', [EmployeeController::class, 'create'])->name('admin.karyawan.create');
    Route::post('admin/karyawan', [EmployeeController::class, 'store'])->name('admin.karyawan.store');
    Route::get('admin/karyawan/{employee}/edit', [EmployeeController::class, 'edit'])->name('admin.karyawan.edit');
    Route::put('admin/karyawan/{employee}', [EmployeeController::class, 'update'])->name('admin.karyawan.update');
    Route::delete('admin/karyawan/{employee}', [EmployeeController::class, 'destroy'])->name('admin.karyawan.destroy');
    Route::get('admin/karyawan/{employee}', [EmployeeController::class, 'show'])->name('admin.karyawan.show');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('admin/criterias', [CriteriaController::class, 'index'])->name('admin.penilaian.criterias');
    Route::post('admin/criterias', [CriteriaController::class, 'store'])->name('criterias.store');
    Route::delete('admin/criterias/{criteria}', [CriteriaController::class, 'destroy'])->name('criterias.destroy');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('admin/subcriterias', [SubCriteriaController::class, 'index'])->name('admin.penilaian.subcriterias');
    Route::post('admin/subcriterias', [SubCriteriaController::class, 'store'])->name('subcriterias.store');
    Route::delete('admin/subcriterias/{subcriteria}', [SubCriteriaController::class, 'destroy'])->name('subcriterias.destroy');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('admin/periods', [PeriodController::class, 'index'])->name('admin.penilaian.periods');
    Route::get('admin/periods/create', [PeriodController::class, 'create'])->name('admin.periods.create');
    Route::post('admin/periods', [PeriodController::class, 'store'])->name('admin.periods.store');
    Route::delete('admin/periods/{period}', [PeriodController::class, 'destroy'])->name('admin.periods.destroy');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('ranking_criterias', RankingCriteriaController::class);
    Route::get('admin/ranking/criterias', [RankingCriteriaController::class, 'index'])->name('admin.ranking.criterias');
    Route::post('admin/ranking/criterias', [RankingCriteriaController::class, 'store'])->name('ranking_criterias.store');
    Route::get('admin/ranking/criterias/calculate', [RankingCriteriaController::class, 'calculate'])->name('criterias.calculate');
    Route::delete('admin/ranking/criterias/{id}', [RankingCriteriaController::class, 'destroy'])->name('ranking_criterias.destroy');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('admin/ranking/subcriterias', [RankingSubcriteriaController::class, 'index'])->name('admin.ranking.subcriterias');
    Route::post('admin/ranking/subcriterias', [RankingSubcriteriaController::class, 'store'])->name('ranking_subcriteria.store');
    Route::delete('admin/ranking/subcriterias/{ranking_subcriteria}', [RankingSubcriteriaController::class, 'destroy'])->name('subcriteria.destroy');
});

Route::middleware(['auth', 'admin_or_penilai'])->group(function () {
    Route::get('admin/penilaian/periods', [EvaluationController::class, 'SelectIndex'])->name('admin.penilaian.select-periods');
    Route::get('admin/penilaian/periods/select', [EvaluationController::class, 'showEmployee'])->name('periods.showEmployee');
    Route::post('admin/penilaian/periods/select', [EvaluationController::class, 'showEmployee'])->name('periods.showEmployee');
    Route::get('admin/penilaian/latest', [EvaluationController::class, 'showLatestPeriod'])->name('admin.penilaian.latest');
    Route::delete('admin/penilaian/periods/select/{employeeId}/{periodId}', [EvaluationController::class, 'deleteScore'])->name('scores.delete');
    Route::get('admin/penilaian/periode/karyawan/{employee}/evaluate/{period}/subcriteria', [EvaluationController::class, 'showSubcriteriaEvaluation'])->name('employees.subcriteriaEvaluation');
    Route::post('admin/penilaian/periode/karyawan/{employee}/evaluate/{period}/subcriteria', [EvaluationController::class, 'storeSubcriteriaEvaluation'])->name('employees.storeSubcriteriaEvaluation');
    Route::get('admin/penilaian/periode/karyawan/{employee}/evaluate/{period}/subcriteria/edit', [EvaluationController::class, 'editScore'])->name('scores.edit');
    Route::get('admin/penilaian/detail/{employee}/{period}', [EvaluationController::class, 'showDetail'])->name('scores.detail');
    Route::put('admin/penilaian/periode/karyawan/{employee}/evaluate/{period}/subcriteria', [EvaluationController::class, 'updateScore'])->name('scores.update');
});

Route::middleware(['auth', 'admin_or_penilai'])->group(function () {
    Route::get('admin/ranking/periods', [BestEmployeeController::class, 'select'])->name('admin.ranking.select-periods');
    Route::get('admin/ranking/periods/select', [BestEmployeeController::class, 'showEmployee'])->name('rankings.showEmployee');
    Route::post('admin/ranking/periods/select', [BestEmployeeController::class, 'showEmployee'])->name('rankings.showEmployee');
    Route::get('admin/ranking/periode/karyawan/{employee}/evaluate/{period}/subcriteria', [BestEmployeeController::class, 'showSubcriteriaEvaluation'])->name('rankings.subcriteriaEvaluation');
    Route::post('admin/ranking/periode/karyawan/{employee}/evaluate/{period}/subcriteria', [BestEmployeeController::class, 'storeSubcriteriaEvaluation'])->name('rankings.storeSubcriteriaEvaluation');
    Route::get('admin/employee/{employee}/period/{period}/detail', [BestEmployeeController::class, 'showDetailEvaluation'])->name('ranking.detail');
    Route::delete('admin/ranking/periods/select/{employeeId}/{periodId}', [BestEmployeeController::class, 'deleteScore'])->name('ranking.delete');
});

Route::middleware(['auth', 'user'])->group(function () {
    Route::get('user/periods', [UserController::class, 'selectPeriods'])->name('user.select-periods');
    Route::get('user/penilaian/{period}', [UserController::class, 'showDetail'])->name('user.detail');
});




