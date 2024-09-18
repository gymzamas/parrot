<?php

// src/Entity/Contact.php

use Symfony\Component\Validator\Constraints as Assert;

class Contact
{
    /**
     * @Assert\NotBlank(message="Le nom ne peut pas être vide.")
     */
    private $nom;

    /**
     * @Assert\NotBlank(message="Le prénom ne peut pas être vide.")
     */
    private $prenom;

    /**
     * @Assert\NotBlank(message="L'adresse email ne peut pas être vide.")
     * @Assert\Email(message="Veuillez entrer une adresse email valide.")
     */
    private $email;

    /**
     * @Assert\NotBlank(message="Le numéro de téléphone ne peut pas être vide.")
     * @Assert\Regex("/^\+?[0-9]{10,15}$/", message="Veuillez entrer un numéro de téléphone valide.")
     */
    private $telephone;

    /**
     * @Assert\NotBlank(message="Le message ne peut pas être vide.")
     * @Assert\Length(min=10, minMessage="Le message doit contenir au moins 10 caractères.")
     */
    private $message;
}
