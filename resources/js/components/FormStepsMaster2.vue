<template>
	<section class="register" v-if="!hasSeenCongrats">
		<div class="register-icon">
			<img class="register-icon-item" src="/form/images/uh1-vertical.png" alt="vue logo">

		</div>

		<h2 class="register-title">Faire votre préinscription</h2>

		<div class="register-stepper">
			<div class="step" :class="{'step-active': step === 1, 'step-done': step > 1}">
				<span class="step-number" :class="{'step-active': step === 1, 'step-done': step > 1}">1</span>
				<span class="step-name" :class="{'step-active': step === 1, 'step-done': step > 1}">IDENTITE</span>
			</div>
			<div class="step" :class="{'step-active': step === 2, 'step-done': step > 2}">
				<span class="step-number" :class="{'step-active': step === 2, 'step-done': step > 2}">2</span>
				<span class="step-name" :class="{'step-active': step === 2, 'step-done': step > 2}">INFORMATIONS ACADEMIQUES</span>
			</div>
			<div class="step" :class="{'step-active': step === 3, 'step-done': step > 3}">
				<span class="step-number" :class="{'step-active': step === 3, 'step-done': step > 3}">3</span>
				<span class="step-name" :class="{'step-active': step === 3, 'step-done': step > 3}">DOCUMENT</span>
			</div>
			<div class="step" :class="{'step-active': step === 4, 'step-done': step > 4}">
				<span class="step-number" :class="{'step-active': step === 4, 'step-done': step > 4}">4</span>
				<span class="step-name" :class="{'step-active': step === 4, 'step-done': step > 4}">CHOIX DE FILIERE</span>
			</div>
			<div class="step" :class="{'step-active': step === 5, 'step-done': step > 5}">
				<span class="step-number" :class="{'step-active': step === 5, 'step-done': step > 5}">5</span>
				<span class="step-name" :class="{'step-active': step === 5, 'step-done': step > 5}">CONFIRMATION</span>
			</div>
		</div>




