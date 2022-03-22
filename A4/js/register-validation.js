// Regex used
const REGEX = {
	EMAIL: /^\w+(\.\w+)?@(jediacademy\.edu|theforce\.org|dal\.ca)$/,
	NAME: /[A-Z]\w*/,
	PHONE: /^\+?(\d)[-\s]?\(?(\d{3})\)?[-\s]?(\d{7})/
}

// Add event listeners
// Email
let emailIn = document.getElementsByClassName('reg-email')[0];
emailIn.addEventListener('focusout', function() {
	if (REGEX.EMAIL.test(emailIn.value)) {
		emailIn.nextElementSibling.classList.add('d-none');
	} else {
		emailIn.nextElementSibling.classList.remove('d-none');
	}
});

// Names
let namesIn = document.getElementsByClassName('reg-name');
Array.from(namesIn).forEach(input => {
	input.addEventListener('focusout', function() {
		if (REGEX.NAME.test(input.value)) {
			input.nextElementSibling.classList.add('d-none');
		} else {
			input.nextElementSibling.classList.remove('d-none');
		}
	});
});

// Phone number
let phNumIn = document.getElementsByClassName('reg-ph-num')[0];
phNumIn.addEventListener('focusout', function() {
	if (REGEX.PHONE.test(phNumIn.value)) {
		phNumIn.nextElementSibling.classList.add('d-none');
	} else {
		phNumIn.nextElementSibling.classList.remove('d-none');
	}
});