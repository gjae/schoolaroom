<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Exception as ModelNotFoundException;
use App\Contracts\Repository as RepositoryInterface;

abstract class Repository implements RepositoryInterface
{
    protected $model;

    public function __construct(Model $model)
    {
        if( is_null($model) )
            throw new ModelNotFoundException( "Repository need Model instance" );
        
        $this->setModel( $model );
    }



    /**
     * @param string $method
     * @param array $args
     * @return mixed
     */
    public function __call($method, $args = [])
    {
        return call_user_func_array([$this->getModel(), $method], $args);
    }
    
    /**
     * @param string $attribute
     * @return void
     */
    public function __get($attribute)
    {
        return $this->getModel()->{$attribute};
    }

    public function all()
    {
        if( is_null($this->getModel()->id) )
            return $this->getModel()->get();

        else
            return $this->newInstance()->get();
    }

    /**
     * Crea un nuevo registro en la base de datos para em model indicado
     *
     * @param array $recordData
     * @return Model|null
     */
    public function create(array $recordData) : ?Model
    {
        return $this->setModel(
            $this->getModel()->create( $recordData )
        )->getModel();
    }

    /**
     * Busca un nuevo registro en la BD a partir de su ID
     *
     * @param integer $id
     * @return Model|null
     */
    public function findById($id)
    {
        if( !is_null( $this->getModel()->id ) )
            $this->setModel( $this->newInstance() );

        return $this->setModel(
            $this->getModel()->find($id)
        );
    }

    /**
     * Actualiza los datos de un registro
     *
     * @param array $newRecordData
     * @return Model
     */
    public function update(array $newRecordData, ?int $id = null) : Model
    {
        if( !is_null($id) )
            $this->findById( $id );
        
        if( is_null( $this->getModel() ) )
            throw new ModelNotFoundException( "No se encuentra un modelo para actualizar" ); 

        $this->getModel()->fill($newRecordData);
        $this->getModel()->save();

        return $this->getModel();
    }   

    /**
     * Elimina un registro de la base de dato
     *
     * @return boolean
     */
    public function delete()
    {
        if( !is_null( $this->getModel() ) )
            $this->getModel()->delete();

        return $this;
    }

    /**
     * Get the value of model
     */ 
    public function getModel() : ?Model
    {
        return $this->model;
    }

    /**
     * Set the value of model
     *
     * @return  self
     */ 
    public function setModel(?Model $model)
    {
        $this->model = $model;

        return $this;
    }

    /**
     * Return true if repository has somevalid model
     *
     * @return boolean
     */
    public function hasModel()
    {
        return !is_null($this->model) && !is_null($this->model->id);
    }

    protected abstract function newInstance() : Model;
}