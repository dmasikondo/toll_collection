<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-11">
            	<form role="form" @submit.prevent="createTag()" v-show="!tagSwiped">
            		<div class="row justify-content-center border-2">
            			<div class="col-md-8">
            				<div class="card">
							         	<div class="card-body justify-content-center">
                              <div class="alert alert-success" v-if="successfulRegistration">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <strong>Success!</strong> The vehicle was successfully registered.
                              </div>                            
			                        <div class="form-group col-md-8">     
			                        	<h2 style="letter-spacing: 1px;">Registration Initialisation</h2>                   	
			                             <input id="getUID" type="text" v-model="tag_number" class="lg form-control" :class="{'is-invalid':errors.hasError('tag_number')}" name="tag_number" placeholder="Please Tag Your Card To Register a vehicle">
                                            <span v-if="errors.hasError('tag_number')" class="invalid-feedback" role="alert" style="display: block">
                                                <strong>{{errors.get('tag_number')}}</strong>
                                            </span> 
			                         </div>										
								</div>            					
            				</div>
            			</div>
            		</div>
            	</form>
<!-- vehicle particulars -->
				<form id="vehicle_regForm" role="form" @submit.prevent="registerVehicle()" v-if="tagSwiped">
					<div class="card">
						<div class="card-header">
							Registering Vehicle with Tag_Number {{tag_number}} 
						</div>
						<div class="card-body">
							<fieldset>
								<legend class="text-muted">Vehicle Particulars</legend>

								<div class="row">

			                        <div class="form-group col-md-3">                        	
			                            <label for="registration_number" class="col-form-label text-md-right">Registration Number</label>
			                             <input id="registration_number" type="text" v-model="registration_number" class="form-control" :class="{'is-invalid':errors.hasError('registration_number')}" name="registration_number" required autofocus>
                                            <span v-if="errors.hasError('registration_number')" class="invalid-feedback" role="alert" style="display: block">
                                                <strong>{{errors.get('registration_number')}}</strong>
                                            </span> 
			                         </div>	

			                        <div class="form-group col-md-3">                        	
			                            <label for="make" class="col-form-label text-md-right">Vehicle Make</label>
			                             <input id="make" type="text" v-model="make" class="form-control"  :class="{'is-invalid':errors.hasError('make')}"  name="make" required>			                                
                                            <span v-if="errors.hasError('make')" class="invalid-feedback" role="alert" style="display: block">
                                                <strong>{{errors.get('make')}}</strong>
                                            </span> 
			                         </div>		                         

			                        <div class="form-group col-md-3">                        	
			                            <label for="model" class="col-form-label text-md-right">Vehicle Model</label>
			                             <input id="model" type="text" v-model="model" class="form-control"  :class="{'is-invalid':errors.hasError('model')}"  name="model" required>			                                
                                            <span v-if="errors.hasError('model')" class="invalid-feedback" role="alert" style="display: block">
                                                <strong>{{errors.get('model')}}</strong>
                                            </span> 
			                         </div>		


			                        <div class="form-group col-md-3">                        	
			                            <label for="year" class="col-form-label text-md-right">Year</label>
			                             <input id="year" type="text" v-model="year" class="form-control"  :class="{'is-invalid':errors.hasError('year')}"  name="year" min="1980" max="2020"
                                   pattern="([0-9]{4})" title="Year must be between 1900 and 2020" required>	
			                             	<small class="form-text text-muted">Year first used as new</small>		                                
                                            <span v-if="errors.hasError('year')" class="invalid-feedback" role="alert" style="display: block">
                                                <strong>{{errors.get('year')}}</strong>
                                            </span> 
			                         </div>	                                                						

								</div>

