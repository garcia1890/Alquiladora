<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    // 1. Mapeo a la tabla y clave primaria
    protected $table = 'usuario';
    protected $primaryKey = 'Id_Usuario';
    public $timestamps = false; // Desactivar si la tabla no tiene created_at y updated_at

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'Nombre',
        'Ape_pat',
        'Ape_mat',
        'Nom_usuario',
        'Email',
        'Telefono',
        'Contrasena', // Usamos el nombre del campo de la BD
        'Fecha_registro',
        'Calle',
        'Numero',
        'CP',
        'Municipio',
        'Estado',
        'Frecuente',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'Contrasena', // Ocultamos 'Contrasena' en lugar de 'password'
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'Fecha_registro' => 'date', // Conversión de campo
        'email_verified_at' => 'datetime',
        'Contrasena' => 'hashed', // ¡IMPORTANTE! Esto hashea automáticamente la contraseña.
    ];

    // 2. Sobrescribir el nombre de la columna de contraseña para Authenticatable
    public function getAuthPasswordName()
    {
        return 'Contrasena';
    }

    // 3. Sobrescribir el nombre de la columna de ID para Route Model Binding y Authenticatable
    public function getAuthIdentifierName()
    {
        return 'Id_Usuario';
    }
}
