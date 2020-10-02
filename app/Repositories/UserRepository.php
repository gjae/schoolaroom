<?php

namespace App\Repositories;

use App\Models\User;
use App\Contracts\HasUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Events\Registered;

class UserRepository extends Repository
{
    public function __construct(?User $user)
    {
        parent::__construct($user ?? new User());
    }

    /**
     * @return Model
     */
    protected function newInstance() : Model
    {
        return new User;
    }

    /**
     * @param HasUser $model
     * @return Model
     */
    public function generateUser(HasUser $model, string $password) : Model
    {
        if( is_null($this->getModel()) )
            throw new \Exception("Model not found");

        $user = $this->create([
            'email' => $model->getEmail(),
            'password' => bcrypt($password),
            'model_type' => get_class($model),
            'model_id' => $model->id,
            'name' => $model->getName(),
        ]);

        event(new Registered($user));

        return $user;
    }
}