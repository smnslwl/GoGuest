<?php

class Validator {
    private $_form;
    private $_method;
    private $_source;
    private $_errors;
    private $_values;

    public function __construct($method, $source)
	{
        $this->_method = $method;
        $this->_source = $source;
        $this->_form = 'default';
        $this->_errors = array();
        $this->_values = array();
        $this->_messages = array();
        $this->start();
    }

    public function start()
    {
        if (Request::method() !== $this->_method) {
            redirect(url('home'));
        }

        if ($this->_method == 'POST') {
            if (!Session::verify_csrf_token(Request::POST('csrf_token'))) {
                redirect(url('home'));
            }
            $this->_form = Request::POST('form_name');
        }
    }

    public function form()
    {
        return $this->_form;
    }

    public function method()
    {
        return $this->_method;
    }

    public function source()
    {
        return $this->_source;
    }

    public function add_error($field, $message)
    {
        if (!array_key_exists($field, $this->_errors)) {
            $this->_errors[$field] = array();
        }
        $this->_errors[$field][] = $message;
    }

    public function add_value($field, $value)
    {
        $this->_values[$field] = $value;
    }

    public function add_message($message)
    {
        if (!array_key_exists($this->_form, $this->_messages)) {
            $this->_messages[$this->_form] = array();
        }
        $this->_messages[$this->_form][] = $message;
    }

    public function validate()
    {
        Session::set('form_name', $this->_form);

        $has_errors = false;
        foreach ($this->_errors as $field => $field_errors) {
            if (count($field_errors) > 0) {
                $has_errors = true;
                break;
            }
        }

        if ($has_errors) {
            Session::set('errors', $this->_errors);
            Session::set('values', $this->_values);
            redirect($this->_source);
        } else {
            Session::remove('errors');
            Session::remove('values');
        }
    }

    public function finish()
    {
        Session::set('messages', $this->_messages);
    }

};
