<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\UserContributor;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class LoginController extends Controller
{
    /**
     * Display a index view.
     *
     * @return view
     */
    public function index()
    {
        session_set_cookie_params(0);
        if(session_status() === PHP_SESSION_NONE) 
                { 
                    session_start(); 
                }

        if(isset($_SESSION['login'])){

            if($_SESSION['login'] == "Si"){

                //Sino tengo tiempo de inicio de acceso, que inicie sesion
                if(!isset($_SESSION['acceso'])){
                    session_unset();
                    session_destroy();
        
                    if(session_status() === PHP_SESSION_NONE) { 
                        session_start(); 
                    }

                    $_SESSION["error_login"] = "Por favor, inicie sesion";
                    return view('auth.login', []);
                }


                if((time() - $_SESSION['acceso']) > 1000){

                    session_unset();
                    session_destroy();
        
                    if(session_status() === PHP_SESSION_NONE) { 
                        session_start(); 
                    }
                    $_SESSION["error_login"] = "Sesion Caducada, Por favor inicie sesion";
                    return redirect('/');
        
                }

                return redirect('/creacion_npe');  
            }

        }

        return view('auth.login', [ 

        ]);
    }

    /**
     * Method to verify login.
     *
     * @return view
     */
    public function login(Request $request)
    {
        
        

        if(!isset($request->nitRequest) || !isset($request->password) ){
            
            if(session_status() === PHP_SESSION_NONE) 
                { 
                    session_start(); 
                }
            $_SESSION["error_login"] = "Complete los datos solicitados";
            return redirect('/');

        }

        if($request->nitRequest == "" || $request->password == "" ){
            if(session_status() === PHP_SESSION_NONE) 
            { 
                session_start(); 
            }
                $_SESSION["error_login"] = "Complete los datos solicitados";
                return redirect('/');
        }

        $count_nit =  app('db')->table('user_contributors')
        ->select(DB::raw('user_contributors.password, user_contributors.nit'))
        ->where('user_contributors.nit', '=', $request->nitRequest)
        ->first();

        if($count_nit == null){

            if(session_status() === PHP_SESSION_NONE) 
                { 
                    session_start(); 
                }
            $_SESSION["error_login"] = "El numero de NIT no se encuentra registrado";
            return redirect('/');

        }

        if (Hash::check($request->password, $count_nit->password)) {

            if(session_status() === PHP_SESSION_NONE) 
                { 
                    session_start(); 
                }
            $_SESSION["login"] = "Si";
            $_SESSION["nit"] = $request->nitRequest;
            $_SESSION["acceso"] = time();
            return redirect('/creacion_npe');

        }else{
            if(session_status() === PHP_SESSION_NONE) 
                { 
                    session_start(); 
                }
            $_SESSION["error_login"] = "Contraseña Incorrecta";
            return redirect('/');
        }
        
    }

    /**
     * Display a register view.
     *
     * @return view
     */
    public function register()
    {
        // dd($request->session());

        return view('auth.register', [ 

        ]);
    }

    /**
     * Display a register view.
     *
     * @return view
     */
    public function register_store(Request $request)
    {
        if(!isset($request->nitRequest) || !isset($request->firstname) || !isset($request->lastname) 
            || !isset($request->email) || !isset($request->password) || !isset($request->confirm_password)  || !isset($request->username)
            || !isset($request->tipo_registro) || !isset($request->pdf_nit)){
            
                if(session_status() === PHP_SESSION_NONE) 
                { 
                    session_start(); 
                }
            $_SESSION["error_register"] = "Complete los datos solicitados y suba todos los documentos solicitados";
            return view('auth.register', [ 
                "request" => $request->all()
            ]);

        }
        if($request->file('pdf_nit')->getSize() > 3145728){
            if(session_status() === PHP_SESSION_NONE) 
                { 
                    session_start(); 
                }
            $_SESSION["error_register"] = "Documento NIT demasiado pesado";
            return view('auth.register', [ 
                "request" => $request->all()
            ]);
        }

        if($request->nitRequest == "" || $request->firstname== "" || $request->email == "" 
            || $request->password == "" || $request->confirm_password == "" || $request->username == "" || $request->tipo_registro == ""){
                if(session_status() === PHP_SESSION_NONE) 
                { 
                    session_start(); 
                }
                $_SESSION["error_register"] = "Complete los datos solicitados";
                return view('auth.register', [ 
                    "request" => $request->all()
                ]);
        }

        if(preg_match('/^([0-9]{14})$/', $request->nitRequest) == 0){  

            if(session_status() === PHP_SESSION_NONE) 
            { 
                session_start(); 
            }
            $_SESSION["error_register"] = "Formato de NIT invalido";

            return view('auth.register', [ 
                "request" => $request->all()
            ]);

        }

        if(strlen($request->password) < 8){
            if(session_status() === PHP_SESSION_NONE) 
            { 
                session_start(); 
            }
            $_SESSION["error_register"] = "Su contraseña debe contener mas de 8 caracteres";
            return view('auth.register', [ 
                "request" => $request->all()
            ]);
        }

        if($request->password !==  $request->confirm_password){
            if(session_status() === PHP_SESSION_NONE) 
            { 
                session_start(); 
            }
            $_SESSION["error_register"] = "Las contraseñas deben coincidir";
            return view('auth.register', [ 
                "request" => $request->all()
            ]);
        }

        
        if($request->tipo_registro == 2){
            if( !isset($request->pdf_nrc)){
            
                if(session_status() === PHP_SESSION_NONE) 
                { 
                    session_start(); 
                }

                $_SESSION["error_register"] = "Por favor suba todos los documentos solicitados";
                return view('auth.register', [ 
                    "request" => $request->all()
                ]);

            }

            if($request->file('pdf_nrc')->getSize() > 3145728){
                if(session_status() === PHP_SESSION_NONE) 
                    { 
                        session_start(); 
                    }
                $_SESSION["error_register"] = "Documento NRC demasiado pesado.";
                return view('auth.register', [ 
                    "request" => $request->all()
                ]);
            }


        }else{
            if( !isset($request->pdf_dui)){
            
                if(session_status() === PHP_SESSION_NONE) 
                { 
                    session_start(); 
                }

                $_SESSION["error_register"] = "Por favor suba todos los documentos solicitados";
                return view('auth.register', [ 
                    "request" => $request->all()
                ]);

            }

            if($request->file('pdf_dui')->getSize() > 3145728){
                if(session_status() === PHP_SESSION_NONE) 
                    { 
                        session_start(); 
                    }
                $_SESSION["error_register"] = "Documento DUI demasiado pesado.";
                return view('auth.register', [ 
                    "request" => $request->all()
                ]);
            }
        }

        $count_nit =  app('db')->table('user_contributors')
        ->select(DB::raw('COUNT(user_contributors.id) as count'))
        ->where('user_contributors.nit', '=', $request->nitRequest)
        ->get();

        if($count_nit[0]->count > 0){
            session_start();
            $_SESSION["error_register"] = "El numero de NIT ya se encuentra registrado";
            return view('auth.register', [ 
                "request" => $request->all()
            ]);
        }


        $count_email =  app('db')->table('user_contributors')
        ->select(DB::raw('COUNT(user_contributors.id) as count'))
        ->where('user_contributors.email', '=', $request->email)
        ->get();

        if($count_email[0]->count > 0){
            if(session_status() === PHP_SESSION_NONE) 
            { 
                session_start(); 
            }
            $_SESSION["error_register"] = "El correo ingresado ya se encuentra registrado";
            return view('auth.register', [ 
                "request" => $request->all()
            ]);
        }

        $count_username =  app('db')->table('user_contributors')
        ->select(DB::raw('COUNT(user_contributors.id) as count'))
        ->where('user_contributors.username', '=', $request->username)
        ->get();

        if($count_username[0]->count > 0){
            if(session_status() === PHP_SESSION_NONE) 
            { 
                session_start(); 
            }
            $_SESSION["error_register"] = "El username seleccionado no esta disponible";
            return view('auth.register', [ 
                "request" => $request->all()
            ]);
        }
        
        $mytime = Carbon::now('America/El_Salvador');
        try{
            $user = UserContributor::create([
                'firstname'     => $request->firstname,
                'lastname'      => $request->lastname,
                'nit'           => $request->nitRequest,
                'email'         => $request->email,
                'username'      => $request->username,
                'password'      => Hash::make($request->password),
                'estado'        => 1,
                'tipo_registro' => $request->tipo_registro,
                'created_at'    => $mytime->toDateTimeString(),
            ]);

        }catch(\Exception $e){

            if(session_status() === PHP_SESSION_NONE) 
            { 
                session_start(); 
            }                
            $_SESSION["error_register"] = "Su usuario no pudo ser registrado verifique sus datos.";
            return view('auth.register', [ 
                "request" => $request->all()
            ]);
            
        }

        $identificador = "nit" . $request->nitRequest . ".pdf";
        $request->pdf_nit->move(storage_path('uploads'), $identificador);

        

        if($request->tipo_registro == 2){
            $identificador = "nrc" . $request->nitRequest . ".pdf";
            $request->pdf_nrc->move(storage_path('uploads'), $identificador);
        }else{
            $identificador = "dui" . $request->nitRequest . ".pdf";
            $request->pdf_dui->move(storage_path('uploads'), $identificador);
        }
 
        if(session_status() === PHP_SESSION_NONE){ 
            session_start(); 
        }
        $_SESSION["success_login"] = "Registro Exitoso!";
        
        return redirect("/");
    }

    /**
     * Display a register view.
     *
     * @return view
     */
    public function reset()
    {
        // dd($request->session());

        return view('auth.reset', [ 

        ]);
    }


     /**
     * Method to verify login.
     *
     * @return view
     */
    public function recover(Request $request)
    {
        
        

        if(!isset($request->nitRequest) || !isset($request->email) ){
            
            if(session_status() === PHP_SESSION_NONE) 
                { 
                    session_start(); 
                }
            $_SESSION["error_reset"] = "Complete los datos solicitados";
            return redirect('/reset');

        }

        if($request->nitRequest == "" || $request->email == "" ){
            if(session_status() === PHP_SESSION_NONE) 
            { 
                session_start(); 
            }
                $_SESSION["error_reset"] = "Complete los datos solicitados";
                return redirect('/reset');
        }

        $count_nit =  app('db')->table('user_contributors')
        ->select(DB::raw('user_contributors.password, user_contributors.nit'))
        ->where('user_contributors.nit', '=', $request->nitRequest)
        ->where('user_contributors.email', '=', $request->email)
        ->first();

        if($count_nit == null){

            if(session_status() === PHP_SESSION_NONE) 
                { 
                    session_start(); 
                }
            $_SESSION["error_reset"] = "No se encuentra registro con los datos proporcionador";
            return redirect('/reset');

        }


        $token = md5(uniqid($request->nitRequest, true));
        app('db')->table('user_contributors')
                    ->where('user_contributors.nit', '=', $request->nitRequest)
                    ->where('user_contributors.email', '=', $request->email)
                    ->update(['token_reset' => $token]);

        $url_reset = url('/') . "/restablecer_contrasenia?token=" .$token;

        $data = array('body' => $url_reset);

        Mail::send('mail', $data, function($message) use ($request) {
            $message->to($request->email, 'Contribuyente')->subject('Restablecer Contraseña');
            $message->from(env('MAIL_FROM_ADDRESS'),'Colecturia Minsal');
        });
        
        if(session_status() === PHP_SESSION_NONE) { 
            session_start(); 
        }
        $_SESSION["success_login"] = "Se ha enviado a su correo un enlace para restablecer su contraseña";
        return redirect("/");
        
    }

    public function restablecer_contrasenia()
    {
        return view('auth.restablecer_contrasenia', []);
    }

    public function new_password(Request $request)
    {

        if(!isset($request->token)){
            
            if(session_status() === PHP_SESSION_NONE) 
                { 
                    session_start(); 
                }
            $_SESSION["error_login"] = "Parece que sucedio algo extraño, intenta restablece tu contraseña de nuevo";

            return redirect('/');

        }

        if($request->token == ""){
            if(session_status() === PHP_SESSION_NONE) 
                { 
                    session_start(); 
                }
            $_SESSION["error_login"] = "Parece que sucedio algo extraño, intenta restablece tu contraseña de nuevo";

            return redirect('/');
        }

        if(!isset($request->password) || !isset($request->confirm_password)){
            
            if(session_status() === PHP_SESSION_NONE) 
                { 
                    session_start(); 
                }
            $_SESSION["error_new_pass"] = "Complete los datos solicitados";

            return redirect('/restablecer_contrasenia?token='.$request->token);
        }

        if($request->password == "" || $request->confirm_password == ""){
            
            if(session_status() === PHP_SESSION_NONE) 
                { 
                    session_start(); 
                }
            $_SESSION["error_new_pass"] = "Complete los datos solicitados";
            
            return redirect('/restablecer_contrasenia?token='.$request->token);
        }

        if( $request->password !== $request->confirm_password ){
            
            if(session_status() === PHP_SESSION_NONE) 
                { 
                    session_start(); 
                }
            $_SESSION["error_new_pass"] = "Las contraseñas no coinciden";
            
            return redirect('/restablecer_contrasenia?token=' . $request->token);
        }

        if(strlen($request->password) < 8){
            if(session_status() === PHP_SESSION_NONE) 
            { 
                session_start(); 
            }
            $_SESSION["error_new_pass"] = "Su contraseña debe contener mas de 8 caracteres";
            return redirect('/restablecer_contrasenia?token=' . $request->token);
        }

        $count_nit =  app('db')->table('user_contributors')
        ->select(DB::raw('user_contributors.password, user_contributors.nit'))
        ->where('user_contributors.token_reset', '=', $request->token)
        ->first();

        if($count_nit == null){

            if(session_status() === PHP_SESSION_NONE) 
                { 
                    session_start(); 
                }
            $_SESSION["error_login"] = "Parece que sucedio algo extraño, intenta restablece tu contraseña de nuevo";
            return redirect('/');

        }
        
        app('db')->table('user_contributors')
                ->where('user_contributors.token_reset', '=', $request->token)
                ->update([
                    'token_reset' => null,
                    'password'    => Hash::make($request->password),
                ]);
        
        if(session_status() === PHP_SESSION_NONE) { 
            session_start(); 
        }
        $_SESSION["success_login"] = "Contraseña restablecida exitosamente";
        return redirect("/");
                
    }

    public function logout(){
        if(session_status() === PHP_SESSION_NONE) 
        { 
            session_start(); 
        }
        session_unset();
        session_destroy();
        return redirect("/");
    }

    public function descargarAdjunto($name){
        return response()->download(storage_path() ."/uploads/" . $name . ".pdf");
    }
    
}
