let progressBar = document.querySelector(".view-mata");
let valueContainer = document.querySelector(".value-container");

let progressValue = 0;
let progressCurrentValue;
let progressEndValue = 100;

fetch('get-mata-pengguna.php')
    .then(response => response.json())
    .then(data => {
        console.log(data); 
        let userPoints = data.mata;
        updateProgressBar(userPoints);
    });

function updateProgressBar(points) {
    let progress = setInterval(() => {
        progressCurrentValue = points;
        progressValue++;

        valueContainer.textContent = `${progressValue} mata`;
    
        progressBar.style.background = `
        conic-gradient(
          #4d5bf9 ${progressValue / progressEndValue * 360}deg,
          #cadcff ${progressValue / progressEndValue * 360}deg
        )
      `;
    
        if (progressValue == progressCurrentValue) {
            clearInterval(progress);
        }
    })
}