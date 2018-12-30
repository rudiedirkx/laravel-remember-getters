<?php

namespace rdx\remgets;

use Illuminate\Support\Str;

trait RemembersAttributes {

	protected $_remembered = [];

	public function getAttribute($key) {
		if ($this->canGetRememberValue($key)) {
			return $this->getRememberValue($key);
		}

		return parent::getAttribute($key);
	}

	public function fill(array $attributes) {
		$this->forgetRememberedAttributes();

		return parent::fill($attributes);
	}



	public function canGetRememberValue($name) {
		return $this->hasRememberedAttribute($name) || $this->hasRememberableAttribute($name);
	}

	public function getRememberValue($name) {
		if ($this->hasRememberedAttribute($name)) {
			return $this->getRememberedAttribute($name);
		}

		if ($this->hasRememberableAttribute($name)) {
			return $this->getRememberableAttribute($name);
		}
	}

	public function hasRememberedAttribute($name) {
		return array_key_exists($name, $this->_remembered);
	}

	public function getRememberedAttribute($name) {
		return $this->_remembered[$name];
	}

	public function rememberAttribute($name, $value) {
		$this->_remembered[$name] = $value;
		return $value;
	}

	public function forgetRememberedAttribute($name) {
		unset($this->_remembered[$name]);
	}

	public function forgetRememberedAttributes() {
		$this->_remembered = [];
	}

	public function hasRememberableAttribute($name) {
		return method_exists($this, 'remember' . Str::studly($name) . 'Attribute');
	}

	public function getRememberableAttribute($name) {
		return $this->rememberAttribute($name, call_user_func([$this, 'remember' . Str::studly($name) . 'Attribute']));
	}

}