<!-- vehicle particulars 2nd row -->
								<div class="row">

			                        <div class="form-group col-md-3">                        	
			                            <label for="body_type" class="col-form-label text-md-right">Type of body</label>
			                             <input id="body_type" type="text" v-model="body_type" class="form-control" :class="{'is-invalid':errors.hasError('body_type')}" name="body_type" required>
                                            <span v-if="errors.hasError('body_type')" class="invalid-feedback" role="alert" style="display: block">
                                                <strong>{{errors.get('body_type')}}</strong>
                                            </span>
			                         </div>	

			                        <div class="form-group col-md-3">                        	
			                            <label for="color" class="col-form-label text-md-right">Color</label>
			                             <input id="color" type="text" v-model="color" class="form-control" :class="{'is-invalid':errors.hasError('color')}" name="color"
                                   title="Color should contain alphabetic characters only" required>
                                            <span v-if="errors.hasError('color')" class="invalid-feedback" role="alert" style="display: block">
                                                <strong>{{errors.get('color')}}</strong>
                                            </span>
			                         </div>	

			                        <div class="form-group col-md-3">                        	
			                            <label for="net_mass" class="col-form-label text-md-right">Net Mass (kg)</label>
			                             <input id="net_mass" type="number" v-model="net_mass" class="form-control" :class="{'is-invalid':errors.hasError('net_mass')}" name="net_mass"
                                   pattern="([0-9])" title="Mass in kgs must be a number" required>
                                            <span v-if="errors.hasError('net_mass')" class="invalid-feedback" role="alert" style="display: block">
                                                <strong>{{errors.get('net_mass')}}</strong>
                                            </span>
			                         </div>	 

			                        <div class="form-group col-md-3">                        	
			                            <label for="gross_mass" class="col-form-label text-md-right">Gross Mass (kg)</label>
			                             <input id="gross_mass" type="number" v-model="gross_mass" class="form-control" :class="{'is-invalid':errors.hasError('gross_mass')}" name="gross_mass"
                                   pattern="([0-9])" title="Mass in kgs must be a number" required>
                                            <span v-if="errors.hasError('gross_mass')" class="invalid-feedback" role="alert" style="display: block">
                                                <strong>{{errors.get('gross_mass')}}</strong>
                                            </span>
			                         </div>		                                                                         						

								</div>

<!-- vehicle particular 3rd row -->

								<div class="row">

			                        <div class="form-group col-md-3">                        	
			                            <label for="serial_number" class="col-form-label text-md-right">Serial Number</label>
			                             <input id="serial_number" type="text" v-model="serial_number" class="form-control"  :class="{'is-invalid':errors.hasError('serial_number')}"  name="serial_number" required>
			                               <small class="form-text muted">Engine Car Serial No.</small>
                                            <span v-if="errors.hasError('serial_number')" class="invalid-feedback" role="alert" style="display: block">
                                                <strong>{{errors.get('serial_number')}}</strong>
                                            </span>
			                         </div>	

			                        <div class="form-group col-md-3">                        	
			                            <label for="chasis_number" class="col-form-label text-md-right">Chasis / Frame No.</label>
			                             <input id="chasis_number" type="text" v-model="chasis_number" class="form-control"  :class="{'is-invalid':errors.hasError('chasis_number')}" name="chasis_number" required="required">
                                            <span v-if="errors.hasError('chasis_number')" class="invalid-feedback" role="alert" style="display: block">
                                                <strong>{{errors.get('chasis_number')}}</strong>
                                            </span>
			                         </div>	

			                        <div class="form-group col-md-3">                        	
			                            <label for="engine_capacity" class="col-form-label text-md-right">Engine Capacity</label>
			                             <input id="engine_capacity" type="text" v-model="engine_capacity" class="form-control" :class="{'is-invalid':errors.hasError('engine_capacity')}" name="engine_capacity" required="required">
			                               <small class="form-text muted">/ factory related load capacity (trailers only)</small>
                                            <span v-if="errors.hasError('engine_capacity')" class="invalid-feedback" role="alert" style="display: block">
                                                <strong>{{errors.get('engine_capacity')}}</strong>
                                            </span>
			                         </div>	 

			                        <div class="form-group col-md-3">                        	
			                            <label for="fuel" class="col-form-label text-md-right">Fuel Used</label>
			                             <input id="fuel" type="text" v-model="fuel" class="form-control" :class="{'is-invalid':errors.hasError('fuel')}" name="fuel" required="required">
                                            <span v-if="errors.hasError('fuel')" class="invalid-feedback" role="alert" style="display: block">
                                                <strong>{{errors.get('fuel')}}</strong>
                                            </span>
			                         </div>		                                                                         						

								</div>

							</fieldset>

<!-- previous registration if avalable-->

							<fieldset>
								<legend>
				                  <div class="form-group form-check">
				                    <input type="checkbox" class="form-check-input" id="exampleCheck1" v-model = "showPreviousRegistrationFields">
				                    <label class="form-check-label text-muted" for="exampleCheck1">Vehicle Was Previously Registered</label>
				                  </div>									
								</legend>
							</fieldset>
							<fieldset v-if="showPreviousRegistrationFields">

						<div class="row">				

		                        <div class="form-group col-md-3">                        	
		                            <label for="country" class="col-form-label text-md-right">Country</label>
		                             <select id="country" type="text" v-model="country" class="form-control" :class="{'is-invalid':errors.hasError('country')}" name="country">
		                             	<option value="">Select Country</option>

   <option value="Zimbabwe">Zimbabwe</option>
