<?php

// Helper class for a form.
// If the user submits the form and there are errors, it gets the errors for each field from session.
// It also remembers previous values of fields.
class Form {
    private $_name;
    private $_action;
    private $_method;
    private $_errors;
    private $_values;
    private $_messages;

    public function __construct($name, $method, $action)
	{
        $this->_name = $name;
        $this->_method = $method;
        $this->_action = $action;
        $this->_errors = Session::get('errors', array());
        $this->_values = Session::get('values', array());
        $messages = Session::get('messages', array());
        if (array_key_exists($this->_name, $messages)) {
            $this->_messages = $messages[$this->_name];
            unset($_SESSION['messages'][$this->_name]);
        }
        Session::remove('errors');
        Session::remove('values');
    }

    public function name()
    {
        return $this->_name;
    }

    public function method()
    {
        return $this->_method;
    }

    public function action()
    {
        return $this->_action;
    }

    public function has_errors_any()
    {
        return (isset($this->_errors) && count($this->_errors) > 0);
    }

    public function has_errors($field)
    {
        return (isset($this->_errors[$field]) && count($this->_errors[$field]) > 0);
    }

    public function has_messages()
    {
        return (isset($this->_messages) && count($this->_messages) > 0);
    }

    public function messages()
    {
        return (isset($this->_messages)) ? $this->_messages : array();
    }

    public function error($field)
    {
        return $this->has_errors($field) ? $this->_errors[$field][0] : '';
    }

    public function errors($field)
    {
        return $this->has_errors($field) ? $this->_errors[$field] : array();
    }

    public function value($field)
    {
        return isset($this->_values[$field]) ? $this->_values[$field] : '';
    }

    public function get_csrf_field()
    {
        return '<input type="hidden" name="csrf_token" value="' . Session::get_csrf_token() . '">';
    }

    public function get_name_field()
    {
        return '<input type="hidden" name="form_name" value="' . $this->name() . '">';
    }

    public function get_meta_fields()
    {
        return $this->get_name_field() . ' ' . $this->get_csrf_field();
    }

};
