<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EtudiantMasterRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Autoriser la validation pour tous les utilisateurs
    }

    public function rules()
    {        
        return [
            'etablissement_id' => 'required',
            'CNE' => 'required|min:7|max:20',
            'CIN' => 'required|min:3|max:10',
            'nom' => 'required|min:2|max:50',
            'prenom' => 'required|min:2|max:50',
            // 'nomar' => 'required|min:2|max:50',
            // 'prenomar' => 'required|min:2|max:50',
            // 'datenais' => 'required|date',
            // 'sexe' => 'required',
            // 'payschamp' => 'required|min:2|max:70',
            // 'villenais' => 'required|min:2|max:70',
            // 'villechamp' => 'required|min:2|max:70',
            // 'adresse' => 'required|min:10|max:250',
            'email' => 'required',
            'phone' => 'required|digits:10',
    

            'serie' => 'required',


            'typelicence' => 'required|max:200',
            'mentionlp' => 'required',
            'specialitelp' => 'required|min:2|max:200',
            'etblsmtLp' => 'required|min:2|max:200',
            'ville_etablissement_licence' => 'required|min:2|max:150',
            'date_obtention_LP' => 'required',
            'moyenne_licence'   => 'required',
        

            'secteur' => 'required',
            'poste' => 'required',
            // 'lieutravail' => 'required',
            // 'villetravail' => 'required',
            
           
            'filiere' => 'nullable',
            'filiere_choix_1' => 'nullable',
            'filiere_choix_2' => 'nullable',
            'filiere_choix_3' => 'nullable',
            'confirmation' => 'required',
        ];  
    }

    public function messages()
    {
        return [
            'etablissement_id.required' => "L'établissement est obligatoire.",

            'CNE.required' => 'Le CNE est obligatoire.',
            'CNE.min' => 'Le CNE doit contenir au moins 7 caractères.',
            'CNE.max' => 'Le CNE ne doit pas dépasser 20 caractères.',

            'CIN.required' => 'Le CIN est obligatoire.',
            'CIN.min' => 'Le CIN doit contenir au moins 3 caractères.',
            'CIN.max' => 'Le CIN ne doit pas dépasser 10 caractères.',

            'nom.required' => 'Le nom est obligatoire.',
            'nom.min' => 'Le nom doit contenir au moins 2 caractères.',
            'nom.max' => 'Le nom ne doit pas dépasser 50 caractères.',

            'prenom.required' => 'Le prénom est obligatoire.',
            'prenom.min' => 'Le prénom doit contenir au moins 2 caractères.',
            'prenom.max' => 'Le prénom ne doit pas dépasser 50 caractères.',

            'nomar.required' => 'Le nom en arabe est obligatoire.',
            'nomar.min' => 'Le nom en arabe doit contenir au moins 2 caractères.',
            'nomar.max' => 'Le nom en arabe ne doit pas dépasser 50 caractères.',

            'prenomar.required' => 'Le prénom en arabe est obligatoire.',
            'prenomar.min' => 'Le prénom en arabe doit contenir au moins 2 caractères.',
            'prenomar.max' => 'Le prénom en arabe ne doit pas dépasser 50 caractères.',

            'datenais.required' => 'La date de naissance est obligatoire.',
            'datenais.date' => 'La date de naissance doit être une date valide.',

            'sexe.required' => 'Le sexe est obligatoire.',

            'payschamp.required' => 'Le pays est obligatoire.',
            'payschamp.min' => 'Le pays doit contenir au moins 2 caractères.',
            'payschamp.max' => 'Le pays ne doit pas dépasser 70 caractères.',

            'villenais.required' => 'La ville de naissance est obligatoire.',
            'villenais.min' => 'La ville de naissance doit contenir au moins 2 caractères.',
            'villenais.max' => 'La ville de naissance ne doit pas dépasser 70 caractères.',

            'villechamp.required' => 'La ville est obligatoire.',
            'villechamp.min' => 'La ville doit contenir au moins 2 caractères.',
            'villechamp.max' => 'La ville ne doit pas dépasser 70 caractères.',

            'adresse.required' => 'L\'adresse est obligatoire.',
            'adresse.min' => 'L\'adresse doit contenir au moins 10 caractères.',
            'adresse.max' => 'L\'adresse ne doit pas dépasser 250 caractères.',

            'email.required' => 'L\'adresse e-mail est obligatoire.',

            'phone.required' => 'Le numéro de téléphone est obligatoire.',
            'phone.digits' => 'Le numéro de téléphone doit contenir exactement 10 chiffres.',


            'serie.required' => 'La série du bac est obligatoire.',


            'typelicence.required' => 'Le type de licence est obligatoire.',
            'mentionlp.required' => 'La mention de licence est obligatoire.',
            'specialitelp.required' => 'La spécialité de licence est obligatoire.',
            'specialitelp.min' => 'La spécialité de licence doit contenir au moins 2 caractères.',
            'specialitelp.max' => 'La spécialité de licence ne doit pas dépasser 200 caractères.',
            'moyenne_licence.required' => 'La moyenne du licence est obligatoire.',
    

    
            'secteur.required' => 'Veuillez indiquer le secteur',
            'nombreannee.required' => "Veuillez indiquer les nombres d'années d'expériences",
            'poste.required' => "Veuillez indiquer le poste",
            'lieutravail.required' => "Veuillez indiquer le lieu de travail",
            'villetravail.required' => "Veuillez indiquer la ville de travail",


            'confirmation.required' => 'La confirmation est obligatoire.',
        ];
    }


}
