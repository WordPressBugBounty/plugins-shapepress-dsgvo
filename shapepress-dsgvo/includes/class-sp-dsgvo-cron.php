<?php

Class SPDSGVOCron{

	public function slug(){
		$reflect = new ReflectionClass($this);
		$class = $reflect->getShortName();
		return 'wp_cron__'. strtolower($class);
	}

	public function schedule(){
		return 'schedule_'. $this->slug();
	}

	public function calculateInterval(){
		if(is_array($this->interval)){
			$interval = 0;

			if( isset($this->interval['seconds']) &&
			    (is_int($this->interval['seconds']) || is_float($this->interval['seconds']))){
				$interval = $interval + ($this->interval['seconds']);
			}

			if( isset($this->interval['minutes']) &&
			    (is_int($this->interval['minutes']) || is_float($this->interval['minutes']))){
				$interval = $interval + ($this->interval['minutes'] * 60);
			}

			if( isset($this->interval['hours']) &&
			    (is_int($this->interval['hours']) || is_float($this->interval['hours']))){
				$interval = $interval + ($this->interval['hours'] * 3600);
			}

			if( isset($this->interval['days']) &&
			    (is_int($this->interval['days']) || is_float($this->interval['days']))){
				$interval = $interval + ($this->interval['days'] * 86400);
			}

			if( isset($this->interval['weeks']) &&
			    (is_int($this->interval['weeks']) || is_float($this->interval['weeks']))){
				$interval = $interval + ($this->interval['weeks'] * 604800);
			}

			if( isset($this->interval['months']) &&
			    (is_int($this->interval['months']) || is_float($this->interval['months']))){
				$interval = $interval + ($this->interval['months'] * 2628000);
			}

			return $interval;

		}else if(is_int($this->interval)){
			return $this->interval;
		}else{
			// parse string??
		}

		throw new Exception("Interval not valid");
	}

	public function scheduleFilter($schedules){
		$interval = $this->calculateInterval();

		if(!in_array($this->schedule(), array_keys($schedules))){
			$schedules[$this->schedule()] = array(
				'interval' => $interval,
				'display'  => __('All', 'shapepress-dsgvo') . ' '. floor($interval / 60) .' ' . __('Minutes', 'shapepress-dsgvo'),
			);
		}

		return $schedules;
	}

	public static function register(){
		$class = get_called_class();
		$self  = new $class;
		$slug  = $self->slug();

		add_filter('cron_schedules', array($self, 'scheduleFilter'));

		if(!wp_next_scheduled($slug)){
		    wp_schedule_event(time(), $self->schedule(), $slug);
		}

		if(method_exists($self, 'handle')){
			 add_action($slug, array($self, 'handle'));
		}
	}
}
