// Elements 
const icon = document.querySelector('.password-toggle');
const input = document.querySelector('input[type="password"]');

// State variable         
let showPassword = false;

icon.addEventListener('click', function() {

  // Toggle password visibility
  // Based on current state
  if (showPassword) {
    input.type = 'password';
    showPassword = false;
  }
  else {
    input.type = 'text';
    showPassword = true;  
  }

  // Toggle icon
  if(icon.classList.contains('fa-lock')) {
    icon.classList.replace('fa-lock', 'fa-lock-open');
  }
  else { 
     icon.classList.replace('fa-lock-open', 'fa-lock');
  }
  
});