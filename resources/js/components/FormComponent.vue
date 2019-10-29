<template>
    <div class="row m-0 px-0 py-4 px-sm-1">  

        <form 
        	class="col-12 col-sm-8 border rounded m-0 mx-auto p-1 p-sm-4" 
			enctype="multipart/form-data"
        >
        	<div 
        		class="alert alert-success text-center" 
        		role="alert"
				v-if="successMessage"
        	>{{successMessage}}</div>

		  	<div class="form-group">
		    	<label for="name">Name</label>
		    	<input 
		    		type="text" 
                    name="name"
		    		class="form-control" 		    		
		    		placeholder="Name" 
		    		v-model="name" 	
		    		v-on:blur="check('nameField')"
					v-bind:class="{ 'is-invalid' : errors.includes('name')}"		
		    	>
		    	<div id="nameError" class="invalid-feedback">Name field is required!</div>
		    	<div 
		    		v-if="serverErrors.hasOwnProperty('name')" 	    		
		    	><small class="text-danger">{{serverErrors['name'][0]}}</small></div>
		  	</div>

		  	<div class="form-group">
		    	<label for="name">Email</label>
		    	<input 
		    		type="email" 
                    name="email"                   
		    		class="form-control" 		    		
		    		placeholder="Email" 
		    		v-model="email" 
		    		v-on:blur="check('emailField')"
					v-bind:class="{ 'is-invalid' : errors.includes('email')}"
					required
		    	>
		    	 <div id="emailError" class="invalid-feedback">Email field is required! Please type valid email address!</div>
		    	 <div 
		    		v-if="serverErrors.hasOwnProperty('email')" 	    		
		    	><small class="text-danger">{{serverErrors['email'][0]}}</small></div>
		  	</div>

		  	<div class="form-group">
		    	<label for="name">Phone number</label>
		    	<input 
		    		type="text" 
		    		id="phone"
                    name="phone"
		    		class="form-control" 		    		
		    		placeholder="Phone number" 
		    		v-model="phone" 		    		
					v-on:blur="check('phoneField')"
					v-bind:class="{ 'is-invalid' : errors.includes('phone')}"
		    	>
		    	<div id="phoneError" class="invalid-feedback">Phone field is required!</div>
		    	<div 
		    		v-if="serverErrors.hasOwnProperty('phone')" 	    		
		    	><small class="text-danger">{{serverErrors['phone'][0]}}</small></div>
		  	</div>

		  	<div class="form-group">
		    	<label for="name">Address</label>
		    	<input 
		    		type="text" 
                    name="address"
		    		class="form-control" 		    		
		    		placeholder="Address" 
		    		v-model="address"		    		
		    		v-on:blur="check('addressField')"
					v-bind:class="{ 'is-invalid' : errors.includes('address')}"
		    	>
		    	<div id="addressError" class="invalid-feedback">Address field is required!</div>
		    	<div 
		    		v-if="serverErrors.hasOwnProperty('address')" 	    		
		    	><small class="text-danger">{{serverErrors['address'][0]}}</small></div>
		  	</div>

		  	<div class="form-group">
		    	<label for="name">Zip code</label>
		    	<input 
		    		type="text" 
		    		id="zipCode"
                    name="zipCode"
		    		class="form-control"		    		
		    		placeholder="Zip code" 
		    		v-model="zipCode"				
					v-on:blur="check('zipCodeField')"
					v-bind:class="{ 'is-invalid' : errors.includes('zipCode')}"
		    	>
		    	<div id="zipCodeError" class="invalid-feedback">ZipCode field is required!</div>
		    	<div 
		    		v-if="serverErrors.hasOwnProperty('zipCode')" 	    		
		    	><small class="text-danger">{{serverErrors['zipCode'][0]}}</small></div>
		  	</div>	
		  	<div class="custom-file">
			  	<input 
			  		type="file" 
                    name="file"
			  		class="custom-file-input" 
			  		id="fileInput"
		    		@change="check('fileField')"
					v-bind:class="{ 'is-invalid' : errors.includes('file')}"								
			  	>
			  	<label class="custom-file-label" for="fileInput">{{fileName}}</label>
			  	<div id="fileError" class="invalid-feedback">File field is required! Please select valid file! Supported formats: jpeg, png, gif, pdf, doc</div>
			  	<div 
		    		v-if="serverErrors.hasOwnProperty('file')" 	    		
		    	><small class="text-danger">{{serverErrors['file'][0]}}</small></div>
			</div>

		  	<button 
		  		type="submit" 
                id="submitButton"
		  		class="btn btn-block btn-primary mt-4"
		  		@click.prevent="sendData"
		  	>Submit</button>

		</form>

    </div>
