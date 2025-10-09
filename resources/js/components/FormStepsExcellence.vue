<template>
	<div class="loading-overlay" v-if="loading">
		<div class="particles"></div> <!-- Effet magique -->
		<div class="loader-logo-container">
			<div class="loader-glow"></div> <!-- Vague lumineuse -->
			<img src="/form/images/uh1-vertical.png" alt="Université Hassan 1er" class="loader-logo">
		</div>
		<div class="spinner"></div>
		<p class="loading-text">Veuillez patienter...</p> <!-- Texte fixe -->
	</div>


	<div class="form-container" v-if="!successForm">
	  <!-- Progress Bar -->
	  <div class="progress-bar-container">
		<div class="progress-bar" :style="{ width: (currentStep / steps.length) * 100 + '%' }"></div>
	  </div>

	  <!-- Header with Logo -->
	  <div class="form-header">
		<div class="logo-container">
		  <img src="/form/images/uh1-vertical.png" alt="University Logo" class="form-logo" />
		</div>
		<h1 class="form-title">Préinscription Universitaire</h1>
		<p class="form-subtitle">Remplissez les étapes ci-dessous pour finaliser votre inscription</p>
	  </div>

	  <!-- Progress Steps -->
	    <div class="progress-steps">
			<div
				v-for="(step, index) in steps"
				:key="index"
				class="step"
				:class="{ completed: currentStep > index + 1, active: currentStep === index + 1 }"
				@click="goToStep(index + 1)"
				title="Click to navigate to step {{ index + 1 }}"
			>
				<div class="step-circle">
					<span class="step-icon">{{ index + 1 }}</span>
				</div>
				<div class="step-label">
					<span class="step-line" v-for="line in step.title.split('\n')" :key="line">
						{{ line }}
					</span>
					<!-- Progress percentage displayed on hover -->
					<span class="progress-tooltip" v-if="currentStep === index + 1">
						{{ Math.round(((index + 1) / steps.length) * 100) }}%
					</span>
				</div>
			</div>
		</div>






	  <!-- Form Section -->
	  <div class="form-body">
		<h2 class="section-title" style="text-align: center;">Étape {{ currentStep }} : {{ steps[currentStep - 1].title }}</h2>

		<form @submit.prevent="nextStep" enctype="multipart/form-data">
			<input type="hidden" v-model="etudiant.etablissement_id">
		  <div v-if="currentStep === 1">
				<div class="form-group" dir="ltr">
					<label for="CNE" >CNE</label>
					<input
						type="text"
						id="CNE"
						v-model="etudiant.CNE"
						placeholder="Entrez votre CNE"
						:class="{ 'input-error': errors.CNE }"
						@input="validateStep('CNE')"
						@focus="currentField = 'CNE'"
						readonly
						disabled
					/>
					<span v-if="errors.CNE" class="error-icon" >✖ {{ errors.CNE }}</span>
				</div>
				<div class="form-group" dir="ltr">
					<label for="CIN" >CIN</label>
					<input
						type="text"
						id="CIN"
						v-model="etudiant.CIN"
						placeholder="Entrez votre CIN"
						:class="{ 'input-error': errors.CIN }"
						@input="validateStep('CIN')"
						@focus="currentField = 'CIN'"
						readonly
						disabled
					/>
					<span v-if="errors.CIN" class="error-icon" >✖ {{ errors.CIN }}</span>
				</div>
				<div class="form-group" dir="ltr">
					<label for="Nom" >Nom</label>
					<input
						type="text"
						id="Nom"
						v-model="etudiant.nom"
						placeholder="Entrez votre Nom"
						:class="{ 'input-error': errors.nom }"
						@input="validateStep('nom')"
						@focus="currentField = 'nom'"

					/>
					<span v-if="errors.nom" class="error-icon" >✖ {{ errors.nom }}</span>
				</div>
				<div class="form-group" dir="ltr">
					<label for="Prenom" >Prenom</label>
					<input
						type="text"
						id="Prenom"
						v-model="etudiant.prenom"
						placeholder="Entrez votre Prenom"
						:class="{ 'input-error': errors.prenom }"
						@input="validateStep('prenom')"
						@focus="currentField = 'prenom'"

					/>
					<span v-if="errors.prenom" class="error-icon" >✖ {{ errors.prenom }}</span>
				</div>
				<div class="form-group" dir="rtl">
					<!-- Apply RTL to the entire form group for Arabic fields -->
					<label for="الاسم العائلي" class="rtl-label">الاسم العائلي</label>
					<input
						type="text"
						id="الاسم العائلي"
						v-model="etudiant.nomar"
						placeholder="أدخل الاسم العائلي"
						:class="{ 'input-error': errors.nomar }"
						@input="validateStep('nomar')"
						@focus="currentField = 'nomar'"
					/>
					<span v-if="errors.nomar" class="error-message">
						✖ {{ errors.nomar }}
					</span>
				</div>
				<div class="form-group" dir="rtl">
					<!-- Apply RTL to the entire form group for Arabic fields -->
					<label for="الاسم الشخصي" class="rtl-label"> الاسم الشخصي</label>
					<input
						type="text"
						id="الاسم الشخصي"
						v-model="etudiant.prenomar"
						placeholder="أدخل الاسم الشخصي"
						:class="{ 'input-error': errors.prenomar }"
						@input="validateStep('prenomar')"
						@focus="currentField = 'prenomar'"
					/>
					<span v-if="errors.prenomar" class="error-message">
						✖ {{ errors.prenomar }}
					</span>
				</div>
				<div class="form-group" dir="ltr">
					<label for="Date Naissance" >Date Naissance</label>
					<input
						type="date"
						id="Date Naissance"
						v-model="etudiant.datenais"
						:class="{ 'input-error': errors.datenais }"
						@input="validateStep('datenais')"
						@focus="currentField = 'datenais'"

					/>
					<span v-if="errors.datenais" class="error-icon" >✖ {{ errors.datenais }}</span>
				</div>

				<div class="form-group" dir="ltr">
					<label for="sexe">Sexe</label>
					<select
						id="sexe"
						v-model="etudiant.sexe"
						:class="{ 'input-error': errors.sexe }"
						@change="validateStep('sexe')"
						@focus="currentField = 'sexe'"
					>
						<option value="" disabled>Veuillez choisir</option>
						<option value="M">M</option>
						<option value="F">F</option>
					</select>
					<span v-if="errors.sexe" class="error-icon">✖ {{ errors.sexe }}</span>
				 </div>
				 <div class="form-group" dir="ltr">
					<label for="pays" >Pays</label>
					<input
						type="text"
						id="pays"
						v-model="etudiant.payschamp"
						placeholder="Entrez votre Pays"
						:class="{ 'input-error': errors.payschamp }"
						@input="validateStep('payschamp')"
						@focus="currentField = 'payschamp'"

					/>
					<span v-if="errors.payschamp" class="error-icon" >✖ {{ errors.payschamp }}</span>
				</div>
				<div class="form-group" dir="ltr">
					<label for="ville" >Ville</label>
					<input
						type="text"
						id="ville"
						v-model="etudiant.villenais"
						placeholder="Entrez votre Ville de Naissance"
						:class="{ 'input-error': errors.villenais }"
						@input="validateStep('villenais')"
						@focus="currentField = 'villenais'"

					/>
					<span v-if="errors.villenais" class="error-icon" >✖ {{ errors.villenais }}</span>
				</div>
				<div class="form-group" dir="rtl">
					<!-- Apply RTL to the entire form group for Arabic fields -->
					<label for="مكان الازدياد" class="rtl-label">مكان الازدياد</label>
					<input
						type="text"
						id="مكان الازدياد"
						v-model="etudiant.villechamp"
						placeholder="مكان الازدياد"
						:class="{ 'input-error': errors.villechamp }"
						@input="validateStep('villechamp')"
						@focus="currentField = 'villechamp'"
					/>
					<span v-if="errors.villechamp" class="error-message">
						✖ {{ errors.villechamp }}
					</span>
				</div>
				<div class="form-group" dir="ltr">
					<label for="adresse">Adresse</label>
					<textarea
						id="adresse"
						v-model="etudiant.adresse"
						placeholder="Entrez votre Adresse"
						:class="{ 'input-error': errors.adresse }"
						@input="validateStep('adresse')"
						@focus="currentField = 'adresse'"
						rows="4"
					></textarea>
					<span v-if="errors.adresse" class="error-icon">✖ {{ errors.adresse }}</span>
				</div>

				<div class="form-group" dir="ltr">
					<label for="email" >Email</label>
					<input
						type="text"
						id="email"
						v-model="etudiant.email"
						placeholder="Entrez votre Email"
						:class="{ 'input-error': errors.email }"
						@input="validateStep('email')"
						@focus="currentField = 'email'"

					/>
					<span v-if="errors.email" class="error-icon" >✖ {{ errors.email }}</span>
				</div>

				<div class="form-group" dir="ltr">
					<label for="phone" >Télephone</label>
					<input
						type="text"
						id="phone"
						v-model="etudiant.phone"
						placeholder="Entrez votre Télephone"
						:class="{ 'input-error': errors.phone }"
						@input="validateStep('phone')"
						@focus="currentField = 'phone'"

					/>
					<span v-if="errors.phone" class="error-icon" >✖ {{ errors.phone }}</span>
				</div>


		  </div>

          <div v-if="currentStep === 2">
			<fieldset>
				<legend class="legend1">Information de baccalauréat</legend>
				<div class="form-group" style="margin-top: 20px;" dir="ltr">
                    <label for="serie">Série de BAC</label>

                    <!-- Select -->
                    <select
                        v-if="!showInputSerie"
                        id="serie"
                        v-model="etudiant.serie"
                        :class="{ 'input-error': errors.serie }"
                        @change="handleSerieChange"
                        @focus="currentField = 'serie'"
                    >
                        <option value="" disabled>SERIE DE BAC</option>
                        <option v-for="s in serie_bac" :key="s.nom" :value="s.id">{{ s.nom }}</option>
                        <option value="AUTRES">AUTRES</option>
                    </select>

                    <!-- Input avec bouton annuler -->
                    <div v-else style="position: relative;">
                        <input
                            type="text"
                            id="serie"
                            v-model="etudiant.serie"
                            placeholder="Taper votre série de BAC"
                            :class="{ 'input-error': errors.serie }"
                            @input="validateStep('serie')"
                            @focus="currentField = 'serie'"
                            style="padding-right: 3rem;"
                        />
                        <div
                            class="close-icon"
                            @click="cancelInputSerie"
                            title="Annuler"
                        >
                            <span>×</span>
                        </div>
                    </div>

                    <!-- Message d'erreur -->
                    <span v-if="errors.serie" class="error-icon">✖ {{ errors.serie }}</span>
                </div>

				<div class="form-group" dir="ltr">
					<label for="Date BAC" >Date D'obtention du BAC</label>
					<input
						type="date"
						id="Date BAC"
						v-model="etudiant.Anneebac"
						:class="{ 'input-error': errors.Anneebac }"
						@input="validateStep('Anneebac')"
						@focus="currentField = 'Anneebac'"

					/>
					<span v-if="errors.Anneebac" class="error-icon" >✖ {{ errors.Anneebac }}</span>
				</div>

			</fieldset>
			<fieldset>
				<legend class="legend2">Information du Diplome</legend>
				<div class="form-group" style="margin-top: 20px;" dir="ltr">
					<label for="dernier_diplome_obtenu">Dernier Diplome Obtenu</label>
					<select
						id="dernier_diplome_obtenu"
						v-model="etudiant.dernier_diplome_obtenu"
						:class="{ 'input-error': errors.dernier_diplome_obtenu }"
						@change="validateStep('dernier_diplome_obtenu')"
						@focus="currentField = 'dernier_diplome_obtenu'"
					>
						<option value="" disabled>Choisir</option>
                        <option value="BAC+2" >Bac+2</option>
						<option value="BAC+3" >Bac+3</option>
						<option value="BAC+4" >Bac+4</option>
						<option value="BAC+5" >Bac+5</option>
					</select>
					<span v-if="errors.dernier_diplome_obtenu" class="error-icon">✖ {{ errors.dernier_diplome_obtenu }}</span>
				</div>
                <div class="form-group" dir="ltr">
                    <label for="type_diplome_obtenu">Type de Diplôme Obtenu</label>

                    <!-- Select -->
                    <select
                        v-if="!showInputTypeDiplome"
                        id="type_diplome_obtenu"
                        v-model="etudiant.type_diplome_obtenu"
                        :class="{ 'input-error': errors.type_diplome_obtenu }"
                        @change="handleDiplomeChange"
                        @focus="currentField = 'type_diplome_obtenu'"
                    >
                        <option value="" disabled>Choisir</option>
                        <option value="PUBLIC">Public</option>
                        <option value="PRIVEE">Privée</option>
                        <option value="AUTRES">AUTRES</option>
                    </select>

                    <!-- Input avec bouton annuler -->
                    <div v-else style="position: relative;">
                        <input
                            type="text"
                            id="type_diplome_obtenu"
                            v-model="etudiant.type_diplome_obtenu"
                            placeholder="Taper le type de diplôme"
                            :class="{ 'input-error': errors.type_diplome_obtenu }"
                            @input="validateStep('type_diplome_obtenu')"
                            @focus="currentField = 'type_diplome_obtenu'"
                            style="padding-right: 3rem;"
                        />
                        <div
                            class="close-icon"
                            @click="cancelInputDiplome"
                            title="Annuler"
                        >
                            <span>×</span>
                        </div>
                    </div>

                    <!-- Message d'erreur -->
                    <span v-if="errors.type_diplome_obtenu" class="error-icon">✖ {{ errors.type_diplome_obtenu }}</span>
                </div>

				 <div class="form-group" dir="ltr">
					<label for="specialitediplome" >Spécialité du Diplome</label>
					<input
						type="text"
						id="specialitediplome"
						v-model="etudiant.specialitediplome"
						placeholder="Entrez le spécialité du Diplome"
						:class="{ 'input-error': errors.specialitediplome }"
						@input="validateStep('specialitediplome')"
						@focus="currentField = 'specialitediplome'"

					/>
					<span v-if="errors.specialitediplome" class="error-icon" >✖ {{ errors.specialitediplome }}</span>
				</div>
				<!-- <div class="form-group" dir="ltr">
					<label for="etblsmtdeug" >Etablissement</label>
					<input
						type="text"
						id="etblsmtdeug"
						v-model="etudiant.etblsmtdeug"
						placeholder="Entrez l'établissement"
						:class="{ 'input-error': errors.etblsmtdeug }"
						@input="validateStep('etblsmtdeug')"
						@focus="currentField = 'etblsmtdeug'"

					/>
					<span v-if="errors.etblsmtdeug" class="error-icon" >✖ {{ errors.etblsmtdeug }}</span>
				</div> -->
				<div class="form-group" dir="ltr">
					<label for="ville_etablissement_diplome" >Etablissement</label>
					<input
						type="text"
						id="ville_etablissement_diplome"
						v-model="etudiant.ville_etablissement_diplome"
						placeholder="Entrez l'établissement"
						:class="{ 'input-error': errors.ville_etablissement_diplome }"
						@input="validateStep('ville_etablissement_diplome')"
						@focus="currentField = 'ville_etablissement_diplome'"

					/>
					<span v-if="errors.ville_etablissement_diplome" class="error-icon" >✖ {{ errors.ville_etablissement_diplome }}</span>
				</div>
				<div class="form-group" dir="ltr">
					<label for="date_optention_diplome" >Date Obtention de Diplome</label>
					<input
						type="date"
						id="date_optention_diplome"
						v-model="etudiant.date_optention_diplome"
						:class="{ 'input-error': errors.date_optention_diplome }"
						@input="validateStep('date_optention_diplome')"
						@focus="currentField = 'date_optention_diplome'"

					/>
					<span v-if="errors.date_optention_diplome" class="error-icon" >✖ {{ errors.date_optention_diplome }}</span>
				</div>
			</fieldset>
			<fieldset>
				<legend class="legend4">Expérience</legend>
				<div class="form-group" style="margin-top: 20px;" dir="ltr">
					<label for="fonctionnaire">Fonctionnaire</label>
					<select
						id="fonctionnaire"
						v-model="etudiant.fonctionnaire"
						:class="{ 'input-error': errors.fonctionnaire }"
						@change="validateStep('fonctionnaire')"
						@focus="currentField = 'fonctionnaire'"
					>
						<option value="" disabled>Fonctionnaire</option>
						<option value="OUI" >OUI</option>
						<option value="NON" >NON</option>
					</select>
					<span v-if="errors.fonctionnaire" class="error-icon">✖ {{ errors.fonctionnaire }}</span>
				</div>
				<div v-if="etudiant.fonctionnaire === 'OUI'">
					<div class="form-group" dir="ltr">
						<label for="secteur">Secteur</label>
						<input
							type="text"
							id="secteur"
							v-model="etudiant.secteur"
							placeholder="Entrez le secteur"
							:class="{ 'input-error': errors.secteur }"
							@input="validateStep('secteur')"
							@focus="currentField = 'secteur'"
						/>
						<span v-if="errors.secteur" class="error-icon">✖ {{ errors.secteur }}</span>
					</div>

					<div class="form-group" dir="ltr">
						<label for="nombreannee">Nombre d'années</label>
						<input
							type="number"
							id="nombreannee"
							v-model="etudiant.nombreannee"
							min="0"
							step="1"
							placeholder="Nombre d'années d'expérience"
							:class="{ 'input-error': errors.nombreannee }"
							@input="validateStep('nombreannee')"
							@focus="currentField = 'nombreannee'"
						/>
						<span v-if="errors.nombreannee" class="error-icon">✖ {{ errors.nombreannee }}</span>
					</div>

					<div class="form-group" dir="ltr">
						<label for="poste">Poste</label>
						<input
							type="text"
							id="poste"
							v-model="etudiant.poste"
							placeholder="Entrez votre poste"
							:class="{ 'input-error': errors.poste }"
							@input="validateStep('poste')"
							@focus="currentField = 'poste'"
						/>
						<span v-if="errors.poste" class="error-icon">✖ {{ errors.poste }}</span>
					</div>

					<div class="form-group" dir="ltr">
						<label for="lieutravail">Lieu de travail</label>
						<input
							type="text"
							id="lieutravail"
							v-model="etudiant.lieutravail"
							placeholder="Lieu de travail"
							:class="{ 'input-error': errors.lieutravail }"
							@input="validateStep('lieutravail')"
							@focus="currentField = 'lieutravail'"
						/>
						<span v-if="errors.lieutravail" class="error-icon">✖ {{ errors.lieutravail }}</span>
					</div>

					<div class="form-group" dir="ltr">
						<label for="villetravail">Ville de travail</label>
						<input
							type="text"
							id="villetravail"
							v-model="etudiant.villetravail"
							placeholder="Ville de travail"
							:class="{ 'input-error': errors.villetravail }"
							@input="validateStep('villetravail')"
							@focus="currentField = 'villetravail'"
						/>
						<span v-if="errors.villetravail" class="error-icon">✖ {{ errors.villetravail }}</span>
					</div>
				</div>
			</fieldset>


		  </div>

		<div v-if="currentStep === 3">

			<!-- File Upload Field for PHOTO -->
			<div class="form-group student-image-upload" v-if="etablissement.show_photo_input_passerelle">
				<div class="file-upload-wrapper-student">
					<input
						type="file"
						id="path_photo"
						@change="handleFileUpload($event, 'path_photo')"
						accept=".jpg, .jpeg, .png"
						:class="{ 'input-error-student': errors['path_photo'] }"
						ref="fileInput8"
						style="display: none;"
					/>
					<div class="file-upload-btn-student" @click="triggerFileInput('fileInput8')">
						<div class="file-upload-image-student">
							<img :src="etudiant['path_photo'] && etudiant['path_photo'].preview ? etudiant['path_photo'].preview : '/form/images/etudiant.png'"
								alt="Preview" class="upload-img-student"/>
						</div>
						<div class="upload-text-student">
							<span>{{ etudiant['path_photo'] && etudiant['path_photo'].preview ? 'Changer l\'image' : 'Choisir votre photo' }}</span>
						</div>
					</div>
					<span v-if="errors['path_photo']" class="error-icon">✖ {{ errors['path_photo'] }}</span>
				</div>
			</div>

			<!-- File Upload Field for CIN -->
			<div v-if="etablissement.show_cin_input_passerelle" class="form-group" style="margin-top: 20px;">
				<!-- File Upload Field for Student Image -->
				<label class="file-label">CIN</label>
				<div class="file-upload-wrapper">
					<input
					type="file"
					id="path_cin"
					@change="handleFileUpload($event, 'path_cin')"
					accept=".jpg, .jpeg, .png"
					:class="{ 'input-error': errors['path_cin'] }"
					ref="fileInput7"
					style="display: none;"
					/>
					<div class="file-upload-btn" @click="triggerFileInput('fileInput7')">
					<span class="btn-text">Choisir une image</span>
					<i class="fa fa-upload"></i>
					</div>
					<div class="file-preview" v-if="etudiant['path_cin'] && etudiant['path_cin'].preview">
					<div class="preview-container">
						<img :src="etudiant['path_cin'].preview" alt="Preview" class="preview-img" />
						<button @click="removeFile('path_cin')" class="remove-btn">✖</button>
					</div>
					</div>
					<span v-if="errors['path_cin']" class="error-icon">✖ {{ errors['path_cin'] }}</span>
				</div>
			</div>

			<!-- File Upload Field for Bac -->
			<div v-if="etablissement.show_bac_input_passerelle" class="form-group" style="margin-top: 20px;">
				<!-- File Upload Field for Student Bac -->
				<label class="file-label">Diplome de baccalauréat</label>
				<div class="file-upload-wrapper">
					<input
					type="file"
					id="path_bac"
					@change="handleFileUpload($event, 'path_bac')"
					accept=".jpg, .jpeg, .png"
					:class="{ 'input-error': errors['path_bac'] }"
					ref="fileInput9"
					style="display: none;"
					/>
					<div class="file-upload-btn" @click="triggerFileInput('fileInput9')">
					<span class="btn-text">Choisir une image</span>
					<i class="fa fa-upload"></i>
					</div>
					<div class="file-preview" v-if="etudiant['path_bac'] && etudiant['path_bac'].preview">
					<div class="preview-container">
						<img :src="etudiant['path_bac'].preview" alt="Preview" class="preview-img" />
						<button @click="removeFile('path_bac')" class="remove-btn">✖</button>
					</div>
					</div>
					<span v-if="errors['path_bac']" class="error-icon">✖ {{ errors['path_bac'] }}</span>
				</div>
			</div>

			<!-- File Upload Field for Diplome Bac+2 -->
			<div v-if="etablissement.show_diplome_deug_input_passerelle" class="form-group" style="margin-top: 20px;">
				<!-- File Upload Field for Student Diplome bac+2 -->
				<label class="file-label">Diplome de Bac+2 (Ou équivalent)</label>
				<div class="file-upload-wrapper">
					<input
					type="file"
					id="path_diplomedeug"
					@change="handleFileUpload($event, 'path_diplomedeug')"
					accept=".jpg, .jpeg, .png"
					:class="{ 'input-error': errors['path_diplomedeug'] }"
					ref="fileInput10"
					style="display: none;"
					/>
					<div class="file-upload-btn" @click="triggerFileInput('fileInput10')">
					<span class="btn-text">Choisir une image</span>
					<i class="fa fa-upload"></i>
					</div>
					<div class="file-preview" v-if="etudiant['path_diplomedeug'] && etudiant['path_diplomedeug'].preview">
					<div class="preview-container">
						<img :src="etudiant['path_diplomedeug'].preview" alt="Preview" class="preview-img" />
						<button @click="removeFile('path_diplomedeug')" class="remove-btn">✖</button>
					</div>
					</div>
					<span v-if="errors['path_diplomedeug']" class="error-icon">✖ {{ errors['path_diplomedeug'] }}</span>
				</div>
			</div>

			<!-- File Upload Field for Attestation non emploi -->
			<div v-if="etablissement.show_attestation_no_emploi_input_passerelle" class="form-group" style="margin-top: 20px;">
				<!-- File Upload Field for Student Attestation non emploi -->
				<label class="file-label">Attestation de non-emploi</label>
				<div class="file-upload-wrapper">
					<input
					type="file"
					id="path_attestation_non_emploi"
					@change="handleFileUpload($event, 'path_attestation_non_emploi')"
					accept=".jpg, .jpeg, .png"
					:class="{ 'input-error': errors['path_attestation_non_emploi'] }"
					ref="fileInput11"
					style="display: none;"
					/>
					<div class="file-upload-btn" @click="triggerFileInput('fileInput11')">
					<span class="btn-text">Choisir une image</span>
					<i class="fa fa-upload"></i>
					</div>
					<div class="file-preview" v-if="etudiant['path_attestation_non_emploi'] && etudiant['path_attestation_non_emploi'].preview">
					<div class="preview-container">
						<img :src="etudiant['path_attestation_non_emploi'].preview" alt="Preview" class="preview-img" />
						<button @click="removeFile('path_attestation_non_emploi')" class="remove-btn">✖</button>
					</div>
					</div>
					<span v-if="errors['path_attestation_non_emploi']" class="error-icon">✖ {{ errors['path_attestation_non_emploi'] }}</span>
				</div>
			</div>

			<div class="form-group student-pdf-upload" v-if="etablissement.show_cv_input_passerelle">
				<label class="file-label-student">Curriculum Vitae (PDF)</label>

				<!-- PDF Upload Box -->
				<div class="pdf-upload-container" @click="triggerFileInputPDF">
					<input
					type="file"
					ref="fileInput"
					@change="handleFileUploadPDF"
					accept=".pdf"
					hidden
					/>

					<!-- PDF Content Preview -->
					<div v-if="pdfUrl" ref="pdfContainer" class="pdf-preview-container">
					<canvas ref="pdfCanvas"></canvas>
					<button class="remove-file-btn" @click.stop="removeFilePDF">✖</button>
					</div>

					<!-- Placeholder -->
					<div v-else class="pdf-upload-placeholder">
					<i class="fas fa-file-upload pdf-upload-icon"></i>
					<span class="upload-text">Cliquez pour sélectionner un fichier PDF</span>
					</div>
				</div>

				<!-- Error Message -->
				<span v-if="errors['path_cv']" class="error-icon">✖ {{ errors['path_cv'] }}</span>
			</div>


		</div>


		<div v-if="currentStep === 4">
			<div v-if="etablissement.multiple_choix_filiere_passerelle == 0" class="form-groupp">
				<label class="section-title">Sélectionnez une Filière</label>

				<div class="filiere-container">
					<div v-for="f in filieres" :key="f.id" class="filiere-card" @click="toggleSelection(f.id)">
						<input
							type="radio"
							:id="'filiere_' + f.id"
							v-model="etudiant.filiere"
							:value="f.id"
							class="hidden-input"
							@change="validateStep('filiere')"
						/>
						<label :for="'filiere_' + f.id" class="filiere-content">
							<div class="filiere-title">{{ f.nom_abrv }}</div>
							<div class="filiere-name">{{ f.nom_complet }}</div>

							<a :href="appurl + f.document" target="_blank" class="description-btn">
								<i class="fas fa-file-alt"></i> Voir la description
							</a>

							<div v-if="etudiant.filiere === f.id" class="selected-icon">
								✔ Sélectionné
							</div>
						</label>
					</div>
				</div>

				<span v-if="errors.filiere" class="error-icon">✖ {{ errors.filiere }}</span>
			</div>

			<div v-else class="form-groupp">
				<label class="section-title">Choisissez jusqu'à 3 Filières</label>

				<div class="filiere-container">
					<div v-for="(f) in filieres" :key="f.id" class="filiere-card">
						<input
							type="checkbox"
							:id="'filiere_choix_' + f.id"
							:value="f.id"
							v-model="selectedFiliereChoices"
							class="hidden-input"
							:disabled="selectedFiliereChoices.length >= 3 && !selectedFiliereChoices.includes(f.id)"
						/>
						<label :for="'filiere_choix_' + f.id" class="filiere-content">
							<div class="filiere-title">{{ f.nom_abrv }}</div>
							<div class="filiere-name">{{ f.nom_complet }}</div>

							<a :href="appurl + f.document" target="_blank" class="description-btn">
								<i class="fas fa-file-alt"></i> Voir la description
							</a>

							<div v-if="selectedFiliereChoices.includes(f.id)" class="selected-icon">
								✔ Sélectionné ({{ choixText(selectedFiliereChoices.indexOf(f.id) + 1) }})
							</div>
						</label>
					</div>
				</div>

				<span v-if="errors.filiere_choix_1 || errors.filiere_choix_2 || errors.filiere_choix_3" class="error-icon">✖ Le choix de trois filières est requis. Veuillez sélectionner trois filières.</span>
			</div>
		</div>

		<div v-if="currentStep === 5" class="confirmation-container">
			<p class="confirmation-note">
				<strong>NB :</strong> Veuillez vérifier que vous avez rempli correctement toutes les informations demandées.
				L'inscription se fait uniquement une seule fois.
			</p>

			<div class="checkbox-wrapper">
				<!-- Hidden checkbox for v-model -->
				<input
					id="check"
					type="checkbox"
					v-model="etudiant.confirmation"
					class="hidden-checkbox"
					@change="validateCheckbox" />

				<!-- Custom checkbox -->
				<label for="check" class="custom-checkbox">
					<svg class="check-icon" viewBox="0 0 24 24">
						<path d="M5 12l5 5L20 7" />
					</svg>
				</label>

				<!-- Checkbox text -->
				<span class="checkbox-text">
					Je certifie sur l'honneur l'exactitude des informations déclarées et des documents téléchargés.
				</span>
			</div>

			<!-- Error message -->
			<span v-if="errors.confirmation" class="error-icon">✖ {{ errors.confirmation }}</span>
		</div>





		<ErrorPopup ref="errorPopup" />


		  <!-- Navigation Buttons -->
		  <div class="form-actions">
			<button type="button" class="btn btn-secondary" @click="prevStep" :disabled="currentStep === 1">Précédent</button>
			<button type="submit" class="btn btn-primary">
			  {{ currentStep === steps.length ? 'Terminer' : 'Suivant' }}
			</button>
		  </div>
		</form>
	  </div>
	</div>



	<div class="success-container" v-else>
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
				<p><strong>Votre compte étudiant a été créé avec succès.</strong></p>
				<p>Veuillez vous connecter à votre espace personnel pour :</p>
				<ul>
					<li><strong>Modifier</strong> votre candidature si nécessaire,</li>
					<li><strong>Confirmer</strong> définitivement votre candidature,</li>
					<li>et <strong>télécharger le reçu</strong> de votre préinscription.</li>
				</ul>
				<p class="mt-3">Nous vous invitons à finaliser ces étapes dans les meilleurs délais.</p>
			</div>

			<!-- User Credentials -->
			<div class="success-credentials">
				<p><strong>Email :</strong> <span>{{ etudiant.email }}</span></p>

				<!-- Smart Password Toggle -->
				<!-- Password field with dynamic type change -->
				<p><strong>Mot de passe :</strong>
					<!-- Password display container -->
					<span class="password-box" :class="{ 'blurred': !showPassword }">
						<!-- Use a span to display the password, it won't show in HTML source directly -->
						<span v-if="showPassword">{{ etudiant.CIN }}@2025</span>
						<span v-else>********************************</span>
					</span>
					<button class="toggle-password" @click="togglePassword" @mouseenter="showTooltip = true" @mouseleave="showTooltip = false">
						<span v-if="showPassword">👁️‍🗨️</span>
						<span v-else>🔒</span>
					</button>
					<!-- Tooltip -->
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




