<?php
	
	/* Set the active state of the currentt URI */
	
	function set_active($path, $active = 'active'){

		return Request::is($path) ? $active : '';
	}
?>