<transition name="slide-fade">
    <section v-show="step === 1">
                <h1 style="text-align: center;">IDENTITE</h1>
				<form class="form" method="post" action="#" @submit.prevent="next">
					<div class="form-group">
						<input type="text" v-model="etudiant.CNE" autocomplete='etudiant.CNE' placeholder="CNE" disabled />
						<input type="text" v-model="etudiant.CIN" autocomplete='etudiant.CNE' placeholder="CIN" disabled />
					</div>
					<div class="form-group">
						<input 
							type="text" 
							v-model="etudiant.nom" 
							autocomplete="etudiant.nom" 
							class="form-control" 
							:class="v$.etudiant.nom.$error ? 'is-invalid' : ''" 
							placeholder="Nom"  
						/>
						<span 
							class="text-danger error-message" 
							v-if="v$.etudiant.nom.$error"
						>
							{{ v$.etudiant.nom.$errors[0].$message }}
						</span>
					</div>

					<div class="form-group">
						<input type="text" v-model="etudiant.prenom" autocomplete='etudiant.prenom' class="form-control" :class="v$.etudiant.prenom.$error ? 'is-invalid' : ''" placeholder="Prenom"  />
						<span class="text-danger error-message" v-if="v$.etudiant.prenom.$error">
                            {{v$.etudiant.prenom.$errors[0].$message}}
                        </span>
					</div>
					<div class="form-group">
						<input type="text" v-model="etudiant.nomar" autocomplete='etudiant.nomar' class="form-control" :class="v$.etudiant.nomar.$error ? 'is-invalid' : ''" placeholder="الاسم العائلي"  />
						<span class="text-danger error-message" v-if="v$.etudiant.nomar.$error">
                            {{v$.etudiant.prenom.$errors[0].$message}}
                        </span>
					</div>
					<div class="form-group">
						<input type="text" v-model="etudiant.prenomar" autocomplete='etudiant.prenomar' class="form-control" :class="v$.etudiant.prenomar.$error ? 'is-invalid' : ''" placeholder="الاسم الشخصي"  />
						<span class="text-danger error-message" v-if="v$.etudiant.prenomar.$error">
                            {{v$.etudiant.prenomar.$errors[0].$message}}
                        </span>
					</div>
					

					<div class="form-group">
						<input type="date" v-model="etudiant.datenais" autocomplete="etudiant.datenais" class="form-control" :class="v$.etudiant.datenais.$error ? 'is-invalid' : ''" placeholder="DATE DE NAISSANCE"  />
						<span class="text-danger error-message" v-if="v$.etudiant.datenais.$error">
                            {{v$.etudiant.datenais.$errors[0].$message}}
                        </span>
					</div>

					<div class="form-group">
						<select name="sexe" v-model="etudiant.sexe"  :class="v$.etudiant.sexe.$error ? 'is-invalid' : ''">
							<option disabled value="">SEXE</option> 
							<option value="M"> M </option> 
							<option value="F"> F </option>  
						</select>
						<span class="text-danger error-message" v-if="v$.etudiant.sexe.$error">
                            {{v$.etudiant.sexe.$errors[0].$message}}
                        </span>
					</div>

					<div class="form-group">
						<input type="text" v-model="etudiant.prenom" autocomplete='etudiant.payschamp' class="form-control" :class="v$.etudiant.payschamp.$error ? 'is-invalid' : ''" placeholder="VOTRE PAYS"  />
						<span class="text-danger error-message" v-if="v$.etudiant.payschamp.$error">
                            {{v$.etudiant.payschamp.$errors[0].$message}}
                        </span>
					</div>

					<div class="form-group">
						<input type="text" v-model="etudiant.villenais" autocomplete='etudiant.villenais' class="form-control" :class="v$.etudiant.villenais.$error ? 'is-invalid' : ''" placeholder="VILLE DE NAISSANCE"  />
						<span class="text-danger error-message" v-if="v$.etudiant.villenais.$error">
                            {{v$.etudiant.villenais.$errors[0].$message}}
                        </span>
					</div>
					<div class="form-group">
						<input type="text" v-model="etudiant.villenais" autocomplete='etudiant.villechamp' class="form-control" :class="v$.etudiant.villechamp.$error ? 'is-invalid' : ''" placeholder="مكان الازدياد"  />
						<span class="text-danger error-message" v-if="v$.etudiant.villechamp.$error">
                            {{v$.etudiant.villechamp.$errors[0].$message}}
                        </span>
					</div>
					<div class="form-group">
						<textarea v-model="etudiant.adresse" autocomplete='etudiant.adresse' class="form-control" :class="v$.etudiant.adresse.$error ? 'is-invalid' : ''" placeholder="Adresse"></textarea>
						<!-- <input type="text" v-model="etudiant.email" autocomplete='etudiant.email' class="form-control" :class="v$.etudiant.email.$error ? 'is-invalid' : ''" placeholder="EMAIL"  /> -->
						<span class="text-danger error-message" v-if="v$.etudiant.adresse.$error">
                            {{v$.etudiant.adresse.$errors[0].$message}}
                        </span>
					</div>

					<div class="form-group">
						<input type="text" v-model="etudiant.email" autocomplete='etudiant.email' class="form-control" :class="v$.etudiant.email.$error ? 'is-invalid' : ''" placeholder="EMAIL"  />
						<span class="text-danger error-message" v-if="v$.etudiant.email.$error">
                            {{v$.etudiant.email.$errors[0].$message}}
                        </span>
					</div>

					<div class="form-group">
						<input type="tel" v-model="etudiant.phone" autocomplete="etudiant.phone" placeholder="TELEPHONE" />
						<span class="text-danger error-message" v-if="v$.etudiant.phone.$error">
                            {{v$.etudiant.phone.$errors[0].$message}}
                        </span>
					</div>
					<div class="form-group">
						<select name="sexe" v-model="etudiant.sexe"  :class="v$.etudiant.sexe.$error ? 'is-invalid' : ''">
							<option disabled value="">SEXE</option> 
							<option value="M"> M </option> 
							<option value="F"> F </option>  
						</select>
						<span class="text-danger error-message" v-if="v$.etudiant.sexe.$error">
                            {{v$.etudiant.sexe.$errors[0].$message}}
                        </span>
					</div>
					<div class="cta" data-style="see-through" data-alignment="right" data-text-color="custom">
						<p class="cta-color">
							<span class="link_wrap">
								<input type="submit" value="Next" class="link_text" />
								<span class="arrow-next"></span>
							</span>
						</p>
					</div>
				</form>
			</section>
		</transition>
		<transition name="slide-fade">
			<section v-show="step === 2">
                <h1 style="text-align: center;">INFORMATIONS ACADEMIQUES</h1>
				<form class="form" method="post" action="#" @submit.prevent="next">
					<div class="form-group">
						<input type="text" v-model="etudiant.address" autocomplete='etudiant.address' placeholder="Address" required />
					</div>
					<div class="form-group">
						<input type="text" v-model="etudiant.zipCode" autocomplete='etudiant.zipCode' placeholder="Zip Code" minlength="5" maxlength="5" required />
						<input type="text" v-model="etudiant.city" autocomplete='etudiant.city' placeholder="City" required />
					</div>

					<div class="form-group cta-step">
						<div class="cta prev">
							<p class="cta-color">
								<span class="link_wrap">
									<a class="link_text" href="#" @click.prevent="prev()"><span class="arrow-prev"></span>Previous
									</a>
								</span>
							</p>
						</div>
						<div class="cta">
							<p class="cta-color">
								<span class="text"></span>
								<span class="link_wrap">
									<input type="submit" value="Next" class="link_text" />
									<span class="arrow-next"></span>
								</span>
							</p>
						</div>
					</div>
				</form>
			</section>
		</transition>
        <transition name="slide-fade">
			<section v-show="step === 3">
                <h1 style="text-align: center;">DOCUMENT</h1>
				<form class="form" method="post" action="#" @submit.prevent="next">
					<div class="form-group">
						<input type="text" v-model="etudiant.address" autocomplete='etudiant.address' placeholder="Address" required />
					</div>
					<div class="form-group">
						<input type="text" v-model="etudiant.zipCode" autocomplete='etudiant.zipCode' placeholder="Zip Code" minlength="5" maxlength="5" required />
						<input type="text" v-model="etudiant.city" autocomplete='etudiant.city' placeholder="City" required />
					</div>

					<div class="form-group cta-step">
						<div class="cta prev">
							<p class="cta-color">
								<span class="link_wrap">
									<a class="link_text" href="#" @click.prevent="prev()"><span class="arrow-prev"></span>Previous
									</a>
								</span>
							</p>
						</div>
						<div class="cta">
							<p class="cta-color">
								<span class="text"></span>
								<span class="link_wrap">
									<input type="submit" value="Next" class="link_text" />
									<span class="arrow-next"></span>
								</span>
							</p>
						</div>
					</div>
				</form>
			</section>
		</transition>
        <transition name="slide-fade">
			<section v-show="step === 4">
                <h1 style="text-align: center;">CHOIX DE FILIERE</h1>
				<form class="form" method="post" action="#" @submit.prevent="next">
					<div class="form-group">
						<input type="text" v-model="etudiant.address" autocomplete='etudiant.address' placeholder="Address" required />
					</div>
					<div class="form-group">
						<input type="text" v-model="etudiant.zipCode" autocomplete='etudiant.zipCode' placeholder="Zip Code" minlength="5" maxlength="5" required />
						<input type="text" v-model="etudiant.city" autocomplete='etudiant.city' placeholder="City" required />
					</div>

					<div class="form-group cta-step">
						<div class="cta prev">
							<p class="cta-color">
								<span class="link_wrap">
									<a class="link_text" href="#" @click.prevent="prev()"><span class="arrow-prev"></span>Previous
									</a>
								</span>
							</p>
						</div>
						<div class="cta">
							<p class="cta-color">
								<span class="text"></span>
								<span class="link_wrap">
									<input type="submit" value="Next" class="link_text" />
									<span class="arrow-next"></span>
								</span>
							</p>
						</div>
					</div>
				</form>
			</section>
		</transition>
		<transition name="slide-fade">
			<section v-show="step === 5">
                <h1 style="text-align: center;">CONFIRMATION</h1>
				<form class="form" action="#" @submit.prevent="etudiantRegister">
					<div class="form-group">
						<input type="email" v-model="etudiant.eMail" autocomplete="etudiant.eMail" placeholder="Email" required />
					</div>
					<div class="form-group">
						<input type="date" v-model="etudiant.birthDay" placeholder="Birthday ('day'/'month'/'year')" required />
					</div>

					<div class="form-group cta-step">
						<div class="cta prev">
							<p class="cta-color">
								<span class="link_wrap">
									<a class="link_text" href="#" @click.prevent="prev()"><span class="arrow-prev"></span>Previous
									</a>
								</span>
							</p>
						</div>
					</div>
					<div class="register-btn">
					<input type="submit" value="Créer mon compte" />
						</div>
				</form>
			</section>
		</transition>
	</section>
	<section class="congrats register" v-if="hasSeenCongrats">
					<div class="register-icon">
			<img class="register-icon-item" src="https://vuejs.org/images/logo.png" alt="vue logo">

		</div>
        <h2 class="congrats-title">Thank you !</h2>
        <p class="congrats-subtitle">
            You have successfully created your account and joined the<br/>
            <strong>VueJS<br/>multiple steps form</strong>
        </p>
    </section>
  </template>

  <script>

  import { useVuelidate } from '@vuelidate/core'
  import { required,maxLength } from '@vuelidate/validators'
  export default {
	props: ['cne','cin','etablissement'],
    data() {
        return {
			v$: useVuelidate(),
            steps: {},
            step: 1,
            etudiant: {
				CNE: "",
        		CIN: "",
        		nom: "",
        		prenom: "",
        		nomar: "",
        		prenomar: "",
				datenais: "",
				sexe: "",
				payschamp: "",
				villenais: "",
				villechamp: "",
				adresse: "",
				email: "",
				phone: "",
				adresse: "",
			},

            hasSeenCongrats: false,
        };
    },
	validations(){
			return {
				etudiant: {
					CNE: { required },
					CIN: { required },
					nom: { required,maxLength:maxLength(30) },
					prenom: { required,maxLength:maxLength(30) },
					nomar: { required },
					prenomar: { required },
					datenais: { required },
					sexe: { required },
					payschamp: { required },
					villenais: { required },
					villechamp: { required },
					adresse: { required },
					email: { required },
					phone: { required },
			}
		}
	},
    methods: {
        prev() {
        this.step--;
        },

        next() {
		this.v$.$validate()
        if(this.v$.$error){
            return;
        }
        this.step++;
        },

        etudiantRegister: function () {
        this.hasSeenCongrats = true;
        }
    },
	mounted() {
		this.etudiant.CNE = this.cne
		this.etudiant.CIN = this.cin
		console.log(this.cne)
		console.log(this.cin)
		console.log(this.etablissement)
	},
  };
  </script>

  <style scoped>
  .form-group {
		position: relative !important;
		display: flex !important;
		flex-direction: column !important; /* Stack elements vertically */
	}

	.error-message {
		display: block !important; /* Ensure it behaves as a block element */
		margin-top: -3px !important; /* Add spacing between input and error message */
		font-size: 0.9em !important; /* Adjust font size if needed */
		color: red !important; /* Keep the error text color */
	}
  </style>
