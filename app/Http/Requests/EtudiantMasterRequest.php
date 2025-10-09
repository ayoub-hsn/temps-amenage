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
        if (($_REQUEST['fonctionnaire'] ?? '') == "NON") {    
            return [
                'etablissement_id' => 'required',
                'CNE' => 'required|min:7|max:20',
                'CIN' => 'required|min:3|max:10',
                'nom' => 'required|min:2|max:50',
                'prenom' => 'required|min:2|max:50',
                'nomar' => 'required|min:2|max:50',
                'prenomar' => 'required|min:2|max:50',
                'datenais' => 'required|date',
                'sexe' => 'required',
                'payschamp' => 'required|min:2|max:70',
                'villenais' => 'required|min:2|max:70',
                'villechamp' => 'required|min:2|max:70',
                'adresse' => 'required|min:10|max:250',
                'email' => 'required',
                'phone' => 'required|digits:10',
    
                'serie' => 'required',
                'Anneebac' => 'required',

                'dernier_diplome_obtenu' => 'required',
                'type_diplome_obtenu' => 'required|min:2|max:200',
                'specialitediplome' => 'required|min:2|max:200',
                'ville_etablissement_diplome' => 'required|min:2|max:150',
                'date_optention_diplome' => 'required',
               
                'fonctionnaire' => 'required',
                'secteur' => 'nullable',
                'nombreannee' => 'nullable',
                'poste' => 'nullable',
                'lieutravail' => 'nullable',
                'villetravail' => 'nullable',
                
                'path_photo' => 'nullable|file|mimes:jpeg,jpg,png|max:300',
                'path_cin'   => 'nullable|file|mimes:jpeg,jpg,png|max:300',
                'path_bac'   => 'nullable|file|mimes:jpeg,jpg,png|max:300',
                'path_licence' => 'nullable|file|mimes:jpeg,jpg,png|max:300',
                'path_attestation_non_emploi' => 'nullable|file|mimes:jpeg,jpg,png|max:300',
                'filiere' => 'nullable',
                'filiere_choix_1' => 'nullable',
                'filiere_choix_2' => 'nullable',
                'filiere_choix_3' => 'nullable',
                'confirmation' => 'required',
            ];
        }else{
            return [
                'etablissement_id' => 'required',
                'CNE' => 'required|min:7|max:20',
                'CIN' => 'required|min:3|max:10',
                'nom' => 'required|min:2|max:50',
                'prenom' => 'required|min:2|max:50',
                'nomar' => 'required|min:2|max:50',
                'prenomar' => 'required|min:2|max:50',
                'datenais' => 'required|date',
                'sexe' => 'required',
                'payschamp' => 'required|min:2|max:70',
                'villenais' => 'required|min:2|max:70',
                'villechamp' => 'required|min:2|max:70',
                'adresse' => 'required|min:10|max:250',
                'email' => 'required',
                'phone' => 'required|digits:10',
                
                'serie' => 'required',
                'Anneebac' => 'required',
                
                'dernier_diplome_obtenu' => 'required',
                'type_diplome_obtenu' => 'required|min:2|max:200',
                'specialitediplome' => 'required|min:2|max:200',
                'ville_etablissement_diplome' => 'required|min:2|max:150',
                'date_optention_diplome' => 'required',

                'fonctionnaire' => 'required',
                'secteur' => 'required',
                'nombreannee' => 'required',
                'poste' => 'required',
                'lieutravail' => 'required',
                'villetravail' => 'required',
                
               
                'path_photo' => 'nullable|file|mimes:jpeg,jpg,png|max:300',
                'path_cin'   => 'nullable|file|mimes:jpeg,jpg,png|max:300',
                'path_bac'   => 'nullable|file|mimes:jpeg,jpg,png|max:300',
                'path_licence' => 'nullable|file|mimes:jpeg,jpg,png|max:300',
                'path_attestation_non_emploi' => 'nullable|file|mimes:jpeg,jpg,png|max:300',
                'path_cv' => 'nullable|file|mimes:pdf|max:350',
                'filiere' => 'nullable',
                'filiere_choix_1' => 'nullable',
                'filiere_choix_2' => 'nullable',
                'filiere_choix_3' => 'nullable',
                'confirmation' => 'required',
            ];
        }
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
            'Anneebac.required' => 'L\'année du bac est obligatoire.',


            'dernier_diplome_obtenu.required' => 'Le diplôme est obligatoire.',
            'type_diplome_obtenu.required' => 'Le type du diplome est obligatoire.',
            'type_diplome_obtenu.min' => 'Le type du diplome doit contenir au moins 2 caractères.',
            'type_diplome_obtenu.max' => 'Le type du diplome ne doit pas dépasser 200 caractères.',
            'specialitediplome.required' => 'La spécialité du diplome est obligatoire.',
            'specialitediplome.min' => 'La spécialité du diplome doit contenir au moins 2 caractères.',
            'specialitediplome.max' => 'La spécialité du diplome ne doit pas dépasser 200 caractères.',
            'ville_etablissement_diplome.required' => 'Le type du diplome est obligatoire.',
            'ville_etablissement_diplome.min' => 'La ville ou tu as eu votre diplome doit contenir au moins 2 caractères.',
            'ville_etablissement_diplome.max' => 'La ville ou tu as eu votre diplome ne doit pas dépasser 150 caractères.',

           
            'date_optention_diplome.required' => "La date d'obtention du diplome est obligatoire.",
    

            'fonctionnaire.required' => 'Veuillez indiquer si vous êtes fonctionnaire.',
            'secteur.required' => 'Veuillez indiquer le secteur',
            'nombreannee.required' => "Veuillez indiquer les nombres d'années d'expériences",
            'poste.required' => "Veuillez indiquer le poste",
            'lieutravail.required' => "Veuillez indiquer le lieu de travail",
            'villetravail.required' => "Veuillez indiquer la ville de travail",


            'path_photo.file' => 'Le fichier photo doit être un fichier valide.',
            'path_photo.mimes' => 'Le fichier photo doit être au format JPEG ou PNG.',
            'path_photo.max' => 'Le fichier photo ne doit pas dépasser 300 Ko.',

            'path_cin.file' => 'Le fichier CIN doit être un fichier valide.',
            'path_cin.mimes' => 'Le fichier CIN doit être au format JPEG ou PNG.',
            'path_cin.max' => 'Le fichier CIN ne doit pas dépasser 300 Ko.',

            'path_bac.file' => 'Le fichier bac doit être un fichier valide.',
            'path_bac.mimes' => 'Le fichier bac doit être au format JPEG ou PNG.',
            'path_bac.max' => 'Le fichier bac ne doit pas dépasser 300 Ko.',

            'path_licence.file' => 'Le fichier licence doit être un fichier valide.',
            'path_licence.mimes' => 'Le fichier licence doit être au format JPEG ou PNG.',
            'path_licence.max' => 'Le fichier licence ne doit pas dépasser 300 Ko.',


            'path_attestation_non_emploi.file' => 'Le fichier de non emploi doit être un fichier valide.',
            'path_attestation_non_emploi.mimes' => 'Le fichier de non emploi doit être au format JPEG ou PNG.',
            'path_attestation_non_emploi.max' => 'Le fichier de non emploi ne doit pas dépasser 300 Ko.',

            
            'path_cv.file' => 'Le fichier CV doit être un fichier valide.',
            'path_cv.mimes' => 'Le fichier CV doit être au format PDF.',
            'path_cv.max' => 'Le fichier CV ne doit pas dépasser 350 Ko.',


            'confirmation.required' => 'La confirmation est obligatoire.',
        ];
    }


}
