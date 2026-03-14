<?php

use App\Http\Controllers\eleveController;
use App\Http\Controllers\examController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\adminController;
use App\Http\Controllers\StatsController;
use App\Http\Controllers\clientController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/',[clientController::class,'home']);

Route::middleware('admin')->group(function () {
    Route::get('/stats',[StatsController::class,'classement']);
    Route::get('/pdfExam',[adminController::class,'generateBulletinExamen']);
    Route::get('/pdfPeriode',[adminController::class,'generateBulletinPeriode']);
    Route::post('/saveImp',[adminController::class,'saveImp']);
    Route::get('/dashboard', [StatsController::class,'classement']);
    Route::get('/eleve',[eleveController::class,'index']);
    Route::get('/formEleve',[eleveController::class,'formEleve']);
    Route::post('/saveEleve',[eleveController::class,'saveEleve']);
    Route::post('/saveAbs',[eleveController::class,'saveAbs']);
    Route::get('/suprEleve',[eleveController::class,'supr']);
    Route::get('/formModEleve',[eleveController::class,'formModEleve']);
    Route::post('/modEleve',[eleveController::class,'modEleve']);
    Route::get('/formAddLevel',[eleveController::class,'formAddLevel']);
    Route::post('/ajouterNiveaux',[eleveController::class,'saveLevel']);
    Route::post('/saveEmp',[adminController::class,'saveEmp']);
    Route::get('/niveau', [adminController::class,'niveaux']);
    Route::get('/formNiveau',[adminController::class,'formNiveau']);
    Route::post('/saveNiveau',[adminController::class,'saveNiveau']);
    Route::get('/suprNiveau',[adminController::class,'suprNiveau']);
    Route::get('/formModNiveau',[adminController::class,'formModNiveau']);
    Route::post('/modNiveau',[adminController::class,'modNiveau']);
    Route::get('/periode', [adminController::class,'periode']);
    Route::get('/formPeriode',[adminController::class,'formPeriode']);
    Route::post('/savePeriode',[adminController::class,'savePeriode']);
    Route::get('/suprPeriode',[adminController::class,'suprPeriode']);
    Route::get('/formModPeriode',[adminController::class,'formModPeriode']);
    Route::post('/modPeriode',[adminController::class,'modPeriode']);
    Route::get('/exam', [examController::class,'exam']);
    Route::get('/formExam',[examController::class,'formExam']);
    Route::post('/saveExam',[examController::class,'saveExam']);
    Route::get('/suprExam',[examController::class,'suprExam']);
    Route::get('/formModExam',[examController::class,'formModExam']);
    Route::post('/modExam',[examController::class,'modExam']);
    Route::get('/examDetails',[examController::class,'details']);
    Route::get('/annesco', [adminController::class,'annesco']);
    Route::get('/formAnnesco',[adminController::class,'formAnnesco']);
    Route::post('/saveAnnesco',[adminController::class,'saveAnnesco']);
    Route::get('/suprAnnesco',[adminController::class,'suprAnnesco']);
    Route::get('/formModAnnesco',[adminController::class,'formModAnnesco']);
    Route::post('/modAnnesco',[adminController::class,'modAnnesco']);
    Route::get('/prof', [adminController::class,'prof']);
    Route::get('/formProf',[adminController::class,'formProf']);
    Route::post('/saveProf',[adminController::class,'saveProf']);
    Route::get('/suprProf',[adminController::class,'suprProf']);
    Route::get('/formModProf',[adminController::class,'formModProf']);
    Route::post('/modProf',[adminController::class,'modProf']);
    Route::get('/classProf',[adminController::class,'mesClasses']);
    Route::post('/assignProf',[adminController::class,'assignerProf']);
    Route::post('/assignPP',[adminController::class,'assignerPP']);
    Route::get('/suprAss',[adminController::class,'suprAss']);
    Route::get('/examEleve',[adminController::class,'examEleve']);
    Route::get('/form_classement_examen',[adminController::class,'get_classement_examen']);
    Route::get('/classement_examen',[adminController::class,'classement_examen']);
    Route::get('/generateResultatExamPdf',[adminController::class,'generateResultatExamPdf']);
    Route::get('/classement_periode',[adminController::class,'classement_periode']);
    Route::get('/notePeriode',[adminController::class,'notePeriode']);
    Route::get('/note',[adminController::class,'note']);
    Route::get('/formNote',[adminController::class,'formNote']);
    Route::post('/importNote',[adminController::class,'importNote']);
    Route::get('/suprNoteEx',[adminController::class,'suprNoteEx']);
    Route::post('/saveNote',[adminController::class,'saveNote']);
    Route::post('/modAppreciation',[adminController::class,'modAppreciation']);
    Route::get('/Matiere', [adminController::class,'matiere']);
    Route::get('/formMatiere',[adminController::class,'formMatiere']);
    Route::post('/saveMatiere',[adminController::class,'saveMatiere']);
    Route::get('/suprMatiere',[adminController::class,'suprMatiere']);
    Route::get('/formModMatiere',[adminController::class,'formModMatiere']);
    Route::post('/modMatiere',[adminController::class,'modMatiere']);
    Route::get('/formNiveauxMatiere',[adminController::class,'formNiveauxMatieres']);
    Route::post('/saveCoefficient',[adminController::class,'saveCoefficient']);
    Route::get('/mesMatieres',[adminController::class,'mesMatieres']);
    Route::get('/user',[adminController::class,'user']);
    Route::get('/suprUser',[adminController::class,'suprUser']);
    Route::get('/formModUser',[adminController::class,'formModUser']);
    Route::post('/modUser',[adminController::class,'modUser']);
    Route::get('/listContact',[adminController::class,'contact']);
    Route::get('/suprContact',[adminController::class,'suprContact']);
    Route::get('/listContenue',[adminController::class,'listContenue']);
    Route::get('/formContenue',[adminController::class,'formContenue']);
    Route::get('/formModContenue',[adminController::class,'formModContenue']);
    Route::post('/modContenue',[adminController::class,'modContenue']);
    Route::post('/saveContenue',[adminController::class,'saveContenue']);
    Route::get('/deleteContenue',[adminController::class,'suprContenue']);
    Route::get('/formAbout',[adminController::class,'formAbout']);
    Route::post('/storeAbout',[adminController::class,'store'])->name('posts.store');
    Route::get('/deletePost',[adminController::class,'deleteAbout']);
    Route::get('/formCMS',[adminController::class,'formCMS']);
    Route::get('/cms',[adminController::class,'cms']);
    Route::post('/storeCMS',[adminController::class,'storeCMS'])->name('page.store');
    Route::get('/deletePage',[adminController::class,'deleteCMS']);
    Route::get('/formModCms',[adminController::class,'formModCMS']);
    Route::post('/modCMS',[adminController::class,'modCMS'])->name('page.mod');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/logout',[AuthenticatedSessionController::class,'destroy']);
    Route::post('/creerCommande',[clientController::class,'creerCommande']);
    Route::get('/pageCommande',[clientController::class,'pageCommande']);
    Route::get('/mesCommande',[clientController::class,'mesCommandes']);
    Route::get('/payment','App\Http\Controllers\stripeController@index')->name('payement');
    Route::post('/checkout','App\Http\Controllers\stripeController@checkout')->name('checkout');
    Route::get('/checkout','App\Http\Controllers\stripeController@succes')->name('success');
    Route::get('/Param',[adminController::class,'formModMyUser']);
    Route::post('/modMyUser',[adminController::class,'modMyUser']);
    });
//stripe
require __DIR__.'/auth.php';
