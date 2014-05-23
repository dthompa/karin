<?php
/**
* Holding a instance of CKarin to enable use of $this in subclasses.
*
* @package KarinCore
*/
class CObject {

        protected $ka;
        protected $config;        
        protected $request;
        protected $data;
        protected $db;
        protected $views;
        protected $session;
        protected $user;

   /**
    * Constructor
    */
   protected function __construct($ka=null) {
     if(!$ka) {
      $ka = CKarin::Instance();
    }
    $this->ka       = &$ka;
    $this->config   = &$ka->config;
    $this->request  = &$ka->request;
    $this->data     = &$ka->data;
    $this->db       = &$ka->db;
    $this->views = &$ka->views;
    $this->session = &$ka->session;
    $this->user     = &$ka->user;
  }
  
    /**
         * Wrapper for same method in CKarin. See there for documentation.
         */
        protected function RedirectTo($urlOrController=null, $method=null, $arguments=null) {
    $this->ka->RedirectTo($urlOrController, $method, $arguments);
  }


        /**
         * Wrapper for same method in CKarin. See there for documentation.
         */
        protected function RedirectToController($method=null, $arguments=null) {
    $this->ka->RedirectToController($method, $arguments);
  }


        /**
         * Wrapper for same method in CKarin. See there for documentation.
         */
        protected function RedirectToControllerMethod($controller=null, $method=null, $arguments=null) {
    $this->ka->RedirectToControllerMethod($controller, $method, $arguments);
  }


       /**
         * Wrapper for same method in CKarin. See there for documentation.
         */
  protected function AddMessage($type, $message, $alternative=null) {
    return $this->ka->AddMessage($type, $message, $alternative);
  }


        /**
         * Wrapper for same method in CKarin. See there for documentation.
         */
        protected function CreateUrl($urlOrController=null, $method=null, $arguments=null) {
    return $this->ka->CreateUrl($urlOrController, $method, $arguments);
  }

}
