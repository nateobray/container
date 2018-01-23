<?php

namespace obray;
/**
 * This class implements ContainerInterface.
 */
Class oDIContainer implements \Psr\Container\ContainerInterface
{

    // @var array|null $dependencies contains a list of registered dependencies loaded from config file in constructor
    protected $dependencies;

    /**
     * Instantiates a DI Container with the specified config file
     *
     * @param string $path_to_config A string with the full path to a DI config file
     *
     * @return void
     */

    public function __construct( $path_to_config )
    {
        
        if (file_exists($path_to_config)) {
            $this->dependencies = include $path_to_config;
            return $this;
        }
        throw new \obray\oFileNotFoundException('Unable to find '.$path_to_config, 500);
    }

    /**
     * Gets a 
     *
     * @param string $id A string with the full name of the desired object
     *
     * @return object
     */

    public function get( $id )
    {
        if ( $this->has($id) ){

            // if we have dependency registered in our array, return it
            if (!empty($this->dependencies[$id])) {
                return $this->dependencies[$id];
            }

            // if we have a factory then make object and return it
            if (!empty($this->factory)) {
                return $this->make($id);
            }
            
        }
        
        // unable to find $id then throw error
        throw new \obray\oNotFoundException('Dependency ' . $id . ' was not found.', 500);
    }

    /**
     * Tests if the container has a reference to the specified class
     *
     * @param string $id A string with the full name of the desired object
     *
     * @return bool
     */

    public function has( $id )
    {
        if (!empty($this->dependencies[$id])) {
            return true;
        }
        return class_exists($id);
    }

    public function useFactory(\obray\oFactoryInterface $factory){
        $this->factory = $factory;
    }
}