</template>

<script>
    export default {
    	data: function() {

    		return {

    			name: '',
    			email: '',
    			phone: '',
    			phoneRule: '(999)-999-9999',
    			address: '',
    			zipCode: '',
    			zipCodeRule: '99999',
    			file: '',
    			fileName: 'Choose file',

    			successMessage: '',
    			errors: [],
    			serverErrors: new Object,

    			inputFields: [
    				'nameField', 'emailField', 'phoneField',
    				'addressField', 'zipCodeField', 'fileField'
    			],

    		}

    	},
        mounted() {
              
            this.phoneFormat(); 
            this.zipCodeFormat();   
                  
        },

        methods: {

        	sendData: function() {
        		for ( let inputField of this.inputFields ) {
        			this.check(inputField);        			
        		}

        		if ( this.errors.length ) return;

        		//console.log(this.file);
        		const config = {
                    headers: { 'content-type': 'multipart/form-data' }
                };

                let formData = this.createFormData();
               
        		axios.post('/userForm', formData, config)
        			.then ( response => {
        				this.successMessage =response.data;
        				setTimeout(()=>this.successMessage = '', 5000);
        				this.clearInputFields();
        			})

        			.catch( error => {        				
        				console.log(error.response);
        				this.serverErrors = error.response.data.errors;
        				console.log(this.serverErrors);
        			});

        	},

        	check: function(item) {       		
        		this.successMessage = '';
        		switch(item) {

        			case 'nameField': 
        				if ( this.name === '' ) {
        					this.errors.push('name');  						
        				} else {
        					this.errors = this.errors.filter( item => item !== 'name');     					
        				}
        				break;

        			case 'emailField': 
        				if ( ! window.validator.isEmail(this.email) ) {
        					this.errors.push('email');  						
        				} else {
        					this.errors = this.errors.filter( item => item !== 'email');   				
        				}
        				break;

        			case 'phoneField': 
        				if ( ! this.phone.match(/^\(\d{3}\)\-\d{3}\-\d{4}$/g) ) {
        					this.errors.push('phone');  						
        				} else {
        					this.errors = this.errors.filter( item => item !== 'phone');   	        					
        				}
        				break;

        			case 'addressField': 
        				if ( this.address === '' ) {
        					this.errors.push('address');   						
        				} else {
        					this.errors = this.errors.filter( item => item !== 'address');        					
        				}
        				break;

        			case 'zipCodeField': 
        				if ( ! this.zipCode.match(/^\d{5}$/g) ) {
        					this.errors.push('zipCode');  						
        				} else {
        					this.errors = this.errors.filter( item => item !== 'zipCode');     					
        				}
        				break;

        			case 'fileField': 
        				try {
	        				this.file = event.target.files[0];
	        				this.fileName = this.file.name;
	        			} catch(e) {
	        				if (! this.file ) {
		        				this.errors.push('file'); 
		        				return;
		        			}
	        			}
        				//console.log(this.file); 
        				if ( ! this.file.type.match(/(image\/jpeg|image\/png|image\/gif|application\/pdf|application\/msword)/g) ) {
        					this.errors.push('file');  							
        				} else {
        					this.errors = this.errors.filter( item => item !== 'file');   					
        				}
        				break;
        		}

        		//console.log(this.errors);

        	},       	

        	phoneFormat: function() {

        		var selector = document.querySelector("#phone");
				var im = new Inputmask(this.phoneRule);
				im.mask(selector);

        	},

        	zipCodeFormat: function() {

        		var selector = document.querySelector("#zipCode");
				var im = new Inputmask(this.zipCodeRule);
				im.mask(selector);

        	},

        	createFormData: function() {

        		let formData = new FormData();
                formData.append('name', this.name);
                formData.append('email', this.email);
                formData.append('phone', this.phone);
                formData.append('address', this.address);
                formData.append('zipCode', this.zipCode);
                formData.append('file', this.file);

                return formData;

        	},

        	clearInputFields: function() {

        		this.name = ''; 
				this.email = '';
				this.phone = '';
				this.address = '';
				this.zipCode = '';
				this.file = '';
				this.fileName = 'Choose file';

        	}

        }



    }
</script>