<option value="Afganistan">Afghanistan</option>
   <option value="Albania">Albania</option>
   <option value="Algeria">Algeria</option>
   <option value="American Samoa">American Samoa</option>
   <option value="Andorra">Andorra</option>
   <option value="Angola">Angola</option>
   <option value="Anguilla">Anguilla</option>
   <option value="Antigua &amp; Barbuda">Antigua &amp; Barbuda</option>
   <option value="Argentina">Argentina</option>
   <option value="Armenia">Armenia</option>
   <option value="Aruba">Aruba</option>
   <option value="Australia">Australia</option>
   <option value="Austria">Austria</option>
   <option value="Azerbaijan">Azerbaijan</option>
   <option value="Bahamas">Bahamas</option>
   <option value="Bahrain">Bahrain</option>
   <option value="Bangladesh">Bangladesh</option>
   <option value="Barbados">Barbados</option>
   <option value="Belarus">Belarus</option>
   <option value="Belgium">Belgium</option>
   <option value="Belize">Belize</option>
   <option value="Benin">Benin</option>
   <option value="Bermuda">Bermuda</option>
   <option value="Bhutan">Bhutan</option>
   <option value="Bolivia">Bolivia</option>
   <option value="Bonaire">Bonaire</option>
   <option value="Bosnia &amp;Herzegovina">Bosnia &amp;Herzegovina</option>
   <option value="Botswana">Botswana</option>
   <option value="Brazil">Brazil</option>
   <option value="British Indian Ocean Ter">British Indian Ocean Ter</option>
   <option value="Brunei">Brunei</option>
   <option value="Bulgaria">Bulgaria</option>
   <option value="Burkina Faso">Burkina Faso</option>
   <option value="Burundi">Burundi</option>
   <option value="Cambodia">Cambodia</option>
   <option value="Cameroon">Cameroon</option>
   <option value="Canada">Canada</option>
   <option value="Canary Islands">Canary Islands</option>
   <option value="Cape Verde">Cape Verde</option>
   <option value="Cayman Islands">Cayman Islands</option>
   <option value="Central African Republic">Central African Republic</option>
   <option value="Chad">Chad</option>
   <option value="Channel Islands">Channel Islands</option>
   <option value="Chile">Chile</option>
   <option value="China">China</option>
   <option value="Christmas Island">Christmas Island</option>
   <option value="Cocos Island">Cocos Island</option>
   <option value="Colombia">Colombia</option>
   <option value="Comoros">Comoros</option>
   <option value="Congo">Congo</option>
   <option value="Cook Islands">Cook Islands</option>
   <option value="Costa Rica">Costa Rica</option>
   <option value="Cote DIvoire">Cote DIvoire</option>
   <option value="Croatia">Croatia</option>
   <option value="Cuba">Cuba</option>
   <option value="Curaco">Curacao</option>
   <option value="Cyprus">Cyprus</option>
   <option value="Czech Republic">Czech Republic</option>
   <option value="Denmark">Denmark</option>
   <option value="Djibouti">Djibouti</option>
   <option value="Dominica">Dominica</option>
   <option value="Dominican Republic">Dominican Republic</option>
   <option value="East Timor">East Timor</option>
   <option value="Ecuador">Ecuador</option>
   <option value="Egypt">Egypt</option>
   <option value="El Salvador">El Salvador</option>
   <option value="Equatorial Guinea">Equatorial Guinea</option>
   <option value="Eritrea">Eritrea</option>
   <option value="Estonia">Estonia</option>
   <option value="Ethiopia">Ethiopia</option>
   <option value="Falkland Islands">Falkland Islands</option>
   <option value="Faroe Islands">Faroe Islands</option>
   <option value="Fiji">Fiji</option>
   <option value="Finland">Finland</option>
   <option value="France">France</option>
   <option value="French Guiana">French Guiana</option>
   <option value="French Polynesia">French Polynesia</option>
   <option value="French Southern Ter">French Southern Ter</option>
   <option value="Gabon">Gabon</option>
   <option value="Gambia">Gambia</option>
   <option value="Georgia">Georgia</option>
   <option value="Germany">Germany</option>
   <option value="Ghana">Ghana</option>
   <option value="Gibraltar">Gibraltar</option>
   <option value="Great Britain">Great Britain</option>
   <option value="Greece">Greece</option>
   <option value="Greenland">Greenland</option>
   <option value="Grenada">Grenada</option>
   <option value="Guadeloupe">Guadeloupe</option>
   <option value="Guam">Guam</option>
   <option value="Guatemala">Guatemala</option>
   <option value="Guinea">Guinea</option>
   <option value="Guyana">Guyana</option>
   <option value="Haiti">Haiti</option>
   <option value="Hawaii">Hawaii</option>
   <option value="Honduras">Honduras</option>
   <option value="Hong Kong">Hong Kong</option>
   <option value="Hungary">Hungary</option>
   <option value="Iceland">Iceland</option>
   <option value="Indonesia">Indonesia</option>
   <option value="India">India</option>
   <option value="Iran">Iran</option>
   <option value="Iraq">Iraq</option>
   <option value="Ireland">Ireland</option>
   <option value="Isle of Man">Isle of Man</option>
   <option value="Israel">Israel</option>
   <option value="Italy">Italy</option>
   <option value="Jamaica">Jamaica</option>
   <option value="Japan">Japan</option>
   <option value="Jordan">Jordan</option>
   <option value="Kazakhstan">Kazakhstan</option>
   <option value="Kenya">Kenya</option>
   <option value="Kiribati">Kiribati</option>
   <option value="Korea North">Korea North</option>
   <option value="Korea Sout">Korea South</option>
   <option value="Kuwait">Kuwait</option>
   <option value="Kyrgyzstan">Kyrgyzstan</option>
   <option value="Laos">Laos</option>
   <option value="Latvia">Latvia</option>
   <option value="Lebanon">Lebanon</option>
   <option value="Lesotho">Lesotho</option>
   <option value="Liberia">Liberia</option>
   <option value="Libya">Libya</option>
   <option value="Liechtenstein">Liechtenstein</option>
   <option value="Lithuania">Lithuania</option>
   <option value="Luxembourg">Luxembourg</option>
   <option value="Macau">Macau</option>
   <option value="Macedonia">Macedonia</option>
   <option value="Madagascar">Madagascar</option>
   <option value="Malaysia">Malaysia</option>
   <option value="Malawi">Malawi</option>
   <option value="Maldives">Maldives</option>
   <option value="Mali">Mali</option>
   <option value="Malta">Malta</option>
   <option value="Marshall Islands">Marshall Islands</option>
   <option value="Martinique">Martinique</option>
   <option value="Mauritania">Mauritania</option>
   <option value="Mauritius">Mauritius</option>
   <option value="Mayotte">Mayotte</option>
   <option value="Mexico">Mexico</option>
   <option value="Midway Islands">Midway Islands</option>
   <option value="Moldova">Moldova</option>
   <option value="Monaco">Monaco</option>
   <option value="Mongolia">Mongolia</option>
   <option value="Montserrat">Montserrat</option>
   <option value="Morocco">Morocco</option>
   <option value="Mozambique">Mozambique</option>
   <option value="Myanmar">Myanmar</option>
   <option value="Nambia">Nambia</option>
   <option value="Nauru">Nauru</option>
   <option value="Nepal">Nepal</option>
   <option value="Netherland Antilles">Netherland Antilles</option>
   <option value="Netherlands">Netherlands (Holland, Europe)</option>
   <option value="Nevis">Nevis</option>
   <option value="New Caledonia">New Caledonia</option>
   <option value="New Zealand">New Zealand</option>
   <option value="Nicaragua">Nicaragua</option>
   <option value="Niger">Niger</option>
   <option value="Nigeria">Nigeria</option>
   <option value="Niue">Niue</option>
   <option value="Norfolk Island">Norfolk Island</option>
   <option value="Norway">Norway</option>
   <option value="Oman">Oman</option>
   <option value="Pakistan">Pakistan</option>
   <option value="Palau Island">Palau Island</option>
   <option value="Palestine">Palestine</option>
   <option value="Panama">Panama</option>
   <option value="Papua New Guinea">Papua New Guinea</option>
   <option value="Paraguay">Paraguay</option>
   <option value="Peru">Peru</option>
   <option value="Phillipines">Philippines</option>
   <option value="Pitcairn Island">Pitcairn Island</option>
   <option value="Poland">Poland</option>
   <option value="Portugal">Portugal</option>
   <option value="Puerto Rico">Puerto Rico</option>
   <option value="Qatar">Qatar</option>
   <option value="Republic of Montenegro">Republic of Montenegro</option>
   <option value="Republic of Serbia">Republic of Serbia</option>
   <option value="Reunion">Reunion</option>
   <option value="Romania">Romania</option>
   <option value="Russia">Russia</option>
   <option value="Rwanda">Rwanda</option>
   <option value="St Barthelemy">St Barthelemy</option>
   <option value="St Eustatius">St Eustatius</option>
   <option value="St Helena">St Helena</option>
   <option value="St Kitts-Nevis">St Kitts-Nevis</option>
   <option value="St Lucia">St Lucia</option>
   <option value="St Maarten">St Maarten</option>
   <option value="St Pierre &amp; Miquelon">St Pierre &amp; Miquelon</option>
   <option value="St Vincent &amp; Grenadines">St Vincent &amp; Grenadines</option>
   <option value="Saipan">Saipan</option>
   <option value="Samoa">Samoa</option>
   <option value="Samoa American">Samoa American</option>
   <option value="San Marino">San Marino</option>
   <option value="Sao Tome &amp; Principe">Sao Tome &amp; Principe</option>
   <option value="Saudi Arabia">Saudi Arabia</option>
   <option value="Senegal">Senegal</option>
   <option value="Seychelles">Seychelles</option>
   <option value="Sierra Leone">Sierra Leone</option>
   <option value="Singapore">Singapore</option>
   <option value="Slovakia">Slovakia</option>
   <option value="Slovenia">Slovenia</option>
   <option value="Solomon Islands">Solomon Islands</option>
   <option value="Somalia">Somalia</option>
   <option value="South Africa">South Africa</option>
   <option value="Spain">Spain</option>
   <option value="Sri Lanka">Sri Lanka</option>
   <option value="Sudan">Sudan</option>
   <option value="Suriname">Suriname</option>
   <option value="Swaziland">Swaziland</option>
   <option value="Sweden">Sweden</option>
   <option value="Switzerland">Switzerland</option>
   <option value="Syria">Syria</option>
   <option value="Tahiti">Tahiti</option>
   <option value="Taiwan">Taiwan</option>
   <option value="Tajikistan">Tajikistan</option>
   <option value="Tanzania">Tanzania</option>
   <option value="Thailand">Thailand</option>
   <option value="Togo">Togo</option>
   <option value="Tokelau">Tokelau</option>
   <option value="Tonga">Tonga</option>
   <option value="Trinidad &amp; Tobago">Trinidad &amp; Tobago</option>
   <option value="Tunisia">Tunisia</option>
   <option value="Turkey">Turkey</option>
   <option value="Turkmenistan">Turkmenistan</option>
   <option value="Turks &amp; Caicos Is">Turks &amp;Caicos Is</option>
   <option value="Tuvalu">Tuvalu</option>
   <option value="Uganda">Uganda</option>
   <option value="United Kingdom">United Kingdom</option>
   <option value="Ukraine">Ukraine</option>
   <option value="United Arab Erimates">United Arab Emirates</option>
   <option value="United States of America">United States of America</option>
   <option value="Uraguay">Uruguay</option>
   <option value="Uzbekistan">Uzbekistan</option>
   <option value="Vanuatu">Vanuatu</option>
   <option value="Vatican City State">Vatican City State</option>
   <option value="Venezuela">Venezuela</option>
   <option value="Vietnam">Vietnam</option>
   <option value="Virgin Islands (Brit)">Virgin Islands (Brit)</option>
   <option value="Virgin Islands (USA)">Virgin Islands (USA)</option>
   <option value="Wake Island">Wake Island</option>
   <option value="Wallis &amp; Futana Is">Wallis &amp; Futana Is</option>
   <option value="Yemen">Yemen</option>
   <option value="Zaire">Zaire</option>
   <option value="Zambia">Zambia</option>
   <option value="Zimbabwe">Zimbabwe</option>
