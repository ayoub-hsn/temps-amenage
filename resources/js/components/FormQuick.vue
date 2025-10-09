<template>
    <div>
        <!-- Loader -->
        <div class="loading-overlay" v-if="loading">
            <div class="particles"></div>
            <div class="loader-logo-container">
            <div class="loader-glow"></div>
            <img src="/form/images/uh1-vertical.png" alt="Université Hassan 1er" class="loader-logo" />
            </div>
            <div class="spinner"></div>
            <p class="loading-text">Veuillez patienter...</p>
        </div>

        <div class="container py-5 form-container">
            <!-- 1. Formulaire Informations personnelles -->
            <div class="mb-5">
            <h2 class="text-center mb-4">Informations personnelles</h2>
            <form @submit.prevent="submitForm">
                <div class="row g-3">
                    <div class="col-md-6 mb-3" v-for="(field, key) in personalFields" :key="key">
                        <label :for="key" class="form-label fw-bold">{{ field.label }}</label>

                        <!-- If field is select -->
                        <select v-if="field.type === 'select'"
                                :id="key"
                                v-model="form[key]"
                                class="form-control form-control-lg"
                                required
                                @change="onInput(key)">
                            <option value="">-- Sélectionnez --</option>
                            <option v-for="opt in field.options" :key="opt" :value="opt">{{ opt }}</option>
                        </select>

                        <!-- If field is input -->
                        <input v-else
                                :id="key"
                                v-model="form[key]"
                                :type="field.type"
                                class="form-control form-control-lg"
                                required
                                @input="onInput(key)" />

                        <div v-if="errors[key]" class="text-danger mt-1">{{ errors[key] }}</div>
                    </div>
                </div>
            </form>
            </div>

            <!-- 2. Liste des établissements -->
            <div class="mb-5">
                <h2 class="text-center mb-4">Choisissez l’établissement dans lequel vous voulez effectuer la formation</h2>
                <div>
                    <select
                        v-model="form.etablissement_id"
                        class="form-select form-select-lg"
                        @change="onEtablissementChange"
                    >
                        <option value="" selected disabled>-- Sélectionnez un établissement --</option>
                        <option
                            v-for="etab in etablissements"
                            :key="etab.id"
                            :value="etab.id"
                            :disabled="!hasFilieres(etab)"
                        >
                            {{ etab.nom_abrev }} - {{ etab.nom }}
                        </option>
                    </select>


                    <div v-if="errors.etablissement_id" class="text-danger mt-2 text-center">
                        {{ errors.etablissement_id }}
                    </div>
                </div>
            </div>


            <!-- 3. Choix du programme -->
            <div class="mb-5">
                    <h2 class="mb-4">Choisissez un programme</h2>
                    <div>
                        <select
                    v-model="selectedProgramme"
                    class="form-select form-select-lg"
                    @change="onProgrammeChange"
                    :disabled="!selectedEtablissement"
                >
                    <option value="">-- Sélectionnez un programme --</option>
                    <option
                        value="master"
                        :disabled="!selectedEtablissement || selectedEtablissement.filiere_master.length === 0"
                    >
                        🎓 Master
                    </option>
                    <option
                        value="licence"
                        :disabled="!selectedEtablissement || selectedEtablissement.filiere_licence.length === 0"
                    >
                        📘 Licence
                    </option>
                </select>
                    <div v-if="errors.selectedProgramme" class="text-danger mt-2 text-center">
                        {{ errors.selectedProgramme }}
                    </div>
                    </div>
            </div>


            <!-- 4. Liste des filières du programme choisi -->
            <div v-if="selectedProgramme && selectedEtablissement" class="mb-5">
                <h2 class="text-center mb-4">Choisissez votre filière</h2>
                <select
                    v-model="form.filiere_id"
                    class="form-select form-select-lg"
                >
                    <option value="">-- Sélectionnez une filière --</option>
                    <option
                        v-for="f in filteredFilieres"
                        :key="f.id"
                        :value="f.id"
                    >
                        {{ f.nom_complet }}
                    </option>
                </select>
                <div v-if="errors.filiere_id" class="text-danger mt-2 text-center">
                    {{ errors.filiere_id }}
                </div>
            </div>


            <!-- 5. Bouton envoyer -->
            <div class="text-center mt-4">
            <button
                class="btn btn-submit btn-lg"
                @click="submitForm"
                :disabled="loading"
                :title="submitTooltip"
            >
                🚀 Envoyer ma préinscription
            </button>
            </div>
        </div>

        <!-- Modal success -->
        <div v-if="modal.show" class="modal">
            <div class="modal-content">

                <!-- Close button -->
                <button class="modal-close" @click="modal.show = false">✖</button>

                <div class="success-container">
                <div class="success-card">

                    <!-- Logo -->
                    <div class="modern-logo-box">
                    <img src="/form/images/uh1-vertical.png" alt="University Logo" class="modern-logo" />
                    </div>

                    <!-- Success Icon -->
                    <div class="success-icon">
                    <svg viewBox="0 0 24 24" width="100" height="100" class="glow">
                        <circle cx="12" cy="12" r="10" stroke="#d4af37" stroke-width="4" fill="none" />
                        <path d="M7 12l3 3 6-6" stroke="#d4af37" stroke-width="4" fill="none" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    </div>

                    <!-- Success Message -->
                    <h2 class="success-title">🎉 Félicitations !</h2>
                    <p class="success-text">
                    Votre inscription est <strong>validée</strong> et sera traitée par notre équipe.
                    </p>

                    <!-- Account Info -->
                    <div class="success-info text-dark p-3 rounded bg-light border">
                    <p v-if="etudiant.exists === false">
                        <strong>Votre compte étudiant a été créé avec succès.</strong>
                    </p>
                    <p v-else>
                        <strong>Vous avez déjà un compte existant.</strong>
                    </p>

                    <p v-if="etudiant.exists === false">Veuillez vous connecter à votre espace personnel pour :</p>
                    <p v-else>Vous pouvez utiliser votre compte pour vous connecter.</p>

                    <ul v-if="etudiant.exists === false">
                        <li><strong>Modifier</strong> votre candidature si nécessaire,</li>
                        <li><strong>Confirmer</strong> définitivement votre candidature,</li>
                        <li>et <strong>télécharger le reçu</strong> de votre préinscription.</li>
                    </ul>
                    </div>

                    <!-- User Credentials (only if new account) -->
                    <div class="success-credentials" v-if="etudiant.exists === false">
                    <p><strong>Email :</strong> <span>{{ etudiant.email }}</span></p>
                    <p>
                        <strong>Mot de passe :</strong>
                        <span class="password-box" :class="{ 'blurred': !showPassword }">
                        <span v-if="showPassword">{{ etudiant.CIN }}@2025</span>
                        <span v-else>********************************</span>
                        </span>
                        <button class="toggle-password" @click.prevent="togglePassword" @mouseenter="showTooltip = true" @mouseleave="showTooltip = false">
                        <span v-if="showPassword">👁️‍🗨️</span>
                        <span v-else>🔒</span>
                        </button>
                        <span v-if="showTooltip" class="password-tooltip">
                        <span v-if="showPassword">Cliquez pour masquer le mot de passe</span>
                        <span v-else>Cliquez pour afficher le mot de passe</span>
                        </span>
                    </p>
                    </div>

                    <!-- Login Button -->
                    <a href="/login" class="modern-button">Se connecter</a>

                </div>
                </div>
            </div>
        </div>


    </div>
  </template>

