<?php

namespace Campus\Http\Controllers;

use Illuminate\Http\Request;
use Campus\Course;
use Campus\Teacher;
use Campus\Student;
use PhpParser\JsonDecoder;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;
use Campus\Section;

class ProfesorController extends Controller
{
   /*
    |--------------------------------------------------------------------------
    | Profesor Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */
   public function __construct()
   {
      $this->middleware('auth');
      $this->middleware('profesor');
   }

   public function index()
   {
      return view('panelprofesores');
   }

   public function screenteacher(Request $request)
   {
      $request->session()->put('course', $request->input('id'));
      return view('panelprofesores');
   }


   public function getcoursesteacher(Teacher $teacher, Request $request)
   {
      if ($request->ajax()) {
         $asignaciones = $teacher->courses()->get();
         $cursos = [];
         foreach ($asignaciones as $asig) {
            array_push($cursos, [
               'id' => $asig->id,
               'nombre' => $asig->nombre,
               'curso' => $asig->subject()->first(),
               'seccion' => $asig->section()->first()
            ]);
         }
         return response()->json($cursos, 200);
      }
   }

   public function studentsforcourse(Request $request)
   {
      if ($request->ajax()) {
         $course_id = $request->session()->get('course');
         $course = Course::where('id', (int)$course_id)->first();
         $students = $course->section()->first()->students()->where('estado', 1)->get();
         return response()->json($students, 200);
      }
   }

   public function qualificationsforstudent(Student $student, Request $request)
   {
      if ($request->ajax()) {
         $qualifications = $student->qualifications()->where([
            'estado' => 1,
            'course_id' => (int)$request->session()->get('course')
         ])->get();
         return response()->json($qualifications, 200);
      }
   }

   private function matrizqualifications(int $id, Request $request)
   {
      $course = Course::where('id', (int)$request->session()->get('course'))->first();
      $section = $course->section()->first();
      $students = $section->students()->where('estado', 1)->get();
      $calificaciones = [];
      foreach ($students as $student) {
         $examenes = $student->qualifications()->where(['trimestre' => $id, 'tipo' => 'Examen'])->get();
         $tareas = $student->qualifications()->where(['trimestre' => $id, 'tipo' => 'Tarea'])->get();
         $trabajos = $student->qualifications()->where(['trimestre' => $id, 'tipo' => 'Trabajo o investigación'])->get();
         $otros = $student->qualifications()->where(['trimestre' => $id, 'tipo' => 'Otra'])->get();
         $calificacion = ['estudiante' => $student, 'examenes' => $examenes, 'tareas' => $tareas, 'trabajos' => $trabajos, 'otros' => $otros];
         array_push($calificaciones, $calificacion);
      }
      return $calificaciones;
   }

   public function qualificationsfortrimester($id, Request $request)
   {
      if ($request->ajax()) {
         $qualifications = $this->matrizqualifications($id, $request);
         return response()->json($qualifications, 200);
      }
   }

   private function Cabeceras($calificaciones)
   {
      $cabeceras = ['Cedula', 'Nombre'];
      $final = 0;
      if (count($calificaciones) > 0) {
         $calificacion = $calificaciones[0];
         $arrays = [$calificacion['examenes'], $calificacion['tareas'], $calificacion['trabajos'], $calificacion['otros']];
         $final = 2;
         foreach ($arrays as $array) {
            $final += $array->count();
            foreach ($array as $cali) {
               array_push($cabeceras, $cali->titulo);
            }
         }
         array_push($cabeceras, 'Nota');
      }
      return [$final, $cabeceras];
   }


   private function Cuerpo($calificaciones)
   {
      $rows = [];
      foreach ($calificaciones as $calificacion) {
         $row = [
            $calificacion['estudiante']->cedula,
            $calificacion['estudiante']->nombre . ' ' .
               $calificacion['estudiante']->primer_apellido . ' ' .
               $calificacion['estudiante']->segundo_apellido
         ];
         $arrays = [$calificacion['examenes'], $calificacion['tareas'], $calificacion['trabajos'], $calificacion['otros']];
         $nota = 0;
         foreach ($arrays as $array) {
            foreach ($array as $cali) {
               array_push($row, $cali->porcentaje_obtenido);
               $nota += $cali->porcentaje_obtenido;
            }
         }
         array_push($row, $nota);
         array_push($rows, $row);
      }
      return $rows;
   }

   private function CuerpoLlenado($calificaciones, $text, &$array, &$nota)
   {
      if ($calificaciones->count() > 0) {
         $total = 0;
         foreach ($calificaciones as $cali) {
            $total += $cali->porcentaje_obtenido;
         }
         $nota += $total;
         $row = [$text, "", "", $total];
         array_push($array, $row);
         $row = [];
         foreach ($calificaciones as $cali) {
            $row = [$cali->titulo, $cali->valor_porcentual, $cali->porcentaje_obtenido, ""];
            array_push($array, $row);
         }
      }
   }

   private function CuerpoEstudiante($calificaciones)
   {
      $rows = [];
      if (
         $calificaciones['examenes']->count() > 0 ||
         $calificaciones['tareas']->count() > 0 ||
         $calificaciones['trabajos']->count() > 0 ||
         $calificaciones['otros']
      ) {
         $nota = 0;
         $this->CuerpoLlenado($calificaciones['examenes'], "Exámenes", $rows, $nota);
         $this->CuerpoLlenado($calificaciones['tareas'], "Tareas", $rows, $nota);
         $this->CuerpoLlenado($calificaciones['trabajos'], "Trabajos", $rows, $nota);
         $this->CuerpoLlenado($calificaciones['otros'], "Otros", $rows, $nota);
         array_push($rows, ["", "", "Nota", $nota]);
      }
      return $rows;
   }