</select>		                             	
                                            <span v-if="errors.hasError('country')" class="invalid-feedback" role="alert" style="display: block">
                                                <strong>{{errors.get('country')}}</strong>
                                            </span>
		                         </div>	

		                        <div class="form-group col-md-3">                        	
		                            <label for="registered_at" class="col-form-label text-md-right">Date Registered</label>
		                             <input id="registered_at" type="date" v-model="registered_at" class="form-control" :class="{'is-invalid':errors.hasError('registered_at')}" name="registered_at">
                                        <span v-if="errors.hasError('registered_at')" class="invalid-feedback" role="alert" style="display: block">
                                            <strong>{{errors.get('registered_at')}}</strong>
                                        </span>
		                         </div>	

		                        <div class="form-group col-md-3">                        	
		                            <label for="reg_no" class="col-form-label text-md-right">Registration Number</label>
		                             <input id="reg_no" type="text" v-model="reg_no" class="form-control" :class="{'is-invalid':errors.hasError('reg_no')}" name="reg_no">		                               
                                        <span v-if="errors.hasError('reg_no')" class="invalid-feedback" role="alert" style="display: block">
                                            <strong>{{errors.get('reg_no')}}</strong>
                                        </span>
		                         </div>	 
	
						</div>
 								
							</fieldset>

		<!--Owner's details -->

						
							<fieldset>
								<div class="row">
								<legend>
									<small class="text-muted">Vehicle Owner's Details</small>
								</legend>
								</div>
									<div class="form-group row">
			                            <label for="surname" class="col-md-4 col-form-label text-md-right">Surname</label>

			                            <div class="col-md-6">
			                                <input id="surname" type="text" v-model="surname" class="form-control" name="surname"  :class="{'is-invalid':errors.hasError('surname')}" required>
			                                    <span v-if="errors.hasError('surname')" class="invalid-feedback" role="alert" style="display: block">
			                                        <strong>{{errors.get('surname')}}</strong>
			                                    </span>
			                            </div>
			                        </div>

			                        <div class="form-group row">
			                            <label for="name" class="col-md-4 col-form-label text-md-right">Name(s)</label>

			                            <div class="col-md-6">
			                                <input id="name" type="text" v-model="name" class="form-control"  :class="{'is-invalid':errors.hasError('name')}" name="name" required>

			                                <span v-if="errors.hasError('name')" class="invalid-feedback" role="alert" style="display: block">
			                                    <strong>{{errors.get('name')}}</strong>
			                                </span>
			                            </div>
			                        </div>  

			                        <div class="form-group row">
			                            <label for="national_id" class="col-md-4 col-form-label text-md-right">National_Id</label>

			                            <div class="col-md-6">
			                                <input id="national_id" type="text" v-model="national_id"  class="form-control"  :class="{'is-invalid':errors.hasError('national_id')}" name="national_id"
                                      pattern="([0-9]{2}-[0-9]{6}[a-zA-Z]{1}[0-9]{2})" title="National ID must be of the format 99-999999Y99" required>
												<small class="text-muted">Use format 99-999999A99 </small>
			                                    <span v-if="errors.hasError('national_id')" class="invalid-feedback" role="alert" style="display: block">
			                                        <strong>{{errors.get('national_id')}}</strong>
			                                    </span>
			                            </div>
			                        </div>     
			                        <div class="form-group row">
			                            <label for="phone_no" class="col-md-4 col-form-label text-md-right">Phone Number</label>

			                            <div class="col-md-6">
			                                <input id="phone_no" type="text" v-model="phone_no" class="form-control"  :class="{'is-invalid':errors.hasError('phone_no')}" name="phone_no"
                                      pattern="[0-9]{8,12}" title="The cellphone number must be between 8 and 12 digits" required>

			                                    <span v-if="errors.hasError('phone_no')" class="invalid-feedback" role="alert" style="display: block">
			                                        <strong>{{errors.get('phone_no')}}</strong>
			                                    </span>
			                            </div>
			                        </div> 
						</fieldset>	
					</div>

							