</template>

<script>
  import axios from 'axios';
  import ErrorPopup  from './ErrorPopup.vue'

  import { nextTick } from 'vue';
  import * as pdfjsLib from 'pdfjs-dist/webpack';


  export default {
	props: ['appurl','cne','cin','etablissement','filieres'],
	components:{
		ErrorPopup
	},
	data() {
	  return {
		currentStep: 1,
		currentField: null,
		serie_bac: [],
		diplomeBacPlus2: [],
		loading: false,
		successForm:false,
		showPassword: false,
		showTooltip: false,
		pdfUrl: null,
		steps: [
			{ title: "IDENTITE" },
			{ title: "INFORMATIONS\nACADEMIQUES" },
			{ title: "DOCUMENT" },
			{ title: "CHOIX\nDE FILIERE" },
			{ title: "CONFIRMATION" },
		],
		etudiant: {
			etablissement_id: "",
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

			serie: "",  //bac
			Anneebac: "",

			dernier_diplome_obtenu:"",//Diplome
			type_diplome_obtenu: "",
			specialitediplome: "",
			ville_etablissement_diplome: "",
			date_optention_diplome: "",


			fonctionnaire: "",
			secteur: "",
			nombreannee: "",
			poste: "",
			lieutravail: "",
			villetravail: "",


			path_photo: { file: null, preview: null },
			path_cin: { file: null, preview: null },
			path_bac: { file: null, preview: null },
			path_licence: { file: null, preview: null },
			path_attestation_non_emploi: { file: null, preview: null },
			path_cv: { file: null, preview: null },
			filiere: "",
			filiere_choix_1: "",
			filiere_choix_2: "",
			filiere_choix_3: "",
			confirmation: ""
		},
		selectedFiliereChoices: [],
		errors: {
		  CNE: null,
          CIN: null,
          nom: null,
          prenom: null,
          nomar: null,
          prenomar: null,
		  datenais: null,
		  sexe: null,
		  payschamp: null,
		  villenais: null,
		  villechamp: null,
		  adresse: null,
		  email: null,
		  phone: null,

		  serie: null,
		  Anneebac: null,

		  dernier_diplome_obtenu: null,
		  type_diplome_obtenu: null,
		  specialitediplome: null,
		  ville_etablissement_diplome: null,
		  date_optention_diplome: null,

		  fonctionnaire: null,
		  secteur: null,
		  nombreannee: null,
		  poste: null,
		  lieutravail: null,
		  villetravail: null,

		  path_photo:null,
		  path_cin: null,
		  path_bac: null,
		  path_licence:null,
		  path_attestation_non_emploi: null,
		  path_cv: null,

		  filiere: null,
		  filiere_choix_1: null,
		  filiere_choix_2: null,
		  filiere_choix_3: null,
		  confirmation: null
		},
		showInputTypeDiplome: false,
        showInputSerie: false,
		showNotification: false,
	  };
	},
	watch: {
		etudiant: {
			deep: true,
			handler(newVal) {
				console.log("Updated etudiant data:", newVal);
			}
		},
		"etudiant.CNE"(newValue) {
		if (this.currentField === "CNE") {
			this.validateStep("CNE");
		}
		},
		"etudiant.CIN"(newValue) {
		if (this.currentField === "CIN") {
			this.validateStep("CIN");
		}
		},
		"etudiant.nom"(newValue) {
		if (this.currentField === "nom") {
			this.validateStep("nom");
		}
		},
		"etudiant.prenom"(newValue) {
		if (this.currentField === "prenom") {
			this.validateStep("prenom");
		}
		},
		"etudiant.nomar"(newValue) {
		if (this.currentField === "nomar") {
			this.validateStep("nomar");
		}
		},
		"etudiant.prenomar"(newValue) {
		if (this.currentField === "prenomar") {
			this.validateStep("prenomar");
		}
		},
		"etudiant.datenais"(newValue) {
		if (this.currentField === "datenais") {
			this.validateStep("datenais");
		}
		},
		"etudiant.sexe"(newValue) {
		if (this.currentField === "sexe") {
			this.validateStep("sexe");
		}
		},
		"etudiant.payschamp"(newValue) {
		if (this.currentField === "payschamp") {
			this.validateStep("payschamp");
		}
		},
		"etudiant.villenais"(newValue) {
		if (this.currentField === "villenais") {
			this.validateStep("villenais");
		}
		},
		"etudiant.villechamp"(newValue) {
		if (this.currentField === "villechamp") {
			this.validateStep("villechamp");
		}
		},
		"etudiant.adresse"(newValue) {
		if (this.currentField === "adresse") {
			this.validateStep("adresse");
		}
		},
		"etudiant.email"(newValue) {
		if (this.currentField === "email") {
			this.validateStep("email");
		}
		},
		"etudiant.phone"(newValue) {
		if (this.currentField === "phone") {
			this.validateStep("phone");
		}
		},

		"etudiant.serie_bac"(newValue) {
		if (this.currentField === "serie_bac") {
			this.validateStep("serie_bac");
		}
		},
		"etudiant.Anneebac"(newValue) {
		if (this.currentField === "Anneebac") {
			this.validateStep("Anneebac");
		}
		},

		"etudiant.dernier_diplome_obtenu"(newValue) {
		if (this.currentField === "dernier_diplome_obtenu") {
			this.validateStep("dernier_diplome_obtenu");
		}
		},
		"etudiant.type_diplome_obtenu"(newValue) {
		if (this.currentField === "type_diplome_obtenu") {
			this.validateStep("type_diplome_obtenu");
		}
		},
		"etudiant.specialitediplome"(newValue) {
		if (this.currentField === "specialitediplome") {
			this.validateStep("specialitediplome");
		}
		},
		"etudiant.ville_etablissement_diplome"(newValue) {
		if (this.currentField === "ville_etablissement_diplome") {
			this.validateStep("ville_etablissement_diplome");
		}
		},
		"etudiant.date_optention_diplome"(newValue) {
		if (this.currentField === "date_optention_diplome") {
			this.validateStep("date_optention_diplome");
		}
		},

		"etudiant.fonctionnaire"(newValue) {
		if (this.currentField === "fonctionnaire") {
			this.validateStep("fonctionnaire");
		}
		},
		"etudiant.secteur"(newValue) {
		if (this.currentField === "secteur") {
			this.validateStep("secteur");
		}
		},
		"etudiant.nombreannee"(newValue) {
		if (this.currentField === "nombreannee") {
			this.validateStep("nombreannee");
		}
		},
		"etudiant.poste"(newValue) {
		if (this.currentField === "poste") {
			this.validateStep("poste");
		}
		},
		"etudiant.lieutravail"(newValue) {
		if (this.currentField === "lieutravail") {
			this.validateStep("lieutravail");
		}
		},
		"etudiant.villetravail"(newValue) {
		if (this.currentField === "villetravail") {
			this.validateStep("villetravail");
		}
		},

		selectedFiliereChoices(newVal, oldVal) {
        	this.updateFiliereChoices(newVal);
    	},
		"etudiant.filiere"(newValue) {
		if (this.currentField === "filiere") {
			this.validateStep("filiere");
		}
		},
		"etudiant.filiere_choix_1"(newValue) {
		if (this.currentField === "filiere_choix_1") {
			this.validateStep("filiere_choix_1");
		}
		},
		"etudiant.filiere_choix_2"(newValue) {
		if (this.currentField === "filiere_choix_2") {
			this.validateStep("filiere_choix_2");
		}
		},
		"etudiant.filiere_choix_3"(newValue) {
		if (this.currentField === "filiere_choix_3") {
			this.validateStep("filiere_choix_3");
		}
		},
		"etudiant.confirmation"(newValue) {
		if (this.currentField === "confirmation") {
			this.validateStep("confirmation");
		}
		}
	},

	methods: {
		handleSerieChange() {
            if (this.etudiant.serie === "AUTRES") {
                this.showInputSerie = true;
                this.etudiant.serie = "";
            } else {
                this.showInputSerie = false;
                this.validateStep("serie");
            }
        },
        cancelInputSerie() {
            this.showInputSerie = false;
            this.etudiant.serie = "";
        },
        handleDiplomeChange() {
            if (this.etudiant.type_diplome_obtenu === "AUTRES") {
                this.showInputTypeDiplome = true;
                this.etudiant.type_diplome_obtenu = "";
            } else {
                this.showInputTypeDiplome = false;
                this.validateStep("type_diplome_obtenu");
            }
        },
        cancelInputDiplome() {
            this.showInputTypeDiplome = false;
            this.etudiant.type_diplome_obtenu = "";
        },


		triggerFileInput(refName) {
			// Check if the reference exists before attempting to click
			const input = this.$refs[refName];
			if (input) {
				input.click();
			} else {
				console.error(`Reference ${refName} not found in $refs`);
			}
		},

		// Function to handle file upload and validation
		handleFileUpload(event, path) {
			const file = event.target.files[0]; // Obtenir le premier fichier sélectionné

			if (!file) return;

			const maxSize = 300 * 1024; // 300 KB
			const allowedTypes = ["image/jpeg", "image/png", "image/jpg"];

			if (!allowedTypes.includes(file.type)) {
				this.errors[path] = "Seules les images (.jpg, .jpeg, .png) sont autorisées.";
				return; // Arrêter l'exécution si le type de fichier n'est pas valide
			}

			if (file.size > maxSize) {
				this.errors[path] = "La taille de l'image ne doit pas dépasser 300 Ko.";
				return; // Arrêter l'exécution si le fichier est trop volumineux
			}

			this.etudiant[path] = file; // Stocker uniquement l'objet fichier
			this.previewImage(file, path); // Générer un aperçu si nécessaire
			this.errors[path] = null; // Effacer les erreurs précédentes si le fichier est valide
		},

		previewImage(file, path) {
			const reader = new FileReader();
			reader.onload = (e) => {
				// Storing preview along with the file object
				this.etudiant[path] = {
					file: file, // Keep the original file object
					preview: e.target.result // Store preview separately
				};
			};
			reader.readAsDataURL(file);
		},

		// Function to remove the uploaded file and clear input
		removeFile(path) {
			console.log(`Removing file for ${path}`);
			console.log('Current file data:', this.etudiant[path]);

			if (this.etudiant[path]) {
				this.etudiant[path] = {
					file: null,
					preview: null
				};
				console.log('After removal:', this.etudiant[path]);
			} else {
				console.error('No file found for', path);
			}
		},

		triggerFileInputPDF() {
			this.$refs.fileInput.click();
		},

		handleFileUploadPDF(event) {
			const file = event.target.files[0];

			if (!file) return;

			const maxSize = 350 * 1024; // 350 KB

			if (file.type !== "application/pdf") {
				this.errors["path_cv"] = "Veuillez sélectionner un fichier PDF valide.";
				return;
			}

			if (file.size > maxSize) {
				this.errors["path_cv"] = "La taille du fichier ne doit pas dépasser 350 Ko.";
				return;
			}

			this.pdfUrl = URL.createObjectURL(file);
			this.etudiant.path_cv = { file: file, preview: this.pdfUrl };
			this.renderPdf(this.pdfUrl);
			this.errors["path_cv"] = null; // Effacer les erreurs précédentes si le fichier est valide
		},

		renderPdf(pdfUrl) {
			const loadingTask = pdfjsLib.getDocument(pdfUrl);
			loadingTask.promise.then((pdf) => {
				pdf.getPage(1).then((page) => {
				nextTick(() => {
					const canvas = this.$refs.pdfCanvas;
					const container = this.$refs.pdfContainer; // Ensure container reference exists

					if (!canvas || !container) {
					console.error('Canvas element not found!');
					return;
					}

					const context = canvas.getContext('2d');
					const viewport = page.getViewport({ scale: 1 });

					// Use container width to adjust scale dynamically
					const containerWidth = container.getBoundingClientRect().width;
					const scale = containerWidth / viewport.width;
					const scaledViewport = page.getViewport({ scale });

					// Set canvas size dynamically
					canvas.width = scaledViewport.width;
					canvas.height = scaledViewport.height;

					const renderContext = {
					canvasContext: context,
					viewport: scaledViewport,
					};

					page.render(renderContext).promise.then(() => {
					// Ensure full top view on all devices
					container.scrollTop = 0;
					});
				});
				});
			});
		},

		removeFilePDF() {
			this.pdfUrl = null;
			this.$refs.fileInput.value = null;
		},


		toggleSelection(id) {
			this.etudiant.filiere = id;
		},
		choixText(index) {
			const labels = ["Premier Choix", "Deuxième Choix", "Troisième Choix"];
			return labels[index - 1] || "";
		},

		updateFiliereChoices(selectedFiliereChoices) {
			this.etudiant.filiere_choix_1 = selectedFiliereChoices[0] || "";
			this.etudiant.filiere_choix_2 = selectedFiliereChoices[1] || "";
			this.etudiant.filiere_choix_3 = selectedFiliereChoices[2] || "";
		},
		validateStep(field) {
			if(this.currentStep == 1){
				switch (field) {
				case "CNE":
					if (!this.etudiant.CNE) {
					this.errors.CNE = "Le CNE est requis.";
					} else if (!/^[A-Za-z0-9]{7,20}$/.test(this.etudiant.CNE)) {
					this.errors.CNE = "Le CNE doit contenir entre 7 et 20 caractères alphanumériques.";
					} else {
					this.errors.CNE = null;
					}
					break;

				case "CIN":
					if (!this.etudiant.CIN) {
					this.errors.CIN = "Le CIN est requis.";
					} else if (!/^[A-Za-z0-9]{3,10}$/.test(this.etudiant.CIN)) {
					this.errors.CIN = "Le CIN doit contenir entre 3 et 10 caractères alphanumériques.";
					} else {
					this.errors.CIN = null;
					}
					break;

				case "nom":
					if (!this.etudiant.nom) {
					this.errors.nom = "Le nom est requis.";
				    }else if (/[^A-Za-zÀ-ÿ0-9\s\-'.]/.test(this.etudiant.nom)) {
						this.errors.nom = "Le nom doit être écrit uniquement en français.";
					}else if (this.etudiant.nom.length < 2 || this.etudiant.nom.length > 50) {
					this.errors.nom = "Le nom doit contenir entre 2 et 50 caractères";
					} else {
					this.errors.nom = null;
					}
					break;

				case "prenom":
					if (!this.etudiant.prenom) {
					this.errors.prenom = "Le prénom est requis.";
					}else if (/[^A-Za-zÀ-ÿ0-9\s\-'.]/.test(this.etudiant.prenom)) {
						this.errors.prenom = "Le prenom doit être écrit uniquement en français.";
					} else if (this.etudiant.prenom.length < 2 || this.etudiant.prenom.length > 50) {
					this.errors.prenom = "Le prenom doit contenir entre 2 et 50 caractères";
					} else {
					this.errors.prenom = null;
					}
					break;

				case "nomar":
					if (!this.etudiant.nomar) {
					this.errors.nomar = "الاسم العائلي مطلوب";
					} else if (this.etudiant.nomar.length < 2 || this.etudiant.nomar.length > 50) {
					this.errors.nomar = "يجب أن يحتوي الاسم العائلي على ما بين 2 و 50 حرفًا.";
					} else if (!/^[\u0621-\u064A\u0660-\u0669\s]+$/i.test(this.etudiant.nomar)) {
					this.errors.nomar = "يرجى إدخال الاسم العائلي باللغة العربية فقط";
					} else {
					this.errors.nomar = null;
					}
					break;

				case "prenomar":
					if (!this.etudiant.prenomar) {
					this.errors.prenomar = "الاسم الشخصي مطلوب";
					} else if (this.etudiant.prenomar.length < 2 || this.etudiant.prenomar.length > 50) {
					this.errors.prenomar = "يجب أن يحتوي الاسم الشخصي على ما بين 2 و 50 حرفًا.";
					} else if (!/^[\u0621-\u064A\u0660-\u0669\s]+$/i.test(this.etudiant.prenomar)) {
					this.errors.prenomar = "يرجى إدخال الاسم الشخصي باللغة العربية فقط";
					} else {
					this.errors.prenomar = null;
					}

					break;

				case "datenais":
					if (!this.etudiant.datenais) {
					this.errors.datenais = "La date de naissance est requis.";
					} else {
					this.errors.datenais = null;
					}
					break;

				case "sexe":
					if (!this.etudiant.sexe) {
					this.errors.sexe = "Le sexe est requis.";
					} else {
					this.errors.sexe = null;
					}
					break;

				case "payschamp":
					if (!this.etudiant.payschamp) {
					this.errors.payschamp = "Le nom du pays est requis.";
					}else if (/[^A-Za-zÀ-ÿ0-9\s\-'.]/.test(this.etudiant.payschamp)) {
						this.errors.payschamp = "Le nom du pays doit être écrit uniquement en français.";
					} else if (this.etudiant.payschamp.length < 2 || this.etudiant.payschamp.length > 70) {
					this.errors.payschamp = "Le nom du pays doit contenir entre 2 et 70 caractères.";
					} else {
					this.errors.payschamp = null;
					}
					break;

				case "villenais":
					if (!this.etudiant.villenais) {
					this.errors.villenais = "Le nom de la ville est requis.";
					}else if (/[^A-Za-zÀ-ÿ0-9\s\-'.]/.test(this.etudiant.villenais)) {
						this.errors.villenais = "Le nom de la ville doit être écrit uniquement en français.";
					} else if (this.etudiant.villenais.length < 2 || this.etudiant.villenais.length > 70) {
					this.errors.villenais = "Le nom de la ville doit contenir entre 2 et 70 caractères.";
					} else {
					this.errors.villenais = null;
					}
					break;

				case "villechamp":
					if (!this.etudiant.villechamp) {
					this.errors.villechamp = "مكان الازدياد مطلوب";
					} else if (this.etudiant.villechamp.length < 2 || this.etudiant.villechamp.length > 70) {
					this.errors.villechamp = "يجب أن يحتوي مكان الازدياد على ما بين 2 و 70 حرفًا.";
					} else if (!/^[\u0621-\u064A\u0660-\u0669\s]+$/i.test(this.etudiant.villechamp)) {
					this.errors.villechamp = "يرجى إدخال مكان الازدياد باللغة العربية فقط";
					} else {
					this.errors.villechamp = null;
					}
					break;

				case "adresse":
				if (!this.etudiant.adresse) {
					this.errors.adresse = "L'adresse est requise.";
				} else if (/[^A-Za-zÀ-ÿ0-9\s-]/.test(this.etudiant.adresse)) {
					this.errors.adresse = "L'adresse doit être écrite uniquement en français et peut contenir des chiffres.";
				} else if (this.etudiant.adresse.length < 10 || this.etudiant.adresse.length > 250) {
					this.errors.adresse = "L'adresse doit contenir entre 10 et 250 caractères.";
				} else {
					this.errors.adresse = null;
				}
					break;

				case "email":
					if (!this.etudiant.email) {
					this.errors.email = "L'email est requis.";
					}else if (!/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,100}$/.test(this.etudiant.email)) {
						this.errors.email = "Veuillez saisir une adresse email valide, en évitant les espaces au début et à la fin.";
					} else {
					this.errors.email = null;
					}
					break;

				case "phone":
					if (!this.etudiant.phone) {
						this.errors.phone = "Le téléphone est requis.";
					} else if (!/^\d{10}$/.test(this.etudiant.phone)) {
						this.errors.phone = "Le téléphone doit contenir exactement 10 chiffres, en évitant les espaces au début et à la fin.";
					} else {
						this.errors.phone = null;
					}
					break;


				default:
					console.warn(`No validation rule defined for the field: ${field}`);
				}
			}

			if(this.currentStep == 2){
				const notePattern = /^(?:\d{1,2}(?:\.\d{1,2})?)$/;
				switch (field) {
					case "serie":
                        if (!this.etudiant.serie) {
                            this.errors.serie = "Série de bac est requise.";
                        } else if (
                            this.etudiant.serie !== "AUTRES" &&
                            !/^[A-Za-zÀ-ÖØ-öø-ÿ0-9\s\(\)\-]{2,200}$/.test(this.etudiant.serie)
                        ) {
                            this.errors.serie =
                                "Ce champ doit contenir entre 2 et 200 caractères, et doit être écrit uniquement en français.";
                        } else {
                            this.errors.serie = null;
                        }
                        break;

					case "Anneebac":
						if (!this.etudiant.Anneebac) {
						this.errors.Anneebac = "Année de bac est requis.";
						} else {
						this.errors.Anneebac = null;
						}
						break;



					case "dernier_diplome_obtenu":
						if (!this.etudiant.dernier_diplome_obtenu) {
						this.errors.dernier_diplome_obtenu = "Ce champs est requis.";
						} else {
						this.errors.dernier_diplome_obtenu = null;
						}
						break;

                        case "type_diplome_obtenu":
                            if (!this.etudiant.type_diplome_obtenu) {
                                this.errors.type_diplome_obtenu = "Ce champ est requis.";
                            } else if (
                                this.etudiant.type_diplome_obtenu !== "AUTRES" &&
                                !/^[A-Za-zÀ-ÖØ-öø-ÿ0-9\s\(\)\-]{2,200}$/.test(this.etudiant.type_diplome_obtenu)
                            ) {
                                this.errors.type_diplome_obtenu =
                                    "Ce champ doit contenir entre 2 et 200 caractères, et doit être écrit uniquement en français.";
                            } else {
                                this.errors.type_diplome_obtenu = null;
                            }
                            break;

					case "specialitediplome":
						if (!this.etudiant.specialitediplome) {
						this.errors.specialitediplome = "Le spécialité du diplome est requis.";
						}else if (/[^A-Za-zÀ-ÿ0-9\s\-'.]/.test(this.etudiant.specialitediplome)) {
						this.errors.specialitediplome = "Ce champs doit être écrit uniquement en français.";
						} else if (this.etudiant.specialitediplome.length < 2 || this.etudiant.specialitediplome.length > 200) {
						this.errors.specialitediplome = "Ce champs doit contenir entre 2 et 200 caractères alphanumériques.";
						} else {
						this.errors.specialitediplome = null;
						}
						break;

					// case "etblsmtdeug":
					// 	if (!this.etudiant.etblsmtdeug) {
					// 	this.errors.etblsmtdeug = "Ce champs est requis.";
					// 	}else if (/[^A-Za-zÀ-ÿ0-9\s\-'.]/.test(this.etudiant.etblsmtdeug)) {
					// 	this.errors.etblsmtdeug = "Ce champs doit être écrit uniquement en français.";
					// 	} else if (this.etudiant.etblsmtdeug.length < 2 || this.etudiant.etblsmtdeug.length > 200) {
					// 	this.errors.etblsmtdeug = "Ce champs doit contenir entre 2 et 200 caractères alphanumériques.";
					// 	} else {
					// 	this.errors.etblsmtdeug = null;
					// 	}
					// 	break;

					case "ville_etablissement_diplome":
						if (!this.etudiant.ville_etablissement_diplome) {
						this.errors.ville_etablissement_diplome = "Ce champs est requis.";
						}else if (/[^A-Za-zÀ-ÿ0-9\s\-'.]/.test(this.etudiant.ville_etablissement_diplome)) {
						this.errors.ville_etablissement_diplome = "Ce champs doit être écrit uniquement en français.";
						} else if (this.etudiant.ville_etablissement_diplome.length < 2 || this.etudiant.ville_etablissement_diplome.length > 150) {
						this.errors.ville_etablissement_diplome = "Ce champs doit contenir entre 2 et 150 caractères alphanumériques.";
						} else {
						this.errors.ville_etablissement_diplome = null;
						}
						break;

					case "date_optention_diplome":
						if (!this.etudiant.date_optention_diplome) {
						this.errors.date_optention_diplome = "Ce champs est requis.";
						} else {
						this.errors.date_optention_diplome = null;
						}
						break;

						case "fonctionnaire":
							if (!this.etudiant.fonctionnaire) {
								this.errors.fonctionnaire = "Ce champ est requis.";
							} else {
								this.errors.fonctionnaire = null;
								// Si "NON" est sélectionné, vider les autres champs
								if (this.etudiant.fonctionnaire === "NON") {
									this.etudiant.secteur = "";
									this.etudiant.nombreannee = "";
									this.etudiant.poste = "";
									this.etudiant.lieutravail = "";
									this.etudiant.villetravail = "";
									this.errors.secteur = null;
									this.errors.nombreannee = null;
									this.errors.poste = null;
									this.errors.lieutravail = null;
									this.errors.villetravail = null;
								}
							}
							break;

						case "secteur":
							if (this.etudiant.fonctionnaire === "OUI") {
							if (!this.etudiant.secteur) {
							this.errors.secteur = "Ce champ est requis.";
							} else if (this.etudiant.secteur.length < 2 || this.etudiant.secteur.length > 200) {
							this.errors.secteur = "Le secteur doit contenir entre 2 et 200 caractères.";
							} else {
							this.errors.secteur = null;
							}
							}
							break;

						case "nombreannee":
							if (this.etudiant.fonctionnaire === "OUI") {
							if (!this.etudiant.nombreannee) {
							this.errors.nombreannee = "Ce champ est requis.";
							} else if (!Number.isInteger(Number(this.etudiant.nombreannee))) {
							this.errors.nombreannee = "Entrez un nombre entier valide.";
							} else if (this.etudiant.nombreannee < 0) {
							this.errors.nombreannee = "Le nombre d'années ne peut pas être négatif.";
							} else {
							this.errors.nombreannee = null;
							}
							}
							break;

						case "poste":
							if (this.etudiant.fonctionnaire === "OUI") {
							if (!this.etudiant.poste) {
							this.errors.poste = "Ce champ est requis.";
							} else if (this.etudiant.poste.length < 2 || this.etudiant.poste.length > 200) {
							this.errors.poste = "Le poste doit contenir entre 2 et 200 caractères.";
							} else {
							this.errors.poste = null;
							}
							}
							break;

						case "lieutravail":
							if (this.etudiant.fonctionnaire === "OUI") {
							if (!this.etudiant.lieutravail) {
							this.errors.lieutravail = "Ce champ est requis.";
							} else if (this.etudiant.lieutravail.length < 2 || this.etudiant.lieutravail.length > 200) {
							this.errors.lieutravail = "Le lieu de travail doit contenir entre 2 et 200 caractères.";
							} else {
							this.errors.lieutravail = null;
							}
							}
							break;

						case "villetravail":
							if (this.etudiant.fonctionnaire === "OUI") {
							if (!this.etudiant.villetravail) {
							this.errors.villetravail = "Ce champ est requis.";
							} else if (this.etudiant.villetravail.length < 2 || this.etudiant.villetravail.length > 200) {
							this.errors.villetravail = "La ville de travail doit contenir entre 2 et 200 caractères.";
							} else {
							this.errors.villetravail = null;
							}
							}
           					break;

						case "type_bac":
							if (!this.etudiant.type_bac) {
								this.errors.type_bac = "Veuillez sélectionner ce champs.";
							} else {
								this.errors.type_bac = null;
							}
							break;

				}
			}

			if(this.currentStep == 3){
				//empty
			}

			if(this.currentStep == 4){
				if(this.etablissement.multiple_choix_filiere_passerelle == 0){
					switch (field) {
						case "filiere":
							if (!this.etudiant.filiere) {
							this.errors.filiere = "Le choix d'une seule filière est requis. Veuillez sélectionner une seule filière.";
							} else {
							this.errors.filiere = null;
							}
							break;

						default:
							break;
					}
				}else{
					switch (field) {
						case "filiere_choix_1":
							if (!this.etudiant.filiere_choix_1) {
							this.errors.filiere_choix_1 = "Le choix de trois filières est requis. Veuillez sélectionner trois filières.";
							} else {
							this.errors.filiere_choix_1 = null;
							}
							break;

						case "filiere_choix_2":
							if (!this.etudiant.filiere_choix_2) {
							this.errors.filiere_choix_2 = "Il vous reste deux filières à sélectionner.";
							} else {
							this.errors.filiere_choix_2 = null;
							}
							break;

						case "filiere_choix_3":
							if (!this.etudiant.filiere_choix_3) {
							this.errors.filiere_choix_3 = "Il vous reste une seule filière à sélectionner.";
							} else {
							this.errors.filiere_choix_3 = null;
							}
							break;
						default:
							break;
					}
				}
			}

			if(this.currentStep == 5){
				//empty
			}
  		},
		validateStepp() {
			this.errors = {};

			if(this.currentStep == 1){
				if (!this.etudiant.CNE) {
				this.errors.CNE = "Le CNE est requis.";
				} else if (!/^[A-Za-z0-9]{7,20}$/.test(this.etudiant.CNE)) {
				this.errors.CNE = "Le CNE doit contenir entre 7 et 20 caractères alphanumériques.";
				} else {
				this.errors.CNE = null;
				}

				if (!this.etudiant.CIN) {
				this.errors.CIN = "Le CIN est requis.";
				} else if (!/^[A-Za-z0-9]{3,10}$/.test(this.etudiant.CIN)) {
				this.errors.CIN = "Le CIN doit contenir entre 3 et 10 caractères alphanumériques.";
				} else {
				this.errors.CIN = null;
				}

				if (!this.etudiant.nom) {
				this.errors.nom = "Le nom est requis.";
				}else if (/[^A-Za-zÀ-ÿ0-9\s\-'.]/.test(this.etudiant.nom)) {
					this.errors.nom = "Le nom doit être écrit uniquement en français.";
				}else if (this.etudiant.nom.length < 2 || this.etudiant.nom.length > 50) {
				this.errors.nom = "Le nom doit contenir entre 2 et 50 caractères";
				} else {
				this.errors.nom = null;
				}

				if (!this.etudiant.prenom) {
				this.errors.prenom = "Le prénom est requis.";
				}else if (/[^A-Za-zÀ-ÿ0-9\s\-'.]/.test(this.etudiant.prenom)) {
					this.errors.prenom = "Le prenom doit être écrit uniquement en français.";
				} else if (this.etudiant.prenom.length < 2 || this.etudiant.prenom.length > 50) {
				this.errors.prenom = "Le prenom doit contenir entre 2 et 50 caractères";
				} else {
				this.errors.prenom = null;
				}

				if (!this.etudiant.nomar) {
				this.errors.nomar = "الاسم العائلي مطلوب";
				} else if (this.etudiant.nomar.length < 2 || this.etudiant.nomar.length > 50) {
				this.errors.nomar = "يجب أن يحتوي الاسم العائلي على ما بين 2 و 50 حرفًا.";
				} else if (!/^[\u0621-\u064A\u0660-\u0669\s]+$/i.test(this.etudiant.nomar)) {
				this.errors.nomar = "يرجى إدخال الاسم العائلي باللغة العربية فقط";
				} else {
				this.errors.nomar = null;
				}

				if (!this.etudiant.prenomar) {
				this.errors.prenomar = "الاسم الشخصي مطلوب";
				} else if (this.etudiant.prenomar.length < 2 || this.etudiant.prenomar.length > 50) {
				this.errors.prenomar = "يجب أن يحتوي الاسم الشخصي على ما بين 2 و 50 حرفًا.";
				} else if (!/^[\u0621-\u064A\u0660-\u0669\s]+$/i.test(this.etudiant.prenomar)) {
				this.errors.prenomar = "يرجى إدخال الاسم الشخصي باللغة العربية فقط";
				} else {
				this.errors.prenomar = null;
				}

				if (!this.etudiant.datenais) {
				this.errors.datenais = "La date de naissance est requis.";
				} else {
				this.errors.datenais = null;
				}

				if (!this.etudiant.sexe) {
				this.errors.sexe = "Le sexe est requis.";
				} else {
				this.errors.sexe = null;
				}

				if (!this.etudiant.payschamp) {
				this.errors.payschamp = "Le nom du pays est requis.";
				}else if (/[^A-Za-zÀ-ÿ0-9\s\-'.]/.test(this.etudiant.payschamp)) {
					this.errors.payschamp = "Le nom du pays doit être écrit uniquement en français.";
				} else if (this.etudiant.payschamp.length < 2 || this.etudiant.payschamp.length > 70) {
				this.errors.payschamp = "Le nom du pays doit contenir entre 2 et 70 caractères.";
				} else {
				this.errors.payschamp = null;
				}

				if (!this.etudiant.villenais) {
				this.errors.villenais = "Le nom de la ville est requis.";
				}else if (/[^A-Za-zÀ-ÿ0-9\s\-'.]/.test(this.etudiant.villenais)) {
					this.errors.villenais = "Le nom de la ville doit être écrit uniquement en français.";
				} else if (this.etudiant.villenais.length < 2 || this.etudiant.villenais.length > 70) {
				this.errors.villenais = "Le nom de la ville doit contenir entre 2 et 70 caractères.";
				} else {
				this.errors.villenais = null;
				}

				if (!this.etudiant.villechamp) {
				this.errors.villechamp = "مكان الازدياد مطلوب";
				} else if (this.etudiant.villechamp.length < 2 || this.etudiant.villechamp.length > 70) {
				this.errors.villechamp = "يجب أن يحتوي مكان الازدياد على ما بين 2 و 70 حرفًا.";
				} else if (!/^[\u0621-\u064A\u0660-\u0669\s]+$/i.test(this.etudiant.villechamp)) {
				this.errors.villechamp = "يرجى إدخال مكان الازدياد باللغة العربية فقط";
				} else {
				this.errors.villechamp = null;
				}

				if (!this.etudiant.adresse) {
					this.errors.adresse = "L'adresse est requise.";
				} else if (/[^A-Za-zÀ-ÿ0-9\s-]/.test(this.etudiant.adresse)) {
					this.errors.adresse = "L'adresse doit être écrite uniquement en français et peut contenir des chiffres.";
				} else if (this.etudiant.adresse.length < 10 || this.etudiant.adresse.length > 250) {
					this.errors.adresse = "L'adresse doit contenir entre 10 et 250 caractères.";
				} else {
					this.errors.adresse = null;
				}

				if (!this.etudiant.email) {
				this.errors.email = "L'email est requis.";
				}else if (!/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,100}$/.test(this.etudiant.email)) {
					this.errors.email = "Veuillez saisir une adresse email valide, en évitant les espaces au début et à la fin.";
				} else {
				this.errors.email = null;
				}

				if (!this.etudiant.phone) {
					this.errors.phone = "Le téléphone est requis.";
				} else if (!/^\d{10}$/.test(this.etudiant.phone)) {
					this.errors.phone = "Le téléphone doit contenir exactement 10 chiffres, en évitant les espaces au début et à la fin.";
				} else {
					this.errors.phone = null;
				}


			}
			if(this.currentStep == 2){
				if (!this.etudiant.serie) {
                    this.errors.serie = "Série de bac est requise.";
                } else if (
                    this.etudiant.serie !== "AUTRES" &&
                    !/^[A-Za-zÀ-ÖØ-öø-ÿ0-9\s\(\)\-]{2,200}$/.test(this.etudiant.serie)
                ) {
                    this.errors.serie =
                        "Ce champ doit contenir entre 2 et 200 caractères, et doit être écrit uniquement en français.";
                } else {
                    this.errors.serie = null;
                }

				if (!this.etudiant.Anneebac) {
				this.errors.Anneebac = "Année de bac est requis.";
				} else {
				this.errors.Anneebac = null;
				}



				if (!this.etudiant.dernier_diplome_obtenu) {
				this.errors.dernier_diplome_obtenu = "Ce champs est requis.";
				} else {
				this.errors.dernier_diplome_obtenu = null;
				}

				if (!this.etudiant.type_diplome_obtenu) {
                    this.errors.type_diplome_obtenu = "Ce champ est requis.";
                } else if (
                    this.etudiant.type_diplome_obtenu !== "AUTRES" &&
                    !/^[A-Za-zÀ-ÖØ-öø-ÿ0-9\s\(\)\-]{2,200}$/.test(this.etudiant.type_diplome_obtenu)
                ) {
                    this.errors.type_diplome_obtenu =
                        "Ce champ doit contenir entre 2 et 200 caractères, et doit être écrit uniquement en français.";
                } else {
                    this.errors.type_diplome_obtenu = null;
                }

				if (!this.etudiant.specialitediplome) {
				this.errors.specialitediplome = "Le spécialité du diplome est requis.";
				}else if (/[^A-Za-zÀ-ÿ0-9\s\-'.]/.test(this.etudiant.specialitediplome)) {
				this.errors.specialitediplome = "Ce champs doit être écrit uniquement en français.";
				} else if (this.etudiant.specialitediplome.length < 2 || this.etudiant.specialitediplome.length > 200) {
				this.errors.specialitediplome = "Ce champs doit contenir entre 2 et 200 caractères alphanumériques.";
				} else {
				this.errors.specialitediplome = null;
				}


				if (!this.etudiant.ville_etablissement_diplome) {
				this.errors.ville_etablissement_diplome = "Ce champs est requis.";
				}else if (/[^A-Za-zÀ-ÿ0-9\s\-'.]/.test(this.etudiant.ville_etablissement_diplome)) {
				this.errors.ville_etablissement_diplome = "Ce champs doit être écrit uniquement en français.";
				} else if (this.etudiant.ville_etablissement_diplome.length < 2 || this.etudiant.ville_etablissement_diplome.length > 150) {
				this.errors.ville_etablissement_diplome = "Ce champs doit contenir entre 2 et 150 caractères alphanumériques.";
				} else {
				this.errors.ville_etablissement_diplome = null;
				}

				if (!this.etudiant.date_optention_diplome) {
				this.errors.date_optention_diplome = "Ce champs est requis.";
				} else {
				this.errors.date_optention_diplome = null;
				}



				if (!this.etudiant.fonctionnaire) {
					this.errors.fonctionnaire = "Ce champ est requis.";
				} else {
					this.errors.fonctionnaire = null;
					// Si "NON" est sélectionné, vider les autres champs
					if (this.etudiant.fonctionnaire === "NON") {
						this.etudiant.secteur = "";
						this.etudiant.nombreannee = "";
						this.etudiant.poste = "";
						this.etudiant.lieutravail = "";
						this.etudiant.villetravail = "";
						this.errors.secteur = null;
						this.errors.nombreannee = null;
						this.errors.poste = null;
						this.errors.lieutravail = null;
						this.errors.villetravail = null;
					}
				}
				if (this.etudiant.fonctionnaire === "OUI") {
					if (!this.etudiant.secteur) {
					this.errors.secteur = "Ce champ est requis.";
					} else if (this.etudiant.secteur.length < 2 || this.etudiant.secteur.length > 200) {
					this.errors.secteur = "Le secteur doit contenir entre 2 et 200 caractères.";
					} else {
					this.errors.secteur = null;
					}
				}

				if (this.etudiant.fonctionnaire === "OUI") {
					if (!this.etudiant.nombreannee) {
					this.errors.nombreannee = "Ce champ est requis.";
					} else if (!Number.isInteger(Number(this.etudiant.nombreannee))) {
					this.errors.nombreannee = "Entrez un nombre entier valide.";
					} else if (this.etudiant.nombreannee < 0) {
					this.errors.nombreannee = "Le nombre d'années ne peut pas être négatif.";
					} else {
					this.errors.nombreannee = null;
					}
				}

				if (this.etudiant.fonctionnaire === "OUI") {
					if (!this.etudiant.poste) {
					this.errors.poste = "Ce champ est requis.";
					} else if (this.etudiant.poste.length < 2 || this.etudiant.poste.length > 200) {
					this.errors.poste = "Le poste doit contenir entre 2 et 200 caractères.";
					} else {
					this.errors.poste = null;
					}
				}
				if (this.etudiant.fonctionnaire === "OUI") {
					if (!this.etudiant.lieutravail) {
					this.errors.lieutravail = "Ce champ est requis.";
					} else if (this.etudiant.lieutravail.length < 2 || this.etudiant.lieutravail.length > 200) {
					this.errors.lieutravail = "Le lieu de travail doit contenir entre 2 et 200 caractères.";
					} else {
					this.errors.lieutravail = null;
					}
				}

				if (this.etudiant.fonctionnaire === "OUI") {
					if (!this.etudiant.villetravail) {
					this.errors.villetravail = "Ce champ est requis.";
					} else if (this.etudiant.villetravail.length < 2 || this.etudiant.villetravail.length > 200) {
					this.errors.villetravail = "La ville de travail doit contenir entre 2 et 200 caractères.";
					} else {
					this.errors.villetravail = null;
					}
				}




			}

			if (this.currentStep == 3) {
				const fileFields = [

				];

				if (this.etablissement.show_photo_input_passerelle) {
					fileFields.push("path_photo");
				}

				if (this.etablissement.show_cin_input_passerelle) {
					fileFields.push("path_cin");
				}

				if (this.etablissement.show_bac_input_passerelle) {
					fileFields.push("path_bac");
				}

				if (this.etablissement.show_diplome_deug_input_passerelle) {
					fileFields.push("path_diplomedeug");
				}

				if (this.etablissement.show_attestation_no_emploi_input_passerelle) {
					fileFields.push("path_attestation_non_emploi");
				}

				fileFields.forEach((path) => {
					const file = this.etudiant[path];

					// Check if a file is selected
					if (!file || !file.preview) {
						this.errors[path] = "Ce fichier est requis.";
					} else {
						// Validate file type (Only images allowed)
						const allowedTypes = ["image/jpeg", "image/png", "image/jpg"];
						if (!allowedTypes.includes(file.file.type)) {
							this.errors[path] = "Seules les images (.jpg, .jpeg, .png) sont autorisées.";
						}


						// Validate file size (Max 300 Ko)
						const maxSize = 300 * 1024; // 300 Ko in bytes
						if (file.size > maxSize) {
							this.errors[path] = "Le fichier ne doit pas dépasser 300 Ko.";
						}
					}
				});


				// Validation for CV PDF
				if(this.etablissement.show_cv_input_passerelle){
					const cvFile = this.etudiant["path_cv"];
					if (!cvFile || !cvFile.preview) {
						this.errors["path_cv"] = "Le CV est requis.";
					} else {
						// Validate file type (Only PDF allowed)
						if (cvFile.file.type !== "application/pdf") {
							this.errors["path_cv"] = "Seul le format PDF est autorisé.";
						}

						// Validate file size (Max 2 MB)
						const maxCVSize = 2 * 1024 * 1024; // 2 MB in bytes
						if (cvFile.size > maxCVSize) {
							this.errors["path_cv"] = "Le fichier ne doit pas dépasser 2 Mo.";
						}
					}
				}
				console.log(fileFields)
				console.log(this.errors)
			}


			if(this.currentStep == 4){
				if(this.etablissement.multiple_choix_filiere_passerelle == 0){
					if (!this.etudiant.filiere) {
						this.errors.filiere = "Le choix d'une seule filière est requis. Veuillez sélectionner une seule filière.";
					} else {
						this.errors.filiere = null;
					}
				}else{
					if (!this.etudiant.filiere_choix_1) {
						this.errors.filiere_choix_1 = "Le choix de trois filières est requis. Veuillez sélectionner trois filières.";
					} else {
						this.errors.filiere_choix_1 = null;
					}
					if (!this.etudiant.filiere_choix_2) {
						this.errors.filiere_choix_2 = "Le choix de trois filières est requis. Veuillez sélectionner trois filières.";
					} else {
						this.errors.filiere_choix_2 = null;
					}
					if (!this.etudiant.filiere_choix_3) {
						this.errors.filiere_choix_3 = "Le choix de trois filières est requis. Veuillez sélectionner trois filières.";
					} else {
						this.errors.filiere_choix_3 = null;
					}
				}
			}

			if(this.currentStep == 5){
				if (!this.etudiant.confirmation) {
					this.errors.confirmation = "L'inscription ne peut pas être validée sans confirmation. Veuillez cocher la case pour continuer.";
				} else {
					this.errors.confirmation = null;
				}
			}

			return !Object.values(this.errors).some(error => error !== null);
    	},
		nextStep() {
			// if(this.currentStep == 1 || this.currentStep == 2 || this.currentStep == 2){
			// 	if (this.currentStep < this.steps.length) {
			// 		this.currentStep++;
			// 		// document.querySelector('.section-title')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
			// 	}
			// }
			// else{
				if (this.validateStepp()) {
					if (this.currentStep < this.steps.length) {
						document.querySelector('.section-title')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
						this.currentStep++;
					}else{
						console.log('submit')
						this.submitForm();
					}
				}else{
					this.$nextTick(() => {
						const firstErrorField = document.querySelector('.input-error');
						if (firstErrorField) {
							firstErrorField.scrollIntoView({ behavior: 'smooth', block: 'center' });
							firstErrorField.focus();
						}
					});
				}
			// }
		},
		prevStep() {
			if (this.currentStep > 1) {
				document.querySelector('.section-title')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
				this.currentStep--;
			}
		},
		clearError(field) {
			this.errors[field] = null;
		},
		goToStep(step) {
			if (step <= this.currentStep) {
				this.currentStep = step;
			}
		},
		async submitForm() {
			this.loading = true; // Show loading screen

			try {

				if (!this.etablissement.show_photo_input_passerelle) {
					this.etudiant.path_photo = null
				}

				if (!this.etablissement.show_cin_input_passerelle) {
					this.etudiant.path_cin = null
				}

				if (!this.etablissement.show_bac_input_passerelle) {
					this.etudiant.path_bac = null
				}

				if (!this.etablissement.show_diplome_deug_input_passerelle) {
					this.etudiant.path_diplomedeug = null
				}

				if (!this.etablissement.show_attestation_no_emploi_input_passerelle) {
					this.etudiant.path_attestation_non_emploi = null
				}

				if(!this.etablissement.show_cv_input_passerelle){
					this.etudiant.path_cv = null
				}

				let formData = new FormData();

				// Append text fields
				for (let key in this.etudiant) {
					if (this.etudiant[key] !== null && this.etudiant[key] !== undefined && !(this.etudiant[key] instanceof File)) {
						formData.append(key, this.etudiant[key]);
					}
				}

				// Append files to FormData
				const fileFields = [

				];

				if (this.etablissement.show_photo_input_passerelle) {
					fileFields.push("path_photo");
				}

				if (this.etablissement.show_cin_input_passerelle) {
					fileFields.push("path_cin");
				}

				if (this.etablissement.show_bac_input_passerelle) {
					fileFields.push("path_bac");
				}

				if (this.etablissement.show_diplome_deug_input_passerelle) {
					fileFields.push("path_diplomedeug");
				}

				if (this.etablissement.show_attestation_no_emploi_input_passerelle) {
					fileFields.push("path_attestation_non_emploi");
				}

				if(this.etablissement.show_cv_input_passerelle){
					fileFields.push("path_cv");
				}

				fileFields.forEach(path => {
					const fileData = this.etudiant[path];
					if (fileData && fileData.file instanceof File) {
						formData.append(path, fileData.file, fileData.file.name);  // Append the actual file
					} else {
						console.warn(`⚠️ File missing or invalid for: ${path}`);
					}
				});


				// Debugging: Log formData entries to the console
				// for (let pair of formData.entries()) {
				// 	console.log(pair[0], pair[1]);
				// }

				// Send form data
				const response = await axios.post("/api/submit/form/licencexcellence", formData, {
					headers: {
						"Content-Type": "multipart/form-data",
					},
				});

				if (response.data.status == 1) {
					this.successForm = true;
				} else {
					this.$refs.errorPopup.show("Une erreur au niveau du serveur est survenue.");
				}
			} catch (error) {
				console.error("Error submitting form:", error);
				if (error.response && error.response.data && error.response.data.errors) {
					const errorMessages = Object.values(error.response.data.errors).flat();
					this.$refs.errorPopup.show(errorMessages[0]);
				} else {
					this.$refs.errorPopup.show("Une erreur au niveau du serveur est survenue.");
				}
			} finally {
				this.loading = false; // Hide loading screen
			}
		},

		togglePassword() {
			this.showPassword = !this.showPassword;
		},

	},
	mounted() {
		this.etudiant.CNE = this.cne
		this.etudiant.CIN = this.cin
		this.serie_bac = this.etablissement.serie_bac
		this.etudiant.etablissement_id = this.etablissement.id
		this.diplomeBacPlus2 = this.etablissement.diplomebacplus2
		// console.log(this.appurl)
		// console.log(this.cne)
		// console.log(this.cin)
		// console.log(this.etablissement)
	},
  };
</script>

<style>
  body {
	background: linear-gradient(135deg, #f0f8ff, #e6f7ff);
	font-family: "Roboto", sans-serif;
	margin: 0;
	padding: 0;
  }

  .form-container {
	max-width: 800px;
	margin: 2rem auto;
	background: #ffffff;
	border-radius: 15px;
	box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
	overflow: hidden;
  }

  .progress-bar-container {
	height: 8px;
	background: #ddd;
	width: 100%;
  }

  .progress-bar {
	height: 8px;
	background: #007bff;
	transition: width 0.3s ease-in-out;
  }

  .form-header {
	text-align: center;
	background: #0056b3;
	color: white;
	padding: 2rem;
  }

  .logo-container {
	background: white;
	border-radius: 50%;
	padding: 1rem;
	display: inline-block;
	box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  }

  .form-logo {
	width: 100px;
  }

  .form-title {
	font-size: 2.5rem;
	font-weight: bold;
  }

  .form-subtitle {
	font-size: 1.1rem;
	color: #ccc;
  }
  .progress-steps {
		display: flex;
		justify-content: space-between;
		align-items: flex-start; /* Aligns circles and labels better */
		padding: 2rem 1rem;
		background-color: #f9f9f9;
		border-radius: 10px;
		gap: 2rem; /* Adds space between steps */
	}

	.step {
		display: flex;
		flex-direction: column;
		align-items: center;
		position: relative;
		flex-grow: 1;
		cursor: pointer; /* Makes steps clickable */
		transition: transform 0.3s ease, box-shadow 0.3s ease;
	}

	.step:hover {
		transform: translateY(-5px); /* Subtle hover effect */
		box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15); /* Add shadow for hover */
	}


	.step-circle {
		width: 50px;
		height: 50px;
		border-radius: 50%;
		background-color: #ddd;
		margin-bottom: 8px;
		display: flex;
		align-items: center;
		justify-content: center;
		font-size: 1.4rem;
		font-weight: bold;
		color: #666;
		transition: all 0.4s ease;
		box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
	}

	.step-icon {
		transition: color 0.3s ease;
	}

	.step-label {
		font-size: 1rem;
		font-weight: bold;
		color: #555;
		margin-top: 8px;
		text-align: center; /* Center-align the text */
		white-space: pre-line; /* Preserve line breaks */
		line-height: 1.4; /* Adjust line height for better spacing */
	}
	.step-line {
		display: block; /* Ensure each line is a block */
	}



	.step.completed .step-circle {
		background-color: #28a745;
	}

	.step.active .step-circle {
		background-color: #007bff;
		transform: scale(1.1);
		transform: scale(1.2);
		box-shadow: 0 4px 15px rgba(0, 123, 255, 0.3);
	}

	.step:not(:last-child)::after {
		content: '';
		position: absolute;
		top: 50%;
		right: 0;
		width: 100%; /* Full width of the space between steps */
		height: 3px;
		background-color: #ddd;
		z-index: -1; /* Keep the line behind the circles */
		transition: background-color 0.3s ease;
	}

	.step.completed:not(:last-child)::after {
		background-color: #28a745;
	}

	.step.active:not(:last-child)::after {
		background-color: #007bff;
	}

	.step.completed .step-icon {
		color: white;
	}


	.step.active .step-icon {
		color: white;
	}



	.step.completed::after {
		background-color: #28a745;
	}

	.step:hover .step-circle {
		background-color: #007bff;
		transform: scale(1.1);
	}

	.step:hover .step-icon {
		color: white;
	}

	.step:hover .step-label {
		color: #007bff;
	}

	.progress-tooltip {
		display: inline-block;
		font-size: 0.85rem;
		font-weight: 500;
		color: #fff;
		background: #007bff;
		border-radius: 4px;
		padding: 4px 8px;
		margin-top: 25px;
		position: absolute;
		left: 50%;
		transform: translateX(-50%);
		opacity: 0;
		visibility: hidden;
		transition: opacity 0.3s ease, visibility 0.3s ease;
		box-shadow: 0 2px 8px rgba(0, 123, 255, 0.4);
	}

	.step:hover .progress-tooltip {
		opacity: 1;
		visibility: visible;
	}


	.step.completed .step-icon,
	.step.active .step-icon {
		color: white;
	}

	.step-label:hover {
	color: #007bff; /* Highlight color */
	transform: scale(1.05);
	}


	.step-label:hover .progress-tooltip {
	opacity: 1;
	visibility: visible;
	margin-top: 12px;
	}




  .form-body {
	padding: 2rem;
  }

  .section-title {
	font-size: 1.5rem;
	margin-bottom: 1rem;
  }

  .form-group {
	margin-bottom: 1.5rem;
  }

  	input[type="text"],
	input[type="date"],
	input[type="number"],
	select,
	textarea {
		width: 100%;
		padding: 0.8rem;
		border: 1px solid #ddd;
		border-radius: 8px;
		font-size: 1rem;
		margin-top: 0.5rem;
		transition: border-color 0.3s ease;
	}

	/* Focus styles */
	input[type="text"]:focus,
	input[type="date"]:focus,
	input[type="number"]:focus,
	select:focus,
	textarea:focus {
		border-color: #007bff;
	}

  .input-error {
	border: 1px solid #e3342f !important;
  }

  .error-icon {
	color: #e3342f;
	font-size: 0.8rem;
  }

  .form-actions {
	display: flex;
	justify-content: space-between;
	margin-top: 1.5rem;
  }

  button {
	padding: 0.8rem 2rem;
	font-size: 1rem;
	border-radius: 8px;
	border: none;
	cursor: pointer;
  }

  button.btn-primary {
	background-color: #007bff;
	color: white;
	transition: background-color 0.3s;
  }

  button.btn-primary:hover {
	background-color: #0056b3;
  }

  button.btn-secondary {
	background-color: #f0f0f0;
	color: #555;
	transition: background-color 0.3s;
  }

  button.btn-secondary:hover {
	background-color: #ddd;
  }


  @media (max-width: 768px) {
  .form-container {
    padding: 1rem;
    margin: 1rem;
  }

  .progress-steps {
    flex-direction: column;
    gap: 1.5rem;
  }

  .step {
    width: 100%;
  }

  .form-header {
    padding: 1rem;
  }

  .form-title {
    font-size: 2rem;
  }

  .form-subtitle {
    font-size: 1rem;
  }

  .form-body {
    padding: 1rem;
  }

  .section-title {
    font-size: 1.25rem;
  }

  button {
    width: 100%;
    padding: 1rem;
  }
}

@media (max-width: 480px) {
  .form-logo {
    width: 80px;
  }

  .form-title {
    font-size: 1.75rem;
  }

  .form-subtitle {
    font-size: 0.9rem;
  }

  .progress-tooltip {
    font-size: 0.75rem;
    padding: 4px 6px;
	position: absolute;
    top: 73%;
  }
}



/* Style for the form group */
.form-group {
  margin-bottom: 1.5rem;
  position: relative;
}


/* Change border color when there is an error */
input[type="text"].input-error {
  border-color: #e74c3c; /* Red border for error */
}

/* Style for the error message */
.error-message {
  color: #e74c3c; /* Red color for error text */
  font-size: 14px;
  margin-top: 5px;
  display: block;
  font-weight: 600;
  padding-left: 5px;
}

/* Add some styles for the input focus */
input[type="text"]:focus {
  outline: none;
  border-color: #3498db; /* Blue border when focused */
}

/* Add some styling to the label */
label {
  font-size: 14px;
  margin-bottom: 0px;
  font-weight: 600;
  color: #333;
}


/* Apply RTL to the entire form group */
.form-group[dir="rtl"] {
  text-align: right !important;  /* Align text to the right */
  direction: rtl !important;     /* Set the direction of the form group to RTL */
}

/* Apply RTL to Arabic labels */
.form-group[dir="rtl"] .rtl-label {
  text-align: right !important;
  direction: rtl !important;
}

/* Apply RTL to input fields within Arabic form groups */
.form-group[dir="rtl"] input {
  text-align: right !important;  /* Align text to the right for RTL inputs */
  direction: rtl !important;     /* Set input direction to RTL */
}

/* Apply RTL to error messages within Arabic form groups */
.form-group[dir="rtl"] .error-message {
  text-align: right !important;
  direction: rtl !important;
}

/* Ensure French inputs remain left-aligned (default behavior) */
input:not([dir="rtl"]) {
  text-align: left;
  direction: ltr;
}

  .close-icon {
    position: absolute;
    top: 50%;
    right: 0.5rem;
    transform: translateY(-50%);
    width: 1.5rem;
    height: 1.5rem;
    display: flex;
    justify-content: center;
    align-items: center;
    background: linear-gradient(135deg, #ff6b6b, #ff4757);
    border-radius: 50%;
    cursor: pointer;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
  }

  .close-icon span {
    color: white;
    font-size: 1.2rem;
    font-weight: bold;
    line-height: 1;
  }




/* Fieldset Styling */
fieldset {
  border: 2px solid #0078d7;
  border-radius: 15px;
  padding: 25px 20px;
  background: #f5f8fa;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  margin-bottom: 30px;
  position: relative;
  overflow: hidden; /* Ensures cleaner clipping */
}

/* Legend Styling */
legend {
  text-align: right;
  font-size: 1.2rem;
  font-weight: 600;
  color: #ffffff;
  background: #0078d7;
  padding: 10px 20px;
  border-radius: 8px;
  text-transform: uppercase;
  position: absolute;
  top: -11px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  white-space: nowrap; /* Prevents wrapping */
}

.legend1{
	left: -365px;
}

.legend2{
	left: -460px;
}

.legend3{
	left: -440px;
  }

  .legend4{
	left: -573px;
  }

  .legend5{
	left: -630px;
  }

/* Hover Effect on Fieldset */
fieldset:hover {
  border-color: #0056a6;
  box-shadow: 0 6px 14px rgba(0, 0, 0, 0.15);
}

/* Responsive Adjustments */
@media (max-width: 768px) {
  legend {
    text-align: right;
    font-size: 0.8rem;
    font-weight: 600;
    color: #ffffff;
    background: #0078d7;
    padding: 10px 20px;
    border-radius: 8px;
    text-transform: uppercase;
    position: absolute;
    top: -7px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    white-space: nowrap;
  }

  .legend1{
	left: -46px;
  }

  .legend2{
	left: -110px;
  }

  .legend3{
	left: -95px;
  }
}



/* Style de la notification */
.notification {
  position: fixed;
  top: 20px;
  right: 20px;
  background: #007bff;
  color: white;
  padding: 15px;
  border-radius: 8px;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
  max-width: 320px;
  font-size: 14px;
  display: flex;
  align-items: center;
  gap: 10px;
  z-index: 1000;
  animation: fadeIn 0.3s ease-in-out;
}

/* Style du texte dans la notification */
.notification p {
  margin: 0;
  flex: 1;
}

/* Style du bouton */
.notification button {
  background: white;
  color: #007bff;
  border: none;
  padding: 5px 10px;
  border-radius: 5px;
  cursor: pointer;
  font-weight: bold;
}

.notification button:hover {
  background: #f1f1f1;
}

/* Responsive design */
@media (max-width: 768px) {
  .notification {
    top: auto;
    bottom: 20px;
    right: 10px;
    left: 10px;
    width: auto;
    max-width: none;
    font-size: 13px;
    padding: 12px;
    flex-direction: column;
    text-align: center;
  }

  .notification button {
    margin-top: 5px;
    width: 100%;
  }
}

/* Animation */
@keyframes fadeIn {
  from {
    opacity: 0;
    transform: translateY(-10px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}




/* Wrapper for the file input */
.file-upload-wrapper {
  position: relative;
  display: inline-block;
  width: 100%;
  text-align: left;
  background-color: #f9f9f9;
  border-radius: 12px;
  padding: 20px;
  border: 2px solid #ccc;
  transition: all 0.3s ease-in-out;
  box-sizing: border-box;
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
  background: linear-gradient(135deg, #f0f7ff, #c0d9e8);
}

/* Custom button for file upload */
.file-upload-btn {
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 14px 28px;
  background-color: #4CAF50;
  color: white;
  border-radius: 8px;
  cursor: pointer;
  font-size: 18px;
  transition: background-color 0.3s ease, transform 0.3s ease, box-shadow 0.3s ease;
  width: 100%;
  margin: 0;
}

.file-upload-btn:hover {
  background-color: #45a049;
  transform: scale(1.05);
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
}

.file-upload-btn i {
  margin-left: 8px;
}

/* Hidden native file input */
.file-input {
  display: none;
}

/* File Preview Section */
.file-preview {
  position: relative;
  margin-top: 20px;
  display: flex;
  justify-content: center;
  transition: all 0.3s ease-in-out;
}

/* Preview container with magic */
.preview-container {
  position: relative;
  display: inline-block;
  max-width: 100%;
  margin-bottom: 10px;
  border-radius: 15px;
  overflow: hidden;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
  transition: all 0.3s ease-in-out;
}

.preview-container:hover {
  transform: scale(1.05) rotate(3deg);
  box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.preview-img {
  width: 100%;
  height: auto;
  max-height: 150px;
  object-fit: cover;
  border-radius: 12px;
  transition: transform 0.3s ease-in-out;
}

.preview-img:hover {
  transform: scale(1.05);
}

/* Remove button for file preview */
.remove-btn {
  position: absolute;
  top: 5px;
  right: 5px;
  background: rgba(255, 0, 0, 0.7);
  color: white;
  font-size: 18px;
  border: none;
  padding: 6px 12px;
  border-radius: 50%;
  cursor: pointer;
  transition: background 0.3s ease, transform 0.3s ease;
}

.remove-btn:hover {
  background: red;
  transform: scale(1.1);
}

/* Label styling */
.file-label {
  font-size: 18px;
  margin-bottom: 12px;
  color: #333;
  font-weight: 600;
  display: block;
  transition: color 0.3s ease;
}

/* Error Message Styling */
.input-error {
  border-color: #f44336;
  background-color: #ffe6e6;
}



@keyframes glow {
  0% {
    text-shadow: 0 0 5px red, 0 0 10px red, 0 0 20px red, 0 0 40px red;
  }
  50% {
    text-shadow: 0 0 10px red, 0 0 20px red, 0 0 30px red, 0 0 60px red;
  }
  100% {
    text-shadow: 0 0 5px red, 0 0 10px red, 0 0 20px red, 0 0 40px red;
  }
}

/* Responsive Styles */
@media screen and (max-width: 768px) {
  .file-upload-btn {
    font-size: 16px;
    padding: 12px 24px;
  }

  .preview-img {
    max-height: 120px;
  }

  .remove-btn{
	width: 52% !important;
  }
}

@media screen and (max-width: 480px) {
  .file-upload-btn {
    font-size: 14px;
    padding: 10px 20px;
  }

  .file-label {
    font-size: 16px;
  }

  .preview-img {
    max-height: 100px;
  }
}


/* etudiant image file */
/* Main container */
.form-group.student-image-upload {
    margin-top: 40px;
    font-family: 'Roboto', sans-serif;
    text-align: center;
    padding: 30px;
}

/* Wrapper for the file upload button */
.file-upload-wrapper-student {
    position: relative;
    display: inline-block;
    cursor: pointer;
    transition: transform 0.3s ease;
}

/* Circular file upload button with shadow */
.file-upload-btn-student {
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    width: 280px;
    height: 280px;
    background: linear-gradient(135deg, #4CAF50, #4CAF50);
    border-radius: 50%;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    position: relative;
    transition: transform 0.3s ease-in-out, box-shadow 0.3s ease;
}

.file-upload-btn-student:hover {
    transform: scale(1.05);
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
}

/* Image container (circle) with hover zoom effect */
.file-upload-image-student {
    width: 180px;
    height: 180px;
    border-radius: 50%;
    background-color: #f0f0f0;
    display: flex;
    justify-content: center;
    align-items: center;
    border: 4px solid #ffffff;
    overflow: hidden;
    transition: transform 0.3s ease;
}

.upload-img-student {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

/* Button text in the center */
.upload-text-student {
    font-size: 18px;
    color: #ffffff;
    font-weight: 500;
    position: absolute;
    bottom: 20px;
    transition: opacity 0.3s ease-in-out;
}

/* Hover effect for image zoom */
.file-upload-btn-student:hover .upload-img-student {
    transform: scale(1.1);
}

/* Hover effect for text change */
.file-upload-btn-student:hover .upload-text-student {
    opacity: 1;
}

/* File input (hidden but accessible) */
input[type="file"] {
    opacity: 0;
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    cursor: pointer;
    z-index: 2;
}

/* Error state */
.input-error-student {
    border: 2px solid #ff5722;
    background-color: rgba(255, 87, 34, 0.1);
}

/* Image preview section */
.file-upload-preview-student {
    margin-top: 30px;
    text-align: center;
}

/* Circular preview image with soft shadow */
.preview-img-student {
    width: 120px;
    height: 120px;
    object-fit: cover;
    border-radius: 50%;
    border: 4px solid #00bcd4;
    box-shadow: 0 8px 20px rgba(0, 188, 212, 0.2);
    transition: transform 0.3s ease;
}

/* Hover effect for preview image */
.preview-img-student:hover {
    transform: scale(1.05);
}

/* Remove image button */
.remove-btn-student {
    background-color: #ff5722;
    color: white;
    border: none;
    padding: 8px 16px;
    border-radius: 8px;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.remove-btn-student:hover {
    background-color: #e64a19;
}

/* Responsive design */
@media (max-width: 768px) {
    .file-upload-btn-student {
        width: 220px;
        height: 220px;
    }

    .file-upload-image-student {
        width: 150px;
        height: 150px;
    }

    .upload-text-student {
        font-size: 16px;
        bottom: 15px;
    }
}

@media (max-width: 480px) {
    .file-upload-btn-student {
        width: 180px;
        height: 180px;
    }

    .file-upload-image-student {
        width: 120px;
        height: 120px;
    }

    .upload-text-student {
        font-size: 14px;
        bottom: 10px;
    }
}
/* end etudiant image file*/


/* start etudiant pdf file*/
.pdf-upload-container {
  display: flex;
  justify-content: center;
  align-items: center;
  flex-direction: column;
  width: 100%;
  height: auto;
  min-height: 200px;
  border: 2px dashed #4CAF50;
  border-radius: 12px;
  cursor: pointer;
  background: rgba(255, 255, 255, 0.9);
  transition: all 0.3s ease-in-out;
  padding: 10px;
}

/* Hover effect */
.pdf-upload-container:hover {
  background: rgba(255, 255, 255, 1);
  border-color: #4CAF50;
}

/* PDF Preview */
.pdf-preview-container {
  position: relative;
  width: 100%;
  max-width: 100%;
  max-height: 350px; /* Adjust based on viewport */
  overflow-y: auto; /* Enable vertical scrolling */
  display: flex;
  justify-content: flex-start; /* Ensures content starts from the top */
  align-items: center;
  background: white;
  border-radius: 12px;
  padding: 5px;
  box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
}

/* Canvas - Ensure it scales properly */
canvas {
  width: 100%;
  height: auto;
  max-width: 100%;
  border-radius: 8px;
  background: white;
  display: block;
}

/* Remove Button */
.remove-file-btn {
  position: absolute;
  top: 5px;
  right: 5px;
  background: red;
  color: white;
  border: none;
  border-radius: 50%;
  width: 20px; /* Smaller size */
  height: 20px;
  font-size: 12px; /* Smaller icon */
  display: flex;
  justify-content: center;
  align-items: center;
  cursor: pointer;
  transition: all 0.2s ease-in-out;
}

/* Hover Effect */
.remove-file-btn:hover {
  background: darkred;
}

/* Error Message */
.error-message {
  color: red;
  font-size: 14px;
  margin-top: 5px;
  text-align: center;
  font-weight: bold;
}

/* Responsive Fix */
@media (min-width: 1024px) {
  .pdf-preview-container {
    max-height: 940px; /* Increase height for larger screens */
  }
}

@media (max-width: 768px) {
	.pdf-upload-placeholder{
		text-align: center;
	}

	.remove-file-btn {
		width: 18px; /* Even smaller for mobile */
		height: 18px;
		font-size: 10px;
		top: 3px;
		right: 3px;
	}
}

/* end etudiant pdf file*/

/*  filiere step  */
.filiere-container {
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
    justify-content: center;
}

.filiere-card {
    position: relative;
    width: 280px;
    height: 180px;
    background: #ffffff;
    border-radius: 12px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease, border 0.3s ease;
    overflow: hidden;
    border: 2px solid transparent;
    cursor: pointer;
}

.filiere-card:hover {
    transform: scale(1.05);
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
    border: 2px solid #007bff;
}

.hidden-input {
    display: none;
}

.filiere-content {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 100%;
    cursor: pointer;
    text-align: center;
    padding: 10px;
}

.filiere-title {
    font-size: 18px;
    font-weight: bold;
    color: #007bff;
}

.filiere-name {
    font-size: 14px;
    color: #333;
    margin-top: 5px;
}

/* Bouton Voir la description */
.description-btn {
    margin-top: 8px;
    font-size: 14px;
    font-weight: bold;
    background: linear-gradient(135deg, #007bff, #0056b3);
    color: white;
    padding: 8px 12px;
    border-radius: 20px;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 8px;
}

.description-btn i {
    font-size: 16px;
}

.description-btn:hover {
    background: linear-gradient(135deg, #e0e2e3, #a7a7a7);
    transform: scale(1.05);
}

/* Effet pour les cases cochées */
.hidden-input:checked + .filiere-content,
.filiere-card.selected {
    background: #007bff;
    color: white;
    border: 2px solid #0056b3;
}

.hidden-input:checked + .filiere-content .filiere-title,
.filiere-card.selected .filiere-title {
    color: white;
}

.hidden-input:checked + .filiere-content .description-btn,
.filiere-card.selected .description-btn {
    background: #ffeeab;
    color: #333;
}

.hidden-input:checked + .filiere-content .description-btn:hover,
.filiere-card.selected .description-btn:hover {
    background: #ffc107;
}

/* Icône de sélection */
.selected-icon {
    position: absolute;
    top: 10px;
    right: 10px;
    background: #28a745;
    color: white;
    font-size: 14px;
    font-weight: bold;
    padding: 5px 10px;
    border-radius: 20px;
    box-shadow: 0 3px 6px rgba(0, 0, 0, 0.2);
}


/* end filiere step  */



/* --- confirmation step --- */

.confirmation-container {
    padding: 20px;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(12px);
    border-radius: 16px;
    box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.15);
    transition: all 0.3s ease-in-out;
    max-width: 600px;
    margin: auto;
}

/* --- Important Note --- */
.confirmation-note {
	text-align: center;
    color: #d32f2f;
    font-weight: bold;
    font-size: 16px;
    margin-bottom: 15px;
}

/* --- Checkbox Wrapper (Flex for Same Line) --- */
.checkbox-wrapper {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 10px;
    cursor: pointer;
}

/* --- Hide Default Checkbox --- */
.hidden-checkbox {
    display: none;
}

/* --- Custom Checkbox --- */
.custom-checkbox {
    width: 29px;
    height: 24px;
    border: 2px solid #4CAF50;
    border-radius: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: rgba(255, 255, 255, 0.2);
    transition: all 0.3s ease-in-out;
    cursor: pointer;
    position: relative;
    box-shadow: 0 4px 10px rgba(76, 175, 80, 0.4);
}

/* --- Checkmark Icon (Now Appears When Checked) --- */
.check-icon {
    width: 16px;
    height: 16px;
    stroke: white;
    stroke-width: 3;
    fill: none;
    stroke-linecap: round;
    stroke-linejoin: round;
    display: none; /* Initially Hidden */
    transition: all 0.2s ease-in-out;
}

/* --- Checkbox Checked State (Fixed) --- */
.hidden-checkbox:checked + .custom-checkbox {
    background-color: #4CAF50;
    border-color: #4CAF50;
    box-shadow: 0px 0px 15px rgba(76, 175, 80, 0.6);
}

/* --- Ensure Checkmark Appears When Checked --- */
.hidden-checkbox:checked + .custom-checkbox .check-icon {
    display: block;
}

/* --- Checkbox Text (Aligned with Checkbox) --- */
.checkbox-text {
    font-size: 16px;
    color: #333;
    font-weight: 500;
    transition: color 0.3s ease-in-out;
    line-height: 1.4;
}

/* --- Responsive Design --- */
@media (max-width: 768px) {
    .confirmation-container {
        padding: 15px;
        width: 90%;
    }

    .confirmation-note {
        font-size: 14px;
    }

    .custom-checkbox {
        width: 60px;
        height: 22px;
    }

    .checkbox-text {
        font-size: 14px;
    }
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



/*  success submit form  */
.success-container {
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 20px;
}

/* 🎨 Success Card */
.success-card {
  background: rgba(255, 255, 255, 0.95);
  border-radius: 15px;
  padding: 40px;
  max-width: 600px;
  width: 100%;
  box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.2);
  text-align: center;
  animation: fadeInUp 1s ease-out;
}

/* 🌟 Success Icon */
.success-icon {
  margin: 20px 0;
}

.glow {
  filter: drop-shadow(0px 0px 15px #d4af37);
  animation: glowEffect 1.5s infinite alternate;
}

/* 🏆 Title & Message */
.success-title {
  font-size: 26px;
  color: #002147;
  font-weight: bold;
  margin-bottom: 10px;
}

.success-text {
  font-size: 16px;
  color: #333;
  margin-bottom: 20px;
}

/* 📜 User Info */
.success-info {
  background: rgba(0, 33, 71, 0.1);
  padding: 15px;
  border-radius: 10px;
  margin-bottom: 15px;
  font-weight: 500;
  color: #002147;
}

/* 🔑 Credentials */
.success-credentials {
  background: rgba(212, 175, 55, 0.1);
  padding: 15px;
  border-radius: 10px;
  margin-bottom: 20px;
  font-weight: bold;
  color: #002147;
  position: relative;
}

/* 🎭 Smart Password Box */
.password-box {
  display: inline-block;
  padding: 4px 10px;
  border-radius: 5px;
  transition: all 0.3s ease-in-out;
  font-weight: bold;
  font-size: 16px;
}

/* Blur effect when hidden */
.blurred {
  color: transparent;
  text-shadow: 0 0 8px rgba(0, 0, 0, 0.5);
  background: rgba(0, 0, 0, 0.1);
  padding: 4px 10px;
  border-radius: 5px;
}

/* 🎛️ Password Toggle Button */
.toggle-password {
  background: none;
  border: none;
  font-size: 18px;
  cursor: pointer;
  margin-left: 0px;
  transition: transform 0.2s ease-in-out;
}

.toggle-password:hover {
  transform: scale(1.1);
}


/* 🎨 Stylish Button */
.modern-button {
  display: inline-block;
  padding: 12px 20px;
  background: linear-gradient(135deg, #d4af37, #ffcc5c);
  color: #002147;
  font-size: 16px;
  font-weight: bold;
  text-decoration: none;
  border-radius: 12px;
  transition: all 0.3s ease-in-out;
  box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.3);
}

.modern-button:hover {
  transform: scale(1.05);
  box-shadow: 0px 7px 20px rgba(0, 0, 0, 0.4);
}

/* 🔥 Animations */
@keyframes glowEffect {
  from {
    filter: drop-shadow(0px 0px 10px #d4af37);
  }
  to {
    filter: drop-shadow(0px 0px 20px #d4af37);
  }
}

@keyframes fadeInUp {
  from {
    opacity: 0;
    transform: translateY(50px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}


.modern-logo-box {
  display: flex;
  justify-content: center;
  align-items: center;
  background: rgba(255, 255, 255, 0.9); /* Keep a subtle background */
  padding: 10px; /* Smaller padding around the logo */
  border-radius: 10px; /* Rounded corners for the background */
  box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1); /* Soft shadow for the background */
  margin-bottom: 20px; /* Keep the margin below the logo */
  transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
}

/* 🖼️ Logo Image */
.modern-logo {
  width: 120px; /* Adjust logo size */
  height: auto;
  filter: drop-shadow(2px 2px 8px rgba(0, 33, 71, 0.2)); /* Subtle shadow on the logo */
}

/* Logo Hover Effect */
.modern-logo-box:hover {
  transform: translateY(-5px);
  box-shadow: 0px 10px 25px rgba(0, 0, 0, 0.4);
}

.password-tooltip {
  position: absolute;
  background: rgba(0, 33, 71, 0.9);
  color: #fff;
  padding: 6px 12px;
  border-radius: 6px;
  font-size: 14px;
  top: 33px;
  left: 85%;
  transform: translateX(-50%);
  white-space: nowrap;
  box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3);
}



</style>
