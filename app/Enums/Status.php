<?php

namespace App\Enums;

enum Status: string
{
    case EnAttente = 'en_attente';
    case Valide = 'valide';
    case Rejete = 'rejete';
}
