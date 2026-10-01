const form = document.getElementById("registrationForm");

const registrationContainer =
    document.getElementById("registrationContainer");

const loadingBox =
    document.getElementById("loadingBox");

const adoptionContainer =
    document.getElementById("adoptionContainer");

const message =
    document.getElementById("message");

const petCards =
    document.querySelectorAll(".pet-card");

const selectedPet =
    document.getElementById("selectedPet");


/* =========================
   REGISTRATION FORM
========================= */

form.addEventListener("submit", function(event) {

    // Prevent page refresh
    event.preventDefault();


    // Get input values
    const fullName =
        document.getElementById("fullName").value.trim();

    const email =
        document.getElementById("email").value.trim();

    const password =
        document.getElementById("password").value.trim();


    /* =========================
       VALIDATION
    ========================= */

    // Check if all fields are completed
    if (
        fullName === "" ||
        email === "" ||
        password === ""
    ) {

        message.textContent =
            "Please complete all fields.";

        message.className = "error";

        return;
    }


    // Check email
    if (
        !email.includes("@") ||
        !email.includes(".")
    ) {

        message.textContent =
            "Please enter a valid email address.";

        message.className = "error";

        return;
    }


    /* =========================
       SUCCESS
    ========================= */

    message.textContent =
        "Registration successful!";

    message.className = "success";


    /*
       Show loading indicator
       after successful registration
    */

    setTimeout(function() {

        registrationContainer.style.display = "none";

        loadingBox.style.display = "block";


        /*
           After 2 seconds,
           show adoption list
        */

        setTimeout(function() {

            loadingBox.style.display = "none";

            adoptionContainer.style.display = "block";

        }, 2000);


    }, 1000);

});


/* =========================
   PET SELECTION
========================= */

petCards.forEach(function(card) {

    card.addEventListener("click", function() {

        // Remove selected state from all cards
        petCards.forEach(function(item) {

            item.classList.remove("selected");

        });


        // Add selected state
        card.classList.add("selected");


        // Get selected pet name
        const petName = card.dataset.pet;


        // Display selected pet
        selectedPet.textContent =
            "You selected " + petName + "!";

    });

});