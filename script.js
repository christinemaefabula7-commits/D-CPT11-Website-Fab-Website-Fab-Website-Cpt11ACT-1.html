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
const userForm = document.getElementById('user-form');
const inputArea = document.getElementById('input-area');
const resultArea = document.getElementById('result-area');
const loadingModal = document.getElementById('loading-modal');

const greetingOutput = document.getElementById('greeting-output');
const ageStatusOutput = document.getElementById('age-status-output');

const openLetterBtn = document.getElementById('open-letter-btn');
const backBtn = document.getElementById('back-btn'); // Back Button element
const letterModal = document.getElementById('letter-modal');
const closeLetterBtn = document.getElementById('close-letter-btn');
const personalSweetMessage = document.getElementById('personal-sweet-message');

let storedUserName = "";

// Handle Form Submission
userForm.addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent page reload

    const nameInput = document.getElementById('username').value.trim();
    const ageInput = parseInt(document.getElementById('userage').value);

    storedUserName = nameInput;

    // Hide input area and show loading indicator
    inputArea.classList.add('hidden');
    loadingModal.classList.remove('hidden');

    // Simulate loading delay (1.5 seconds)
    setTimeout(() => {
        loadingModal.classList.add('hidden');

        // Display results
        greetingOutput.textContent = generateGreeting(storedUserName);
        ageStatusOutput.textContent = checkAgeCategory(ageInput);

        // Show result area
        resultArea.classList.remove('hidden');
    }, 1500);
});

// Handle "Open our letter" button click
openLetterBtn.addEventListener('click', function() {
    personalSweetMessage.textContent = `We have a sweet message for you, ${storedUserName}! Thank you for diving into the Saga Universe. May your day be filled with joy, sweetness, and fun victories! ✨`;
    letterModal.classList.remove('hidden');
});

// Handle "Back" button click (Returns to the initial form screen)
backBtn.addEventListener('click', function() {
    resultArea.classList.add('hidden');
    inputArea.classList.remove('hidden');
    userForm.reset(); // Clear form inputs
});

// Handle "Play" button click inside the letter modal
closeLetterBtn.addEventListener('click', function() {
    letterModal.classList.add('hidden');
});