<script>
  import axios from 'axios';
  export default {
    props: {
      appurl: String,
      etablissements: Array,
    },
    data() {
      return {
        selectedEtablissement: null,
        selectedProgramme: null,
        loading: false,
        form: {
          etablissement_id: "",
          filiere_id: "",
          CIN: "",
          nom: "",
          prenom: "",
          email: "",
          phone: "",
          dernier_diplome_obtenu: "",
          type_diplome_obtenu: "",
          specialitediplome: "",
          ville_etablissement_diplome: "",
        },
        etudiant: {
            email: "",
            CIN: ""
        },
        personalFields: {
            CIN: { label: "CIN", type: "text" },
            nom: { label: "Nom", type: "text" },
            prenom: { label: "Prénom", type: "text" },
            email: { label: "Email", type: "email" },
            phone: { label: "Téléphone", type: "tel" },
            dernier_diplome_obtenu: {
                label: "Dernier diplôme obtenu",
                type: "select",
                options: ["BAC+2", "BAC+3", "BAC+4", "BAC+5"] // will be set dynamically
            },
            type_diplome_obtenu: { label: "Type du diplôme", type: "select", options: ["PUBLIC","PRIVEE","ETRANGER"] },
            specialitediplome: { label: "Spécialité du diplôme", type: "text" },
            ville_etablissement_diplome: { label: "Etablissement du diplôme", type: "text" },
        },
        errors: {
          CNE: null,
          CIN: null,
          nom: null,
          prenom: null,
          email: null,
          phone: null,
          dernier_diplome_obtenu: null,
          type_diplome_obtenu: null,
          specialitediplome: null,
          ville_etablissement_diplome: null,
          date_optention_diplome: null,
          filiere_id: null,
          etablissement_id: null,
          selectedProgramme:null,
        },
        currentField: null,
        modal: {
            show: false
        },
        showPassword: false,
        showTooltip: false
      };
    },
    computed: {
      filteredFilieres() {
        if (!this.selectedEtablissement || !this.selectedProgramme) return [];
        return this.selectedProgramme === "master"
          ? this.selectedEtablissement.filiere_master
          : this.selectedEtablissement.filiere_licence;
      },
      arePersonalInfosFilled() {
        return Object.keys(this.personalFields).every(
          (key) => this.form[key] && this.form[key].toString().trim() !== ""
        );
      },
      canSubmit() {
        return (
          this.arePersonalInfosFilled &&
          this.selectedEtablissement &&
          this.selectedProgramme &&
          this.form.filiere_id !== ""
        );
      },
      submitTooltip() {
        if (!this.arePersonalInfosFilled) return "Veuillez remplir toutes les informations personnelles.";
        if (!this.selectedEtablissement) return "Veuillez choisir un établissement.";
        if (!this.selectedProgramme) return "Veuillez choisir un programme.";
        if (!this.form.filiere_id) return "Veuillez sélectionner une filière.";
        return "Cliquez pour envoyer votre préinscription.";
      },
    },
    watch: {
        selectedProgramme(newValue) {
            if (!newValue) return;

            if (newValue.toLowerCase().includes("master")) {
            this.personalFields.dernier_diplome_obtenu.options = ["BAC+3", "BAC+4", "BAC+5"];
            } else if (newValue.toLowerCase().includes("licence")) {
            this.personalFields.dernier_diplome_obtenu.options = ["BAC+2", "BAC+3", "BAC+4", "BAC+5"];
            } else {
            this.personalFields.dernier_diplome_obtenu.options = [];
            }
        }
    },
    methods: {
        onEtablissementChange() {
            // Met à jour selectedEtablissement
            this.selectedEtablissement = this.etablissements.find(
                e => e.id == this.form.etablissement_id
            ) || null;

            // Réinitialiser programme et filière
            this.selectedProgramme = "";
            this.form.filiere_id = "";
            this.errors.filiere_id = null;
        },
        hasFilieres(etab) {
            return (etab.filiere_master && etab.filiere_master.length > 0) ||
                (etab.filiere_licence && etab.filiere_licence.length > 0);
        },
        onProgrammeChange() {
            // Réinitialiser filière
            this.form.filiere_id = "";
            this.errors.filiere_id = null;
        },
        filteredFilieres() {
            if (!this.selectedEtablissement || !this.selectedProgramme) return [];
            return this.selectedProgramme === "master"
                ? this.selectedEtablissement.filiere_master
                : this.selectedEtablissement.filiere_licence;
        },
        selectEtablissement(etab) {
            this.selectedEtablissement = etab;
            this.selectedProgramme = null;
            this.form.filiere_id = "";
            this.errors.filiere_id = null;
        },

        onInput(field) {
            this.currentField = field;
            this.validateStep(field);
        },
        validateStep(field) {
            switch (field) {

            case "CIN":
                if (!this.form.CIN) {
                this.errors.CIN = "Le CIN est requis.";
                } else if (!/^[A-Za-z0-9]{3,10}$/.test(this.form.CIN)) {
                this.errors.CIN = "Le CIN doit contenir entre 3 et 10 caractères alphanumériques.";
                } else {
                this.errors.CIN = null;
                }
                break;

            case "nom":
                if (!this.form.nom) {
                this.errors.nom = "Le nom est requis.";
                } else if (/[^A-Za-zÀ-ÿ0-9\s\-'.]/.test(this.form.nom)) {
                this.errors.nom = "Le nom doit être écrit uniquement en français.";
                } else if (this.form.nom.length < 2 || this.form.nom.length > 50) {
                this.errors.nom = "Le nom doit contenir entre 2 et 50 caractères.";
                } else {
                this.errors.nom = null;
                }
                break;

            case "prenom":
                if (!this.form.prenom) {
                this.errors.prenom = "Le prénom est requis.";
                } else if (/[^A-Za-zÀ-ÿ0-9\s\-'.]/.test(this.form.prenom)) {
                this.errors.prenom = "Le prénom doit être écrit uniquement en français.";
                } else if (this.form.prenom.length < 2 || this.form.prenom.length > 50) {
                this.errors.prenom = "Le prénom doit contenir entre 2 et 50 caractères.";
                } else {
                this.errors.prenom = null;
                }
                break;

            case "email":
                if (!this.form.email) {
                this.errors.email = "L'email est requis.";
                } else if (!/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,100}$/.test(this.form.email)) {
                this.errors.email = "Veuillez saisir une adresse email valide.";
                } else {
                this.errors.email = null;
                }
                break;

            case "phone":
                if (!this.form.phone) {
                this.errors.phone = "Le téléphone est requis.";
                } else if (!/^\d{10}$/.test(this.form.phone)) {
                this.errors.phone = "Le téléphone doit contenir exactement 10 chiffres.";
                } else {
                this.errors.phone = null;
                }
                break;

            case "dernier_diplome_obtenu":
                if (!this.form.dernier_diplome_obtenu) {
                this.errors.dernier_diplome_obtenu = "Ce champ est requis.";
                }else if (this.form.dernier_diplome_obtenu < 2 || this.form.dernier_diplome_obtenu > 150) {
                this.errors.dernier_diplome_obtenu = "Ce champs doit contenir entre 2 et 150 caractères.";
                } else {
                this.errors.dernier_diplome_obtenu = null;
                }
                break;

            case "type_diplome_obtenu":
                if (!this.form.type_diplome_obtenu) {
                this.errors.type_diplome_obtenu = "Ce champ est requis.";
                }else if (this.form.type_diplome_obtenu < 2 || this.form.type_diplome_obtenu > 150) {
                this.errors.type_diplome_obtenu = "Ce champs doit contenir entre 2 et 150 caractères.";
                } else {
                this.errors.type_diplome_obtenu = null;
                }
                break;

            case "specialitediplome":
                if (!this.form.specialitediplome) {
                this.errors.specialitediplome = "Ce champ est requis.";
                }else if (this.form.specialitediplome < 2 || this.form.specialitediplome > 150) {
                this.errors.specialitediplome = "Ce champs doit contenir entre 2 et 150 caractères.";
                } else {
                this.errors.specialitediplome = null;
                }
                break;

            case "ville_etablissement_diplome":
                if (!this.form.ville_etablissement_diplome) {
                this.errors.ville_etablissement_diplome = "Ce champ est requis.";
                }else if (this.form.ville_etablissement_diplome < 2 || this.form.ville_etablissement_diplome > 150) {
                this.errors.ville_etablissement_diplome = "Ce champs doit contenir entre 2 et 150 caractères.";
                } else {
                this.errors.ville_etablissement_diplome = null;
                }
                break;

            case "filiere_id":
                if (!this.form.filiere_id) {
                this.errors.filiere_id = "Veuillez sélectionner une filière.";
                } else {
                this.errors.filiere_id = null;
                }
                break;

            case "etablissement_id":
                if (!this.form.etablissement_id) {
                this.errors.etablissement_id = "Veuillez sélectionner un établissement.";
                } else {
                this.errors.etablissement_id = null;
                }
            break;

            case "selectedProgramme":
                if (!this.selectedProgramme) {
                this.errors.selectedProgramme = "Veuillez sélectionner un programme.";
                } else {
                this.errors.selectedProgramme = null;
                }
            break;

            default:
                break;
            }
        },
        validateAll() {
            // Valide tous les champs et met à jour errors
            Object.keys(this.errors).forEach((field) => this.validateStep(field));
            return Object.values(this.errors).every((err) => err === null);
        },
        togglePassword() {
                this.showPassword = !this.showPassword;
        },
        async submitForm() {
            if (!this.validateAll()) {
            const firstErrorField = Object.keys(this.errors).find(key => this.errors[key] !== null);
            if (firstErrorField) {
                this.currentField = firstErrorField;
                this.$nextTick(() => {
                const input = this.$el.querySelector(`#${firstErrorField}`);
                if (input) {
                    input.focus();
                    input.scrollIntoView({ behavior: "smooth", block: "center" });
                }
                });
            }
            //   alert("Veuillez corriger les erreurs avant de soumettre.");
            return;
            }

            this.loading = true;
            try {
                const payload = {
                    ...this.form,
                    etablissement_id: this.selectedEtablissement?.id || null,
                    programme: this.selectedProgramme,
                    filiere_id: this.form.filiere_id,  // assuming single filiere selection
                };

                // Send POST request to your Laravel route
                const response = await axios.post('api/submit/form/quick', payload);
                if (response.data.status === 1) {
                    // Mettre à jour les infos pour affichage dans la modale
                    this.etudiant = {
                        email: this.form.email,
                        CIN: this.form.CIN,
                        exists: response.data.user.exists
                    };
                    this.modal.show = true;
                } else {
                    alert(`⚠️ ${response.data.message}`);
                }

                this.resetForm();
            } catch (error) {
            alert("❌ Une erreur est survenue lors de l'envoi.");
            console.error(error);
            } finally {
            this.loading = false;
            }
        },
        resetForm() {
            this.selectedEtablissement = null;
            this.selectedProgramme = null;
            for (const key in this.form) {
            this.form[key] = "";
            }
            for (const key in this.errors) {
            this.errors[key] = null;
            }
            this.currentField = null;
        },
    },
  };
  </script>



<style scoped>
  /* Ajoute ici tes styles ou utilise ceux que tu as déjà */
        .form-container {
        background: linear-gradient(135deg, #f4f9ff, #d9e8ff);
        border-radius: 16px;
        padding: 40px 30px 50px;
        max-width: 900px;
        margin: 40px auto;
        box-shadow: 0 12px 40px rgba(0, 75, 135, 0.2);
        font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
        color: #002b5b;
        }

        /* Titre */
        h2 {
        font-weight: 900;
        font-size: 2.4rem;
        color: #004b87;
        text-align: center;
        margin-bottom: 2rem;
        text-shadow: 1px 1px 3px #a0c8ff;
        }

        /* Formulaire personnel */
        .personal-info-form {
        margin-bottom: 50px;
        }

        .personal-info-form .form-control {
        border-radius: 12px;
        border: 2px solid #d3d8e0;
        padding: 12px 15px;
        font-size: 1.1rem;
        transition: border-color 0.3s ease;
        margin-bottom: 1.2rem;
        }

        .personal-info-form .form-control:focus {
        border-color: #004b87;
        outline: none;
        box-shadow: 0 0 8px #004b87cc;
        }

        /* Liste établissements */
        .etablissements-container {
        display: flex;
        flex-wrap: wrap;
        gap: 24px;
        justify-content: center;
        margin-bottom: 40px;
        }

        .etab-card {
        border-radius: 18px;
        transition: all 0.4s ease;
        cursor: pointer;
        border: 2px solid transparent;
        box-shadow: 0 8px 25px rgba(0, 75, 135, 0.12);
        background: white;
        user-select: none;
        display: flex;
        flex-direction: column;
        justify-content: center;
        height: 250px;
        width: 260px;
        text-align: center;
        }

        .etab-card img {
        max-height: 130px;
        object-fit: contain;
        margin-bottom: 1rem;
        transition: transform 0.35s ease;
        padding: 0 20px;
        }

        .etab-card:hover:not(.disabled) {
        transform: translateY(-8px);
        box-shadow: 0 14px 35px rgba(0, 75, 135, 0.4);
        }

        .etab-card.selected {
        border-color: #004b87;
        box-shadow: 0 0 25px #004b87cc;
        transform: translateY(-10px);
        }

        .etab-card.disabled {
        opacity: 0.5;
        cursor: not-allowed !important;
        pointer-events: none;
        filter: grayscale(60%);
        }

        /* Programmes */
        .programme-buttons {
        display: flex;
        justify-content: center;
        gap: 30px;
        margin-bottom: 40px;
        }

        .btn-programme {
        flex: 1;
        max-width: 180px;
        padding: 18px 24px;
        font-weight: 700;
        border: none;
        color: white;
        border-radius: 14px;
        cursor: pointer;
        box-shadow: 0 7px 20px rgba(0, 0, 0, 0.12);
        font-size: 1.3rem;
        text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.2);
        transition: transform 0.25s, background 0.35s;
        text-align: center;
        }

        .btn-programme:hover:not(:disabled) {
        transform: translateY(-5px);
        box-shadow: 0 12px 25px rgba(0, 75, 135, 0.5);
        }

        .btn-programme.master {
        background: #004b87;
        }

        .btn-programme.licence {
        background: #198754;
        }

        .btn-programme:disabled {
        background: #a5a5a5;
        cursor: not-allowed;
        box-shadow: none;
        }

        /* Liste filières */
        .filieres-container {
        display: flex;
        flex-wrap: wrap;
        gap: 18px;
        justify-content: center;
        margin-bottom: 40px;
        }

        .filieres-card {
        position: relative;
        flex: 1 1 calc(33.333% - 18px);
        background: white;
        border: 2px solid #d3d8e0;
        border-radius: 14px;
        padding: 25px 20px;
        cursor: pointer;
        transition: all 0.35s ease;
        font-weight: 700;
        font-size: 1.1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        min-height: 120px;
        user-select: none;
        }

        .filieres-card input {
        transform: scale(1.3);
        cursor: pointer;
        margin-right: 12px;
        flex-shrink: 0;
        }

        .filieres-card:hover {
        background: #e6f0ff;
        border-color: #004b87;
        box-shadow: 0 8px 22px rgba(0, 75, 135, 0.2);
        }

        .filieres-card.selected {
        border-color: #004b87;
        box-shadow: 0 0 30px #004b87cc;
        background: #d7e4ff;
        }

        /* Checkmark */
        .selected-checkmark {
        position: absolute;
        top: 12px;
        right: 12px;
        background-color: #004b87;
        color: white;
        font-weight: 900;
        font-size: 1.4rem;
        width: 28px;
        height: 28px;
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        box-shadow: 0 0 8px #004b87cc;
        user-select: none;
        pointer-events: none;
        transition: transform 0.3s ease;
        }

        .filieres-card.selected .selected-checkmark {
        animation: pulse 1.2s infinite alternate;
        }

        @keyframes pulse {
        0% {
            transform: scale(1);
        }
        100% {
            transform: scale(1.15);
        }
        }

        /* Bouton submit */
        .btn-submit {
        background: #f1a300;
        color: white;
        font-weight: 700;
        padding: 18px 36px;
        border-radius: 14px;
        border: none;
        cursor: pointer;
        box-shadow: 0 10px 25px #f1a300bb;
        font-size: 1.5rem;
        text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.15);
        transition: box-shadow 0.3s ease;
        user-select: none;
        }

        .btn-submit:hover {
        box-shadow: 0 14px 35px #f1a300ee;
        }

        /* Messages d'erreur */
        .text-danger {
        font-weight: 700;
        font-size: 1rem;
        margin-top: 10px;
        color: #d9534f;
        text-align: center;
        }

        /* Responsive */
        @media (max-width: 768px) {
        .filieres-card {
            flex: 1 1 calc(50% - 18px);
        }
        .btn-programme {
            max-width: 140px;
            font-size: 1.1rem;
            padding: 14px 18px;
        }
        .etab-card {
            width: 45%;
        }
        }

        @media (max-width: 480px) {
        .filieres-card {
            flex: 1 1 100%;
        }
        h2 {
            font-size: 1.8rem;
        }
        .btn-programme {
            max-width: 100%;
            font-size: 1rem;
            padding: 12px 18px;
        }
        .etab-card {
            width: 100%;
        }
        }
        .custom-select {
            width: 100%;
            padding: 14px 18px;
            font-size: 1.1rem;
            border: 2px solid #004B87; /* Bleu branding */
            border-radius: 8px;
            background-color: #fff;
            color: #333;
            outline: none;
            box-shadow: 0 3px 8px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
            appearance: none; /* cache la flèche par défaut */
            background-image: url("data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D'http%3A//www.w3.org/2000/svg'%20viewBox%3D'0%200%204%205'%3E%3Cpath%20fill%3D'%23004B87'%20d%3D'M2%200L0%202h4zm0%205L0%203h4z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 12px center;
            background-size: 12px;
        }

        .custom-select:hover {
            border-color: #F1A300; /* Or accent */
            box-shadow: 0 4px 10px rgba(241,163,0,0.2);
        }

        .custom-select:focus {
            border-color: #F1A300;
            box-shadow: 0 0 0 3px rgba(241,163,0,0.25);
        }

       /* loader  */
            .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.85);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            color: #fff;
            font-size: 18px;
            z-index: 9999;
            overflow: hidden;
            }

            /* Effet lumineux derrière le logo */
            .loader-logo-container {
            position: relative;
            background: linear-gradient(135deg, rgba(0, 123, 255, 0.4), rgba(0, 0, 0, 0.6)); /* Gradient for a modern feel */
            padding: 20px;
            border-radius: 15px; /* Rounded corners */
            box-shadow: 0 0 30px rgba(0, 123, 255, 0.6); /* Soft glow around the container */
            animation: logoGlow 3s infinite alternate ease-in-out;
            }

            /* Pulse animation for the logo container */
            @keyframes logoGlow {
            0% { box-shadow: 0 0 30px rgba(0, 123, 255, 0.6); }
            100% { box-shadow: 0 0 50px rgba(0, 123, 255, 1); }
            }

            .loader-logo {
            width: 150px;
            height: auto;
            filter: drop-shadow(0 0 15px rgba(0, 123, 255, 0.8));
            animation: pulse 2s infinite alternate ease-in-out;
            }

            /* Effet de pulsation du logo */
            @keyframes pulse {
            0% {
                transform: scale(1);
                filter: drop-shadow(0 0 10px rgba(0, 123, 255, 0.6));
            }
            100% {
                transform: scale(1.05);
                filter: drop-shadow(0 0 20px rgba(0, 123, 255, 1));
            }
            }

            /* Vague lumineuse en arrière-plan */
            .loader-glow {
            position: absolute;
            top: 50%;
            left: 50%;
            width: 200px;
            height: 200px;
            background: radial-gradient(circle, rgba(0, 123, 255, 0.4) 10%, transparent 60%);
            border-radius: 50%;
            transform: translate(-50%, -50%);
            animation: glowwave 2.5s infinite alternate ease-in-out;
            filter: blur(20px);
            }

            @keyframes glowwave {
            0% { transform: translate(-50%, -50%) scale(1); opacity: 0.8; }
            100% { transform: translate(-50%, -50%) scale(1.3); opacity: 0.5; }
            }

            /* Spinner fluide */
            .spinner {
            width: 60px;
            height: 60px;
            border: 4px solid rgba(255, 255, 255, 0.2);
            border-top: 4px solid #007bff;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin-top: 20px;
            }

            @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
            }

            /* Texte statique et élégant */
            .loading-text {
            font-size: 20px;
            font-weight: bold;
            margin-top: 15px;
            color: rgba(255, 255, 255, 0.8);
            text-shadow: 0 0 10px rgba(0, 123, 255, 0.6);
            letter-spacing: 1px;
            }

            /* Particules dynamiques pour l'effet magique */
            .particles {
            position: absolute;
            width: 100%;
            height: 100%;
            pointer-events: none;
            background: radial-gradient(circle, rgba(0, 123, 255, 0.2) 10%, transparent 70%);
            animation: floating 3s infinite ease-in-out alternate;
            }

            @keyframes floating {
            0% { transform: translateY(0); opacity: 0.7; }
            100% { transform: translateY(-20px); opacity: 1; }
            }

        /* Styles du modal et success card */
        .modal {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0,0,0,0.6);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 999;
}

.modal-content {
  background: white;
  width: 80%; /* wider modal */
  max-width: 900px; /* prevent it from being too big */
  max-height: 90vh; /* not full page height */
  overflow-y: auto; /* scroll if content is tall */
  border-radius: 12px;
  padding: 20px;
  position: relative;
}

.modal-close {
  position: absolute;
  top: 10px;
  right: 15px;
  background: none;
  border: none;
  font-size: 22px;
  cursor: pointer;
  color: #333;
}

.success-container {
  padding: 20px;
}

</style>
