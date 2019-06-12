<?php
use Symfony\Component\HttpFoundation\Session\Session;
use Illuminate\Support\Facades\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
   return view('welcome');
});

Route::get('/profileteacher', 'ProfesorController@show')->name('profileteacher');
Route::get('/profilestudent', 'EstudianteController@show')->name('profilestudent');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('teachers', 'TeacherController');

Route::resource('students', 'StudentController');

Route::resource('schedules', 'ScheduleController');

Route::resource('subjects', 'SubjectController');

Route::resource('sections', 'SectionController');

Route::resource('courses', 'CourseController');

Route::resource('grades', 'GradeController');

Route::resource('tasks', 'TaskController');

Route::resource('news', 'NewsController');

Route::resource('taskhistories', 'TaskhistoryController');

Route::resource('questions', 'QuestionController');

Route::resource('qualifications', 'QualificationController');

Route::post('/qualificationstudents', 'QualificationController@qualificationstudents')->name('qualificationstudents');;

Route::get('/admin', 'AdministracionController@index')->name('admin');

Route::post('/updatecredencial/{user}', 'AdministracionController@updatecredencial')->name('updatecredencial');

Route::get('/roles', 'AdministracionController@roles')->name('roles');

Route::get('/roltouser', 'AdministracionController@roltouser')->name('roltouser');

Route::get('/credencial', 'AdministracionController@index');

Route::get('/horario', 'AdministracionController@index');

Route::get('/profesor', 'AdministracionController@index');

Route::get('/estudiante', 'AdministracionController@index');

Route::get('/asignatura', 'AdministracionController@index');

Route::get('/seccion', 'AdministracionController@index');

Route::get('/anoticias', 'AdministracionController@index');

Route::get('/seccion_alumnos', 'AdministracionController@index');

Route::get('/curso', 'AdministracionController@index');

Route::get('/curso_leccion', 'AdministracionController@index');

Route::get('/studentsforsection/{section}', 'AdministracionController@studentsforsection');

Route::post('/addstudentsforsection/{section}', 'AdministracionController@addstudentsforsection');

Route::post('/setstudentsforsection/{section}', 'AdministracionController@setstudentsforsection');

Route::get('/lessonsforcourses/{course}', 'AdministracionController@lessonsforcourses');

Route::get('/lessonsstock/{course}', 'AdministracionController@lessonsstock');

Route::post('/addlessonsforcourse/{course}', 'AdministracionController@addlessonsforcourse');

Route::get('/pnotas', 'ProfesorController@index');

Route::get('/pnotasagregar', 'ProfesorController@index');

Route::get('/pnoticias', 'ProfesorController@index');

Route::get('/ptareas', 'ProfesorController@index');

Route::get('/ppromedios', 'ProfesorController@index');

Route::get('/screenteacher', 'ProfesorController@index');

Route::get('/screenstudent', 'EstudianteController@index');

Route::get(
   '/getcoursesteacher/{teacher}',
   'ProfesorController@getcoursesteacher'
)->name('getcoursesteacher');

Route::get(
   '/getcoursesstudent/{student}',
   'EstudianteController@getcoursesstudent'
)->name('getcoursesstudent');

Route::post(
   '/screenteacher',
   'ProfesorController@screenteacher'
)->name('screenteacher');

Route::post(
   '/screenstudent',
   'EstudianteController@screenstudent'
)->name('screenstudent');

Route::get(
   'qualificationsexport/{id}',
   'ProfesorController@qualificationsexport'
)->name('qualificationsexport');

Route::get(
   'studentsexport/{id}/{student}',
   'ProfesorController@studentsexport'
)->name('studentsexport');

Route::get('/studentsforcourse', 'ProfesorController@studentsforcourse');

Route::get('/qualificationsforstudent/{student}', 'ProfesorController@qualificationsforstudent');

Route::get('/qualificationsfortrimester/{id}', 'ProfesorController@qualificationsfortrimester');

Route::get('/questionsfortask/{task}', 'ProfesorController@questionsfortask');

Route::get('/taskforcourse/{task}', 'ProfesorController@taskforcourse');

Route::post('/addtaskforstudents', 'ProfesorController@addtaskforstudents');

Route::post('/removetaskforstudents/{task}', 'ProfesorController@removetaskforstudents');

Route::post('/store', 'ProfesorController@store');