<!-- vehicle contacts -->
						
							<fieldset>
								<div class="row">
									<legend>
										<small class="text-muted">Address where vehicle is ordinarily kept at night</small>
									</legend>
								</div>

			                        <div class="form-group row">
			                            <label for="address" class="col-md-4 col-form-label text-md-right">Address</label>

			                            <div class="col-md-6">
			                                <input id="address" type="text" v-model="address" class="form-control" :class="{'is-invalid':errors.hasError('address')}" name="address" required >

			                                <span v-if="errors.hasError('address')" class="invalid-feedback" role="alert" style="display: block">
			                                    <strong>{{errors.get('address')}}</strong>
			                                </span>
			                            </div>
			                        </div>	

			                        <div class="form-group row">
			                            <label for="city" class="col-md-4 col-form-label text-md-right">Town / City</label>

			                            <div class="col-md-6">
			                                <select id="city" type="text" v-model="city" class="form-control" :class="{'is-invalid':errors.hasError('city')}" name="city" required>
											<option value="">Select a Town/City</option>
<option value="Arcturus">Arcturus</option>
<option value="Alaska">Alaska</option>
<option value="Banket">Banket</option>
<option value="Beatrice">Beatrice</option>
<option value="Beitbridge">Beatrice</option>
<option value="Bembesi">Bembesi</option>
<option value="Bikita">Bikita</option>
<option value="Binga ">Binga </option>
<option value="Bindura">Bindura</option>
<option value="Birchenough Bridge">Birchenough Bridge</option>
<option value="Bubi">Bubi</option>
<option value="Buhera">Buhera</option>
<option value="Bulawayo">Bulawayo</option>
<option value="Bulilima">Bulilima</option>
<option value="Centenary">Centenary</option>
<option value="Chakari">Chakari</option>
<option value="Chegutu">Chegutu</option>
<option value="Chimanimani">Chimanimani</option>
<option value="Chipinge">Chipinge</option>
<option value="Chiredzi">Chiredzi</option>
<option value="Chirumanzu">Chirumanzu</option> 
<option value="Chirundu">Chirundu</option>
<option value="Chitungwiza">Chitungwiza</option>
<option value="Chivi">Chivi</option> 
<option value="Chivhu">Chivhu</option>
<option value="Chiwundura">Chiwundura</option>
<option value="Concession">Concession</option>
<option value="Dema">Dema</option>
<option value="Domboshava">Domboshava</option>
<option value="Esigodini">Esigodini</option> 
<option value="Filabusi">Filabusi</option>
<option value="Figtree">Figtree</option>
<option value="Gokwe">Gokwe</option>
<option value="Goromonzi">Goromonzi</option> 
<option value="Guruve">Guruve</option>
<option value="Gutu">Gutu</option>
<option value="Guyu">Guyu</optiony
<option value="Gwanda">Gwanda</option>
<option value="Gwayi">Gwayi</option>
<option value="Gweru">Gweru</option>
<option value="Harare">Harare</option>
<option value="Headlands">Headlands</option>
<option value="Honde Valley">Honde Valley</option>
<option value="Hurungwe">Hurungwe</option>
<option value="Hwange">Hwange</option>
<option value="Hwedza">Hwedza</option>
<option value="Insiza">Insiza</option>
<option value="Inyati">Inyati</option>
<option value="Jotsholo">Jotsholo</option>
<option value="Kadoma">Kadoma</option>
<option value="Kafusi">Kafusi</option>
<option value="Kamativi">Kamativi</option>
<option value="Kariba">Kariba</option>
<option value="Karoi">Karoi</option>
<option value="Kezi">Kezi</option>
<option value="Kotwa">Kotwa</option> 
<option value="kwekwe">kwekwe</option>
<option value="Lalapanzi">Lalapanzi</option>
<option value="Lomagundi">Lomagundi</option>
<option value="Lower Gweru">Lower Gweru</option>
<option value="Lupane">Lupane</option>
<option value="Macheke">Macheke</option>
<option value="Makonde">Makonde</option>
<option value="Mangwe">Mangwe</option>
<option value="Marondera">Marondera</option>
<option value="Masvingo">Masvingo</option>
<option value="Matobo">Matobo</option>
<option value="Mazowe">Mazowe</option>
<option value="Mbembesi">Mbembesi</option>
<option value="Mberengwa">Mberengwa</option>
<option value="Mhangura">Mhangura</option>
<option value="Mhondoro">Mhondoro</option>
<option value="Mount Darwin">Mount Darwin</option>
<option value="Mount Selinda">Mount Selinda</option>
<option value="Mudzi">Mudzi</option>
<option value="Mukumbura">Mukumbura</option>
<option value="Munyati">Munyati</option>
<option value="Murehwa">Murehwa</option>
<option value="Murombedzi">Murombedzi</option>
<option value="Mutare">Mutare</option>
<option value="Mutoko">Mutoko</option>
<option value="Mutorashanga">Mutorashanga</option>
<option value="Muzarabani">Muzarabani</option> 
<option value="Mvuma">Mvuma</option>
<option value="Mvurwi">Mvurwi</option>
<option value="Mwenezi">Mwenezi</option>
<option value="Ngundu">Ngundu</option>
<option value="Nkayi">Nkayi</option>
<option value="Norton">Norton</option>
<option value="Nyamandlovu">Nyamandlovu</option>
<option value="Nyamapanda">Nyamapanda</option>
<option value="Nyanga">Nyanga</option>
<option value="Nyanyadzi">Nyanyadzi</option>
<option value="Nyazura">Nyazura</option> 
<option value="Penhalonga">Penhalonga</option>
<option value="Plumtree">Plumtree</option>
<option value="Raffingora">Raffingora</option>
<option value="Redcliff">Redcliff</option>
<option value="Rusape">Rusape</option>
<option value="Rushinga">Rushinga</option>
<option value="Rutenga">Rutenga</option>
<option value="Ruwa">Ruwa</option>
<option value="Sanyati">Sanyati</option>
<option value="Shamva">Shamva</option>
<option value="Selous">Selous</option>
<option value="Shangani">Shangani</option>
<option value="Shurugwi">Shurugwi</option> 
<option value="Silobela">Silobela</option>
<option value="Somabula">Somabula</option>
<option value="Trelawney">Trelawney</option>
<option value="Triangle">Triangle</option>
<option value="Tsholotsho">Tsholotsho </option>
<option value="Umguza">Umguza</option>
<option value="Umzingwane">Umzingwane</option>
<option value="Uzumba">Uzumba</option>
<option value="Victoria Falls">Victoria Falls</option>
<option value="Vumba">Vumba</option>
<option value="West Nicholson">West Nicholson</option>
<option value="Zaka">Zaka</option>
<option value="Zvimba">Zvimba</option>
<option value="Zvishavane">Zvishavane</option>
<option value="Zhombe">Zhombe</option>

										</select>
			                                <span v-if="errors.hasError('city')" class="invalid-feedback" role="alert" style="display: block">
			                                    <strong>{{errors.get('city')}}</strong>
			                                </span>
			                            </div>
			                        </div>  
							</fieldset>	

	                        <button class="btn btn-primary" type="submit">Register</button>



						</div>
	</form>
					</div>
				</form>

            </div>
        </div>
    </div>
 </template>
