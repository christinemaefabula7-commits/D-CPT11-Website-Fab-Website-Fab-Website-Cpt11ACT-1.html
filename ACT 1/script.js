
/* =====================================================
   ACTIVITY 1
===================================================== */


// Function to generate the personalized greeting message
function generateGreeting(name) {

    return `Hello and welcome, ${name}! 🍭`;

}


// Function to determine if user is minor or adult using if-else
function checkAgeCategory(age) {

    if (age < 18) {

        return `You are categorized as a Minor sweet explorer! 🍬`;

    } else {

        return `You are categorized as an Adult sweet master! 🍫`;

    }

}


// Grab elements from the DOM
const userForm =
    document.getElementById("user-form");

const inputArea =
    document.getElementById("input-area");

const resultArea =
    document.getElementById("result-area");

const loadingModal =
    document.getElementById("loading-modal");


const greetingOutput =
    document.getElementById("greeting-output");

const ageStatusOutput =
    document.getElementById("age-status-output");


const openLetterBtn =
    document.getElementById("open-letter-btn");

const backBtn =
    document.getElementById("back-btn");

const letterModal =
    document.getElementById("letter-modal");

const closeLetterBtn =
    document.getElementById("close-letter-btn");

const personalSweetMessage =
    document.getElementById("personal-sweet-message");


let storedUserName = "";


// Handle Form Submission
userForm.addEventListener("submit", function(event) {

    event.preventDefault();


    const nameInput =
        document.getElementById("username").value.trim();

    const ageInput =
        parseInt(
            document.getElementById("userage").value
        );


    storedUserName = nameInput;


    // Hide input area
    inputArea.classList.add("hidden");

    // Show loading indicator
    loadingModal.classList.remove("hidden");


    // Simulate loading delay
    setTimeout(function() {

        loadingModal.classList.add("hidden");


        // Display results
        greetingOutput.textContent =
            generateGreeting(storedUserName);

        ageStatusOutput.textContent =
            checkAgeCategory(ageInput);


        // Show result area
        resultArea.classList.remove("hidden");


    }, 1500);

});


// Handle "Open our letter" button
openLetterBtn.addEventListener("click", function() {

    personalSweetMessage.textContent =
        `We have a sweet message for you, ${storedUserName}! 
        Thank you for diving into the Saga Universe. 
        May your day be filled with joy, sweetness, 
        and fun victories! ✨`;


    letterModal.classList.remove("hidden");

});


// Handle "Back" button
backBtn.addEventListener("click", function() {

    resultArea.classList.add("hidden");

    inputArea.classList.remove("hidden");

    userForm.reset();

});


// Handle "Close Letter" button
closeLetterBtn.addEventListener("click", function() {

    letterModal.classList.add("hidden");

});


/* =====================================================
   ACTIVITY 2
===================================================== */


// Grab elements from the DOM

const registrationForm =
    document.getElementById("registrationForm");

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



/* =====================================================
   REGISTRATION FORM
===================================================== */


registrationForm.addEventListener(
    "submit",
    function(event) {


        // Prevent page refresh

        event.preventDefault();


        // Get input values

        const fullName =
            document
                .getElementById("fullName")
                .value
                .trim();


        const email =
            document
                .getElementById("email")
                .value
                .trim();


        const password =
            document
                .getElementById("password")
                .value
                .trim();



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

            message.className =
                "error";

            return;

        }



        // Check email

        if (
            !email.includes("@") ||
            !email.includes(".")
        ) {

            message.textContent =
                "Please enter a valid email address.";

            message.className =
                "error";

            return;

        }



        /* =========================
           SUCCESS
        ========================= */


        message.textContent =
            "Congratulations, Future PurMum/PurDad! 🎉";

        message.className =
            "success";



        /* =========================
           ACTIVITY INDICATOR
        ========================= */


        setTimeout(function() {


            registrationContainer.style.display =
                "none";


            loadingBox.style.display =
                "block";



            /* =========================
               SHOW PURBABY LIST
            ========================= */


            setTimeout(function() {


                loadingBox.style.display =
                    "none";


                adoptionContainer.style.display =
                    "block";


            }, 2000);


        }, 1000);

    }
);



/* =====================================================
   PET SELECTION
===================================================== */


petCards.forEach(function(card) {


    card.addEventListener(
        "click",
        function() {


            // Remove selected state from all pets

            petCards.forEach(function(item) {

                item.classList.remove("selected");

            });



            // Add selected state

            card.classList.add("selected");



            // Get selected pet name

            const petName =
                card.dataset.pet;



            // Display selected pet

            selectedPet.textContent =
                "You selected " +
                petName +
                "!";


        }
    );

    /* =========================
   ADOPT BUTTON
========================= */

const adoptButtons =
    document.querySelectorAll(".adopt-btn");

const adoptMessage =
    document.getElementById("adoptMessage");


adoptButtons.forEach(function(button) {

    button.addEventListener("click", function(event) {

        // Prevent the pet card from being selected
        event.stopPropagation();

              // Get the pet card where the button was clicked
        const petCard = button.closest(".pet-card");

        // Get the pet name
        const petName = petCard.dataset.pet;

        // Display the pet name
        adoptMessage.querySelector("h2").textContent =
            "You adopted " + petName + "! 🐾";

        // Show adoption message
        adoptMessage.style.display = "block";


    });

});

});