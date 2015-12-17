<?php
  namespace App\Http\Controllers;

  class MyBaseController extends Controller {

    protected $app;
    //protected $active_settings;

    public function __construct($sublayout = NULL) {
      $this->app = app();
      //$this->context = $this->app->context;

      //$this->language_id = $this->active_settings->language_id;
      //$this->currency_id = $this->active_settings->currency_id;
      //$this->customer_id = $this->active_settings->customer_id;
    }

    //
    /**
     * Setup the layout used by the controller.
     *
     * @return void
     */
    protected function setupLayout() {
      if (!is_null($this->layout)) {
        $this->layout = View::make($this->layout);
      }
    }
  }
