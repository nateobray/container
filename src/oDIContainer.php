<?php
	namespace obray
	Class oDIContainer implements \psr\container\ContainerInterface {

		protected $dependencies;

		public function __construct( $path )
		{
			if( file_exists($path) ){
				$this->dependencies = include $path;
				return;
			}
			throw new \Exeception("DI Container config file ".$path." not found");
		}

		public function get( string $entry )
		{

			if( $this->has($entry) )
			{
				return $this->dependencies[$entry];
			}

		}

		public function has( string $entry )
		{

			if( in_array( $entry, $this->dependencies) )
			{
				return TRUE;
			}
			return FALSE;
		}

	}
?>