<script>
   class Errors{
        constructor(){
            this.errors = {};
        }
        get(field){
            if(this.errors[field]){
               return this.errors[field][0];
            }
        }
        hasError(field)
        {
             if(this.errors[field]){
              return true;
            } 
            else{
                return false;
            } 
        }
        clear(field){
           delete this.errors[field];
        }

        record(errors){
            this.errors = errors;
        }

    } 

    export default {
        data()
        {
            return{
            	'tag_number': '',
            	'tagSwiped':false,
            	'displayPreviousRegistration': false,
            	'showPreviousRegistrationFields': false,
            	'message': '',
            	'registration_number': '',
            	'make': '',
            	'model':'',
            	'year':'',
            	'color': '',
            	'body_type': '',
            	'net_mass': '',
            	'gross_mass':'',
            	'serial_number': '',
            	'chasis_number': '',
            	'fuel': '',
            	'engine_capacity': '',
            	'country': '',
            	'registered_at':'',
            	'reg_no': '',
            	'surname':'',
            	'name':'',
            	'national_id':'',
            	'phone_no':'',
            	'address': '',
            	'city':'',
              'successfulRegistration': false,
               errors: new Errors(),
               owners:{}
            }
        },

        methods:{
        	createTag(){
            this.successfulRegistration = false;
        		//	this.tagSwiped =true;
        		axios.post('/api/tags',{
        			tag_number: this.tag_number,
        		}).
        		then((response)=>{
        			this.tagSwiped =true;
        			this.message = '',
        			this.errors = new Errors();
        		}).catch((e)=>{
                    this.errors.record(e.response.data.errors);
                    this.message = e.response.data.message;                       
                });
        	},

        	displayPreviousRegistrationToTrue()
        	{
        		this.displayPreviousRegistration = true;
        	},
        	registerVehicle(){
        		axios.post('/api/vehicles',{
            	tag_number: this.tag_number,
            	previousReg: this.showPreviousRegistrationFields,
            	registration_number: this.registration_number,
            	make: this.make,
            	model: this.model,
            	year: this.year,
            	color: this.color,
            	body_type: this.body_type,
            	net_mass: this.net_mass,
            	gross_mass: this.gross_mass,
            	serial_number: this.serial_number,
            	chasis_number: this.chasis_number,
            	fuel: this.fuel, 
            	engine_capacity: this.engine_capacity,
            	country: this.country,
            	registered_at: this.registered_at,
            	reg_no: this.reg_no,
            	surname: this.surname,
            	name: this.name,
            	national_id: this.national_id,
            	phone_no: this.phone_no,
            	address: this.address,
            	city: this.city,
        		}).then((response)=>{
        			console.log('success');

        		//reset form fields
            		this.tag_number= '';
            		this.message ='';
            		this.showPreviousRegistrationFields=false;
            		this.tagSwiped= false;
            		this.registration_number = '';
            		this.make ='';
            		this.model ='';
            		this.year ='';
            		this.color ='';
            		this.body_type ='';
            		this.net_mass ='';
            		this.gross_mass ='';
            		 this.serial_number ='';
            		this.chasis_number ='';
            		 this.fuel ='';
            		 this.engine_capacity ='';
            		this.country ='';
            		 this.registered_at ='';
            		this.reg_no ='';
            		this.surname ='';
            		 this.name ='';
            		this.national_id ='';
            		 this.phone_no ='';
            		 this.address ='';
            		this.city ='';
                this.successfulRegistration = true;   			
        			//form.reset();
        			this.errors = new Errors();
        		}).catch((e)=>{
                	 this.errors.record(e.response.data.errors);
                   	 this.message = e.response.data.message; 
        		});
        	},



        	loadOwners(){
        		axios.get('/owners').then ((response) =>{
        			this.owners = response.data;
        		})
        	}
        },

        mounted(){
            this.loadOwners();
          //  Fire.$on('AfterRoleWasCreated', () => {this.loadRoles()});
        },
	}                   
</script>
