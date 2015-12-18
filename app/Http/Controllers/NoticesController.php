<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Guard;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class NoticesController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
        parent::__construct();// "$this->user" defined in parent controller
    }
    
    public function index() {
        //return 'all notices';
        //return \App\Notice::all();
        //return \Auth::user()->notices;
        //return $this->user->notices;// "$this->user" defined in parent controller
        $notices = $this->user->notices;
        //$notices = $this->user->notices()->where('content_removed', 0)->get();
        //$notices = $this->user->notices()->latest()->get();
        return view('notices/index', compact('notices'));
    }
    
    public function create() {
        // get list of providers
        $providers = \App\Provider::lists('name', 'id');
        
        // load a view to create a new notice
        return view('notices/create', compact('providers'));
    }
    
    public function confirm(Requests\PrepareNoticeRequest $request) {// "$this->user" defined in parent controller
//    public function confirm(Requests\PrepareNoticeRequest $request, Guard $auth) {// using method injection for getting "Guard $auth"
/*
//    public function confirm(Requests\PrepareNoticeRequest $request) {
        $data = $request->all()+[
//          'name' => \Auth::user()->name,
//          'email' => \Auth::user()->email,
          'name' => $auth->user()->name,
          'email' => $auth->user()->email,
        ];
        
        $template = view()->file(app_path('Http/Templates/dmca.blade.php'), $data);// specifying path to file to be used as view*/
  
        $data = $request->all();
        $template = $this->compileDmcaTemplate($data);// "$this->user" defined in parent controller
        //$template = $this->compileDmcaTemplate($data, $auth);
        
        session()->flash('dmca', $data);
        
        return view('notices/confirm', compact('template'));
    }
    
//    public function store(Request $request, AppMailer $mailer) {
    public function store(Request $request) {
        //ini_set('display_errors', '1');

        //$data = session()->get('dmca');
        //return $data;
        //return \Request::input('template');
        
        // Form data is flashed. Get with session()->get('dmca')
        // Template is in request. Request::input('template')
        // So build up a Notice object (craete table too)
        // new Notice();// We can create object by simply using "new", however its better to name it according to the conventions being used in domain like "opening a notice" translates to "open" method on Notice object
         /*$notice = Notice::open($data);// think of "open" method as simple named constructor, i.e. giving name to instantiating new constructor
         $notice->useEmail($request->input('template'));
         $notice->save();*/
        /*Notice::open($data)// think of "open" method as simple named constructor, i.e. giving name to instantiating new constructor
            ->useTemplate($request->input('template'))
            ->save();*/
        /*$notice = \App\Notice::open($data)->useTemplate($request->input('template'));
        \Auth::user()->notices()->save($notice);*/
        
        //\Auth::user()->notices()->create($array_of_fields);
        
        $notice = $this->createNotice($request);
//        $this->createNotice($request);
        

        //session()->flash('notification', 'You are now logged in');// Using session Facade to save notifications

        // persist it with this data.
        // And then fire off the email.
        //\Mail::send();// Using Mail Facade
        //\Mail::queue();// Using Mail queue, as smtp mails are slowest processes, instead of keeping user waiting we can queue them up
        //\Mail::raw();// Suitable when you already have text for email instead of view and you want to send the email rightaway instead of using queue
        //$mailer->sendDmcaNotice($notice);// Using injected mailer class from your app, suitable if your application is fireing alot of mails with different subjects, views; methods for each variant can be setup in mailer class
        //event('DmcaWasCreated', $notice);// Using event generation to send mails, will need to listen the event elsewhere in app.

        //\Mail::queue(['html' => 'emails/dmca'], compact('notice'), function($message) use ($notice) { // HTML version of email, you can specify both text & HTML versions of email view
        \Mail::queue(['text' => 'emails/dmca'], compact('notice'), function($message) use ($notice) { // Text version of email
        //\Mail::queue('emails/dmca', compact('notice'), function($message) use ($notice) {
//            $message->to('copyright@youtube.com')// Hardcoded version
            $message->from($notice->getOwnerEmail())
                    ->to($notice->getRecipientEmail())
                    ->subject('DMCA Notice');
        });
        
        flash('Your DMCA notice has been delivered!');
        
        return redirect('notices');
    }
    
    public function update($noticeId, Request $request) {
        $isRemoved = $request->has('content_removed');
        
        \App\Notice::findOrFail($noticeId)
                ->update(['content_removed' => $isRemoved]);
        
        //return redirect()->back();
    }
    
    public function compileDmcaTemplate($data) {// "$this->user" defined in parent controller
//    public function compileDmcaTemplate($data, Guard $auth) {
        $data = $data + [
          'name' => $this->user->name,
          'email' => $this->user->email,
          /*'name' => $auth->user()->name,
          'email' => $auth->user()->email,*/
        ];
        
        return view()->file(app_path('Http/Templates/dmca.blade.php'), $data);// specifying path to file to be used as view
    }
    
    private function createNotice(Request $request) {
//        $data = session()->get('dmca');
        $notice = session()->get('dmca') + ['template' => $request->input('template')];// this way you won't need "open()" & "useTemplate()" methods on Notice object
        
//        $notice = \App\Notice::open($data)->useTemplate($request->input('template'));
        
//        \Auth::user()->notices()->save($notice);
        
        $notice = $this->user->notices()->create($notice);// "$this->user" defined in parent controller
//        $notice = \Auth::user()->notices()->create($notice);
        
        return $notice;
    } 
}
