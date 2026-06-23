<script>
    // Clear all error messages
    function clearErrors() {
        const errors = document.getElementsByClassName('formerror');
        for (let error of errors) {
            error.textContent = ""; // Clear error text
        }
    }

    // Set error for a specific input field
    function setError(field, message) {
        const errorElement = document.querySelector(`.formerror[data-for="${field}"]`);
        if (errorElement) {
            errorElement.textContent = message; // Display error message
        }
    }

    // Validate the form before submission
    function validateForm(event) {
        clearErrors(); // Clear previous errors
        let isValid = true;

        // Name validation
        const nameValue = document.getElementsByName('name')[0].value.trim();
        if (nameValue === "" || /[^a-zA-Z\s]/.test(nameValue) || /\s{2,}/.test(nameValue)) {
            setError("name", "*Full name is required. No numbers or special characters.");
            isValid = false;
        }

        // Phone number validation
        const phoneValue = document.getElementsByName('phone')[0].value.trim();
        const phonePattern = /^[6-9]{1}[0-9]{9}$/;
        if (!phonePattern.test(phoneValue)) {
            setError("phone", "*Enter a valid 10-digit phone number.");
            isValid = false;
        }

        // Email validation
        const emailValue = document.getElementsByName('email')[0].value.trim();
        const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        if (!emailPattern.test(emailValue)) {
            setError("email", "*Enter a valid email address.");
            isValid = false;
        }
        
        // Pincode validation
        const pincodeValue = document.getElementsByName('pincode')[0].value.trim();
        const pincodePattern = /^(\d{4}|\d{6})$/;
        if (!pincodePattern.test(pincodeValue)) {
            setError("pincode", "*Enter a valid pincode number.");
            isValid = false;
        }
       
        // UHID validation
        const uhidValue = document.getElementsByName('uhid')[0].value.trim();
        const uhidPattern = /^[A-Z]{4}[0-9]{10}$/;
        
        if (!uhidPattern.test(uhidValue)) {
            setError("uhid", "*UHID must be 4 CAPITAL letters + 10 digits (Example: ASHB0000066805)");
            isValid = false;
        }
       
        return isValid; // Prevent form submission if validation fails
    }

    // Real-time input validation
    function validateInput(event, field) {
        const value = event.target.value.trim();
        const subBtn = document.getElementById("popsubmit"); // Replace with your submit button ID

        // if (field === "name" || field === "team_name" || field === "poc_name") {
        //     if (/[^a-zA-Z\s]/.test(value) || /\s{2,}/.test(value) || value === "") {
        //         setError("name", "*Enter a valid name. No numbers or special characters.");
        //         subBtn.disabled = true;
        //     } else { 
        //         setError("name", "");
        //         subBtn.disabled = false;
        //     }
        // }
        if (field === "name" || field === "team_name" || field === "poc_name") {

            // Only letters & single spaces
            if (value === "" || /[^a-zA-Z\s]/.test(value) || /\s{2,}/.test(value)) {
                setError(field, "*Enter a valid name. Only alphabets allowed.");
                subBtn.disabled = true;
            } else {
                setError(field, "");
                subBtn.disabled = false;
            }
        }


        // if (field === "phone") {
        //     const phonePattern = /^[6-9]{1}[0-9]{9}$/;
        //     if (!phonePattern.test(value)) {
        //         setError("phone", "*Enter a valid 10-digit phone number.");
        //         subBtn.disabled = true;
        //     } else {
        //         setError("phone", "");
        //         subBtn.disabled = false;
        //     }
        // }
        
        if (field === "phone" || field === "poc_contact" || field === "mobile") {

            // sirf digits allow
            let numericValue = value.replace(/[^0-9]/g, '');
        
            // max 10 digits
            if (numericValue.length > 10) {
                numericValue = numericValue.slice(0, 10);
            }
        
            // input me set karo
            event.target.value = numericValue;
        
            const phonePattern = /^[6-9][0-9]{9}$/;
        
            if (!phonePattern.test(numericValue)) {
                setError(field, "*Enter a valid 10-digit mobile number.");
                subBtn.disabled = true;
            } else {
                setError(field, "");
                subBtn.disabled = false;
            }
        }



        if (field === "email") {
            const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
            if (!emailPattern.test(value)) {
                setError("email", "*Enter a valid email address.");
                subBtn.disabled = true;
            } else {
                setError("email", "");
                subBtn.disabled = false;
            }
        }
        
        if (field === "pincode") {
            
           // sirf digits allow
            let numericValue = value.replace(/[^0-9]/g, '');
        
            // max 10 digits
            if (numericValue.length > 6) {
                numericValue = numericValue.slice(0, 6);
            }
        
            // input me set karo
            event.target.value = numericValue;
            
            const pincodePattern = /^(\d{4}|\d{6})$/;
            if (!pincodePattern.test(value)) {
                setError("pincode", "*Enter a valid pincode number.");
                subBtn.disabled = true;
            } else {
                setError("pincode", "");
                subBtn.disabled = false;
            }
        }
        
        if(field === "uhid"){
            const uhidPattern = /^[A-Z]{4}[0-9]{10}$/;
        
            if (!uhidPattern.test(value)) {
                setError("uhid", "*Enter a Valid UHID Number");
                subBtn.disabled = true;
            } else {
                setError("uhid", "");
                subBtn.disabled = false;
            }
        }
        
       
    }
</script>
