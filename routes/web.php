<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PaysController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\EnseignantController;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Controllers\LieuNaissanceController;
use App\Http\Controllers\TypeMatiereController;
use App\Http\Controllers\MatiereController;
use App\Http\Controllers\ClasseController;
use App\Http\Controllers\AnneeAcademiqueController;
use App\Http\Controllers\ScolariteController;
use App\Http\Controllers\PaiementController;
use App\Http\Controllers\CompositionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

/*Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');*/

Route::get('/dashboard', function () {
$user = User::where('id', '=', Auth::user()->id)->first();
return view('adminpages.dashboardcontent',compact('user'));

})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
Route::get('/lists-des-utilisateurs', [UserController::class, 'index'])->name('user.index');
Route::get('/createuser', [UserController::class, 'create'])->name('user.create');
Route::post('/storeuser', [UserController::class, 'store'])->name('user.store');
Route::get('/edituser', [UserController::class, 'edit'])->name('user.edit');
Route::put('/modifier', [UserController::class, 'update'])->name('auth.update');
Route::get('/delete/{id}', [UserController::class, 'destroy'])->name('auth.delete');
Route::get('/inscription-premier-niveau', [UserController::class, 'inscrire'])->name('auth.inscrire');
Route::get('/completer-inscription-deuxieme-niveau', [UserController::class, 'secondeEtapeInscription'])->name('auth.secondeEtapeInscription');
Route::get('/completer-inscription-troisieme-niveau', [UserController::class, 'tirdEtapeInscription'])->name('auth.tirdEtapeInscription');
//Route::post('/finish-inscription', [UserController::class, 'finishInscription'])->name('auth.finishInscription');
Route::post('/inscrireprocess', [UserController::class, 'processInscrire'])->name('auth.inscrireprocess');
Route::post('/inscription-deuxieme-niveau', [UserController::class, 'inscriptionNiveauDeux'])->name('auth.inscriptionNiveauDeux');
Route::post('/fetch-eleve-for-tuteur', [UserController::class, 'fetch'])->name('auth.fetch');
Route::post('/fetch-classe-for-annee', [UserController::class, 'fetchClassesForAnnee'])->name('auth.fetchClassesForAnnee');
Route::post('/fetch-classe-scolarite-for-annee', [UserController::class, 'fetchClassesScolariteForAnnee'])->name('auth.fetchClassesScolariteForAnnee');
Route::post('/fetch-tuteur-email-tel', [UserController::class, 'fetchTuteurEmailAndTel'])->name('auth.fetchTuteurEmailAndTel');
Route::post('/enregistrer-inscription-for-tuteur', [UserController::class, 'enregistrerInscription'])->name('auth.enregistrerInscription');
Route::post('/user-inscription', [UserController::class, 'storeinscription'])->name('user.storeinscription');
Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
Route::get('/createpays',[PaysController::class,'create'])->name('pays.create');
Route::get('/indexpays',[PaysController::class,'index'])->name('pays.index');
Route::post('/storepays',[PaysController::class,'store'])->name('pays.storepays');
Route::get('/paysedit', [PaysController::class, 'edit'])->name('pays.edit');
Route::put('/paysupdate', [PaysController::class, 'update'])->name('pays.update');
Route::get('/deletepays/{id}', [PaysController::class, 'destroy'])->name('pays.destroy');
Route::get('/listelieux',[LieuNaissanceController::class,'index'])->name('lieu.index');
Route::get('/createlieu',[LieuNaissanceController::class,'create'])->name('lieu.create');
Route::post('/storelieu',[LieuNaissanceController::class,'store'])->name('lieu.storelieu');
Route::get('/liste-des-rôles', [RoleController::class, 'index'])->name('roles.index');
Route::get('/rolecreate', [RoleController::class, 'create'])->name('roles.create');
Route::post('/rolestore', [RoleController::class, 'store'])->name('roles.store');
Route::get('/roleshow', [RoleController::class, 'show'])->name('roles.show');
Route::get('/roleedit', [RoleController::class, 'edit'])->name('roles.edit');
Route::put('/roleupdate', [RoleController::class, 'update'])->name('roles.update');
Route::get('/deleterole/{id}', [RoleController::class, 'destroy'])->name('roles.destroy');
Route::get('/liste-des-type-de-matieres', [TypeMatiereController::class, 'index'])->name('typematiere.index');
Route::get('/creer-type-matiere', [TypeMatiereController::class, 'create'])->name('typematiere.create');
Route::post('/store-type-matiere', [TypeMatiereController::class, 'store'])->name('typematiere.store');
Route::get('/edit-type-matiere', [TypeMatiereController::class, 'edit'])->name('typematiere.edit');
Route::put('/update-type-matiere', [TypeMatiereController::class, 'update'])->name('typematiere.update');
Route::get('/deletetypematiere/{id}', [TypeMatiereController::class, 'destroy'])->name('typematiere.destroy');
Route::get('/liste-des-matieres', [MatiereController::class, 'index'])->name('matiere.index');
Route::get('/creer-matiere', [MatiereController::class, 'create'])->name('matiere.create');
Route::post('/store-matiere', [MatiereController::class, 'store'])->name('matiere.store');
Route::get('/edit-matiere', [MatiereController::class, 'edit'])->name('matiere.edit');
Route::put('/update-matiere', [MatiereController::class, 'update'])->name('matiere.update');
Route::get('/deletematiere/{id}', [MatiereController::class, 'destroy'])->name('matiere.destroy');
Route::get('/liste-des-classes', [ClasseController::class, 'index'])->name('classe.index');
Route::get('/creer-classe', [ClasseController::class, 'create'])->name('classe.create');
Route::post('/store-classe', [ClasseController::class, 'store'])->name('classe.store');
Route::get('/edit-classe', [ClasseController::class, 'edit'])->name('classe.edit');
Route::put('/update-classe', [ClasseController::class, 'update'])->name('classe.update');
Route::get('/deleteclasse/{id}', [ClasseController::class, 'destroy'])->name('classe.destroy');
Route::get('/liste-annees-academique', [AnneeAcademiqueController::class, 'index'])->name('annee.index');
Route::get('/creer-annees-academique', [AnneeAcademiqueController::class, 'create'])->name('annee.create');
Route::post('/store-annees-academique', [AnneeAcademiqueController::class, 'store'])->name('annee.store');
Route::get('/edit-annees-academique', [AnneeAcademiqueController::class, 'edit'])->name('annee.edit');
Route::put('/edit-annees-academique', [AnneeAcademiqueController::class, 'update'])->name('annee.update');
Route::get('/deleteannee/{id}', [AnneeAcademiqueController::class, 'destroy'])->name('annee.destroy');
Route::get('/voir-annee-academique-users', [AnneeAcademiqueController::class, 'voirUsersForAnneeAcademique'])->name('annee.voirUsersForAnneeAcademique');
Route::get('/liste-annees-academique-supprimee', [AnneeAcademiqueController::class, 'listeAnnneSupprimees'])->name('annee.restaureliste');
Route::get('/restaureannee/{id}', [AnneeAcademiqueController::class, 'restaure'])->name('annee.restaure');
Route::get('/liste-scolarites', [ScolariteController::class, 'index'])->name('scolarite.index');
Route::get('/creer-scolarites', [ScolariteController::class, 'create'])->name('scolarite.create');
Route::post('/store-scolarites', [ScolariteController::class, 'store'])->name('scolarite.store');
Route::get('/edit-scolarites', [ScolariteController::class, 'edit'])->name('scolarite.edit');
Route::put('/update-scolarites', [ScolariteController::class, 'update'])->name('scolarite.update');
Route::get('/paiement-anneeacdemique', [PaiementController::class, 'afficheVueRecherche'])->name('paiment.afficheVueRecherche');
Route::post('/rechercher-paiments-anneeacademique', [PaiementController::class, 'rechercherPaimentAnneeAcademique'])->name('paiment.rechercherPaimentAnneeAcademique');
Route::get('/affiche-eleve-paiement-info', [PaiementController::class, 'afficheInfoElevePaiement'])->name('paiment.afficheInfoElevePaiement');
Route::post('/payer-scolarite', [PaiementController::class, 'payer'])->name('paiement.payer');
Route::get('/paiement-classe-anneeacdemique', [PaiementController::class, 'afficheVueRecherchePourPaimentParClasse'])->name('paiment.afficheVueRecherchePourPaimentParClasse');
Route::post('/rechercher-classes', [PaiementController::class, 'rechercherClasse'])->name('paiment.rechercherClasse');
Route::post('/rechercher-classes-paiement', [PaiementController::class, 'rechercherPaiementClasse'])->name('paiment.rechercherPaiementClasse');
Route::get('/etat-paiement-anneeacdemique', [PaiementController::class, 'imprimeEtatAnneePaiement'])->name('paiment.imprimeEtatAnneePaiement');
Route::get('/etat-paiement-solde-anneeacdemique', [PaiementController::class, 'imprimeEtatAnneePaiementSolde'])->name('paiment.imprimeEtatAnneePaiementSolde');
Route::get('/composition-anneeacdemique', [CompositionController::class, 'afficheVueRecherche'])->name('composition.afficheVueRecherche');
Route::get('/composition-anneeacdemique-changement-note', [CompositionController::class, 'afficheVueRechercheAnnePourChangementNote'])->name('composition.afficheVueRechercheAnnePourChangementNote');
Route::get('/liste-compositions-anneeacdemique', [CompositionController::class, 'afficheVueRechercheAnneeCompo'])->name('composition.afficheVueRechercheAnneeCompo');
Route::get('/liste-compositions', [CompositionController::class, 'index'])->name('composition.index');
Route::get('/liste-changement-notes-composition', [CompositionController::class, 'indexChangementNote'])->name('composition.indexChangementNote');
Route::get('/edit-composition', [CompositionController::class, 'editInfoComposition'])->name('composition.editInfoComposition');
Route::get('/bulletin-compositions', [CompositionController::class, 'imprimeBulletin'])->name('composition.imprimeBulletin');
Route::post('/rechercher-classes-composition', [CompositionController::class, 'rechercherClasseCompos'])->name('composition.rechercherClasseCompos');
Route::get('/rechercher-notes-composition-modif', [CompositionController::class, 'rechercherNotesComposPourModif'])->name('composition.rechercherNotesComposPourModif');
Route::post('/rechercher-annee-composition', [CompositionController::class, 'rechercherAnneeCompos'])->name('composition.rechercherAnneeCompos');
Route::post('/fetch-eleve-classe', [CompositionController::class, 'fetchClassesForAnnee'])->name('composition.fetchClassesForAnnee');
Route::post('/fetch-eleveevaluation-classe', [CompositionController::class, 'fetchClassesForEleve'])->name('composition.fetchClassesForEleve');
Route::post('/saisir-eleve-note', [CompositionController::class, 'saisirNoteCompo'])->name('composition.saisirNoteCompo');
Route::put('/update-eleve-note', [CompositionController::class, 'update'])->name('composition.update');
Route::post('/store-eleve-sanction-note', [CompositionController::class, 'saisirSanction'])->name('composition.saisirSanction');
Route::get('/liste-enseignant-associate-matiere', [EnseignantController::class, 'index'])->name('enseignant.index');
Route::get('/creer-enseignant-associate-matiere', [EnseignantController::class, 'create'])->name('enseignant.create');
Route::post('/store-enseignant-associate-matiere', [EnseignantController::class, 'store'])->name('enseignant.store');
Route::post('/verif-doublon-enseignant-associate-matiere', [EnseignantController::class, 'verifDoublonv'])->name('enseignant.verifDoublonv');
Route::get('/edit-enseignant-associate-matiere', [EnseignantController::class, 'edit'])->name('enseignant.edit');
Route::put('/update-enseignant-associate-matiere', [EnseignantController::class, 'update'])->name('enseignant.update');

});

require __DIR__.'/auth.php';
