use Illuminate\Support\Facades\Route;

//View
Route::get('/', [StudentsController::class, 'myWelcomeView'])->name("std.myWelcomeView"); 
Route::get('/', [StudentsController::class,  'myWelcomeView'])->name("std.myWelcomeView"); 

//Create
Route::post("/create", [StudentsController::class, "createNewStd"])->name("std.createNew");