   public function qualificationsexport($id, Request $request)
   {
      try {
         $course = $request->session()->get('course');
         $course = Course::where('id', $course)->first();
         $profesor = $course->teacher()->first();
         $section = $course->section()->first();
         $course = $course->subject()->first();
         $calificaciones = $this->matrizqualifications($id, $request);
         $Heads = $this->Cabeceras($calificaciones);
         $cabeceras = $Heads[1];
         $final = $Heads[0];
         $rows = $this->Cuerpo($calificaciones);
         Excel::create('Notas trimestrales', function ($excel) use ($profesor, $course, $id, $section, $cabeceras, $final, $rows) {
            $excel->sheet('Notas Estudiantes', function ($sheet) use ($profesor, $course, $id, $section, $cabeceras, $final, $rows) {
               if ($final > 0) {
                  $Listado = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];
                  $sheet->mergeCells('A1:' . $Listado[$final] . '1');
                  $sheet->row(1, ['Lista de Notas del ' . $id . ' Trimestre.']);
                  $sheet->mergeCells('A2:' . $Listado[$final] . '2');
                  $sheet->row(2, ['Curso: ' . $course->nombre . '        Sección: ' . $section->seccion]);
                  $sheet->mergeCells('A3:' . $Listado[$final] . '3');
                  $sheet->row(3, ['Profesor: ' . $profesor->nombre . ' ' . $profesor->primer_apellido . ' ' . $profesor->segundo_apellido]);
                  $sheet->row(4, $cabeceras);
                  foreach ($rows as $row) {
                     $sheet->appendRow($row);
                  }
                  for ($i = 0; $i < 3; $i++) {
                     $sheet->cells('A' . ($i + 1) . ':' . $Listado[$final] . ($i + 1), function ($cells) {
                        $cells->setBackground('#022450');
                        $cells->setFontColor('#ffffff');
                        $cells->setFont(array(
                           'family'     => 'Calibri',
                           'size'       => '16',
                           'bold'       =>  true
                        ));
                        $cells->setAlignment('center');
                        $cells->setValignment('center');
                     });
                  }
                  $sheet->cells('A4:' . $Listado[$final] . '4', function ($cells) {
                     $cells->setBackground('#91bdee');
                     $cells->setFontColor('#000000');
                     $cells->setFont(array(
                        'family'     => 'Calibri',
                        'size'       => '14',
                        'bold'       =>  true
                     ));
                  });
                  $sheet->setHeight(array(
                     1     =>  25,
                     2     =>  25,
                     3     =>  25,
                     4     =>  25,
                  ));
                  $sheet->setAutoSize(true);
               }
            });
         })->export('xlsx');
      } catch (\Exception $e) {
         $output = new \Symfony\Component\Console\Output\ConsoleOutput();
         $output->writeln($e->getMessage());
      }
   }

   public function studentsexport($id, Student $student, Request $request)
   {
      try {
         $qualifications = $this->matrizqualifications($id, $request);
         $calificaciones = [];
         foreach ($qualifications as $qualification) {
            if ($qualification['estudiante']->id == $student->id) {
               $calificaciones = $qualification;
               break;
            }
         }
         $course = $request->session()->get('course');
         $course = Course::where('id', $course)->first();
         $profesor = $course->teacher()->first();
         $section = $course->section()->first();
         $course = $course->subject()->first();
         $rows = $this->CuerpoEstudiante($calificaciones);
         Excel::create('Nota trimestral', function ($excel) use ($profesor, $course, $id, $section, $student, $rows) {
            $excel->sheet('Nota Estudiante', function ($sheet) use ($profesor, $course, $id, $section, $student, $rows) {
               if (count($rows) > 0) {
                  $sheet->mergeCells('A1:D1');
                  $sheet->row(1, ['Lista de Notas del ' . $id . ' Trimestre.']);
                  $sheet->mergeCells('A2:D2');
                  $sheet->row(2, ['Curso: ' . $course->nombre . '        Sección: ' . $section->seccion]);
                  $sheet->mergeCells('A3:D3');
                  $sheet->row(3, ['Profesor: ' . $profesor->nombre . ' ' . $profesor->primer_apellido . ' ' . $profesor->segundo_apellido]);
                  $sheet->mergeCells('A4:D4');
                  $sheet->row(4, ['Alumno=     Cedula: ' . $student->cedula . '     Nombre: ' . $student->nombre . ' ' . $student->primer_apellido . ' ' . $student->segundo_apellido]);
                  $sheet->row(5, ['Rubro', 'Valor', 'Obtenido', 'Totales']);
                  foreach ($rows as $row) {
                     $sheet->appendRow($row);
                  }
                  $sheet->cells('A1:A4', function ($cells) {
                     $cells->setBackground('#022450');
                     $cells->setFontColor('#ffffff');
                     $cells->setFont(array(
                        'family'     => 'Calibri',
                        'size'       => '16',
                        'bold'       =>  true
                     ));
                     $cells->setAlignment('center');
                     $cells->setValignment('center');
                  });
                  $sheet->cells('A5:D5', function ($cells) {
                     $cells->setBackground('#91bdee');
                     $cells->setFontColor('#000000');
                     $cells->setFont(array(
                        'family'     => 'Calibri',
                        'size'       => '14',
                        'bold'       =>  true
                     ));
                  });
                  $sheet->setHeight(array(
                     1     =>  25,
                     2     =>  25,
                     3     =>  25,
                     4     =>  25,
                     5     =>  25,
                  ));
                  $sheet->setAutoSize(true);
                  $sheet->setWidth('A', 75);
               }
            });
         })->export('xlsx');
      } catch (\Exception $e) {
         $output = new \Symfony\Component\Console\Output\ConsoleOutput();
         $output->writeln($e->getMessage());
      }
   }
}
